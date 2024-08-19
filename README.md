# Plausible Analytics for Statamic

A wrapper around the Plausible API that fetches the analytics into your dashboard in a pretty way.

## Setup

Install the addon.

```
composer require thoughtco/statamic-plausible-analytics
```

Then follow the steps in the config step bellow.

## Config

1. Head to your [Plausible Settings](https://plausible.io/settings).
2. Scroll down to API key and generate a new one. Name it whatever you like.
3. Copy that value into your `.env` as `PLAUSIBLE_KEY`.
4. Get your site as displayed in your Plausible Dashboard (e.g. jackwhiting.co.uk). Add that value to your `.env` as `PLAUSIBLE_SITE`.
5. Data should load.

For more customisation you can publish the config and adjust the values as you wish.

```bash
php artisan vendor:publish --tag=plausible-config
```

By default, all results from the API are cached. This can be overwritten, but I didn't want to spam to the API.

## Widgets

There are four widgets included with a few options. Periods to display be changed between `12mo,6mo,month,30d,6d,day`.

### Visitor Overview

```php
[
    'type' => 'plausible_visitor_overview',
    'period' => '30d', // Period you want to show
    'show_graph' => 0 // Boolean, 0 or 1
],
```

### Top Pages

```php
[
    'type' => 'plausible_top_pages',
    'period' => '30d'
]
```

### Top Browsers

```php
[
    'type' => 'plausible_top_browsers',
    'period' => '7d'
]
```

### Top Referrers

```php
[
    'type' => 'plausible_top_referrers',
    'period' => '7d'
]
```

## Issues

If there are any problems with getting this to work, please open an issue on GitHub. If you have any ideas/want to discuss new features please use the discussions feature :)
