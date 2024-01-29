<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
        'weight',
        'barcode',
        'date',
        'lang'
    ];

    public function labelProduct(): BelongsTo
    {
        return $this->belongsTo(LabelProduct::class);
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d/m/Y'),
        );
    }

    //get name
    public function getName()
    {
        return $this->labelProduct->{'name_' . $this->lang};
    }

    //get composition
    public function getComposition()
    {
        return $this->labelProduct->{'composition_' . $this->lang};
    }

    //get cert
    public function getCert()
    {
        return $this->labelProduct->{'cert_' . $this->lang};
    }

    //get date_create
    public function getDateCreate()
    {
        return $this->labelProduct->{'date_create_' . $this->lang};
    }

    //get address
    public function getAddress()
    {
        return $this->labelProduct->{'address_' . $this->lang};
    }
}
