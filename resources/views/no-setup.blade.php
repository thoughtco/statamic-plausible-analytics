@extends('statamic::layout')

@section('content')
    <ui-header
       icon="chart-monitoring-indicator"
       title="{{ __('Analytics') }}"
    />

    <ui-card>
        <ui-heading size="lg">Setup required</ui-heading>

        <ui-description>

            Double check the following to make sure everything is set up correctly.<br /><br />

            <ol class="mb-2 pl-3">
                <li class="mb-1">1. Have you set up your <a href="https://plausible.io/settings">API key</a>?</li>
                <li class="mb-1">2. Have you set up your site in Plausible?</li>
                <li class="mb-1">3. Have you added <pre class="inline">PLAUSIBLE_KEY</pre> to your `.env` file?</li>
                <li class="mb-1">4. Have you added <pre class="inline">PLAUSIBLE_SITE</pre> to your `.env` file?</li>
            </ol>

        </ui-description>
    </ui-card>

@endsection
