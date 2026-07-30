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
                    <LanguageTabs v-model="activeLang" />
                    <div>
                        <label class="label">Page Title <span class="text-xs text-gray-400">(shown in breadcrumb banner)</span></label>
                        <input v-model="form.about_hero_title[activeLang]" type="text" class="input" placeholder="About Us" />
                        <InputError :message="form.errors[`about_hero_title.${activeLang}`]" />
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
                    <LanguageTabs v-model="activeLang" />
                    <div>
                        <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars)</span></label>
                        <input v-model="form.about_seo_title[activeLang]" @input="onMetaTitleInput" type="text" class="input"
                            :placeholder="`About Us | ${appName}`" maxlength="160" />
                        <p class="text-xs text-gray-400 mt-1">{{ (form.about_seo_title[activeLang] || '').length }}/160</p>
                        <InputError :message="form.errors[`about_seo_title.${activeLang}`]" />
                    </div>
                    <div>
                        <label class="label">Meta Description <span class="text-xs text-gray-400">(max 320 chars)</span></label>
                        <textarea v-model="form.about_seo_description[activeLang]" @input="onMetaDescInput" rows="3" class="input resize-none"
                            placeholder="Learn about ClinicMaster's mission, values, and leadership." maxlength="320"></textarea>
                        <p class="text-xs text-gray-400 mt-1">{{ (form.about_seo_description[activeLang] || '').length }}/320</p>
                        <InputError :message="form.errors[`about_seo_description.${activeLang}`]" />
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

                <!-- ─── Mission & Vision (About page) ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Mission & Vision Section <span class="text-xs font-normal text-gray-400">(About page only)</span></h2>
                    <LanguageTabs v-model="activeLang" />
                    <div>
                        <label class="label">Title</label>
                        <input v-model="form.about_mv_title[activeLang]" type="text" class="input" placeholder="Inspirational Health Our Vision And Mission" />
                    </div>
                    <div>
                        <label class="label">Description</label>
                        <textarea v-model="form.about_mv_desc[activeLang]" rows="2" class="input"></textarea>
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
                            <input v-model="card.title[activeLang]" type="text" class="input" placeholder="Mission" />
                            <label class="label text-xs">Description</label>
                            <textarea v-model="card.description[activeLang]" rows="2" class="input"></textarea>
                        </div>
                    </div>
                </section>

                <!-- ─── CEO Message (About page) ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">CEO Message Section <span class="text-xs font-normal text-gray-400">(About page only)</span></h2>
                    <LanguageTabs v-model="activeLang" />
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
                            <input v-model="form.ceo_badge_label[activeLang]" type="text" class="input" placeholder="Years Experienced" />
                        </div>
                    </div>
                    <div>
                        <label class="label">Eyebrow Text</label>
                        <input v-model="form.ceo_eyebrow[activeLang]" type="text" class="input" placeholder="Our CEO Message" />
                    </div>
                    <div>
                        <label class="label">Title</label>
                        <input v-model="form.ceo_title[activeLang]" type="text" class="input" placeholder="Meet Dr. Natali Jackson" />
                    </div>
                    <div>
                        <label class="label">Message</label>
                        <textarea v-model="form.ceo_message[activeLang]" rows="3" class="input"></textarea>
                    </div>

                    <div class="border-t pt-4 space-y-3">
                        <input v-model="form.ceo_focus_label[activeLang]" type="text" class="input" placeholder="Leadership Focus" />
                        <div v-for="(item, i) in form.ceo_focus_items" :key="i" class="flex items-center gap-3">
                            <input v-model="form.ceo_focus_items[i][activeLang]" type="text" placeholder="e.g. Patient-Centered Care" class="input flex-1" />
                            <button type="button" @click="form.ceo_focus_items.splice(i, 1)" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                        </div>
                        <button type="button" @click="form.ceo_focus_items.push(emptyTranslatable(languages))" class="text-xs text-blue-600 hover:underline">+ Add Focus Item</button>
                    </div>

                    <div class="border-t pt-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Awards</p>
                            <button type="button" @click="form.ceo_awards.push({ year: '', org: '', label: emptyTranslatable(languages) })" class="text-xs text-blue-600 hover:underline">+ Add Award</button>
                        </div>
                        <div v-for="(award, i) in form.ceo_awards" :key="i" class="border border-gray-200 rounded-lg p-4 space-y-2">
                            <div class="flex justify-end">
                                <button type="button" @click="form.ceo_awards.splice(i, 1)" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                            </div>
                            <input v-model="award.year" type="text" class="input" placeholder="ClinicMaster 2024" />
                            <input v-model="award.org" type="text" class="input" placeholder="Quality and Accreditation Institute" />
                            <input v-model="award.label[activeLang]" type="text" class="input" placeholder="Healthcare Leadership Award" />
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
import { ref, reactive, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import InputError   from '@/Components/InputError.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import LanguageTabs from '@/Components/Admin/Shared/LanguageTabs.vue';
import { useSeoAutoFill } from '@/Composables/useSeoAutoFill';
import { emptyTranslatable, defaultLangCode } from '@/Composables/useTranslatable';

const props = defineProps({
    settings: { type: Object, required: true },
});

const languages = computed(() => usePage().props.languages ?? []);
const activeLang = ref(defaultLangCode(languages.value));
const appName = computed(() => usePage().props.appName);

const s = props.settings;
const seed = (key, fallback = {}) => ({ ...emptyTranslatable(languages.value), ...fallback, ...(s[key] || {}) });

const currentHeroImage  = ref(s.about_hero_image);
const currentOgImage    = ref(s.about_seo_og_image);
const currentMvImage    = ref(s.about_mv_image);
const currentCeoImage   = ref(s.ceo_image);

const form = useForm({
    about_hero_image:      null,
    about_hero_title:      seed('about_hero_title'),
    about_seo_title:       seed('about_seo_title'),
    about_seo_description: seed('about_seo_description'),
    about_seo_keywords:    s.about_seo_keywords ?? '',
    about_seo_og_image:    null,

    about_mv_title:  seed('about_mv_title'),
    about_mv_desc:    seed('about_mv_desc'),
    about_mv_image:   null,
    about_mv_cards:   Array.isArray(s.about_mv_cards) && s.about_mv_cards.length
        ? s.about_mv_cards.map(c => ({ title: { ...emptyTranslatable(languages.value), ...c.title }, description: { ...emptyTranslatable(languages.value), ...c.description } }))
        : [1, 2, 3].map(() => ({ title: emptyTranslatable(languages.value), description: emptyTranslatable(languages.value) })),

    ceo_image:        null,
    ceo_badge_value:  s.ceo_badge_value ?? '',
    ceo_badge_label:  seed('ceo_badge_label'),
    ceo_eyebrow:      seed('ceo_eyebrow'),
    ceo_title:        seed('ceo_title'),
    ceo_message:      seed('ceo_message'),
    ceo_focus_label:  seed('ceo_focus_label'),
    ceo_focus_items:  Array.isArray(s.ceo_focus_items) ? s.ceo_focus_items.map(f => ({ ...emptyTranslatable(languages.value), ...f })) : [],
    ceo_awards:       Array.isArray(s.ceo_awards) ? s.ceo_awards.map(a => ({ ...a, label: { ...emptyTranslatable(languages.value), ...a.label } })) : [],
});

const { onMetaTitleInput, onMetaDescInput, onMetaKeywordsInput } = useSeoAutoFill(reactive({
    get about_seo_title() { return form.about_seo_title[activeLang.value]; },
    set about_seo_title(v) { form.about_seo_title[activeLang.value] = v; },
    get about_seo_description() { return form.about_seo_description[activeLang.value]; },
    set about_seo_description(v) { form.about_seo_description[activeLang.value] = v; },
    get about_seo_keywords() { return form.about_seo_keywords; },
    set about_seo_keywords(v) { form.about_seo_keywords = v; },
}), {
    titleSource: () => form.about_hero_title[activeLang.value],
    descSource:  () => form.about_mv_desc[activeLang.value],
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
