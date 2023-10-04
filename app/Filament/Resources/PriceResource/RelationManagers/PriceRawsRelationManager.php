<?php

namespace App\Filament\Resources\PriceResource\RelationManagers;

use App\Models\Raw;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PriceRawsRelationManager extends RelationManager
{
    protected static string $relationship = 'priceRaws';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required(),

                Forms\Components\Select::make('raw_id')
                    ->label('Сырье')
                    ->getSearchResultsUsing(
                        fn (string $search, RelationManager $livewire): array => Raw::where('name', 'like', "%{$search}%")
                            ->whereNotIn('id', $livewire->getOwnerRecord()->priceRaws()->pluck('raw_id'))
                            ->limit(10)
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->getOptionLabelUsing(fn ($value): ?string => Raw::find($value)?->name)
                    ->searchable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('raw.name'),
                Tables\Columns\TextColumn::make('price'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
