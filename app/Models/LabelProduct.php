<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_kz',
        'name_ru',
        'name_en',
        'composition_kz',
        'composition_ru',
        'composition_en',
        'barcode',
        'cert_kz',
        'cert_ru',
        'cert_en',
        'date_create_kz',
        'date_create_ru',
        'date_create_en',
        'address_kz',
        'address_ru',
        'address_en',
    ];


}
