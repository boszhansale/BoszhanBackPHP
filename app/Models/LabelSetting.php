<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelSetting extends Model
{
    use HasFactory;

    protected $table = 'label_setting';
    public $timestamps = false;
    protected $fillable = [
        'cert_kz',
        'cert_en',
        'date_create_kz',
        'date_create_en',
        'date_create_ab',
        'date_create_package_kz',
        'date_create_package_ru',
        'date_create_package_en',
        'address_kz',
        'address_en',
        'weight_text_kz',
        'weight_text_en',
        'weight_text_ab',
        'image_url_1',
        'image_url_2',
        'image_url_3',
        'image_url_4',
    ];


}
