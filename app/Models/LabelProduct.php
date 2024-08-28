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
        'kz_ru_margin',
        'composition_kz',
        'composition_ru',
        'composition_en',
        'barcode',
        'cert_kz',
        'cert_en',
        'date_create_kz',
        'date_create_en',
        'date_create_package_kz',
        'date_create_package_ru',
        'date_create_package_en',
        'address_kz',
        'address_en',
        'label_category_id',
        'measure',
        'align',
        'weight_text_kz',
        'weight_text_en',
        'date_type',
        'image_url_1',
        'image_url_2',
        'image_url_3',
        'image_url_4',
    ];
    public $casts = [
        'measure' => 'string',
        'date_type' => 'string',
        'kz_ru_margin' => 'string'
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
