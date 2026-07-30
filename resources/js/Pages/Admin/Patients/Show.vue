<template>
    <AdminLayout>
        <div class="space-y-4">
            <div class="flex items-center gap-2 text-xs text-gray-400">
                <Link :href="route('admin.patients.index')" class="hover:text-blue-600">Patients</Link>
                <span>/</span>
                <span class="text-gray-600">{{ patient.name }}</span>
            </div>

            <!-- Patient summary -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-lg font-semibold text-gray-800">{{ patient.name }}</h1>
                        <p class="text-xs text-gray-400 mt-0.5">Patient since {{ formatDate(patient.created_at) }}</p>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                        <div>
                            <div class="text-xl font-bold text-blue-600">{{ patient.appointments.length }}</div>
                            <div class="text-xs text-gray-400">Total Visits</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-gray-700">{{ patient.age ?? '—' }}</div>
                            <div class="text-xs text-gray-400">Age</div>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-700 capitalize pt-1.5">{{ patient.gender || '—' }}</div>
                            <div class="text-xs text-gray-400">Gender</div>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-700 pt-1.5">{{ lastVisit }}</div>
                            <div class="text-xs text-gray-400">Last Visit</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6 pt-4 border-t border-gray-100 text-sm">
                    <div>
                        <p class="text-xs text-gray-400">Phone</p>
                        <p class="text-gray-700">{{ patient.phone || '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Email</p>
                        <p class="text-gray-700">{{ patient.email || '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Address</p>
                        <p class="text-gray-700">{{ patient.address || '—' }}</p>
                    </div>
                </div>
            </div>

            <!-- Appointment history -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-700">Appointment History</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Every appointment this patient has ever booked, across all doctors.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm min-w-[900px]">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Date / Time</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Doctor</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Serial</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Fee</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Symptoms</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Documents</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-if="!patient.appointments.length">
                                <td colspan="8" class="px-4 py-8 text-center text-gray-400 text-sm">No appointments recorded for this patient yet.</td>
                            </tr>
                            <tr v-for="a in patient.appointments" :key="a.id" class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-700">
                                    {{ a.appointment_date || '—' }}
                                    <span v-if="a.time_slot" class="text-gray-400">{{ a.time_slot }}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 text-xs">{{ a.doctor?.name || a.preferred_doctor || '—' }}</td>
                                <td class="px-4 py-3 text-gray-600 text-xs capitalize">{{ (a.appointment_type || '').replace('_', ' ') || '—' }}</td>
                                <td class="px-4 py-3 text-gray-500 text-xs">{{ a.serial_number ? '#' + a.serial_number : '—' }}</td>
                                <td class="px-4 py-3 text-gray-600 text-xs">{{ a.fee ? '৳' + a.fee : '—' }}</td>
                                <td class="px-4 py-3 text-gray-600 text-xs max-w-[220px] truncate" :title="a.symptoms">{{ a.symptoms || '—' }}</td>
                                <td class="px-4 py-3 text-xs">
                                    <div v-if="documentsFor(a).length" class="flex flex-col gap-0.5">
                                        <a v-for="(doc, i) in documentsFor(a)" :key="doc" :href="'/storage/' + doc" target="_blank" rel="noopener"
                                            class="text-blue-600 hover:underline">Document {{ documentsFor(a).length > 1 ? i + 1 : '' }}</a>
                                    </div>
                                    <span v-else class="text-gray-400">—</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span :class="statusBadge(a.status)" class="px-2 py-0.5 rounded-full text-xs font-medium">
                                        {{ statusLabel(a.status) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

const props = defineProps({
    patient: { type: Object, required: true },
});

const lastVisit = computed(() => props.patient.appointments[0]?.appointment_date || '—');

function documentsFor(a) {
    if (Array.isArray(a.documents) && a.documents.length) return a.documents;
    return a.document ? [a.document] : [];
}

function formatDate(d) {
    if (!d) return '—';
    return new Date(d).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' });
}

function statusLabel(s) {
    return {
        pending: 'Pending', confirmed: 'Confirmed', checked_in: 'Checked In',
        in_consultation: 'In Consultation', completed: 'Completed',
        follow_up_required: 'Follow-up Required', cancelled: 'Cancelled', no_show: 'No Show',
    }[s] ?? s;
}

function statusBadge(s) {
    return {
        pending: 'bg-yellow-100 text-yellow-700', confirmed: 'bg-green-100 text-green-700',
        checked_in: 'bg-cyan-100 text-cyan-700', in_consultation: 'bg-indigo-100 text-indigo-700',
        completed: 'bg-blue-100 text-blue-700', follow_up_required: 'bg-orange-100 text-orange-700',
        cancelled: 'bg-red-100 text-red-700', no_show: 'bg-gray-200 text-gray-700',
    }[s] ?? 'bg-gray-100 text-gray-600';
}
</script>
