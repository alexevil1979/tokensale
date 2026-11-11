<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ApiKey extends Model { protected $fillable=['user_id','name','key_prefix','key_hash','last_used_at','expires_at']; protected $hidden=['key_hash']; protected $casts=['last_used_at'=>'datetime','expires_at'=>'datetime']; public function user(): BelongsTo { return $this->belongsTo(User::class); } }
