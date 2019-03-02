<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\QrCodeWriterContract;
use App\Adapters\QrCodeWriterAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        QrCodeWriterContract::class => QrCodeWriterAdapter::class,
    ];
}
