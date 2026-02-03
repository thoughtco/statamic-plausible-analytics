<template>
    <div class="p-0 mb-4 card">
        <ui-heading v-if="widget" class="p-2">Analytics (Last {{ period }})</ui-heading>

        <Aggregates :period="period" />

        <div v-if="showGraph">
<!--          <vue-frappe-->
<!--              id="test"-->
<!--              :lineOptions="options"-->
<!--              type="line"-->
<!--              :height="300"-->
<!--              :colors="getGraphColor"-->
<!--              :labels="labels"-->
<!--              :dataSets="series">-->
<!--          </vue-frappe>-->
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
//import { VueFrappe } from 'vue2-frappe';
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

const options = ref({
    height: 500,
    regionFill: 1
});

const series = ref([{
    name: "Visitors",
    data: []
}]);

const labels = ref([]);

const fetchData = async () => {
    try {
        const res = await fetch(cp_url(`/plausible/api/timeseries?period=${props.period}`));
        const data = await res.json();
        labels.value = data.labels;
        series.value = [{
            name: 'Visitors',
            values: data.series
        }];
    } catch (err) {
        console.log(err);
    }
};

watch(() => props.period, () => {
    fetchData();
}, { immediate: true });
</script>
