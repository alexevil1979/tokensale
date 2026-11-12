<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>@yield('title','Админка') · TokenHub</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Unbounded:wght@600;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<style>
:root{--bg:#0b0907;--panel:#12100e;--card:rgba(23,18,15,.9);--line:#2a221c;--txt:#f5efe8;--muted:#9a8d82;--acc:#ff7a1a;--acc2:#ff9a4d;--ok:#7dcea0;--bad:#ffb4a6}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--txt);font:14px Inter,system-ui,sans-serif;min-height:100vh}
body::before{content:"";position:fixed;inset:0;z-index:0;pointer-events:none;background:
 radial-gradient(circle at 14% 20%,rgba(255,140,40,.18) 0 2px,transparent 3px),
 radial-gradient(circle at 78% 70%,rgba(255,160,50,.14) 0 3px,transparent 5px),
 radial-gradient(900px 500px at 15% 5%,#3a220f 0%,transparent 55%),
 radial-gradient(700px 400px at 90% 90%,#2a1608 0%,transparent 50%),var(--bg)}
a{color:inherit;text-decoration:none}
.top,.shell{position:relative;z-index:1}
.top{height:64px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 22px;position:sticky;top:0;background:rgba(11,9,7,.9);backdrop-filter:blur(12px);z-index:30}
.brand{display:flex;align-items:center;gap:10px;font-family:Unbounded,sans-serif;font-weight:800}
.mark{width:30px;height:30px;border-radius:8px;background:var(--acc);color:#0b0907;display:grid;place-items:center}
.pill{border:1px solid var(--line);border-radius:999px;padding:7px 12px;color:var(--muted);font-size:12px;background:rgba(26,21,18,.7)}
.pill b{color:var(--acc)}
.shell{display:grid;grid-template-columns:250px 1fr;min-height:calc(100vh - 64px)}
.side{border-right:1px solid var(--line);padding:16px 12px 28px;background:rgba(18,16,14,.78);position:sticky;top:64px;height:calc(100vh - 64px);overflow:auto;backdrop-filter:blur(8px)}
.side .grp{color:var(--muted);font-size:11px;text-transform:uppercase;letter-spacing:.08em;padding:14px 10px 8px}
.side a{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;color:var(--muted);margin-bottom:2px}
.side a:hover{background:#221b16;color:var(--txt)}
.side a.active{color:var(--acc);border:1px solid #3a2a1c;background:#1a1512}
.main{padding:22px 24px 40px}
.hrow{display:flex;justify-content:space-between;gap:16px;align-items:end;margin-bottom:16px;flex-wrap:wrap}
h1{font-family:Unbounded,sans-serif;font-size:28px;margin:0}
.muted{color:var(--muted)}
.btn{border:0;border-radius:10px;padding:9px 14px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px}
.primary{background:var(--acc);color:#0b0907}
.ghost{background:transparent;color:var(--txt);border:1px solid var(--line)}
.danger{background:#3a1510;color:var(--bad);border:1px solid #5a2a22}
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin:14px 0 18px}
.stat{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:14px}
.stat small{display:block;color:var(--muted);margin-bottom:8px}
.stat strong{font-size:20px}
.stat strong.acc{color:var(--acc)}
.card{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:16px;margin-bottom:14px}
.card h2{margin:0 0 12px;font-size:16px}
.grid2{display:grid;grid-template-columns:1.2fr .8fr;gap:14px}
.table{width:100%;border-collapse:collapse}
.table th,.table td{text-align:left;padding:10px 8px;border-bottom:1px solid var(--line);font-size:13px;vertical-align:middle}
.table th{color:var(--muted);font-size:11px;text-transform:uppercase}
.mono{font-family:"JetBrains Mono",ui-monospace,monospace;font-size:12px}
.badge{display:inline-flex;padding:3px 8px;border-radius:999px;font-size:11px;border:1px solid var(--line)}
.badge.on{color:var(--ok);border-color:#2a4a34;background:#142018}
.badge.off{color:var(--muted)}
.badge.paid{color:var(--ok);border-color:#2a4a34}
.badge.pending{color:var(--acc);border-color:#4a2e14}
.badge.failed{color:var(--bad);border-color:#5a2a22}
.alert{background:#1f2a18;color:#c6f6c2;border-radius:10px;padding:12px;margin-bottom:14px}
.err{background:#3a1510;color:var(--bad)}
input,select,textarea{width:100%;background:#100d0b;border:1px solid var(--line);border-radius:10px;padding:10px 12px;color:var(--txt);margin:6px 0 12px}
label{display:block;color:var(--muted);font-size:12px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.chart{display:flex;align-items:end;gap:6px;height:140px}
.chart span{flex:1;background:#2a2018;border-radius:6px 6px 2px 2px;min-height:4px;position:relative}
.chart span i{position:absolute;left:0;right:0;bottom:0;background:linear-gradient(180deg,var(--acc),#7a3d10);border-radius:6px 6px 2px 2px}
.search{display:flex;gap:8px;align-items:center;margin-bottom:12px}
.search input{margin:0;max-width:320px}
.pager{display:flex;gap:8px;margin-top:12px}
.pager a,.pager span{padding:6px 10px;border:1px solid var(--line);border-radius:8px}
@media(max-width:980px){.shell{grid-template-columns:1fr}.side{position:relative;top:0;height:auto}.stats,.grid2,.form-row{grid-template-columns:1fr}}
</style>
</head>
<body>
@php
  $nav = request()->route()?->getName() ?? '';
  $is = fn(...$names) => collect($names)->contains(fn($n) => str_starts_with($nav, $n));
@endphp
<header class="top">
  <a class="brand" href="{{ secure_url('/admin') }}"><span class="mark">T</span>TokenHub Admin</a>
  <div style="display:flex;gap:10px;align-items:center">
    <a class="pill" href="{{ secure_url('/cabinet') }}" target="_blank">Кабинет</a>
    <span class="pill">{{ auth()->user()->email }}</span>
    <form method="post" action="{{ secure_url('/admin/logout') }}">@csrf<button class="btn ghost" type="submit">Выйти</button></form>
  </div>
</header>
<div class="shell">
  <aside class="side">
    <div class="grp">Обзор</div>
    <a class="{{ $is('admin.index') ? 'active' : '' }}" href="{{ secure_url('/admin') }}">Dashboard</a>

    <div class="grp">Пользователи</div>
    <a class="{{ $is('admin.users') ? 'active' : '' }}" href="{{ secure_url('/admin/users') }}">Пользователи</a>
    <a class="{{ $is('admin.keys') ? 'active' : '' }}" href="{{ secure_url('/admin/keys') }}">API-ключи</a>

    <div class="grp">Каталог</div>
    <a class="{{ $is('admin.models') ? 'active' : '' }}" href="{{ secure_url('/admin/models') }}">Модели и тарифы</a>

    <div class="grp">Биллинг</div>
    <a class="{{ $is('admin.payments') ? 'active' : '' }}" href="{{ secure_url('/admin/payments') }}">Платежи</a>
    <a class="{{ $is('admin.gateways') ? 'active' : '' }}" href="{{ secure_url('/admin/gateways') }}">Платёжные шлюзы</a>
    <a class="{{ $is('admin.ledger') ? 'active' : '' }}" href="{{ secure_url('/admin/ledger') }}">Ledger</a>
    <a class="{{ $is('admin.webhooks') ? 'active' : '' }}" href="{{ secure_url('/admin/webhooks') }}">Webhooks</a>

    <div class="grp">Аналитика</div>
    <a class="{{ $is('admin.usage') ? 'active' : '' }}" href="{{ secure_url('/admin/usage') }}">Usage</a>

    <div class="grp">Система</div>
    <a class="{{ $is('admin.settings') ? 'active' : '' }}" href="{{ secure_url('/admin/settings') }}">Настройки</a>
  </aside>
  <main class="main">
    @if(session('status'))<div class="alert">{{ session('status') }}</div>@endif
    @if(session('error'))<div class="alert err">{{ session('error') }}</div>@endif
    @yield('content')
  </main>
</div>
</body>
</html>
