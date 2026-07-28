<template>
    <div class="flex gap-1 border-b border-gray-200 mb-3">
        <button v-for="lang in languages" :key="lang.code" type="button"
            @click="$emit('update:modelValue', lang.code)"
            :class="modelValue === lang.code
                ? 'border-blue-600 text-blue-600'
                : 'border-transparent text-gray-500 hover:text-gray-700'"
            class="px-3 py-1.5 text-xs font-semibold border-b-2 transition-colors -mb-px">
            {{ lang.native_name }}
            <span v-if="lang.is_default" class="text-gray-400 font-normal">(default)</span>
        </button>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    modelValue: { type: String, required: true },
});
defineEmits(['update:modelValue']);

const page = usePage();
const languages = computed(() => page.props.languages ?? []);
</script>
