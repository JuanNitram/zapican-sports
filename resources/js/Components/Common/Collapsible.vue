<script setup>
import { ref } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    defaultOpen: {
        type: Boolean,
        default: true,
    },
});

const isOpen = ref(props.defaultOpen);

const toggle = () => {
    isOpen.value = !isOpen.value;
};
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div 
            class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center cursor-pointer hover:bg-gray-100 transition-colors"
            @click="toggle"
        >
            <h3 class="text-lg font-semibold text-gray-900">
                {{ title }}
            </h3>
            <svg 
                :class="{ 'rotate-180': isOpen }"
                class="w-5 h-5 text-gray-500 transition-transform duration-200"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
        <div 
            v-show="isOpen"
            class="p-6"
        >
            <slot />
        </div>
    </div>
</template>

