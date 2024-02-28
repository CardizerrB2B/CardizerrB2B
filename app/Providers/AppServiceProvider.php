<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Scopes\SoftDeletingScope;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        //SoftDeletes::addGlobalScope(new SoftDeletingScope);
        \App\Models\Category::addGlobalScope(new SoftDeletingScope);
        \App\Models\SubCategory::addGlobalScope(new SoftDeletingScope);
        \App\Models\MasterFile::addGlobalScope(new SoftDeletingScope);

    }
}
