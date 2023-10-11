<?php

namespace App\Models;

use App\Enums\ActivitySubjectType;
use Spatie\Activitylog\Models\Activity as ModelsActivity;

class Activity extends ModelsActivity
{
    protected $casts = [
        'subject_type' => ActivitySubjectType::class,
        'properties' => 'collection',
    ];
}
