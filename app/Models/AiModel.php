<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AiModel extends Model { protected $fillable=['name','slug','provider','description','input_price','output_price','context_window','is_active']; protected $casts=['is_active'=>'boolean']; }
