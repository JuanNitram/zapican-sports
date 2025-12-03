<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    prev: {
        type: String,
        default: null,
    },
    next: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
        <Link
            v-if="prev"
            :href="prev"
            preserve-scroll
            class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
        >
            Anterior
        </Link>
        <span
            v-else
            class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed"
        >
            Anterior
        </span>

        <Link
            v-if="next"
            :href="next"
            preserve-scroll
            class="relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
        >
            Siguiente
        </Link>
        <span
            v-else
            class="relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed"
        >
            Siguiente
        </span>
    </nav>
</template>

