<?php

namespace App\Models;

use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Warranty extends Model
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
                        ->label('Warranty Name')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('duration')
                        ->numeric()
                        ->minValue(1)
                        ->required(),

                    Forms\Components\Select::make('periods')
                        ->options([
                            'week' => 'Week',
                            'month' => 'Month',
                            'year' => 'Year',
                        ])
                        ->required(),

                    Forms\Components\Textarea::make('description')
                        ->rows(5)
                        ->required()
                        ->columnSpanFull(),

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
                ->description(fn (Warranty $record): string => $record->description ? Str::limit($record->description, 60) : '')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('duration')
                ->sortable()
                ->formatStateUsing(
                    fn (string $state, Warranty $record): string => "$state " . Str::ucfirst($record->periods) . ($record->duration > 1 ? 's' : '')
                ),

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
