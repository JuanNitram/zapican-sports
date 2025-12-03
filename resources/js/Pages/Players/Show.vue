<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Badge from '@/Components/Badge.vue';
import DocumentsList from '@/Components/Common/DocumentsList.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    player: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head :title="`${player.name} - Ficha Técnica`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Ficha Técnica: {{ player.name }}
                </h2>
                <Link
                    :href="route('players')"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    ← Volver a Jugadores
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Cards de Resumen y Documentación en la parte superior -->
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <!-- Resumen -->
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Resumen
                            </h3>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Inversión Total</dt>
                                <dd class="mt-1 text-2xl font-bold text-gray-900">
                                    ${{ player.total_investment.toLocaleString() }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Documentos</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ player.documents.length }} documentos
                                </dd>
                            </div>
                        </div>
                    </div>

                        <!-- Documentos -->
                        <DocumentsList
                            :documents="player.documents"
                            title="Documentación"
                            :document-types="['Identificación', 'Contrato', 'Médico', 'Otro']"
                        />
                </div>

                <!-- Información Principal -->
                <div class="space-y-6">
                        <!-- Datos Personales -->
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">
                                    Datos Personales
                                </h3>
                            </div>
                            <div class="px-6 py-4">
                                <dl class="grid grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ player.name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ player.email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ player.phone }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ player.birth_date }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Lugar de Nacimiento</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ player.birth_place }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Nacionalidad</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ player.nationality }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Datos Deportivos -->
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">
                                    Datos Deportivos
                                </h3>
                            </div>
                            <div class="px-6 py-4">
                                <dl class="grid grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Posición</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ player.position }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Equipo Actual</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ player.team }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Altura</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ player.height }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Peso</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ player.weight }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                        <dd class="mt-1">
                                            <Badge
                                                :variant="player.status === 'activo' ? 'success' : 'danger'"
                                            >
                                                {{ player.status }}
                                            </Badge>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Historial Contractual -->
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">
                                    Historial Contractual
                                </h3>
                            </div>
                            <div class="px-6 py-4">
                                <div class="space-y-4">
                                    <div
                                        v-for="(contract, index) in player.contract_history"
                                        :key="index"
                                        class="border-l-4 border-primary pl-4 py-2"
                                    >
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ contract.club }}</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ contract.start_date }} - {{ contract.end_date }}
                                                </p>
                                            </div>
                                            <Badge
                                                :variant="contract.status === 'activo' ? 'success' : 'gray'"
                                            >
                                                {{ contract.status }}
                                            </Badge>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Inversiones -->
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">
                                    Inversiones
                                </h3>
                                <div class="text-sm text-gray-500">
                                    Total: ${{ player.total_investment.toLocaleString() }}
                                </div>
                            </div>
                            <div class="px-6 py-4">
                                <div v-if="player.investments && player.investments.length > 0" class="space-y-3">
                                    <div
                                        v-for="investment in player.investments"
                                        :key="investment.id"
                                        class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
                                    >
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-1">
                                                <p class="text-sm font-medium text-gray-900">{{ investment.description }}</p>
                                                <Badge variant="info" size="sm">
                                                    {{ investment.type }}
                                                </Badge>
                                            </div>
                                            <p class="text-xs text-gray-500">{{ investment.date }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-gray-900">
                                                ${{ investment.amount.toLocaleString() }}
                                            </p>
                                            <Badge
                                                :variant="investment.status === 'completado' ? 'success' : 'warning'"
                                                size="sm"
                                            >
                                                {{ investment.status }}
                                            </Badge>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-else
                                    class="text-center py-8 text-sm text-gray-500"
                                >
                                    No hay inversiones registradas
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

