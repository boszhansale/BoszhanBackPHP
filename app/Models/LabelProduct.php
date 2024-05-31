<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabelProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'weight',
        'name_kz',
        'name_en',
        'composition_kz',
        'composition_en',
        'barcode',
        'cert_kz',
        'cert_en',
        'date_create_kz',
        'date_create_en',
        'address_kz',
        'address_en',
        'label_category_id',
        'measure',
        'align'
    ];
    public $casts = [
        'measure' => 'string'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(LabelCategory::class, 'label_category_id');
    }

    public function measureDescription(): string
    {
        return $this->measure == 1 ? 'шт' : 'кг';
    }


}
