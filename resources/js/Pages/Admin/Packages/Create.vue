<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <div class="flex items-center gap-3">
                <a :href="route('admin.packages.index')" class="text-gray-400 hover:text-gray-600 text-sm">← Back</a>
                <h1 class="text-lg font-semibold text-gray-800">Add New Package</h1>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <PackageForm :form="form" @image-change="onImageChange" />

                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Creating...' : 'Create Package' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout   from '@/Layouts/Admin/AdminLayout.vue';
import PackageForm   from './PackageForm.vue';

const form = useForm({
    title:            '',
    image:            null,
    short_desc:       '',
    description:      '',
    features:         [],
    secondary_image:  null,
    badge_value:      '',
    badge_label:      '',
    is_featured:      false,
    sort_order:       0,
    is_active:        true,
    seo_title:        '',
    seo_description:  '',
    seo_keywords:     '',
    seo_og_image:     null,
});

function onImageChange({ field, file }) {
    form[field] = file;
}

function submit() {
    form.post(route('admin.packages.store'), { forceFormData: true });
}
</script>
