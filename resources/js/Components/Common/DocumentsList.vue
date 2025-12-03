<script setup>
import { ref } from 'vue';
import Badge from '@/Components/Badge.vue';
import Modal from '@/Components/Common/Modal.vue';
import IconButton from '@/Components/IconButton.vue';
import PlusIcon from '@/Components/Icons/PlusIcon.vue';
import EyeIcon from '@/Components/Icons/EyeIcon.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    title: {
        type: String,
        default: 'Documentación',
    },
    documents: {
        type: Array,
        required: true,
    },
    uploadModalTitle: {
        type: String,
        default: 'Subir Documento',
    },
    documentTypes: {
        type: Array,
        default: () => ['Identificación', 'Contrato', 'Médico', 'Otro'],
    },
});

const emit = defineEmits(['upload', 'view']);

const showUploadModal = ref(false);
const showDocumentModal = ref(false);
const selectedDocument = ref(null);

const openDocument = (doc) => {
    selectedDocument.value = doc;
    showDocumentModal.value = true;
    emit('view', doc);
};

const handleUpload = () => {
    emit('upload');
    showUploadModal.value = false;
};
</script>

<template>
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">
                {{ title }}
            </h3>
            <IconButton
                @click="showUploadModal = true"
                variant="ghost"
                size="sm"
                title="Subir documento"
            >
                <PlusIcon />
            </IconButton>
        </div>
        <div class="px-6 py-4">
            <div class="space-y-2">
                <div
                    v-for="(doc, index) in documents"
                    :key="doc.id || index"
                    @click="openDocument(doc)"
                    class="flex items-center justify-between p-2 hover:bg-gray-50 rounded cursor-pointer transition-colors"
                >
                    <div class="flex items-center gap-3 flex-1">
                        <EyeIcon class="w-5 h-5 text-gray-400" />
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ doc.name }}</p>
                            <p class="text-xs text-gray-500">
                                {{ doc.type }}
                                <template v-if="doc.size"> • {{ doc.size }}</template>
                                <template v-if="doc.format"> • {{ doc.format }}</template>
                            </p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400">{{ doc.uploaded_at }}</span>
                </div>
                <div
                    v-if="documents.length === 0"
                    class="text-center py-8 text-sm text-gray-500"
                >
                    No hay documentos registrados
                </div>
            </div>
        </div>

        <!-- Modal para subir documentos -->
        <Modal
            :show="showUploadModal"
            :title="uploadModalTitle"
            max-width="md"
            @close="showUploadModal = false"
        >
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo de Documento
                    </label>
                    <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                        <option
                            v-for="type in documentTypes"
                            :key="type"
                        >
                            {{ type }}
                        </option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Documento
                    </label>
                    <input
                        type="text"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                        placeholder="Ej: DNI, Contrato 2024, etc."
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Archivo
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg
                                class="mx-auto h-12 w-12 text-gray-400"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 48 48"
                            >
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label class="relative cursor-pointer rounded-md font-medium text-primary hover:text-gray-800">
                                    <span>Subir un archivo</span>
                                    <input type="file" class="sr-only" />
                                </label>
                                <p class="pl-1">o arrastra y suelta</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, PDF hasta 10MB</p>
                        </div>
                    </div>
                </div>
            </div>
            <template #footer>
                <SecondaryButton @click="showUploadModal = false">
                    Cancelar
                </SecondaryButton>
                <PrimaryButton @click="handleUpload">
                    Subir Documento
                </PrimaryButton>
            </template>
        </Modal>

        <!-- Modal para visualizar documento -->
        <Modal
            :show="showDocumentModal"
            :title="selectedDocument?.name || 'Documento'"
            max-width="4xl"
            @close="showDocumentModal = false"
        >
            <div v-if="selectedDocument" class="space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ selectedDocument.name }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            Tipo: {{ selectedDocument.type }}
                            <template v-if="selectedDocument.size"> | Tamaño: {{ selectedDocument.size }}</template>
                            <template v-if="selectedDocument.format"> | Formato: {{ selectedDocument.format }}</template>
                            | Subido: {{ selectedDocument.uploaded_at }}
                        </p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-8 min-h-[400px] flex items-center justify-center">
                    <div class="text-center">
                        <svg
                            class="mx-auto h-24 w-24 text-gray-400 mb-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>
                        <p class="text-gray-600 font-medium">Vista Previa del Documento</p>
                        <p class="text-sm text-gray-500 mt-2">
                            {{ selectedDocument.name }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            (Vista previa mock - En producción se mostraría el documento real)
                        </p>
                    </div>
                </div>
            </div>
            <template #footer>
                <SecondaryButton @click="showDocumentModal = false">
                    Cerrar
                </SecondaryButton>
                <PrimaryButton>
                    Descargar
                </PrimaryButton>
            </template>
        </Modal>
    </div>
</template>

