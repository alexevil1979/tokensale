@extends('admin.layout')
@section('title','Настройки')
@section('content')
<div class="hrow"><div><h1>Настройки</h1><div class="muted">Системные параметры TokenHub</div></div></div>
<div class="card" style="max-width:640px">
<form method="post" action="{{ secure_url('/admin/settings') }}">@csrf
  <label>Название сайта</label>
  <input name="site_name" value="{{ $settings['site_name'] }}" required>
  <label>Support email</label>
  <input name="support_email" type="email" value="{{ $settings['support_email'] }}" required>
  <label>Мин. пополнение (cents)</label>
  <input name="min_topup_cents" type="number" value="{{ $settings['min_topup_cents'] }}" required>
  <label style="display:flex;gap:8px;align-items:center;color:var(--txt);margin:8px 0 16px">
    <input type="checkbox" name="maintenance" value="1" @checked($settings['maintenance']) style="width:auto;margin:0"> Режим обслуживания
  </label>
  <button class="btn primary" type="submit">Сохранить</button>
</form>
</div>
@endsection
