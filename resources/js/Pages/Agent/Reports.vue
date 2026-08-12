<template>
    <AgentLayout>
        <div class="space-y-5">
            <!-- Header -->
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Reports Module</h1>
                <p class="text-xs text-gray-400 mt-0.5">View your income, commissions, and withdrawal history</p>
            </div>

            <!-- Tabs -->
            <div class="flex gap-4 border-b border-gray-200">
                <button 
                    @click="activeTab = 'income'"
                    :class="activeTab === 'income' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2 text-sm font-semibold border-b-2 transition-colors">
                    Income Summary
                </button>
                <button 
                    @click="activeTab = 'commissions'"
                    :class="activeTab === 'commissions' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2 text-sm font-semibold border-b-2 transition-colors">
                    Commissions
                </button>
                <button 
                    @click="activeTab = 'test_bookings'"
                    :class="activeTab === 'test_bookings' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2 text-sm font-semibold border-b-2 transition-colors">
                    Test Bookings
                </button>
                <button 
                    @click="activeTab = 'withdrawals'"
                    :class="activeTab === 'withdrawals' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2 text-sm font-semibold border-b-2 transition-colors">
                    Withdrawals
                </button>
            </div>

            <!-- Tab Content -->
            <div class="bg-white rounded-lg shadow-sm p-5 min-h-[400px]">
                
                <!-- Income Summary Tab -->
                <div v-if="activeTab === 'income'" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="p-4 rounded-xl border border-gray-100 bg-emerald-50/50">
                            <div class="text-xs font-semibold text-gray-500 uppercase">Total Earned</div>
                            <div class="text-2xl font-bold text-emerald-600 mt-1">BDT {{ Number(incomeStats.total_commission).toLocaleString() }}</div>
                        </div>
                        <div class="p-4 rounded-xl border border-gray-100 bg-blue-50/50">
                            <div class="text-xs font-semibold text-gray-500 uppercase">Current Balance</div>
                            <div class="text-2xl font-bold text-blue-600 mt-1">BDT {{ Number(incomeStats.current_balance).toLocaleString() }}</div>
                        </div>
                        <div class="p-4 rounded-xl border border-gray-100 bg-purple-50/50">
                            <div class="text-xs font-semibold text-gray-500 uppercase">Total Withdrawn</div>
                            <div class="text-2xl font-bold text-purple-600 mt-1">BDT {{ Number(incomeStats.total_withdrawn).toLocaleString() }}</div>
                        </div>
                        <div class="p-4 rounded-xl border border-gray-100 bg-amber-50/50">
                            <div class="text-xs font-semibold text-gray-500 uppercase">Pending Withdrawals</div>
                            <div class="text-2xl font-bold text-amber-600 mt-1">BDT {{ Number(incomeStats.pending_withdrawals).toLocaleString() }}</div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4 pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-2">
                            <select v-model="filterDate" @change="applyFilter" class="px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 outline-none">
                                <option value="all">All Time</option>
                                <option value="daily">Daily (Today)</option>
                                <option value="monthly">Monthly (This Month)</option>
                                <option value="yearly">Yearly (This Year)</option>
                                <option value="custom">Custom Range</option>
                            </select>
                            
                            <template v-if="filterDate === 'custom'">
                                <input v-model="filterStart" @change="applyFilter" type="date" class="px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 outline-none" />
                                <span class="text-gray-400 text-xs">to</span>
                                <input v-model="filterEnd" @change="applyFilter" type="date" class="px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 outline-none" />
                            </template>
                        </div>
                        <a :href="pdfUrl" target="_blank" class="px-4 py-1.5 text-xs font-semibold text-white bg-gray-800 hover:bg-gray-900 rounded shadow transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print PDF
                        </a>
                    </div>

                    <div v-if="!incomeList?.data?.length" class="text-center py-10 text-gray-400 text-sm">
                        No income recorded for this period.
                    </div>
                    <div v-else class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap mb-4">
                            <thead>
                                <tr class="text-xs text-gray-500 uppercase tracking-wider border-b">
                                    <th class="pb-2 font-semibold">Date</th>
                                    <th class="pb-2 font-semibold">Source</th>
                                    <th class="pb-2 font-semibold">Reference</th>
                                    <th class="pb-2 font-semibold text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="inc in incomeList.data" :key="inc.id" class="hover:bg-gray-50 transition-colors">
                                    <td class="py-2.5">{{ new Date(inc.created_at).toLocaleDateString() }}</td>
                                    <td class="py-2.5 capitalize">{{ inc.source_type }}</td>
                                    <td class="py-2.5 font-mono text-xs text-gray-500">{{ inc.booking_reference }}</td>
                                    <td class="py-2.5 text-right font-medium text-emerald-600">BDT {{ Number(inc.amount).toLocaleString() }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-gray-200">
                                    <td colspan="3" class="py-3 text-right font-bold text-gray-700">Total Filtered Amount:</td>
                                    <td class="py-3 text-right font-bold text-lg text-emerald-600">BDT {{ Number(incomeTotal).toLocaleString() }}</td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Pagination -->
                        <div v-if="incomeList.links?.length > 3" class="flex flex-wrap justify-center gap-1">
                            <Link v-for="(link, k) in incomeList.links" :key="k" 
                                :href="link.url || '#'" 
                                v-html="link.label"
                                :class="[
                                    'px-3 py-1 text-xs border rounded transition-colors',
                                    link.active ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 hover:bg-gray-50',
                                    !link.url ? 'opacity-50 cursor-not-allowed' : ''
                                ]" />
                        </div>
                    </div>
                </div>

                <!-- Commissions Tab -->
                <div v-if="activeTab === 'commissions'" class="space-y-4">
                    <div v-if="!commissions?.data?.length" class="text-center py-10 text-gray-400 text-sm">
                        No commissions recorded yet.
                    </div>
                    <div v-else class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead>
                                <tr class="text-xs text-gray-500 uppercase tracking-wider border-b">
                                    <th class="pb-2 font-semibold">Date</th>
                                    <th class="pb-2 font-semibold">Source</th>
                                    <th class="pb-2 font-semibold">Reference</th>
                                    <th class="pb-2 font-semibold">Status</th>
                                    <th class="pb-2 font-semibold text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="c in commissions.data" :key="c.id" class="hover:bg-gray-50 transition-colors">
                                    <td class="py-2.5">{{ new Date(c.created_at).toLocaleDateString() }}</td>
                                    <td class="py-2.5 capitalize">{{ c.source_type }}</td>
                                    <td class="py-2.5 font-mono text-xs text-gray-500">{{ c.booking_reference }}</td>
                                    <td class="py-2.5">
                                        <span :class="badgeColor(c.status)" class="px-2 py-0.5 rounded text-xs font-medium">{{ c.status }}</span>
                                    </td>
                                    <td class="py-2.5 text-right font-bold text-emerald-600">BDT {{ Number(c.amount).toLocaleString() }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <!-- Pagination -->
                        <div v-if="commissions.links?.length > 3" class="mt-4 flex flex-wrap justify-center gap-1">
                            <Link v-for="(link, k) in commissions.links" :key="k" 
                                :href="link.url || '#'" 
                                v-html="link.label"
                                :class="[
                                    'px-3 py-1 text-xs border rounded transition-colors',
                                    link.active ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 hover:bg-gray-50',
                                    !link.url ? 'opacity-50 cursor-not-allowed' : ''
                                ]" />
                        </div>
                    </div>
                </div>

                <!-- Test Bookings Tab -->
                <div v-if="activeTab === 'test_bookings'" class="space-y-4">
                    <div v-if="!testBookings?.data?.length" class="text-center py-10 text-gray-400 text-sm">
                        No medical tests booked yet.
                    </div>
                    <div v-else class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead>
                                <tr class="text-xs text-gray-500 uppercase tracking-wider border-b">
                                    <th class="pb-2 font-semibold">Date</th>
                                    <th class="pb-2 font-semibold">Booking #</th>
                                    <th class="pb-2 font-semibold">Patient</th>
                                    <th class="pb-2 font-semibold">Items</th>
                                    <th class="pb-2 font-semibold text-right">Total Bill</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="t in testBookings.data" :key="t.id" class="hover:bg-gray-50 transition-colors">
                                    <td class="py-2.5">{{ t.booking_date }}</td>
                                    <td class="py-2.5 font-bold text-gray-700">#{{ t.booking_number }}</td>
                                    <td class="py-2.5">{{ t.patient_name }}</td>
                                    <td class="py-2.5">{{ t.items?.length || 0 }} test(s)</td>
                                    <td class="py-2.5 text-right font-bold text-gray-900">BDT {{ Number(t.total_amount).toLocaleString() }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <!-- Pagination -->
                        <div v-if="testBookings.links?.length > 3" class="mt-4 flex flex-wrap justify-center gap-1">
                            <Link v-for="(link, k) in testBookings.links" :key="k" 
                                :href="link.url || '#'" 
                                v-html="link.label"
                                :class="[
                                    'px-3 py-1 text-xs border rounded transition-colors',
                                    link.active ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 hover:bg-gray-50',
                                    !link.url ? 'opacity-50 cursor-not-allowed' : ''
                                ]" />
                        </div>
                    </div>
                </div>

                <!-- Withdrawals Tab -->
                <div v-if="activeTab === 'withdrawals'" class="space-y-4">
                    <div v-if="!withdrawals?.data?.length" class="text-center py-10 text-gray-400 text-sm">
                        No withdrawals requested yet.
                    </div>
                    <div v-else class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead>
                                <tr class="text-xs text-gray-500 uppercase tracking-wider border-b">
                                    <th class="pb-2 font-semibold">Date</th>
                                    <th class="pb-2 font-semibold">Ref ID</th>
                                    <th class="pb-2 font-semibold">Method</th>
                                    <th class="pb-2 font-semibold">Status</th>
                                    <th class="pb-2 font-semibold text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="w in withdrawals.data" :key="w.id" class="hover:bg-gray-50 transition-colors">
                                    <td class="py-2.5">{{ new Date(w.created_at).toLocaleDateString() }}</td>
                                    <td class="py-2.5 font-mono text-xs text-gray-500">{{ w.reference_id }}</td>
                                    <td class="py-2.5 capitalize">{{ w.payout_method }}</td>
                                    <td class="py-2.5">
                                        <span :class="badgeColor(w.status)" class="px-2 py-0.5 rounded text-xs font-medium">{{ w.status }}</span>
                                    </td>
                                    <td class="py-2.5 text-right font-bold text-gray-900">BDT {{ Number(w.amount).toLocaleString() }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <!-- Pagination -->
                        <div v-if="withdrawals.links?.length > 3" class="mt-4 flex flex-wrap justify-center gap-1">
                            <Link v-for="(link, k) in withdrawals.links" :key="k" 
                                :href="link.url || '#'" 
                                v-html="link.label"
                                :class="[
                                    'px-3 py-1 text-xs border rounded transition-colors',
                                    link.active ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 hover:bg-gray-50',
                                    !link.url ? 'opacity-50 cursor-not-allowed' : ''
                                ]" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AgentLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AgentLayout from '@/Layouts/AgentLayout.vue';

const props = defineProps({
    activeTab: { type: String, default: 'income' },
    dateFilter: { type: String, default: 'all' },
    startDate: { type: String, default: '' },
    endDate: { type: String, default: '' },
    incomeStats: { type: Object, default: () => ({}) },
    incomeList: { type: Object, default: null },
    incomeTotal: { type: Number, default: 0 },
    commissions: { type: Object, default: null },
    testBookings: { type: Object, default: null },
    withdrawals: { type: Object, default: null },
});

const filterDate = ref(props.dateFilter);
const filterStart = ref(props.startDate);
const filterEnd = ref(props.endDate);

const activeTab = computed({
    get: () => props.activeTab,
    set: (val) => {
        router.get(route('agent.reports.index'), { tab: val, date_filter: filterDate.value, start_date: filterStart.value, end_date: filterEnd.value }, {
            preserveState: true,
            preserveScroll: true,
            only: ['activeTab', 'incomeStats', 'incomeList', 'incomeTotal', 'commissions', 'testBookings', 'withdrawals']
        });
    }
});

function applyFilter() {
    if (filterDate.value === 'custom' && (!filterStart.value || !filterEnd.value)) return;
    router.get(route('agent.reports.index'), {
        tab: activeTab.value,
        date_filter: filterDate.value,
        start_date: filterStart.value,
        end_date: filterEnd.value
    }, { preserveState: true, preserveScroll: true });
}

const pdfUrl = computed(() => {
    let url = route('agent.reports.pdf') + '?date_filter=' + filterDate.value;
    if (filterDate.value === 'custom' && filterStart.value && filterEnd.value) {
        url += '&start_date=' + filterStart.value + '&end_date=' + filterEnd.value;
    }
    return url;
});

function badgeColor(status) {
    if (status === 'credited' || status === 'approved' || status === 'completed') return 'bg-emerald-100 text-emerald-800';
    if (status === 'pending') return 'bg-amber-100 text-amber-800';
    if (status === 'rejected' || status === 'cancelled') return 'bg-rose-100 text-rose-800';
    return 'bg-gray-100 text-gray-800';
}
</script>
