<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $salesrep_id
 * @property int $driver_id
 * @property int $store_id
 * @property int $status_id
 * @property string $mobile_id
 * @property int $payment_type_id
 * @property int $payment_status_id
 * @property int|null $payment_full
 * @property int|null $payment_partial
 * @property string|null $winning_name
 * @property string|null $winning_phone
 * @property int $winning_status
 * @property int $rnk_generate
 * @property int $db_export
 * @property string|null $delivery_date
 * @property string|null $delivered_date
 * @property float|null $purchase_price
 * @property float|null $return_price
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Basket[] $baskets
 * @property-read int|null $baskets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BonusGame[] $bonusGames
 * @property-read int|null $bonus_games_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderComment[] $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\User $driver
 * @property-read \App\Models\PaymentStatus $paymentStatus
 * @property-read \App\Models\PaymentType $paymentType
 * @property-read \App\Models\OrderReport|null $report
 * @property-read \App\Models\User $salesrep
 * @property-read \App\Models\Status $status
 * @property-read \App\Models\Store $store
 * @method static \Illuminate\Database\Eloquent\Builder|Order individual()
 * @method static \Illuminate\Database\Eloquent\Builder|Order legalEntity()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order today()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDbExport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereMobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentFull($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentPartial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePurchasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReturnPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRnkGenerate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSalesrepId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWinningName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWinningPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWinningStatus($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Model  implements Auditable
{
    use HasFactory,SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'id','salesrep_id','driver_id','store_id','status_id','mobile_id',
        'payment_type_id','payment_status_id','payment_full','payment_partial',
        'winning_name','winning_phone','winning_status',
        'rnk_generate',
        'delivery_date','delivered_date',
        'purchase_price','return_price',
        'salesrep_mobile_app_version'
    ];

    protected $hidden = ['updated_at','deleted_at','rnk_generate'];

    const STATUS_READY_FOR_DELIVERY = 1;
    const STATUS_ON_DELIVERY = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_REJECT = 4;
    const STATUS_CONFIRMATION = 5;
    const STATUS_CONFIRMED = 6;

    const PAYMENT_CASH = 1;
    const PAYMENT_CARD = 2;
    const PAYMENT_DELAY = 3;
    const PAYMENT_KASPI = 4;

    // счет опланчен
    const PAYMENT_STATUS_PAID = 1;
    const PAYMENT_STATUS_NO_PAID = 2;
    const PAYMENT_STATUS_REJECT = 3;

    const PAYMENT_WINNING_STATUS_NO_PAID = 1;
    const PAYMENT_WINNING_STATUS_PAID = 2;

    const BASKET_PRODUCT_TYPE_FOR_PURCHASE = 0;
    const BASKET_PRODUCT_TYPE_FOR_RETURN = 1;


    function driver():BelongsTo
    {
        return $this->belongsTo(User::class,'driver_id');
    }
    function salesrep():BelongsTo
    {
        return $this->belongsTo(User::class,'salesrep_id');
    }
    function store():BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    function status():BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
    function paymentType():BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }
    function paymentStatus():BelongsTo
    {
        return $this->belongsTo(PaymentStatus::class);
    }
    function bonusGames():HasMany
    {
        return $this->hasMany(BonusGame::class, 'mobile_id', 'mobile_id');
    }
    function baskets():HasMany
    {
        return $this->hasMany(Basket::class);
    }
    function comments():HasMany
    {
        return $this->hasMany(OrderComment::class);
    }

    function report() :HasOne
    {
        return $this->hasOne(OrderReport::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('orders.created_at',Carbon::today());
    }
    //Физ лицо
    public function scopeIndividual($query)
    {
        return $query->join('stores','stores.id','orders.store_id')->whereNull('stores.counteragent_id');
    }
    //Юр лицо
    public function scopeLegalEntity($query)
    {
        return $query->join('stores','stores.id','orders.store_id')->whereNotNull('stores.counteragent_id');
    }




    protected function winningName(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ?? "",
        );
    }
    protected function winningPhone(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ?? "",
        );
    }
    protected function winningStatus(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ?? 1,
        );
    }
    protected function paymentStatusId(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ?? 2,
        );
    }
    protected function paymentTypeId(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ?? 1,
        );
    }
    protected function paymentFull(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ?? null,
        );
    }
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d.m.Y H:i') ,
        );
    }
    protected function deliveryDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d.m.Y'),
        );
    }
    protected function deliveredDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d.m.Y'),
        );
    }


}
