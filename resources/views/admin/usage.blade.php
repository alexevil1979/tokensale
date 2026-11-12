@extends('admin.layout')
@section('title','Usage')
@section('content')
<div class="hrow"><div><h1>Usage</h1><div class="muted">Запросы API</div></div></div>
<div class="stats" style="grid-template-columns:repeat(3,1fr)">
  <div class="stat"><small>Requests</small><strong>{{ number_format($agg->requests) }}</strong></div>
  <div class="stat"><small>Revenue</small><strong class="acc">${{ number_format($agg->revenue/100,2) }}</strong></div>
  <div class="stat"><small>Tokens</small><strong>{{ number_format($agg->tokens) }}</strong></div>
</div>
<div class="card">
<table class="table">
<thead><tr><th>ID</th><th>User</th><th>Model</th><th>Tokens</th><th>Cost</th><th>Status</th><th>Latency</th><th>When</th></tr></thead>
<tbody>
@foreach($usage as $e)
<tr>
  <td class="mono">{{ \Illuminate\Support\Str::limit($e->request_id,14,'') }}</td>
  <td><a href="{{ secure_url('/admin/users/'.$e->user_id) }}">#{{ $e->user_id }}</a></td>
  <td>{{ optional($e->model)->slug ?? $e->model_id }}</td>
  <td>{{ $e->prompt_tokens }}/{{ $e->completion_tokens }}</td>
  <td>${{ number_format($e->cost_cents/100,4) }}</td>
  <td>{{ $e->status }}</td>
  <td>{{ $e->latency_ms }}ms</td>
  <td class="muted">{{ $e->created_at }}</td>
</tr>
@endforeach
</tbody>
</table>
<div class="pager">{{ $usage->links('pagination::simple-default') }}</div>
</div>
@endsection
