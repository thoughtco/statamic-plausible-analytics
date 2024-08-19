<?php

namespace Jackabox\Plausible\Http\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

trait FetchResultsTrait
{
    public $key;

    public $period;

    public function prepareUrl(string $url): string
    {
        $parsed_url = parse_url($url);

        // Avoid undefined index query
        if (isset($parsed_url['query'])) {
            parse_str($parsed_url['query'], $params);
        } else {
            $params = [];
        }

        $params['site_id'] = config('plausible.site');
        $parsed_url['query'] = http_build_query($params);
        $port = isset($parsed_url['port']) ? ':'.$parsed_url['port'] : '';

        return $parsed_url['scheme'].'://'.$parsed_url['host'].$port.$parsed_url['path'].'?'.$parsed_url['query'];
    }

    public function fetchQuery(string $url)
    {
        $http = Http::withToken(config('plausible.key'))
            ->get($url);

        if (! $http->ok()) {
            return 'Not working';
        }

        $data = $http->json();

        return isset($data['results']) ? $data['results'] : $data;
    }

    public function matchPeriodToApi(string $period): string
    {
        if ($period === 'day') {
            $date = Carbon::now()->format('Y-m-d');

            return 'day&date='.$date;
        }

        if ($period === 'yesterday') {
            $date = Carbon::now()->subDays(1)->format('Y-m-d');

            return 'day&date='.$date;
        }

        return $period;
    }

    public function cacheResults($results): void
    {
        Cache::put($this->key, $results, config('plausible.cache_duration'));
    }

    public function getCachedResults()
    {
        return Cache::get($this->key, function () {
            return $this->handleResults();
        });
    }
}
