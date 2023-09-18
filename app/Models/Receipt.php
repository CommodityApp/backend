<?php

namespace App\Models;

use App\Traits\Sortable\SortableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory, SortableTrait;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rate' => 'decimal:2',
        'concentration' => 'decimal:2',
    ];

    public function receiptRaws()
    {
        return $this->hasMany(ReceiptRaw::class)->ordered();
    }

    public function ratio(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->receiptRaws->sum('ratio'),
        );
    }
}
