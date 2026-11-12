@extends('admin.layout')
@section('title','Модели')
@section('content')
<div class="hrow"><div><h1>Модели и тарифы</h1><div class="muted">Цены в integer micro/minor units (input/output)</div></div></div>
<div class="card">
  <h2>Добавить модель</h2>
  <form method="post" action="{{ secure_url('/admin/models') }}" class="form-row">@csrf
    <div><label>Name</label><input name="name" required></div>
    <div><label>Slug</label><input name="slug" required placeholder="openai/gpt-4o-mini"></div>
    <div><label>Provider</label><input name="provider" required placeholder="openai"></div>
    <div><label>Context</label><input name="context_window" type="number" value="128000" required></div>
    <div><label>Input price</label><input name="input_price" type="number" value="0" required></div>
    <div><label>Output price</label><input name="output_price" type="number" value="0" required></div>
    <div style="grid-column:1/-1"><button class="btn primary" type="submit">Создать</button></div>
  </form>
</div>
<div class="card">
<table class="table">
<thead><tr><th>Name</th><th>Slug</th><th>Provider</th><th>In</th><th>Out</th><th>Ctx</th><th>Active</th><th></th></tr></thead>
<tbody>
@foreach($models as $m)
<tr>
<form method="post" action="{{ secure_url('/admin/models/'.$m->id) }}">@csrf @method('PATCH')
  <td>{{ $m->name }}</td>
  <td class="mono">{{ $m->slug }}</td>
  <td>{{ $m->provider }}</td>
  <td><input name="input_price" type="number" value="{{ $m->input_price }}" style="margin:0;width:100px"></td>
  <td><input name="output_price" type="number" value="{{ $m->output_price }}" style="margin:0;width:100px"></td>
  <td><input name="context_window" type="number" value="{{ $m->context_window }}" style="margin:0;width:100px"></td>
  <td><input type="checkbox" name="is_active" value="1" @checked($m->is_active)></td>
  <td><button class="btn primary" type="submit">Save</button></td>
</form>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection
