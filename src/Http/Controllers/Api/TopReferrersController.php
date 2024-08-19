<?php

namespace Jackabox\Plausible\Http\Controllers\Api;

use Illuminate\Http\Request;
use Jackabox\Plausible\Http\Traits\FetchResultsTrait;
use Statamic\Http\Controllers\CP\CpController;

class TopReferrersController extends CpController
{
    use FetchResultsTrait;

    public function fetch(Request $request)
    {
        // Grab the period
        $period = $request->get('period') ?: '6mo';
        $this->period = $this->matchPeriodToApi($period);

        // Set the key for control of cache
        $this->key = 'plausible_top_referrers_'.$this->period;

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
            '%s/api/v1/stats/breakdown?period=%s&limit=%d&property=visit:source&metrics=visitors',
            config('plausible.domain'),
            $this->period,
            config('plausible.results_limit', 5)
        );

        $url = $this->prepareUrl($url);

        $results = $this->fetchQuery($url);

        $this->cacheResults($results);

        return $results;
    }
}
