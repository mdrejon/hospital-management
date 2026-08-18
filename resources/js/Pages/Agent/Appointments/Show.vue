<template>
    <AgentLayout>
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
                    <a :href="route('agent.bookings.invoice', booking.id)" target="_blank" class="px-3.5 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs flex items-center gap-1.5">
                        <span>🖨️</span> Print Invoice
                    </a>
                    <Link :href="route('agent.bookings.index')" class="px-3.5 py-2 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        &larr; Back
                    </Link>
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
                        <div v-if="booking.message" class="pt-4 border-t mt-4">
                            <span class="text-gray-400 block text-xs font-semibold mb-1">Patient Message</span>
                            <p class="text-gray-700 text-sm bg-gray-50 p-3 rounded-lg">{{ booking.message }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Status & Payment -->
                <div class="space-y-6">
                    <!-- Status Progression -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900 border-b pb-2">Current Status</h3>

                        <div class="py-4 flex justify-center">
                            <span :class="statusBadge(booking.status)" class="px-4 py-1.5 rounded-full text-sm font-bold uppercase">
                                {{ formatStatus(booking.status) }}
                            </span>
                        </div>
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
                        
                        <div v-if="booking.payment_status === 'paid'" class="mt-4 bg-emerald-50 text-emerald-700 p-3 rounded-lg text-xs font-semibold text-center border border-emerald-200">
                            Fully Paid
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

const dueAmount = computed(() => {
    return Math.max(0, (props.booking.fee || 0) - (props.booking.paid_amount || 0));
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
</script>
