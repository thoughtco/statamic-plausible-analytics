<?php

namespace Jackabox\Plausible\Http\Controllers;

use Statamic\Http\Controllers\CP\CpController;

class DashboardController extends CpController
{
    public function index()
    {
        if (! config('plausible.key') || ! config('plausible.site')) {
            return view('plausible::no-setup', [
                'title' => 'Analytics',
            ]);
        }

        return view('plausible::dashboard', [
            'title' => 'Analytics',
        ]);
    }
}
