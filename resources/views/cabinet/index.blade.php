<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Кабинет · TokenHub</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Unbounded:wght@600;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<style>
:root{--bg:#0b0907;--panel:#12100e;--card:#17120f;--line:#2a221c;--txt:#f5efe8;--muted:#9a8d82;--acc:#ff7a1a;--acc2:#ff9a4d}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--txt);font:14px Inter,system-ui,sans-serif}
a{color:inherit;text-decoration:none}
.top{height:64px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 22px;position:sticky;top:0;background:rgba(11,9,7,.92);backdrop-filter:blur(10px);z-index:20}
.brand{display:flex;align-items:center;gap:10px;font-family:Unbounded,sans-serif;font-weight:800}
.mark{width:30px;height:30px;border-radius:8px;background:var(--acc);color:#0b0907;display:grid;place-items:center}
.pill{display:inline-flex;align-items:center;gap:8px;border:1px solid var(--line);border-radius:999px;padding:7px 12px;color:var(--muted);font-size:12px}
.pill b{color:var(--acc)}
.who{border:1px solid var(--line);border-radius:999px;padding:7px 12px;background:#1a1512}
.shell{display:grid;grid-template-columns:240px 1fr;min-height:calc(100vh - 64px)}
.side{border-right:1px solid var(--line);padding:18px 12px;background:rgba(18,16,14,.85);position:sticky;top:64px;height:calc(100vh - 64px)}
.side small{display:block;color:var(--muted);padding:0 10px 12px;text-transform:uppercase;letter-spacing:.08em;font-size:11px}
.side a,.side button.nav{display:flex;align-items:center;gap:10px;width:100%;text-align:left;border:0;background:transparent;color:var(--muted);padding:11px 12px;border-radius:10px;cursor:pointer;font:inherit}
.side a.active,.side a:hover,.side button.nav:hover{background:#221b16;color:var(--txt)}
.side a.active{color:var(--acc);border:1px solid #3a2a1c}
.side .out{margin-top:18px;color:#ffb4a6}
.main{padding:24px}
.hrow{display:flex;justify-content:space-between;gap:16px;align-items:end;margin-bottom:18px}
h1{font-family:Unbounded,sans-serif;font-size:30px;margin:0}
.muted{color:var(--muted)}
.btn{border:0;border-radius:10px;padding:10px 14px;font-weight:700;cursor:pointer}
.primary{background:var(--acc);color:#0b0907}
.ghost{background:transparent;color:var(--txt);border:1px solid var(--line)}
.stats{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;margin:16px 0 18px}
.stat{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:14px}
.stat small{display:block;color:var(--muted);margin-bottom:8px}
.stat strong{font-size:18px}
.stat strong.acc{color:var(--acc)}
.grid2{display:grid;grid-template-columns:1.4fr .8fr;gap:14px}
.card{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:16px;margin-bottom:14px}
.card h2{margin:0 0 10px;font-size:16px}
.bar{height:10px;background:#241c17;border-radius:999px;overflow:hidden}
.bar>i{display:block;height:100%;background:linear-gradient(90deg,var(--acc),#ffb070)}
.chart{display:flex;align-items:end;gap:6px;height:140px;padding-top:10px}
.chart span{flex:1;background:#2a2018;border-radius:6px 6px 2px 2px;min-height:4px;position:relative}
.chart span i{position:absolute;left:0;right:0;bottom:0;background:linear-gradient(180deg,var(--acc),#7a3d10);border-radius:6px 6px 2px 2px}
.chartlabels{display:flex;gap:6px;margin-top:8px;color:var(--muted);font-size:10px}
.chartlabels b{flex:1;text-align:center;font-weight:500}
.table{width:100%;border-collapse:collapse}
.table th,.table td{text-align:left;padding:10px 8px;border-bottom:1px solid var(--line);font-size:13px}
.table th{color:var(--muted);font-size:11px;text-transform:uppercase}
.mono{font-family:"JetBrains Mono",ui-monospace,monospace;font-size:12px;background:#100d0b;padding:8px 10px;border-radius:8px;word-break:break-all}
.alert{background:#1f2a18;color:#c6f6c2;border-radius:10px;padding:12px;margin-bottom:14px}
.err{background:#3a1510;color:#ffb4a6}
.section{display:none}
.section.active{display:block}
input,textarea,select{width:100%;background:#100d0b;border:1px solid var(--line);border-radius:10px;padding:11px 12px;color:var(--txt);margin:6px 0 12px}
.chat{display:grid;grid-template-rows:1fr auto;height:60vh;gap:10px}
.chatlog{overflow:auto;border:1px solid var(--line);border-radius:12px;padding:12px;background:#100d0b}
.bubble{max-width:80%;padding:10px 12px;border-radius:12px;margin:8px 0}
.me{background:#2a1c12;margin-left:auto}
.bot{background:#1a1512}
.codebox{background:#100d0b;border:1px solid var(--line);border-radius:12px;padding:14px;font-family:"JetBrains Mono",monospace;font-size:12px;line-height:1.6;overflow:auto}
@media(max-width:980px){.shell{grid-template-columns:1fr}.side{position:relative;top:0;height:auto;display:flex;gap:6px;overflow:auto}.stats{grid-template-columns:repeat(2,1fr)}.grid2{grid-template-columns:1fr}.hrow{flex-direction:column;align-items:start}}
</style>
</head>
<body>
<header class="top">
  <a class="brand" href="{{ secure_url('/') }}"><span class="mark">T</span>TokenHub</a>
  <div style="display:flex;gap:10px;align-items:center">
    <a class="pill" href="#overview">Остаток: <b>${{ number_format($wallet->balance/100, 2) }}</b></a>
    <a class="who" href="#profile">{{ $u->name }}</a>
  </div>
</header>
<div class="shell">
  <aside class="side">
    <small>кабинет</small>
    <a class="active" data-sec="overview" href="#overview">Обзор</a>
    <a data-sec="chat" href="#chat">Чат с ИИ</a>
    <a data-sec="image" href="#image">Генерация фото</a>
    <a data-sec="logs" href="#logs">Журнал запросов</a>
    <a data-sec="keys" href="#keys">Мой API-ключ</a>
    <a data-sec="connect" href="#connect">Как подключить</a>
    <a data-sec="billing" href="#billing">Баланс</a>
    <form method="post" action="{{ secure_url('/cabinet/logout') }}">@csrf<button class="nav out" type="submit">Выйти</button></form>
  </aside>
  <main class="main">
    @if(session('status'))<div class="alert">{{ session('status') }}</div>@endif
    @if(session('new_key'))<div class="alert">Новый ключ (сохраните сейчас):<div class="mono" style="margin-top:8px">{{ session('new_key') }}</div></div>@endif

    <section class="section active" id="overview">
      <div class="hrow">
        <div>
          <h1>Обзор</h1>
          <div class="muted">{{ $activeKey->name ?? $u->email }}</div>
        </div>
        <div style="display:flex;gap:8px">
          <button class="btn ghost" type="button" data-go="image">Генерация фото</button>
          <button class="btn primary" type="button" data-go="chat">Чат с ИИ</button>
        </div>
      </div>
      <div class="stats">
        <div class="stat"><small>Осталось</small><strong class="acc">${{ number_format($wallet->balance/100,2) }}</strong></div>
        <div class="stat"><small>Израсходовано</small><strong>${{ number_format($spent/100,2) }}</strong></div>
        <div class="stat"><small>Токенов</small><strong>{{ number_format($tokens) }}</strong></div>
        <div class="stat"><small>Запросов</small><strong>{{ $requests }}</strong></div>
        <div class="stat"><small>За 24 ч</small><strong>{{ $requests24 }}</strong></div>
        <div class="stat"><small>Ключей</small><strong>{{ $keys->count() }}</strong></div>
      </div>
      <div class="card">
        <h2>Лимит баланса</h2>
        <div class="muted" style="margin-bottom:8px">Осталось ${{ number_format($wallet->balance/100,2) }} @if($totalTopups>0) из ${{ number_format($totalTopups/100,2) }} пополнений @endif</div>
        <div class="bar"><i style="width:{{ $remainPct }}%"></i></div>
      </div>
      <div class="grid2">
        <div class="card">
          <h2>Использование · 14 дней</h2>
          @php $max = max(1, collect($chart)->max('tokens')); @endphp
          <div class="chart">
            @foreach($chart as $c)
              <span><i style="height:{{ max(4, (int)round(($c['tokens']/$max)*100)) }}%"></i></span>
            @endforeach
          </div>
          <div class="chartlabels">
            @foreach($chart as $c)<b>{{ $c['label'] }}</b>@endforeach
          </div>
        </div>
        <div class="card">
          <h2>По моделям</h2>
          @forelse($byModel as $row)
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--line)">
              <span>{{ $row->model_name }}</span>
              <span class="muted">{{ $row->requests }} req · ${{ number_format($row->spend/100,2) }}</span>
            </div>
          @empty
            <p class="muted">Запросов ещё не было</p>
          @endforelse
        </div>
      </div>
      <div class="card">
        <div class="hrow" style="margin:0 0 8px"><h2 style="margin:0">Последние запросы</h2><button class="btn ghost" type="button" data-go="logs">Весь журнал</button></div>
        <table class="table">
          <thead><tr><th>ID</th><th>Статус</th><th>Токены</th><th>Сумма</th><th>Время</th></tr></thead>
          <tbody>
          @forelse($recent->take(6) as $e)
            <tr>
              <td class="mono" style="background:transparent;padding:0">{{ \Illuminate\Support\Str::limit($e->request_id,18,'') }}</td>
              <td>{{ $e->status }}</td>
              <td>{{ $e->total_tokens }}</td>
              <td>${{ number_format($e->cost_cents/100,4) }}</td>
              <td class="muted">{{ $e->created_at->diffForHumans() }}</td>
            </tr>
          @empty
            <tr><td colspan="5" class="muted">Запросов по этому аккаунту ещё не было</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
      <div class="card">
        <h2>Подключение</h2>
        <p class="muted">Адрес и ключ вставляются в программу вместо OpenAI. Ключ — в разделе «Мой API-ключ», пошагово — в «Как подключить».</p>
        <div style="display:flex;gap:8px;margin-top:10px">
          <button class="btn ghost" type="button" data-go="keys">Мой API-ключ</button>
          <button class="btn primary" type="button" data-go="connect">Как подключить</button>
        </div>
      </div>
    </section>

    <section class="section" id="chat">
      <div class="hrow"><div><h1>Чат с ИИ</h1><div class="muted">Тестовый чат через ваш API TokenHub</div></div></div>
      <div class="card chat">
        <div class="chatlog" id="chatlog"><div class="bubble bot">Напишите сообщение. Будет использован endpoint /api/v1/chat/completions.</div></div>
        <form id="chatform" style="display:flex;gap:8px">
          <select id="chatmodel" style="width:220px;margin:0">
            @foreach($models as $m)<option value="{{ $m->slug }}">{{ $m->name }}</option>@endforeach
          </select>
          <input id="chatmsg" placeholder="Сообщение..." style="margin:0" required>
          <button class="btn primary" style="width:auto">Отправить</button>
        </form>
        <p class="muted">Для чата создайте ключ и вставьте его один раз ниже:</p>
        <input id="chatkey" placeholder="tk_live_… (только в браузере, не сохраняется на сервере)" style="margin:0">
      </div>
    </section>

    <section class="section" id="image">
      <div class="hrow"><div><h1>Генерация фото</h1><div class="muted">Раздел в разработке</div></div></div>
      <div class="card"><p class="muted">Скоро: генерация изображений через тот же баланс и API-ключ.</p></div>
    </section>

    <section class="section" id="logs">
      <div class="hrow"><div><h1>Журнал запросов</h1><div class="muted">Usage events вашего аккаунта</div></div></div>
      <div class="card">
        <table class="table">
          <thead><tr><th>Request</th><th>Status</th><th>Tokens</th><th>Cost</th><th>Latency</th><th>When</th></tr></thead>
          <tbody>
          @forelse($recent as $e)
            <tr>
              <td class="mono" style="background:transparent;padding:0">{{ $e->request_id }}</td>
              <td>{{ $e->status }}</td>
              <td>{{ $e->prompt_tokens }}/{{ $e->completion_tokens }}</td>
              <td>${{ number_format($e->cost_cents/100,4) }}</td>
              <td>{{ $e->latency_ms }}ms</td>
              <td class="muted">{{ $e->created_at }}</td>
            </tr>
          @empty
            <tr><td colspan="6" class="muted">Пусто</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </section>

    <section class="section" id="keys">
      <div class="hrow"><div><h1>Мой API-ключ</h1><div class="muted">Ключ показывается только при создании</div></div></div>
      <div class="card">
        <form method="post" action="{{ secure_url('/cabinet/keys') }}" style="display:flex;gap:8px;align-items:end">
          @csrf
          <div style="flex:1"><label class="muted">Название</label><input name="name" value="default" required style="margin:6px 0 0"></div>
          <button class="btn primary" style="width:auto">+ Создать ключ</button>
        </form>
      </div>
      <div class="card">
        <table class="table">
          <thead><tr><th>Имя</th><th>Prefix</th><th>Rate limit</th><th>Last used</th><th></th></tr></thead>
          <tbody>
          @forelse($keys as $k)
            <tr>
              <td>{{ $k->name }}</td>
              <td class="mono" style="background:transparent;padding:0">{{ $k->key_prefix }}••••</td>
              <td>{{ $k->rate_limit_per_minute }}/min</td>
              <td class="muted">{{ $k->last_used_at?->diffForHumans() ?? '—' }}</td>
              <td>
                <form method="post" action="{{ secure_url('/cabinet/keys/'.$k->id) }}">@csrf @method('DELETE')
                  <button class="btn ghost" style="width:auto;color:#ffb4a6">Удалить</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="muted">Ключей пока нет</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </section>

    <section class="section" id="connect">
      <div class="hrow"><div><h1>Как подключить</h1><div class="muted">OpenAI-compatible endpoint</div></div></div>
      <div class="card">
        <p class="muted">Base URL:</p>
        <div class="mono">{{ rtrim(config('app.url'), '/') }}/api/v1</div>
        <p class="muted" style="margin-top:14px">Пример curl:</p>
        <div class="codebox">curl {{ rtrim(config('app.url'), '/') }}/api/v1/chat/completions \
  -H "Authorization: Bearer YOUR_KEY" \
  -H "Content-Type: application/json" \
  -d '{"model":"openai/gpt-4o","messages":[{"role":"user","content":"hello"}]}'</div>
        <p class="muted" style="margin-top:14px">В Cursor / Continue / OpenWebUI укажите этот base URL и ваш ключ.</p>
      </div>
    </section>

    <section class="section" id="billing">
      <div class="hrow"><div><h1>Баланс</h1><div class="muted">Пополнения и списания</div></div>
        <form method="post" action="{{ secure_url('/cabinet/topup') }}">@csrf<button class="btn primary">+$10 demo</button></form>
      </div>
      <div class="stats" style="grid-template-columns:repeat(3,1fr)">
        <div class="stat"><small>Баланс</small><strong class="acc">${{ number_format($wallet->balance/100,2) }}</strong></div>
        <div class="stat"><small>Пополнено</small><strong>${{ number_format($totalTopups/100,2) }}</strong></div>
        <div class="stat"><small>Списано на API</small><strong>${{ number_format($spent/100,2) }}</strong></div>
      </div>
      <div class="card">
        <table class="table">
          <thead><tr><th>Тип</th><th>Сумма</th><th>Описание</th><th>Когда</th></tr></thead>
          <tbody>
          @forelse($entries as $e)
            <tr>
              <td>{{ $e->type }}</td>
              <td>${{ number_format($e->amount/100,2) }}</td>
              <td>{{ $e->description }}</td>
              <td class="muted">{{ $e->created_at }}</td>
            </tr>
          @empty
            <tr><td colspan="4" class="muted">Операций пока нет</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </section>

    <section class="section" id="profile">
      <div class="hrow"><div><h1>Профиль</h1><div class="muted">{{ $u->email }}</div></div></div>
      <div class="card">
        <p><b>{{ $u->name }}</b></p>
        <p class="muted">{{ $u->email }}</p>
        @if($u->is_admin)<p><a class="btn ghost" href="{{ secure_url('/admin') }}">Открыть админку</a></p>@endif
      </div>
    </section>
  </main>
</div>
<script>
const sections=[...document.querySelectorAll('.section')];
const links=[...document.querySelectorAll('.side a[data-sec]')];
function show(id){
  sections.forEach(s=>s.classList.toggle('active', s.id===id));
  links.forEach(a=>a.classList.toggle('active', a.dataset.sec===id));
  history.replaceState(null,'','#'+id);
}
function go(id){ if(document.getElementById(id)) show(id); }
links.forEach(a=>a.addEventListener('click',e=>{e.preventDefault();show(a.dataset.sec)}));
document.querySelectorAll('[data-go]').forEach(b=>b.addEventListener('click',()=>go(b.dataset.go)));
go((location.hash||'#overview').slice(1));
const form=document.getElementById('chatform');
const log=document.getElementById('chatlog');
form?.addEventListener('submit', async (e)=>{
  e.preventDefault();
  const key=document.getElementById('chatkey').value.trim();
  const msg=document.getElementById('chatmsg').value.trim();
  const model=document.getElementById('chatmodel').value;
  if(!key){ alert('Вставьте API-ключ'); return; }
  log.innerHTML += `<div class="bubble me">${msg.replace(/</g,'&lt;')}</div>`;
  document.getElementById('chatmsg').value='';
  try{
    const r=await fetch('/api/v1/chat/completions',{method:'POST',headers:{'Authorization':'Bearer '+key,'Content-Type':'application/json'},body:JSON.stringify({model,messages:[{role:'user',content:msg}],max_tokens:128})});
    const j=await r.json();
    const txt=j?.choices?.[0]?.message?.content || j?.error?.message || JSON.stringify(j);
    log.innerHTML += `<div class="bubble bot">${String(txt).replace(/</g,'&lt;')}</div>`;
  }catch(err){ log.innerHTML += `<div class="bubble bot">Ошибка: ${err}</div>`; }
  log.scrollTop=log.scrollHeight;
});
</script>
</body>
</html>
