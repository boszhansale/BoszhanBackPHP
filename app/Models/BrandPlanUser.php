<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;
/**
 * App\Models\BrandPlanUser
 *
 * @property int $id
 * @property int $brand_id
 * @property int $user_id
 * @property int $plan
 * @property float $completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Brand $brand
 * @method static \Illuminate\Database\Eloquent\Builder|BrandPlanUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BrandPlanUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BrandPlanUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|BrandPlanUser whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BrandPlanUser whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BrandPlanUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BrandPlanUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BrandPlanUser wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BrandPlanUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BrandPlanUser whereUserId($value)
 * @mixin \Eloquent
 */
class BrandPlanUser extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;


    protected $fillable = ['brand_id','user_id','plan','completed'];
    protected $hidden = ['created_at','updated_at'];

    function brand():BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
