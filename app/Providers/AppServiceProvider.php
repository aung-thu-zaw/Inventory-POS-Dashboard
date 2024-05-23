<?php

namespace App\Providers;

use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());

        Model::unguard();

        EditAction::configureUsing(fn (EditAction $action) => $action->iconButton());

        DeleteAction::configureUsing(fn (DeleteAction $action) => $action->iconButton());
    }
}
