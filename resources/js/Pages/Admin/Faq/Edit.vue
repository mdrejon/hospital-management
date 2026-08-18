<template>
    <AdminLayout>
        <div class="max-w-3xl space-y-4">
            <div class="flex items-center gap-3">
                <a :href="route('admin.faqs.index')" class="text-gray-400 hover:text-gray-600 text-sm">← Back</a>
                <h1 class="text-lg font-semibold text-gray-800">Edit FAQ Group</h1>
                <span class="px-2 py-0.5 text-xs rounded-full font-medium"
                    :class="faq.page === 'home' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700'">
                    {{ faq.page === 'home' ? 'Home Page' : 'About Page' }}
                </span>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <FaqForm :form="form" :pages="pages" :existing-image="f.image" />
                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Saving...' : 'Save Changes' }}
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
import { emptyTranslatable, seedTranslatable } from '@/Composables/useTranslatable';

const props = defineProps({
    faq:   { type: Object, required: true },
    pages: { type: Array,  default: () => [] },
});

const languages = computed(() => usePage().props.languages ?? []);
const f = props.faq;

const form = useForm({
    page:        f.page        ?? 'home',
    badge:       seedTranslatable(languages.value, f.badge),
    title:       seedTranslatable(languages.value, f.title),
    description: seedTranslatable(languages.value, f.description),
    image:       null,
    image_alt:   seedTranslatable(languages.value, f.image_alt),
    items:       Array.isArray(f.items) ? f.items.map(i => ({
        question: seedTranslatable(languages.value, i.question),
        answer: seedTranslatable(languages.value, i.answer),
    })) : [{ question: emptyTranslatable(languages.value), answer: emptyTranslatable(languages.value) }],
    sort_order:  f.sort_order  ?? 0,
    is_active:   f.is_active   ?? true,
});

function submit() {
    form.transform(data => ({ ...data, _method: 'PUT' }))
        .post(route('admin.faqs.update', f.id), { forceFormData: true });
}
</script>
