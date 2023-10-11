<?php

namespace App\Models;

use App\Traits\Sortable\SortableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RawPrice extends Model
{
    use HasFactory, LogsActivity, SortableTrait;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (self $rawPrice) {
            $rawPrice->raw()->update([
                'last_raw_price_id' => $rawPrice->id,
            ]);
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*']);
    }

    public function firstActivity(): MorphOne
    {
        return $this->morphOne(Activity::class, 'subject');
    }

    public function raw()
    {
        return $this->belongsTo(Raw::class);
    }
}
