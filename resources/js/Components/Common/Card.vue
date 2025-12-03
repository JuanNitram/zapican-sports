<script setup>
defineProps({
    title: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div v-if="title || $slots.header" class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 v-if="title" class="text-lg font-semibold text-gray-900">
                {{ title }}
            </h3>
            <slot v-else name="header" />
            <div v-if="title && $slots.headerActions" class="ml-4">
                <slot name="headerActions" />
            </div>
        </div>
        <div class="p-6">
            <slot />
        </div>
    </div>
</template>

