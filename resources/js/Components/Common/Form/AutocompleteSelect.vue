<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue';

const emit = defineEmits(['update:modelValue', 'update:modelName']);

const props = defineProps({
    modelValue: {
        type: [String, Number, null],
        default: null,
    },
    modelName: {
        type: String,
        default: '',
    },
    options: {
        type: Array,
        required: true,
    },
    placeholder: {
        type: String,
        default: 'Escribir o seleccionar...',
    },
    valueKey: {
        type: String,
        default: 'id',
    },
    labelKey: {
        type: String,
        default: 'name',
    },
    required: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    creatable: {
        type: Boolean,
        default: true,
    },
});

const inputValue = ref('');
const showDropdown = ref(false);
const highlightedIndex = ref(-1);
const inputRef = ref(null);
const dropdownRef = ref(null);
const dropdownStyle = ref({});

// Filtrar opciones basado en el input
const filteredOptions = computed(() => {
    if (!inputValue.value) return props.options;
    
    const search = inputValue.value.toLowerCase();
    return props.options.filter(option => 
        option[props.labelKey].toLowerCase().includes(search)
    );
});

// Verificar si hay coincidencia exacta
const hasExactMatch = computed(() => {
    if (!inputValue.value) return false;
    
    return props.options.some(option => 
        option[props.labelKey].toLowerCase() === inputValue.value.toLowerCase()
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

// Inicializar el input con el nombre del modelo si existe
watch(() => props.modelName, (newValue) => {
    if (newValue) {
        inputValue.value = newValue;
    }
}, { immediate: true });

// Cuando se selecciona un valor externo
watch(() => props.modelValue, (newValue) => {
    if (newValue) {
        const option = props.options.find(opt => opt[props.valueKey] === newValue);
        if (option) {
            inputValue.value = option[props.labelKey];
        }
    } else if (newValue === null && !props.modelName) {
        inputValue.value = '';
    }
});

// Actualizar posición cuando se muestra el dropdown
watch(showDropdown, (isShown) => {
    if (isShown) {
        updateDropdownPosition();
    }
});

// Seleccionar una opción
const selectOption = (option) => {
    inputValue.value = option[props.labelKey];
    emit('update:modelValue', option[props.valueKey]);
    emit('update:modelName', option[props.labelKey]);
    showDropdown.value = false;
    highlightedIndex.value = -1;
};

// Cuando el input cambia
const handleInput = () => {
    showDropdown.value = true;
    highlightedIndex.value = -1;
    
    // Si hay coincidencia exacta, auto-seleccionar
    const exactMatch = props.options.find(
        opt => opt[props.labelKey].toLowerCase() === inputValue.value.toLowerCase()
    );
    
    if (exactMatch) {
        // Auto-seleccionar el match exacto
        selectOption(exactMatch);
    } else if (props.creatable) {
        // Si no hay coincidencia y es creatable, será un nuevo valor
        emit('update:modelValue', null);
        emit('update:modelName', inputValue.value);
    } else {
        // Si no es creatable, no emitir nada
        emit('update:modelValue', null);
        emit('update:modelName', '');
    }
};

// Cuando el input recibe focus
const handleFocus = () => {
    showDropdown.value = true;
};

// Manejar navegación con teclado
const handleKeydown = (event) => {
    if (!showDropdown.value) return;
    
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
                selectOption(filteredOptions.value[highlightedIndex.value]);
            } else {
                showDropdown.value = false;
            }
            break;
        case 'Escape':
            showDropdown.value = false;
            highlightedIndex.value = -1;
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
        <input
            ref="inputRef"
            v-model="inputValue"
            type="text"
            :placeholder="placeholder"
            :required="required"
            :disabled="disabled"
            @input="handleInput"
            @focus="handleFocus"
            @keydown="handleKeydown"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
            autocomplete="off"
        />
        
        <!-- Dropdown -->
        <div
            v-if="showDropdown && (filteredOptions.length > 0 || inputValue)"
            ref="dropdownRef"
            :style="dropdownStyle"
            class="mt-1 bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
        >
            <!-- Opciones filtradas -->
            <div
                v-for="(option, index) in filteredOptions"
                :key="option[valueKey]"
                @click="selectOption(option)"
                @mouseenter="highlightedIndex = index"
                :class="[
                    'cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-primary hover:text-white',
                    highlightedIndex === index ? 'bg-primary text-white' : 'text-gray-900'
                ]"
            >
                {{ option[labelKey] }}
            </div>
            
            <!-- Opción de crear nuevo -->
            <div
                v-if="creatable && inputValue && !hasExactMatch"
                @click="showDropdown = false"
                class="cursor-pointer select-none relative py-2 pl-3 pr-9 text-gray-700 bg-gray-50 border-t border-gray-200 hover:bg-gray-100"
            >
                <span class="font-medium">Crear:</span> "{{ inputValue }}"
            </div>
            
            <!-- Sin resultados -->
            <div
                v-if="filteredOptions.length === 0 && !inputValue"
                class="cursor-default select-none relative py-2 pl-3 pr-9 text-gray-500"
            >
                No hay opciones disponibles
            </div>
        </div>
    </div>
</template>

