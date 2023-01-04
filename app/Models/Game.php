<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Game
 *
 * @property int $id
 * @property int $total_win
 * @property int $store_id
 * @property int $order_id
 * @property int $salesrep_id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereMobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereWin($value)
 * @mixin \Eloquent
 */
class Game extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'salesrep_id', 'order_id', 'total_win', 'token'];

    function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    function salesrep(): BelongsTo
    {
        return $this->belongsTo(User::class, 'salesrep_id');
    }

    function loops(): HasMany
    {
        return $this->hasMany(GameLoop::class);
    }
}
