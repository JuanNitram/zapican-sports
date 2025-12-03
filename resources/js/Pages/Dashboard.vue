<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    stats: {
        type: Object,
        required: true,
    },
    recentActivities: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Inicio" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Inicio
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">
                                Total Jugadores
                            </div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">
                                {{ stats.total_players }}
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">
                                Equipos Activos
                            </div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">
                                {{ stats.active_teams }}
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">
                                Próximos Partidos
                            </div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">
                                {{ stats.upcoming_matches }}
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">
                                Total Partidos
                            </div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">
                                {{ stats.total_matches }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Actividades Recientes
                        </h3>
                        <div class="space-y-4">
                            <div
                                v-for="activity in recentActivities"
                                :key="activity.id"
                                class="flex items-start space-x-3 pb-4 border-b border-gray-200 last:border-0"
                            >
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900">
                                        {{ activity.description }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ activity.date }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
