<script setup>
defineProps({
    active: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <button
        :class="[
            'inline-flex items-center gap-3 px-20 py-10 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none',
            active
                ? 'border-b-2 border-primary text-gray-900 bg-gray-50'
                : 'border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 focus:text-gray-800 focus:bg-gray-50',
        ]"
    >
        <slot name="icon" />
        <span>
            <slot />
        </span>
    </button>
</template>

