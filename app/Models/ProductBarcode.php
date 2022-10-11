<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBarcode extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','barcode'];

    protected $hidden =['created_at','updated_at'];
}
