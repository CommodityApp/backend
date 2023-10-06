<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RawPricePivot extends Pivot
{
    public $incrementing = true;

    protected static function booted(): void
    {
        static::created(function (self $rawPrice) {
            $rawPrice->raw()->update([
                'last_raw_price_id' => $rawPrice->id,
            ]);
        });
    }

    public function raw()
    {
        return $this->belongsTo(Raw::class);
    }
}
