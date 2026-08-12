<template>
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white font-bold text-2xl flex items-center justify-center shadow-md">
                        {{ agent.user?.name?.charAt(0) || 'A' }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-xl font-bold text-gray-900">{{ agent.user?.name }}</h1>
                            <span :class="statusBadgeClass(agent.status)" class="px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase">
                                {{ agent.status }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 font-mono">Agent Code: <span class="text-blue-600 font-bold">{{ agent.agent_code }}</span> &bull; Joined: {{ new Date(agent.created_at).toLocaleDateString() }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button @click="showAdjustModal = true" class="px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition-all flex items-center gap-2">
                        <span>💳</span> Adjust Wallet Balance
                    </button>
                    <Link :href="route('admin.agents.edit', agent.id)" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 shadow-xs transition-all">
                        Edit Agent
                    </Link>
                    <Link :href="route('admin.agents.index')" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">
                        &larr; Back
                    </Link>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Current Balance</div>
                    <div class="text-2xl font-black text-emerald-600 mt-1">BDT {{ Number(agent.wallet_balance).toLocaleString() }}</div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Commission Earned</div>
                    <div class="text-2xl font-black text-blue-600 mt-1">BDT {{ Number(agent.total_earned_commission).toLocaleString() }}</div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Cash Out / Withdrawn</div>
                    <div class="text-2xl font-black text-purple-600 mt-1">BDT {{ Number(agent.total_withdrawn_commission).toLocaleString() }}</div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Commission Rates</div>
                    <div class="text-sm font-bold text-gray-800 mt-2 flex items-center justify-between">
                        <span>🩺 Doctor: {{ agent.doctor_commission_rate }}{{ agent.commission_type === 'percentage' ? '%' : ' BDT' }}</span>
                        <span>🔬 Test: {{ agent.test_commission_rate }}{{ agent.commission_type === 'percentage' ? '%' : ' BDT' }}</span>
                    </div>
                </div>
            </div>

            <!-- Agent Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile & Payout Info -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                    <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider border-b pb-3">Contact & Payout Info</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Phone:</span>
                            <span class="font-semibold text-gray-900">{{ agent.phone }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Email:</span>
                            <span class="font-semibold text-gray-900">{{ agent.user?.email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">NID Number:</span>
                            <span class="font-semibold text-gray-900">{{ agent.nid_number || 'Not provided' }}</span>
                        </div>
                        <div v-if="agent.nid_file" class="flex justify-between items-center pt-2">
                            <span class="text-gray-500">NID Document:</span>
                            <a :href="'/storage/' + agent.nid_file" target="_blank" class="text-blue-600 hover:underline text-xs font-semibold">View Attachment &rarr;</a>
                        </div>
                        <div class="border-t pt-3 space-y-2">
                            <div class="text-xs font-semibold text-gray-400 uppercase">Payout Account</div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Method:</span>
                                <span class="font-bold text-gray-900 capitalize">{{ agent.payout_method }} ({{ agent.payout_account_type }})</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Account No:</span>
                                <span class="font-mono font-bold text-gray-900">{{ agent.payout_account_number || 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Tabs & Lists -->
                <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
                    <div class="border-b border-gray-200 flex px-6 pt-4 gap-6 overflow-x-auto">
                        <button @click="activeTab = 'appointments'" :class="activeTab === 'appointments' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 text-sm font-semibold border-b-2 transition-colors whitespace-nowrap">
                            Doctor Appointments
                        </button>
                        <button @click="activeTab = 'tests'" :class="activeTab === 'tests' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 text-sm font-semibold border-b-2 transition-colors whitespace-nowrap">
                            Medical Tests
                        </button>
                        <button @click="activeTab = 'commissions'" :class="activeTab === 'commissions' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 text-sm font-semibold border-b-2 transition-colors whitespace-nowrap">
                            Commissions
                        </button>
                        <button @click="activeTab = 'withdrawals'" :class="activeTab === 'withdrawals' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 text-sm font-semibold border-b-2 transition-colors whitespace-nowrap">
                            Withdrawals
                        </button>
                        <button @click="activeTab = 'ledger'" :class="activeTab === 'ledger' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 text-sm font-semibold border-b-2 transition-colors whitespace-nowrap">
                            Wallet Transactions
                        </button>
                    </div>

                    <div class="p-6">
                        <!-- 1. Appointments -->
                        <div v-if="activeTab === 'appointments'" class="space-y-3">
                            <div v-if="recentAppointments?.length === 0" class="text-center py-8 text-gray-400 text-sm">
                                No appointments booked yet.
                            </div>
                            <div v-for="apt in recentAppointments" :key="apt.id" class="p-4 rounded-xl border border-gray-100 hover:bg-gray-50/70 transition-colors flex items-center justify-between">
                                <div>
                                    <div class="font-bold text-gray-900">{{ apt.name }} &bull; <span class="text-xs font-normal text-gray-500">{{ apt.phone }}</span></div>
                                    <div class="text-xs text-blue-600 mt-0.5">Doctor: {{ apt.doctor?.name || apt.preferred_doctor }} ({{ apt.appointment_date }})</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-gray-900">Fee: BDT {{ Number(apt.fee || 0).toLocaleString() }}</div>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded text-xs font-medium" :class="apt.status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-yellow-50 text-yellow-700'">
                                        {{ apt.status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Medical Tests -->
                        <div v-if="activeTab === 'tests'" class="space-y-3">
                            <div v-if="recentTestBookings?.length === 0" class="text-center py-8 text-gray-400 text-sm">
                                No medical tests booked yet.
                            </div>
                            <div v-for="t in recentTestBookings" :key="t.id" class="p-4 rounded-xl border border-gray-100 hover:bg-gray-50/70 transition-colors flex items-center justify-between">
                                <div>
                                    <div class="font-bold text-gray-900">#{{ t.booking_number }} &bull; {{ t.patient_name }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ t.items?.length || 0 }} test(s) &bull; {{ t.booking_date }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-gray-900">BDT {{ Number(t.total_amount).toLocaleString() }}</div>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded text-xs font-medium" :class="t.status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700'">
                                        {{ t.status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Commissions -->
                        <div v-if="activeTab === 'commissions'" class="space-y-2">
                            <div v-if="recentCommissions?.length === 0" class="text-center py-8 text-gray-400 text-sm">
                                No commissions recorded yet.
                            </div>
                            <div v-for="c in recentCommissions" :key="c.id" class="p-3 rounded-lg border border-gray-100 flex items-center justify-between text-xs hover:bg-gray-50">
                                <div>
                                    <div class="font-semibold text-gray-800 capitalize">{{ c.source_type }} Commission</div>
                                    <div class="text-gray-400 mt-0.5">Ref: {{ c.booking_reference }} &bull; {{ new Date(c.created_at).toLocaleString() }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-mono font-bold text-emerald-600">BDT {{ Number(c.amount).toLocaleString() }}</div>
                                    <span :class="statusBadgeClass(c.status)" class="px-1.5 py-0.5 rounded text-[10px] uppercase font-bold">{{ c.status }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Withdrawals -->
                        <div v-if="activeTab === 'withdrawals'" class="space-y-2">
                            <div v-if="recentWithdrawals?.length === 0" class="text-center py-8 text-gray-400 text-sm">
                                No withdrawals recorded yet.
                            </div>
                            <div v-for="w in recentWithdrawals" :key="w.id" class="p-3 rounded-lg border border-gray-100 flex items-center justify-between text-xs hover:bg-gray-50">
                                <div>
                                    <div class="font-semibold text-gray-800">Withdrawal via {{ w.payout_method }}</div>
                                    <div class="text-gray-400 mt-0.5">Ref: {{ w.reference_id }} &bull; {{ new Date(w.created_at).toLocaleString() }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-mono font-bold text-gray-900">BDT {{ Number(w.amount).toLocaleString() }}</div>
                                    <span :class="statusBadgeClass(w.status)" class="px-1.5 py-0.5 rounded text-[10px] uppercase font-bold">{{ w.status }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Wallet Transactions -->
                        <div v-if="activeTab === 'ledger'" class="space-y-2">
                            <div v-if="recentLedger?.length === 0" class="text-center py-8 text-gray-400 text-sm">
                                No transactions recorded yet.
                            </div>
                            <div v-for="tx in recentLedger" :key="tx.id" class="p-3 rounded-lg border border-gray-100 flex items-center justify-between text-xs hover:bg-gray-50">
                                <div>
                                    <div class="font-semibold text-gray-800">{{ tx.description }}</div>
                                    <div class="text-gray-400 mt-0.5">{{ new Date(tx.created_at).toLocaleString() }}</div>
                                </div>
                                <div class="text-right font-mono font-bold" :class="tx.type === 'credit' ? 'text-emerald-600' : 'text-rose-600'">
                                    {{ tx.type === 'credit' ? '+' : '-' }} BDT {{ Number(tx.amount).toLocaleString() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Balance Adjustment Modal -->
            <div v-if="showAdjustModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs">
                <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h3 class="font-bold text-gray-900 text-lg">Adjust Wallet Balance</h3>
                        <button @click="showAdjustModal = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                    </div>

                    <form @submit.prevent="submitAdjustment" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Type</label>
                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" @click="adjustForm.type = 'credit'" :class="adjustForm.type === 'credit' ? 'bg-emerald-600 text-white font-bold' : 'bg-gray-100 text-gray-700'" class="py-2 text-xs rounded-lg transition-all text-center">
                                    + Credit (Increase)
                                </button>
                                <button type="button" @click="adjustForm.type = 'debit'" :class="adjustForm.type === 'debit' ? 'bg-rose-600 text-white font-bold' : 'bg-gray-100 text-gray-700'" class="py-2 text-xs rounded-lg transition-all text-center">
                                    - Debit (Decrease)
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Amount (BDT)</label>
                            <input v-model="adjustForm.amount" type="number" step="0.01" min="1" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Note / Reason</label>
                            <textarea v-model="adjustForm.note" rows="2" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="showAdjustModal = false" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                            <button type="submit" :disabled="adjustForm.processing" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm">
                                Save
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
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    agent: { type: Object, required: true },
    recentAppointments: { type: Array, default: () => [] },
    recentTestBookings: { type: Array, default: () => [] },
    recentWithdrawals:  { type: Array, default: () => [] },
    recentLedger:       { type: Array, default: () => [] },
    recentCommissions:  { type: Array, default: () => [] },
    stats: { type: Object, default: () => ({}) },
});

const activeTab = ref('appointments');
const showAdjustModal = ref(false);

const adjustForm = useForm({
    amount: '',
    type: 'credit',
    note: '',
});

function statusBadgeClass(status) {
    switch (status) {
        case 'active':   return 'bg-emerald-100 text-emerald-800';
        case 'inactive': return 'bg-gray-100 text-gray-700';
        case 'pending':  return 'bg-amber-100 text-amber-800';
        default:         return 'bg-gray-100 text-gray-600';
    }
}

function submitAdjustment() {
    adjustForm.post(route('admin.agents.adjust-balance', props.agent.id), {
        preserveScroll: true,
        onSuccess: () => {
            showAdjustModal.value = false;
            adjustForm.reset();
        }
    });
}
</script>
