<template>
    <div>

          <ui-header
              icon="chart-monitoring-indicator"
              :title="__('Analytics')"
          >
            <div class="flex items-center justify-between mb-3">

                <div class="flex items-center">
                    <ui-label :text="__('Range:')" class="mr-2" />

                    <ui-select
                        v-model="range" class="bg-white p-1 rounded-lg"
                        :options="[
                          { label: 'Today', value: 'day' },
                          { label: 'Yesterday', value: 'yesterday' },
                          { label: '7 Days', value: '7d' },
                          { label: '30 Days', value: '30d' },
                          { label: '6 Months', value: '6mo' },
                          { label: '12 Months', value: '12mo' }

                      ]"
                    />
                </div>
            </div>
          </ui-header>

        <VisitorOverview :period="range" />

        <TopPages :period="range" />

        <div class="flex -mx-2 mt-3">
            <TopReferrers class="mx-2 w-1/2" :period="range" />
            <TopBrowser class="mx-2 w-1/2" :period="range" />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import TopBrowser from "./TopBrowser.vue";
import TopReferrers from "./TopReferrers.vue";
import TopPages from "./TopPages.vue";
import VisitorOverview from "./VisitorOverview.vue";

const range = ref('7d');
</script>
