<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupervisorSalesrep extends Model
{
    use HasFactory;

    protected $fillable = ['supervisor_id', 'salesrep_id'];

    public function supervisor(): BelongsTo
    {
        return  $this->belongsTo(User::class);
    }

    public function salesrep(): BelongsTo
    {
        return  $this->belongsTo(User::class);
    }
}
