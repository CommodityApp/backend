<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\AnimalType;
use App\Services\OrderService;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('date')
                    ->required()
                    ->default(\Carbon\Carbon::now())
                    ->native(false),

                Forms\Components\Select::make('client_id')
                    ->relationship(name: 'client', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('receipt_id')
                    ->relationship(name: 'receipt', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('animal_type_id')
                    ->options(AnimalType::treeView())
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('error')
                    ->numeric()
                    ->inputMode('decimal')
                    ->required(),

                Forms\Components\TextInput::make('batch_quantity')
                    ->numeric()
                    ->live()
                    ->debounce(600)
                    ->afterStateUpdated(
                        function (Get $get, Set $set) {
                            if ($get('batch_quantity') > 0 && $get('batch_quantity') < 30) {
                                $arr = array_fill(0, intval($get('batch_quantity')), []);

                                return $set('batch_inputs', $arr);
                            } else {
                                return $set('batch_inputs', []);
                            }
                        }
                    ),

                Forms\Components\Repeater::make('batch_inputs')
                    ->simple(
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->required(),
                    )
                    ->grid(2)
                    ->maxItems(30)
                    ->addable(false)
                    ->reorderable(false)
                    ->deletable(false)
                    ->columnSpanFull(),
            ]);
    }


    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $orderService = new OrderService();

        $data['batch_inputs'] = array_map('floatval', $data['batch_inputs']);

        return $orderService->update($record, $data);
    }
}
