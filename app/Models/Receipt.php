<?php

namespace App\Models;

use App\Traits\Sortable\SortableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Receipt extends Model
{
    use HasFactory, LogsActivity, SoftDeletes, SortableTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*']);
    }

    public function firstActivity(): MorphOne
    {
        return $this->morphOne(Activity::class, 'subject');
    }

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

    public function receiptRawsForResource(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->receiptRaws,
        );
    }

    public function ratio(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->receiptRaws->sum('ratio'),
        );
    }

    public function raws()
    {
        return $this->belongsToMany(Raw::class, 'receipt_raws');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function animalType()
    {
        return $this->belongsTo(AnimalType::class);
    }
}
