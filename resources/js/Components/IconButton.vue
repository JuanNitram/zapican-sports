<script setup>
defineProps({
    variant: {
        type: String,
        default: 'primary',
        validator: (value) => ['primary', 'secondary', 'danger', 'ghost'].includes(value),
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg'].includes(value),
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <button
        :disabled="disabled"
        :class="[
            'inline-flex items-center justify-center rounded-md font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed',
            {
                // Variants
                'bg-primary text-white hover:bg-gray-800 focus:ring-primary': variant === 'primary',
                'bg-gray-200 text-gray-900 hover:bg-gray-300 focus:ring-gray-500': variant === 'secondary',
                'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500': variant === 'danger',
                'bg-transparent text-gray-700 hover:bg-gray-100 focus:ring-gray-500': variant === 'ghost',
                // Sizes
                'p-1.5 text-sm': size === 'sm',
                'p-2 text-base': size === 'md',
                'p-3 text-lg': size === 'lg',
            },
        ]"
    >
        <slot />
    </button>
</template>

