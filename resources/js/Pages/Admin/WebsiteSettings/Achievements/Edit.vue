<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <h1 class="text-lg font-semibold text-gray-800">Achievements Page Settings</h1>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">

                <!-- ─── Page Hero ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Page Hero &amp; Breadcrumb</h2>
                    <div>
                        <label class="label">Page Title <span class="text-xs text-gray-400">(shown in breadcrumb hero)</span></label>
                        <input v-model="form.ach_hero_title" type="text" class="input" placeholder="Our Achievements" />
                        <InputError :message="form.errors.ach_hero_title" />
                    </div>
                    <div>
                        <label class="label">Hero Background Image</label>
                        <DropZone @change="file => onImg(file, 'hero')" hint="Recommended: 1920×600px. JPEG / PNG / WebP" preview-class="w-full h-44 object-cover"
                            :existing-preview="currentHeroImg ? '/storage/' + currentHeroImg : null" />
                        <InputError :message="form.errors.ach_hero_image" />
                    </div>
                </section>

                <!-- ─── Section Header ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">"Always Ready To Help" Section</h2>
                    <div>
                        <label class="label">Section Title</label>
                        <input v-model="form.ach_title" type="text" class="input" placeholder="We Are Always Ready To Help You & Your Family" />
                        <InputError :message="form.errors.ach_title" />
                    </div>
                    <div>
                        <label class="label">Section Description</label>
                        <textarea v-model="form.ach_desc" rows="2" class="input resize-none"
                            placeholder="From emergencies to everyday care, our team stands beside you at every step of your health journey."></textarea>
                        <InputError :message="form.errors.ach_desc" />
                    </div>
                </section>

                <!-- ─── Items (max 3, icons fixed) ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-3">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">
                        Help Items
                        <span class="text-xs text-gray-400 font-normal ml-2">exactly 3 items — icons are fixed (Emergency / Pharmacy / Treatment)</span>
                    </h2>
                    <div v-for="(item, i) in form.ach_items" :key="i" class="border border-gray-100 rounded-lg p-4 space-y-2 bg-gray-50">
                        <span class="text-xs font-semibold text-gray-500 uppercase">Item {{ i + 1 }}</span>
                        <div>
                            <label class="label">Title</label>
                            <input v-model="item.title" type="text" class="input" placeholder="e.g. Emergency Help" />
                        </div>
                        <div>
                            <label class="label">Description</label>
                            <textarea v-model="item.desc" rows="2" class="input resize-none" placeholder="Short description..."></textarea>
                        </div>
                    </div>
                </section>

                <!-- ─── SEO ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">SEO Configuration</h2>
                    <div>
                        <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars, auto-filled if left blank)</span></label>
                        <input v-model="form.ach_seo_title" @input="onMetaTitleInput" type="text" class="input" maxlength="160"
                            placeholder="Our Achievements | ClinicMaster Medical & Health Care Services" />
                        <p class="text-xs text-gray-400 mt-1">{{ (form.ach_seo_title || '').length }}/160</p>
                        <InputError :message="form.errors.ach_seo_title" />
                    </div>
                    <div>
                        <label class="label">Meta Description <span class="text-xs text-gray-400">(max 320 chars)</span></label>
                        <textarea v-model="form.ach_seo_description" @input="onMetaDescInput" rows="3" class="input resize-none" maxlength="320"
                            placeholder="Explore ClinicMaster's awards, accreditations, and commitment to patient care."></textarea>
                        <p class="text-xs text-gray-400 mt-1">{{ (form.ach_seo_description || '').length }}/320</p>
                        <InputError :message="form.errors.ach_seo_description" />
                    </div>
                    <div>
                        <label class="label">Meta Keywords <span class="text-xs text-gray-400">(comma-separated, auto-filled if left blank)</span></label>
                        <input v-model="form.ach_seo_keywords" @input="onMetaKeywordsInput" type="text" class="input"
                            placeholder="hospital awards, healthcare accreditation, clinicmaster achievements" />
                        <InputError :message="form.errors.ach_seo_keywords" />
                    </div>
                    <div>
                        <label class="label">OG / Social Share Image <span class="text-xs text-gray-400">(1200×630px recommended)</span></label>
                        <DropZone @change="file => onImg(file, 'og')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-36 object-cover"
                            :existing-preview="currentOgImg ? '/storage/' + currentOgImg : null" />
                        <InputError :message="form.errors.ach_seo_og_image" />
                    </div>
                </section>

                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Saving...' : 'Save Settings' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import { useSeoAutoFill } from '@/Composables/useSeoAutoFill';

const props = defineProps({
    settings: { type: Object, required: true },
});

const s = props.settings;

const currentHeroImg = ref(s.ach_hero_image    ?? null);
const currentOgImg   = ref(s.ach_seo_og_image  ?? null);

const form = useForm({
    ach_hero_title:       s.ach_hero_title       ?? '',
    ach_hero_image:       null,
    ach_title:            s.ach_title            ?? '',
    ach_desc:             s.ach_desc             ?? '',
    ach_items:            Array.isArray(s.ach_items) ? s.ach_items.map(i => ({ ...i })) : [],
    ach_seo_title:        s.ach_seo_title        ?? '',
    ach_seo_description:  s.ach_seo_description  ?? '',
    ach_seo_keywords:     s.ach_seo_keywords     ?? '',
    ach_seo_og_image:     null,
});

const { onMetaTitleInput, onMetaDescInput, onMetaKeywordsInput } = useSeoAutoFill(form, {
    titleSource: () => form.ach_title,
    descSource:  () => form.ach_desc,
    titleKey:    'ach_seo_title',
    descKey:     'ach_seo_description',
    keywordsKey: 'ach_seo_keywords',
    titleSuffix: ' | ClinicMaster',
});

function onImg(file, type) {
    if (!file) return;
    if (type === 'hero') form.ach_hero_image = file;
    if (type === 'og')   form.ach_seo_og_image = file;
}

function submit() {
    form.post(route('admin.website-settings.achievements.update'), {
        forceFormData: true,
    });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
