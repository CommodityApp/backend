<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class ViewOrderCalculatedPage extends Page implements HasForms, HasInfolists
{
    use InteractsWithForms;
    use InteractsWithInfolists;

    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.resources.order-resource.pages.view-order-calculated-page';

    public Order $record;

    public int $activeTab = 0;

    public function getTitle(): string|Htmlable
    {
        return __("Заказ №{$this->record->id}");
    }

    public function updateTab(int $tab)
    {
        $this->activeTab = $tab;
    }

    public function orderInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Components\TextEntry::make('amount'),
                Components\TextEntry::make('error'),
                Components\TextEntry::make('date'),
                Components\TextEntry::make('client.name'),
                Components\TextEntry::make('receipt.name'),
                Components\TextEntry::make('animalType.name'),
            ])->columns(3);
    }
}
