<template>
  <ui-card class="mt-8">
      <ui-heading size="lg">Top Referrers <span v-if="widget">(Last {{ period }})</span></ui-heading>

      <ui-table class="mt-2">
        <ui-table-columns>
            <ui-table-column>Referrer</ui-table-column>
            <ui-table-column class="text-right">Visitors</ui-table-column>
        </ui-table-columns>
        <ui-table-rows>
          <ui-table-row v-for="(referrer, index) in referrers" :key="index">
              <ui-table-cell>{{ referrer.source ? referrer.source : 'Other/Direct' }}</ui-table-cell>
              <ui-table-cell class="text-right">{{ referrer.visitors }}</ui-table-cell>
          </ui-table-row>
        </ui-table-rows>

      </ui-table>
    </ui-card>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    period: {
        type: String,
        required: true
    },
    widget: {
        type: Boolean,
        required: false,
        default: false
    }
});

const error = ref(null);
const referrers = ref([]);

const fetchData = async () => {
    try {
        const res = await fetch(cp_url(`/plausible/api/top-referrers?period=${props.period}`));
        const data = await res.json();
        referrers.value = data;
    } catch (err) {
        console.log(err);
    }
};

watch(() => props.period, () => {
  fetchData();
}, { immediate: true });
</script>
