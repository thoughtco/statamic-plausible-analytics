<?php

namespace Thoughtco\Plausible\Widgets;

use Statamic\Widgets\Widget;

class PlausibleVisitorOverview extends Widget
{
    /**
     * The HTML that should be shown in the widget.
     *
     * @return string|\Illuminate\View\View
     */
    public function html()
    {
        return view('plausible::widgets.plausible-visitor-overview', [
            'period' => $this->config('period', '7d'),
            'show_graph' => $this->config('show_graph', false),
        ]);
    }
}
