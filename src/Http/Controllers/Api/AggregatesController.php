<?php

namespace Jackabox\Plausible\Http\Controllers\Api;

use Illuminate\Http\Request;
use Jackabox\Plausible\Http\Traits\FetchResultsTrait;
use Statamic\Http\Controllers\CP\CpController;

class AggregatesController extends CpController
{
    use FetchResultsTrait;

    public function __construct()
    {
        $this->key = 'plausible_aggregates_'.config('plausible.default_period');
    }

    public function fetch(Request $request)
    {
        // Grab the period
        $period = $request->get('period') ?: '6mo';
        $this->period = $this->matchPeriodToApi($period);

        // Set the key for control of cache
        $this->key = 'plausible_aggregates_'.$this->period;

        // If we have cache, get results
        if (config('plausible.cache_enabled')) {
            return $this->getCachedResults();
        }

        // Return all others if not.
        return $this->handleResults();
    }

    public function handleResults()
    {
        $url = sprintf(
            '%s/api/v1/stats/aggregate?period=%s&metrics=visitors,pageviews,bounce_rate,visit_duration',
            config('plausible.domain'),
            $this->period
        );

        $url = $this->prepareUrl($url);

        $results = array_reverse($this->fetchQuery($url));

        $this->cacheResults($results);

        return $results;
    }
}
