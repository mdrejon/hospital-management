<template>
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xl">
                        📅
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-xl font-bold text-gray-900">Appointment #{{ booking.id }}</h1>
                            <span :class="statusBadge(booking.status)" class="px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase">
                                {{ formatStatus(booking.status) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">Booked on {{ new Date(booking.created_at).toLocaleString() }} &bull; Patient: <strong class="text-gray-800">{{ booking.name }}</strong></p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a :href="route('admin.appointments.invoice', booking.id)" target="_blank" class="px-3.5 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs flex items-center gap-1.5">
                        <span>🖨️</span> Print Invoice
                    </a>
                    <Link :href="route('admin.appointments.index')" class="px-3.5 py-2 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        &larr; Back
                    </Link>
                </div>
            </div>

            <!-- Agent Commission Banner (if booked via agent) -->
            <div v-if="booking.agent" class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200/80 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-sm">
                        🧑‍💼
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase text-emerald-800 tracking-wider">Referred By Agent</div>
                        <div class="text-sm font-semibold text-gray-900">{{ booking.agent.user?.name }} (Code: {{ booking.agent.agent_code }}) &bull; {{ booking.agent.phone }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Details -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Doctor & Schedule -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <div class="flex items-center justify-between border-b pb-3">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900">Doctor & Schedule</h2>
                            <span class="text-xs text-gray-500 font-mono capitalize">Source: {{ (booking.source || 'Unknown').replace('_', ' ') }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-400 block text-xs">Doctor</span>
                                <strong class="text-gray-900" v-if="booking.doctor">
                                    Dr. {{ displayTranslatable(booking.doctor.name, langs) }}
                                </strong>
                                <strong class="text-gray-900" v-else-if="booking.preferred_doctor">
                                    {{ booking.preferred_doctor }}
                                </strong>
                                <span class="text-gray-500" v-else>Not specified</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-xs">Specialization</span>
                                <span class="text-gray-800" v-if="booking.doctor?.specialization">
                                    {{ displayTranslatable(booking.doctor.specialization.name, langs) }}
                                </span>
                                <span class="text-gray-800" v-else-if="booking.department">
                                    {{ booking.department }}
                                </span>
                                <span class="text-gray-500" v-else>N/A</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-xs">Date</span>
                                <strong class="text-gray-900">{{ booking.appointment_date || booking.preferred_date || 'N/A' }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-xs">Time / Slot</span>
                                <strong class="text-gray-900">{{ booking.time_slot || 'N/A' }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Patient Profile -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900 border-b pb-2">Patient Profile</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
                            <div>
                                <span class="text-gray-400 block">Name</span>
                                <strong class="text-gray-900 text-sm">{{ booking.name }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Phone</span>
                                <strong class="text-gray-900 text-sm font-mono">{{ booking.phone || 'N/A' }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Email</span>
                                <span class="text-gray-800">{{ booking.email || 'N/A' }}</span>
                            </div>
                        </div>
                        <div v-if="booking.message || booking.notes" class="pt-4 border-t mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div v-if="booking.message">
                                <span class="text-gray-400 block text-xs font-semibold mb-1">Patient Message</span>
                                <p class="text-gray-700 text-sm bg-gray-50 p-3 rounded-lg">{{ booking.message }}</p>
                            </div>
                            <div v-if="booking.notes">
                                <span class="text-gray-400 block text-xs font-semibold mb-1">Internal Notes</span>
                                <p class="text-gray-700 text-sm bg-yellow-50 p-3 rounded-lg">{{ booking.notes }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Status & Payment -->
                <div class="space-y-6">
                    <!-- Status Progression -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900 border-b pb-2">Update Status</h3>

                        <form @submit.prevent="submitStatus" class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Status</label>
                                <select v-model="statusForm.status" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="no_show">No Show</option>
                                </select>
                            </div>
                            <button type="submit" :disabled="statusForm.processing" class="w-full py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs transition-all">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <!-- Financial & Payment Updates -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900 border-b pb-2">Billing & Payment</h3>

                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between text-gray-900 font-bold border-b pb-2 mb-2">
                                <span>Consultation Fee:</span>
                                <span>BDT {{ Number(booking.fee || 0).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between text-blue-600">
                                <span>Paid Amount:</span>
                                <span class="font-bold">BDT {{ Number(booking.paid_amount || 0).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between font-black text-sm" :class="dueAmount > 0 ? 'text-rose-600' : 'text-emerald-600'">
                                <span>Due Balance:</span>
                                <span>BDT {{ Number(dueAmount).toLocaleString() }}</span>
                            </div>
                        </div>

                        <!-- Payment Collection Form -->
                        <div v-if="dueAmount > 0" class="border-t pt-3 space-y-3">
                            <h4 class="text-2xs font-bold uppercase tracking-wider text-gray-500">Collect Payment</h4>
                            <form @submit.prevent="submitPayment" class="space-y-3">
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-600 uppercase mb-0.5">Collect Amount (BDT)</label>
                                    <input v-model="paymentForm.paid_amount" type="number" step="0.01" min="1" :max="dueAmount" required class="w-full px-3 py-1.5 text-xs border rounded-lg focus:outline-none font-bold" />
                                </div>
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-600 uppercase mb-0.5">Method</label>
                                    <select v-model="paymentForm.payment_method" class="w-full px-3 py-1.5 text-xs border rounded-lg focus:outline-none bg-white">
                                        <option value="cash">Cash</option>
                                        <option value="bkash">bKash</option>
                                        <option value="nagad">Nagad</option>
                                        <option value="rocket">Rocket</option>
                                        <option value="card">Card</option>
                                    </select>
                                </div>
                                <button type="submit" :disabled="paymentForm.processing" class="w-full py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition-all">
                                    Record Payment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import { displayTranslatable } from '@/Composables/useTranslatable';

const props = defineProps({
    booking: { type: Object, required: true },
});

const langs = computed(() => usePage().props.languages ?? []);

const dueAmount = computed(() => {
    return Math.max(0, (props.booking.fee || 0) - (props.booking.paid_amount || 0));
});

const statusForm = useForm({
    status: props.booking.status || 'pending',
});

const paymentForm = useForm({
    paid_amount: dueAmount.value,
    payment_method: 'cash',
});

function formatStatus(status) {
    if (!status) return 'Pending';
    return status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
}

function statusBadge(status) {
    switch (status) {
        case 'pending':          return 'bg-amber-100 text-amber-800 border border-amber-200';
        case 'confirmed':        return 'bg-cyan-100 text-cyan-800 border border-cyan-200';
        case 'completed':        return 'bg-emerald-100 text-emerald-800 border border-emerald-200';
        case 'cancelled':        return 'bg-rose-100 text-rose-800 border border-rose-200';
        case 'no_show':          return 'bg-gray-100 text-gray-700 border border-gray-200';
        default:                 return 'bg-gray-100 text-gray-700';
    }
}

function submitStatus() {
    statusForm.patch(route('admin.appointments.update-status', props.booking.id), {
        preserveScroll: true,
    });
}

function submitPayment() {
    paymentForm.patch(route('admin.appointments.update-payment', props.booking.id), {
        preserveScroll: true,
        onSuccess: () => {
            paymentForm.reset('paid_amount');
            paymentForm.paid_amount = dueAmount.value;
        }
    });
}
</script>
