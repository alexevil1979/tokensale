@extends('admin.layout')
@section('title',$user->email)
@section('content')
<div class="hrow">
  <div>
    <h1>{{ $user->name }}</h1>
    <div class="muted">{{ $user->email }} · #{{ $user->id }}</div>
  </div>
  <div style="display:flex;gap:8px">
    <form method="post" action="{{ secure_url('/admin/users/'.$user->id.'/toggle-admin') }}">@csrf
      <button class="btn ghost" type="submit">{{ $user->is_admin ? 'Снять admin' : 'Сделать admin' }}</button>
    </form>
    <a class="btn ghost" href="{{ secure_url('/admin/users') }}">Назад</a>
  </div>
</div>
<div class="stats" style="grid-template-columns:repeat(3,1fr)">
  <div class="stat"><small>Баланс</small><strong class="acc">${{ number_format(($user->wallet->balance ?? 0)/100,2) }}</strong></div>
  <div class="stat"><small>API-ключей</small><strong>{{ $user->apiKeys->count() }}</strong></div>
  <div class="stat"><small>Роль</small><strong>{{ $user->is_admin ? 'admin' : 'user' }}</strong></div>
</div>
<div class="grid2">
  <div class="card">
    <h2>Корректировка баланса</h2>
    <form method="post" action="{{ secure_url('/admin/users/'.$user->id.'/adjust') }}">@csrf
      <label>Сумма в центах (отрицательная = списание)</label>
      <input name="amount_cents" type="number" required placeholder="1000 = $10.00">
      <label>Описание</label>
      <input name="description" required placeholder="Компенсация / бонус / корректировка">
      <button class="btn primary" type="submit">Применить</button>
    </form>
  </div>
  <div class="card">
    <h2>API-ключи</h2>
    <table class="table">
      <thead><tr><th>Имя</th><th>Prefix</th><th>RPM</th></tr></thead>
      <tbody>
      @forelse($user->apiKeys as $k)
        <tr><td>{{ $k->name }}</td><td class="mono">{{ $k->key_prefix }}••••</td><td>{{ $k->rate_limit_per_minute }}</td></tr>
      @empty
        <tr><td colspan="3" class="muted">Нет ключей</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
<div class="card">
  <h2>Ledger</h2>
  <table class="table">
    <thead><tr><th>Type</th><th>Amount</th><th>Desc</th><th>When</th></tr></thead>
    <tbody>
    @forelse($ledger as $e)
      <tr><td>{{ $e->type }}</td><td>${{ number_format($e->amount/100,2) }}</td><td>{{ $e->description }}</td><td class="muted">{{ $e->created_at }}</td></tr>
    @empty<tr><td colspan="4" class="muted">Пусто</td></tr>@endforelse
    </tbody>
  </table>
</div>
<div class="card">
  <h2>Платежи</h2>
  <table class="table">
    <thead><tr><th>ID</th><th>Gateway</th><th>Sum</th><th>Status</th></tr></thead>
    <tbody>
    @forelse($orders as $o)
      <tr><td>#{{ $o->id }}</td><td>{{ $o->gateway_code }}</td><td>${{ number_format($o->amount_cents/100,2) }}</td><td><span class="badge {{ $o->status }}">{{ $o->status }}</span></td></tr>
    @empty<tr><td colspan="4" class="muted">Нет платежей</td></tr>@endforelse
    </tbody>
  </table>
</div>
@endsection
