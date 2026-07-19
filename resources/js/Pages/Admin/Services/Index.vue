<template>
    <AdminLayout>
        <div class="space-y-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Services Management</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Manage services shown on the home page, service listing, and detail pages</p>
                </div>
                <a v-if="tab === 'list'" :href="route('admin.services.create')"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                    + Add Service
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
                    Services List
                </button>
                <button type="button" @click="tab = 'settings'"
                    :class="tab === 'settings' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2.5 text-sm font-medium border-b-2 transition-colors">
                    Page Settings
                </button>
            </div>

            <!-- ═══════════ Services List tab ═══════════ -->
            <div v-if="tab === 'list'" class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">#</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Image</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Title</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Short Desc</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Order</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Featured</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Status</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(svc, i) in services" :key="svc.id"
                            class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-gray-500">{{ i + 1 }}</td>
                            <td class="px-4 py-3">
                                <img v-if="svc.image" :src="`/storage/${svc.image}`"
                                    class="w-20 h-12 object-cover rounded" alt="" />
                                <div v-else class="w-20 h-12 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-400">
                                    No image
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-700 max-w-[180px]">
                                <p class="font-medium truncate">{{ svc.title }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ svc.slug }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs max-w-[200px]">
                                <span class="line-clamp-2">{{ svc.short_desc || '—' }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ svc.sort_order }}</td>
                            <td class="px-4 py-3">
                                <span :class="svc.is_featured
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-gray-100 text-gray-400'"
                                    class="px-2 py-0.5 rounded-full text-xs font-semibold">
                                    {{ svc.is_featured ? 'Featured' : 'No' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <button @click="toggleStatus(svc)"
                                    :class="svc.is_active
                                        ? 'bg-green-100 text-green-700 hover:bg-green-200'
                                        : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
                                    class="px-2.5 py-0.5 rounded-full text-xs font-semibold transition-colors">
                                    {{ svc.is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a :href="route('admin.services.edit', svc.id)"
                                        class="px-3 py-1.5 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">
                                        Edit
                                    </a>
                                    <button @click="confirmDelete(svc)"
                                        class="px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!services.length">
                            <td colspan="8" class="px-4 py-10 text-center text-gray-400">
                                No services yet. Add your first service.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ═══════════ Page Settings tab ═══════════ -->
            <div v-else class="max-w-3xl space-y-4">
                <form @submit.prevent="submitSettings" class="space-y-4">

                    <!-- Home page "Departments" section -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Home Page — "Departments" Section</h2>
                        <p class="text-xs text-gray-400 -mt-2">Shows your <strong>Featured</strong> services as cards. Mark a service "Featured" in the list tab to include it.</p>

                        <div>
                            <label class="label">Eyebrow / Badge</label>
                            <input v-model="settingsForm.svc_badge" type="text" class="input" placeholder="Medical & General Care!" />
                            <InputError :message="settingsForm.errors.svc_badge" />
                        </div>
                        <div>
                            <label class="label">Section Title</label>
                            <input v-model="settingsForm.svc_title" type="text" class="input" placeholder="Amazing Services" />
                            <InputError :message="settingsForm.errors.svc_title" />
                        </div>
                        <div>
                            <label class="label">Section Description</label>
                            <textarea v-model="settingsForm.svc_desc" rows="2" class="input"></textarea>
                            <InputError :message="settingsForm.errors.svc_desc" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label">"View All" Button Text</label>
                                <input v-model="settingsForm.svc_btn_text" type="text" class="input" placeholder="View All Services" />
                            </div>
                            <div>
                                <label class="label">"View All" Button URL</label>
                                <input v-model="settingsForm.svc_btn_url" type="text" class="input" placeholder="/services" />
                            </div>
                        </div>
                    </section>

                    <!-- Service List page hero / breadcrumb -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Service List Page — Hero &amp; Breadcrumb</h2>
                        <div>
                            <label class="label">Page Title <span class="text-xs text-gray-400">(shown in breadcrumb banner)</span></label>
                            <input v-model="settingsForm.svc_page_hero_title" type="text" class="input" placeholder="Our Services" />
                            <InputError :message="settingsForm.errors.svc_page_hero_title" />
                        </div>
                        <div>
                            <label class="label">Banner Background Image</label>
                            <DropZone @change="file => onImage(file, 'hero')" hint="Recommended: 1920×500px. JPEG / PNG / WebP" preview-class="w-full h-40 object-cover"
                                :existing-preview="currentHeroImage ? '/storage/' + currentHeroImage : null" />
                            <InputError :message="settingsForm.errors.svc_page_hero_image" />
                        </div>
                    </section>

                    <!-- SEO -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Service List Page — SEO Configuration</h2>
                        <div>
                            <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars, auto-filled if left blank)</span></label>
                            <input v-model="settingsForm.svc_seo_title" @input="onMetaTitleInput" type="text" class="input" placeholder="Our Services | ClinicMaster" maxlength="160" />
                            <p class="text-xs text-gray-400 mt-1">{{ (settingsForm.svc_seo_title || '').length }}/160</p>
                            <InputError :message="settingsForm.errors.svc_seo_title" />
                        </div>
                        <div>
                            <label class="label">Meta Description <span class="text-xs text-gray-400">(max 320 chars)</span></label>
                            <textarea v-model="settingsForm.svc_seo_description" @input="onMetaDescInput" rows="3" class="input resize-none" maxlength="320"></textarea>
                            <p class="text-xs text-gray-400 mt-1">{{ (settingsForm.svc_seo_description || '').length }}/320</p>
                            <InputError :message="settingsForm.errors.svc_seo_description" />
                        </div>
                        <div>
                            <label class="label">Meta Keywords <span class="text-xs text-gray-400">(comma-separated, auto-filled if left blank)</span></label>
                            <input v-model="settingsForm.svc_seo_keywords" @input="onMetaKeywordsInput" type="text" class="input" />
                            <InputError :message="settingsForm.errors.svc_seo_keywords" />
                        </div>
                        <div>
                            <label class="label">OG / Social Share Image <span class="text-xs text-gray-400">(recommended 1200×630px)</span></label>
                            <DropZone @change="file => onImage(file, 'og')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-36 object-cover"
                                :existing-preview="currentOgImage ? '/storage/' + currentOgImage : null" />
                            <InputError :message="settingsForm.errors.svc_seo_og_image" />
                        </div>
                    </section>

                    <!-- Detail page sidebar help box -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Service Detail Page — "Do You Need Any Help?" Box</h2>
                        <div>
                            <label class="label">Box Title</label>
                            <input v-model="settingsForm.svc_help_title" type="text" class="input" placeholder="Do you need any help?" />
                            <InputError :message="settingsForm.errors.svc_help_title" />
                        </div>
                        <div>
                            <label class="label">Description Text</label>
                            <textarea v-model="settingsForm.svc_help_desc" rows="3" class="input resize-none"></textarea>
                            <InputError :message="settingsForm.errors.svc_help_desc" />
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
                    <h3 class="font-semibold text-gray-800 mb-2">Delete Service</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Are you sure you want to delete
                        "<strong>{{ deleteTarget.title }}</strong>"?
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
    services:     { type: Array, default: () => [] },
    pageSettings: { type: Object, default: () => ({}) },
});

const tab = ref('list');
const deleteTarget = ref(null);

function confirmDelete(svc) {
    deleteTarget.value = svc;
}

function doDelete() {
    router.delete(route('admin.services.destroy', deleteTarget.value.id), {
        onFinish: () => { deleteTarget.value = null; },
    });
}

function toggleStatus(svc) {
    router.patch(route('admin.services.toggle', svc.id));
}

// ── Page Settings tab ──
const currentHeroImage = ref(props.pageSettings.svc_page_hero_image ?? null);
const currentOgImage   = ref(props.pageSettings.svc_seo_og_image ?? null);

const settingsForm = useForm({
    svc_page_hero_image: null,
    svc_page_hero_title: props.pageSettings.svc_page_hero_title ?? '',
    svc_seo_title:        props.pageSettings.svc_seo_title       ?? '',
    svc_seo_description:  props.pageSettings.svc_seo_description ?? '',
    svc_seo_keywords:     props.pageSettings.svc_seo_keywords    ?? '',
    svc_seo_og_image:    null,
    svc_badge:            props.pageSettings.svc_badge    ?? '',
    svc_title:            props.pageSettings.svc_title    ?? '',
    svc_desc:             props.pageSettings.svc_desc     ?? '',
    svc_btn_text:         props.pageSettings.svc_btn_text ?? '',
    svc_btn_url:          props.pageSettings.svc_btn_url  ?? '',
    svc_help_title:       props.pageSettings.svc_help_title ?? '',
    svc_help_desc:        props.pageSettings.svc_help_desc  ?? '',
});

const { onMetaTitleInput, onMetaDescInput, onMetaKeywordsInput } = useSeoAutoFill(settingsForm, {
    titleSource: () => settingsForm.svc_title,
    descSource:  () => settingsForm.svc_desc,
    titleKey:    'svc_seo_title',
    descKey:     'svc_seo_description',
    keywordsKey: 'svc_seo_keywords',
});

function onImage(file, type) {
    if (!file) return;
    if (type === 'hero') {
        settingsForm.svc_page_hero_image = file;
    } else {
        settingsForm.svc_seo_og_image = file;
    }
}

function submitSettings() {
    settingsForm.post(route('admin.website-settings.services.update'), {
        forceFormData: true,
        preserveScroll: true,
    });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
