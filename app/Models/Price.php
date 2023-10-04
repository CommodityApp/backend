<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use HasFactory, SoftDeletes;

    public function priceRaws()
    {
        return $this->hasMany(RawPrice::class, 'price_id')->ordered();
    }

    public function raws()
    {
        return $this->belongsToMany(Raw::class, 'raw_prices')->using(RawPricePivot::class);
    }
}
