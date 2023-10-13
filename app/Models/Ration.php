<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Ration extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rate' => 'decimal:2',
    ];

    public function rationRawsForResource(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->rationRaws,
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*']);
    }

    public function firstActivity(): MorphOne
    {
        return $this->morphOne(Activity::class, 'subject');
    }

    public function rationRaws()
    {
        return $this->hasMany(RationRaw::class)->ordered();
    }

    public function raws()
    {
        return $this->belongsToMany(Raw::class, 'ration_raws');
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }
}
