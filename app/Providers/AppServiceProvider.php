<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Cart;
use App\Models\{ Shop, Page };
use ConsoleTVs\Charts\Registrar as Charts;
use App\Charts\OrdersChart;
use App\Charts\UsersChart;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Run Dusk only on testing and local environment
        // if ($this->app->environment('local', 'testing')) {
        //     $this->app->register(DuskServiceProvider::class);
        // }   
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        DB::statement("SET lc_time_names = 'fr_FR'");

        View::share('shop', Shop::firstOrFail());
        View::share('pages', Page::all());

        View::composer(['layouts.app', 'products.show'], function ($view) {
            $view->with([
                'cartCount' => Cart::getTotalQuantity(), 
                'cartTotal' => Cart::getTotal(),
            ]);
        });

        View::composer('back.layout', function ($view) {
            $title = config('titles.' . Route::currentRouteName());
            $view->with(compact('title'));
        });

        Route::resourceVerbs([
            'edit' => 'modification',
            'create' => 'creation',
        ]);

        DB::statement("SET lc_time_names = 'fr_FR'");
        $charts->register([
            OrdersChart::class,
            UsersChart::class
        ]);
    }
}
