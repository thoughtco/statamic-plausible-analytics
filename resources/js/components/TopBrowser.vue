<template>
  <ui-card class="mt-8">
      <ui-heading size="lg">Top Browsers <span v-if="widget">(Last {{ period }})</span></ui-heading>

      <ui-table class="mt-2">
        <ui-table-columns>
            <ui-table-column>Browser</ui-table-column>
            <ui-table-column class="text-right">Visitors</ui-table-column>
        </ui-table-columns>
        <ui-table-rows>
          <ui-table-row v-for="(item, index) in items" :key="index">
              <ui-table-cell>{{ item.browser }}</ui-table-cell>
              <ui-table-cell class="text-right">{{ item.visitors }}</ui-table-cell>
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
const items = ref([]);

const fetchData = async () => {
    try {
        const res = await fetch(cp_url(`/plausible/api/top-browsers?period=${props.period}`));
        const data = await res.json();
        items.value = data;
    } catch (err) {
        console.log(err);
    }
};

watch(() => props.period, () => {
  fetchData();
}, { immediate: true });
</script>
