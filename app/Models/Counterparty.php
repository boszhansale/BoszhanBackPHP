<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Counterparty
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property string|null $id_1c
 * @property int|null $limit
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Counterparty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Counterparty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Counterparty query()
 * @method static \Illuminate\Database\Eloquent\Builder|Counterparty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counterparty whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counterparty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counterparty whereId1c($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counterparty whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counterparty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counterparty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counterparty whereUserId($value)
 * @mixin \Eloquent
 */
class Counterparty extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'user_id',
        'id_1c',
        'limit',
    ];

    //protected $fillable = ['name_1c'];

    public static function generateId1C()
    {
        $last = self::orderBy('id_1c', 'desc')->first();

        return strval($last->id_1c + 1);
    }

}
