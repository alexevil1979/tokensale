<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TokenHub Admin</title>
<style>
:root{--b:#1d4ed8;--i:#0f172a;--m:#64748b;--l:#e2e8f0}
*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;background:linear-gradient(160deg,#0b1220,#1e293b 55%,#0f172a);font:14px system-ui,sans-serif;color:var(--i)}
.card{width:min(420px,calc(100% - 32px));background:#fff;border-radius:14px;padding:32px;box-shadow:0 24px 60px rgba(0,0,0,.35)}
.brand{display:flex;align-items:center;gap:10px;font-weight:800;font-size:18px;margin-bottom:18px}
.mark{width:32px;height:32px;border-radius:8px;background:var(--b);color:#fff;display:grid;place-items:center}
h1{margin:0 0 6px;font-size:26px}p{margin:0 0 18px;color:var(--m)}
label{display:block;font-size:12px;font-weight:700;color:#475569;margin:0 0 6px}
input{width:100%;border:1px solid #cbd5e1;border-radius:8px;padding:12px;margin-bottom:14px;font-size:14px}
button{width:100%;border:0;border-radius:8px;padding:12px;background:var(--b);color:#fff;font-weight:700;cursor:pointer}
.err{background:#fff1f2;color:#be123c;border-radius:8px;padding:10px 12px;margin-bottom:14px}
.hint{margin-top:14px;font-size:12px;color:var(--m);text-align:center}
a{color:var(--b);text-decoration:none}
</style>
</head>
<body>
<form class="card" method="post" action="{{ url('/admin/login') }}">
@csrf
<div class="brand"><span class="mark">T</span> TokenHub Admin</div>
<h1>Вход в админку</h1>
<p>Управление тарифами, моделями и статистикой.</p>
@if($errors->any())<div class="err">{{ $errors->first() }}</div>@endif
<label>Email</label>
<input type="email" name="email" value="{{ old('email') }}" required autofocus>
<label>Пароль</label>
<input type="password" name="password" required>
<label style="display:flex;align-items:center;gap:8px;font-weight:500;margin-bottom:14px"><input type="checkbox" name="remember" value="1" style="width:auto;margin:0"> Запомнить</label>
<button type="submit">Войти в админку</button>
<div class="hint"><a href="{{ url('/') }}">На сайт</a></div>
</form>
</body>
</html>
