<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryChat extends Model
{
    protected $table ='histories_chat';
    protected $fillable=['user_id','message'];
    use HasFactory;
}
