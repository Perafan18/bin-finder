<?php

namespace App\Providers;

use App\Services\Adapters\BinCheckAdapter;
use App\Services\Adapters\BinCodesAdapter;
use App\Services\Adapters\BinListAdapter;
use App\Services\Adapters\GreipAdapter;
use App\Services\Adapters\IinListAdapter;
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
                'bincodes' => new BinCodesService(new BinCodesAdapter),
                'bincheck' => new BinCheckService(new BinCheckAdapter),
                'binlist' => new BinListService(new BinListAdapter),
                'greip' => new GreipService(new GreipAdapter),
                'iinlist' => new IinListService(new IinListAdapter),
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
