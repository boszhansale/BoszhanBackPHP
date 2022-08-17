<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserPosition
 *
 * @property int $id
 * @property int $user_id
 * @property float|null $lat
 * @property float|null $lng
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserPosition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPosition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPosition query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPosition whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPosition whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPosition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPosition whereUserId($value)
 * @mixin \Eloquent
 */
class UserPosition extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','lat','lng'];


    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];
}
