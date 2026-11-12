<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PaymentWebhook extends Model { protected $fillable=['provider','event_id','status','payload','processed_at','error']; protected $casts=['payload'=>'array','processed_at'=>'datetime']; }
