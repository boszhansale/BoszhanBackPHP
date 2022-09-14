<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BonusGame
 *
 * @property int $id
 * @property int $store_id
 * @property int $win
 * @property string $mobile_id
 * @property string $game_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BonusGame newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BonusGame newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BonusGame query()
 * @method static \Illuminate\Database\Eloquent\Builder|BonusGame whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonusGame whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonusGame whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonusGame whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonusGame whereMobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonusGame whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonusGame whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonusGame whereWin($value)
 * @mixin \Eloquent
 */
class BonusGame extends Model
{
    use HasFactory;
}
