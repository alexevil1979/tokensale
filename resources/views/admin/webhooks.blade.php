@extends('admin.layout')
@section('title','Webhooks')
@section('content')
<div class="hrow"><div><h1>Payment webhooks</h1><div class="muted">Идемпотентные события шлюзов</div></div></div>
<div class="card">
<table class="table">
<thead><tr><th>ID</th><th>Provider</th><th>Event</th><th>Status</th><th>Error</th><th>When</th></tr></thead>
<tbody>
@forelse($webhooks as $w)
<tr>
  <td>{{ $w->id }}</td>
  <td>{{ $w->provider }}</td>
  <td class="mono">{{ $w->event_id }}</td>
  <td><span class="badge {{ $w->status==='processed'?'paid':($w->status==='failed'?'failed':'pending') }}">{{ $w->status }}</span></td>
  <td class="muted">{{ \Illuminate\Support\Str::limit($w->error,60) }}</td>
  <td class="muted">{{ $w->created_at }}</td>
</tr>
@empty
<tr><td colspan="6" class="muted">Webhook-событий пока нет</td></tr>
@endforelse
</tbody>
</table>
<div class="pager">{{ $webhooks->links('pagination::simple-default') }}</div>
</div>
@endsection
