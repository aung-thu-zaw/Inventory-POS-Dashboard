<?php

namespace App\Models;

use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    /**
     * @return array<mixed>
     */
    public static function getForm(): array
    {
        return [
            Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Unit Name')
                        ->unique(ignoreRecord: true)
                        ->required(),

                    Forms\Components\TextInput::make('short_name')
                        ->label('Unit Short Form')
                        ->unique(ignoreRecord: true)
                        ->required(),

                    Forms\Components\Toggle::make('status')
                        ->required(),
                ]),
        ];
    }

    /**
     * @return array<mixed>
     */
    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Unit')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('short_name')
                ->label('Short Form')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('status')
                ->sortable()
                ->formatStateUsing(fn (string $state): string => $state ? 'Active' : 'Inactive')
                ->badge()
                ->icon(fn (bool $state): string => match ($state) {
                    true => 'heroicon-o-check',
                    false => 'heroicon-o-x-circle',
                })
                ->color(
                    fn (bool $state): string => match ($state) {
                        true => 'success',
                        false => 'danger',
                    },
                ),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
