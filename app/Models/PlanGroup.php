<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\PlanGroup
 *
 * @property int $id
 * @property string $name
 * @property int $plan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroup wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property float $completed
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PlanGroupBrand[] $planGroupBrands
 * @property-read int|null $plan_group_brands_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PlanGroupUser[] $planGroupUser
 * @property-read int|null $plan_group_user_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroup whereCompleted($value)
 */
class PlanGroup extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'plan', 'completed'];

    protected $hidden = ['created_at', 'updated_at'];

    public function users(): HasManyThrough
    {
        return  $this->hasManyThrough(User::class, PlanGroupUser::class);
    }

    public function planGroupUser(): HasMany
    {
        return  $this->hasMany(PlanGroupUser::class);
    }

    public function planGroupBrands(): HasMany
    {
        return  $this->hasMany(PlanGroupBrand::class);
    }
}
