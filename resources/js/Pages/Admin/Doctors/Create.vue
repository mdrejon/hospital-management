<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <div class="flex items-center gap-3">
                <a :href="route('admin.doctors.index')" class="text-gray-400 hover:text-gray-600 text-sm">← Back</a>
                <h1 class="text-lg font-semibold text-gray-800">Add New Doctor</h1>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <DoctorForm :form="form" @image-change="onImageChange" />

                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Creating...' : 'Create Doctor' }}
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
import DoctorForm   from './DoctorForm.vue';
import { emptyTranslatable } from '@/Composables/useTranslatable';

const languages = computed(() => usePage().props.languages ?? []);

function defaultAvailabilities() {
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    return days.map((label, weekday) => ({
        weekday, label, is_active: false, start_time: '09:00', end_time: '17:00', slot_duration_minutes: 15,
    }));
}

const form = useForm({
    name:            '',
    role:            emptyTranslatable(languages.value),
    photo:           null,
    specialty:       emptyTranslatable(languages.value),
    degrees:         emptyTranslatable(languages.value),
    experience:      emptyTranslatable(languages.value),
    awards:          emptyTranslatable(languages.value),
    bio:             emptyTranslatable(languages.value),
    skills:          [],
    schedule:        [],
    consultation_fee: '',
    chambers:        [],
    availabilities:  defaultAvailabilities(),
    leaves:          [],
    address:         '',
    phone:           '',
    email:           '',
    facebook_url:    '',
    twitter_url:     '',
    instagram_url:   '',
    linkedin_url:    '',
    youtube_url:     '',
    is_featured:     false,
    sort_order:      0,
    is_active:       true,
    seo_title:        emptyTranslatable(languages.value),
    seo_description:  emptyTranslatable(languages.value),
    seo_keywords:     '',
    seo_og_image:     null,
});

function onImageChange({ field, file }) {
    form[field] = file;
}

function submit() {
    form.post(route('admin.doctors.store'), { forceFormData: true });
}
</script>
