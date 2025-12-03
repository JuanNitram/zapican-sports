<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Badge from '@/Components/Badge.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    playerId: {
        type: Number,
        required: true,
    },
    investments: {
        type: Array,
        required: true,
    },
    total: {
        type: Number,
        required: true,
    },
});
</script>

<template>
    <Head title="Inversiones del Jugador" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Inversiones del Jugador
                </h2>
                <Link
                    :href="route('investments')"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    ← Volver a Inversiones
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Resumen de Inversión
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="text-3xl font-bold text-gray-900">
                            ${{ total.toLocaleString() }}
                        </div>
                        <div class="text-sm text-gray-500 mt-1">
                            Total invertido en {{ investments.length }} operaciones
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Detalle de Inversiones
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipo
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Descripción
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Monto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="investment in investments"
                                    :key="investment.id"
                                    class="hover:bg-gray-50"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ investment.type }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ investment.description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        ${{ investment.amount.toLocaleString() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ investment.date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <Badge
                                            :variant="investment.status === 'completado' ? 'success' : 'warning'"
                                        >
                                            {{ investment.status }}
                                        </Badge>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

