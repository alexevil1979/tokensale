<?php
namespace App\Http\Controllers;

use App\Models\AiModel;
use App\Models\ApiKey;
use App\Models\LedgerEntry;
use App\Models\UsageEvent;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CabinetController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('cabinet');
        }
        return view('cabinet.login');
    }

    public function authenticate(Request $r)
    {
        $data = $r->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (! Auth::attempt($data, $r->boolean('remember'))) {
            return back()->withErrors(['email' => 'Неверный email или пароль.'])->onlyInput('email');
        }
        $r->session()->regenerate();
        $r->session()->forget(['cabinet_key_id', 'cabinet_raw_key']);
        return redirect()->intended(route('cabinet'));
    }

    public function loginByKey(Request $r)
    {
        $data = $r->validate(['key' => 'required|string|min:10']);
        $raw = preg_replace('/^Bearer\s+/i', '', trim($data['key']));
        $record = ApiKey::where('key_hash', hash('sha256', $raw))->first();
        if (! $record) {
            return back()->withErrors(['key' => 'API-ключ не найден.'])->withInput();
        }
        Auth::login($record->user);
        $r->session()->regenerate();
        $r->session()->put('cabinet_key_id', $record->id);
        $r->session()->put('cabinet_raw_key', $raw);
        return redirect()->route('cabinet');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('cabinet.login');
    }

    public function index()
    {
        $u = Auth::user();
        $wallet = Wallet::firstOrCreate(['user_id' => $u->id], ['balance' => 0]);
        $keys = $u->apiKeys()->latest()->get();
        $models = AiModel::where('is_active', true)->orderBy('name')->get();
        $usageQ = UsageEvent::where('user_id', $u->id);
        $requests = (clone $usageQ)->count();
        $requests24 = (clone $usageQ)->where('created_at', '>=', now()->subDay())->count();
        $spent = (int) (clone $usageQ)->sum('cost_cents');
        $tokens = (int) (clone $usageQ)->sum('total_tokens');
        $byModelRaw = UsageEvent::query()
            ->select('model_id', DB::raw('COUNT(*) as requests'), DB::raw('COALESCE(SUM(total_tokens),0) as tokens'), DB::raw('COALESCE(SUM(cost_cents),0) as spend'))
            ->where('user_id', $u->id)
            ->groupBy('model_id')
            ->get();
        $modelMap = $models->keyBy('id');
        $byModel = $byModelRaw->map(function ($row) use ($modelMap) {
            $row->model_name = optional($modelMap->get($row->model_id))->name ?? ('#'.$row->model_id);
            return $row;
        });
        $recent = UsageEvent::where('user_id', $u->id)->latest()->limit(20)->get();
        $chart = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = now()->subDays($i)->startOfDay();
            $chart[] = [
                'label' => $day->format('d.m'),
                'tokens' => (int) UsageEvent::where('user_id', $u->id)->whereDate('created_at', $day)->sum('total_tokens'),
                'spend' => (int) UsageEvent::where('user_id', $u->id)->whereDate('created_at', $day)->sum('cost_cents'),
            ];
        }
        $entries = LedgerEntry::where('user_id', $u->id)->latest()->limit(12)->get();
        $activeKey = null;
        if ($kid = session('cabinet_key_id')) {
            $activeKey = $keys->firstWhere('id', $kid);
        }
        if (! $activeKey) {
            $activeKey = $keys->first();
        }
        $totalTopups = (int) LedgerEntry::where('user_id', $u->id)->where('type', 'credit')->sum('amount');
        $base = max($totalTopups, $wallet->balance + $spent, 1);
        $remainPct = (int) max(0, min(100, round(($wallet->balance / $base) * 100)));
        $packName = $activeKey
            ? ($activeKey->name !== 'default' ? $activeKey->name : ($activeKey->key_prefix.'…'))
            : $u->email;
        $sessionKey = session('cabinet_raw_key');
        $baseUrl = rtrim(config('app.url'), '/').'/api/v1';

        return view('cabinet.index', compact(
            'u', 'wallet', 'keys', 'models', 'requests', 'requests24', 'spent', 'tokens',
            'byModel', 'recent', 'chart', 'entries', 'activeKey', 'totalTopups', 'remainPct',
            'packName', 'sessionKey', 'baseUrl'
        ));
    }

    public function createKey(Request $r)
    {
        $r->validate(['name' => 'required|string|max:60']);
        $raw = 'tk_live_'.Str::random(32);
        ApiKey::create([
            'user_id' => Auth::id(),
            'name' => $r->name,
            'key_prefix' => substr($raw, 0, 16),
            'key_hash' => hash('sha256', $raw),
            'rate_limit_per_minute' => 60,
        ]);
        return back()->with('new_key', $raw)->with('status', 'Ключ создан. Сохраните его сейчас.');
    }

    public function deleteKey(ApiKey $key)
    {
        abort_unless($key->user_id === Auth::id(), 403);
        $key->delete();
        return back()->with('status', 'Ключ удалён.');
    }

    public function topup()
    {
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0]);
        $amount = 1000;
        $wallet->increment('balance', $amount);
        LedgerEntry::create([
            'user_id' => Auth::id(),
            'type' => 'credit',
            'amount' => $amount,
            'description' => 'Демо-пополнение',
        ]);
        return back()->with('status', 'На баланс добавлено $10.00 (demo).');
    }
}
