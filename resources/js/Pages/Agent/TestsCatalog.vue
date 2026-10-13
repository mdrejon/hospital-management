<template>
    <AgentLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <span>🔬</span> Diagnostic Tests & Commission List
                    </h1>
                    <p class="text-xs text-gray-500 mt-1">
                        Private reference catalog for agents to check official hospital test prices, turnaround times, and your earned commission rates.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <Link :href="route('agent.test.create')" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                        <span>➕</span> Book Medical Test
                    </Link>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl border border-gray-200/80 p-4 shadow-xs">
                    <div class="text-2xs uppercase tracking-wider text-gray-400 font-semibold">Total Available Tests</div>
                    <div class="text-2xl font-black text-gray-900 mt-1">{{ tests.total || 0 }}</div>
                </div>
                <div class="bg-white rounded-xl border border-gray-200/80 p-4 shadow-xs">
                    <div class="text-2xs uppercase tracking-wider text-gray-400 font-semibold">Default Agent Commission</div>
                    <div class="text-2xl font-black text-purple-600 mt-1">{{ agent?.test_commission_rate || 15 }}%</div>
                </div>
                <div class="bg-white rounded-xl border border-gray-200/80 p-4 shadow-xs">
                    <div class="text-2xs uppercase tracking-wider text-gray-400 font-semibold">Active Categories</div>
                    <div class="text-2xl font-black text-blue-600 mt-1">{{ categories.length }}</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl border border-gray-200/80 p-4 shadow-xs flex flex-col sm:flex-row items-center gap-3">
                <div class="relative flex-1 w-full">
                    <input 
                        v-model="searchQuery" 
                        @input="debounceSearch"
                        type="text" 
                        placeholder="Search by test name (e.g. CBC, Lipid, Sugar) or test code..." 
                        class="w-full pl-9 pr-4 py-2 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                    />
                    <span class="absolute left-3 top-2.5 text-gray-400 text-xs">🔍</span>
                </div>

                <div class="w-full sm:w-64">
                    <select 
                        v-model="selectedCategory" 
                        @change="applyFilter" 
                        class="w-full px-3 py-2 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white"
                    >
                        <option value="">All Categories ({{ categories.length }})</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                            {{ localized(cat.name) }}
                        </option>
                    </select>
                </div>

                <button 
                    v-if="searchQuery || selectedCategory" 
                    @click="resetFilters" 
                    type="button" 
                    class="px-3 py-2 text-xs text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors whitespace-nowrap"
                >
                    Reset Filters
                </button>
            </div>

            <!-- Tests Table -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-600">
                        <thead class="bg-gray-50/80 border-b border-gray-200 text-2xs uppercase tracking-wider text-gray-500 font-bold">
                            <tr>
                                <th class="px-5 py-3.5">Test Details</th>
                                <th class="px-5 py-3.5">Category</th>
                                <th class="px-5 py-3.5">Specimen / Sample</th>
                                <th class="px-5 py-3.5">Turnaround Time</th>
                                <th class="px-5 py-3.5 text-right">Hospital Price</th>
                                <th class="px-5 py-3.5 text-center">Your Commission</th>
                                <th class="px-5 py-3.5 text-right">Est. Earnings</th>
                                <th class="px-5 py-3.5 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="t in tests.data" :key="t.id" class="hover:bg-purple-50/20 transition-colors">
                                <td class="px-5 py-4">
                                    <div class="font-bold text-gray-900 text-sm">
                                        {{ localized(t.name) }}
                                    </div>
                                    <div class="font-mono text-2xs text-gray-400 mt-0.5">
                                        Code: {{ t.code }}
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="px-2 py-0.5 rounded-full text-3xs font-semibold uppercase bg-blue-50 text-blue-700 border border-blue-200">
                                        {{ localized(t.category?.name) || 'General' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-gray-700">
                                    {{ t.sample_type || 'N/A' }}
                                </td>
                                <td class="px-5 py-4 text-gray-500 font-mono text-2xs">
                                    {{ t.turnaround_time || 'Same day' }}
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="font-bold text-gray-900 text-sm">
                                        BDT {{ Number(t.final_price).toLocaleString() }}
                                    </div>
                                    <div v-if="t.discount_amount > 0" class="text-3xs text-gray-400 line-through">
                                        BDT {{ Number(t.price).toLocaleString() }}
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                        {{ t.agent_commission_rate }}%
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right font-mono font-bold text-emerald-600 text-sm">
                                    +BDT {{ Number(t.agent_estimated_commission).toLocaleString() }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <button 
                                        @click="openDetails(t)" 
                                        type="button" 
                                        class="px-2.5 py-1 text-2xs font-semibold text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded transition-colors"
                                    >
                                        Details
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="tests.data.length === 0">
                                <td colspan="8" class="px-5 py-12 text-center text-gray-400 text-sm">
                                    No medical tests match your search criteria.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="tests.links && tests.links.length > 3" class="p-4 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-xs text-gray-500">
                        Showing {{ tests.from || 0 }} to {{ tests.to || 0 }} of {{ tests.total }} tests
                    </div>
                    <div class="flex items-center gap-1">
                        <Link 
                            v-for="(link, i) in tests.links" 
                            :key="i" 
                            :href="link.url || '#'" 
                            :class="[
                                link.active ? 'bg-blue-600 text-white font-semibold' : 'text-gray-600 hover:bg-gray-100',
                                !link.url ? 'opacity-40 cursor-not-allowed pointer-events-none' : ''
                            ]" 
                            class="px-3 py-1.5 rounded text-xs border border-gray-200 transition-colors" 
                            v-html="link.label"
                        />
                    </div>
                </div>
            </div>

            <!-- Test Detail Modal -->
            <div v-if="selectedTest" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40">
                <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                    <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-blue-50">
                        <div>
                            <span class="text-3xs uppercase tracking-wider font-bold text-purple-700 bg-white/80 px-2 py-0.5 rounded border border-purple-200">
                                {{ localized(selectedTest.category?.name) || 'Diagnostic Test' }}
                            </span>
                            <h3 class="font-bold text-gray-900 text-base mt-1">{{ localized(selectedTest.name) }}</h3>
                            <p class="text-2xs font-mono text-gray-500">Code: {{ selectedTest.code }}</p>
                        </div>
                        <button @click="selectedTest = null" class="w-8 h-8 rounded-full hover:bg-gray-200 text-gray-400 hover:text-gray-600 text-lg flex items-center justify-center">
                            &times;
                        </button>
                    </div>

                    <div class="p-5 space-y-4 text-xs">
                        <!-- Commission & Pricing Breakdown Card -->
                        <div class="p-4 bg-purple-50/60 rounded-xl border border-purple-100 space-y-2">
                            <div class="text-2xs font-bold uppercase tracking-wider text-purple-900">
                                Agent Financial Breakdown
                            </div>
                            <div class="grid grid-cols-3 gap-2 pt-1 text-center">
                                <div class="bg-white p-2 rounded-lg border border-purple-100">
                                    <div class="text-3xs text-gray-400">Hospital Price</div>
                                    <div class="font-bold text-gray-900 font-mono text-sm mt-0.5">BDT {{ Number(selectedTest.final_price).toLocaleString() }}</div>
                                </div>
                                <div class="bg-white p-2 rounded-lg border border-purple-100">
                                    <div class="text-3xs text-gray-400">Commission Rate</div>
                                    <div class="font-bold text-purple-700 font-mono text-sm mt-0.5">{{ selectedTest.agent_commission_rate }}%</div>
                                </div>
                                <div class="bg-white p-2 rounded-lg border border-purple-100">
                                    <div class="text-3xs text-gray-400">Estimated Comm.</div>
                                    <div class="font-bold text-emerald-600 font-mono text-sm mt-0.5">+BDT {{ Number(selectedTest.agent_estimated_commission).toLocaleString() }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Technical Test Details -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <span class="text-3xs uppercase tracking-wider text-gray-400 block font-semibold">Specimen / Sample</span>
                                <strong class="text-gray-800 text-xs">{{ selectedTest.sample_type || 'Blood / Serum' }}</strong>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <span class="text-3xs uppercase tracking-wider text-gray-400 block font-semibold">Turnaround Time</span>
                                <strong class="text-gray-800 text-xs">{{ selectedTest.turnaround_time || '24 Hours' }}</strong>
                            </div>
                        </div>

                        <!-- Instructions -->
                        <div v-if="selectedTest.preparation_instructions" class="p-3 bg-blue-50/50 rounded-lg border border-blue-100">
                            <span class="text-3xs uppercase tracking-wider text-blue-800 block font-bold mb-1">Patient Preparation Instructions</span>
                            <p class="text-gray-700 text-xs leading-relaxed">{{ localized(selectedTest.preparation_instructions) }}</p>
                        </div>
                    </div>

                    <div class="p-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-2">
                        <button @click="selectedTest = null" type="button" class="px-4 py-2 text-xs font-medium text-gray-600 hover:bg-gray-200 rounded-lg transition-colors">
                            Close
                        </button>
                        <Link :href="route('agent.test.create')" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors">
                            Book This Test &rarr;
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AgentLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import AgentLayout from '@/Layouts/AgentLayout.vue';

const props = defineProps({
    tests:      { type: Object, required: true },
    categories: { type: Array, default: () => [] },
    agent:      { type: Object, default: () => ({}) },
    filters:    { type: Object, default: () => ({}) },
});

const searchQuery = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category_id || '');
const selectedTest = ref(null);

let searchTimeout = null;
function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilter();
    }, 350);
}

function applyFilter() {
    router.get(route('agent.tests.catalog'), {
        search: searchQuery.value || undefined,
        category_id: selectedCategory.value || undefined,
    }, {
        preserveState: true,
        replace: true,
    });
}

function resetFilters() {
    searchQuery.value = '';
    selectedCategory.value = '';
    applyFilter();
}

function openDetails(test) {
    selectedTest.value = test;
}

function localized(val) {
    if (!val) return '';
    if (typeof val === 'string') {
        try {
            const parsed = JSON.parse(val);
            if (typeof parsed === 'object' && parsed !== null) {
                return parsed.en || parsed[Object.keys(parsed)[0]] || val;
            }
        } catch (e) {
            return val;
        }
        return val;
    }
    if (typeof val === 'object') {
        return val.en || val[Object.keys(val)[0]] || '';
    }
    return String(val);
}
</script>
