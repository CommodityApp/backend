<?php

namespace App\Models;

use App\Traits\Sortable\SortableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RationRaw extends Model
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

    public function ration()
    {
        return $this->belongsTo(Ration::class)->withTrashed();
    }

    public function buildSortQuery()
    {
        return static::query()->where('ration_id', $this->ration_id);
    }
}
