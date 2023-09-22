<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderCalculatedRaw;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ViewOrderCalculatedTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Order $record;

    #[Reactive]
    public int $index;

    public function render()
    {
        return view('livewire.view-order-calculated-table');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderCalculatedRaw::whereOrderId($this->record->id))
            ->columns([
                TextColumn::make('receiptRaw.raw.name'),
                TextColumn::make('receiptRaw.ratio'),
                TextColumn::make('calculated_amount.'.$this->index),
                TextColumn::make('calculated_amount_with_error.'.$this->index),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ])->paginated(false);
    }
}
