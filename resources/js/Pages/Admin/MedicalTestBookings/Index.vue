<template>
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Diagnostic Test Bookings</h1>
                    <p class="text-xs text-gray-500 mt-1">Manage patient medical test orders, sample status, report delivery, and billing</p>
                </div>
                <div class="flex items-center gap-3">
                    <Link :href="route('admin.medical-tests.index')" class="px-3.5 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs">
                        Tests Catalog
                    </Link>
                    <Link :href="route('admin.medical-test-bookings.create')" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-xs transition-all flex items-center gap-2">
                        <span>+</span> Book Medical Test
                    </Link>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-6 gap-3">
                <div class="bg-white p-4 rounded-xl border border-gray-200/80 shadow-xs">
                    <div class="text-xs font-semibold text-gray-400 uppercase">Total Orders</div>
                    <div class="text-2xl font-black text-gray-900 mt-1">{{ stats.total_bookings }}</div>
                </div>
                <div class="bg-amber-50/70 p-4 rounded-xl border border-amber-200 shadow-xs">
                    <div class="text-xs font-semibold text-amber-700 uppercase">Sample Pending</div>
                    <div class="text-2xl font-black text-amber-900 mt-1">{{ stats.pending_samples }}</div>
                </div>
                <div class="bg-blue-50/70 p-4 rounded-xl border border-blue-200 shadow-xs">
                    <div class="text-xs font-semibold text-blue-700 uppercase">In Lab / Processing</div>
                    <div class="text-2xl font-black text-blue-900 mt-1">{{ stats.processing_tests }}</div>
                </div>
                <div class="bg-emerald-50/70 p-4 rounded-xl border border-emerald-200 shadow-xs">
                    <div class="text-xs font-semibold text-emerald-700 uppercase">Completed / Ready</div>
                    <div class="text-2xl font-black text-emerald-900 mt-1">{{ stats.completed_tests }}</div>
                </div>
                <div class="bg-purple-50/70 p-4 rounded-xl border border-purple-200 shadow-xs">
                    <div class="text-xs font-semibold text-purple-700 uppercase">Total Bill</div>
                    <div class="text-lg font-black text-purple-900 mt-1.5">BDT {{ Number(stats.total_test_amount).toLocaleString() }}</div>
                </div>
                <div class="bg-teal-50/70 p-4 rounded-xl border border-teal-200 shadow-xs">
                    <div class="text-xs font-semibold text-teal-700 uppercase">Collected</div>
                    <div class="text-lg font-black text-teal-900 mt-1.5">BDT {{ Number(stats.total_collected).toLocaleString() }}</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-4 flex flex-wrap items-center gap-3">
                <div class="relative flex-1 min-w-[200px]">
                    <input v-model="filterSearch" @keyup.enter="applyFilters" type="text" placeholder="Search by booking #, patient, phone..." class="w-full pl-8 pr-3 py-1.5 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    <svg class="w-3.5 h-3.5 absolute left-2.5 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>

                <select v-model="filterStatus" @change="applyFilters" class="py-1.5 px-3 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="sample_collected">Sample Collected</option>
                    <option value="processing">Processing in Lab</option>
                    <option value="completed">Completed / Ready</option>
                    <option value="cancelled">Cancelled</option>
                </select>

                <select v-model="filterPayment" @change="applyFilters" class="py-1.5 px-3 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                    <option value="">All Payments</option>
                    <option value="paid">Fully Paid</option>
                    <option value="partial">Partial</option>
                    <option value="unpaid">Unpaid</option>
                </select>

                <select v-model="filterAgent" @change="applyFilters" class="py-1.5 px-3 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                    <option value="">All Agents</option>
                    <option v-for="a in agents" :key="a.id" :value="a.id">{{ a.user?.name }} ({{ a.agent_code }})</option>
                </select>

                <input v-model="filterDate" @change="applyFilters" type="date" class="py-1.5 px-3 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white" />

                <button @click="applyFilters" class="px-4 py-1.5 text-xs font-semibold text-white bg-gray-800 rounded-lg hover:bg-gray-900">
                    Apply
                </button>
                <button v-if="filterSearch || filterStatus || filterPayment || filterAgent || filterDate" @click="clearFilters" class="px-3 py-1.5 text-xs text-gray-500 hover:bg-gray-100 rounded-lg">
                    Clear
                </button>
            </div>

            <!-- Bookings Table -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50/80 text-xs uppercase font-semibold text-gray-500 border-b border-gray-200">
                            <tr>
                                <th class="px-5 py-3.5">Booking # & Patient</th>
                                <th class="px-5 py-3.5">Tests Included</th>
                                <th class="px-5 py-3.5">Referred By</th>
                                <th class="px-5 py-3.5">Booking Date</th>
                                <th class="px-5 py-3.5">Financials</th>
                                <th class="px-5 py-3.5">Test Status</th>
                                <th class="px-5 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="b in bookings.data" :key="b.id" class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-5 py-4">
                                    <Link :href="route('admin.medical-test-bookings.show', b.id)" class="font-bold text-blue-600 hover:underline">
                                        #{{ b.booking_number }}
                                    </Link>
                                    <div class="font-semibold text-gray-900 mt-0.5">{{ b.patient_name }}</div>
                                    <div class="text-xs text-gray-400 font-mono">{{ b.phone }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-50 text-purple-700">
                                        {{ b.items?.length || 0 }} test(s)
                                    </span>
                                    <div v-if="b.items?.length" class="text-2xs text-gray-500 mt-1 max-w-xs truncate">
                                        {{ b.items.map(i => i.test_name).join(', ') }}
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-xs">
                                    <div v-if="b.agent" class="text-emerald-700 font-semibold flex items-center gap-1">
                                        <span>🧑‍💼</span> {{ b.agent.user?.name }} ({{ b.agent.agent_code }})
                                    </div>
                                    <div v-else-if="b.doctor" class="text-blue-700">
                                        👨‍⚕️ Dr. {{ b.doctor.name }}
                                    </div>
                                    <div v-else class="text-gray-400">Direct Patient</div>
                                </td>
                                <td class="px-5 py-4 text-xs text-gray-600">
                                    <div>{{ b.booking_date }}</div>
                                    <div v-if="b.preferred_date" class="text-2xs text-blue-600 mt-0.5">Pref: {{ b.preferred_date }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="font-bold text-gray-900">BDT {{ Number(b.total_amount).toLocaleString() }}</div>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span :class="paymentBadge(b.payment_status)" class="px-2 py-0.5 rounded text-2xs font-semibold uppercase">
                                            {{ b.payment_status }}
                                        </span>
                                        <span v-if="b.due_amount > 0" class="text-2xs font-bold text-rose-600">
                                            Due: {{ Number(b.due_amount).toLocaleString() }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <span :class="statusBadge(b.status)" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold">
                                        {{ formatStatus(b.status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <Link :href="route('admin.medical-test-bookings.show', b.id)" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-xs font-semibold transition-colors">
                                        Manage & Report &rarr;
                                    </Link>
                                </td>
                            </tr>
                            <tr v-if="bookings.data.length === 0">
                                <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                                    <div class="text-3xl mb-2">📋</div>
                                    No test bookings found for the selected criteria.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="bookings.links?.length > 3" class="p-4 border-t border-gray-100 flex justify-center gap-1">
                    <Link v-for="(link, i) in bookings.links" :key="i" :href="link.url || '#'" :class="[link.active ? 'bg-blue-600 text-white font-bold' : 'text-gray-600 hover:bg-gray-100', !link.url ? 'opacity-50 cursor-not-allowed' : '']" class="px-3 py-1.5 rounded-lg text-xs" v-html="link.label">
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
    bookings: { type: Object, required: true },
    agents:   { type: Array, default: () => [] },
    filters:  { type: Object, default: () => ({}) },
    stats:    { type: Object, default: () => ({}) },
});

const filterSearch  = ref(props.filters.search || '');
const filterStatus  = ref(props.filters.status || '');
const filterPayment = ref(props.filters.payment_status || '');
const filterAgent   = ref(props.filters.agent_id || '');
const filterDate    = ref(props.filters.date || '');

function formatStatus(status) {
    switch (status) {
        case 'sample_collected': return 'Sample Collected';
        case 'processing':       return 'In Lab Processing';
        case 'completed':        return 'Report Ready';
        default:                 return status.charAt(0).toUpperCase() + status.slice(1);
    }
}

function statusBadge(status) {
    switch (status) {
        case 'pending':          return 'bg-amber-100 text-amber-800 border border-amber-200';
        case 'sample_collected': return 'bg-cyan-100 text-cyan-800 border border-cyan-200';
        case 'processing':       return 'bg-blue-100 text-blue-800 border border-blue-200';
        case 'completed':        return 'bg-emerald-100 text-emerald-800 border border-emerald-200';
        case 'cancelled':        return 'bg-rose-100 text-rose-800 border border-rose-200';
        default:                 return 'bg-gray-100 text-gray-700';
    }
}

function paymentBadge(status) {
    switch (status) {
        case 'paid':    return 'bg-emerald-100 text-emerald-800';
        case 'partial': return 'bg-amber-100 text-amber-800';
        case 'unpaid':  return 'bg-rose-100 text-rose-800';
        default:        return 'bg-gray-100 text-gray-600';
    }
}

function applyFilters() {
    router.get(route('admin.medical-test-bookings.index'), {
        search: filterSearch.value,
        status: filterStatus.value,
        payment_status: filterPayment.value,
        agent_id: filterAgent.value,
        date: filterDate.value,
    }, { preserveState: true, replace: true });
}

function clearFilters() {
    filterSearch.value = '';
    filterStatus.value = '';
    filterPayment.value = '';
    filterAgent.value = '';
    filterDate.value = '';
    applyFilters();
}
</script>
