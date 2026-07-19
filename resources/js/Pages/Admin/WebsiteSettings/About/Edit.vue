<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <h1 class="text-lg font-semibold text-gray-800">About Section Settings</h1>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">

                <!-- ─── Page Hero / Breadcrumb ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Page Hero &amp; Breadcrumb <span class="text-xs font-normal text-gray-400">(About page banner)</span></h2>
                    <div>
                        <label class="label">Page Title <span class="text-xs text-gray-400">(shown in breadcrumb banner)</span></label>
                        <input v-model="form.about_hero_title" type="text" class="input" placeholder="About Us" />
                        <InputError :message="form.errors.about_hero_title" />
                    </div>
                    <div>
                        <label class="label">Banner Background Image</label>
                        <DropZone @change="file => form.about_hero_image = file" hint="Recommended: 1920×500px. JPEG / PNG / WebP" preview-class="w-full h-40 object-cover"
                            :existing-preview="currentHeroImage ? '/storage/' + currentHeroImage : null" />
                        <InputError :message="form.errors.about_hero_image" />
                    </div>
                </section>

                <!-- ─── SEO Configuration ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">SEO Configuration <span class="text-xs font-normal text-gray-400">(About page)</span></h2>
                    <div>
                        <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars)</span></label>
                        <input v-model="form.about_seo_title" @input="onMetaTitleInput" type="text" class="input"
                            placeholder="About Us | ClinicMaster Medical & Health Care Services" maxlength="160" />
                        <p class="text-xs text-gray-400 mt-1">{{ (form.about_seo_title || '').length }}/160</p>
                        <InputError :message="form.errors.about_seo_title" />
                    </div>
                    <div>
                        <label class="label">Meta Description <span class="text-xs text-gray-400">(max 320 chars)</span></label>
                        <textarea v-model="form.about_seo_description" @input="onMetaDescInput" rows="3" class="input resize-none"
                            placeholder="Learn about ClinicMaster's mission, values, and leadership." maxlength="320"></textarea>
                        <p class="text-xs text-gray-400 mt-1">{{ (form.about_seo_description || '').length }}/320</p>
                        <InputError :message="form.errors.about_seo_description" />
                    </div>
                    <div>
                        <label class="label">Meta Keywords <span class="text-xs text-gray-400">(comma-separated, auto-filled if left blank)</span></label>
                        <input v-model="form.about_seo_keywords" @input="onMetaKeywordsInput" type="text" class="input"
                            placeholder="hospital, about us, healthcare, mission" />
                        <InputError :message="form.errors.about_seo_keywords" />
                    </div>
                    <div>
                        <label class="label">OG / Social Share Image <span class="text-xs text-gray-400">(recommended 1200×630px)</span></label>
                        <DropZone @change="file => form.about_seo_og_image = file" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-36 object-cover"
                            :existing-preview="currentOgImage ? '/storage/' + currentOgImage : null" />
                        <InputError :message="form.errors.about_seo_og_image" />
                    </div>
                </section>

                <!-- ─── About Section (Home + About page) ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">About Section <span class="text-xs font-normal text-gray-400">(shown on Home page and About page)</span></h2>

                    <div>
                        <label class="label">Photo</label>
                        <DropZone @change="file => form.about_photo = file" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-44 object-cover"
                            :existing-preview="currentAboutPhoto ? '/storage/' + currentAboutPhoto : null" />
                        <InputError :message="form.errors.about_photo" />
                    </div>
                    <div>
                        <label class="label">Title</label>
                        <input v-model="form.about_title" type="text" class="input" placeholder="World Class Patient Facilities Designed For You" />
                        <InputError :message="form.errors.about_title" />
                    </div>
                    <div>
                        <label class="label">Description</label>
                        <textarea v-model="form.about_desc" rows="3" class="input" placeholder="Experience the future of healthcare..."></textarea>
                        <InputError :message="form.errors.about_desc" />
                    </div>

                    <div class="border-t pt-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="label mb-0">Opening Hours Card</label>
                        </div>
                        <input v-model="form.about_hours_title" type="text" class="input" placeholder="Open Hours" />
                        <div v-for="(row, i) in form.about_hours" :key="i" class="flex items-center gap-3">
                            <input v-model="row.day" type="text" placeholder="Day (e.g. Monday)" class="input flex-1" />
                            <input v-model="row.time" type="text" placeholder="Time (e.g. 09:30 - 07:30)" class="input flex-1" />
                            <button type="button" @click="form.about_hours.splice(i, 1)" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                        </div>
                        <button type="button" @click="form.about_hours.push({ day: '', time: '' })" class="text-xs text-blue-600 hover:underline">+ Add Row</button>
                    </div>

                    <div class="border-t pt-4 space-y-3">
                        <label class="label mb-0">Feature Checklist <span class="text-xs text-gray-400">(shown in two columns)</span></label>
                        <div v-for="(item, i) in form.about_features" :key="i" class="flex items-center gap-3">
                            <input v-model="form.about_features[i]" type="text" placeholder="e.g. Comprehensive Specialties" class="input flex-1" />
                            <button type="button" @click="form.about_features.splice(i, 1)" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                        </div>
                        <button type="button" @click="form.about_features.push('')" class="text-xs text-blue-600 hover:underline">+ Add Feature</button>
                    </div>

                    <div class="border-t pt-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">CTA Button Text</label>
                            <input v-model="form.about_more_btn_text" type="text" class="input" placeholder="Appointment" />
                        </div>
                        <div>
                            <label class="label">CTA Button URL</label>
                            <input v-model="form.about_more_btn_url" type="text" class="input" placeholder="/appointment" />
                        </div>
                    </div>
                </section>

                <!-- ─── Mission & Vision (About page) ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Mission & Vision Section <span class="text-xs font-normal text-gray-400">(About page only)</span></h2>
                    <div>
                        <label class="label">Title</label>
                        <input v-model="form.about_mv_title" type="text" class="input" placeholder="Inspirational Health Our Vision And Mission" />
                    </div>
                    <div>
                        <label class="label">Description</label>
                        <textarea v-model="form.about_mv_desc" rows="2" class="input"></textarea>
                    </div>
                    <div>
                        <label class="label">Image</label>
                        <DropZone @change="file => form.about_mv_image = file" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-40 object-cover"
                            :existing-preview="currentMvImage ? '/storage/' + currentMvImage : null" />
                    </div>

                    <div class="border-t pt-4 space-y-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Cards — Mission / Vision / Values (in order)</p>
                        <div v-for="(card, i) in form.about_mv_cards" :key="i" class="border border-gray-200 rounded-lg p-4 space-y-2">
                            <label class="label text-xs">Title</label>
                            <input v-model="card.title" type="text" class="input" placeholder="Mission" />
                            <label class="label text-xs">Description</label>
                            <textarea v-model="card.description" rows="2" class="input"></textarea>
                        </div>
                    </div>
                </section>

                <!-- ─── CEO Message (About page) ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">CEO Message Section <span class="text-xs font-normal text-gray-400">(About page only)</span></h2>
                    <div>
                        <label class="label">Photo</label>
                        <DropZone @change="file => form.ceo_image = file" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-44 object-cover"
                            :existing-preview="currentCeoImage ? '/storage/' + currentCeoImage : null" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Experience Badge Value</label>
                            <input v-model="form.ceo_badge_value" type="text" class="input" placeholder="16+" />
                        </div>
                        <div>
                            <label class="label">Experience Badge Label</label>
                            <input v-model="form.ceo_badge_label" type="text" class="input" placeholder="Years Experienced" />
                        </div>
                    </div>
                    <div>
                        <label class="label">Eyebrow Text</label>
                        <input v-model="form.ceo_eyebrow" type="text" class="input" placeholder="Our CEO Message" />
                    </div>
                    <div>
                        <label class="label">Title</label>
                        <input v-model="form.ceo_title" type="text" class="input" placeholder="Meet Dr. Natali Jackson" />
                    </div>
                    <div>
                        <label class="label">Message</label>
                        <textarea v-model="form.ceo_message" rows="3" class="input"></textarea>
                    </div>

                    <div class="border-t pt-4 space-y-3">
                        <input v-model="form.ceo_focus_label" type="text" class="input" placeholder="Leadership Focus" />
                        <div v-for="(item, i) in form.ceo_focus_items" :key="i" class="flex items-center gap-3">
                            <input v-model="form.ceo_focus_items[i]" type="text" placeholder="e.g. Patient-Centered Care" class="input flex-1" />
                            <button type="button" @click="form.ceo_focus_items.splice(i, 1)" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                        </div>
                        <button type="button" @click="form.ceo_focus_items.push('')" class="text-xs text-blue-600 hover:underline">+ Add Focus Item</button>
                    </div>

                    <div class="border-t pt-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Awards</p>
                            <button type="button" @click="form.ceo_awards.push({ year: '', org: '', label: '' })" class="text-xs text-blue-600 hover:underline">+ Add Award</button>
                        </div>
                        <div v-for="(award, i) in form.ceo_awards" :key="i" class="border border-gray-200 rounded-lg p-4 space-y-2">
                            <div class="flex justify-end">
                                <button type="button" @click="form.ceo_awards.splice(i, 1)" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                            </div>
                            <input v-model="award.year" type="text" class="input" placeholder="ClinicMaster 2024" />
                            <input v-model="award.org" type="text" class="input" placeholder="Quality and Accreditation Institute" />
                            <input v-model="award.label" type="text" class="input" placeholder="Healthcare Leadership Award" />
                        </div>
                    </div>
                </section>

                <!-- ─── Why Choose Us (Home page) ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Why Choose Us Section <span class="text-xs font-normal text-gray-400">(Home page only)</span></h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Badge Text</label>
                            <input v-model="form.why_badge" type="text" class="input" placeholder="WHY CHOOSE US" />
                        </div>
                        <div>
                            <label class="label">Section Title</label>
                            <input v-model="form.why_title" type="text" class="input" placeholder="Why Choose Us For Your Health Care Needs" />
                        </div>
                        <div class="col-span-2">
                            <label class="label">Section Description</label>
                            <textarea v-model="form.why_desc" rows="2" class="input"></textarea>
                        </div>
                    </div>

                    <div class="border-t pt-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Feature Cards</p>
                            <button type="button" @click="form.why_features.push({ icon_svg: '', title: '', description: '' })" class="text-xs text-blue-600 hover:underline">+ Add Feature Card</button>
                        </div>
                        <div v-for="(feat, i) in form.why_features" :key="i" class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="flex items-center justify-between bg-gray-50 px-4 py-2 border-b border-gray-200">
                                <span class="text-xs font-semibold text-gray-600">Card {{ i + 1 }}</span>
                                <button type="button" @click="form.why_features.splice(i, 1)" class="w-6 h-6 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded text-xs">&times;</button>
                            </div>
                            <div class="p-4 space-y-3">
                                <label class="label text-xs">Title</label>
                                <input v-model="feat.title" type="text" class="input" placeholder="More Experience" />
                                <label class="label text-xs">Icon SVG</label>
                                <div v-if="feat.icon_svg" class="mb-1 flex items-center gap-2">
                                    <div class="w-8 h-8 flex items-center justify-center text-gray-600" v-html="feat.icon_svg"></div>
                                    <span class="text-xs text-gray-400">Preview</span>
                                </div>
                                <textarea v-model="feat.icon_svg" rows="3" class="input font-mono text-xs" placeholder="<svg xmlns=...>...</svg>"></textarea>
                                <label class="label text-xs">Description</label>
                                <textarea v-model="feat.description" rows="2" class="input"></textarea>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Saving...' : 'Save About Settings' }}
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
import InputError   from '@/Components/InputError.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import { useSeoAutoFill } from '@/Composables/useSeoAutoFill';

const props = defineProps({
    settings: { type: Object, required: true },
});

const s = props.settings;

const currentHeroImage  = ref(s.about_hero_image);
const currentOgImage    = ref(s.about_seo_og_image);
const currentAboutPhoto = ref(s.about_photo);
const currentMvImage    = ref(s.about_mv_image);
const currentCeoImage   = ref(s.ceo_image);

const form = useForm({
    about_hero_image:      null,
    about_hero_title:      s.about_hero_title ?? '',
    about_seo_title:       s.about_seo_title ?? '',
    about_seo_description: s.about_seo_description ?? '',
    about_seo_keywords:    s.about_seo_keywords ?? '',
    about_seo_og_image:    null,

    about_photo:        null,
    about_title:         s.about_title ?? '',
    about_desc:           s.about_desc ?? '',
    about_hours_title:    s.about_hours_title ?? '',
    about_hours:          Array.isArray(s.about_hours) ? s.about_hours.map(r => ({ ...r })) : [],
    about_features:       Array.isArray(s.about_features) ? [...s.about_features] : [],
    about_more_btn_text:  s.about_more_btn_text ?? '',
    about_more_btn_url:   s.about_more_btn_url ?? '',

    about_mv_title:  s.about_mv_title ?? '',
    about_mv_desc:    s.about_mv_desc ?? '',
    about_mv_image:   null,
    about_mv_cards:   Array.isArray(s.about_mv_cards) && s.about_mv_cards.length
        ? s.about_mv_cards.map(c => ({ ...c }))
        : [{ title: '', description: '' }, { title: '', description: '' }, { title: '', description: '' }],

    ceo_image:        null,
    ceo_badge_value:  s.ceo_badge_value ?? '',
    ceo_badge_label:  s.ceo_badge_label ?? '',
    ceo_eyebrow:      s.ceo_eyebrow ?? '',
    ceo_title:        s.ceo_title ?? '',
    ceo_message:      s.ceo_message ?? '',
    ceo_focus_label:  s.ceo_focus_label ?? '',
    ceo_focus_items:  Array.isArray(s.ceo_focus_items) ? [...s.ceo_focus_items] : [],
    ceo_awards:       Array.isArray(s.ceo_awards) ? s.ceo_awards.map(a => ({ ...a })) : [],

    why_badge:    s.why_badge ?? '',
    why_title:    s.why_title ?? '',
    why_desc:     s.why_desc ?? '',
    why_features: Array.isArray(s.why_features) ? s.why_features.map(f => ({ ...f })) : [],
});

const { onMetaTitleInput, onMetaDescInput, onMetaKeywordsInput } = useSeoAutoFill(form, {
    titleSource: () => form.about_title,
    descSource:  () => form.about_desc,
    titleKey:    'about_seo_title',
    descKey:     'about_seo_description',
    keywordsKey: 'about_seo_keywords',
});

function submit() {
    form.post(route('admin.website-settings.about.update'), {
        forceFormData: true,
    });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
