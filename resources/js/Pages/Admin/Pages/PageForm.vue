<template>
    <div class="space-y-6">

        <!-- ── Basic Info ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Basic Information</h2>
            <LanguageTabs v-model="activeLang" />

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label">Page Title <span class="text-red-500">*</span></label>
                    <input v-model="form.title[activeLang]" type="text" class="input" placeholder="e.g. Privacy Policy" />
                    <InputError :message="form.errors[`title.${activeLang}`]" />
                </div>
                <div>
                    <label class="label">Parent Page <span class="text-gray-400 font-normal text-xs">(optional)</span></label>
                    <select v-model="form.parent_id" class="input">
                        <option :value="null">— No Parent (top level) —</option>
                        <option v-for="p in parentOptions" :key="p.id" :value="p.id">{{ displayTranslatable(p.title, languages) }}</option>
                    </select>
                    <InputError :message="form.errors.parent_id" />
                </div>
                <div class="col-span-2">
                    <label class="label">URL Path <span class="text-gray-400 font-normal text-xs">(auto-generated from title)</span></label>
                    <input :value="pathPreview" type="text" class="input bg-gray-50 text-gray-500 cursor-not-allowed" readonly />
                </div>
                <div>
                    <label class="label">Breadcrumb Title <span class="text-gray-400 font-normal text-xs">(optional override, shown in the page header)</span></label>
                    <input v-model="form.breadcrumb_title[activeLang]" type="text" class="input" placeholder="Defaults to page title" />
                    <InputError :message="form.errors[`breadcrumb_title.${activeLang}`]" />
                </div>
                <div>
                    <label class="label">Sort Order</label>
                    <input v-model.number="form.sort_order" type="number" min="0" class="input" />
                    <InputError :message="form.errors.sort_order" />
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input v-model="form.is_active" type="checkbox" class="w-4 h-4 rounded text-blue-600" />
                        <span class="text-sm text-gray-600">Active</span>
                    </label>
                </div>
            </div>
        </section>

        <!-- ── Header / Breadcrumb Banner ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Header Banner Image</h2>
            <DropZone @change="file => onFile(file, 'hero_image')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-40 object-cover"
                :existing-preview="existing?.hero_image ? '/storage/' + existing.hero_image : null" />
            <InputError :message="form.errors.hero_image" />
        </section>

        <!-- ── Content ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Page Content</h2>
            <LanguageTabs v-model="activeLang" />
            <RichEditor v-model="form.content[activeLang]" />
            <InputError :message="form.errors[`content.${activeLang}`]" />
        </section>

        <!-- ── SEO ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">SEO Configuration</h2>
            <LanguageTabs v-model="activeLang" />
            <div>
                <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars, auto-filled if left blank)</span></label>
                <input v-model="form.seo_title[activeLang]" @input="onMetaTitleInput" type="text" class="input" maxlength="160" />
                <p class="text-xs text-gray-400 mt-1">{{ (form.seo_title[activeLang] || '').length }}/160</p>
                <InputError :message="form.errors[`seo_title.${activeLang}`]" />
            </div>
            <div>
                <label class="label">Meta Description <span class="text-xs text-gray-400">(max 320 chars)</span></label>
                <textarea v-model="form.seo_description[activeLang]" @input="onMetaDescInput" rows="3" class="input resize-none" maxlength="320"></textarea>
                <p class="text-xs text-gray-400 mt-1">{{ (form.seo_description[activeLang] || '').length }}/320</p>
                <InputError :message="form.errors[`seo_description.${activeLang}`]" />
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
import { computed, ref, reactive } from 'vue';
import { usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import RichEditor from '@/Components/Admin/Shared/RichEditor.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import LanguageTabs from '@/Components/Admin/Shared/LanguageTabs.vue';
import { useSeoAutoFill } from '@/Composables/useSeoAutoFill';
import { defaultLangCode, displayTranslatable } from '@/Composables/useTranslatable';

const props = defineProps({
    form:          { type: Object, required: true },
    existing:      { type: Object, default: null },
    parentOptions: { type: Array, default: () => [] },
});

const emit = defineEmits(['image-change']);

const languages = computed(() => usePage().props.languages ?? []);
const activeLang = ref(defaultLangCode(languages.value));

// Proxy exposing the current-tab locale value of each translatable field as a
// plain string, so useSeoAutoFill (which reads/writes flat form keys) can
// drive the per-locale seo_title[activeLang]/seo_description[activeLang].
const seoProxy = reactive({
    get seo_title() { return props.form.seo_title[activeLang.value]; },
    set seo_title(v) { props.form.seo_title[activeLang.value] = v; },
    get seo_description() { return props.form.seo_description[activeLang.value]; },
    set seo_description(v) { props.form.seo_description[activeLang.value] = v; },
    get seo_keywords() { return props.form.seo_keywords; },
    set seo_keywords(v) { props.form.seo_keywords = v; },
});

const { onMetaTitleInput, onMetaDescInput, onMetaKeywordsInput } = useSeoAutoFill(seoProxy, {
    titleSource: () => props.form.title[activeLang.value],
    descSource:  () => props.form.breadcrumb_title[activeLang.value],
    titleSuffix: ' | ClinicMaster',
    titleKey:    'seo_title',
    descKey:     'seo_description',
    keywordsKey: 'seo_keywords',
});

const slugPreview = computed(() => {
    return (props.form.title[defaultLangCode(languages.value)] || '')
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
});

const pathPreview = computed(() => {
    const parent = props.parentOptions.find(p => p.id === props.form.parent_id);
    const base = parent ? `/${parent.full_path}` : '';
    return `${base}/${slugPreview.value || '…'}`;
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
