<?php

namespace App\Models;

use App\Traits\Sortable\SortableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AnimalType extends Model
{
    use HasFactory, LogsActivity, SortableTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*']);
    }

    public function firstActivity(): MorphOne
    {
        return $this->morphOne(Activity::class, 'subject');
    }

    public function scopeRoot(Builder $query)
    {
        $query->whereNull('parent_id')->ordered();
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->ordered();
    }

    public function nestedChildren()
    {
        return $this->children()->with('nestedChildren');
    }

    public function nestedParent()
    {
        return $this->parent()->with('nestedParent');
    }

    public static function treeView(): array
    {
        $results = self::root()->with('nestedChildren')->get();
        $array = [];

        foreach ($results as $result) {
            $array[$result->name] = $result->recursiveChildrenNames();
        }

        return $array;
    }

    public function recursiveChildrenNames(): array
    {
        $names = [];

        foreach ($this->nestedChildren as $child) {
            $names[$child->id] = $child->name;
        }

        return $names;
    }

    public function recursiveParentNames(): array
    {
        if ($parent = $this->nestedParent) {
            return [...$parent->recursiveParentNames(), ['id' => $this->id, 'name' => $this->name]];
        }

        return [['id' => $this->id, 'name' => $this->name]];
    }

    public function buildSortQuery()
    {
        return static::query()->where('parent_id', $this->parent_id);
    }
}
