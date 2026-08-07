<template>
    <AdminLayout>
        <div class="space-y-5">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Agent Management</h1>
                    <p class="text-xs text-gray-500 mt-1">Manage hospital marketing & booking agents, commissions, and balances</p>
                </div>
                <div class="flex items-center gap-3">
                    <Link :href="route('admin.withdrawals.index')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition-all flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Cash Out Requests
                    </Link>
                    <Link :href="route('admin.agents.create')" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Add New Agent
                    </Link>
                </div>
            </div>

            <!-- Stats Overview Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-xl border border-gray-200/80 shadow-xs flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xl">
                        👥
                    </div>
                    <div>
                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Agents</div>
                        <div class="text-2xl font-bold text-gray-900 mt-0.5">{{ stats.total_agents ?? stats.total ?? 0 }}</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-200/80 shadow-xs flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xl">
                        🟢
                    </div>
                    <div>
                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Active Agents</div>
                        <div class="text-2xl font-bold text-emerald-600 mt-0.5">{{ stats.active_agents ?? stats.active ?? 0 }}</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-200/80 shadow-xs flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xl">
                        💰
                    </div>
                    <div>
                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Commission Earned</div>
                        <div class="text-2xl font-bold text-amber-600 mt-0.5">BDT {{ Number(stats.total_commission_paid || 0).toLocaleString() }}</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-200/80 shadow-xs flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-xl">
                        💼
                    </div>
                    <div>
                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Current Wallet Balances</div>
                        <div class="text-2xl font-bold text-purple-600 mt-0.5">BDT {{ Number(stats.total_wallet_balance || 0).toLocaleString() }}</div>
                    </div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-4 flex flex-col md:flex-row items-center justify-between gap-3">
                <div class="relative w-full md:w-80">
                    <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <input v-model="filterSearch" type="text" placeholder="Search by name, code, phone..." class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                </div>
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <select v-model="filterStatus" class="w-full md:w-auto py-2 px-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending Approval</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
            </div>

            <!-- Agents Table -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50/80 text-xs uppercase font-semibold text-gray-500 border-b border-gray-200">
                            <tr>
                                <th class="px-5 py-3.5">Agent Details</th>
                                <th class="px-5 py-3.5">Commission Rates</th>
                                <th class="px-5 py-3.5">Wallet Balance</th>
                                <th class="px-5 py-3.5">Payout Method</th>
                                <th class="px-5 py-3.5">Bookings</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="agent in filteredAgents" :key="agent.id" class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0 text-sm">
                                            {{ agent.user?.name?.charAt(0) || 'A' }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ agent.user?.name }}</div>
                                            <div class="text-xs text-blue-600 font-mono font-medium mt-0.5">Code: {{ agent.agent_code }}</div>
                                            <div class="text-xs text-gray-400 mt-0.5">{{ agent.phone }} &bull; {{ agent.user?.email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700">
                                            🩺 Doctor: {{ agent.doctor_commission_rate }}{{ agent.commission_type === 'percentage' ? '%' : ' BDT' }}
                                        </span>
                                        <div>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-purple-50 text-purple-700">
                                                🔬 Test: {{ agent.test_commission_rate }}{{ agent.commission_type === 'percentage' ? '%' : ' BDT' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="font-bold text-gray-900 text-base">BDT {{ Number(agent.wallet_balance || 0).toLocaleString() }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5">Earned: BDT {{ Number(agent.total_earned_commission || 0).toLocaleString() }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="font-medium text-gray-800 capitalize">{{ agent.payout_method || 'bKash' }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ agent.payout_account_number || 'N/A' }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="text-xs text-gray-600">
                                        <div>Appointments: <span class="font-semibold text-gray-900">{{ agent.appointments_count || 0 }}</span></div>
                                        <div class="mt-0.5">Tests: <span class="font-semibold text-gray-900">{{ agent.medical_test_bookings_count || 0 }}</span></div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <span :class="statusBadgeClass(agent.status)" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold uppercase tracking-wider">
                                        {{ agent.status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="openAdjustModal(agent)" title="Adjust Balance" class="p-1.5 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                        </button>
                                        <Link :href="route('admin.agents.show', agent.id)" title="View Details" class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </Link>
                                        <Link :href="route('admin.agents.edit', agent.id)" title="Edit" class="p-1.5 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="filteredAgents.length === 0">
                                <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                                    <div class="text-3xl mb-2">🧑‍💼</div>
                                    No agents found matching your query.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="agents?.links?.length > 3" class="p-4 border-t border-gray-100 flex justify-center gap-1">
                    <Link v-for="(link, i) in agents.links" :key="i" :href="link.url || '#'" :class="[link.active ? 'bg-blue-600 text-white font-bold' : 'text-gray-600 hover:bg-gray-100', !link.url ? 'opacity-50 cursor-not-allowed' : '']" class="px-3 py-1.5 rounded-lg text-xs" v-html="link.label">
                    </Link>
                </div>
            </div>

            <!-- Balance Adjustment Modal -->
            <div v-if="adjustingAgent" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs">
                <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h3 class="font-bold text-gray-900 text-lg">Adjust Agent Balance</h3>
                        <button @click="adjustingAgent = null" class="text-gray-400 hover:text-gray-600">&times;</button>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg text-xs space-y-1">
                        <div><span class="text-gray-500">Agent:</span> <strong class="text-gray-900">{{ adjustingAgent.user?.name }}</strong> ({{ adjustingAgent.agent_code }})</div>
                        <div><span class="text-gray-500">Current Balance:</span> <strong class="text-emerald-700 font-mono">BDT {{ Number(adjustingAgent.wallet_balance).toLocaleString() }}</strong></div>
                    </div>

                    <form @submit.prevent="submitBalanceAdjustment" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Adjustment Type</label>
                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" @click="adjustForm.type = 'adjustment_credit'" :class="adjustForm.type === 'adjustment_credit' ? 'bg-emerald-600 text-white font-bold' : 'bg-gray-100 text-gray-700'" class="py-2 text-xs rounded-lg transition-all text-center">
                                    + Add Credit (Increase)
                                </button>
                                <button type="button" @click="adjustForm.type = 'adjustment_debit'" :class="adjustForm.type === 'adjustment_debit' ? 'bg-rose-600 text-white font-bold' : 'bg-gray-100 text-gray-700'" class="py-2 text-xs rounded-lg transition-all text-center">
                                    - Debit (Decrease)
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Amount (BDT)</label>
                            <input v-model="adjustForm.amount" type="number" step="0.01" min="1" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="e.g. 500" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Reason / Description</label>
                            <textarea v-model="adjustForm.description" rows="2" required placeholder="Reason for manual wallet adjustment..." class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="adjustingAgent = null" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                            <button type="submit" :disabled="adjustForm.processing" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm">
                                Save Adjustment
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
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    agents: { type: [Array, Object], default: () => [] },
    stats:  { type: Object, default: () => ({ total: 0, active: 0, total_commission_paid: 0, total_wallet_balance: 0 }) },
});

const filterSearch = ref('');
const filterStatus = ref('');
const adjustingAgent = ref(null);

const adjustForm = useForm({
    amount: '',
    type: 'adjustment_credit',
    description: '',
});

const agentList = computed(() => {
    return Array.isArray(props.agents) ? props.agents : (props.agents?.data || []);
});

const filteredAgents = computed(() => {
    return agentList.value.filter(agent => {
        const matchesSearch = !filterSearch.value || 
            agent.user?.name?.toLowerCase().includes(filterSearch.value.toLowerCase()) ||
            agent.agent_code?.toLowerCase().includes(filterSearch.value.toLowerCase()) ||
            agent.phone?.toLowerCase().includes(filterSearch.value.toLowerCase()) ||
            agent.user?.email?.toLowerCase().includes(filterSearch.value.toLowerCase());
        
        const matchesStatus = !filterStatus.value || agent.status === filterStatus.value;
        return matchesSearch && matchesStatus;
    });
});

function statusBadgeClass(status) {
    switch (status) {
        case 'active':   return 'bg-emerald-100 text-emerald-800 border border-emerald-200';
        case 'inactive': return 'bg-gray-100 text-gray-700 border border-gray-200';
        case 'pending':  return 'bg-amber-100 text-amber-800 border border-amber-200';
        case 'suspended':return 'bg-rose-100 text-rose-800 border border-rose-200';
        default:         return 'bg-gray-100 text-gray-600';
    }
}

function openAdjustModal(agent) {
    adjustingAgent.value = agent;
    adjustForm.reset();
    adjustForm.type = 'adjustment_credit';
    adjustForm.description = '';
}

function submitBalanceAdjustment() {
    if (!adjustingAgent.value) return;
    adjustForm.post(route('admin.agents.adjust-balance', adjustingAgent.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            adjustingAgent.value = null;
            adjustForm.reset();
        }
    });
}
</script>
