<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ProductCounteragentPrice
 *
 * @property int $id
 * @property int $product_id
 * @property int $counteragent_id
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCounteragentPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCounteragentPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCounteragentPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCounteragentPrice whereCounteragentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCounteragentPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCounteragentPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCounteragentPrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCounteragentPrice whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCounteragentPrice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductCounteragentPrice extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','counteragent_id','price'];
    protected $hidden = ['created_at','updated_at'];

    function counteragent():BelongsTo
    {
        return  $this->belongsTo(Counteragent::class);
    }

}
