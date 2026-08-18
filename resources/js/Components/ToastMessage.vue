<template>
    <!-- Vue3-Toastify handles its own DOM insertion, so this component acts as a listener -->
    <div class="hidden"></div>
</template>

<script setup>
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const page = usePage();

// Watch for flash messages from inertia
watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.success) {
            toast.success(flash.success, {
                position: toast.POSITION.BOTTOM_RIGHT,
                autoClose: 3000,
                theme: 'colored'
            });
        }
        if (flash?.error) {
            toast.error(flash.error, {
                position: toast.POSITION.BOTTOM_RIGHT,
                autoClose: 4000,
                theme: 'colored'
            });
        }
    },
    { deep: true, immediate: true }
);
</script>
