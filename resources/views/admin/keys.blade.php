@extends('admin.layout')
@section('title','API-ключи')
@section('content')
<div class="hrow"><div><h1>API-ключи</h1><div class="muted">Все ключи платформы</div></div></div>
<form class="search" method="get"><input name="q" value="{{ $q }}" placeholder="name / prefix"><button class="btn primary">Найти</button></form>
<div class="card">
<table class="table">
<thead><tr><th>ID</th><th>User</th><th>Name</th><th>Prefix</th><th>RPM</th><th>Last used</th><th></th></tr></thead>
<tbody>
@foreach($keys as $k)
<tr>
  <td>{{ $k->id }}</td>
  <td><a href="{{ secure_url('/admin/users/'.$k->user_id) }}">{{ $k->user->email ?? $k->user_id }}</a></td>
  <td>{{ $k->name }}</td>
  <td class="mono">{{ $k->key_prefix }}••••</td>
  <td>{{ $k->rate_limit_per_minute }}</td>
  <td class="muted">{{ $k->last_used_at?->diffForHumans() ?? '—' }}</td>
  <td>
    <form method="post" action="{{ secure_url('/admin/keys/'.$k->id) }}" onsubmit="return confirm('Удалить ключ?')">@csrf @method('DELETE')
      <button class="btn danger" type="submit">Удалить</button>
    </form>
  </td>
</tr>
@endforeach
</tbody>
</table>
<div class="pager">{{ $keys->withQueryString()->links('pagination::simple-default') }}</div>
</div>
@endsection
