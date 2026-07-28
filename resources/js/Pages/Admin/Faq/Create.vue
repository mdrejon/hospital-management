<template>
    <AdminLayout>
        <div class="max-w-3xl space-y-4">
            <div class="flex items-center gap-3">
                <a :href="route('admin.faqs.index')" class="text-gray-400 hover:text-gray-600 text-sm">← Back</a>
                <h1 class="text-lg font-semibold text-gray-800">Add FAQ Group</h1>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <FaqForm :form="form" :pages="pages" />
                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Creating...' : 'Create FAQ Group' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import FaqForm     from './FaqForm.vue';
import { emptyTranslatable } from '@/Composables/useTranslatable';

const props = defineProps({
    pages: { type: Array, default: () => [] },
});

const languages = computed(() => usePage().props.languages ?? []);

const form = useForm({
    page:        'home',
    badge:       { ...emptyTranslatable(languages.value), en: "FAQ'S" },
    title:       emptyTranslatable(languages.value),
    description: emptyTranslatable(languages.value),
    image:       null,
    image_alt:   emptyTranslatable(languages.value),
    items:       [{ question: emptyTranslatable(languages.value), answer: emptyTranslatable(languages.value) }],
    sort_order:  0,
    is_active:   true,
});

function submit() {
    form.post(route('admin.faqs.store'), { forceFormData: true });
}
</script>
