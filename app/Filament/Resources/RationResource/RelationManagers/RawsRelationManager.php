<?php

namespace App\Filament\Resources\RationResource\RelationManagers;

use App\Models\Raw;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RawsRelationManager extends RelationManager
{
    protected static string $relationship = 'rationRaws';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('raw_id')
                    ->label('Сырье')
                    ->searchable()
                    ->required()

                    ->getSearchResultsUsing(
                        fn (string $search, RelationManager $livewire): array => Raw::where('name', 'like', "%{$search}%")
                            ->whereNotIn('id', $livewire->getOwnerRecord()->rationRaws()->pluck('raw_id'))
                            ->limit(10)
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->getOptionLabelUsing(fn ($value): ?string => Raw::find($value)?->name),

                Forms\Components\TextInput::make('ratio')
                    ->label('Норма')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('raw.name'),
                Tables\Columns\TextColumn::make('ratio'),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->paginated(false)
            ->reorderable('order_column');
    }
}
