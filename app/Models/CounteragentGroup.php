<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\CounteragentGroup
 *
 * @property int $id
 * @property string $name
 * @property int|null $limit
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentGroup whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounteragentGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CounteragentGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function counteragents(): HasMany
    {
        return $this->hasMany(Counteragent::class, 'group_id');
    }
}
