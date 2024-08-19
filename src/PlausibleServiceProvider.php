<?php

namespace Jackabox\Plausible;

use Illuminate\Support\Facades\Artisan;
use Statamic\Facades\CP\Nav;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;

class PlausibleServiceProvider extends AddonServiceProvider
{
    protected $publishAfterInstall = false;

    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    protected $scripts = [
        __DIR__.'/../dist/js/statamic-plausible.js',
    ];

    protected $widgets = [
        Widgets\PlausibleTopPages::class,
        Widgets\PlausibleTopBrowsers::class,
        Widgets\PlausibleTopReferrers::class,
        Widgets\PlausibleVisitorOverview::class,
    ];

    public function boot()
    {
        parent::boot();

        $this->createNavigation();

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'plausible');
        $this->mergeConfigFrom(__DIR__.'/../config/plausible.php', 'plausible');
        $this->publishAssets();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/plausible.php' => config_path('plausible.php'),
            ], 'plausible-config');
        }
    }

    private function createNavigation(): void
    {
        if (
            (! config('plausible.key') || ! config('plausible.site'))
            && config('app.env') === 'production'
        ) {
            return;
        }

        Nav::extend(function ($nav) {
            $nav->create('Analytics')
                ->icon('charts')
                ->section('Tools')
                ->route('plausible.index');
        });
    }

    private function publishAssets(): void
    {
        Statamic::afterInstalled(function () {
            Artisan::call('vendor:publish --tag=plausible-config');
        });
    }
}
