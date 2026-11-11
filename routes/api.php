<?php
use Illuminate\Support\Facades\Route; use App\Http\Controllers\TokenHubController;
Route::post('/v1/chat/completions',[TokenHubController::class,'api']); Route::get('/v1/models',fn()=>response()->json(['object'=>'list','data'=>\App\Models\AiModel::where('is_active',true)->get()->map(fn($m)=>['id'=>$m->slug,'object'=>'model','owned_by'=>$m->provider])]));
