<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Price extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*']);
    }

    public function firstActivity(): MorphOne
    {
        return $this->morphOne(Activity::class, 'subject');
    }

    public function priceRaws()
    {
        return $this->hasMany(RawPrice::class, 'price_id')->ordered();
    }

    public function raws()
    {
        return $this->belongsToMany(Raw::class, 'raw_prices')->using(RawPricePivot::class);
    }
}
