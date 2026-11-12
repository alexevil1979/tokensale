<?php
namespace App\Http\Controllers;
use App\Models\AiModel;
use App\Models\ApiKey;
use App\Models\LedgerEntry;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class TokenHubController extends Controller {
 public function home(){return view('home',['models'=>AiModel::where('is_active',true)->get()]);}
 public function login(){return view('auth.login');}
 public function authenticate(Request $r){$data=$r->validate(['email'=>'required|email','password'=>'required']); if(!Auth::attempt($data,$r->boolean('remember'))){return back()->withErrors(['email'=>'Неверный email или пароль.'])->withInput();} $r->session()->regenerate(); return redirect()->intended('/dashboard');}
 public function register(){return view('auth.register');}
 public function storeUser(Request $r){$data=$r->validate(['name'=>'required|string|max:80','email'=>'required|email|max:255|unique:users','password'=>'required|string|min:8|confirmed']); $u=User::create($data); Wallet::create(['user_id'=>$u->id]); Auth::login($u); return redirect('/dashboard');}
 public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect('/');}
 public function dashboard(){ $u=Auth::user(); $wallet=Wallet::firstOrCreate(['user_id'=>$u->id]); return view('dashboard',['wallet'=>$wallet,'keys'=>$u->apiKeys()->latest()->get(),'models'=>AiModel::where('is_active',true)->get(),'entries'=>LedgerEntry::where('user_id',$u->id)->latest()->limit(6)->get()]); }
 public function createKey(Request $r){$r->validate(['name'=>'required|string|max:60']);$raw='tk_live_'.Str::random(32); ApiKey::create(['user_id'=>Auth::id(),'name'=>$r->name,'key_prefix'=>substr($raw,0,16),'key_hash'=>hash('sha256',$raw)]);return back()->with('new_key',$raw);}
 public function deleteKey(ApiKey $key){abort_unless($key->user_id===Auth::id(),403);$key->delete();return back()->with('status','Ключ удален.');}
 public function demoTopup(){ $wallet=Wallet::firstOrCreate(['user_id'=>Auth::id()]);$amount=1000; $wallet->increment('balance',$amount);LedgerEntry::create(['user_id'=>Auth::id(),'type'=>'credit','amount'=>$amount,'description'=>'Демо-пополнение']);return back()->with('status','На баланс добавлено $10.00 в демо-режиме.'); }
 public function models(){return view('models',['models'=>AiModel::where('is_active',true)->get()]);}
 public function api(Request $r){
  $key=$r->bearerToken();
  if(!$key){return response()->json(['error'=>['message'=>'Bearer API key required','type'=>'authentication_error']],401);}
  $record=ApiKey::where('key_hash',hash('sha256',$key))->first();
  if(!$record){return response()->json(['error'=>['message'=>'Invalid API key','type'=>'authentication_error']],401);}
  $model=AiModel::where('slug',$r->input('model','openai/gpt-4o'))->where('is_active',true)->first();
  if(!$model){return response()->json(['error'=>['message'=>'Model not found','type'=>'invalid_request_error']],404);}
  $messages=$r->input('messages',[]); $promptTokens=max(1,(int)ceil(strlen(json_encode($messages))/4)); $completionTokens=max(1,min((int)$r->input('max_tokens',128),128));
  $cost=max(1,(int)ceil(($promptTokens*$model->input_price+$completionTokens*$model->output_price)/1000000));
  try { DB::transaction(function() use($record,$model,$cost){ $wallet=Wallet::where('user_id',$record->user_id)->lockForUpdate()->firstOrCreate(['user_id'=>$record->user_id],['balance'=>0]); if($wallet->balance<$cost){ throw new \\RuntimeException('INSUFFICIENT_BALANCE'); } $wallet->decrement('balance',$cost); LedgerEntry::create(['user_id'=>$record->user_id,'type'=>'debit','amount'=>-$cost,'description'=>'API usage: '.$model->slug,'reference'=>'api-'.Str::uuid()]); $record->update(['last_used_at'=>now()]); }); }
  catch(\\RuntimeException $e){if($e->getMessage()==='INSUFFICIENT_BALANCE'){return response()->json(['error'=>['message'=>'Insufficient balance. Add funds before making API requests.','type'=>'insufficient_quota']],402);} throw $e;}
  return response()->json(['id'=>'chatcmpl_demo','object'=>'chat.completion','created'=>now()->timestamp,'model'=>$model->slug,'choices'=>[['index'=>0,'message'=>['role'=>'assistant','content'=>'TokenHub API is connected. Configure a provider to enable live model responses.'],'finish_reason'=>'stop']],'usage'=>['prompt_tokens'=>$promptTokens,'completion_tokens'=>$completionTokens,'total_tokens'=>$promptTokens+$completionTokens],'billing'=>['charged_cents'=>$cost]]);
 }
}
