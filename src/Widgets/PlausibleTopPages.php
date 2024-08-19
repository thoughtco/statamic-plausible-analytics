<?php

namespace Thoughtco\Plausible\Widgets;

use Statamic\Widgets\Widget;

class PlausibleTopPages extends Widget
{
    /**
     * The HTML that should be shown in the widget.
     *
     * @return string|\Illuminate\View\View
     */
    public function html()
    {
        return view('plausible::widgets.plausible-top-pages', [
            'period' => $this->config('period', '7d'),
        ]);
    }
}
