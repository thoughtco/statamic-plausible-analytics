<?php

namespace Thoughtco\Plausible\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Thoughtco\Plausible\Http\Traits\FetchResultsTrait;
use Statamic\Http\Controllers\CP\CpController;

class TimeseriesController extends CpController
{
    use FetchResultsTrait;

    public function __construct()
    {
        $this->key = 'plausible_timeseries_'.config('plausible.default_period');
    }

    public function fetch(Request $request)
    {
        // Grab the period
        $period = $request->get('period') ?: '6mo';
        $this->period = $this->matchPeriodToApi($period);

        // Set the key for control of cache
        $this->key = 'plausible_timeseries_'.$this->period;

        // If we have cache, get results
        if (config('plausible.cache_enabled')) {
            return $this->getCachedResults();
        }

        // Return all others if not.
        return $this->handleResults();
    }

    public function handleResults(): array
    {
        $url = sprintf(
            '%s/api/v1/stats/timeseries?period=%s',
            config('plausible.domain'),
            $this->period
        );

        $url = $this->prepareUrl($url);
        $data = $this->fetchQuery($url);

        $data = match (Str::before($this->period, '&')) {
            'day', 'yesterday' => collect($data)->map(function ($item) {
                return [
                    'date' => Str::of($item['date'])->after(' ')->beforeLast(':'),
                    'visitors' => $item['visitors'] ?? 0,
                ];
            })->all(),
            '30d' => collect($data)->map(function ($item) {
                return [
                    'date' => Str::of($item['date'])->after('-')->beforeLast(' '),
                    'visitors' => $item['visitors'] ?? 0,
                ];
            })->all(),
            default => $data,
        };

        $results = [
            'data' => $data,
        ];

        $this->cacheResults($results);

        return $results;
    }
}
