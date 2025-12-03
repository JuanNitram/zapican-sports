<script setup>
import { Link } from '@inertiajs/vue3';
import PaginationButtons from '@/Components/Table/PaginationButtons.vue';

defineProps({
    links: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="flex justify-between items-center px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex-1 flex justify-between sm:hidden">
            <Link
                v-if="links.prev"
                :href="links.prev"
                preserve-scroll
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
                Anterior
            </Link>
            <span v-else class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                Anterior
            </span>
            
            <Link
                v-if="links.next"
                :href="links.next"
                preserve-scroll
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
                Siguiente
            </Link>
            <span v-else class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                Siguiente
            </span>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Mostrando
                    <span class="font-medium">{{ links.from }}</span>
                    a
                    <span class="font-medium">{{ links.to }}</span>
                    de
                    <span class="font-medium">{{ links.total }}</span>
                    resultados
                </p>
            </div>
            <div>
                <PaginationButtons :prev="links.prev" :next="links.next" />
            </div>
        </div>
    </div>
</template>

