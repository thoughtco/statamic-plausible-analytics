<template>
  <ui-card>
    <div class="flex justify-between p-0">
        <div
            v-for="(item, key, index) in data"
            :key="key"
            :class="{ 'border-r': index != getArrayLength }"
            class="w-1/4 p-2 -r last:border-0"
        >
            <ui-heading size="base" class="uppercase">{{ getKeyTitle(key) }}</ui-heading>
            <ui-heading size="2xl" >
                {{ item.value }}{{ getKeyEnding(key) }}
            </ui-heading>
        </div>
    </div>
  </ui-card>
</template>

<script setup>
import { ref, computed, watch } from 'vue';

const props = defineProps({
    period: {
        type: String,
        required: true
    }
});

const data = ref([]);

const getArrayLength = computed(() => {
    return Object.keys(data.value).length - 1;
});

const getKeyTitle = (key) => {
    return key.replace('_', ' ');
};

const getKeyEnding = (key) => {
    if (key === 'bounce_rate') {
        return '%';
    }
    if (key === 'visit_duration') {
        return 's';
    }
    return '';
};

const fetchData = async () => {
    try {
        const res = await fetch(cp_url(`/plausible/api/aggregates?period=${props.period}`));
        const json = await res.json();
        data.value = json;
    } catch (err) {
        console.log(err);
    }
};

watch(() => props.period, () => {
    fetchData();
}, { immediate: true });
</script>
