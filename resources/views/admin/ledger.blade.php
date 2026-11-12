@extends('admin.layout')
@section('title','Ledger')
@section('content')
<div class="hrow"><div><h1>Ledger</h1><div class="muted">Append-only движения баланса</div></div></div>
<div class="card">
<table class="table">
<thead><tr><th>ID</th><th>User</th><th>Type</th><th>Amount</th><th>Desc</th><th>Ref</th><th>When</th></tr></thead>
<tbody>
@foreach($entries as $e)
<tr>
  <td>{{ $e->id }}</td>
  <td><a href="{{ secure_url('/admin/users/'.$e->user_id) }}">#{{ $e->user_id }}</a></td>
  <td>{{ $e->type }}</td>
  <td>${{ number_format($e->amount/100,2) }}</td>
  <td>{{ $e->description }}</td>
  <td class="mono">{{ $e->reference }}</td>
  <td class="muted">{{ $e->created_at }}</td>
</tr>
@endforeach
</tbody>
</table>
<div class="pager">{{ $entries->links('pagination::simple-default') }}</div>
</div>
@endsection
