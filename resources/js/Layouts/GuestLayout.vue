<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const site = computed(() => usePage().props.site || {});
const logoUrl = computed(() => site.value.logo ? `/storage/${site.value.logo}` : null);
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="text-center">
            <Link href="/" class="inline-block">
                <img v-if="logoUrl" :src="logoUrl" alt="Site Logo" class="h-20 w-auto mx-auto object-contain" />
                <div v-else class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold mx-auto">
                    LOGO
                </div>
            </Link>
            <h1 class="mt-4 text-2xl font-bold text-gray-900">{{ site.name || 'Site Title' }}</h1>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
