@extends('admin.layout')
@section('title','Платёжные шлюзы')
@section('content')
<div class="hrow">
  <div>
    <h1>Платёжные шлюзы</h1>
    <div class="muted">Каталог из fullvpnservice · секреты только в config JSON · без коммита в git</div>
  </div>
</div>
@foreach($gateways->groupBy('group') as $group => $items)
<div class="card">
  <h2>{{ $groups[$group] ?? $group }}</h2>
  @foreach($items as $g)
  <details style="border:1px solid var(--line);border-radius:12px;padding:12px 14px;margin-bottom:10px;background:#100d0b">
    <summary style="cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:12px;list-style:none">
      <span><b>{{ $g->name }}</b> <span class="mono muted">{{ $g->code }}</span></span>
      <span>
        @if($g->enabled)<span class="badge on">enabled</span>@else<span class="badge off">disabled</span>@endif
        @if($g->test_mode)<span class="badge pending">test</span>@else<span class="badge paid">live</span>@endif
      </span>
    </summary>
    <form method="post" action="{{ secure_url('/admin/gateways/'.$g->id) }}" style="margin-top:14px">@csrf @method('PATCH')
      <div class="form-row">
        <div><label>Name</label><input name="name" value="{{ $g->name }}" required></div>
        <div><label>Min amount (cents)</label><input name="min_amount_cents" type="number" value="{{ $g->min_amount_cents }}" required></div>
        <div><label>Sort</label><input name="sort" type="number" value="{{ $g->sort }}" required></div>
        <div style="display:flex;gap:18px;align-items:end;padding-bottom:18px">
          <label style="display:flex;gap:8px;align-items:center;color:var(--txt)"><input type="checkbox" name="enabled" value="1" @checked($g->enabled) style="width:auto;margin:0"> Enabled</label>
          <label style="display:flex;gap:8px;align-items:center;color:var(--txt)"><input type="checkbox" name="test_mode" value="1" @checked($g->test_mode) style="width:auto;margin:0"> Test mode</label>
        </div>
      </div>
      <label>Config JSON (shop_id, secret_key, api_key, webhook_secret, merchant_id…)</label>
      <textarea name="config_json" rows="5" placeholder='{"shop_id":"…","secret_key":"…"}'>{{ json_encode($g->config ?: (object)[], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</textarea>
      <button class="btn primary" type="submit">Сохранить {{ $g->code }}</button>
    </form>
  </details>
  @endforeach
</div>
@endforeach
@endsection
