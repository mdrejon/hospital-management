<template>
    <AdminLayout>
        <div class="space-y-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Appointments</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Manage appointment requests submitted from the website, or add one manually</p>
                </div>
                <a v-if="tab === 'list'" :href="route('admin.appointments.create')"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                    + Add Manual Appointment
                </a>
            </div>

            <!-- Flash -->
            <!-- Tabs -->
            <div class="border-b border-gray-200 flex gap-6">
                <button type="button" @click="tab = 'list'"
                    :class="tab === 'list' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2.5 text-sm font-medium border-b-2 transition-colors">
                    Appointments List
                </button>
                <button type="button" @click="tab = 'settings'"
                    :class="tab === 'settings' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2.5 text-sm font-medium border-b-2 transition-colors">
                    Page Settings
                </button>
            </div>

            <!-- ═══════════ Appointments List tab ═══════════ -->
            <div v-if="tab === 'list'" class="space-y-4">
                <!-- Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                        <div class="text-2xl font-bold text-gray-700">{{ stats.total }}</div>
                        <div class="text-xs text-gray-400 mt-1">Total</div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg shadow-sm p-4 text-center border border-yellow-200">
                        <div class="text-2xl font-bold text-yellow-600">{{ stats.pending }}</div>
                        <div class="text-xs text-gray-400 mt-1">Pending</div>
                    </div>
                    <div class="bg-green-50 rounded-lg shadow-sm p-4 text-center border border-green-200">
                        <div class="text-2xl font-bold text-green-600">{{ stats.confirmed }}</div>
                        <div class="text-xs text-gray-400 mt-1">Confirmed</div>
                    </div>
                    <div class="bg-blue-50 rounded-lg shadow-sm p-4 text-center border border-blue-200">
                        <div class="text-2xl font-bold text-blue-600">{{ stats.completed }}</div>
                        <div class="text-xs text-gray-400 mt-1">Completed</div>
                    </div>
                    <div class="bg-red-50 rounded-lg shadow-sm p-4 text-center border border-red-200">
                        <div class="text-2xl font-bold text-red-600">{{ stats.cancelled }}</div>
                        <div class="text-xs text-gray-400 mt-1">Cancelled</div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-3">
                    <select v-model="filterStatus" class="filter-input max-w-xs">
                        <option value="">All Statuses</option>
                        <option v-for="s in statuses" :key="s" :value="s">{{ statusLabel(s) }}</option>
                    </select>
                    <input v-model="search" type="text" placeholder="Search name / email..." class="filter-input max-w-xs" />
                </div>

                <!-- Table -->
                <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                    <table class="w-full text-sm min-w-[960px]">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600">Patient Details</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600">Doctor & Specialization</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600">Date, Slot & Source</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600">Visit Fee</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600">Payment</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600">Status</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-if="filtered.length === 0">
                                <td colspan="7" class="px-4 py-8 text-center text-gray-400 text-sm">No appointments found.</td>
                            </tr>
                            <tr v-for="item in filtered" :key="item.id" class="hover:bg-gray-50">
                                <td class="px-5 py-3.5">
                                    <div class="font-medium text-gray-900">{{ item.name }}</div>
                                    <div class="text-xs text-gray-400 font-mono mt-0.5">{{ item.phone || item.email }}</div>
                                    <Link v-if="item.patient_id" :href="route('admin.patients.show', item.patient_id)"
                                        class="inline-block mt-1 text-xs text-blue-600 hover:underline">
                                        View patient history
                                    </Link>
                                    <div v-if="documentsFor(item).length" class="mt-1 flex flex-col gap-0.5">
                                        <a v-for="(doc, i) in documentsFor(item)" :key="doc" :href="'/storage/' + doc" target="_blank" rel="noopener"
                                            class="inline-flex items-center gap-1 text-xs text-blue-600 hover:underline">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                            Attached document{{ documentsFor(item).length > 1 ? ' ' + (i + 1) : '' }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="font-medium text-gray-800">{{ formatDoctorName(item) }}</div>
                                    <div class="text-xs text-blue-600 mt-0.5">
                                        {{ displayTranslatable(item.doctor?.specialization?.name || '', $page.props.languages) || item.department || '—' }}
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="font-medium text-gray-800">
                                        <template v-if="item.appointment_date">{{ formatDate(item.appointment_date) }}</template>
                                        <template v-else>{{ item.preferred_date || '—' }}</template>
                                    </div>
                                    <div class="text-xs text-purple-600 font-medium mt-0.5">
                                        <template v-if="item.appointment_date">Serial #{{ item.serial_number || 'TBD' }} • {{ item.time_slot }}</template>
                                    </div>
                                    <div class="mt-1">
                                        <span :class="item.is_manual ? 'bg-purple-100 text-purple-700' : 'bg-teal-100 text-teal-700'"
                                            class="px-2 py-0.5 rounded text-2xs font-medium uppercase">
                                            {{ item.is_manual ? 'Manual' : sourceLabel(item.source) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 font-mono font-semibold text-gray-900 text-xs">
                                    BDT {{ Number(item.fee || item.doctor?.consultation_fee || 0).toLocaleString() }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="space-y-1">
                                        <span :class="paymentBadge(item.payment_status)" class="px-2 py-0.5 rounded-full text-xs font-bold uppercase">
                                            {{ item.payment_status || 'unpaid' }}
                                        </span>
                                        <div v-if="item.payment_method" class="text-xs text-gray-400 uppercase font-mono mt-0.5">
                                            {{ item.payment_method }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <select :value="item.status" @change="updateStatus(item, $event.target.value)"
                                        :class="statusBadge(item.status)"
                                        class="px-2 py-1 rounded-full text-xs font-medium border-0 cursor-pointer">
                                        <option v-for="s in statuses" :key="s" :value="s">{{ statusLabel(s) }}</option>
                                    </select>
                                    <div class="text-2xs text-gray-400 mt-1">Received: {{ formatDate(item.created_at) }}</div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex flex-col gap-2">
                                        <Link :href="route('admin.appointments.show', item.id)" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-xs font-semibold text-center transition-colors">
                                            Details &rarr;
                                        </Link>
                                        <button @click="confirmDelete(item)"
                                            class="text-xs px-3 py-1.5 rounded-lg border border-red-300 text-red-600 hover:bg-red-50 text-center transition-colors">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ═══════════ Page Settings tab ═══════════ -->
            <div v-else class="max-w-3xl space-y-4">
                <form @submit.prevent="submitSettings" class="space-y-4">

                    <!-- Book Appointment section (Home + Appointment page) -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">"Book Appointment" Section <span class="text-xs font-normal text-gray-400">(shown on Home page and the Appointment page)</span></h2>
                        <LanguageTabs v-model="activeLang" />
                        <div>
                            <label class="label">Eyebrow / Badge</label>
                            <input v-model="settingsForm.appt_badge[activeLang]" type="text" class="input" placeholder="Make an Appointment" />
                            <InputError :message="settingsForm.errors[`appt_badge.${activeLang}`]" />
                        </div>
                        <div>
                            <label class="label">Section Title</label>
                            <input v-model="settingsForm.appt_title[activeLang]" type="text" class="input" placeholder="Fast & Easy Scheduling Today!" />
                            <InputError :message="settingsForm.errors[`appt_title.${activeLang}`]" />
                        </div>
                        <div>
                            <label class="label">Form Title</label>
                            <input v-model="settingsForm.appt_form_title[activeLang]" type="text" class="input" placeholder="Please enter your info" />
                            <InputError :message="settingsForm.errors[`appt_form_title.${activeLang}`]" />
                        </div>
                        <div>
                            <label class="label">Form Subtitle</label>
                            <textarea v-model="settingsForm.appt_form_subtitle[activeLang]" rows="2" class="input resize-none"></textarea>
                            <InputError :message="settingsForm.errors[`appt_form_subtitle.${activeLang}`]" />
                        </div>
                        <div>
                            <label class="label">Side Image</label>
                            <DropZone @change="file => onImage(file, 'appt_image')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-44 object-cover"
                                :existing-preview="currentApptImage ? '/storage/' + currentApptImage : null" />
                            <InputError :message="settingsForm.errors.appt_image" />
                        </div>
                    </section>

                    <!-- Appointment page hero / breadcrumb -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Appointment Page — Hero &amp; Breadcrumb</h2>
                        <LanguageTabs v-model="activeLang" />
                        <div>
                            <label class="label">Page Title <span class="text-xs text-gray-400">(shown in breadcrumb banner)</span></label>
                            <input v-model="settingsForm.appt_page_hero_title[activeLang]" type="text" class="input" placeholder="Book Appointment" />
                            <InputError :message="settingsForm.errors[`appt_page_hero_title.${activeLang}`]" />
                        </div>
                        <div>
                            <label class="label">Banner Background Image</label>
                            <DropZone @change="file => onImage(file, 'appt_page_hero_image')" hint="Recommended: 1920×500px. JPEG / PNG / WebP" preview-class="w-full h-40 object-cover"
                                :existing-preview="currentHeroImage ? '/storage/' + currentHeroImage : null" />
                            <InputError :message="settingsForm.errors.appt_page_hero_image" />
                        </div>
                    </section>

                    <!-- SEO -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Appointment Page — SEO Configuration</h2>
                        <LanguageTabs v-model="activeLang" />
                        <div>
                            <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars, auto-filled if left blank)</span></label>
                            <input v-model="settingsForm.appt_seo_title[activeLang]" @input="onMetaTitleInput" type="text" class="input" maxlength="160" />
                            <p class="text-xs text-gray-400 mt-1">{{ (settingsForm.appt_seo_title[activeLang] || '').length }}/160</p>
                            <InputError :message="settingsForm.errors[`appt_seo_title.${activeLang}`]" />
                        </div>
                        <div>
                            <label class="label">Meta Description <span class="text-xs text-gray-400">(max 320 chars)</span></label>
                            <textarea v-model="settingsForm.appt_seo_description[activeLang]" @input="onMetaDescInput" rows="3" class="input resize-none" maxlength="320"></textarea>
                            <p class="text-xs text-gray-400 mt-1">{{ (settingsForm.appt_seo_description[activeLang] || '').length }}/320</p>
                            <InputError :message="settingsForm.errors[`appt_seo_description.${activeLang}`]" />
                        </div>
                        <div>
                            <label class="label">Meta Keywords <span class="text-xs text-gray-400">(comma-separated, auto-filled if left blank)</span></label>
                            <input v-model="settingsForm.appt_seo_keywords" @input="onMetaKeywordsInput" type="text" class="input" />
                            <InputError :message="settingsForm.errors.appt_seo_keywords" />
                        </div>
                        <div>
                            <label class="label">OG / Social Share Image</label>
                            <DropZone @change="file => onImage(file, 'appt_seo_og_image')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-36 object-cover"
                                :existing-preview="currentOgImage ? '/storage/' + currentOgImage : null" />
                            <InputError :message="settingsForm.errors.appt_seo_og_image" />
                        </div>
                    </section>

                    <div class="flex justify-end">
                        <button type="submit" :disabled="settingsForm.processing"
                            class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                            {{ settingsForm.processing ? 'Saving...' : 'Save Settings' }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete modal -->
            <div v-if="deleteTarget" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-80 shadow-xl">
                    <h3 class="font-semibold text-gray-800 mb-2">Delete Appointment</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Are you sure you want to delete the appointment request from
                        "<strong>{{ deleteTarget.name }}</strong>"? This cannot be undone.
                    </p>
                    <div class="flex justify-end gap-2">
                        <button @click="deleteTarget = null"
                            class="px-4 py-2 text-sm text-gray-600 border rounded hover:bg-gray-50">
                            Cancel
                        </button>
                        <button @click="doDelete"
                            class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, reactive, computed } from 'vue';
import { Link, router, useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import LanguageTabs from '@/Components/Admin/Shared/LanguageTabs.vue';
import { useSeoAutoFill } from '@/Composables/useSeoAutoFill';
import { seedTranslatable, defaultLangCode, displayTranslatable } from '@/Composables/useTranslatable';

const props = defineProps({
    appointments: { type: Array,  default: () => [] },
    stats:        { type: Object, default: () => ({}) },
    statuses:     { type: Array,  default: () => ['pending', 'confirmed', 'checked_in', 'in_consultation', 'completed', 'follow_up_required', 'cancelled', 'no_show'] },
    pageSettings: { type: Object, default: () => ({}) },
});

const tab = ref('list');
const deleteTarget = ref(null);
const filterStatus = ref('');
const search = ref('');

function documentsFor(item) {
    if (Array.isArray(item.documents) && item.documents.length) return item.documents;
    return item.document ? [item.document] : [];
}

const filtered = computed(() => props.appointments.filter(item => {
    if (filterStatus.value && item.status !== filterStatus.value) return false;
    if (search.value) {
        const q = search.value.toLowerCase();
        if (!item.name?.toLowerCase().includes(q) && !item.email?.toLowerCase().includes(q)) return false;
    }
    return true;
}));

function formatDate(d) {
    if (!d) return '—';
    return new Date(d).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
}

function sourceLabel(s) {
    return { home: 'Home Page', appointment_page: 'Appointment Page', admin: 'Manual' }[s] ?? s;
}

function statusLabel(s) {
    return {
        pending: 'Pending', confirmed: 'Confirmed', checked_in: 'Checked In',
        in_consultation: 'In Consultation', completed: 'Completed',
        follow_up_required: 'Follow-up Required', cancelled: 'Cancelled', no_show: 'No Show',
    }[s] ?? s;
}

function statusBadge(s) {
    return {
        pending:             'bg-yellow-100 text-yellow-700',
        confirmed:           'bg-green-100 text-green-700',
        checked_in:          'bg-cyan-100 text-cyan-700',
        in_consultation:     'bg-indigo-100 text-indigo-700',
        completed:           'bg-blue-100 text-blue-700',
        follow_up_required:  'bg-orange-100 text-orange-700',
        cancelled:           'bg-red-100 text-red-700',
        no_show:             'bg-gray-200 text-gray-700',
    }[s] ?? 'bg-gray-100 text-gray-600';
}

function paymentBadge(status) {
    const s = String(status || '').toLowerCase();
    if (s === 'paid') return 'bg-emerald-100 text-emerald-800';
    if (s === 'partially_paid') return 'bg-blue-100 text-blue-800';
    return 'bg-gray-100 text-gray-700';
}

function formatDoctorName(item) {
    const langs = usePage().props.languages ?? [];
    if (item.doctor?.name) {
        return displayTranslatable(item.doctor.name, langs);
    }
    if (item.preferred_doctor) {
        if (item.preferred_doctor.trim().startsWith('{')) {
            try {
                return displayTranslatable(JSON.parse(item.preferred_doctor), langs);
            } catch (e) {}
        }
        return item.preferred_doctor;
    }
    return '—';
}

function updateStatus(item, status) {
    router.patch(route('admin.appointments.update-status', item.id), { status }, { preserveScroll: true });
}

function confirmDelete(item) {
    deleteTarget.value = item;
}

function doDelete() {
    router.delete(route('admin.appointments.destroy', deleteTarget.value.id), {
        onFinish: () => { deleteTarget.value = null; },
    });
}

// ── Page Settings tab ──
const languages  = computed(() => usePage().props.languages ?? []);
const activeLang = ref(defaultLangCode(languages.value));

const currentApptImage = ref(props.pageSettings.appt_image ?? null);
const currentHeroImage = ref(props.pageSettings.appt_page_hero_image ?? null);
const currentOgImage   = ref(props.pageSettings.appt_seo_og_image ?? null);

const settingsForm = useForm({
    appt_badge:            seedTranslatable(languages.value, props.pageSettings.appt_badge),
    appt_title:            seedTranslatable(languages.value, props.pageSettings.appt_title),
    appt_form_title:       seedTranslatable(languages.value, props.pageSettings.appt_form_title),
    appt_form_subtitle:    seedTranslatable(languages.value, props.pageSettings.appt_form_subtitle),
    appt_image:            null,
    appt_page_hero_title:  seedTranslatable(languages.value, props.pageSettings.appt_page_hero_title),
    appt_page_hero_image:  null,
    appt_seo_title:        seedTranslatable(languages.value, props.pageSettings.appt_seo_title),
    appt_seo_description:  seedTranslatable(languages.value, props.pageSettings.appt_seo_description),
    appt_seo_keywords:     props.pageSettings.appt_seo_keywords    ?? '',
    appt_seo_og_image:     null,
});

// Proxy exposing the current-tab locale value of each translatable SEO field
// as a plain string, so useSeoAutoFill (which reads/writes flat form keys)
// can drive the per-locale appt_seo_title[activeLang]/appt_seo_description[activeLang].
const seoProxy = reactive({
    get appt_title() { return settingsForm.appt_title[activeLang.value]; },
    get appt_form_subtitle() { return settingsForm.appt_form_subtitle[activeLang.value]; },
    get appt_seo_title() { return settingsForm.appt_seo_title[activeLang.value]; },
    set appt_seo_title(v) { settingsForm.appt_seo_title[activeLang.value] = v; },
    get appt_seo_description() { return settingsForm.appt_seo_description[activeLang.value]; },
    set appt_seo_description(v) { settingsForm.appt_seo_description[activeLang.value] = v; },
    get appt_seo_keywords() { return settingsForm.appt_seo_keywords; },
    set appt_seo_keywords(v) { settingsForm.appt_seo_keywords = v; },
});

const { onMetaTitleInput, onMetaDescInput, onMetaKeywordsInput } = useSeoAutoFill(seoProxy, {
    titleSource: () => seoProxy.appt_title,
    descSource:  () => seoProxy.appt_form_subtitle,
    titleKey:    'appt_seo_title',
    descKey:     'appt_seo_description',
    keywordsKey: 'appt_seo_keywords',
});

function onImage(file, field) {
    if (!file) return;
    settingsForm[field] = file;
}

function submitSettings() {
    settingsForm.post(route('admin.website-settings.appointment.update'), {
        forceFormData: true,
        preserveScroll: true,
    });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
.filter-input { @apply border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-colors bg-white; }
</style>
