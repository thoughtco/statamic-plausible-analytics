<template>
    <div class="p-0 mb-4 card">
        <ui-heading v-if="widget" class="p-2">Analytics (Last {{ period }})</ui-heading>

        <Aggregates :period="period" />

        <ui-card v-if="showGraph" class="mt-4" ref="chartHolder">
          <Chart
              :size="{ width: width, height: 400 }"
              :data="series"
              :direction="direction"
              :margin="margin"
          >
            <template #layers>
              <Grid strokeDasharray="2,2" />
              <Line :dataKeys="['date', 'visitors']" :lineStyle="{ stroke: 'var(--color-primary)' }" />
            </template>
          </Chart>
        </ui-card>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Chart, Grid, Line } from 'vue3-charts';
import { useElementSize } from '@vueuse/core'
import { useTemplateRef } from 'vue'

import Aggregates from './Aggregates.vue';

const props = defineProps({
    period: {
        type: String,
        required: true
    },
    widget: {
        type: Boolean,
        required: false,
        default: false
    },
    showGraph: {
        type: Boolean,
        required: false,
        default: true
    }
});

const direction = ref('horizontal')

const margin = ref({
  left: 0,
  top: 10,
  right: 10,
  bottom: 0
})

const series = ref([{
    name: "Visitors",
    data: []
}]);

const chartHolderEl = useTemplateRef('chartHolder');
const { width, height } = useElementSize(chartHolderEl);

const fetchData = async () => {
    try {
        const res = await fetch(cp_url(`/plausible/api/timeseries?period=${props.period}`));

        const data = await res.json();

        series.value = data.data;
    } catch (err) {
        console.log(err);
    }
};

watch(() => props.period, () => {
    fetchData();
}, { immediate: true });
</script>
