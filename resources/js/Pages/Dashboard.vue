<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    stats: {
        type: Object,
        required: true,
    },
    alerts: {
        type: Array,
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
                Dashboard - Zapicán Sport Agency Group
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
                                Contratos Activos
                            </div>
                            <div class="mt-2 text-3xl font-bold text-green-600">
                                {{ stats.active_contracts }}
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">
                                Contratos por Vencer
                            </div>
                            <div class="mt-2 text-3xl font-bold text-yellow-600">
                                {{ stats.contracts_expiring_soon }}
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">
                                Inversión Total
                            </div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">
                                ${{ stats.total_investment.toLocaleString() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Alertas -->
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Alertas y Notificaciones
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div
                                    v-for="alert in alerts"
                                    :key="alert.id"
                                    :class="[
                                        'p-4 rounded-lg border-l-4',
                                        alert.priority === 'critical'
                                            ? 'bg-red-50 border-red-500'
                                            : alert.priority === 'high'
                                            ? 'bg-yellow-50 border-yellow-500'
                                            : 'bg-blue-50 border-blue-500',
                                    ]"
                                >
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <p
                                                :class="[
                                                    'text-sm font-semibold',
                                                    alert.priority === 'critical'
                                                        ? 'text-red-800'
                                                        : alert.priority === 'high'
                                                        ? 'text-yellow-800'
                                                        : 'text-blue-800',
                                                ]"
                                            >
                                                {{ alert.title }}
                                            </p>
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ alert.description }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-2">
                                                {{ alert.player_name }} - {{ alert.date }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="alerts.length === 0"
                                    class="text-sm text-gray-500 text-center py-4"
                                >
                                    No hay alertas pendientes
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Actividades Recientes
                            </h3>
                        </div>
                        <div class="p-6">
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
        </div>
    </AuthenticatedLayout>
</template>
