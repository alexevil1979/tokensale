<?php
namespace App\Http\Controllers;

use App\Models\AiModel;
use App\Models\ApiKey;
use App\Models\LedgerEntry;
use App\Models\PaymentGateway;
use App\Models\PaymentOrder;
use App\Models\PaymentWebhook;
use App\Models\SystemSetting;
use App\Models\UsageEvent;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();
        $stats = [
            'users' => User::count(),
            'users_today' => User::where('created_at', '>=', $today)->count(),
            'balance' => (int) Wallet::sum('balance'),
            'revenue' => (int) UsageEvent::sum('cost_cents'),
            'revenue_today' => (int) UsageEvent::where('created_at', '>=', $today)->sum('cost_cents'),
            'requests' => UsageEvent::count(),
            'requests_today' => UsageEvent::where('created_at', '>=', $today)->count(),
            'tokens' => (int) UsageEvent::sum('total_tokens'),
            'keys' => ApiKey::count(),
            'models' => AiModel::where('is_active', true)->count(),
            'orders_paid' => PaymentOrder::where('status', 'paid')->count(),
            'orders_pending' => PaymentOrder::where('status', 'pending')->count(),
            'gateways_on' => PaymentGateway::where('enabled', true)->count(),
        ];
        $chart = [];
        for ($i = 13; $i >= 0; $i--) {
            $d = now()->subDays($i)->startOfDay();
            $chart[] = [
                'label' => $d->format('d.m'),
                'revenue' => (int) UsageEvent::whereDate('created_at', $d)->sum('cost_cents'),
                'requests' => UsageEvent::whereDate('created_at', $d)->count(),
            ];
        }
        $recentUsers = User::latest()->limit(8)->get();
        $recentUsage = UsageEvent::latest()->limit(10)->get();
        $recentOrders = PaymentOrder::with('user')->latest()->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'chart', 'recentUsers', 'recentUsage', 'recentOrders'));
    }

    public function users(Request $r)
    {
        $q = trim((string) $r->get('q', ''));
        $users = User::query()
            ->when($q !== '', fn ($b) => $b->where('email', 'like', "%$q%")->orWhere('name', 'like', "%$q%"))
            ->with('wallet')
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.users', compact('users', 'q'));
    }

    public function userShow(User $user)
    {
        $user->load('wallet', 'apiKeys');
        $ledger = LedgerEntry::where('user_id', $user->id)->latest()->limit(30)->get();
        $usage = UsageEvent::where('user_id', $user->id)->latest()->limit(20)->get();
        $orders = PaymentOrder::where('user_id', $user->id)->latest()->limit(20)->get();

        return view('admin.user', compact('user', 'ledger', 'usage', 'orders'));
    }

    public function userToggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Нельзя снять админ-права с себя.');
        }
        $user->update(['is_admin' => ! $user->is_admin]);
        return back()->with('status', 'Роль обновлена.');
    }

    public function userAdjust(Request $r, User $user)
    {
        $data = $r->validate([
            'amount_cents' => 'required|integer',
            'description' => 'required|string|max:200',
        ]);
        $amount = (int) $data['amount_cents'];
        if ($amount === 0) {
            return back()->with('error', 'Сумма не может быть 0.');
        }
        try {
            DB::transaction(function () use ($user, $amount, $data) {
                $wallet = Wallet::firstOrCreate(['user_id' => $user->id], ['balance' => 0]);
                $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
                $new = $wallet->balance + $amount;
                if ($new < 0) {
                    throw new \RuntimeException('Недостаточно средств для списания.');
                }
                $wallet->update(['balance' => $new]);
                LedgerEntry::create([
                    'user_id' => $user->id,
                    'type' => $amount > 0 ? 'credit' : 'debit',
                    'amount' => abs($amount),
                    'description' => '[admin] '.$data['description'],
                    'reference' => 'adj_'.Str::uuid(),
                ]);
            });
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('status', 'Баланс скорректирован.');
    }

    public function keys(Request $r)
    {
        $q = trim((string) $r->get('q', ''));
        $keys = ApiKey::query()
            ->with('user')
            ->when($q !== '', fn ($b) => $b->where('name', 'like', "%$q%")->orWhere('key_prefix', 'like', "%$q%"))
            ->latest()
            ->paginate(40)
            ->withQueryString();

        return view('admin.keys', compact('keys', 'q'));
    }

    public function keyDelete(ApiKey $key)
    {
        $key->delete();
        return back()->with('status', 'Ключ удалён.');
    }

    public function models()
    {
        $models = AiModel::orderBy('name')->get();
        return view('admin.models', compact('models'));
    }

    public function updateModel(Request $r, AiModel $model)
    {
        $data = $r->validate([
            'input_price' => 'required|integer|min:0',
            'output_price' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'context_window' => 'nullable|integer|min:1',
        ]);
        $data['is_active'] = $r->boolean('is_active');
        $model->update($data);
        return back()->with('status', 'Модель обновлена.');
    }

    public function createModel(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|max:80',
            'slug' => 'required|max:120|unique:ai_models,slug',
            'provider' => 'required|max:80',
            'input_price' => 'required|integer|min:0',
            'output_price' => 'required|integer|min:0',
            'context_window' => 'required|integer|min:1',
        ]);
        $data['is_active'] = true;
        AiModel::create($data);
        return back()->with('status', 'Модель добавлена.');
    }

    public function usage(Request $r)
    {
        $usage = UsageEvent::query()->with('model')->latest()->paginate(50);
        $agg = UsageEvent::query()->selectRaw('COUNT(*) as requests, COALESCE(SUM(cost_cents),0) as revenue, COALESCE(SUM(total_tokens),0) as tokens')->first();
        return view('admin.usage', compact('usage', 'agg'));
    }

    public function ledger()
    {
        $entries = LedgerEntry::query()->latest()->paginate(50);
        return view('admin.ledger', compact('entries'));
    }

    public function payments(Request $r)
    {
        $status = $r->get('status');
        $orders = PaymentOrder::query()
            ->with('user')
            ->when($status, fn ($b) => $b->where('status', $status))
            ->latest()
            ->paginate(40)
            ->withQueryString();
        return view('admin.payments', compact('orders', 'status'));
    }

    public function paymentMarkPaid(PaymentOrder $order)
    {
        if ($order->status === 'paid') {
            return back()->with('status', 'Уже оплачен.');
        }
        DB::transaction(function () use ($order) {
            $order = PaymentOrder::where('id', $order->id)->lockForUpdate()->first();
            if ($order->status === 'paid') {
                return;
            }
            $wallet = Wallet::firstOrCreate(['user_id' => $order->user_id], ['balance' => 0]);
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            $wallet->increment('balance', $order->amount_cents);
            LedgerEntry::create([
                'user_id' => $order->user_id,
                'type' => 'credit',
                'amount' => $order->amount_cents,
                'description' => 'Оплата '.$order->gateway_code.' #'.$order->id,
                'reference' => 'pay_'.$order->id,
            ]);
            $order->update(['status' => 'paid', 'paid_at' => now()]);
        });
        return back()->with('status', 'Платёж зачислен.');
    }

    public function gateways()
    {
        $this->ensureGatewaysSeeded();
        $gateways = PaymentGateway::orderBy('sort')->orderBy('name')->get();
        $groups = config('payments.groups', []);
        return view('admin.gateways', compact('gateways', 'groups'));
    }

    public function gatewayUpdate(Request $r, PaymentGateway $gateway)
    {
        $data = $r->validate([
            'name' => 'required|string|max:120',
            'enabled' => 'nullable|boolean',
            'test_mode' => 'nullable|boolean',
            'min_amount_cents' => 'required|integer|min:0',
            'sort' => 'required|integer|min:0',
            'config_json' => 'nullable|string',
        ]);
        $config = [];
        if (trim((string) ($data['config_json'] ?? '')) !== '') {
            $decoded = json_decode($data['config_json'], true);
            if (! is_array($decoded)) {
                return back()->with('error', 'config JSON невалиден.')->withInput();
            }
            $config = $decoded;
        }
        $gateway->update([
            'name' => $data['name'],
            'enabled' => $r->boolean('enabled'),
            'test_mode' => $r->boolean('test_mode'),
            'min_amount_cents' => (int) $data['min_amount_cents'],
            'sort' => (int) $data['sort'],
            'config' => $config,
        ]);
        return back()->with('status', 'Шлюз «'.$gateway->code.'» сохранён.');
    }

    public function webhooks()
    {
        $webhooks = PaymentWebhook::query()->latest()->paginate(40);
        return view('admin.webhooks', compact('webhooks'));
    }

    public function settings()
    {
        $settings = [
            'site_name' => SystemSetting::getValue('site_name', 'TokenHub'),
            'support_email' => SystemSetting::getValue('support_email', 'support@tokensale.linkus1.online'),
            'min_topup_cents' => (int) SystemSetting::getValue('min_topup_cents', 500),
            'maintenance' => (bool) SystemSetting::getValue('maintenance', false),
        ];
        return view('admin.settings', compact('settings'));
    }

    public function settingsSave(Request $r)
    {
        $data = $r->validate([
            'site_name' => 'required|string|max:80',
            'support_email' => 'required|email',
            'min_topup_cents' => 'required|integer|min:0',
            'maintenance' => 'nullable|boolean',
        ]);
        SystemSetting::putValue('site_name', $data['site_name']);
        SystemSetting::putValue('support_email', $data['support_email']);
        SystemSetting::putValue('min_topup_cents', (int) $data['min_topup_cents']);
        SystemSetting::putValue('maintenance', $r->boolean('maintenance'));
        return back()->with('status', 'Настройки сохранены.');
    }

    protected function ensureGatewaysSeeded(): void
    {
        $catalog = config('payments.catalog', []);
        $sort = 10;
        foreach ($catalog as $code => $meta) {
            PaymentGateway::firstOrCreate(
                ['code' => $code],
                [
                    'name' => $meta['name'],
                    'group' => $meta['group'] ?? 'aggregators',
                    'enabled' => false,
                    'test_mode' => true,
                    'min_amount_cents' => 100,
                    'sort' => $sort,
                    'config' => [],
                ]
            );
            $sort += 10;
        }
    }
}
