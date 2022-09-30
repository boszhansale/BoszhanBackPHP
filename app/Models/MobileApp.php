<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\MobileApp
 *
 * @property int $id
 * @property int $status
 * @property int $type
 * @property float $version
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MobileApp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MobileApp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MobileApp query()
 * @method static \Illuminate\Database\Eloquent\Builder|MobileApp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileApp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileApp wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileApp whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileApp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileApp whereVersion($value)
 * @mixin \Eloquent
 *
 * @property string|null $comment
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MobileApp whereComment($value)
 */
class MobileApp extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'version', 'path'];

    public function typeDescription(): string
    {
        return $this->type == 1 ? 'Торговый' : 'Водительский';
    }

    public function statusDescription(): string
    {
        return match ($this->status) {
            1 => 'новая',
            2 => 'Тестируется',
            3 => 'В продакшн',
            default => '',
        };
    }

    protected function version(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (string) $value
        );
    }

    public function downloads(): HasMany
    {
        return  $this->hasMany(MobileAppDownload::class);
    }
}
