<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabelCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function labelProducts(): HasMany
    {
        return $this->hasMany(LabelProduct::class)->select([
            'label_category_id',
            'name_kz', 'name_en', 'composition_kz', 'composition_en', 'barcode', 'cert_kz', 'cert_en', 'measure'
        ]);
    }
}
