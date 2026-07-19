<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <div class="flex items-center gap-3">
                <a :href="route('admin.management-members.index')" class="text-gray-400 hover:text-gray-600 text-sm">← Back</a>
                <h1 class="text-lg font-semibold text-gray-800">Edit Member — {{ member.name }}</h1>
            </div>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <MemberForm :form="form" :existing="member" @image-change="onImageChange" />

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
import MemberForm   from './MemberForm.vue';

const props = defineProps({
    member: { type: Object, required: true },
});

const m = props.member;

const form = useForm({
    name:            m.name          ?? '',
    role:            m.role          ?? '',
    photo:           null,
    facebook_url:    m.facebook_url  ?? '',
    twitter_url:     m.twitter_url   ?? '',
    instagram_url:   m.instagram_url ?? '',
    linkedin_url:    m.linkedin_url  ?? '',
    youtube_url:     m.youtube_url   ?? '',
    sort_order:      m.sort_order    ?? 0,
    is_active:       m.is_active     ?? true,
});

function onImageChange({ field, file }) {
    form[field] = file;
}

function submit() {
    form.transform(data => ({ ...data, _method: 'PUT' }))
        .post(route('admin.management-members.update', m.id), {
            forceFormData: true,
        });
}
</script>
