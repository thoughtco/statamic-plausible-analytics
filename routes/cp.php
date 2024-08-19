<?php

use Jackabox\Plausible\Http\Controllers\Api;
use Jackabox\Plausible\Http\Controllers\DashboardController;

Route::get('/analytics', [DashboardController::class, 'index'])->name('plausible.index');

Route::get('/plausible/api/top-pages', [Api\TopPagesController::class, 'fetch'])->name('plausible.api.top-pages');
Route::get('/plausible/api/top-referrers', [Api\TopReferrersController::class, 'fetch'])->name('plausible.api.top-referrers');
Route::get('/plausible/api/top-browsers', [Api\TopBrowsersController::class, 'fetch'])->name('plausible.api.top-browsers');
Route::get('/plausible/api/timeseries', [Api\TimeseriesController::class, 'fetch'])->name('plausible.api.timeseries');
Route::get('/plausible/api/aggregates', [Api\AggregatesController::class, 'fetch'])->name('plausible.api.aggregates');
