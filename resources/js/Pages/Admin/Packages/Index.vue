<template>
    <AdminLayout>
        <div class="space-y-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Packages Management</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Manage health packages shown on the home page and the packages listing/detail pages</p>
                </div>
                <a v-if="tab === 'list'" :href="route('admin.packages.create')"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                    + Add Package
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
                    Packages List
                </button>
                <button type="button" @click="tab = 'settings'"
                    :class="tab === 'settings' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2.5 text-sm font-medium border-b-2 transition-colors">
                    Page Settings
                </button>
            </div>

            <!-- ═══════════ Packages List tab ═══════════ -->
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
                        <tr v-for="(pkg, i) in packages" :key="pkg.id"
                            class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-gray-500">{{ i + 1 }}</td>
                            <td class="px-4 py-3">
                                <img v-if="pkg.image" :src="`/storage/${pkg.image}`"
                                    class="w-20 h-12 object-cover rounded" alt="" />
                                <div v-else class="w-20 h-12 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-400">
                                    No image
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-700 max-w-[180px]">
                                <p class="font-medium truncate">{{ pkg.title }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ pkg.slug }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs max-w-[200px]">
                                <span class="line-clamp-2">{{ pkg.short_desc || '—' }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ pkg.sort_order }}</td>
                            <td class="px-4 py-3">
                                <span :class="pkg.is_featured
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-gray-100 text-gray-400'"
                                    class="px-2 py-0.5 rounded-full text-xs font-semibold">
                                    {{ pkg.is_featured ? 'Featured' : 'No' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <button @click="toggleStatus(pkg)"
                                    :class="pkg.is_active
                                        ? 'bg-green-100 text-green-700 hover:bg-green-200'
                                        : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
                                    class="px-2.5 py-0.5 rounded-full text-xs font-semibold transition-colors">
                                    {{ pkg.is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a :href="route('admin.packages.edit', pkg.id)"
                                        class="px-3 py-1.5 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">
                                        Edit
                                    </a>
                                    <button @click="confirmDelete(pkg)"
                                        class="px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!packages.length">
                            <td colspan="8" class="px-4 py-10 text-center text-gray-400">
                                No packages yet. Add your first package.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ═══════════ Page Settings tab ═══════════ -->
            <div v-else class="max-w-3xl space-y-4">
                <form @submit.prevent="submitSettings" class="space-y-4">

                    <!-- Home page "Packages" section -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Home Page — "Health Packages" Section</h2>
                        <p class="text-xs text-gray-400 -mt-2">Shows your <strong>Featured</strong> packages as cards. Mark a package "Featured" in the list tab to include it.</p>

                        <div>
                            <label class="label">Eyebrow / Badge</label>
                            <input v-model="settingsForm.pkg_badge" type="text" class="input" placeholder="Our Health Packages" />
                            <InputError :message="settingsForm.errors.pkg_badge" />
                        </div>
                        <div>
                            <label class="label">Section Title</label>
                            <input v-model="settingsForm.pkg_title" type="text" class="input" placeholder="Best Medical Assistance Packages" />
                            <InputError :message="settingsForm.errors.pkg_title" />
                        </div>
                        <div>
                            <label class="label">Section Description</label>
                            <textarea v-model="settingsForm.pkg_desc" rows="2" class="input"></textarea>
                            <InputError :message="settingsForm.errors.pkg_desc" />
                        </div>
                    </section>

                    <!-- Package List page hero / breadcrumb -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Package List Page — Hero &amp; Breadcrumb</h2>
                        <div>
                            <label class="label">Page Title <span class="text-xs text-gray-400">(shown in breadcrumb banner)</span></label>
                            <input v-model="settingsForm.pkg_page_hero_title" type="text" class="input" placeholder="Our Health Packages" />
                            <InputError :message="settingsForm.errors.pkg_page_hero_title" />
                        </div>
                        <div>
                            <label class="label">Banner Background Image</label>
                            <DropZone @change="file => onImage(file, 'hero')" hint="Recommended: 1920×500px. JPEG / PNG / WebP" preview-class="w-full h-40 object-cover"
                                :existing-preview="currentHeroImage ? '/storage/' + currentHeroImage : null" />
                            <InputError :message="settingsForm.errors.pkg_page_hero_image" />
                        </div>
                    </section>

                    <!-- SEO -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Package List Page — SEO Configuration</h2>
                        <div>
                            <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars, auto-filled if left blank)</span></label>
                            <input v-model="settingsForm.pkg_seo_title" @input="onMetaTitleInput" type="text" class="input" placeholder="Our Health Packages | ClinicMaster" maxlength="160" />
                            <p class="text-xs text-gray-400 mt-1">{{ (settingsForm.pkg_seo_title || '').length }}/160</p>
                            <InputError :message="settingsForm.errors.pkg_seo_title" />
                        </div>
                        <div>
                            <label class="label">Meta Description <span class="text-xs text-gray-400">(max 320 chars)</span></label>
                            <textarea v-model="settingsForm.pkg_seo_description" @input="onMetaDescInput" rows="3" class="input resize-none" maxlength="320"></textarea>
                            <p class="text-xs text-gray-400 mt-1">{{ (settingsForm.pkg_seo_description || '').length }}/320</p>
                            <InputError :message="settingsForm.errors.pkg_seo_description" />
                        </div>
                        <div>
                            <label class="label">Meta Keywords <span class="text-xs text-gray-400">(comma-separated, auto-filled if left blank)</span></label>
                            <input v-model="settingsForm.pkg_seo_keywords" @input="onMetaKeywordsInput" type="text" class="input" />
                            <InputError :message="settingsForm.errors.pkg_seo_keywords" />
                        </div>
                        <div>
                            <label class="label">OG / Social Share Image <span class="text-xs text-gray-400">(recommended 1200×630px)</span></label>
                            <DropZone @change="file => onImage(file, 'og')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-36 object-cover"
                                :existing-preview="currentOgImage ? '/storage/' + currentOgImage : null" />
                            <InputError :message="settingsForm.errors.pkg_seo_og_image" />
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
                    <h3 class="font-semibold text-gray-800 mb-2">Delete Package</h3>
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
    packages:     { type: Array, default: () => [] },
    pageSettings: { type: Object, default: () => ({}) },
});

const tab = ref('list');
const deleteTarget = ref(null);

function confirmDelete(pkg) {
    deleteTarget.value = pkg;
}

function doDelete() {
    router.delete(route('admin.packages.destroy', deleteTarget.value.id), {
        onFinish: () => { deleteTarget.value = null; },
    });
}

function toggleStatus(pkg) {
    router.patch(route('admin.packages.toggle', pkg.id));
}

// ── Page Settings tab ──
const currentHeroImage = ref(props.pageSettings.pkg_page_hero_image ?? null);
const currentOgImage   = ref(props.pageSettings.pkg_seo_og_image ?? null);

const settingsForm = useForm({
    pkg_page_hero_image: null,
    pkg_page_hero_title: props.pageSettings.pkg_page_hero_title ?? '',
    pkg_seo_title:        props.pageSettings.pkg_seo_title       ?? '',
    pkg_seo_description:  props.pageSettings.pkg_seo_description ?? '',
    pkg_seo_keywords:     props.pageSettings.pkg_seo_keywords    ?? '',
    pkg_seo_og_image:    null,
    pkg_badge:            props.pageSettings.pkg_badge ?? '',
    pkg_title:            props.pageSettings.pkg_title ?? '',
    pkg_desc:             props.pageSettings.pkg_desc  ?? '',
});

const { onMetaTitleInput, onMetaDescInput, onMetaKeywordsInput } = useSeoAutoFill(settingsForm, {
    titleSource: () => settingsForm.pkg_title,
    descSource:  () => settingsForm.pkg_desc,
    titleKey:    'pkg_seo_title',
    descKey:     'pkg_seo_description',
    keywordsKey: 'pkg_seo_keywords',
});

function onImage(file, type) {
    if (!file) return;
    if (type === 'hero') {
        settingsForm.pkg_page_hero_image = file;
    } else {
        settingsForm.pkg_seo_og_image = file;
    }
}

function submitSettings() {
    settingsForm.post(route('admin.website-settings.packages.update'), {
        forceFormData: true,
        preserveScroll: true,
    });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
