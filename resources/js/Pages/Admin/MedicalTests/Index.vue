<template>
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Diagnostic & Medical Tests Catalog</h1>
                    <p class="text-xs text-gray-500 mt-1">Configure diagnostic test pricing, preparation guidelines, and sample types</p>
                </div>
                <div class="flex items-center gap-3">
                    <Link :href="route('admin.medical-test-categories.index')" class="px-3.5 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs">
                        Manage Categories
                    </Link>
                    <Link :href="route('admin.medical-test-bookings.create')" class="px-3.5 py-2 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 shadow-xs">
                        + New Test Booking
                    </Link>
                    <Link :href="route('admin.medical-tests.create')" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-xs transition-all flex items-center gap-2">
                        <span>+</span> Add Test
                    </Link>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-4 flex flex-col md:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <div class="relative w-full sm:w-64">
                        <input v-model="search" @keyup.enter="applyFilters" type="text" placeholder="Search by name, code..." class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        <svg class="w-4 h-4 absolute left-2.5 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>

                    <select v-model="selectedCategory" @change="applyFilters" class="py-2 px-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="">All Categories</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ localized(cat.name) }}</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button @click="applyFilters" class="px-4 py-2 text-xs font-semibold text-white bg-gray-800 rounded-lg hover:bg-gray-900">
                        Search
                    </button>
                    <button v-if="search || selectedCategory" @click="clearFilters" class="px-3 py-2 text-xs text-gray-600 hover:bg-gray-100 rounded-lg">
                        Reset
                    </button>
                </div>
            </div>

            <!-- Tests Table -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50/80 text-xs uppercase font-semibold text-gray-500 border-b border-gray-200">
                            <tr>
                                <th class="px-5 py-3.5">Test Code & Name</th>
                                <th class="px-5 py-3.5">Category</th>
                                <th class="px-5 py-3.5">Pricing</th>
                                <th class="px-5 py-3.5">Sample / Specimen</th>
                                <th class="px-5 py-3.5">Delivery Time</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="t in tests.data" :key="t.id" class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-5 py-4">
                                    <div class="font-bold text-gray-900">{{ localized(t.name) }}</div>
                                    <div class="text-xs text-blue-600 font-mono mt-0.5">Code: {{ t.code }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                        {{ localized(t.category?.name) || 'General' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-baseline gap-1.5">
                                        <span class="font-black text-gray-900 text-sm">BDT {{ Number(t.final_price).toLocaleString() }}</span>
                                        <span v-if="t.discount_amount > 0" class="text-xs text-gray-400 line-through">
                                            BDT {{ Number(t.price).toLocaleString() }}
                                        </span>
                                    </div>
                                    <div v-if="t.discount_amount > 0" class="text-2xs font-semibold text-emerald-600">
                                        Discount: {{ t.discount_type === 'percentage' ? t.discount_amount + '%' : 'BDT ' + t.discount_amount }}
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-xs text-gray-600">
                                    {{ t.sample_type || 'N/A' }}
                                </td>
                                <td class="px-5 py-4 text-xs text-gray-600">
                                    {{ t.delivery_time || 'Same Day' }}
                                </td>
                                <td class="px-5 py-4">
                                    <span :class="t.is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600'" class="px-2.5 py-1 rounded-full text-xs font-semibold">
                                        {{ t.is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Link :href="route('admin.medical-tests.edit', t.id)" class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </Link>
                                        <button @click="confirmDelete(t)" class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="tests.data.length === 0">
                                <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                                    <div class="text-3xl mb-2">🔬</div>
                                    No medical tests found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="tests.links?.length > 3" class="p-4 border-t border-gray-100 flex justify-center gap-1">
                    <Link v-for="(link, i) in tests.links" :key="i" :href="link.url || '#'" :class="[link.active ? 'bg-blue-600 text-white font-bold' : 'text-gray-600 hover:bg-gray-100', !link.url ? 'opacity-50 cursor-not-allowed' : '']" class="px-3 py-1.5 rounded-lg text-xs" v-html="link.label">
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    tests:      { type: Object, required: true },
    categories: { type: Array, default: () => [] },
    filters:    { type: Object, default: () => ({}) },
});

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category_id || '');

function localized(field) {
    if (!field) return '';
    if (typeof field === 'string') return field;
    return field['en'] || Object.values(field)[0] || '';
}

function applyFilters() {
    router.get(route('admin.medical-tests.index'), {
        search: search.value,
        category_id: selectedCategory.value,
    }, { preserveState: true, replace: true });
}

function clearFilters() {
    search.value = '';
    selectedCategory.value = '';
    applyFilters();
}

function confirmDelete(t) {
    if (confirm(`Are you sure you want to delete "${localized(t.name)}"?`)) {
        router.delete(route('admin.medical-tests.destroy', t.id));
    }
}
</script>
