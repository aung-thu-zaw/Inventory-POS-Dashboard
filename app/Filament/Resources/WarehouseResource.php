<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseResource\Pages;
use App\Filament\Resources\WarehouseResource\RelationManagers;
use App\Models\City;
use App\Models\Province;
use App\Models\Warehouse;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Warehouse::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(Warehouse::getTableColumns())
            ->defaultSort("id", "desc")
            ->filters([
                SelectFilter::make('country_id')
                    ->label("Country")
                    ->relationship("country", "name")
                    ->searchable()
                    ->preload(),

                SelectFilter::make('province_id')
                    ->label("Province")
                    ->relationship("province", "name")
                    ->searchable()
                    ->preload(),

                SelectFilter::make('city_id')
                    ->label("City")
                    ->relationship("city", "name")
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->options([
                        true => 'Active',
                        false => 'Inactive',
                ]),
            ], layout: FiltersLayout::AboveContent)
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWarehouses::route('/'),
        ];
    }
}
