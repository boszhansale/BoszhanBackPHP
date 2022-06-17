<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RolePermission extends Model
{
    use HasFactory;

    protected $fillable = ['role_id','permission_id'];

    function permission():BelongsTo
    {
        return  $this->belongsTo(Permission::class);
    }
    function role():BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
