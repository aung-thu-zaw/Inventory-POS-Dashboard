<?php

namespace App\Models;

use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category,Category>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Category>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }

    /**
     * @return array<mixed>
     */
    public static function getForm(): array
    {
        return [
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\Select::make("parent_id")
                        ->label("Parent Category")
                        ->relationship('parent', 'name')
                        ->exists('categories', 'id')
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->default(null),

                    Forms\Components\TextInput::make('name')
                        ->label('Category Name')
                        ->unique(ignoreRecord: true)
                        ->required(),

                    Forms\Components\Textarea::make('description')
                        ->rows(5)
                        ->maxLength(600)
                        ->nullable()
                        ->helperText('Maximum 600 characters.'),

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
            Tables\Columns\TextColumn::make('parent.name')
                ->label('Parent Category')
                ->default('-')
                ->numeric()
                ->sortable(),

            Tables\Columns\TextColumn::make('name')
                ->label('Category')
                ->description(fn (Category $record): string => $record->description ? Str::limit($record->description, 60) : '')
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
