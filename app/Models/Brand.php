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
                        ->maxLength(600)
                        ->nullable()
                        ->helperText('Maximum 600 characters.'),

                    Forms\Components\FileUpload::make('logo')
                        ->label('Brand Logo')
                        ->image()
                        ->disk('public')
                        ->directory('brands')
                        ->preserveFilenames()
                        ->maxSize(1024 * 1024 * 2)
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
                ->description(fn (Brand $record): string => $record->description ? Str::limit($record->description, 60) : '-')
                ->sortable()
                ->searchable(),

            Tables\Columns\ToggleColumn::make('status'),

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
