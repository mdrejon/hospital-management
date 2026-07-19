<template>
    <div class="space-y-6">

        <!-- ── Basic Info ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Basic Information</h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label">Service Title <span class="text-red-500">*</span></label>
                    <input v-model="form.title" type="text" class="input" placeholder="e.g. Cardiology" />
                    <InputError :message="form.errors.title" />
                </div>
                <div>
                    <label class="label">URL Slug <span class="text-gray-400 font-normal text-xs">(auto-generated)</span></label>
                    <div class="flex items-center gap-2">
                        <input :value="slugPreview" type="text" class="input bg-gray-50 text-gray-500 cursor-not-allowed" readonly />
                        <span class="text-xs text-gray-400 whitespace-nowrap">/services/{{ slugPreview || '…' }}</span>
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

        <!-- ── Icon SVG ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Service Icon</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="label">Paste SVG Code</label>
                    <textarea v-model="form.icon_svg" rows="6" class="input font-mono text-xs resize-none"
                        placeholder='<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" ...></svg>'></textarea>
                    <p class="text-xs text-gray-400 mt-1">Copy the &lt;svg&gt;...&lt;/svg&gt; markup from any icon library</p>
                    <InputError :message="form.errors.icon_svg" />
                </div>
                <div>
                    <label class="label">Preview</label>
                    <div class="w-16 h-16 border rounded-lg flex items-center justify-center bg-gray-50 text-gray-600"
                        v-html="form.icon_svg || defaultIcon">
                    </div>
                    <!-- Common presets -->
                    <p class="text-xs text-gray-500 mt-3 mb-2">Quick presets:</p>
                    <div class="flex flex-wrap gap-2">
                        <button v-for="preset in iconPresets" :key="preset.name" type="button"
                            @click="form.icon_svg = preset.svg"
                            class="px-2 py-1 text-xs border rounded hover:bg-blue-50 hover:border-blue-300 text-gray-600"
                            :title="preset.name">
                            {{ preset.name }}
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── Main Image ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Card Image (Listing & Home Page)</h2>
            <DropZone @change="file => onFile(file, 'image')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-44 object-cover"
                :existing-preview="existing?.image ? '/storage/' + existing.image : null" />
            <InputError :message="form.errors.image" />

            <div>
                <label class="label">Short Description <span class="text-xs text-gray-400">(shown on card)</span></label>
                <textarea v-model="form.short_desc" rows="3" class="input resize-none"
                    placeholder="e.g. Diagnosis and treatment of heart and blood vessel conditions."></textarea>
                <InputError :message="form.errors.short_desc" />
            </div>
        </section>

        <!-- ── Detail Page Content ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Detail Page — Introduction</h2>
            <div>
                <label class="label">Full Description <span class="text-xs text-gray-400">(rich text, detail page intro)</span></label>
                <RichEditor v-model="form.description" />
                <InputError :message="form.errors.description" />
            </div>
        </section>

        <!-- ── Why Choose This Service ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-3">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Why Choose This Service — Feature List</h2>
            <div v-for="(item, i) in form.features" :key="i" class="flex gap-2">
                <input v-model="form.features[i]" type="text" class="input"
                    placeholder="e.g. 24/7 Emergency Response Team" />
                <button type="button" @click="form.features.splice(i, 1)"
                    class="px-3 py-2 text-red-500 hover:bg-red-50 rounded text-sm flex-shrink-0">✕</button>
            </div>
            <button type="button" @click="form.features.push('')"
                class="text-sm text-blue-600 hover:underline">+ Add Feature</button>
        </section>

        <!-- ── Available Doctors ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-3">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Available Doctors <span class="text-xs font-normal text-gray-400">(shown on the detail page)</span></h2>
            <p class="text-xs text-gray-400 -mt-1">Hold Ctrl (Windows) or Cmd (Mac) to select multiple doctors.</p>
            <select v-model="form.doctor_ids" multiple class="input" size="8">
                <option v-for="d in doctors" :key="d.id" :value="d.id">
                    {{ d.name }}{{ d.specialty ? ' — ' + d.specialty : '' }}
                </option>
            </select>
            <p v-if="!doctors.length" class="text-xs text-gray-400">No doctors found — add doctors first under Website Management → Doctors.</p>

            <div v-if="selectedDoctors.length" class="flex flex-wrap gap-2 pt-1">
                <span v-for="d in selectedDoctors" :key="d.id"
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 text-xs rounded-full">
                    {{ d.name }}
                    <button type="button" @click="removeDoctor(d.id)" class="text-blue-400 hover:text-blue-700 leading-none">&times;</button>
                </span>
            </div>
            <InputError :message="form.errors.doctor_ids" />
        </section>

        <!-- ── SEO ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">SEO Configuration <span class="text-xs font-normal text-gray-400">(service detail page)</span></h2>
            <div>
                <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars, auto-filled if left blank)</span></label>
                <input v-model="form.seo_title" @input="onMetaTitleInput" type="text" class="input" placeholder="e.g. Angioplasty | ClinicMaster" maxlength="160" />
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

        <!-- ── FAQ ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">FAQ Section</h2>
            <div v-for="(faq, i) in form.faqs" :key="i"
                class="border border-gray-100 rounded-lg p-4 space-y-3 bg-gray-50">
                <div class="flex justify-between items-center">
                    <span class="text-xs font-semibold text-gray-500 uppercase">FAQ {{ i + 1 }}</span>
                    <button type="button" @click="form.faqs.splice(i, 1)"
                        class="text-xs text-red-500 hover:underline">Remove</button>
                </div>
                <div>
                    <label class="label">Question</label>
                    <input v-model="form.faqs[i].question" type="text" class="input"
                        placeholder="e.g. Do I need a referral to see a specialist?" />
                </div>
                <div>
                    <label class="label">Answer</label>
                    <textarea v-model="form.faqs[i].answer" rows="3" class="input resize-none"
                        placeholder="Answer..."></textarea>
                </div>
            </div>
            <button type="button" @click="form.faqs.push({ question: '', answer: '' })"
                class="text-sm text-blue-600 hover:underline">+ Add FAQ</button>
        </section>

    </div>
</template>

<script setup>
import { reactive, computed } from 'vue';
import InputError from '@/Components/InputError.vue';
import RichEditor from '@/Components/Admin/Shared/RichEditor.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import { useSeoAutoFill } from '@/Composables/useSeoAutoFill';

const props = defineProps({
    form:     { type: Object, required: true },
    existing: { type: Object, default: null },
    doctors:  { type: Array, default: () => [] },
});

const emit = defineEmits(['image-change']);

const selectedDoctors = computed(() =>
    props.doctors.filter(d => (props.form.doctor_ids || []).includes(d.id))
);

function removeDoctor(id) {
    props.form.doctor_ids = (props.form.doctor_ids || []).filter(i => i !== id);
}

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

const defaultIcon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;

const iconPresets = [
    {
        name: 'Cardiology',
        svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h4l2-6 4 12 2-6h6"/></svg>`,
    },
    {
        name: 'Dental',
        svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"><path d="M12 3c-2.2 0-3.8 1-5 1-1.5 0-2.5 1.3-2.5 3.3 0 2.2.7 4.7 1.4 6.9.5 1.7.9 3.6 1.6 4.9.4.8 1 1.4 1.8 1.4.9 0 1.3-.8 1.6-1.9.3-1.1.4-2.5 1.1-2.5s.8 1.4 1.1 2.5c.3 1.1.7 1.9 1.6 1.9.8 0 1.4-.6 1.8-1.4.7-1.3 1.1-3.2 1.6-4.9.7-2.2 1.4-4.7 1.4-6.9C19.5 5.3 18.5 4 17 4c-1.2 0-2.8-1-5-1z"/></svg>`,
    },
    {
        name: 'Pediatrics',
        svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"><path d="M12 20s-7-4.5-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 5c-2.5 4.5-9.5 9-9.5 9z"/></svg>`,
    },
    {
        name: 'Emergency',
        svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a5 5 0 0 1 5 5v6H7V8a5 5 0 0 1 5-5z"/><path d="M5 14h14v3a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-3zM12 3V1M9 21h6"/></svg>`,
    },
    {
        name: 'Laboratory',
        svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"><path d="M9 2h6M10 2v6.5L5.5 18a2 2 0 0 0 1.8 2.9h9.4a2 2 0 0 0 1.8-2.9L14 8.5V2"/><path d="M7.5 15h9" stroke-linecap="round"/></svg>`,
    },
    {
        name: 'Mental Health',
        svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="M9 4a3 3 0 0 0-3 3 3 3 0 0 0-1 5.8A3 3 0 0 0 8 17a3 3 0 0 0 3-3V7a3 3 0 0 0-2-3z"/><path d="M15 4a3 3 0 0 1 3 3 3 3 0 0 1 1 5.8A3 3 0 0 1 16 17a3 3 0 0 1-3-3V7a3 3 0 0 1 2-3z"/></svg>`,
    },
    {
        name: 'Surgery',
        svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20 14 10M14 10l6-6M14 10l3 3M17 4l3 3"/></svg>`,
    },
    {
        name: 'General Medicine',
        svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4a3 3 0 0 0-3 3v3a5 5 0 0 0 5 5h2a5 5 0 0 0 5-5V7a3 3 0 0 0-3-3"/><circle cx="18" cy="6" r="2.5"/><path d="M12 15v3m0 0a3 3 0 1 0 0 0z"/></svg>`,
    },
];
</script>

<style scoped>
.label  { @apply block text-sm text-gray-600 mb-1; }
.input  { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
