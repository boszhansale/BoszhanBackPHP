<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\PlanGroupBrand
 *
 * @property int $id
 * @property int $plan_group_id
 * @property int $brand_id
 * @property int $plan
 * @property float $completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Brand $brand
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupBrand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupBrand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupBrand query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupBrand whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupBrand whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupBrand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupBrand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupBrand wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupBrand wherePlanGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanGroupBrand whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PlanGroupBrand extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['plan_group_id', 'brand_id', 'plan', 'completed'];

    protected $hidden = ['created_at', 'updated_at'];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
