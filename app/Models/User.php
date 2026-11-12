<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory; use Illuminate\Foundation\Auth\User as Authenticatable; use Illuminate\Notifications\Notifiable; use Illuminate\Database\Eloquent\Relations\HasMany; use Illuminate\Database\Eloquent\Relations\HasOne;
class User extends Authenticatable { use HasFactory, Notifiable; protected $fillable=['name','email','password']; protected $hidden=['password','remember_token']; protected function casts(): array {return ['email_verified_at'=>'datetime','password'=>'hashed','is_admin'=>'boolean'];} public function wallet(): HasOne{return $this->hasOne(Wallet::class);} public function apiKeys(): HasMany{return $this->hasMany(ApiKey::class);} public function usageEvents(): HasMany{return $this->hasMany(UsageEvent::class);} }
