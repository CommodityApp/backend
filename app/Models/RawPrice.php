<?php

namespace App\Models;

use App\Traits\Sortable\SortableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawPrice extends Model
{
    use HasFactory, SortableTrait;

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

    public function raw()
    {
        return $this->belongsTo(Raw::class);
    }
}
