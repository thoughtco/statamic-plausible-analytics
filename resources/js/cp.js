import Dashboard from './components/Dashboard.vue';
import TopPages from './components/TopPages.vue';
import TopBrowser from './components/TopBrowser.vue';
import TopReferrers from './components/TopReferrers.vue';
import VisitorOverview from './components/VisitorOverview.vue';

Statamic.booting(() => {
    Statamic.$components.register('plausible-dashboard', Dashboard);
    Statamic.$components.register('plausible-top-pages', TopPages);
    Statamic.$components.register('plausible-top-browsers', TopBrowser);
    Statamic.$components.register('plausible-top-referrers', TopReferrers);
    Statamic.$components.register('plausible-visitor-overview', VisitorOverview);
});
