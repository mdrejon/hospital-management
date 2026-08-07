<template>
    <AgentLayout>
        <div class="space-y-5">
            <!-- Top Header & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Agent Dashboard</h1>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Welcome back, {{ $page.props.auth?.user?.name }}. You earn {{ stats.doctor_rate }}% on Doctor Appointments and {{ stats.test_rate }}% on Medical Tests.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <Link
                        :href="route('agent.doctor.create')"
                        class="px-3.5 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors shadow-sm"
                    >
                        + Book Doctor
                    </Link>
                    <Link
                        :href="route('agent.test.create')"
                        class="px-3.5 py-2 text-xs font-semibold text-white bg-purple-600 hover:bg-purple-700 rounded-md transition-colors shadow-sm"
                    >
                        + Book Medical Test
                    </Link>
                    <Link
                        :href="route('agent.wallet.index')"
                        class="px-3.5 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-md transition-colors shadow-sm"
                    >
                        Cash Out
                    </Link>
                </div>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="rounded-lg p-5 text-white bg-emerald-600 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-emerald-100">Wallet Balance</p>
                        <p class="text-2xl font-bold leading-tight mt-1">BDT {{ Number(stats.wallet_balance).toLocaleString() }}</p>
                        <Link :href="route('agent.wallet.index')" class="text-xs text-emerald-200 hover:text-white underline mt-1 inline-block">
                            Withdraw &rarr;
                        </Link>
                    </div>
                    <div class="text-3xl opacity-80">💵</div>
                </div>

                <div class="rounded-lg p-5 text-white bg-blue-600 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-blue-100">Total Earned</p>
                        <p class="text-2xl font-bold leading-tight mt-1">BDT {{ Number(stats.total_earned).toLocaleString() }}</p>
                        <span class="text-xs text-blue-200 mt-1 inline-block">
                            Withdrawn: BDT {{ Number(stats.total_withdrawn).toLocaleString() }}
                        </span>
                    </div>
                    <div class="text-3xl opacity-80">📈</div>
                </div>

                <div class="rounded-lg p-5 text-white bg-indigo-600 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-indigo-100">Doctor Bookings</p>
                        <p class="text-2xl font-bold leading-tight mt-1">{{ stats.total_appointments }}</p>
                        <span class="text-xs text-indigo-200 mt-1 inline-block">
                            Rate: {{ stats.doctor_rate }}% per visit
                        </span>
                    </div>
                    <div class="text-3xl opacity-80">🩺</div>
                </div>

                <div class="rounded-lg p-5 text-white bg-purple-600 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-purple-100">Medical Tests</p>
                        <p class="text-2xl font-bold leading-tight mt-1">{{ stats.total_tests }}</p>
                        <span class="text-xs text-purple-200 mt-1 inline-block">
                            Rate: {{ stats.test_rate }}% per test
                        </span>
                    </div>
                    <div class="text-3xl opacity-80">🔬</div>
                </div>
            </div>

            <!-- Two-Column Recent Activity (Doctor Bookings + Medical Tests) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Recent Doctor Appointments -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-gray-700">Recent Doctor Bookings</h2>
                        <Link :href="route('agent.bookings.index', { tab: 'appointments' })" class="text-xs text-blue-600 hover:underline">
                            View all
                        </Link>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600">
                            <tr>
                                <th class="px-4 py-2.5 text-left">Patient</th>
                                <th class="px-4 py-2.5 text-left">Doctor</th>
                                <th class="px-4 py-2.5 text-left">Date</th>
                                <th class="px-4 py-2.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-if="!recentAppointments.length">
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">No doctor appointments booked yet.</td>
                            </tr>
                            <tr v-for="a in recentAppointments" :key="a.id" class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-800 text-xs">{{ a.name }}</p>
                                    <p class="text-2xs text-gray-400">{{ a.phone }}</p>
                                </td>
                                <td class="px-4 py-3 text-gray-600 text-xs">{{ a.doctor?.name || a.preferred_doctor || '—' }}</td>
                                <td class="px-4 py-3 text-gray-600 text-xs">{{ a.appointment_date }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span :class="statusBadge(a.status)" class="px-2 py-0.5 rounded-full text-2xs font-semibold uppercase">
                                        {{ a.status }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Recent Medical Tests -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-gray-700">Recent Medical Test Orders</h2>
                        <Link :href="route('agent.bookings.index', { tab: 'tests' })" class="text-xs text-blue-600 hover:underline">
                            View all
                        </Link>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600">
                            <tr>
                                <th class="px-4 py-2.5 text-left">Booking # / Patient</th>
                                <th class="px-4 py-2.5 text-left">Date</th>
                                <th class="px-4 py-2.5 text-right">Net Bill</th>
                                <th class="px-4 py-2.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-if="!recentTests.length">
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">No medical tests booked yet.</td>
                            </tr>
                            <tr v-for="t in recentTests" :key="t.id" class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-800 text-xs">{{ t.patient_name }}</p>
                                    <p class="text-2xs text-gray-400 font-mono">#{{ t.booking_number }}</p>
                                </td>
                                <td class="px-4 py-3 text-gray-600 text-xs">{{ t.appointment_date }}</td>
                                <td class="px-4 py-3 text-right font-mono text-xs font-semibold text-gray-700">
                                    BDT {{ Number(t.net_amount || 0).toLocaleString() }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span :class="statusBadge(t.status)" class="px-2 py-0.5 rounded-full text-2xs font-semibold uppercase">
                                        {{ t.status }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Wallet Transactions Ledger -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-700">Recent Wallet Transactions</h2>
                    <Link :href="route('agent.wallet.index')" class="text-xs text-blue-600 hover:underline">
                        View Wallet Details
                    </Link>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600">
                        <tr>
                            <th class="px-4 py-2.5 text-left">Type</th>
                            <th class="px-4 py-2.5 text-left">Description</th>
                            <th class="px-4 py-2.5 text-right">Amount</th>
                            <th class="px-4 py-2.5 text-right">Balance After</th>
                            <th class="px-4 py-2.5 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-if="!recentTransactions.length">
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400 text-sm">No wallet transactions recorded yet.</td>
                        </tr>
                        <tr v-for="trx in recentTransactions" :key="trx.id" class="hover:bg-gray-50 text-xs">
                            <td class="px-4 py-3">
                                <span
                                    :class="trx.type === 'credit' ? 'bg-green-100 text-green-700' : 'bg-rose-100 text-rose-700'"
                                    class="px-2 py-0.5 rounded-full text-2xs font-bold uppercase"
                                >
                                    {{ trx.type }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ trx.description }}</td>
                            <td class="px-4 py-3 text-right font-mono font-bold" :class="trx.type === 'credit' ? 'text-green-600' : 'text-rose-600'">
                                {{ trx.type === 'credit' ? '+' : '-' }}BDT {{ Number(trx.amount).toLocaleString() }}
                            </td>
                            <td class="px-4 py-3 text-right font-mono text-gray-600">
                                BDT {{ Number(trx.balance_after).toLocaleString() }}
                            </td>
                            <td class="px-4 py-3 text-right text-gray-500">{{ formatDate(trx.created_at) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AgentLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AgentLayout from '@/Layouts/AgentLayout.vue';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            wallet_balance: 0,
            total_earned: 0,
            total_withdrawn: 0,
            total_appointments: 0,
            total_tests: 0,
            doctor_rate: 10,
            test_rate: 15,
        })
    },
    recentAppointments: { type: Array, default: () => [] },
    recentTests: { type: Array, default: () => [] },
    recentTransactions: { type: Array, default: () => [] }
});

function statusBadge(status) {
    const s = String(status || '').toLowerCase();
    if (s === 'approved' || s === 'completed' || s === 'paid') return 'bg-green-100 text-green-700';
    if (s === 'pending' || s === 'processing') return 'bg-amber-100 text-amber-700';
    if (s === 'cancelled' || s === 'rejected') return 'bg-rose-100 text-rose-700';
    return 'bg-gray-100 text-gray-700';
}

function formatDate(val) {
    if (!val) return '—';
    try {
        const d = new Date(val);
        return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    } catch {
        return val;
    }
}
</script>
