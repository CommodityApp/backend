<?php

namespace App\Filament\Resources\ReceiptResource\RelationManagers;

use App\Models\Raw;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Component as Livewire;

class RawsRelationManager extends RelationManager
{
    protected static string $relationship = 'receiptRaws';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('raw_id')
                    ->label('Норма')
                    ->required()
                    ->options(function (Livewire $livewire, Get $get) {
                        $selectedIds = $livewire->ownerRecord->receiptRaws->pluck('raw_id');

                        return Raw::whereNotIn('id', $selectedIds)
                            ->orWhere('id', $get('raw_id'))
                            ->pluck('name', 'id');
                    })
                    ->searchable(),

                Forms\Components\TextInput::make('ratio')
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
