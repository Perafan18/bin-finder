<?php

namespace App\Providers;

use App\Services\BinCheckService;
use App\Services\BinCodesService;
use App\Services\BinListService;
use App\Services\BinServiceInterface;
use App\Services\GreipService;
use App\Services\IinListService;
use App\Services\MultiBinService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(BinServiceInterface::class, function ($app) {
            return new MultiBinService([
                'binlist' => new BinListService(),
                'bincodes' => new BinCodesService(),
                'bincheck' => new BinCheckService(),
                'greip' => new GreipService(),
                'iinlist' => new IinListService(),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
