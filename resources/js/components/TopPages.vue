<template>
    <ui-card class="mt-8">
        <ui-heading size="lg">Top Pages <span v-if="widget">(Last {{ period }})</span></ui-heading>

        <ui-table class="mt-2">
            <ui-table-columns>
                <ui-table-column>Page</ui-table-column>
                <ui-table-column class="text-right">Visitors</ui-table-column>
            </ui-table-columns>
            <ui-table-rows>
              <ui-table-row v-for="(page, index) in pages" :key="index">
                    <ui-table-cell>{{ page.page }}</ui-table-cell>
                    <ui-table-cell class="text-right">{{ page.visitors }}</ui-table-cell>
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
const pages = ref([]);

const fetchData = async () => {
    try {
        const res = await fetch(cp_url(`/plausible/api/top-pages?period=${props.period}`));
        const data = await res.json();
        pages.value = data;
    } catch (err) {
        console.log(err);
    }
};

watch(() => props.period, () => {
  fetchData();
}, { immediate: true });
</script>
