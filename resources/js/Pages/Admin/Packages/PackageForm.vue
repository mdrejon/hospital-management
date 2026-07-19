<template>
    <div class="space-y-6">

        <!-- ── Basic Info ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Basic Information</h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label">Package Title <span class="text-red-500">*</span></label>
                    <input v-model="form.title" type="text" class="input" placeholder="e.g. Full Body Checkup" />
                    <InputError :message="form.errors.title" />
                </div>
                <div>
                    <label class="label">URL Slug <span class="text-gray-400 font-normal text-xs">(auto-generated)</span></label>
                    <div class="flex items-center gap-2">
                        <input :value="slugPreview" type="text" class="input bg-gray-50 text-gray-500 cursor-not-allowed" readonly />
                        <span class="text-xs text-gray-400 whitespace-nowrap">/packages/{{ slugPreview || '…' }}</span>
                    </div>
                </div>
                <div>
                    <label class="label">Sort Order</label>
                    <input v-model.number="form.sort_order" type="number" min="0" class="input" />
                    <InputError :message="form.errors.sort_order" />
                </div>
                <div class="flex items-end gap-6 pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input v-model="form.is_active" type="checkbox" class="w-4 h-4 rounded text-blue-600" />
                        <span class="text-sm text-gray-600">Active</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input v-model="form.is_featured" type="checkbox" class="w-4 h-4 rounded text-yellow-500" />
                        <span class="text-sm text-gray-600">Featured on Home Page</span>
                    </label>
                </div>
            </div>
        </section>

        <!-- ── Main Image ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Card Image (Listing &amp; Home Page)</h2>
            <DropZone @change="file => onFile(file, 'image')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-44 object-cover"
                :existing-preview="existing?.image ? '/storage/' + existing.image : null" />
            <InputError :message="form.errors.image" />

            <div>
                <label class="label">Short Description <span class="text-xs text-gray-400">(shown on card)</span></label>
                <textarea v-model="form.short_desc" rows="3" class="input resize-none"
                    placeholder="e.g. Comprehensive screening to catch health issues early."></textarea>
                <InputError :message="form.errors.short_desc" />
            </div>
        </section>

        <!-- ── Detail Page Content ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Detail Page — Description</h2>
            <div>
                <label class="label">Full Description <span class="text-xs text-gray-400">(rich text, detail page)</span></label>
                <RichEditor v-model="form.description" />
                <InputError :message="form.errors.description" />
            </div>
        </section>

        <!-- ── Secondary Image + Experience Badge ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Detail Page — Secondary Image &amp; Experience Badge</h2>
            <DropZone @change="file => onFile(file, 'secondary_image')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-44 object-cover"
                :existing-preview="existing?.secondary_image ? '/storage/' + existing.secondary_image : null" />
            <InputError :message="form.errors.secondary_image" />
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label">Badge Value <span class="text-xs text-gray-400">(e.g. "28+")</span></label>
                    <input v-model="form.badge_value" type="text" class="input" placeholder="28+" />
                    <InputError :message="form.errors.badge_value" />
                </div>
                <div>
                    <label class="label">Badge Label <span class="text-xs text-gray-400">(e.g. "Years")</span></label>
                    <input v-model="form.badge_label" type="text" class="input" placeholder="Years" />
                    <InputError :message="form.errors.badge_label" />
                </div>
            </div>
        </section>

        <!-- ── Features Checklist ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-3">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Detail Page — Features Checklist</h2>
            <div v-for="(item, i) in form.features" :key="i" class="flex gap-2">
                <input v-model="form.features[i]" type="text" class="input"
                    placeholder="e.g. Monthly Checkups Medical Service" />
                <button type="button" @click="form.features.splice(i, 1)"
                    class="px-3 py-2 text-red-500 hover:bg-red-50 rounded text-sm flex-shrink-0">✕</button>
            </div>
            <button type="button" @click="form.features.push('')"
                class="text-sm text-blue-600 hover:underline">+ Add Feature</button>
        </section>

        <!-- ── SEO ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">SEO Configuration <span class="text-xs font-normal text-gray-400">(package detail page)</span></h2>
            <div>
                <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars, auto-filled if left blank)</span></label>
                <input v-model="form.seo_title" @input="onMetaTitleInput" type="text" class="input" placeholder="e.g. Full Body Checkup | ClinicMaster" maxlength="160" />
                <p class="text-xs text-gray-400 mt-1">{{ (form.seo_title || '').length }}/160</p>
                <InputError :message="form.errors.seo_title" />
            </div>
            <div>
                <label class="label">Meta Description <span class="text-xs text-gray-400">(max 320 chars)</span></label>
                <textarea v-model="form.seo_description" @input="onMetaDescInput" rows="3" class="input resize-none" maxlength="320"></textarea>
                <p class="text-xs text-gray-400 mt-1">{{ (form.seo_description || '').length }}/320</p>
                <InputError :message="form.errors.seo_description" />
            </div>
            <div>
                <label class="label">Meta Keywords <span class="text-xs text-gray-400">(comma-separated, auto-filled if left blank)</span></label>
                <input v-model="form.seo_keywords" @input="onMetaKeywordsInput" type="text" class="input" />
                <InputError :message="form.errors.seo_keywords" />
            </div>
            <div>
                <label class="label">OG / Social Share Image <span class="text-xs text-gray-400">(recommended 1200×630px)</span></label>
                <DropZone @change="file => onFile(file, 'seo_og_image')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-36 object-cover"
                    :existing-preview="existing?.seo_og_image ? '/storage/' + existing.seo_og_image : null" />
                <InputError :message="form.errors.seo_og_image" />
            </div>
        </section>

    </div>
</template>

<script setup>
import { computed } from 'vue';
import InputError from '@/Components/InputError.vue';
import RichEditor from '@/Components/Admin/Shared/RichEditor.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import { useSeoAutoFill } from '@/Composables/useSeoAutoFill';

const props = defineProps({
    form:     { type: Object, required: true },
    existing: { type: Object, default: null },
});

const emit = defineEmits(['image-change']);

const { onMetaTitleInput, onMetaDescInput, onMetaKeywordsInput } = useSeoAutoFill(props.form, {
    titleSource: () => props.form.title,
    descSource:  () => props.form.short_desc,
    titleSuffix: ' | ClinicMaster',
    titleKey:    'seo_title',
    descKey:     'seo_description',
    keywordsKey: 'seo_keywords',
});

const slugPreview = computed(() => {
    return (props.form.title || '')
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
});

function onFile(file, field) {
    if (!file) return;
    emit('image-change', { field, file });
}
</script>

<style scoped>
.label  { @apply block text-sm text-gray-600 mb-1; }
.input  { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
