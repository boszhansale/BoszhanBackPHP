<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupervisorSalesrep extends Model
{
    use HasFactory;

    protected $fillable = ['supervisor_id','salesrep_id'];


    function supervisor():BelongsTo
    {
        return  $this->belongsTo(User::class);
    }
    function salesrep():BelongsTo
    {
        return  $this->belongsTo(User::class);
    }
}
