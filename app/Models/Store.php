<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Store
 *
 * @property int $id
 * @property int $salesrep_id
 * @property int|null $counteragent_id
 * @property string $name
 * @property string $phone
 * @property string|null $bin
 * @property string|null $id_1c
 * @property int|null $district_id
 * @property string $address
 * @property string|null $lat
 * @property string|null $lng
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store query()
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereBin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCounteragentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereId1c($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereSalesrepId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property float|null $discount
 * @property-read \App\Models\Counteragent|null $counteragent
 * @property-read \App\Models\User $salesrep
 * @method static \Illuminate\Database\Query\Builder|Store onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDiscount($value)
 * @method static \Illuminate\Database\Query\Builder|Store withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Store withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property int|null $driver_id
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDriverId($value)
 */

class Store extends Model implements Auditable
{
    use HasFactory,SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'id',
        'salesrep_id',
        'counteragent_id',
        'name',
        'phone',
        'bin',
        'id_1c',
        'district_id',
        'address',
        'lat',
        'lng',
        'discount',
        'created_at',
    ];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    function counteragent():BelongsTo
    {
        return  $this->belongsTo(Counteragent::class);
    }
    function salesrep():BelongsTo
    {
        return $this->belongsTo(User::class,'salesrep_id');
    }
    function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }
//
//    protected function id_1c(): Attribute
//    {
//        return Attribute::make(
//            set: fn ($value) => 300000000100000 + $this->id,
//        );
//    }

    //300000000100113

}
