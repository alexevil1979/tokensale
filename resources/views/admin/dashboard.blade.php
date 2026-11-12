@extends('admin.layout')
@section('title','Dashboard')
@section('content')
<div class="hrow">
  <div><h1>Dashboard</h1><div class="muted">Операционный обзор TokenHub</div></div>
</div>
<div class="stats">
  <div class="stat"><small>Пользователи</small><strong>{{ $stats['users'] }}</strong><div class="muted">+{{ $stats['users_today'] }} сегодня</div></div>
  <div class="stat"><small>Балансы</small><strong class="acc">${{ number_format($stats['balance']/100,2) }}</strong></div>
  <div class="stat"><small>Выручка usage</small><strong>${{ number_format($stats['revenue']/100,2) }}</strong><div class="muted">${{ number_format($stats['revenue_today']/100,2) }} сегодня</div></div>
  <div class="stat"><small>Запросы</small><strong>{{ number_format($stats['requests']) }}</strong><div class="muted">{{ $stats['requests_today'] }} сегодня</div></div>
  <div class="stat"><small>Токены</small><strong>{{ number_format($stats['tokens']) }}</strong></div>
  <div class="stat"><small>API-ключи</small><strong>{{ $stats['keys'] }}</strong></div>
  <div class="stat"><small>Активные модели</small><strong>{{ $stats['models'] }}</strong></div>
  <div class="stat"><small>Шлюзы / платежи</small><strong>{{ $stats['gateways_on'] }} on</strong><div class="muted">{{ $stats['orders_paid'] }} paid · {{ $stats['orders_pending'] }} pending</div></div>
</div>
<div class="grid2">
  <div class="card">
    <h2>Выручка · 14 дней</h2>
    @php $max = max(1, collect($chart)->max('revenue')); @endphp
    <div class="chart">
      @foreach($chart as $c)
        <span title="{{ $c['label'] }}: ${{ number_format($c['revenue']/100,2) }}"><i style="height:{{ max(4,(int)round(($c['revenue']/$max)*100)) }}%"></i></span>
      @endforeach
    </div>
  </div>
  <div class="card">
    <h2>Последние платежи</h2>
    <table class="table">
      <thead><tr><th>ID</th><th>User</th><th>Sum</th><th>Status</th></tr></thead>
      <tbody>
      @forelse($recentOrders as $o)
        <tr>
          <td>#{{ $o->id }}</td>
          <td>{{ $o->user->email ?? '—' }}</td>
          <td>${{ number_format($o->amount_cents/100,2) }}</td>
          <td><span class="badge {{ $o->status }}">{{ $o->status }}</span></td>
        </tr>
      @empty
        <tr><td colspan="4" class="muted">Пока нет заказов</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
<div class="grid2">
  <div class="card">
    <h2>Новые пользователи</h2>
    <table class="table">
      <thead><tr><th>Email</th><th>Когда</th></tr></thead>
      <tbody>
      @foreach($recentUsers as $u)
        <tr><td><a href="{{ secure_url('/admin/users/'.$u->id) }}">{{ $u->email }}</a></td><td class="muted">{{ $u->created_at }}</td></tr>
      @endforeach
      </tbody>
    </table>
  </div>
  <div class="card">
    <h2>Последний usage</h2>
    <table class="table">
      <thead><tr><th>Req</th><th>Cost</th><th>When</th></tr></thead>
      <tbody>
      @forelse($recentUsage as $e)
        <tr>
          <td class="mono">{{ \Illuminate\Support\Str::limit($e->request_id,16,'') }}</td>
          <td>${{ number_format($e->cost_cents/100,4) }}</td>
          <td class="muted">{{ $e->created_at->diffForHumans() }}</td>
        </tr>
      @empty
        <tr><td colspan="3" class="muted">Пусто</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
