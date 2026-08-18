<template>
    <AgentLayout>
        <div class="space-y-6">
            <!-- Header & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-xl">
                        🧪
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-xl font-bold text-gray-900">Order #{{ booking.booking_number }}</h1>
                            <span :class="statusBadge(booking.status)" class="px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase">
                                {{ formatStatus(booking.status) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">Booked on {{ new Date(booking.created_at).toLocaleString() }} &bull; Patient: <strong class="text-gray-800">{{ booking.patient_name }}</strong></p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a :href="route('agent.bookings.test.invoice', booking.id)" target="_blank" class="px-3.5 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs flex items-center gap-1.5">
                        <span>🖨️</span> Print Invoice / Token
                    </a>
                    <Link :href="route('agent.bookings.tests')" class="px-3.5 py-2 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        &larr; Back
                    </Link>
                </div>
            </div>

            <!-- Agent Commission Banner (if booked via agent) -->
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200/80 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-sm">
                        🧑‍💼
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase text-emerald-800 tracking-wider">Your Commission</div>
                        <div class="text-sm font-semibold text-gray-900">For Medical Test Booking</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-xs text-emerald-700 font-medium">Commission Earned:</div>
                    <div class="text-lg font-black text-emerald-900">BDT {{ Number(booking.agent_commission_amount || 0).toLocaleString() }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Test Items & Lab Reports (2 cols) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- 1. Ordered Tests & Report Upload -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <div class="flex items-center justify-between border-b pb-3">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900">Diagnostic Tests ({{ booking.items?.length || 0 }})</h2>
                            <span class="text-xs text-gray-500 font-mono">Total Bill: BDT {{ Number(booking.total_amount).toLocaleString() }}</span>
                        </div>

                        <div class="divide-y divide-gray-100">
                            <div v-for="item in booking.items" :key="item.id" class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="space-y-1">
                                    <div class="font-bold text-gray-900 text-sm">{{ item.test_name }}</div>
                                    <div class="text-xs text-gray-400 font-mono">Code: {{ item.test_code }} &bull; Specimen: {{ item.medical_test?.sample_type || 'Blood' }}</div>
                                    <div class="text-xs text-blue-600">Standard Price: BDT {{ Number(item.unit_price).toLocaleString() }} <span v-if="item.discount_amount > 0" class="text-emerald-600">(- BDT {{ Number(item.discount_amount).toLocaleString() }} discount)</span></div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <!-- Report download or upload -->
                                    <div v-if="item.report_file" class="flex items-center gap-2">
                                        <a :href="'/storage/' + item.report_file" target="_blank" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-lg text-xs font-bold flex items-center gap-1">
                                            <span>📄</span> View Report
                                        </a>
                                    </div>
                                    <div v-else>
                                        <span class="px-3 py-1.5 bg-gray-50 text-gray-500 rounded-lg text-xs font-semibold">Report Pending</span>
                                    </div>

                                    <div class="text-right min-w-[90px]">
                                        <div class="text-sm font-black text-gray-900">BDT {{ Number(item.final_price).toLocaleString() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Patient & Referral Details -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 border-b pb-2">Patient Profile</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
                            <div>
                                <span class="text-gray-400 block">Name</span>
                                <strong class="text-gray-900 text-sm">{{ booking.patient_name }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Phone</span>
                                <strong class="text-gray-900 text-sm font-mono">{{ booking.phone }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Gender & Age</span>
                                <span class="text-gray-800 capitalize">{{ booking.gender }} {{ booking.date_of_birth ? `(${booking.date_of_birth})` : '' }}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-400 block">Address</span>
                                <span class="text-gray-800">{{ booking.address || 'Not specified' }}</span>
                            </div>
                            <div v-if="booking.doctor">
                                <span class="text-gray-400 block">Referring Doctor</span>
                                <span class="text-blue-700 font-semibold">Dr. {{ displayTranslatable(booking.doctor.name, langs) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Status Update & Payment Collection (1 col) -->
                <div class="space-y-6">
                    <!-- Status Progression -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900 border-b pb-2">Process & Lab Status</h3>
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 font-medium">Current Status:</span>
                                <span :class="statusBadge(booking.status)" class="px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase">{{ formatStatus(booking.status) }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between text-sm border-t pt-3">
                                <span class="text-gray-500 font-medium">Report Delivery Date:</span>
                                <span class="text-gray-900 font-bold">{{ booking.report_delivery_date || 'Pending' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Financial & Payment Updates -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900 border-b pb-2">Billing & Payment</h3>

                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal:</span>
                                <span class="font-semibold text-gray-900">BDT {{ Number(booking.subtotal).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between text-emerald-600">
                                <span>Discounts:</span>
                                <span class="font-semibold">- BDT {{ Number(booking.discount_amount).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between text-gray-900 font-bold border-t pt-2">
                                <span>Net Total:</span>
                                <span>BDT {{ Number(booking.total_amount).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between text-blue-600">
                                <span>Paid So Far:</span>
                                <span class="font-bold">BDT {{ Number(booking.paid_amount).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between font-black text-sm" :class="booking.due_amount > 0 ? 'text-rose-600' : 'text-emerald-600'">
                                <span>Due Balance:</span>
                                <span>BDT {{ Number(booking.due_amount).toLocaleString() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AgentLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import AgentLayout from '@/Layouts/AgentLayout.vue';
import { displayTranslatable } from '@/Composables/useTranslatable';

const props = defineProps({
    booking: { type: Object, required: true },
});

const langs = computed(() => usePage().props.languages ?? []);

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

</script>
