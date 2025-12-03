<script setup>
import TableHeader from '@/Components/Table/TableHeader.vue';
import TableBody from '@/Components/Table/TableBody.vue';

defineProps({
    pagination: {
        type: Object,
        default: null,
    },
});
</script>

<template>
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <TableHeader :pagination="pagination">
            <template #title>
                <slot name="title" />
            </template>
        </TableHeader>
        
        <TableBody>
            <template #header>
                <slot name="header" />
            </template>
            <slot />
        </TableBody>
        
        <slot name="footer" />
    </div>
</template>

