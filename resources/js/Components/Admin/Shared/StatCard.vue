<template>
    <component :is="href ? Link : 'div'" :href="href"
        class="bg-white rounded-lg shadow-sm p-4 border transition-colors"
        :class="[colorMap.border, href ? 'hover:shadow-md cursor-pointer' : '']">
        <div class="text-2xl font-bold" :class="colorMap.text">{{ value ?? 0 }}</div>
        <div class="text-xs text-gray-400 mt-1">{{ label }}</div>
    </component>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    label: { type: String, required: true },
    value: { type: [Number, String], default: 0 },
    color: { type: String, default: 'blue' },
    href:  { type: String, default: null },
});

const COLORS = {
    blue:   { text: 'text-blue-600',   border: 'border-blue-100' },
    yellow: { text: 'text-yellow-600', border: 'border-yellow-100' },
    green:  { text: 'text-green-600',  border: 'border-green-100' },
    cyan:   { text: 'text-cyan-600',   border: 'border-cyan-100' },
    indigo: { text: 'text-indigo-600', border: 'border-indigo-100' },
    pink:   { text: 'text-pink-600',   border: 'border-pink-100' },
    purple: { text: 'text-purple-600', border: 'border-purple-100' },
    red:    { text: 'text-red-600',    border: 'border-red-100' },
};

const colorMap = computed(() => COLORS[props.color] ?? COLORS.blue);
</script>
