<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DriverSalesrep
 *
 * @property int $id
 * @property int $driver_id
 * @property int $salesrep_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DriverSalesrep newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DriverSalesrep newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DriverSalesrep query()
 * @method static \Illuminate\Database\Eloquent\Builder|DriverSalesrep whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriverSalesrep whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriverSalesrep whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriverSalesrep whereSalesrepId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriverSalesrep whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DriverSalesrep extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'driver_id', 'salesrep_id'];
}
