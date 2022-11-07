<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounteragentBalanceOperation extends Model
{
    use HasFactory;

    protected $fillable = ['counteragent_id', 'debt', 'balance', 'comment', 'orders', 'user_id'];

    protected $casts = [
        'orders' => 'json'
    ];
}
