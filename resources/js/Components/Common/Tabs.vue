<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    tabs: {
        type: Array,
        required: true,
        // Array format: [{ id: 'tab1', label: 'Tab 1', count: 5 }, ...]
    },
    modelValue: {
        type: String,
        default: null,
    },
});

const emit = defineEmits(['update:modelValue']);

const activeTab = computed({
    get: () => props.modelValue || props.tabs[0]?.id,
    set: (value) => emit('update:modelValue', value),
});

const selectTab = (tabId) => {
    activeTab.value = tabId;
};
</script>

<template>
    <div>
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button
                    v-for="tab in tabs"
                    :key="tab.id"
                    type="button"
                    @click="selectTab(tab.id)"
                    :class="[
                        activeTab === tab.id
                            ? 'border-indigo-500 text-indigo-600'
                            : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                        'whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors duration-150'
                    ]"
                >
                    {{ tab.label }}
                    <span
                        v-if="tab.count !== undefined"
                        :class="[
                            activeTab === tab.id
                                ? 'bg-gray-100 text-primary'
                                : 'bg-gray-100 text-gray-900',
                            'ml-2 rounded-full py-0.5 px-2.5 text-xs font-medium'
                        ]"
                    >
                        {{ tab.count }}
                    </span>
                </button>
            </nav>
        </div>
        
        <div class="mt-6">
            <slot :active-tab="activeTab" />
        </div>
    </div>
</template>

