<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from '@/Components/Table/Table.vue';
import Badge from '@/Components/Badge.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    contracts: {
        type: Array,
        required: true,
    },
    stats: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Contratos" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Gestión de Contratos
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">
                                Total Contratos
                            </div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">
                                {{ stats.total_contracts }}
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">
                                Contratos Activos
                            </div>
                            <div class="mt-2 text-3xl font-bold text-green-600">
                                {{ stats.active_contracts }}
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">
                                Por Vencer (30 días)
                            </div>
                            <div class="mt-2 text-3xl font-bold text-yellow-600">
                                {{ stats.expiring_soon }}
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">
                                Vencidos
                            </div>
                            <div class="mt-2 text-3xl font-bold text-red-600">
                                {{ stats.expired }}
                            </div>
                        </div>
                    </div>
                </div>

                <Table>
                    <template #title>
                        <h3 class="text-lg font-medium text-gray-900">
                            Lista de Contratos
                        </h3>
                    </template>

                    <template #header>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jugador
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Club
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha Inicio
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha Vencimiento
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Salario
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </template>

                    <tr
                        v-for="contract in contracts"
                        :key="contract.id"
                        class="hover:bg-gray-50"
                    >
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ contract.player_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ contract.club }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ contract.start_date }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ contract.end_date }}
                            <div
                                v-if="contract.days_until_expiry !== null"
                                :class="[
                                    'text-xs mt-1',
                                    contract.days_until_expiry < 0
                                        ? 'text-red-600 font-semibold'
                                        : contract.days_until_expiry <= 30
                                        ? 'text-yellow-600 font-semibold'
                                        : 'text-gray-500',
                                ]"
                            >
                                {{ contract.days_until_expiry < 0 
                                    ? `Vencido hace ${Math.abs(contract.days_until_expiry)} días`
                                    : `${contract.days_until_expiry} días restantes`
                                }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${{ contract.salary.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <Badge
                                :variant="contract.status === 'activo' ? 'success' : 'danger'"
                            >
                                {{ contract.status }}
                            </Badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <Link
                                :href="route('contracts.show', contract.id)"
                                class="text-primary hover:text-gray-900"
                            >
                                Ver Detalles
                            </Link>
                        </td>
                    </tr>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

