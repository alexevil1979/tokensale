<?php
use Illuminate\Support\Facades\Route; use App\Http\Controllers\TokenHubController; use App\Http\Controllers\OperationsController;
Route::get('/health',[OperationsController::class,'health']); Route::get('/metrics',[OperationsController::class,'metrics']); Route::post('/webhooks/payments',[OperationsController::class,'paymentWebhook']);
Route::post('/v1/chat/completions',[TokenHubController::class,'api']); Route::get('/v1/models',fn()=>response()->json(['object'=>'list','data'=>\App\Models\AiModel::where('is_active',true)->get()->map(fn($m)=>['id'=>$m->slug,'object'=>'model','owned_by'=>$m->provider])]));
