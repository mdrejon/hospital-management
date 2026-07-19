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
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import DoctorForm   from './DoctorForm.vue';

const props = defineProps({
    doctor: { type: Object, required: true },
});

const d = props.doctor;

const form = useForm({
    name:            d.name          ?? '',
    role:            d.role          ?? '',
    photo:           null,
    specialty:       d.specialty     ?? '',
    degrees:         d.degrees       ?? '',
    experience:      d.experience    ?? '',
    awards:          d.awards        ?? '',
    bio:             d.bio           ?? '',
    skills:          Array.isArray(d.skills)   ? [...d.skills] : [],
    schedule:        Array.isArray(d.schedule) ? d.schedule.map(s => ({ ...s })) : [],
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
    seo_title:        d.seo_title       ?? '',
    seo_description:  d.seo_description ?? '',
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
