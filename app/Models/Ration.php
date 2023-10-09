<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ration extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rate' => 'decimal:2',
        'concentration' => 'decimal:2',
    ];

    public function rationRaws()
    {
        return $this->hasMany(RationRaw::class)->ordered();
    }

    public function raws()
    {
        return $this->belongsToMany(Raw::class, 'ration_raws');
    }

    public function animalType()
    {
        return $this->belongsTo(AnimalType::class);
    }
}
