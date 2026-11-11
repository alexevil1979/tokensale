<?php
namespace App\Http\Controllers;
use App\Models\AiModel; use App\Models\ApiKey; use App\Models\LedgerEntry; use App\Models\Wallet; use App\Models\User; use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth; use Illuminate\Support\Facades\Hash; use Illuminate\Support\Str;
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
 public function api(Request $r){$key=$r->bearerToken(); if(!$key){return response()->json(['error'=>['message'=>'Bearer API key required','type'=>'authentication_error']],401);} $record=ApiKey::where('key_hash',hash('sha256',$key))->first(); if(!$record){return response()->json(['error'=>['message'=>'Invalid API key','type'=>'authentication_error']],401);} $record->update(['last_used_at'=>now()]); return response()->json(['id'=>'chatcmpl_demo','object'=>'chat.completion','model'=>$r->input('model','tokenhub/auto'),'choices'=>[['index'=>0,'message'=>['role'=>'assistant','content'=>'TokenHub API is connected. Configure a provider to enable live model responses.'],'finish_reason'=>'stop']],'usage'=>['prompt_tokens'=>0,'completion_tokens'=>0,'total_tokens'=>0]]); }
}
