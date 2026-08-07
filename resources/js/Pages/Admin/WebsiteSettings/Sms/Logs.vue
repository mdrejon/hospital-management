<template>
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">SMS Dispatch Logs</h1>
                    <p class="text-xs text-gray-500 mt-1">Audit log of all outgoing SMS alerts sent to patients and agents</p>
                </div>
                <Link :href="route('admin.website-settings.sms.edit')" class="px-3.5 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs">
                    &larr; Gateway Settings
                </Link>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-4 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <input v-model="filterSearch" @keyup.enter="applyFilters" type="text" placeholder="Search by recipient phone, event, text..." class="w-full sm:w-72 px-3 py-1.5 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    
                    <select v-model="filterStatus" @change="applyFilters" class="py-1.5 px-3 text-xs border border-gray-300 rounded-lg focus:outline-none bg-white">
                        <option value="">All Statuses</option>
                        <option value="sent">Sent</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button @click="applyFilters" class="px-4 py-1.5 text-xs font-semibold text-white bg-gray-800 rounded-lg hover:bg-gray-900">
                        Filter
                    </button>
                    <button v-if="filterSearch || filterStatus" @click="clearFilters" class="px-3 py-1.5 text-xs text-gray-500 hover:bg-gray-100 rounded-lg">
                        Clear
                    </button>
                </div>
            </div>

            <!-- Logs Table -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50/80 text-xs uppercase font-semibold text-gray-500 border-b border-gray-200">
                            <tr>
                                <th class="px-5 py-3.5">Recipient</th>
                                <th class="px-5 py-3.5">Event Type</th>
                                <th class="px-5 py-3.5">Message Content</th>
                                <th class="px-5 py-3.5">Gateway Response</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="log in logs.data" :key="log.id" class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-5 py-4 font-mono font-bold text-gray-900 text-xs">
                                    {{ log.recipient_phone }}
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-2xs font-semibold uppercase bg-blue-50 text-blue-700">
                                        {{ log.event_type }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-xs text-gray-700 max-w-sm">
                                    {{ log.message }}
                                </td>
                                <td class="px-5 py-4 text-2xs font-mono text-gray-400 max-w-xs truncate">
                                    {{ log.gateway_response || 'N/A' }}
                                </td>
                                <td class="px-5 py-4">
                                    <span :class="log.status === 'sent' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'" class="px-2.5 py-0.5 rounded-full text-2xs font-bold uppercase">
                                        {{ log.status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-xs text-gray-400">
                                    {{ new Date(log.created_at).toLocaleString() }}
                                </td>
                            </tr>
                            <tr v-if="logs.data.length === 0">
                                <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                                    No SMS records found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="logs.links?.length > 3" class="p-4 border-t border-gray-100 flex justify-center gap-1">
                    <Link v-for="(link, i) in logs.links" :key="i" :href="link.url || '#'" :class="[link.active ? 'bg-blue-600 text-white font-bold' : 'text-gray-600 hover:bg-gray-100', !link.url ? 'opacity-50 cursor-not-allowed' : '']" class="px-3 py-1.5 rounded-lg text-xs" v-html="link.label">
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
    logs:    { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
});

const filterSearch = ref(props.filters.search || '');
const filterStatus = ref(props.filters.status || '');

function applyFilters() {
    router.get(route('admin.website-settings.sms.logs'), {
        search: filterSearch.value,
        status: filterStatus.value,
    }, { preserveState: true, replace: true });
}

function clearFilters() {
    filterSearch.value = '';
    filterStatus.value = '';
    applyFilters();
}
</script>
