<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Badge from '@/Components/Badge.vue';
import DocumentsList from '@/Components/Common/DocumentsList.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    contract: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head :title="`Contrato - ${contract.player_name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Detalle del Contrato
                </h2>
                <Link
                    :href="route('contracts')"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    ← Volver a Contratos
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="space-y-6">
                    <!-- Información del Contrato -->
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Información del Contrato
                            </h3>
                        </div>
                        <div class="px-6 py-4">
                            <dl class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Jugador</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ contract.player_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Club</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ contract.club }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha de Inicio</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ contract.start_date }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha de Vencimiento</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ contract.end_date }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tipo</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ contract.type }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                    <dd class="mt-1">
                                        <Badge
                                            :variant="contract.status === 'activo' ? 'success' : 'danger'"
                                        >
                                            {{ contract.status }}
                                        </Badge>
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
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Duración</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ contract.duration_days }} días</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Renovaciones</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ contract.renewal_count }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Información Financiera -->
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Información Financiera
                            </h3>
                        </div>
                        <div class="px-6 py-4">
                            <dl class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Salario Mensual</dt>
                                    <dd class="mt-1 text-lg font-bold text-gray-900">
                                        ${{ contract.salary.toLocaleString() }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Bono de Firma</dt>
                                    <dd class="mt-1 text-lg font-bold text-gray-900">
                                        ${{ contract.bonus.toLocaleString() }}
                                    </dd>
                                </div>
                                <div class="col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Cláusulas Especiales</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ contract.clauses }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Documentos del Contrato -->
                    <DocumentsList
                        :documents="contract.documents"
                        title="Documentos del Contrato"
                        upload-modal-title="Subir Documento del Contrato"
                        :document-types="['Contrato', 'Transferencia', 'Médico', 'Anexo', 'Otro']"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

