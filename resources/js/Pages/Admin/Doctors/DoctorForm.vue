<template>
    <div class="space-y-6">

        <!-- ── Basic Info ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Basic Information</h2>
            <LanguageTabs v-model="activeLang" />

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label">Doctor Name <span class="text-red-500">*</span></label>
                    <input v-model="form.name[activeLang]" type="text" class="input" placeholder="e.g. Dr. Rihana Roy" />
                    <InputError :message="form.errors[`name.${activeLang}`]" />
                </div>
                <div>
                    <label class="label">URL Slug <span class="text-gray-400 font-normal text-xs">(auto-generated from the English name)</span></label>
                    <div class="flex items-center gap-2">
                        <input :value="slugPreview" type="text" class="input bg-gray-50 text-gray-500 cursor-not-allowed" readonly />
                        <span class="text-xs text-gray-400 whitespace-nowrap">/doctors/{{ slugPreview || '…' }}</span>
                    </div>
                </div>
                <div>
                    <label class="label">Role / Title <span class="text-xs text-gray-400">(shown on list card, e.g. "Cardiologist")</span></label>
                    <input v-model="form.role[activeLang]" type="text" class="input" placeholder="e.g. Cardiologist" />
                    <InputError :message="form.errors[`role.${activeLang}`]" />
                </div>
                <div>
                    <label class="label">Specialization <span class="text-xs text-gray-400">(category, shown in the site's "Doctor's" menu)</span></label>
                    <select v-model="form.doctor_specialization_id" class="input">
                        <option :value="null">— None —</option>
                        <option v-for="s in specializations" :key="s.id" :value="s.id">{{ s.name }}</option>
                    </select>
                    <InputError :message="form.errors.doctor_specialization_id" />
                </div>
                <div>
                    <label class="label">Sort Order</label>
                    <input v-model.number="form.sort_order" type="number" min="0" class="input" />
                    <InputError :message="form.errors.sort_order" />
                </div>
                <div class="flex items-end gap-6 pb-1 col-span-2">
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

        <!-- ── Photo ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Photo</h2>
            <DropZone @change="file => onFile(file, 'photo')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-40 h-40 object-cover"
                :existing-preview="existing?.photo ? '/storage/' + existing.photo : null" />
            <InputError :message="form.errors.photo" />
        </section>

        <!-- ── Detail Page Info Table ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Detail Page — Info Table</h2>
            <LanguageTabs v-model="activeLang" />
            <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                <div v-for="field in infoTableFields" :key="field.key" class="space-y-2">
                    <label class="label">{{ field.label }}</label>
                    <div v-for="(entry, i) in form[field.key]" :key="i" class="flex gap-2">
                        <input v-model="entry[activeLang]" type="text" class="input" :placeholder="field.placeholder" />
                        <button type="button" @click="form[field.key].splice(i, 1)"
                            class="px-3 py-2 text-red-500 hover:bg-red-50 rounded text-sm flex-shrink-0">✕</button>
                    </div>
                    <p v-if="!form[field.key].length" class="text-xs text-gray-400">No entries yet.</p>
                    <button type="button" @click="form[field.key].push(emptyTranslatable(languages))"
                        class="text-sm text-blue-600 hover:underline">+ Add {{ field.label }}</button>
                    <InputError :message="form.errors[field.key]" />
                </div>
            </div>
            <p class="text-xs text-gray-400">
                Each field can hold several entries — they are listed on their own line in the detail page's info table.
                "Degrees" is also shown as the specialty tagline directly under the doctor's name.
            </p>
        </section>

        <!-- ── Bio ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Detail Page — Biography</h2>
            <LanguageTabs v-model="activeLang" />
            <div>
                <label class="label">Full Biography <span class="text-xs text-gray-400">(rich text, detail page intro)</span></label>
                <RichEditor v-model="form.bio[activeLang]" />
                <InputError :message="form.errors[`bio.${activeLang}`]" />
            </div>
        </section>

        <!-- ── Professional Skills ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-3">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Professional Skills Checklist</h2>
            <LanguageTabs v-model="activeLang" />
            <div v-for="(skill, i) in form.skills" :key="i" class="flex gap-2">
                <input v-model="form.skills[i][activeLang]" type="text" class="input"
                    placeholder="e.g. Primary Care & Diagnosis" />
                <button type="button" @click="form.skills.splice(i, 1)"
                    class="px-3 py-2 text-red-500 hover:bg-red-50 rounded text-sm flex-shrink-0">✕</button>
            </div>
            <button type="button" @click="form.skills.push(emptyTranslatable(languages))"
                class="text-sm text-blue-600 hover:underline">+ Add Skill</button>
        </section>

        <!-- ── Time Schedule ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-3">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">My Time Schedule</h2>
            <LanguageTabs v-model="activeLang" />
            <div v-for="(row, i) in form.schedule" :key="i" class="flex gap-2">
                <input v-model="row.day[activeLang]" type="text" class="input" placeholder="e.g. Monday" />
                <input v-model="row.time[activeLang]" type="text" class="input" placeholder="e.g. 11:00 AM – 6:00 PM" />
                <button type="button" @click="form.schedule.splice(i, 1)"
                    class="px-3 py-2 text-red-500 hover:bg-red-50 rounded text-sm flex-shrink-0">✕</button>
            </div>
            <button type="button" @click="form.schedule.push({ day: emptyTranslatable(languages), time: emptyTranslatable(languages) })"
                class="text-sm text-blue-600 hover:underline">+ Add Day</button>
        </section>

        <!-- ── Booking: Fee & Weekly Availability (our hospital only) ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Online Booking — Weekly Availability</h2>
            <p class="text-xs text-gray-400">
                Drives which dates/time slots patients can book online at our hospital. Chambers below are informational only
                (including chambers outside our hospital) and do not affect booking availability.
            </p>
            <div>
                <label class="label">Consultation Fee</label>
                <input v-model="form.consultation_fee" type="number" min="0" step="0.01" class="input max-w-xs" placeholder="e.g. 800" />
                <InputError :message="form.errors.consultation_fee" />
            </div>
            <div class="space-y-2">
                <div v-for="row in form.availabilities" :key="row.weekday"
                    class="grid grid-cols-12 gap-2 items-center text-sm">
                    <label class="col-span-3 flex items-center gap-2 cursor-pointer">
                        <input v-model="row.is_active" type="checkbox" class="w-4 h-4 rounded text-blue-600" />
                        <span class="text-gray-700">{{ row.label }}</span>
                    </label>
                    <input v-model="row.start_time" type="time" class="input col-span-3" :disabled="!row.is_active" />
                    <span class="col-span-1 text-center text-gray-400">to</span>
                    <input v-model="row.end_time" type="time" class="input col-span-3" :disabled="!row.is_active" />
                    <div class="col-span-2 flex items-center gap-1">
                        <input v-model.number="row.slot_duration_minutes" type="number" min="5" max="180" class="input" :disabled="!row.is_active" />
                        <span class="text-xs text-gray-400 whitespace-nowrap">min</span>
                    </div>
                </div>
                <InputError :message="form.errors.availabilities" />
            </div>
        </section>

        <!-- ── Leave Days ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-3">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Leave Days <span class="text-xs font-normal text-gray-400">(disables online booking for that date)</span></h2>
            <div v-for="(leave, i) in form.leaves" :key="i" class="flex gap-2">
                <input v-model="leave.date" type="date" class="input max-w-[180px]" />
                <input v-model="leave.reason" type="text" class="input" placeholder="Reason (optional)" />
                <button type="button" @click="form.leaves.splice(i, 1)"
                    class="px-3 py-2 text-red-500 hover:bg-red-50 rounded text-sm flex-shrink-0">✕</button>
            </div>
            <button type="button" @click="form.leaves.push({ date: '', reason: '' })"
                class="text-sm text-blue-600 hover:underline">+ Add Leave Day</button>
        </section>

        <!-- ── Chambers (informational directory — not used for booking) ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-3">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">
                Chambers <span class="text-xs font-normal text-gray-400">(information only — can include chambers outside our hospital)</span>
            </h2>
            <LanguageTabs v-model="activeLang" />
            <div v-for="(chamber, i) in form.chambers" :key="i" class="border border-gray-100 rounded p-4 space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="label">Chamber Name <span class="text-red-500">*</span></label>
                        <input v-model="chamber.name[activeLang]" type="text" class="input" placeholder="e.g. City Diagnostic Center" />
                    </div>
                    <div>
                        <label class="label">Hospital / Branch</label>
                        <input v-model="chamber.hospital_branch[activeLang]" type="text" class="input" />
                    </div>
                    <div>
                        <label class="label">Floor</label>
                        <input v-model="chamber.floor[activeLang]" type="text" class="input" />
                    </div>
                    <div>
                        <label class="label">Room No.</label>
                        <input v-model="chamber.room_no[activeLang]" type="text" class="input" />
                    </div>
                    <div class="col-span-2">
                        <label class="label">Address</label>
                        <input v-model="chamber.address[activeLang]" type="text" class="input" />
                    </div>
                    <div>
                        <label class="label">Contact Number</label>
                        <input v-model="chamber.contact_number[activeLang]" type="text" class="input" />
                    </div>
                    <div>
                        <label class="label">Google Map URL <span class="text-xs font-normal text-gray-400">(same for every language)</span></label>
                        <input v-model="chamber.google_map_url" type="text" class="input" placeholder="https://maps.google.com/…" />
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                        <input v-model="chamber.is_own_hospital" type="checkbox" class="w-4 h-4 rounded text-blue-600" />
                        This is our hospital
                    </label>
                    <button type="button" @click="form.chambers.splice(i, 1)"
                        class="text-sm text-red-500 hover:underline">Remove Chamber</button>
                </div>
            </div>
            <button type="button" @click="addChamber"
                class="text-sm text-blue-600 hover:underline">+ Add Chamber</button>
        </section>

        <!-- ── Contact & Social ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Contact &amp; Social Links</h2>
            <LanguageTabs v-model="activeLang" />
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="label">Address</label>
                    <input v-model="form.address[activeLang]" type="text" class="input" placeholder="e.g. 234 Oak Drive, Villagetown, USA" />
                    <InputError :message="form.errors[`address.${activeLang}`]" />
                </div>
                <div>
                    <label class="label">Phone</label>
                    <input v-model="form.phone[activeLang]" type="text" class="input" placeholder="e.g. 0 123-456-7890" />
                    <InputError :message="form.errors[`phone.${activeLang}`]" />
                </div>
                <div>
                    <label class="label">Email</label>
                    <input v-model="form.email" type="email" class="input" placeholder="e.g. info@example.com" />
                    <InputError :message="form.errors.email" />
                </div>
                <div>
                    <label class="label">Facebook URL</label>
                    <input v-model="form.facebook_url" type="text" class="input" placeholder="https://facebook.com/…" />
                </div>
                <div>
                    <label class="label">Twitter / X URL</label>
                    <input v-model="form.twitter_url" type="text" class="input" placeholder="https://x.com/…" />
                </div>
                <div>
                    <label class="label">Instagram URL</label>
                    <input v-model="form.instagram_url" type="text" class="input" placeholder="https://instagram.com/…" />
                </div>
                <div>
                    <label class="label">LinkedIn URL</label>
                    <input v-model="form.linkedin_url" type="text" class="input" placeholder="https://linkedin.com/…" />
                </div>
                <div>
                    <label class="label">YouTube URL</label>
                    <input v-model="form.youtube_url" type="text" class="input" placeholder="https://youtube.com/…" />
                </div>
            </div>
        </section>

        <!-- ── SEO ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">SEO Configuration <span class="text-xs font-normal text-gray-400">(doctor detail page)</span></h2>
            <LanguageTabs v-model="activeLang" />
            <div>
                <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars, auto-filled if left blank)</span></label>
                <input v-model="form.seo_title[activeLang]" @input="onMetaTitleInput" type="text" class="input" placeholder="e.g. Dr. Rihana Roy | ClinicMaster" maxlength="160" />
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
import { reactive, computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import RichEditor from '@/Components/Admin/Shared/RichEditor.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import LanguageTabs from '@/Components/Admin/Shared/LanguageTabs.vue';
import { useSeoAutoFill } from '@/Composables/useSeoAutoFill';
import { emptyTranslatable, defaultLangCode } from '@/Composables/useTranslatable';

const props = defineProps({
    form:             { type: Object, required: true },
    existing:         { type: Object, default: null },
    specializations:  { type: Array,  default: () => [] },
});

const emit = defineEmits(['image-change']);

const languages = computed(() => usePage().props.languages ?? []);
const activeLang = ref(defaultLangCode(languages.value));

// The detail page's info table — each of these holds a list of translatable
// entries, so an admin can add as many lines as a doctor needs.
const infoTableFields = [
    { key: 'specialty',  label: 'Specialty',  placeholder: 'e.g. Gynecology' },
    { key: 'degrees',    label: 'Degrees',    placeholder: 'e.g. MBBS, PGT (Obs & Gynae)' },
    { key: 'experience', label: 'Experience', placeholder: 'e.g. Ex-Medical Officer, Sarat Abida General Hospital' },
    { key: 'awards',     label: 'Awards',     placeholder: 'e.g. World Medical Congress – 2023' },
];

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
    titleSource: () => props.form.name[activeLang.value],
    descSource:  () => (props.form.specialty ?? [])
        .map(entry => entry[activeLang.value])
        .filter(Boolean)
        .join(', '),
    titleSuffix: ' | ClinicMaster',
    titleKey:    'seo_title',
    descKey:     'seo_description',
    keywordsKey: 'seo_keywords',
});

// The slug is always generated from the English name (matching the backend),
// regardless of which language tab is active, so the preview stays accurate.
const slugPreview = computed(() => {
    return (props.form.name?.en || '')
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

function addChamber() {
    props.form.chambers.push({
        name: emptyTranslatable(languages.value),
        hospital_branch: emptyTranslatable(languages.value),
        floor: emptyTranslatable(languages.value),
        room_no: emptyTranslatable(languages.value),
        address: emptyTranslatable(languages.value),
        contact_number: emptyTranslatable(languages.value),
        google_map_url: '',
        is_own_hospital: false,
    });
}
</script>

<style scoped>
.label  { @apply block text-sm text-gray-600 mb-1; }
.input  { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
