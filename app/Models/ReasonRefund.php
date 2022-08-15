<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReasonRefund extends Model
{
    use HasFactory;

    protected $fillable = ['code','title','type'];
    protected $hidden =['created_at','updated_at'];
}
