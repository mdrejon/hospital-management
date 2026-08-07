<template>
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Medical Test Categories</h1>
                    <p class="text-xs text-gray-500 mt-1">Organize pathology, radiology, biochemical and other diagnostic tests</p>
                </div>
                <div class="flex items-center gap-3">
                    <Link :href="route('admin.medical-tests.index')" class="px-3.5 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs">
                        &larr; Tests Catalog
                    </Link>
                    <button @click="openCreateModal" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-xs transition-all flex items-center gap-2">
                        <span>+</span> Add Category
                    </button>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50/80 text-xs uppercase font-semibold text-gray-500 border-b border-gray-200">
                            <tr>
                                <th class="px-5 py-3.5">Category Name</th>
                                <th class="px-5 py-3.5">Slug</th>
                                <th class="px-5 py-3.5">Total Tests</th>
                                <th class="px-5 py-3.5">Sort Order</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="cat in categories" :key="cat.id" class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                                            {{ cat.icon || '🧪' }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">{{ localized(cat.name) }}</div>
                                            <div v-if="cat.description" class="text-xs text-gray-400 max-w-sm truncate">{{ localized(cat.description) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 font-mono text-xs text-gray-500">
                                    {{ cat.slug }}
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                        {{ cat.tests_count || 0 }} tests
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-xs font-semibold text-gray-700">
                                    {{ cat.sort_order }}
                                </td>
                                <td class="px-5 py-4">
                                    <span :class="cat.is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600'" class="px-2.5 py-1 rounded-full text-xs font-semibold">
                                        {{ cat.is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="openEditModal(cat)" class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </button>
                                        <button @click="confirmDelete(cat)" class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="categories.length === 0">
                                <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                                    No categories yet. Click "Add Category" to create one.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal for Create / Edit -->
            <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs">
                <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h3 class="font-bold text-gray-900 text-lg">{{ editingCategory ? 'Edit Category' : 'Add Test Category' }}</h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                    </div>

                    <!-- Language selector tabs -->
                    <div class="flex border-b gap-4">
                        <button v-for="lang in languages" :key="lang.code" type="button" @click="activeLang = lang.code" :class="activeLang === lang.code ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500'" class="pb-2 text-xs border-b-2 uppercase">
                            {{ lang.name }} ({{ lang.code }})
                        </button>
                    </div>

                    <form @submit.prevent="saveCategory" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Category Name ({{ activeLang }}) *</label>
                            <input v-model="form.name[activeLang]" type="text" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="e.g. Hematology & Blood Tests" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Description ({{ activeLang }})</label>
                            <textarea v-model="form.description[activeLang]" rows="2" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Brief description..."></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Icon / Emoji</label>
                                <input v-model="form.icon" type="text" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="🧪, 🩸, 🩻" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Sort Order</label>
                                <input v-model="form.sort_order" type="number" min="0" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            </div>
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <input id="cat-active" v-model="form.is_active" type="checkbox" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500" />
                            <label for="cat-active" class="text-xs font-medium text-gray-700">Category Active</label>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3 border-t">
                            <button type="button" @click="showModal = false" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                            <button type="submit" :disabled="form.processing" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-xs">
                                {{ editingCategory ? 'Update' : 'Create' }} Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    categories: { type: Array, default: () => [] },
    languages:  { type: Array, default: () => [{ code: 'en', name: 'English' }] },
});

const showModal = ref(false);
const editingCategory = ref(null);
const activeLang = ref(props.languages[0]?.code || 'en');

function localized(field) {
    if (!field) return '';
    if (typeof field === 'string') return field;
    return field[activeLang.value] || field['en'] || Object.values(field)[0] || '';
}

const form = useForm({
    name: {},
    description: {},
    icon: '🧪',
    sort_order: 0,
    is_active: true,
});

function openCreateModal() {
    editingCategory.value = null;
    form.reset();
    form.name = {};
    form.description = {};
    props.languages.forEach(l => {
        form.name[l.code] = '';
        form.description[l.code] = '';
    });
    form.icon = '🧪';
    form.sort_order = props.categories.length;
    form.is_active = true;
    showModal.value = true;
}

function openEditModal(cat) {
    editingCategory.value = cat;
    form.name = typeof cat.name === 'object' ? { ...cat.name } : { en: cat.name };
    form.description = typeof cat.description === 'object' ? { ...cat.description } : { en: cat.description };
    props.languages.forEach(l => {
        if (!form.name[l.code]) form.name[l.code] = '';
        if (!form.description[l.code]) form.description[l.code] = '';
    });
    form.icon = cat.icon || '🧪';
    form.sort_order = cat.sort_order;
    form.is_active = Boolean(cat.is_active);
    showModal.value = true;
}

function saveCategory() {
    if (editingCategory.value) {
        form.put(route('admin.medical-test-categories.update', editingCategory.value.id), {
            onSuccess: () => { showModal.value = false; }
        });
    } else {
        form.post(route('admin.medical-test-categories.store'), {
            onSuccess: () => { showModal.value = false; }
        });
    }
}

function confirmDelete(cat) {
    if (confirm(`Are you sure you want to delete the category "${localized(cat.name)}"?`)) {
        router.delete(route('admin.medical-test-categories.destroy', cat.id));
    }
}
</script>
