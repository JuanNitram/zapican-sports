<script setup>
import { watch } from 'vue';
import CloseIcon from '@/Components/Icons/CloseIcon.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    title: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['close']);

const maxWidthClass = {
    sm: 'sm:max-w-sm',
    md: 'sm:max-w-md',
    lg: 'sm:max-w-lg',
    xl: 'sm:max-w-xl',
    '2xl': 'sm:max-w-2xl',
    '4xl': 'sm:max-w-4xl',
    '6xl': 'sm:max-w-6xl',
}[props.maxWidth];

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

watch(
    () => props.show,
    (newValue) => {
        if (newValue) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    },
    { immediate: true }
);
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="show"
                class="fixed inset-0 z-50 overflow-y-auto"
                @click.self="close"
            >
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />

                <!-- Modal -->
                <div class="flex min-h-full items-center justify-center p-4">
                    <Transition
                        enter-active-class="ease-out duration-300"
                        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="ease-in duration-200"
                        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <div
                            v-if="show"
                            class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all w-full"
                            :class="maxWidthClass"
                            @click.stop
                        >
                            <!-- Header -->
                            <div
                                v-if="title || $slots.header"
                                class="flex items-center justify-between border-b border-gray-200 px-6 py-4"
                            >
                                <h3 v-if="title" class="text-lg font-medium text-gray-900">
                                    {{ title }}
                                </h3>
                                <slot name="header" />
                                <button
                                    v-if="closeable"
                                    @click="close"
                                    class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                                >
                                    <CloseIcon />
                                </button>
                            </div>

                            <!-- Content -->
                            <div class="px-6 py-4">
                                <slot />
                            </div>

                            <!-- Footer -->
                            <div
                                v-if="$slots.footer"
                                class="flex items-center justify-end gap-3 border-t border-gray-200 px-6 py-4"
                            >
                                <slot name="footer" />
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

