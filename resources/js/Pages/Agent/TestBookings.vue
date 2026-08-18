<template>
    <AgentLayout>
        <div class="space-y-5">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Test Bookings List</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Track all patient medical tests booked through your agent account</p>
                </div>
                <div class="flex items-center gap-2">
                    <Link :href="route('agent.doctor.create')" class="px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors shadow-sm flex items-center gap-1.5">
                        <span>+</span> Book Doctor
                    </Link>
                    <Link :href="route('agent.test.create')" class="px-3 py-1.5 text-xs font-semibold text-white bg-purple-600 hover:bg-purple-700 rounded transition-colors shadow-sm flex items-center gap-1.5">
                        <span>+</span> Book Medical Test
                    </Link>
                </div>
            </div>

            <!-- Search Filter -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-200">
                <h2 class="pb-3 text-sm font-bold text-gray-800">
                    Medical Tests ({{ testBookings.total || 0 }})
                </h2>

                <div class="pb-3 flex items-center gap-2">
                    <input v-model="filterSearch" @keyup.enter="applySearch" type="text" placeholder="Search by patient, phone..." class="px-3 py-1.5 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 w-full sm:w-64" />
                    <button @click="applySearch" class="px-3 py-1.5 text-xs font-semibold text-white bg-gray-800 rounded hover:bg-gray-900 transition-colors">
                        Search
                    </button>
                </div>
            </div>

            <!-- Medical Tests Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-600">
                        <thead class="bg-gray-50 text-xs font-semibold text-gray-600 border-b border-gray-200">
                            <tr>
                                <th class="px-5 py-3">Booking # / Patient</th>
                                <th class="px-5 py-3">Date</th>
                                <th class="px-5 py-3">Selected Tests</th>
                                <th class="px-5 py-3">Net Bill</th>
                                <th class="px-5 py-3">Payment</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="tb in testBookings.data" :key="tb.id" class="hover:bg-gray-50">
                                <td class="px-5 py-3.5">
                                    <div class="font-mono font-semibold text-blue-600">#{{ tb.booking_number }}</div>
                                    <div class="font-medium text-gray-900 mt-0.5">{{ tb.patient_name }}</div>
                                    <div class="text-2xs text-gray-400">{{ tb.phone }}</div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="font-medium text-gray-800">{{ tb.booking_date }}</div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="space-y-0.5">
                                        <div v-for="item in tb.items" :key="item.id" class="text-xs text-gray-700 flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                            <span>{{ localized(item.medical_test?.name) || item.test_name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 font-mono font-bold text-gray-900 text-sm">
                                    BDT {{ Number(tb.total_amount || 0).toLocaleString() }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="space-y-1">
                                        <span :class="paymentBadge(tb.payment_status)" class="px-2 py-0.5 rounded-full text-3xs font-bold uppercase">
                                            {{ tb.payment_status }}
                                        </span>
                                        <div v-if="tb.payment_method" class="text-3xs text-gray-400 uppercase font-mono">
                                            {{ tb.payment_method }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span :class="statusBadge(tb.status)" class="px-2 py-0.5 rounded-full text-2xs font-semibold uppercase">
                                        {{ tb.status }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex flex-col gap-2">
                                        <Link :href="route('agent.bookings.test.show', tb.id)" class="px-3 py-1 text-xs font-semibold text-center text-blue-700 bg-blue-50 hover:bg-blue-100 rounded border border-blue-200 transition-colors">
                                            Details &rarr;
                                        </Link>
                                        <button v-if="tb.payment_status === 'unpaid' && tb.total_amount > 0 && paymentSettings?.has_online" @click="openPayModal('medical_test', tb.id, tb.total_amount, tb.patient_name)" class="px-3 py-1 text-xs font-bold text-white bg-purple-600 hover:bg-purple-700 rounded shadow-xs transition-colors text-center">
                                            💳 Pay Online
                                        </button>
                                        <a v-else-if="tb.payment_status === 'paid' && tb.payments?.[0]" :href="route('payment.receipt', tb.payments[0].id)" target="_blank" class="px-3 py-1 text-xs font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 rounded border border-purple-200 transition-colors text-center">
                                            🧾 Receipt
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="testBookings.data.length === 0">
                                <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                                    No medical test bookings found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="testBookings.links?.length > 3" class="p-3.5 border-t border-gray-100 flex justify-center gap-1">
                    <Link v-for="(link, i) in testBookings.links" :key="i" :href="link.url || '#'" :class="[link.active ? 'bg-blue-600 text-white font-semibold' : 'text-gray-600 hover:bg-gray-100', !link.url ? 'opacity-50 cursor-not-allowed' : '']" class="px-3 py-1 rounded text-xs" v-html="link.label">
                    </Link>
                </div>
            </div>
        </div>

        <!-- Quick Online Payment Modal -->
        <div v-if="payModal.show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white rounded-xl max-w-sm w-full p-5 space-y-4 shadow-xl">
                <div class="flex items-center justify-between border-b pb-2.5">
                    <h3 class="font-bold text-sm text-gray-900">Online Payment</h3>
                    <button @click="payModal.show = false" class="text-gray-400 hover:text-gray-600 font-bold">&times;</button>
                </div>

                <div class="space-y-1">
                    <div class="text-xs text-gray-500">Pay for {{ payModal.name }}</div>
                    <div class="text-xl font-bold text-gray-900">BDT {{ Number(payModal.amount).toLocaleString() }}</div>
                </div>

                <form method="POST" :action="route('payment.initiate')">
                    <input type="hidden" name="_token" :value="csrfToken" />
                    <input type="hidden" name="payable_type" :value="payModal.type" />
                    <input type="hidden" name="payable_id" :value="payModal.id" />

                    <label class="block text-2xs font-bold uppercase tracking-wider text-gray-600 mb-2">Select Gateway:</label>
                    <div class="space-y-2">
                        <label v-if="paymentSettings?.gateways?.bkash" class="flex items-center gap-3 p-3 rounded-lg border cursor-pointer hover:bg-pink-50/50">
                            <input type="radio" name="gateway" value="bkash" checked class="text-pink-600 focus:ring-pink-500" />
                            <div>
                                <div class="text-xs font-bold text-gray-900">bKash Payment</div>
                                <div class="text-3xs text-gray-400">Direct mobile wallet</div>
                            </div>
                        </label>
                        <label v-if="paymentSettings?.gateways?.sslcommerz" class="flex items-center gap-3 p-3 rounded-lg border cursor-pointer hover:bg-blue-50/50">
                            <input type="radio" name="gateway" value="sslcommerz" :checked="!paymentSettings?.gateways?.bkash" class="text-blue-600 focus:ring-blue-500" />
                            <div>
                                <div class="text-xs font-bold text-gray-900">SSLCommerz</div>
                                <div class="text-3xs text-gray-400">Cards / Nagad / Rocket / Net Banking</div>
                            </div>
                        </label>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <button type="button" @click="payModal.show = false" class="flex-1 py-2 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded shadow-xs">
                            Proceed to Pay &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AgentLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AgentLayout from '@/Layouts/AgentLayout.vue';

const props = defineProps({
    testBookings:    { type: Object, default: () => ({ data: [], total: 0 }) },
    search:          { type: String, default: '' },
    paymentSettings: { type: Object, default: () => ({}) },
});

const filterSearch = ref(props.search);
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

const payModal = ref({
    show: false,
    type: 'medical_test',
    id: null,
    amount: 0,
    name: '',
});

function openPayModal(type, id, amount, name) {
    payModal.value = {
        show: true,
        type,
        id,
        amount,
        name,
    };
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

function applySearch() {
    router.get(route('agent.bookings.tests'), {
        search: filterSearch.value
    }, { preserveState: true });
}

function statusBadge(status) {
    const s = String(status || '').toLowerCase();
    if (s === 'approved' || s === 'completed' || s === 'paid' || s === 'confirmed') return 'bg-emerald-100 text-emerald-700';
    if (s === 'pending' || s === 'processing') return 'bg-amber-100 text-amber-700';
    if (s === 'cancelled' || s === 'rejected') return 'bg-rose-100 text-rose-700';
    return 'bg-gray-100 text-gray-700';
}

function paymentBadge(status) {
    const s = String(status || '').toLowerCase();
    if (s === 'paid') return 'bg-emerald-100 text-emerald-800';
    if (s === 'partially_paid') return 'bg-blue-100 text-blue-800';
    return 'bg-gray-100 text-gray-700';
}
</script>
