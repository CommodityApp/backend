<?php

namespace App\Models;

use App\Traits\Sortable\SortableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptRaw extends Model
{
    use HasFactory, SortableTrait;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'ratio' => 'decimal:3',
    ];

    public function raw()
    {
        return $this->belongsTo(Raw::class)->withTrashed();
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class)->withTrashed();
    }

    public function orderCalculatedRaws()
    {
        return $this->hasMany(ReceiptRaw::class, 'receipt_raw_id');
    }

    public function buildSortQuery()
    {
        return static::query()->where('receipt_id', $this->receipt_id);
    }
}
