<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <div class="flex items-center gap-3">
                <a :href="route('admin.doctors.index')" class="text-gray-400 hover:text-gray-600 text-sm">← Back</a>
                <h1 class="text-lg font-semibold text-gray-800">Edit Doctor — {{ doctor.name }}</h1>
            </div>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <DoctorForm :form="form" :existing="doctor" @image-change="onImageChange" />

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
import DoctorForm   from './DoctorForm.vue';
import { seedTranslatable } from '@/Composables/useTranslatable';

const props = defineProps({
    doctor: { type: Object, required: true },
});

const languages = computed(() => usePage().props.languages ?? []);
const d = props.doctor;

const dayLabels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

function seedAvailabilities() {
    const existing = Array.isArray(d.availabilities) ? d.availabilities : [];
    return dayLabels.map((label, weekday) => {
        const row = existing.find(a => a.weekday === weekday);
        return row
            ? { weekday, label, is_active: !!row.is_active, start_time: (row.start_time || '09:00').slice(0, 5), end_time: (row.end_time || '17:00').slice(0, 5), slot_duration_minutes: row.slot_duration_minutes ?? 15 }
            : { weekday, label, is_active: false, start_time: '09:00', end_time: '17:00', slot_duration_minutes: 15 };
    });
}

const form = useForm({
    name:            d.name          ?? '',
    role:            seedTranslatable(languages.value, d.role),
    photo:           null,
    specialty:       seedTranslatable(languages.value, d.specialty),
    degrees:         seedTranslatable(languages.value, d.degrees),
    experience:      seedTranslatable(languages.value, d.experience),
    awards:          seedTranslatable(languages.value, d.awards),
    bio:             seedTranslatable(languages.value, d.bio),
    skills:          Array.isArray(d.skills)   ? d.skills.map(s => ({ ...s })) : [],
    schedule:        Array.isArray(d.schedule) ? d.schedule.map(s => ({ ...s })) : [],
    consultation_fee: d.consultation_fee ?? '',
    chambers:        Array.isArray(d.chambers) ? d.chambers.map(c => ({ ...c })) : [],
    availabilities:  seedAvailabilities(),
    leaves:          Array.isArray(d.leaves) ? d.leaves.map(l => ({ date: (l.date || '').slice(0, 10), reason: l.reason ?? '' })) : [],
    address:         d.address       ?? '',
    phone:           d.phone         ?? '',
    email:           d.email         ?? '',
    facebook_url:    d.facebook_url  ?? '',
    twitter_url:     d.twitter_url   ?? '',
    instagram_url:   d.instagram_url ?? '',
    linkedin_url:    d.linkedin_url  ?? '',
    youtube_url:     d.youtube_url   ?? '',
    is_featured:     d.is_featured   ?? false,
    sort_order:      d.sort_order    ?? 0,
    is_active:       d.is_active     ?? true,
    seo_title:        seedTranslatable(languages.value, d.seo_title),
    seo_description:  seedTranslatable(languages.value, d.seo_description),
    seo_keywords:      d.seo_keywords    ?? '',
    seo_og_image:      null,
});

function onImageChange({ field, file }) {
    form[field] = file;
}

function submit() {
    form.transform(data => ({ ...data, _method: 'PUT' }))
        .post(route('admin.doctors.update', d.id), {
            forceFormData: true,
        });
}
</script>
