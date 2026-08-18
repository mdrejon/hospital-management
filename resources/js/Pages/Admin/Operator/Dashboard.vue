<template>
    <AdminLayout>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Operator Dashboard</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Today's appointment queue</p>
                </div>
                <a :href="route('admin.operator.book')"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                    + Book Appointment
                </a>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                    <div class="text-2xl font-bold text-gray-700">{{ stats.today }}</div>
                    <div class="text-xs text-gray-400 mt-1">Today's Appointments</div>
                </div>
                <div class="bg-yellow-50 rounded-lg shadow-sm p-4 text-center border border-yellow-200">
                    <div class="text-2xl font-bold text-yellow-600">{{ stats.pending }}</div>
                    <div class="text-xs text-gray-400 mt-1">Pending Requests</div>
                </div>
                <div class="bg-green-50 rounded-lg shadow-sm p-4 text-center border border-green-200">
                    <div class="text-2xl font-bold text-green-600">{{ stats.confirmed }}</div>
                    <div class="text-xs text-gray-400 mt-1">Confirmed (Today)</div>
                </div>
                <div class="bg-cyan-50 rounded-lg shadow-sm p-4 text-center border border-cyan-200">
                    <div class="text-2xl font-bold text-cyan-600">{{ stats.waiting }}</div>
                    <div class="text-xs text-gray-400 mt-1">Waiting (Checked In)</div>
                </div>
                <div class="bg-blue-50 rounded-lg shadow-sm p-4 text-center border border-blue-200">
                    <div class="text-2xl font-bold text-blue-600">{{ stats.completed }}</div>
                    <div class="text-xs text-gray-400 mt-1">Completed Bookings</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-700">Today's Queue</h2>
                </div>
                <table class="w-full text-sm min-w-[800px]">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Serial</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Patient</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Doctor</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Time</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-if="!todayAppointments.length">
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400 text-sm">No appointments today.</td>
                        </tr>
                        <tr v-for="a in todayAppointments" :key="a.id" class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-500">#{{ a.serial_number ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-800">{{ a.name }}</p>
                                <p class="text-xs text-gray-400">{{ a.phone }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">{{ a.doctor?.name || a.preferred_doctor || '—' }}</td>
                            <td class="px-4 py-3 text-gray-600 text-xs">{{ a.time_slot || '—' }}</td>
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
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

defineProps({
    todayAppointments: { type: Array, default: () => [] },
    stats:             { type: Object, default: () => ({}) },
});

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
