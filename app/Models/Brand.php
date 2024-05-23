<?php

namespace App\Models;

use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    /**
     * @return array<mixed>
     */
    public static function getForm(): array
    {
        return [
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Brand Name')
                        ->unique(ignoreRecord: true)
                        ->required(),

                    Forms\Components\Textarea::make('description')
                        ->rows(5)
                        ->helperText('Maximum 600 characters.'),

                    Forms\Components\FileUpload::make('logo')
                        ->label('Brand Logo')
                        ->image()
                        ->disk('public')
                        ->directory('brands')
                        ->preserveFilenames()
                        ->maxSize(1024 * 1024 * 2)
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
            Tables\Columns\ImageColumn::make('logo')
                ->square(),

            Tables\Columns\TextColumn::make('name')
                ->label('Brand')
                ->description(fn (Brand $record): string => $record->description ? Str::limit($record->description, 60) : '')
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
