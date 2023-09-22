<?php

namespace App\Filament\Resources\AnimalTypeResource\Pages;

use App\Filament\Resources\AnimalTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnimalType extends EditRecord
{
    protected static string $resource = AnimalTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * @return array<string>
     */
    public function getBreadcrumbs(): array
    {
        $array = [];
        $resource = static::getResource();
        $breadcrumb = $this->getBreadcrumb();

        foreach ($this->record->recursiveParentNames() as $id => $data) {
            $array[$resource::getUrl()."/{$data['id']}/edit"] = $data['name'];
        }

        return [
            $resource::getUrl() => $resource::getBreadcrumb(),
            ...$array,
            ...(filled($breadcrumb) ? [$breadcrumb] : []),
        ];
    }
}
