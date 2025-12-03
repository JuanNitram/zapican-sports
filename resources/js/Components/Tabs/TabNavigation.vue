<script setup>
import { Link } from '@inertiajs/vue3';
import DashboardIcon from '@/Components/Icons/DashboardIcon.vue';
import UsersIcon from '@/Components/Icons/UsersIcon.vue';

defineProps({
    currentTab: {
        type: String,
        default: 'inicio',
    },
});
</script>

<template>
    <div class="bg-white border-b border-gray-200 hidden sm:block">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-x-auto scrollbar-hide">
                <div class="flex justify-center space-x-0 min-w-max">
                <Link
                    :href="route('dashboard')"
                    :class="[
                        'inline-flex items-center gap-3 px-20 py-4 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none',
                        currentTab === 'inicio'
                            ? 'border-b-2 border-primary text-gray-900 bg-gray-50'
                            : 'border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 focus:text-gray-800 focus:bg-gray-50',
                    ]"
                >
                    <DashboardIcon />
                    <span>Inicio</span>
                </Link>

                <Link
                    :href="route('players')"
                    :class="[
                        'inline-flex items-center gap-3 px-20 py-4 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none',
                        currentTab === 'jugadores'
                            ? 'border-b-2 border-primary text-gray-900 bg-gray-50'
                            : 'border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 focus:text-gray-800 focus:bg-gray-50',
                    ]"
                >
                    <UsersIcon />
                    <span>Jugadores</span>
                </Link>

                </div>
            </div>
        </div>
    </div>
</template>

