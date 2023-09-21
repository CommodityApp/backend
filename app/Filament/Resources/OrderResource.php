<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
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

                                foreach ($arr as $key => $value) {
                                    $arr[$key]['index'] = $key;
                                }

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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('amount')
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: '.',
                        thousandsSeparator: '',
                    ),

                Tables\Columns\TextColumn::make('error')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('batch_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('receipt.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('animalType.name')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrderCalculatedPage::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
