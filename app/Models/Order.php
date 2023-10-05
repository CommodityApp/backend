<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'integer',
        'price' => 'decimal:1',
        'rati' => 'decimal:1',
        'error' => 'decimal:4',
        'batch_inputs' => 'array',
        'calculated_amount' => 'array',
        'calculated_amount_with_error' => 'array',
        'date' => 'datetime:Y-m-d',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class)->withTrashed();
    }

    public function orderCalculatedRaws()
    {
        return $this->hasMany(OrderCalculatedRaw::class);
    }

    public function receiptRaws()
    {
        return $this->belongsToMany(ReceiptRaw::class, 'order_calculated_raws');
    }

    public function animalType()
    {
        return $this->belongsTo(AnimalType::class);
    }
}
