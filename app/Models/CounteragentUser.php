<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CounteragentUser
 *
 * @property int $id
 * @property int $counteragent_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentUser whereCounteragentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentUser whereUserId($value)
 * @mixin \Eloquent
 */
class CounteragentUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'counteragent_id'];
}
