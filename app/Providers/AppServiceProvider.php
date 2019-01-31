<?php

namespace App\Providers;
use App\Genre;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        $genres = Genre::all();
        View::share([
            'genres'=> $genres,
            'meta_title' => 'Películas online',
            'meta_description' => '',
            'meta_claves' => '',
            ]);


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
