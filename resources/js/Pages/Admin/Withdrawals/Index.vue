<template>
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Agent Cash Out Requests</h1>
                    <p class="text-xs text-gray-500 mt-1">Review, process, approve, and disburse agent commission withdrawals</p>
                </div>
                <div class="flex items-center gap-3">
                    <Link :href="route('admin.agents.index')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 shadow-xs transition-all">
                        &larr; Manage Agents
                    </Link>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-amber-50/80 border border-amber-200/80 p-5 rounded-2xl shadow-xs flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-amber-700 uppercase tracking-wider">Pending Cash Out Requests</div>
                        <div class="text-2xl font-black text-amber-900 mt-1">{{ stats.pending_count || 0 }}</div>
                        <div class="text-xs text-amber-700/80 mt-0.5">BDT {{ Number(stats.pending_amount || 0).toLocaleString() }} pending</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl font-bold">
                        ⏳
                    </div>
                </div>

                <div class="bg-emerald-50/80 border border-emerald-200/80 p-5 rounded-2xl shadow-xs flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">Total Disbursed</div>
                        <div class="text-2xl font-black text-emerald-900 mt-1">BDT {{ Number(stats.approved_amount || 0).toLocaleString() }}</div>
                        <div class="text-xs text-emerald-700/80 mt-0.5">{{ stats.approved_count || 0 }} disbursements completed</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl font-bold">
                        ✅
                    </div>
                </div>

                <div class="bg-blue-50/80 border border-blue-200/80 p-5 rounded-2xl shadow-xs flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-blue-700 uppercase tracking-wider">Available Agent Funds</div>
                        <div class="text-2xl font-black text-blue-900 mt-1">BDT {{ Number(stats.total_wallet_balance || 0).toLocaleString() }}</div>
                        <div class="text-xs text-blue-700/80 mt-0.5">Active agents wallet balance</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl font-bold">
                        💼
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-4 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto">
                    <button @click="setFilter('')" :class="!currentFilter ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'" class="px-3.5 py-1.5 rounded-lg text-xs transition-all whitespace-nowrap">
                        All Requests ({{ stats.total_requests || 0 }})
                    </button>
                    <button @click="setFilter('pending')" :class="currentFilter === 'pending' ? 'bg-amber-600 text-white font-semibold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'" class="px-3.5 py-1.5 rounded-lg text-xs transition-all whitespace-nowrap">
                        Pending ({{ stats.pending_count || 0 }})
                    </button>
                    <button @click="setFilter('approved')" :class="currentFilter === 'approved' ? 'bg-emerald-600 text-white font-semibold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'" class="px-3.5 py-1.5 rounded-lg text-xs transition-all whitespace-nowrap">
                        Approved ({{ stats.approved_count || 0 }})
                    </button>
                    <button @click="setFilter('rejected')" :class="currentFilter === 'rejected' ? 'bg-rose-600 text-white font-semibold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'" class="px-3.5 py-1.5 rounded-lg text-xs transition-all whitespace-nowrap">
                        Rejected
                    </button>
                </div>

                <div class="w-full sm:w-72">
                    <input 
                        v-model="searchInput" 
                        @keyup.enter="performSearch"
                        type="text" 
                        placeholder="Search agent, code, phone, TrxID..." 
                        class="w-full px-3.5 py-2 text-xs border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                    />
                </div>
            </div>

            <!-- Withdrawals Table -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50/80 text-xs uppercase font-semibold text-gray-500 border-b border-gray-200">
                            <tr>
                                <th class="px-5 py-3.5">Withdrawal ID</th>
                                <th class="px-5 py-3.5">Agent Details</th>
                                <th class="px-5 py-3.5">Amount</th>
                                <th class="px-5 py-3.5">Payout Method & Account</th>
                                <th class="px-5 py-3.5">Requested At</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="item in withdrawalList" :key="item.id" class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-5 py-4 font-mono font-bold text-gray-900 text-xs">
                                    #{{ item.withdrawal_number }}
                                </td>
                                <td class="px-5 py-4">
                                    <div class="font-bold text-gray-900">{{ item.agent?.user?.name || 'N/A' }}</div>
                                    <div class="text-xs text-blue-600 font-mono">Code: {{ item.agent?.agent_code }}</div>
                                    <div class="text-xs text-gray-400">{{ item.agent?.phone }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="text-base font-black text-gray-900 font-mono">BDT {{ Number(item.amount).toLocaleString() }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="font-bold uppercase text-xs flex items-center gap-1.5">
                                        <span :class="payoutMethodTagClass(item.payout_method)" class="px-2 py-0.5 rounded text-3xs border font-bold">
                                            {{ item.payout_method }}
                                        </span>
                                        <span class="text-xs text-gray-500 capitalize">({{ item.account_type || 'Personal' }})</span>
                                    </div>
                                    <div class="font-mono text-xs text-gray-900 font-bold mt-1">{{ item.account_number }}</div>
                                    <div v-if="item.bank_details" class="text-xs text-gray-500 mt-0.5">
                                        {{ item.bank_details.bank_name }} &bull; {{ item.bank_details.branch }} ({{ item.bank_details.account_name }})
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-xs text-gray-500">
                                    {{ new Date(item.created_at).toLocaleString() }}
                                </td>
                                <td class="px-5 py-4">
                                    <span :class="statusBadge(item.status)" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold uppercase">
                                        {{ item.status }}
                                    </span>
                                    <div v-if="item.transaction_id" class="text-2xs text-emerald-700 font-mono font-bold mt-1">
                                        Trx: {{ item.transaction_id }}
                                    </div>
                                    <div v-if="item.admin_notes" class="text-2xs text-gray-500 mt-0.5 max-w-xs truncate" :title="item.admin_notes">
                                        Note: {{ item.admin_notes }}
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div v-if="item.status === 'pending' || item.status === 'processing'" class="flex items-center justify-end gap-2">
                                        <button @click="openApproveModal(item)" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-xs transition-colors flex items-center gap-1">
                                            <span>✓</span> Approve & Disburse
                                        </button>
                                        <button @click="openRejectModal(item)" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold rounded-xl transition-colors">
                                            Reject
                                        </button>
                                    </div>
                                    <div v-else class="text-xs text-gray-400">
                                        {{ item.status === 'approved' ? 'Disbursed' : 'Closed' }} &bull; {{ item.processed_at ? new Date(item.processed_at).toLocaleDateString() : '' }}
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="withdrawalList.length === 0">
                                <td colspan="7" class="px-5 py-16 text-center text-gray-400">
                                    <div class="text-3xl mb-2">💸</div>
                                    <div class="font-medium text-gray-600">No cash out requests found.</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="withdrawals?.links?.length > 3" class="p-4 border-t border-gray-100 flex justify-center gap-1">
                    <Link v-for="(link, i) in withdrawals.links" :key="i" :href="link.url || '#'" :class="[link.active ? 'bg-blue-600 text-white font-bold' : 'text-gray-600 hover:bg-gray-100', !link.url ? 'opacity-50 cursor-not-allowed' : '']" class="px-3 py-1.5 rounded-lg text-xs" v-html="link.label" />
                </div>
            </div>

            <!-- Approve & Disburse Modal -->
            <div v-if="approvingItem" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs">
                <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4 animate-in fade-in zoom-in duration-200">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h3 class="font-bold text-gray-900 text-lg">Approve & Disburse Payout</h3>
                        <button @click="approvingItem = null" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
                    </div>

                    <div class="p-3.5 bg-emerald-50 text-emerald-950 rounded-2xl text-xs space-y-1.5 border border-emerald-100">
                        <div class="flex justify-between"><span>Agent Name:</span> <strong class="text-gray-900">{{ approvingItem.agent?.user?.name }}</strong></div>
                        <div class="flex justify-between"><span>Cash Out Amount:</span> <strong class="text-emerald-700 font-mono text-sm">BDT {{ Number(approvingItem.amount).toLocaleString() }}</strong></div>
                        <div class="flex justify-between"><span>Channel:</span> <strong class="uppercase text-gray-900">{{ approvingItem.payout_method }} ({{ approvingItem.account_type || 'Personal' }})</strong></div>
                        <div class="flex justify-between"><span>Account Number:</span> <strong class="font-mono text-gray-900">{{ approvingItem.account_number }}</strong></div>
                        <div v-if="approvingItem.bank_details" class="border-t border-emerald-200/60 pt-1 text-2xs">
                            Bank: {{ approvingItem.bank_details.bank_name }} &bull; Branch: {{ approvingItem.bank_details.branch }} &bull; Name: {{ approvingItem.bank_details.account_name }}
                        </div>
                    </div>

                    <form @submit.prevent="submitApproval" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Transaction ID / Reference Number (TrxID) *</label>
                            <input v-model="approveForm.transaction_id" type="text" required placeholder="e.g. 9K3J781LQX or Bank Voucher No" class="w-full px-3 py-2 text-sm border rounded-xl focus:ring-2 focus:ring-emerald-500 font-mono font-semibold focus:outline-none" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Admin Remarks / Note (Optional)</label>
                            <textarea v-model="approveForm.admin_notes" rows="2" placeholder="Paid via hospital official MFS / Bank merchant..." class="w-full px-3 py-2 text-sm border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="approvingItem = null" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-xl">Cancel</button>
                            <button type="submit" :disabled="approveForm.processing" class="px-6 py-2.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md">
                                Confirm & Mark Disbursed
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Reject Modal -->
            <div v-if="rejectingItem" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs">
                <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4 animate-in fade-in zoom-in duration-200">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h3 class="font-bold text-gray-900 text-lg">Reject Cash Out Request</h3>
                        <button @click="rejectingItem = null" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
                    </div>

                    <div class="p-3.5 bg-rose-50 text-rose-950 rounded-2xl text-xs space-y-1 border border-rose-100">
                        <div><strong>Automatic Wallet Refund:</strong> Rejecting this request will automatically refund <strong class="text-rose-700 font-mono">BDT {{ Number(rejectingItem.amount).toLocaleString() }}</strong> back into the agent's available wallet balance.</div>
                    </div>

                    <form @submit.prevent="submitRejection" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Reason for Rejection *</label>
                            <textarea v-model="rejectForm.admin_notes" rows="3" required placeholder="e.g. Account number invalid or not registered in bKash/Nagad..." class="w-full px-3 py-2 text-sm border rounded-xl focus:ring-2 focus:ring-rose-500 focus:outline-none"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="rejectingItem = null" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-xl">Cancel</button>
                            <button type="submit" :disabled="rejectForm.processing" class="px-5 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">
                                Confirm Rejection & Refund
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    withdrawals: { type: [Array, Object], default: () => [] },
    filters:     { type: Object, default: () => ({}) },
    stats:       { type: Object, default: () => ({}) },
});

const currentFilter = ref(props.filters?.status || '');
const searchInput   = ref(props.filters?.search || '');
const approvingItem = ref(null);
const rejectingItem = ref(null);

const approveForm = useForm({
    transaction_id: '',
    admin_notes: '',
});

const rejectForm = useForm({
    admin_notes: '',
});

const withdrawalList = computed(() => {
    return Array.isArray(props.withdrawals) ? props.withdrawals : (props.withdrawals?.data || []);
});

function setFilter(status) {
    currentFilter.value = status;
    router.get(route('admin.withdrawals.index'), {
        status: status || undefined,
        search: searchInput.value || undefined,
    }, { preserveState: true });
}

function performSearch() {
    router.get(route('admin.withdrawals.index'), {
        status: currentFilter.value || undefined,
        search: searchInput.value || undefined,
    }, { preserveState: true });
}

function statusBadge(status) {
    switch (status) {
        case 'pending':    return 'bg-amber-100 text-amber-800 border border-amber-200';
        case 'approved':   return 'bg-emerald-100 text-emerald-800 border border-emerald-200';
        case 'processing': return 'bg-blue-100 text-blue-800 border border-blue-200';
        case 'rejected':   return 'bg-rose-100 text-rose-800 border border-rose-200';
        default:           return 'bg-gray-100 text-gray-600';
    }
}

function payoutMethodTagClass(method) {
    switch (method) {
        case 'bkash':  return 'bg-pink-50 text-pink-700 border-pink-200';
        case 'nagad':  return 'bg-orange-50 text-orange-700 border-orange-200';
        case 'rocket': return 'bg-purple-50 text-purple-700 border-purple-200';
        case 'upay':   return 'bg-amber-50 text-amber-700 border-amber-200';
        case 'bank':   return 'bg-blue-50 text-blue-700 border-blue-200';
        default:       return 'bg-gray-100 text-gray-700 border-gray-200';
    }
}

function openApproveModal(item) {
    approvingItem.value = item;
    approveForm.transaction_id = '';
    approveForm.admin_notes = '';
}

function submitApproval() {
    if (!approvingItem.value) return;
    approveForm.post(route('admin.withdrawals.approve', approvingItem.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            approvingItem.value = null;
            approveForm.reset();
        }
    });
}

function openRejectModal(item) {
    rejectingItem.value = item;
    rejectForm.admin_notes = '';
}

function submitRejection() {
    if (!rejectingItem.value) return;
    rejectForm.post(route('admin.withdrawals.reject', rejectingItem.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            rejectingItem.value = null;
            rejectForm.reset();
        }
    });
}
</script>
