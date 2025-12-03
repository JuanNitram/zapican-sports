<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: false,
});

defineProps({
    rows: {
        type: Number,
        default: 3,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const textarea = ref(null);

onMounted(() => {
    if (textarea.value.hasAttribute('autofocus')) {
        textarea.value.focus();
    }
});

defineExpose({ focus: () => textarea.value.focus() });
</script>

<template>
    <textarea
        v-model="model"
        ref="textarea"
        :rows="rows"
        :disabled="$props.disabled"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
    />
</template>

