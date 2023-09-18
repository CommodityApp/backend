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
        return $this->belongsTo(Raw::class);
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }
}
