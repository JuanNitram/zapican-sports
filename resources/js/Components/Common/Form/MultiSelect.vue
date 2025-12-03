<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },
    options: {
        type: Array,
        required: true,
    },
    placeholder: {
        type: String,
        default: 'Escribir para buscar...',
    },
    valueKey: {
        type: String,
        default: 'id',
    },
    labelKey: {
        type: String,
        default: 'name',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const inputValue = ref('');
const showDropdown = ref(false);
const highlightedIndex = ref(-1);
const inputRef = ref(null);
const dropdownRef = ref(null);
const dropdownStyle = ref({});

// Opciones ya seleccionadas
const selectedOptions = computed(() => {
    return props.options.filter(option => 
        props.modelValue.includes(option[props.valueKey])
    );
});

// Filtrar opciones basado en el input y excluir las ya seleccionadas
const filteredOptions = computed(() => {
    let available = props.options.filter(option => 
        !props.modelValue.includes(option[props.valueKey])
    );
    
    if (!inputValue.value) return available;
    
    const search = inputValue.value.toLowerCase();
    return available.filter(option => 
        option[props.labelKey].toLowerCase().includes(search)
    );
});

// Calcular posición del dropdown
const updateDropdownPosition = () => {
    if (inputRef.value) {
        const rect = inputRef.value.getBoundingClientRect();
        dropdownStyle.value = {
            position: 'fixed',
            top: `${rect.bottom}px`,
            left: `${rect.left}px`,
            width: `${rect.width}px`,
            zIndex: 9999,
        };
    }
};

// Actualizar posición cuando se muestra el dropdown
watch(showDropdown, (isShown) => {
    if (isShown) {
        updateDropdownPosition();
    }
});

// Agregar una opción
const addOption = (option) => {
    const newValue = [...props.modelValue, option[props.valueKey]];
    emit('update:modelValue', newValue);
    inputValue.value = '';
    highlightedIndex.value = -1;
    // Mantener el dropdown abierto para seguir agregando
    showDropdown.value = true;
    updateDropdownPosition();
};

// Remover una opción
const removeOption = (optionValue) => {
    const newValue = props.modelValue.filter(val => val !== optionValue);
    emit('update:modelValue', newValue);
};

// Cuando el input cambia
const handleInput = () => {
    showDropdown.value = true;
    highlightedIndex.value = -1;
};

// Cuando el input recibe focus
const handleFocus = () => {
    showDropdown.value = true;
};

// Manejar navegación con teclado
const handleKeydown = (event) => {
    if (!showDropdown.value && event.key !== 'Backspace') return;
    
    switch (event.key) {
        case 'ArrowDown':
            event.preventDefault();
            highlightedIndex.value = Math.min(
                highlightedIndex.value + 1,
                filteredOptions.value.length - 1
            );
            scrollToHighlighted();
            break;
        case 'ArrowUp':
            event.preventDefault();
            highlightedIndex.value = Math.max(highlightedIndex.value - 1, -1);
            scrollToHighlighted();
            break;
        case 'Enter':
            event.preventDefault();
            if (highlightedIndex.value >= 0 && filteredOptions.value[highlightedIndex.value]) {
                addOption(filteredOptions.value[highlightedIndex.value]);
            }
            break;
        case 'Escape':
            showDropdown.value = false;
            highlightedIndex.value = -1;
            break;
        case 'Backspace':
            if (!inputValue.value && selectedOptions.value.length > 0) {
                // Remover el último seleccionado si el input está vacío
                const lastOption = selectedOptions.value[selectedOptions.value.length - 1];
                removeOption(lastOption[props.valueKey]);
            }
            break;
    }
};

// Scroll al elemento destacado
const scrollToHighlighted = () => {
    if (highlightedIndex.value >= 0 && dropdownRef.value) {
        const highlighted = dropdownRef.value.children[highlightedIndex.value];
        if (highlighted) {
            highlighted.scrollIntoView({ block: 'nearest' });
        }
    }
};

// Click fuera del componente
const handleClickOutside = (event) => {
    if (
        inputRef.value && 
        !inputRef.value.contains(event.target) &&
        dropdownRef.value &&
        !dropdownRef.value.contains(event.target)
    ) {
        showDropdown.value = false;
    }
};

// Actualizar posición en scroll y resize
const handleScrollResize = () => {
    if (showDropdown.value) {
        updateDropdownPosition();
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
    window.addEventListener('scroll', handleScrollResize, true);
    window.addEventListener('resize', handleScrollResize);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
    window.removeEventListener('scroll', handleScrollResize, true);
    window.removeEventListener('resize', handleScrollResize);
});
</script>

<template>
    <div class="relative">
        <div 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500 bg-white border p-2 min-h-[42px]"
            :class="{ 'bg-gray-100 cursor-not-allowed': disabled }"
        >
            <div class="flex flex-wrap gap-2 items-center">
                <!-- Selected items -->
                <span
                    v-for="option in selectedOptions"
                    :key="option[valueKey]"
                    class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-primary text-white text-sm"
                >
                    {{ option[labelKey] }}
                    <button
                        v-if="!disabled"
                        type="button"
                        @click="removeOption(option[valueKey])"
                        class="hover:bg-gray-700 rounded-full p-0.5 transition-colors"
                    >
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </span>
                
                <!-- Input -->
                <input
                    ref="inputRef"
                    v-model="inputValue"
                    type="text"
                    :placeholder="selectedOptions.length === 0 ? placeholder : ''"
                    :disabled="disabled"
                    @input="handleInput"
                    @focus="handleFocus"
                    @keydown="handleKeydown"
                    class="flex-1 min-w-[120px] border-0 p-0 focus:ring-0 focus:outline-none disabled:bg-gray-100 disabled:cursor-not-allowed"
                    autocomplete="off"
                />
            </div>
        </div>
        
        <!-- Dropdown -->
        <div
            v-if="showDropdown && filteredOptions.length > 0"
            ref="dropdownRef"
            :style="dropdownStyle"
            class="mt-1 bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
        >
            <!-- Opciones filtradas -->
            <div
                v-for="(option, index) in filteredOptions"
                :key="option[valueKey]"
                @click="addOption(option)"
                @mouseenter="highlightedIndex = index"
                :class="[
                    'cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-primary hover:text-white',
                    highlightedIndex === index ? 'bg-primary text-white' : 'text-gray-900'
                ]"
            >
                {{ option[labelKey] }}
            </div>
        </div>
        
        <!-- Sin opciones disponibles -->
        <div
            v-if="showDropdown && filteredOptions.length === 0 && inputValue"
            :style="dropdownStyle"
            class="mt-1 bg-white shadow-lg rounded-md py-2 px-3 ring-1 ring-black ring-opacity-5 text-sm text-gray-500"
        >
            No se encontraron resultados
        </div>
    </div>
</template>
