<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $id_1c
 * @property string|null $article
 * @property int $measure
 * @property string $name
 * @property string|null $barcode
 * @property float|null $remainder
 * @property int $enabled
 * @property string|null $presale_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId1c($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMeasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePresaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRemainder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property float|null $discount
 * @property int|null $hit
 * @property int|null $new
 * @property int|null $rating
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductImage[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductPriceType[] $prices
 * @property-read int|null $prices_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRating($value)
 * @property int|null $action
 * @property int|null $discount_5
 * @property int|null $discount_10
 * @property int|null $discount_15
 * @property int|null $discount_20
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Basket[] $baskets
 * @property-read int|null $baskets_count
 * @property-read \App\Models\Category $category
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDiscount10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDiscount15($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDiscount20($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDiscount5($value)
 */
class Product extends Model
{
    use HasFactory;

    //price = BC
    //off_price = BC+
    //price_a = A
    protected $fillable = [
        'id',
        'category_id',
        'id_1c',
        'article',
        'measure',
        'name',
        'barcode',
        'remainder',
        'enabled',
        'presale_id',
        'discount',
        'hit',
        'new',
        'action',
        'discount_5',
        'discount_10',
        'discount_15',
        'discount_20',
        'rating',
    ];

    protected $hidden = ['created_at','deleted_at','updated_at'];

    function prices():HasMany
    {
        return $this->hasMany(ProductPriceType::class,'product_id');
    }

    function baskets():HasMany
    {
        return $this->hasMany(Basket::class);
    }

    function images():HasMany
    {
        return $this->hasMany(ProductImage::class,'product_id');
    }
    function category() :BelongsTo
    {
        return  $this->belongsTo(Category::class,'category_id');
    }

    function measureDescription():string
    {
        return $this->measure == 1 ? 'шт' : 'кг';
    }


}
