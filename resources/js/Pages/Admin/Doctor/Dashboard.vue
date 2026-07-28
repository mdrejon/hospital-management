<template>
    <AdminLayout>
        <div class="space-y-4">
            <h1 class="text-lg font-semibold text-gray-800">
                {{ unlinked ? 'Doctor Dashboard' : `Welcome, ${doctorName}` }}
            </h1>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <div v-if="unlinked" class="px-4 py-3 bg-yellow-50 border border-yellow-200 text-yellow-700 text-sm rounded">
                Your login isn't linked to a doctor profile yet. Ask an administrator to set the "Linked Doctor Profile" on your user account.
            </div>

            <template v-else>
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                        <div class="text-2xl font-bold text-gray-700">{{ stats.today }}</div>
                        <div class="text-xs text-gray-400 mt-1">Today's Schedule</div>
                    </div>
                    <div class="bg-blue-50 rounded-lg shadow-sm p-4 text-center border border-blue-200">
                        <div class="text-2xl font-bold text-blue-600">{{ stats.upcoming }}</div>
                        <div class="text-xs text-gray-400 mt-1">Upcoming Appointments</div>
                    </div>
                    <div class="bg-green-50 rounded-lg shadow-sm p-4 text-center border border-green-200">
                        <div class="text-2xl font-bold text-green-600">{{ stats.completed }}</div>
                        <div class="text-xs text-gray-400 mt-1">Completed Patients</div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg shadow-sm p-4 text-center border border-yellow-200">
                        <div class="text-2xl font-bold text-yellow-600">{{ stats.pending }}</div>
                        <div class="text-xs text-gray-400 mt-1">Pending Patients</div>
                    </div>
                    <div class="bg-orange-50 rounded-lg shadow-sm p-4 text-center border border-orange-200">
                        <div class="text-2xl font-bold text-orange-600">{{ stats.followUp }}</div>
                        <div class="text-xs text-gray-400 mt-1">Follow-up Patients</div>
                    </div>
                </div>

                <section class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-sm font-semibold text-gray-700">Today's Schedule</h2>
                    </div>
                    <div v-if="!today.length" class="px-6 py-8 text-center text-gray-400 text-sm">No appointments today.</div>
                    <div v-else class="divide-y divide-gray-50">
                        <div v-for="a in today" :key="a.id" class="px-6 py-3 flex items-center gap-4">
                            <span class="text-xs text-gray-400 w-16">#{{ a.serial_number ?? '—' }}</span>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 text-sm">{{ a.name }}</p>
                                <p class="text-xs text-gray-400">{{ a.time_slot }} · {{ a.phone }}</p>
                            </div>
                            <select :value="a.status" @change="updateStatus(a, $event.target.value)"
                                :class="statusBadge(a.status)" class="px-2 py-1 rounded-full text-xs font-medium border-0 cursor-pointer">
                                <option value="pending" disabled>Pending</option>
                                <option value="confirmed" disabled>Confirmed</option>
                                <option value="checked_in">Checked In</option>
                                <option value="in_consultation">In Consultation</option>
                                <option value="completed">Completed</option>
                                <option value="follow_up_required">Follow-up Required</option>
                                <option value="no_show">No Show</option>
                            </select>
                        </div>
                    </div>
                </section>

                <section class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-sm font-semibold text-gray-700">Upcoming Appointments</h2>
                    </div>
                    <div v-if="!upcoming.length" class="px-6 py-8 text-center text-gray-400 text-sm">Nothing upcoming.</div>
                    <div v-else class="divide-y divide-gray-50">
                        <div v-for="a in upcoming" :key="a.id" class="px-6 py-3 flex items-center gap-4 text-sm">
                            <span class="text-gray-500 w-24">{{ formatDate(a.appointment_date) }}</span>
                            <span class="text-gray-400 w-20">{{ a.time_slot }}</span>
                            <span class="flex-1 text-gray-800">{{ a.name }}</span>
                        </div>
                    </div>
                </section>
            </template>
        </div>
    </AdminLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

defineProps({
    unlinked:   { type: Boolean, default: false },
    doctorName: { type: String,  default: '' },
    today:      { type: Array, default: () => [] },
    upcoming:   { type: Array, default: () => [] },
    completed:  { type: Array, default: () => [] },
    pending:    { type: Array, default: () => [] },
    followUp:   { type: Array, default: () => [] },
    stats:      { type: Object, default: () => ({}) },
});

function formatDate(d) {
    if (!d) return '—';
    return new Date(d).toLocaleDateString('en-GB', { day: '2-digit', month: 'short' });
}

function statusBadge(s) {
    return {
        pending: 'bg-yellow-100 text-yellow-700', confirmed: 'bg-green-100 text-green-700',
        checked_in: 'bg-cyan-100 text-cyan-700', in_consultation: 'bg-indigo-100 text-indigo-700',
        completed: 'bg-blue-100 text-blue-700', follow_up_required: 'bg-orange-100 text-orange-700',
        cancelled: 'bg-red-100 text-red-700', no_show: 'bg-gray-200 text-gray-700',
    }[s] ?? 'bg-gray-100 text-gray-600';
}

function updateStatus(item, status) {
    router.patch(route('admin.doctor-dashboard.update-status', item.id), { status }, { preserveScroll: true });
}
</script>
