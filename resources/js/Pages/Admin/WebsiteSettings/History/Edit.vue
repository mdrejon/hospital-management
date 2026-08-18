<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <h1 class="text-lg font-semibold text-gray-800">History Page Settings</h1>

            <form @submit.prevent="submit" class="space-y-6">

                <!-- ─── Page Hero ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Page Hero &amp; Breadcrumb</h2>
                    <LanguageTabs v-model="activeLang" />
                    <div>
                        <label class="label">Page Title <span class="text-xs text-gray-400">(shown in breadcrumb hero)</span></label>
                        <input v-model="form.hist_hero_title[activeLang]" type="text" class="input" placeholder="Our History" />
                        <InputError :message="form.errors[`hist_hero_title.${activeLang}`]" />
                    </div>
                    <div>
                        <label class="label">Hero Background Image</label>
                        <DropZone @change="file => onSingleImg(file, 'hero')" hint="Recommended: 1920×600px. JPEG / PNG / WebP" preview-class="w-full h-44 object-cover"
                            :existing-preview="currentHeroImg ? '/storage/' + currentHeroImg : null" />
                        <InputError :message="form.errors.hist_hero_image" />
                    </div>
                </section>

                <!-- ─── SEO ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">SEO Configuration</h2>
                    <LanguageTabs v-model="activeLang" />
                    <div>
                        <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars)</span></label>
                        <input v-model="form.hist_seo_title[activeLang]" @input="onMetaTitleInput" type="text" class="input" maxlength="160"
                            placeholder="Our History – Hotel Beach Way, Cox's Bazar" />
                        <p class="text-xs text-gray-400 mt-1">{{ (form.hist_seo_title[activeLang] || '').length }}/160</p>
                        <InputError :message="form.errors[`hist_seo_title.${activeLang}`]" />
                    </div>
                    <div>
                        <label class="label">Meta Description <span class="text-xs text-gray-400">(max 320 chars)</span></label>
                        <textarea v-model="form.hist_seo_description[activeLang]" @input="onMetaDescInput" rows="3" class="input resize-none" maxlength="320"
                            placeholder="Discover the history of Hotel Beach Way — Cox's Bazar's premier coastal retreat since 2013."></textarea>
                        <p class="text-xs text-gray-400 mt-1">{{ (form.hist_seo_description[activeLang] || '').length }}/320</p>
                        <InputError :message="form.errors[`hist_seo_description.${activeLang}`]" />
                    </div>
                    <div>
                        <label class="label">Meta Keywords <span class="text-xs text-gray-400">(comma-separated)</span></label>
                        <input v-model="form.hist_seo_keywords" @input="onMetaKeywordsInput" type="text" class="input"
                            placeholder="hotel beach way history, cox's bazar hotel history" />
                        <InputError :message="form.errors.hist_seo_keywords" />
                    </div>
                    <div>
                        <label class="label">OG / Social Share Image <span class="text-xs text-gray-400">(1200×630px recommended)</span></label>
                        <DropZone @change="file => onSingleImg(file, 'og')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-36 object-cover"
                            :existing-preview="currentOgImg ? '/storage/' + currentOgImg : null" />
                        <InputError :message="form.errors.hist_seo_og_image" />
                    </div>
                </section>

                <!-- ─── Section Header ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Timeline Section Header</h2>
                    <LanguageTabs v-model="activeLang" />
                    <div>
                        <label class="label">Badge Text</label>
                        <input v-model="form.hist_badge[activeLang]" type="text" class="input" placeholder="OUR JOURNEY" />
                        <InputError :message="form.errors[`hist_badge.${activeLang}`]" />
                    </div>
                    <div>
                        <label class="label">Section Title <span class="text-xs text-gray-400">(use &lt;br&gt; for line break)</span></label>
                        <input v-model="form.hist_title[activeLang]" type="text" class="input"
                            placeholder="A Decade of Warmth,&lt;br&gt;Hospitality &amp; Excellence" />
                        <InputError :message="form.errors[`hist_title.${activeLang}`]" />
                    </div>
                    <div>
                        <label class="label">Section Description</label>
                        <textarea v-model="form.hist_desc[activeLang]" rows="3" class="input resize-none"
                            placeholder="Short description shown below the section title..."></textarea>
                        <InputError :message="form.errors[`hist_desc.${activeLang}`]" />
                    </div>
                </section>

                <!-- ─── Timeline Items ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <div class="flex items-center justify-between border-b pb-2">
                        <h2 class="text-sm font-semibold text-gray-700">
                            Timeline Items
                            <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">{{ form.hist_timeline.length }}</span>
                        </h2>
                        <button type="button" @click="addItem"
                            class="px-3 py-1.5 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">
                            + Add Item
                        </button>
                    </div>
                    <LanguageTabs v-model="activeLang" />

                    <div class="space-y-4">
                        <div v-for="(item, i) in form.hist_timeline" :key="i"
                            class="border border-gray-200 rounded-lg overflow-hidden">

                            <!-- Item header bar -->
                            <div class="flex items-center justify-between bg-gray-50 px-4 py-2 border-b border-gray-200 cursor-pointer"
                                @click="toggleItem(i)">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 bg-blue-600 text-white text-xs font-bold rounded-full flex items-center justify-center">
                                        {{ item.year || (i + 1) }}
                                    </span>
                                    <span class="text-sm font-medium text-gray-700 truncate max-w-xs">
                                        {{ displayTranslatable(item.heading, languages) || 'New Timeline Item' }}
                                    </span>
                                    <span v-if="item.reversed" class="text-xs bg-purple-100 text-purple-600 px-2 py-0.5 rounded">Reversed</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click.stop="moveUp(i)" :disabled="i === 0"
                                        class="text-gray-400 hover:text-gray-700 disabled:opacity-30 text-sm px-1">↑</button>
                                    <button type="button" @click.stop="moveDown(i)" :disabled="i === form.hist_timeline.length - 1"
                                        class="text-gray-400 hover:text-gray-700 disabled:opacity-30 text-sm px-1">↓</button>
                                    <button type="button" @click.stop="removeItem(i)"
                                        class="text-red-400 hover:text-red-600 text-sm px-1">✕</button>
                                    <span class="text-gray-400 text-xs">{{ openItems.has(i) ? '▲' : '▼' }}</span>
                                </div>
                            </div>

                            <!-- Item fields (collapsible) -->
                            <div v-if="openItems.has(i)" class="p-4 space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="label">Year</label>
                                        <input v-model="form.hist_timeline[i].year" type="text" class="input" placeholder="2013" />
                                    </div>
                                    <div>
                                        <label class="label">Tag / Category</label>
                                        <input v-model="form.hist_timeline[i].tag[activeLang]" type="text" class="input" placeholder="Foundation" />
                                    </div>
                                </div>
                                <div>
                                    <label class="label">Heading</label>
                                    <input v-model="form.hist_timeline[i].heading[activeLang]" type="text" class="input"
                                        placeholder="Grand Opening — Hotel Beach Way Is Born" />
                                </div>
                                <div>
                                    <label class="label">Content</label>
                                    <textarea v-model="form.hist_timeline[i].content[activeLang]" rows="4" class="input resize-none"
                                        placeholder="Describe this milestone..."></textarea>
                                </div>

                                <!-- Badges -->
                                <div>
                                    <label class="label">Badges <span class="text-xs text-gray-400">(small highlight chips)</span></label>
                                    <div v-for="(badge, bi) in form.hist_timeline[i].badges" :key="bi" class="flex gap-2 mb-2">
                                        <input v-model="form.hist_timeline[i].badges[bi][activeLang]" type="text" class="input"
                                            placeholder="e.g. 30 Rooms Launched" />
                                        <button type="button" @click="removeBadge(i, bi)"
                                            class="px-2 text-red-400 hover:text-red-600 text-sm">✕</button>
                                    </div>
                                    <button type="button" @click="addBadge(i)"
                                        class="text-xs text-blue-600 hover:underline">+ Add Badge</button>
                                </div>

                                <!-- Image -->
                                <div>
                                    <label class="label">Item Image</label>
                                    <DropZone @change="file => onTimelineImg(file, i)" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-44 object-cover"
                                        :existing-preview="item.image && !timelineImgPreviews[i] ? '/storage/' + item.image : null" />
                                </div>

                                <!-- Layout -->
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" :id="`rev-${i}`" v-model="form.hist_timeline[i].reversed"
                                        class="w-4 h-4 rounded text-blue-600" />
                                    <label :for="`rev-${i}`" class="text-sm text-gray-600 cursor-pointer">
                                        Reversed layout <span class="text-xs text-gray-400">(image on right, text on left)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" @click="addItem"
                        class="w-full py-2.5 border-2 border-dashed border-gray-300 rounded-lg text-sm text-blue-600 hover:border-blue-400 hover:bg-blue-50 transition-colors">
                        + Add Timeline Item
                    </button>
                </section>

                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Saving...' : 'Save History Settings' }}
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
import { seedTranslatable, defaultLangCode, emptyTranslatable, displayTranslatable } from '@/Composables/useTranslatable';

const props = defineProps({
    settings: { type: Object, required: true },
});

const s = props.settings;
const languages  = computed(() => usePage().props.languages ?? []);
const activeLang = ref(defaultLangCode(languages.value));

const currentHeroImg = ref(s.hist_hero_image);
const currentOgImg   = ref(s.hist_seo_og_image);

// Per-timeline-item image previews keyed by index
const timelineImgPreviews = reactive({});

// Which timeline items are expanded
const openItems = reactive(new Set([0]));

const defaultItem = () => ({
    year: '', tag: emptyTranslatable(languages.value), heading: emptyTranslatable(languages.value),
    content: emptyTranslatable(languages.value), badges: [], image: '', reversed: false,
});

const form = useForm({
    hist_hero_image:      null,
    hist_hero_title:      seedTranslatable(languages.value, s.hist_hero_title),
    hist_badge:           seedTranslatable(languages.value, s.hist_badge),
    hist_title:           seedTranslatable(languages.value, s.hist_title),
    hist_desc:            seedTranslatable(languages.value, s.hist_desc),
    hist_timeline:        Array.isArray(s.hist_timeline) && s.hist_timeline.length
                            ? s.hist_timeline.map(i => ({
                                ...i,
                                tag:     seedTranslatable(languages.value, i.tag),
                                heading: seedTranslatable(languages.value, i.heading),
                                content: seedTranslatable(languages.value, i.content),
                                badges:  (i.badges || []).map(b => seedTranslatable(languages.value, b)),
                            }))
                            : [],
    timeline_images:      {},
    hist_seo_title:       seedTranslatable(languages.value, s.hist_seo_title),
    hist_seo_description: seedTranslatable(languages.value, s.hist_seo_description),
    hist_seo_keywords:    s.hist_seo_keywords    ?? '',
    hist_seo_og_image:    null,
});

// Proxy exposing the current-tab locale value of each translatable field as a
// plain string, so useSeoAutoFill (which reads/writes flat form keys) can
// drive the per-locale hist_seo_title[activeLang]/hist_seo_description[activeLang].
const seoProxy = reactive({
    get hist_title() { return form.hist_title[activeLang.value]; },
    get hist_desc() { return form.hist_desc[activeLang.value]; },
    get hist_seo_title() { return form.hist_seo_title[activeLang.value]; },
    set hist_seo_title(v) { form.hist_seo_title[activeLang.value] = v; },
    get hist_seo_description() { return form.hist_seo_description[activeLang.value]; },
    set hist_seo_description(v) { form.hist_seo_description[activeLang.value] = v; },
    get hist_seo_keywords() { return form.hist_seo_keywords; },
    set hist_seo_keywords(v) { form.hist_seo_keywords = v; },
});

const { onMetaTitleInput, onMetaDescInput, onMetaKeywordsInput } = useSeoAutoFill(seoProxy, {
    titleSource: () => seoProxy.hist_title,
    descSource:  () => seoProxy.hist_desc,
    titleKey:    'hist_seo_title',
    descKey:     'hist_seo_description',
    keywordsKey: 'hist_seo_keywords',
});

function onSingleImg(file, type) {
    if (!file) return;
    if (type === 'hero') { form.hist_hero_image = file; }
    else                  { form.hist_seo_og_image = file; }
}

function onTimelineImg(file, idx) {
    if (!file) return;
    form.timeline_images[idx] = file;
    timelineImgPreviews[idx]  = URL.createObjectURL(file);
}

function toggleItem(i) {
    openItems.has(i) ? openItems.delete(i) : openItems.add(i);
}

function addItem() {
    form.hist_timeline.push(defaultItem());
    openItems.add(form.hist_timeline.length - 1);
}

function removeItem(i) {
    form.hist_timeline.splice(i, 1);
    openItems.delete(i);
    delete timelineImgPreviews[i];
}

function moveUp(i) {
    if (i === 0) return;
    [form.hist_timeline[i - 1], form.hist_timeline[i]] = [form.hist_timeline[i], form.hist_timeline[i - 1]];
}

function moveDown(i) {
    if (i === form.hist_timeline.length - 1) return;
    [form.hist_timeline[i], form.hist_timeline[i + 1]] = [form.hist_timeline[i + 1], form.hist_timeline[i]];
}

function addBadge(i)        { form.hist_timeline[i].badges.push(emptyTranslatable(languages.value)); }
function removeBadge(i, bi) { form.hist_timeline[i].badges.splice(bi, 1); }

function submit() {
    form.transform(data => ({ ...data, _method: 'PUT' }))
        .post(route('admin.website-settings.history.update'), { forceFormData: true });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
