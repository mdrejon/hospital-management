<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <a :href="route('admin.doctors.index')" class="text-gray-400 hover:text-gray-600 text-sm">← Back</a>
                    <h1 class="text-lg font-semibold text-gray-800">Edit Doctor — {{ displayTranslatable(doctor.name, languages) }}</h1>
                </div>
                <a v-if="doctor.slug" :href="route('doctor-details', doctor.slug)" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm border border-gray-300 rounded text-gray-600 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    View Details Page
                </a>
            </div>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <DoctorForm :form="form" :existing="doctor" :specializations="specializations" @image-change="onImageChange" />

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
import { seedTranslatable, displayTranslatable } from '@/Composables/useTranslatable';

const props = defineProps({
    doctor:          { type: Object, required: true },
    specializations: { type: Array,  default: () => [] },
});

const languages = computed(() => usePage().props.languages ?? []);
const d = props.doctor;

const dayLabels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

// Specialty/degrees/experience/awards/skills each hold a list of translatable
// entries. Seeding every entry guarantees a key per configured locale to bind
// to; a bare object tolerates rows saved before these fields took a list.
function seedTranslatableList(value) {
    if (!value) return [];
    const entries = Array.isArray(value) ? value : [value];
    return entries.map(entry => seedTranslatable(languages.value, entry));
}

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
    name:            seedTranslatable(languages.value, d.name),
    role:            seedTranslatable(languages.value, d.role),
    photo:           null,
    specialty:       seedTranslatableList(d.specialty),
    doctor_specialization_id: d.doctor_specialization_id ?? null,
    degrees:         seedTranslatableList(d.degrees),
    experience:      seedTranslatableList(d.experience),
    awards:          seedTranslatableList(d.awards),
    bio:             seedTranslatable(languages.value, d.bio),
    skills:          seedTranslatableList(d.skills),
    schedule:        Array.isArray(d.schedule)
                        ? d.schedule.map(s => ({
                            day:  seedTranslatable(languages.value, s.day),
                            time: seedTranslatable(languages.value, s.time),
                        }))
                        : [],
    consultation_fee: d.consultation_fee ?? '',
    chambers:        Array.isArray(d.chambers)
                        ? d.chambers.map(c => ({
                            name:            seedTranslatable(languages.value, c.name),
                            hospital_branch: seedTranslatable(languages.value, c.hospital_branch),
                            floor:           seedTranslatable(languages.value, c.floor),
                            room_no:         seedTranslatable(languages.value, c.room_no),
                            address:         seedTranslatable(languages.value, c.address),
                            contact_number:  seedTranslatable(languages.value, c.contact_number),
                            google_map_url:  c.google_map_url ?? '',
                            is_own_hospital: !!c.is_own_hospital,
                        }))
                        : [],
    availabilities:  seedAvailabilities(),
    leaves:          Array.isArray(d.leaves) ? d.leaves.map(l => ({ date: (l.date || '').slice(0, 10), reason: l.reason ?? '' })) : [],
    address:         seedTranslatable(languages.value, d.address),
    phone:           seedTranslatable(languages.value, d.phone),
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
