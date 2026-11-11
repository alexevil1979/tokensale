<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LedgerEntry extends Model { protected $fillable=['user_id','type','amount','description','reference']; protected $casts=['amount'=>'integer']; }
