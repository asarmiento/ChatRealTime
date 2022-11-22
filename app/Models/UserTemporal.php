<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTemporal extends Model
{
    protected $table ='users_temporal';
    protected $fillable=['name','email'];
    use HasFactory;
}
