@extends('admin.layout')
@section('title','Платежи')
@section('content')
<div class="hrow">
  <div><h1>Платежи</h1><div class="muted">Заказы на пополнение</div></div>
  <div style="display:flex;gap:8px">
    <a class="btn {{ !$status?'primary':'ghost' }}" href="{{ secure_url('/admin/payments') }}">Все</a>
    <a class="btn {{ $status==='pending'?'primary':'ghost' }}" href="{{ secure_url('/admin/payments?status=pending') }}">Pending</a>
    <a class="btn {{ $status==='paid'?'primary':'ghost' }}" href="{{ secure_url('/admin/payments?status=paid') }}">Paid</a>
    <a class="btn {{ $status==='failed'?'primary':'ghost' }}" href="{{ secure_url('/admin/payments?status=failed') }}">Failed</a>
  </div>
</div>
<div class="card">
<table class="table">
<thead><tr><th>ID</th><th>User</th><th>Gateway</th><th>Sum</th><th>Status</th><th>External</th><th>When</th><th></th></tr></thead>
<tbody>
@forelse($orders as $o)
<tr>
  <td>#{{ $o->id }}</td>
  <td><a href="{{ secure_url('/admin/users/'.$o->user_id) }}">{{ $o->user->email ?? $o->user_id }}</a></td>
  <td>{{ $o->gateway_code }}</td>
  <td>${{ number_format($o->amount_cents/100,2) }} {{ $o->currency }}</td>
  <td><span class="badge {{ $o->status }}">{{ $o->status }}</span></td>
  <td class="mono">{{ $o->external_id }}</td>
  <td class="muted">{{ $o->created_at }}</td>
  <td>
    @if($o->status!=='paid')
    <form method="post" action="{{ secure_url('/admin/payments/'.$o->id.'/mark-paid') }}" onsubmit="return confirm('Зачислить вручную?')">@csrf
      <button class="btn primary" type="submit">Mark paid</button>
    </form>
    @endif
  </td>
</tr>
@empty
<tr><td colspan="8" class="muted">Платежей пока нет. Шлюзы настраиваются в разделе «Платёжные шлюзы».</td></tr>
@endforelse
</tbody>
</table>
<div class="pager">{{ $orders->links('pagination::simple-default') }}</div>
</div>
@endsection
