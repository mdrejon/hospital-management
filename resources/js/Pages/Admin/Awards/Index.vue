<template>
    <AdminLayout>
        <div class="max-w-5xl space-y-6">
            <h1 class="text-lg font-semibold text-gray-800">Awards Management</h1>

            <!-- Flash -->
            <!-- ── Section Settings ── -->
            <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Home Page — "Awards" Section</h2>
                <form @submit.prevent="saveSettings" class="space-y-4">
                    <LanguageTabs v-model="activeLang" />
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Badge Text</label>
                            <input v-model="settingsForm.award_badge[activeLang]" type="text" class="input" placeholder="Our Recognition" />
                        </div>
                        <div>
                            <label class="label">Section Title</label>
                            <input v-model="settingsForm.award_title[activeLang]" type="text" class="input" placeholder="Awards" />
                        </div>
                        <div class="col-span-2">
                            <label class="label">Section Description</label>
                            <textarea v-model="settingsForm.award_desc[activeLang]" rows="2" class="input resize-none"></textarea>
                        </div>
                    </div>

                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2 pt-2">Achievements Page — Awards List Section</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Section Title</label>
                            <input v-model="settingsForm.ach_award_title[activeLang]" type="text" class="input" placeholder="Our Awards & Accreditations" />
                        </div>
                        <div>
                            <label class="label">Section Description</label>
                            <input v-model="settingsForm.ach_award_desc[activeLang]" type="text" class="input" />
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" :disabled="settingsForm.processing"
                            class="px-5 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                            {{ settingsForm.processing ? 'Saving...' : 'Save Settings' }}
                        </button>
                    </div>
                </form>
            </section>

            <!-- ── Add / Edit Award ── -->
            <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">
                    {{ editingId ? 'Edit Award' : 'Add New Award' }}
                </h2>
                <form @submit.prevent="submitAward" class="space-y-4">
                    <LanguageTabs v-model="activeLang" />
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Title <span class="text-red-500">*</span></label>
                            <input v-model="form.title[activeLang]" type="text" class="input" placeholder="e.g. ClinicMaster 2024" />
                            <InputError :message="form.errors[`title.${activeLang}`]" />
                        </div>
                        <div>
                            <label class="label">Subtitle / Organization</label>
                            <input v-model="form.subtitle[activeLang]" type="text" class="input" placeholder="e.g. Quality and Accreditation Institute" />
                            <InputError :message="form.errors[`subtitle.${activeLang}`]" />
                        </div>
                        <div>
                            <label class="label">Link Text</label>
                            <input v-model="form.link_text[activeLang]" type="text" class="input" placeholder="e.g. Healthcare Leadership Award" />
                            <InputError :message="form.errors[`link_text.${activeLang}`]" />
                        </div>
                        <div>
                            <label class="label">Link URL</label>
                            <input v-model="form.link_url" type="text" class="input" placeholder="https://…" />
                            <InputError :message="form.errors.link_url" />
                        </div>
                        <div>
                            <label class="label">Seal Style <span class="text-gray-400">(used when no seal image is uploaded)</span></label>
                            <select v-model.number="form.seal_variant" class="input" :disabled="hasSealImage">
                                <option :value="1">Style 1 — Hexagon with stars</option>
                                <option :value="2">Style 2 — Dashed circle with ribbon</option>
                                <option :value="3">Style 3 — Laurel wreath circle</option>
                            </select>
                            <InputError :message="form.errors.seal_variant" />
                        </div>
                        <div class="flex items-end gap-4">
                            <div class="flex-1">
                                <label class="label">Sort Order</label>
                                <input v-model.number="form.sort_order" type="number" min="0" class="input" />
                            </div>
                            <label class="flex items-center gap-2 cursor-pointer pb-2">
                                <input v-model="form.is_active" type="checkbox" class="w-4 h-4 rounded text-blue-600" />
                                <span class="text-sm text-gray-600">Active</span>
                            </label>
                        </div>

                        <div class="col-span-2">
                            <label class="label">Seal Image</label>
                            <p class="text-xs text-gray-400 mb-2">
                                Upload a logo/seal to show on the card instead of the built-in seal style.
                                A square, transparent PNG or WebP works best.
                            </p>
                            <DropZone
                                :key="dropZoneKey"
                                hint="JPEG / PNG / WebP — max 5 MB"
                                preview-class="w-32 h-32 object-contain mx-auto my-4"
                                :existing-preview="existingSealPreview"
                                @change="onSealChange"
                                @remove="onSealRemove"
                            />
                            <InputError :message="form.errors.seal_image" />
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-end">
                        <button v-if="editingId" type="button" @click="resetForm"
                            class="px-4 py-2 text-sm text-gray-600 border rounded hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" :disabled="form.processing"
                            class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                            {{ form.processing ? 'Saving...' : (editingId ? 'Update Award' : 'Add Award') }}
                        </button>
                    </div>
                </form>
            </section>

            <!-- ── Awards List ── -->
            <section class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-700">All Awards ({{ awards.length }})</h2>
                </div>
                <div v-if="!awards.length" class="px-6 py-10 text-center text-gray-400 text-sm">
                    No awards yet — add one above.
                </div>
                <div v-else class="divide-y divide-gray-50">
                    <div v-for="a in awards" :key="a.id"
                        class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50 transition-colors">
                        <div class="w-12 h-12 flex-shrink-0 rounded border border-gray-100 bg-gray-50 flex items-center justify-center overflow-hidden">
                            <img v-if="a.seal_image" :src="'/storage/' + a.seal_image" alt="" class="w-full h-full object-contain" />
                            <span v-else class="text-[10px] text-gray-400 text-center leading-tight">Style<br />{{ a.seal_variant }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-800 text-sm">{{ displayTranslatable(a.title, languages) }}</span>
                                <span class="text-xs text-gray-400">{{ a.seal_image ? 'Custom seal image' : 'Seal style ' + a.seal_variant }}</span>
                            </div>
                            <p class="text-xs text-gray-500">{{ displayTranslatable(a.subtitle, languages) }}</p>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <button @click="toggleStatus(a)"
                                :class="a.is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'"
                                class="px-2 py-0.5 rounded-full text-xs font-semibold">
                                {{ a.is_active ? 'Active' : 'Inactive' }}
                            </button>
                            <button @click="startEdit(a)"
                                class="px-3 py-1.5 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">
                                Edit
                            </button>
                            <button @click="confirmDelete(a)"
                                class="px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Delete modal -->
        <div v-if="deleteTarget" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-80 shadow-xl">
                <h3 class="font-semibold text-gray-800 mb-2">Delete Award</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Remove "<strong>{{ displayTranslatable(deleteTarget?.title, languages) }}</strong>"? Cannot be undone.
                </p>
                <div class="flex justify-end gap-2">
                    <button @click="deleteTarget = null"
                        class="px-4 py-2 text-sm text-gray-600 border rounded hover:bg-gray-50">Cancel</button>
                    <button @click="doDelete"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import LanguageTabs from '@/Components/Admin/Shared/LanguageTabs.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import { emptyTranslatable, seedTranslatable, displayTranslatable, defaultLangCode } from '@/Composables/useTranslatable';

const props = defineProps({
    awards:   { type: Array,  default: () => [] },
    settings: { type: Object, default: () => ({}) },
});

const languages = computed(() => usePage().props.languages ?? []);
const activeLang = ref(defaultLangCode(languages.value));

// ── Section settings ──
const settingsForm = useForm({
    award_badge:     seedTranslatable(languages.value, props.settings.award_badge),
    award_title:     seedTranslatable(languages.value, props.settings.award_title),
    award_desc:      seedTranslatable(languages.value, props.settings.award_desc),
    ach_award_title: seedTranslatable(languages.value, props.settings.ach_award_title),
    ach_award_desc:  seedTranslatable(languages.value, props.settings.ach_award_desc),
});

function saveSettings() {
    settingsForm.post(route('admin.awards.settings'));
}

// ── Add / Edit form ──
const editingId = ref(null);
const editingSealImage = ref(null); // path of the seal already stored on the award being edited
const dropZoneKey = ref(0);         // bumped to reset DropZone's own preview/cleared state

const form = useForm({
    title:             emptyTranslatable(languages.value),
    subtitle:          emptyTranslatable(languages.value),
    link_text:         emptyTranslatable(languages.value),
    link_url:          '',
    seal_image:        null,
    remove_seal_image: false,
    seal_variant:      1,
    sort_order:        0,
    is_active:         true,
});

const existingSealPreview = computed(() =>
    editingSealImage.value ? '/storage/' + editingSealImage.value : null
);

// A seal image (freshly picked or already saved and not being removed) wins
// over the built-in seal styles, so the style picker is moot while one is set.
const hasSealImage = computed(() =>
    !!form.seal_image || (!!editingSealImage.value && !form.remove_seal_image)
);

function onSealChange(file) {
    form.seal_image = file;
    form.remove_seal_image = false;
}

function onSealRemove() {
    form.seal_image = null;
    form.remove_seal_image = true;
}

function startEdit(a) {
    editingId.value        = a.id;
    form.title             = seedTranslatable(languages.value, a.title);
    form.subtitle          = seedTranslatable(languages.value, a.subtitle);
    form.link_text         = seedTranslatable(languages.value, a.link_text);
    form.link_url          = a.link_url ?? '';
    form.seal_image        = null;
    form.remove_seal_image = false;
    form.seal_variant      = a.seal_variant;
    form.sort_order        = a.sort_order;
    form.is_active         = a.is_active;
    editingSealImage.value = a.seal_image ?? null;
    dropZoneKey.value++;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
    editingId.value = null;
    form.reset();
    form.title = emptyTranslatable(languages.value);
    form.subtitle = emptyTranslatable(languages.value);
    form.link_text = emptyTranslatable(languages.value);
    form.seal_image = null;
    form.remove_seal_image = false;
    form.seal_variant = 1;
    form.is_active = true;
    editingSealImage.value = null;
    dropZoneKey.value++;
}

function submitAward() {
    if (editingId.value) {
        // POST + _method spoofing: PUT can't carry a multipart file upload.
        form.transform(data => ({ ...data, _method: 'PUT' }))
            .post(route('admin.awards.update', editingId.value), {
                forceFormData: true,
                onSuccess: () => resetForm(),
            });
    } else {
        // transform() sticks to the form, so it has to be cleared here —
        // otherwise a create right after an edit would still send _method: PUT.
        form.transform(data => data)
            .post(route('admin.awards.store'), {
                onSuccess: () => resetForm(),
            });
    }
}

// ── Status / Delete ──
function toggleStatus(a) {
    router.patch(route('admin.awards.toggle', a.id));
}

const deleteTarget = ref(null);
function confirmDelete(a) { deleteTarget.value = a; }
function doDelete() {
    router.delete(route('admin.awards.destroy', deleteTarget.value.id), {
        onFinish: () => { deleteTarget.value = null; },
    });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
