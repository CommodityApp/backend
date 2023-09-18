<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCalculatedRaw extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'calculated_amount' => 'array',
        'calculated_amount_with_error' => 'array',
    ];

    public function receiptRaw()
    {
        return $this->belongsTo(ReceiptRaw::class);
    }
}
