<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Кабинет · TokenHub</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Unbounded:wght@600;800&display=swap" rel="stylesheet">
<style>
:root{--bg:#0b0907;--card:#17120f;--line:#2a221c;--txt:#f5efe8;--muted:#9a8d82;--acc:#ff7a1a;--acc2:#ff9a4d}
*{box-sizing:border-box}body{margin:0;min-height:100vh;font-family:Inter,system-ui,sans-serif;color:var(--txt);background:radial-gradient(900px 500px at 20% 10%,#3a220f 0%,transparent 55%),radial-gradient(700px 400px at 80% 80%,#2a1608 0%,transparent 50%),var(--bg)}
.top{height:64px;display:flex;align-items:center;justify-content:space-between;padding:0 5%}
.brand{display:flex;align-items:center;gap:10px;font-family:Unbounded,sans-serif;font-weight:800;text-decoration:none;color:var(--txt)}
.mark{width:32px;height:32px;border-radius:9px;background:var(--acc);color:#0b0907;display:grid;place-items:center;font-weight:800}
.wrap{min-height:calc(100vh - 64px);display:grid;place-items:center;padding:24px}
.card{width:min(440px,100%);background:rgba(23,18,15,.92);border:1px solid var(--line);border-radius:16px;padding:28px}
h1{font-family:Unbounded,sans-serif;font-size:28px;margin:0 0 8px}
.muted{color:var(--muted);font-size:13px}
input{width:100%;background:#100d0b;border:1px solid var(--line);border-radius:10px;padding:12px 14px;color:var(--txt);margin:8px 0 12px}
.btn{border:0;border-radius:10px;padding:12px 16px;font-weight:700;cursor:pointer;width:100%}
.primary{background:var(--acc);color:#0b0907}
.ghost{background:transparent;color:var(--txt);border:1px solid var(--line)}
.err{background:#3a1510;color:#ffb4a6;border-radius:8px;padding:10px 12px;margin:10px 0}
.sep{border:0;border-top:1px solid var(--line);margin:20px 0}
a{color:var(--acc2);text-decoration:none}
</style>
</head>
<body>
<header class="top"><a class="brand" href="{{ secure_url('/') }}"><span class="mark">T</span>TokenHub</a></header>
<main class="wrap">
  <section class="card">
    <h1>Вход в кабинет</h1>
    <p class="muted">Email/пароль или вход по API-ключу.</p>
    @if($errors->has('email') || $errors->has('password'))<div class="err">{{ $errors->first() }}</div>@endif
    <form method="post" action="{{ secure_url('/cabinet/login') }}">
      @csrf
      <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button class="btn primary" type="submit">Войти</button>
    </form>
    <hr class="sep">
    <p class="muted">Купили API-ключ? Войдите по нему:</p>
    @if($errors->has('key'))<div class="err">{{ $errors->first('key') }}</div>@endif
    <form method="post" action="{{ secure_url('/cabinet/login-key') }}">
      @csrf
      <input name="key" placeholder="tk_live_…" value="{{ old('key') }}" required>
      <button class="btn ghost" type="submit">Вход по API-ключу</button>
    </form>
    <p class="muted" style="margin-top:16px;text-align:center">Нет аккаунта? <a href="{{ secure_url('/register') }}">Регистрация</a></p>
  </section>
</main>
</body>
</html>
