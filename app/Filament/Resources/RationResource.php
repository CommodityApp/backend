<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RationResource\Pages;
use App\Filament\Resources\RationResource\RelationManagers\RawsRelationManager;
use App\Models\Ration;
use App\Models\Raw;
use App\Models\Receipt;
use App\Services\RationService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RationResource extends Resource
{
    protected static ?string $model = Ration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Рацион';

    protected static ?string $pluralModelLabel = 'Рационы';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('receipt_id')
                    ->relationship(name: 'receipt', titleAttribute: 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $receiptRate = 0;

                        if ($receipt_id = $get('receipt_id')) {
                            $receiptRate = Receipt::find($receipt_id)->rate;
                        }

                        $sum = array_sum(
                            array_filter(
                                array_values(
                                    array_column($get('ration_raws_for_resource'), 'ratio')
                                )
                            )
                        );

                        return $set('rate', $receiptRate + $sum);
                    }),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit')
                    ->maxLength(255),
                Forms\Components\TextInput::make('producer_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('rate')
                    ->disabled(),
                Forms\Components\Repeater::make('ration_raws_for_resource')
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
                                                array_column($get('../../ration_raws_for_resource'), 'raw_id')
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
                    ->grid(2)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $receiptRate = 0;

                        if ($receipt_id = $get('receipt_id')) {
                            $receiptRate = Receipt::find($receipt_id)->rate;
                        }

                        $sum = array_sum(
                            array_filter(
                                array_values(
                                    array_column($get('ration_raws_for_resource'), 'ratio')
                                )
                            )
                        );

                        return $set('rate', $receiptRate + $sum);
                    }),
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
                Tables\Columns\TextColumn::make('receipt.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit')
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
                        function (Ration $record, RationService $rationService) {
                            $new = $rationService->replicate($record);

                            return redirect()->route('filament.admin.resources.rations.edit', $new);
                        }
                    )
                    ->requiresConfirmation(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make('delete')
                    ->requiresConfirmation()
                    ->action(
                        function (Ration $record, RationService $rationService) {
                            return $rationService->delete($record);
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
            'index' => Pages\ListRations::route('/'),
            'create' => Pages\CreateRation::route('/create'),
            'edit' => Pages\EditRation::route('/{record}/edit'),
        ];
    }
}
