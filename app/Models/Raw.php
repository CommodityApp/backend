<?php

namespace App\Models;

use App\Traits\Sortable\SortableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Raw extends Model
{
    use HasFactory, LogsActivity, SoftDeletes, SortableTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*']);
    }

    public function firstActivity(): MorphOne
    {
        return $this->morphOne(Activity::class, 'subject');
    }

    public function rawPrices()
    {
        return $this->hasMany(RawPrice::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function bunker()
    {
        return $this->belongsTo(Bunker::class);
    }

    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }

    public function rawType()
    {
        return $this->belongsTo(RawType::class);
    }

    public function lastRawPrice()
    {
        return $this->belongsTo(RawPrice::class, 'last_raw_price_id');
    }
}
