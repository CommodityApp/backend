<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ActivityResource;
use App\Models\Activity;
use Spatie\QueryBuilder\QueryBuilder;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = QueryBuilder::for(Activity::class)
            ->allowedFilters('description', 'subject_type')
            ->allowedSorts('id', 'created_at')
            ->allowedIncludes('causer', 'subject')
            ->paginate(request()->input('per_page', 15));

        return ActivityResource::collection($activities);
    }

    public function show(Activity $activity)
    {
        return new ActivityResource($activity->load('causer'));
    }
}
