<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;
/**
 * App\Models\Basket
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property float $count
 * @property float $price
 * @property float $all_price
 * @property int $type
 * @property int $measure
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Basket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Basket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Basket query()
 * @method static \Illuminate\Database\Eloquent\Builder|Basket whereAllPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Basket whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Basket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Basket whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Basket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Basket whereMeasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Basket whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Basket wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Basket whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Basket whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Basket whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Product $product
 */

class Basket extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = ['product_id','type','price','count','all_price'];

    protected $hidden = ['created_at','updated_at','deleted_at'];


    function product():BelongsTo
    {
        return  $this->belongsTo(Product::class);
    }
    function order():BelongsTo
    {
        return  $this->belongsTo(Order::class);
    }
}
