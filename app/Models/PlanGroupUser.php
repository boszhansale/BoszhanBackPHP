<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\PlanGroupUser
 *
 * @property int $id
 * @property int $plan_group_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PlanGroup $planGroup
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupUser wherePlanGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupUser whereUserId($value)
 * @mixin \Eloquent
 *
 * @property int $plan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupUser wherePlan($value)
 *
 * @property float $completed
 * @property int $position
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupUser whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupUser wherePosition($value)
 */
class PlanGroupUser extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['plan_group_id', 'user_id', 'completed', 'position', 'plan'];

    protected $hidden = ['created_at', 'updated_at'];

    public function planGroup(): BelongsTo
    {
        return  $this->belongsTo(PlanGroup::class);
    }
}
