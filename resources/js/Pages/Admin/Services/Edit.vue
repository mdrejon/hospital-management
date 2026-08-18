<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <div class="flex items-center gap-3">
                <a :href="route('admin.services.index')" class="text-gray-400 hover:text-gray-600 text-sm">← Back</a>
                <h1 class="text-lg font-semibold text-gray-800">Edit Service — {{ displayTranslatable(service.title, languages) }}</h1>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <ServiceForm :form="form" :existing="service" :doctors="doctors" @image-change="onImageChange" />

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
import ServiceForm from './ServiceForm.vue';
import { seedTranslatable, displayTranslatable } from '@/Composables/useTranslatable';

const props = defineProps({
    service: { type: Object, required: true },
    doctors: { type: Array, default: () => [] },
});

const languages = computed(() => usePage().props.languages ?? []);
const s = props.service;

const form = useForm({
    title:           seedTranslatable(languages.value, s.title),
    icon_svg:        s.icon_svg       ?? '',
    image:           null,
    short_desc:      seedTranslatable(languages.value, s.short_desc),
    description:     seedTranslatable(languages.value, s.description),
    features:        Array.isArray(s.features) ? s.features.map(f => ({ ...f })) : [],
    faqs:            Array.isArray(s.faqs)     ? s.faqs.map(f => ({ question: { ...f.question }, answer: { ...f.answer } })) : [],
    doctor_ids:      Array.isArray(s.doctor_ids) ? [...s.doctor_ids] : [],
    show_doctors:    s.show_doctors    ?? false,
    is_featured:     s.is_featured    ?? false,
    sort_order:      s.sort_order     ?? 0,
    is_active:       s.is_active      ?? true,
    seo_title:        seedTranslatable(languages.value, s.seo_title),
    seo_description:  seedTranslatable(languages.value, s.seo_description),
    seo_keywords:      s.seo_keywords    ?? '',
    seo_og_image:      null,
});

function onImageChange({ field, file }) {
    form[field] = file;
}

function submit() {
    form.transform(data => ({ ...data, _method: 'PUT' }))
        .post(route('admin.services.update', s.id), {
            forceFormData: true,
        });
}
</script>
