<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <div class="flex items-center gap-3">
                <a :href="route('admin.packages.index')" class="text-gray-400 hover:text-gray-600 text-sm">← Back</a>
                <h1 class="text-lg font-semibold text-gray-800">Edit Package — {{ pkg.title }}</h1>
            </div>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <PackageForm :form="form" :existing="pkg" @image-change="onImageChange" />

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
import PackageForm from './PackageForm.vue';

const props = defineProps({
    package: { type: Object, required: true },
});

const pkg = props.package;

const form = useForm({
    title:            pkg.title           ?? '',
    image:            null,
    short_desc:       pkg.short_desc      ?? '',
    description:      pkg.description     ?? '',
    features:         Array.isArray(pkg.features) ? [...pkg.features] : [],
    secondary_image:  null,
    badge_value:      pkg.badge_value     ?? '',
    badge_label:      pkg.badge_label     ?? '',
    is_featured:      pkg.is_featured     ?? false,
    sort_order:       pkg.sort_order      ?? 0,
    is_active:        pkg.is_active       ?? true,
    seo_title:        pkg.seo_title       ?? '',
    seo_description:  pkg.seo_description ?? '',
    seo_keywords:     pkg.seo_keywords    ?? '',
    seo_og_image:     null,
});

function onImageChange({ field, file }) {
    form[field] = file;
}

function submit() {
    form.transform(data => ({ ...data, _method: 'PUT' }))
        .post(route('admin.packages.update', pkg.id), {
            forceFormData: true,
        });
}
</script>
