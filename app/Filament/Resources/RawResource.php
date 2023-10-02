<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RawResource\Pages;
use App\Filament\Resources\RawResource\RelationManagers\RawPricesRelationManager;
use App\Models\Raw;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RawResource extends Resource
{
    protected static ?string $model = Raw::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit')
                    ->maxLength(255),
                Forms\Components\TextInput::make('concentration')
                    ->maxLength(255),
                Forms\Components\TextInput::make('batch_number')
                    ->maxLength(255),

                Forms\Components\Select::make('raw_type_id')
                    ->relationship(name: 'rawType', titleAttribute: 'name')
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('country_id')
                    ->relationship(name: 'country', titleAttribute: 'name')
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('producer_id')
                    ->relationship(name: 'producer', titleAttribute: 'name')
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('bunker_id')
                    ->relationship(name: 'bunker', titleAttribute: 'name')
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rawType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('producer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bunker.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lastRawPrice.price')
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
            RawPricesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRaws::route('/'),
            'create' => Pages\CreateRaw::route('/create'),
            'view' => Pages\ViewRaw::route('/{record}'),
            'edit' => Pages\EditRaw::route('/{record}/edit'),
        ];
    }
}
