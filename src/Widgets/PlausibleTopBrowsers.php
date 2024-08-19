<?php

namespace Thoughtco\Plausible\Widgets;

use Statamic\Widgets\Widget;

class PlausibleTopBrowsers extends Widget
{
    /**
     * The HTML that should be shown in the widget.
     *
     * @return string|\Illuminate\View\View
     */
    public function html()
    {
        return view('plausible::widgets.plausible-top-browsers', [
            'period' => $this->config('period', '7d'),
        ]);
    }
}
