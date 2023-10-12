<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiptResource\Pages;
use App\Models\Raw;
use App\Models\Receipt;
use App\Services\ReceiptService;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReceiptResource extends Resource
{
    protected static ?string $model = Receipt::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Рецепт';

    protected static ?string $pluralModelLabel = 'Рецепты';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('rate')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit')
                    ->maxLength(255),
                Forms\Components\TextInput::make('producer_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('concentration')
                    ->numeric()
                    ->required()
                    ->rules([
                        function (Get $get) {
                            return function (string $attribute, $value, Closure $fail) use ($get) {
                                $sum = array_sum(array_column(array_values($get('receipt_raws_for_resource')), 'ratio'));

                                if ($value != $sum) {
                                    $fail('Поле :attribute должен быть равен '.$sum);
                                }
                            };
                        },
                    ]),
                Forms\Components\Repeater::make('receipt_raws_for_resource')
                    ->schema([
                        Forms\Components\Select::make('raw_id')
                            ->label('Сырье')
                            ->searchable()
                            ->required()
                            ->getSearchResultsUsing(
                                fn (string $search, Get $get): array => Raw::where('name', 'like', "%{$search}%")
                                    ->whereNotIn(
                                        'id',
                                        array_filter(
                                            array_values(
                                                array_column($get('../../receipt_raws_for_resource'), 'raw_id')
                                            )
                                        )
                                    )
                                    ->limit(10)
                                    ->pluck('name', 'id')
                                    ->toArray()
                            )
                            ->getOptionLabelUsing(fn ($value): ?string => Raw::find($value)?->name),

                        Forms\Components\TextInput::make('ratio')
                            ->label('Норма')
                            ->numeric()
                            ->required(),
                    ])
                    ->live()
                    ->columns(2)
                    ->columnSpanFull()
                    ->grid(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rate')
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('producer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('concentration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('firstActivity.causer.name')
                    ->label('Создан кем')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создание')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('clone')
                    ->action(
                        function (Receipt $record, ReceiptService $receiptService) {
                            $new = $receiptService->replicate($record);

                            return redirect()->route('filament.admin.resources.receipts.edit', $new);
                        }
                    )
                    ->requiresConfirmation(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make('delete')
                    ->requiresConfirmation()
                    ->action(
                        function (Receipt $record, ReceiptService $receiptService) {
                            return $receiptService->delete($record);
                        }
                    )
                    ->successNotificationTitle(__('filament-actions::delete.single.notifications.deleted.title')),
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
            // RawsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReceipts::route('/'),
            'create' => Pages\CreateReceipt::route('/create'),
            'edit' => Pages\EditReceipt::route('/{record}/edit'),
        ];
    }
}
