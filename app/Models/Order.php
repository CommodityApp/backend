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
        'error' => 'decimal:4',
        'batch_inputs' => 'array',
        'calculated_amount' => 'array',
        'calculated_amount_with_error' => 'array',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $order) {
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

    public function orderCalculatedRaws()
    {
        return $this->hasMany(OrderCalculatedRaw::class);
    }

    public function animalType()
    {
        return $this->belongsTo(AnimalType::class);
    }
}
