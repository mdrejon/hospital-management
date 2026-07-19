<template>
    <AdminLayout>
        <div class="space-y-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Doctors Management</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Manage doctors shown on the home page, doctors listing, and detail pages</p>
                </div>
                <a v-if="tab === 'list'" :href="route('admin.doctors.create')"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                    + Add Doctor
                </a>
            </div>

            <!-- Flash -->
            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200 flex gap-6">
                <button type="button" @click="tab = 'list'"
                    :class="tab === 'list' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2.5 text-sm font-medium border-b-2 transition-colors">
                    Doctors List
                </button>
                <button type="button" @click="tab = 'settings'"
                    :class="tab === 'settings' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2.5 text-sm font-medium border-b-2 transition-colors">
                    Page Settings
                </button>
            </div>

            <!-- ═══════════ Doctors List tab ═══════════ -->
            <div v-if="tab === 'list'" class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">#</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Photo</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Name</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Role</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Order</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Featured</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Status</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(doc, i) in doctors" :key="doc.id"
                            class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-gray-500">{{ i + 1 }}</td>
                            <td class="px-4 py-3">
                                <img v-if="doc.photo" :src="`/storage/${doc.photo}`"
                                    class="w-12 h-12 object-cover rounded-full" alt="" />
                                <div v-else class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-xs text-gray-400">
                                    No photo
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-700 max-w-[180px]">
                                <p class="font-medium truncate">{{ doc.name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ doc.slug }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs max-w-[160px]">
                                <span class="line-clamp-2">{{ doc.role || '—' }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ doc.sort_order }}</td>
                            <td class="px-4 py-3">
                                <span :class="doc.is_featured
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-gray-100 text-gray-400'"
                                    class="px-2 py-0.5 rounded-full text-xs font-semibold">
                                    {{ doc.is_featured ? 'Featured' : 'No' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <button @click="toggleStatus(doc)"
                                    :class="doc.is_active
                                        ? 'bg-green-100 text-green-700 hover:bg-green-200'
                                        : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
                                    class="px-2.5 py-0.5 rounded-full text-xs font-semibold transition-colors">
                                    {{ doc.is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a :href="route('admin.doctors.edit', doc.id)"
                                        class="px-3 py-1.5 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">
                                        Edit
                                    </a>
                                    <button @click="confirmDelete(doc)"
                                        class="px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!doctors.length">
                            <td colspan="8" class="px-4 py-10 text-center text-gray-400">
                                No doctors yet. Add your first doctor.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ═══════════ Page Settings tab ═══════════ -->
            <div v-else class="max-w-3xl space-y-4">
                <form @submit.prevent="submitSettings" class="space-y-4">

                    <!-- Home page "Meet Our Doctor" section -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Home Page — "Meet Our Doctor" Section</h2>
                        <p class="text-xs text-gray-400 -mt-2">Shows your <strong>Featured</strong> doctors as cards. Mark a doctor "Featured" in the list tab to include it.</p>

                        <div>
                            <label class="label">Eyebrow / Badge</label>
                            <input v-model="settingsForm.doc_home_badge" type="text" class="input" placeholder="Our Doctor" />
                            <InputError :message="settingsForm.errors.doc_home_badge" />
                        </div>
                        <div>
                            <label class="label">Section Title</label>
                            <input v-model="settingsForm.doc_home_title" type="text" class="input" placeholder="Meet Our Doctor" />
                            <InputError :message="settingsForm.errors.doc_home_title" />
                        </div>
                    </section>

                    <!-- Doctors List page hero / breadcrumb -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Doctors List Page — Hero &amp; Breadcrumb</h2>
                        <div>
                            <label class="label">Page Title <span class="text-xs text-gray-400">(shown in breadcrumb banner)</span></label>
                            <input v-model="settingsForm.doc_page_hero_title" type="text" class="input" placeholder="Our Doctors" />
                            <InputError :message="settingsForm.errors.doc_page_hero_title" />
                        </div>
                        <div>
                            <label class="label">Banner Background Image</label>
                            <DropZone @change="file => onImage(file, 'hero')" hint="Recommended: 1920×500px. JPEG / PNG / WebP" preview-class="w-full h-40 object-cover"
                                :existing-preview="currentHeroImage ? '/storage/' + currentHeroImage : null" />
                            <InputError :message="settingsForm.errors.doc_page_hero_image" />
                        </div>
                    </section>

                    <!-- Doctors List page section head -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Doctors List Page — Section Head</h2>
                        <div>
                            <label class="label">Eyebrow / Badge</label>
                            <input v-model="settingsForm.doc_badge" type="text" class="input" placeholder="Our Team Member" />
                            <InputError :message="settingsForm.errors.doc_badge" />
                        </div>
                        <div>
                            <label class="label">Section Title</label>
                            <input v-model="settingsForm.doc_title" type="text" class="input" placeholder="Meet Our Doctor Meeting" />
                            <InputError :message="settingsForm.errors.doc_title" />
                        </div>
                    </section>

                    <!-- SEO -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Doctors List Page — SEO Configuration</h2>
                        <div>
                            <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars, auto-filled if left blank)</span></label>
                            <input v-model="settingsForm.doc_seo_title" @input="onMetaTitleInput" type="text" class="input" placeholder="Our Doctors | ClinicMaster" maxlength="160" />
                            <p class="text-xs text-gray-400 mt-1">{{ (settingsForm.doc_seo_title || '').length }}/160</p>
                            <InputError :message="settingsForm.errors.doc_seo_title" />
                        </div>
                        <div>
                            <label class="label">Meta Description <span class="text-xs text-gray-400">(max 320 chars)</span></label>
                            <textarea v-model="settingsForm.doc_seo_description" @input="onMetaDescInput" rows="3" class="input resize-none" maxlength="320"></textarea>
                            <p class="text-xs text-gray-400 mt-1">{{ (settingsForm.doc_seo_description || '').length }}/320</p>
                            <InputError :message="settingsForm.errors.doc_seo_description" />
                        </div>
                        <div>
                            <label class="label">Meta Keywords <span class="text-xs text-gray-400">(comma-separated, auto-filled if left blank)</span></label>
                            <input v-model="settingsForm.doc_seo_keywords" @input="onMetaKeywordsInput" type="text" class="input" />
                            <InputError :message="settingsForm.errors.doc_seo_keywords" />
                        </div>
                        <div>
                            <label class="label">OG / Social Share Image <span class="text-xs text-gray-400">(recommended 1200×630px)</span></label>
                            <DropZone @change="file => onImage(file, 'og')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-36 object-cover"
                                :existing-preview="currentOgImage ? '/storage/' + currentOgImage : null" />
                            <InputError :message="settingsForm.errors.doc_seo_og_image" />
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
                    <h3 class="font-semibold text-gray-800 mb-2">Delete Doctor</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Are you sure you want to delete
                        "<strong>{{ deleteTarget.name }}</strong>"?
                        This cannot be undone.
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
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import { useSeoAutoFill } from '@/Composables/useSeoAutoFill';

const props = defineProps({
    doctors:      { type: Array, default: () => [] },
    pageSettings: { type: Object, default: () => ({}) },
});

const tab = ref('list');
const deleteTarget = ref(null);

function confirmDelete(doc) {
    deleteTarget.value = doc;
}

function doDelete() {
    router.delete(route('admin.doctors.destroy', deleteTarget.value.id), {
        onFinish: () => { deleteTarget.value = null; },
    });
}

function toggleStatus(doc) {
    router.patch(route('admin.doctors.toggle', doc.id));
}

// ── Page Settings tab ──
const currentHeroImage = ref(props.pageSettings.doc_page_hero_image ?? null);
const currentOgImage   = ref(props.pageSettings.doc_seo_og_image ?? null);

const settingsForm = useForm({
    doc_home_badge:       props.pageSettings.doc_home_badge ?? '',
    doc_home_title:       props.pageSettings.doc_home_title ?? '',
    doc_page_hero_image: null,
    doc_page_hero_title:  props.pageSettings.doc_page_hero_title ?? '',
    doc_badge:            props.pageSettings.doc_badge ?? '',
    doc_title:            props.pageSettings.doc_title ?? '',
    doc_seo_title:        props.pageSettings.doc_seo_title       ?? '',
    doc_seo_description:  props.pageSettings.doc_seo_description ?? '',
    doc_seo_keywords:     props.pageSettings.doc_seo_keywords    ?? '',
    doc_seo_og_image:    null,
});

const { onMetaTitleInput, onMetaDescInput, onMetaKeywordsInput } = useSeoAutoFill(settingsForm, {
    titleSource: () => settingsForm.doc_title,
    descSource:  () => settingsForm.doc_home_title,
    titleKey:    'doc_seo_title',
    descKey:     'doc_seo_description',
    keywordsKey: 'doc_seo_keywords',
});

function onImage(file, type) {
    if (!file) return;
    if (type === 'hero') {
        settingsForm.doc_page_hero_image = file;
    } else {
        settingsForm.doc_seo_og_image = file;
    }
}

function submitSettings() {
    settingsForm.post(route('admin.website-settings.doctors.update'), {
        forceFormData: true,
        preserveScroll: true,
    });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
