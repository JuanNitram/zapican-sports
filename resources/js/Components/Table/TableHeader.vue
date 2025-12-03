<script setup>
import PaginationButtons from '@/Components/Table/PaginationButtons.vue';

defineProps({
    pagination: {
        type: Object,
        default: null,
    },
});
</script>

<template>
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">
                <slot name="title">Table</slot>
            </h3>
        </div>
        <div v-if="pagination">
            <PaginationButtons :prev="pagination.prev" :next="pagination.next" />
        </div>
    </div>
</template>

