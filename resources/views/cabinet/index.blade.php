<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Кабинет · TokenHub</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Unbounded:wght@600;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<style>
:root{--bg:#0b0907;--panel:#12100e;--card:rgba(23,18,15,.88);--line:#2a221c;--txt:#f5efe8;--muted:#9a8d82;--acc:#ff7a1a;--acc2:#ff9a4d}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--txt);font:14px Inter,system-ui,sans-serif;min-height:100vh}
body::before{content:"";position:fixed;inset:0;z-index:0;pointer-events:none;background:
  radial-gradient(circle at 12% 18%,rgba(255,140,40,.22) 0 2px,transparent 3px),
  radial-gradient(circle at 28% 72%,rgba(255,170,60,.18) 0 3px,transparent 5px),
  radial-gradient(circle at 68% 22%,rgba(255,120,30,.2) 0 4px,transparent 7px),
  radial-gradient(circle at 82% 64%,rgba(255,160,50,.16) 0 2px,transparent 4px),
  radial-gradient(circle at 48% 40%,rgba(255,100,20,.12) 0 6px,transparent 10px),
  radial-gradient(900px 520px at 18% 8%,#3a220f 0%,transparent 55%),
  radial-gradient(700px 420px at 88% 88%,#2a1608 0%,transparent 50%),
  var(--bg);filter:blur(.2px)}
a{color:inherit;text-decoration:none}
.top,.shell,.main,.side{position:relative;z-index:1}
.top{height:64px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 22px;position:sticky;top:0;background:rgba(11,9,7,.86);backdrop-filter:blur(12px);z-index:20}
.brand{display:flex;align-items:center;gap:10px;font-family:Unbounded,sans-serif;font-weight:800}
.mark{width:30px;height:30px;border-radius:8px;background:var(--acc);color:#0b0907;display:grid;place-items:center}
.pill{display:inline-flex;align-items:center;gap:8px;border:1px solid var(--line);border-radius:999px;padding:7px 12px;color:var(--muted);font-size:12px;background:rgba(26,21,18,.7)}
.pill b{color:var(--acc)}
.who{border:1px solid var(--line);border-radius:999px;padding:7px 12px;background:#1a1512;display:inline-flex;align-items:center;gap:8px}
.who .av{width:22px;height:22px;border-radius:50%;background:var(--acc);color:#0b0907;display:grid;place-items:center;font-size:11px;font-weight:800}
.shell{display:grid;grid-template-columns:240px 1fr;min-height:calc(100vh - 64px)}
.side{border-right:1px solid var(--line);padding:18px 12px;background:rgba(18,16,14,.72);position:sticky;top:64px;height:calc(100vh - 64px);backdrop-filter:blur(8px)}
.side small{display:block;color:var(--muted);padding:0 10px 12px;text-transform:uppercase;letter-spacing:.08em;font-size:11px}
.side a,.side button.nav{display:flex;align-items:center;gap:10px;width:100%;text-align:left;border:0;background:transparent;color:var(--muted);padding:11px 12px;border-radius:10px;cursor:pointer;font:inherit}
.side a.active,.side a:hover,.side button.nav:hover{background:#221b16;color:var(--txt)}
.side a.active{color:var(--acc);border:1px solid #3a2a1c}
.side .out{margin-top:18px;color:#ffb4a6}
.main{padding:24px}
.hrow{display:flex;justify-content:space-between;gap:16px;align-items:end;margin-bottom:18px}
h1{font-family:Unbounded,sans-serif;font-size:30px;margin:0;opacity:.95}
.muted{color:var(--muted)}
.btn{border:0;border-radius:10px;padding:10px 14px;font-weight:700;cursor:pointer}
.primary{background:var(--acc);color:#0b0907}
.ghost{background:transparent;color:var(--txt);border:1px solid var(--line)}
.stats{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;margin:16px 0 18px}
.stat{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:14px;backdrop-filter:blur(6px)}
.stat small{display:block;color:var(--muted);margin-bottom:8px}
.stat strong{font-size:18px}
.stat strong.acc{color:var(--acc)}
.grid2{display:grid;grid-template-columns:1.4fr .8fr;gap:14px}
.card{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:16px;margin-bottom:14px;backdrop-filter:blur(6px)}
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
.section{display:none}
.section.active{display:block}
input,textarea,select{width:100%;background:#100d0b;border:1px solid var(--line);border-radius:10px;padding:11px 12px;color:var(--txt);margin:6px 0 12px}
.chatwrap{display:grid;grid-template-columns:1fr 260px;gap:14px;min-height:62vh}
.chat{display:grid;grid-template-rows:auto 1fr auto;gap:10px;min-height:62vh}
.chatlog{overflow:auto;border:1px solid var(--line);border-radius:12px;padding:12px;background:rgba(16,13,11,.85)}
.bubble{max-width:80%;padding:10px 12px;border-radius:12px;margin:8px 0;white-space:pre-wrap}
.me{background:#2a1c12;margin-left:auto}
.bot{background:#1a1512}
.prompts{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:8px}
.prompts button{text-align:left;background:#1a1512;border:1px solid var(--line);border-radius:10px;color:var(--txt);padding:10px;cursor:pointer}
.prompts button small{display:block;color:var(--muted);margin-top:4px;font-size:11px}
.codebox{background:#100d0b;border:1px solid var(--line);border-radius:12px;padding:14px;font-family:"JetBrains Mono",monospace;font-size:12px;line-height:1.6;overflow:auto}
.sidepanel label{display:block;color:var(--muted);font-size:12px;margin-top:8px}
@media(max-width:980px){.shell{grid-template-columns:1fr}.side{position:relative;top:0;height:auto;display:flex;gap:6px;overflow:auto;flex-wrap:wrap}.stats{grid-template-columns:repeat(2,1fr)}.grid2,.chatwrap{grid-template-columns:1fr}.hrow{flex-direction:column;align-items:start}.prompts{grid-template-columns:1fr}}
</style>
</head>
<body>
<header class="top">
  <a class="brand" href="{{ secure_url('/') }}"><span class="mark">T</span>TokenHub</a>
  <div style="display:flex;gap:10px;align-items:center">
    <a class="pill" href="#overview">Остаток ключа: <b>{{ $remainPct }}%</b></a>
    <a class="who" href="#keys"><span class="av">{{ strtoupper(substr($packName,0,1)) }}</span>{{ $packName }}</a>
  </div>
</header>
<div class="shell">
  <aside class="side">
    <small>{{ session('cabinet_key_id') ? 'вход по ключу' : 'кабинет' }}</small>
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
          <div class="muted">{{ $packName }}</div>
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
        <h2>Лимит ключа</h2>
        <div class="muted" style="margin-bottom:8px">Осталось {{ $remainPct }}% · ${{ number_format($wallet->balance/100,2) }}</div>
        <div class="bar"><i style="width:{{ $remainPct }}%"></i></div>
      </div>
      <div class="grid2">
        <div class="card">
          <h2>Использование</h2>
          <div class="muted" style="margin-bottom:8px">Последние 14 дней</div>
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
            <tr><td colspan="5" class="muted">Запросов по этому ключу ещё не было</td></tr>
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
      <div class="hrow"><div><h1>Чат с ИИ</h1><div class="muted">Запросы списываются с баланса ключа</div></div></div>
      <div class="chatwrap">
        <div class="card chat">
          <div class="prompts">
            <button type="button" data-prompt="Напиши Telegram-бота на Python, который отвечает на сообщения"><b>Напиши код</b><small>Telegram-бот на Python</small></button>
            <button type="button" data-prompt="Придумай 10 идей для постов в Telegram-канал про нейросети"><b>Придумай идеи</b><small>10 идей для постов</small></button>
            <button type="button" data-prompt="Объясни простыми словами, как работают нейросети"><b>Объясни просто</b><small>Как работают нейросети</small></button>
            <button type="button" data-prompt="Исправь ошибки и сделай текст красивее:"><b>Улучши текст</b><small>Правка и стиль</small></button>
          </div>
          <div class="chatlog" id="chatlog"><div class="bubble bot">Чем могу помочь?</div></div>
          <form id="chatform" style="display:flex;gap:8px">
            <textarea id="chatmsg" rows="2" placeholder="Сообщение… Enter — отправить" style="margin:0;resize:vertical" required></textarea>
            <button class="btn primary" style="width:auto;align-self:end">Отправить</button>
          </form>
        </div>
        <div class="card sidepanel">
          <h2>Параметры</h2>
          <label>Модель</label>
          <select id="chatmodel">
            @forelse($models as $m)<option value="{{ $m->slug }}">{{ $m->name }}</option>
            @empty<option value="openai/gpt-4o-mini">openai/gpt-4o-mini</option>@endforelse
          </select>
          <label>Системный промпт</label>
          <textarea id="system" rows="4" placeholder="Опционально">Ты полезный ассистент TokenHub.</textarea>
          <label>API-ключ</label>
          <input id="chatkey" value="{{ $sessionKey }}" placeholder="tk_live_…">
          <p class="muted" style="font-size:12px">Ключ используется только в браузере для запросов к API.</p>
          <button class="btn ghost" type="button" id="newchat" style="width:100%;margin-top:8px">Новый чат</button>
        </div>
      </div>
    </section>

    <section class="section" id="image">
      <div class="hrow"><div><h1>Генерация фото</h1><div class="muted">Промпт → изображение через ваш баланс</div></div></div>
      <div class="card">
        <label class="muted">Промпт</label>
        <textarea id="imgprompt" rows="3" placeholder="Опиши изображение…"></textarea>
        <div style="display:flex;gap:8px;align-items:center">
          <button class="btn primary" type="button" id="imggen">Сгенерировать</button>
          <span class="muted" id="imgstatus">Эндпоинт /api/v1/images/generations (если доступен у провайдера)</span>
        </div>
        <div id="imgout" style="margin-top:14px"></div>
      </div>
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
      <div class="hrow"><div><h1>Мой API-ключ</h1><div class="muted">Ключ показывается полностью только при создании или входе по ключу</div></div></div>
      @if($sessionKey)
      <div class="card">
        <h2>Активный ключ сессии</h2>
        <div class="mono" id="sessionkey">{{ $sessionKey }}</div>
        <button class="btn ghost" type="button" style="margin-top:10px;width:auto" onclick="navigator.clipboard.writeText(document.getElementById('sessionkey').innerText)">Копировать</button>
      </div>
      @endif
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
        <div class="mono">{{ $baseUrl }}</div>
        <p class="muted" style="margin-top:14px">Пример curl:</p>
        <div class="codebox">curl {{ $baseUrl }}/chat/completions \
  -H "Authorization: Bearer YOUR_KEY" \
  -H "Content-Type: application/json" \
  -d '{"model":"openai/gpt-4o-mini","messages":[{"role":"user","content":"hello"}]}'</div>
        <p class="muted" style="margin-top:14px">В Cursor / Continue / OpenWebUI укажите этот base URL и ваш ключ из раздела «Мой API-ключ».</p>
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
const msgs=[];
document.querySelectorAll('[data-prompt]').forEach(b=>b.addEventListener('click',()=>{
  document.getElementById('chatmsg').value=b.dataset.prompt;
  document.getElementById('chatmsg').focus();
}));
document.getElementById('newchat')?.addEventListener('click',()=>{
  msgs.length=0; log.innerHTML='<div class="bubble bot">Чем могу помочь?</div>';
});
form?.addEventListener('submit', async (e)=>{
  e.preventDefault();
  const key=document.getElementById('chatkey').value.trim();
  const msg=document.getElementById('chatmsg').value.trim();
  const model=document.getElementById('chatmodel').value;
  const system=document.getElementById('system').value.trim();
  if(!key){ alert('Вставьте API-ключ'); return; }
  log.innerHTML += `<div class="bubble me">${msg.replace(/</g,'&lt;')}</div>`;
  document.getElementById('chatmsg').value='';
  msgs.push({role:'user',content:msg});
  const payload={model,messages:[...(system?[{role:'system',content:system}]:[]),...msgs],max_tokens:512};
  try{
    const r=await fetch('/api/v1/chat/completions',{method:'POST',headers:{'Authorization':'Bearer '+key,'Content-Type':'application/json'},body:JSON.stringify(payload)});
    const j=await r.json();
    const txt=j?.choices?.[0]?.message?.content || j?.error?.message || JSON.stringify(j);
    msgs.push({role:'assistant',content:String(txt)});
    log.innerHTML += `<div class="bubble bot">${String(txt).replace(/</g,'&lt;')}</div>`;
  }catch(err){ log.innerHTML += `<div class="bubble bot">Ошибка: ${err}</div>`; }
  log.scrollTop=log.scrollHeight;
});
document.getElementById('chatmsg')?.addEventListener('keydown',e=>{
  if(e.key==='Enter' && !e.shiftKey){ e.preventDefault(); form.requestSubmit(); }
});
document.getElementById('imggen')?.addEventListener('click', async ()=>{
  const key=document.getElementById('chatkey').value.trim();
  const prompt=document.getElementById('imgprompt').value.trim();
  const st=document.getElementById('imgstatus');
  const out=document.getElementById('imgout');
  if(!key||!prompt){ alert('Нужны промпт и API-ключ'); return; }
  st.textContent='Генерация…'; out.innerHTML='';
  try{
    const r=await fetch('/api/v1/images/generations',{method:'POST',headers:{'Authorization':'Bearer '+key,'Content-Type':'application/json'},body:JSON.stringify({prompt,n:1,size:'1024x1024'})});
    const j=await r.json();
    const url=j?.data?.[0]?.url || j?.data?.[0]?.b64_json;
    if(j?.data?.[0]?.url){ out.innerHTML=`<img src="${j.data[0].url}" style="max-width:100%;border-radius:12px;border:1px solid var(--line)">`; st.textContent='Готово'; }
    else if(j?.data?.[0]?.b64_json){ out.innerHTML=`<img src="data:image/png;base64,${j.data[0].b64_json}" style="max-width:100%;border-radius:12px;border:1px solid var(--line)">`; st.textContent='Готово'; }
    else { st.textContent='Ответ API'; out.innerHTML=`<div class="mono">${JSON.stringify(j).replace(/</g,'&lt;')}</div>`; }
  }catch(err){ st.textContent='Ошибка'; out.innerHTML=`<div class="muted">${err}</div>`; }
});
</script>
</body>
</html>
