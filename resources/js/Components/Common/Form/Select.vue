<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: [String, Number, Boolean, null],
        default: null,
    },
    options: {
        type: Array,
        required: true,
    },
    placeholder: {
        type: String,
        default: 'Seleccionar...',
    },
    valueKey: {
        type: String,
        default: 'id',
    },
    labelKey: {
        type: String,
        default: 'name',
    },
    required: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const proxyValue = computed({
    get() {
        return props.modelValue;
    },
    set(val) {
        emit('update:modelValue', val);
    },
});
</script>

<template>
    <select
        v-model="proxyValue"
        :required="required"
        :disabled="disabled"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
    >
        <option v-if="placeholder && !required" :value="null">{{ placeholder }}</option>
        <option 
            v-for="option in options" 
            :key="option[valueKey]" 
            :value="option[valueKey]"
        >
            {{ option[labelKey] }}
        </option>
    </select>
</template>

