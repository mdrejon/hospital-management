<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <div class="flex items-center gap-3">
                <a :href="route('admin.pages.index')" class="text-gray-400 hover:text-gray-600 text-sm">← Back</a>
                <h1 class="text-lg font-semibold text-gray-800">Edit Page — {{ pageRecord.title }}</h1>
            </div>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <PageForm :form="form" :existing="pageRecord" :parent-options="parentOptions" @image-change="onImageChange" />

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
import PageForm from './PageForm.vue';

const props = defineProps({
    page:          { type: Object, required: true },
    parentOptions: { type: Array, default: () => [] },
});

const pageRecord = props.page;

const form = useForm({
    parent_id:         pageRecord.parent_id       ?? null,
    title:             pageRecord.title           ?? '',
    breadcrumb_title:  pageRecord.breadcrumb_title ?? '',
    hero_image:        null,
    content:           pageRecord.content         ?? '',
    is_active:         pageRecord.is_active       ?? true,
    sort_order:        pageRecord.sort_order      ?? 0,
    seo_title:         pageRecord.seo_title        ?? '',
    seo_description:   pageRecord.seo_description  ?? '',
    seo_keywords:      pageRecord.seo_keywords     ?? '',
    seo_og_image:      null,
});

function onImageChange({ field, file }) {
    form[field] = file;
}

function submit() {
    form.transform(data => ({ ...data, _method: 'PUT' }))
        .post(route('admin.pages.update', pageRecord.id), {
            forceFormData: true,
        });
}
</script>
