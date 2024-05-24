<?php

namespace App\Models;

use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warehouse extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Country,Warehouse>
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Province,Warehouse>
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<City,Warehouse>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return array<mixed>
     */
    public static function getForm(): array
    {
        return [
            Forms\Components\Section::make()
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Warehouse')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\Select::make('country_id')
                        ->relationship('country', 'name')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('province_id', null))
                        ->afterStateUpdated(fn (Set $set) => $set('city_id', null))
                        ->required(),

                    Forms\Components\Select::make('province_id')
                        ->relationship('province', 'name')
                        ->options(fn (Get $get) => Province::where('country_id', (int) $get('country_id'))->orderBy('name')->pluck('name', 'id'))
                        ->required()
                        // ->searchable()
                        // ->preload()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('city_id', null))
                        ->disabled(fn (Get $get): bool => $get('country_id') ? false : true),

                    Forms\Components\Select::make('city_id')
                        ->relationship('city', 'name')
                        ->options(fn (Get $get) => City::where('province_id', (int) $get('province_id'))->orderBy('name')->pluck('name', 'id'))
                        // ->searchable()
                        // ->preload()
                        ->required()
                        ->live()
                        ->disabled(fn (Get $get): bool => $get('country_id') && $get('province_id') ? false : true),

                    Forms\Components\TextInput::make('zip_code')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('address')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('contact_person')
                        ->required(),

                    Forms\Components\TextInput::make('contact_email')
                        ->email()
                        ->unique(ignoreRecord: true)
                        ->required(),

                    Forms\Components\TextInput::make('contact_phone')
                        ->tel()
                        ->unique(ignoreRecord: true)
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
                ->label('Warehouse')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('country.name')
                ->numeric()
                ->sortable(),

            Tables\Columns\TextColumn::make('province.name')
                ->numeric()
                ->sortable(),

            Tables\Columns\TextColumn::make('city.name')
                ->numeric()
                ->sortable(),

            Tables\Columns\TextColumn::make('address')
                ->sortable(),

            Tables\Columns\TextColumn::make('zip_code')
                ->sortable(),

            Tables\Columns\TextColumn::make('contact_person')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('contact_email')
                ->sortable(),

            Tables\Columns\TextColumn::make('contact_phone')
                ->sortable(),

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
