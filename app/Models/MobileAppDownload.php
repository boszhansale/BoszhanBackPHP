<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileAppDownload extends Model
{
    use HasFactory;

    protected $fillable = ['ip', 'mobile_app_id'];
}
