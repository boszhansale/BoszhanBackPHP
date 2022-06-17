<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderComment
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property string $description
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderComment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderComment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderComment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderComment whereUserId($value)
 * @mixin \Eloquent
 */
class OrderComment extends Model
{
    use HasFactory;
}
