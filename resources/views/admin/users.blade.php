@extends('admin.layout')
@section('title','Пользователи')
@section('content')
<div class="hrow"><div><h1>Пользователи</h1><div class="muted">Аккаунты, балансы, роли</div></div></div>
<form class="search" method="get">
  <input name="q" value="{{ $q }}" placeholder="email или имя">
  <button class="btn primary" type="submit">Найти</button>
</form>
<div class="card">
<table class="table">
  <thead><tr><th>ID</th><th>Email</th><th>Имя</th><th>Баланс</th><th>Admin</th><th>Создан</th></tr></thead>
  <tbody>
  @foreach($users as $u)
    <tr>
      <td>{{ $u->id }}</td>
      <td><a href="{{ secure_url('/admin/users/'.$u->id) }}">{{ $u->email }}</a></td>
      <td>{{ $u->name }}</td>
      <td class="acc" style="color:var(--acc)">${{ number_format(($u->wallet->balance ?? 0)/100,2) }}</td>
      <td>@if($u->is_admin)<span class="badge on">admin</span>@else<span class="badge off">user</span>@endif</td>
      <td class="muted">{{ $u->created_at }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
<div class="pager">{{ $users->links('pagination::simple-default') }}</div>
</div>
@endsection
