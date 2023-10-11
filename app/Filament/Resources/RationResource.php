<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RationResource\Pages;
use App\Filament\Resources\RationResource\RelationManagers\RawsRelationManager;
use App\Models\Ration;
use App\Services\RationService;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

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
                    ->rules([
                        function (?Model $record) {
                            return function (string $attribute, $value, Closure $fail) use ($record) {
                                if ($record) {
                                    $sum = $record->rationRaws()->sum('ratio');
                                    if ($value < $sum) {
                                        $fail('Поле :attribute должен быть равен '.$sum);
                                    }
                                }
                            };
                        },
                    ]),
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
            RawsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRations::route('/'),
            'create' => Pages\CreateRation::route('/create'),
            'view' => Pages\ViewRation::route('/{record}'),
            'edit' => Pages\EditRation::route('/{record}/edit'),
        ];
    }
}
