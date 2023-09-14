<?php

namespace App\Filament\Resources\AnimalTypeResource\Pages;

use App\Filament\Resources\AnimalTypeResource;
use Filament\Resources\Pages\Page;

class EditPage extends Page
{
    protected static string $resource = AnimalTypeResource::class;

    protected static string $view = 'filament.resources.animal-type-resource.pages.edit-page';
}
