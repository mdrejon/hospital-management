<template>
    <AdminLayout>
        <div class="space-y-4">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Dashboard</h1>
                <p class="text-xs text-gray-400 mt-0.5">Overview of appointments, patients and inquiries.</p>
            </div>

            <!-- Stat cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <StatCard label="Today's Appointments" :value="stats.todayAppointments" color="blue" :href="route('admin.appointments.index')" />
                <StatCard label="Pending Appointments" :value="stats.pendingAppointments" color="yellow" :href="route('admin.appointments.index')" />
                <StatCard label="New Inquiries" :value="stats.newInquiries" color="cyan" :href="route('admin.inquiries.index')" />
                <StatCard label="Total Appointments" :value="stats.totalAppointments" color="indigo" :href="route('admin.appointments.index')" />
                <StatCard label="Active Doctors" :value="stats.totalDoctors" color="green" :href="route('admin.doctors.index')" />
                <StatCard label="Total Patients" :value="stats.totalPatients" color="pink" />
                <StatCard label="Staff Users" :value="stats.totalUsers" color="purple" :href="route('admin.users.index')" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Weekly appointment trend -->
                <div class="bg-white rounded-lg shadow-sm p-6 lg:col-span-2">
                    <h2 class="text-sm font-semibold text-gray-700 mb-4">Appointments — Last 7 Days</h2>
                    <div class="flex items-end justify-between gap-3 h-40">
                        <div v-for="day in weeklyTrend" :key="day.date" class="flex-1 flex flex-col items-center gap-2">
                            <span class="text-xs font-medium text-gray-500">{{ day.count }}</span>
                            <div class="w-full bg-blue-100 rounded-t relative flex items-end" style="height: 110px;">
                                <div class="w-full bg-blue-500 rounded-t transition-all"
                                    :style="{ height: barHeight(day.count) }"></div>
                            </div>
                            <span class="text-xs text-gray-400">{{ day.label }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status breakdown -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-sm font-semibold text-gray-700 mb-4">Appointment Status</h2>
                    <div class="space-y-3">
                        <div v-for="s in statusBreakdown" :key="s.status">
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-gray-600">{{ statusLabel(s.status) }}</span>
                                <span class="font-medium text-gray-700">{{ s.count }}</span>
                            </div>
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full" :class="statusBarColor(s.status)"
                                    :style="{ width: statusBarWidth(s.count) }"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Recent appointments -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden lg:col-span-2">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-gray-700">Recent Appointments</h2>
                        <Link :href="route('admin.appointments.index')" class="text-xs text-blue-600 hover:underline">View all</Link>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-600">Patient</th>
                                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-600">Doctor</th>
                                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-600">Date</th>
                                <th class="px-4 py-2.5 text-center text-xs font-semibold text-gray-600">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-if="!recentAppointments.length">
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">No appointments yet.</td>
                            </tr>
                            <tr v-for="a in recentAppointments" :key="a.id" class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-800">{{ a.name }}</p>
                                    <p class="text-xs text-gray-400">{{ a.phone }}</p>
                                </td>
                                <td class="px-4 py-3 text-gray-600 text-xs">{{ localized(a.doctor?.name) || '—' }}</td>
                                <td class="px-4 py-3 text-gray-600 text-xs">
                                    {{ a.appointment_date }} <span class="text-gray-400">{{ a.time_slot }}</span>
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

                <!-- Recent inquiries -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-gray-700">Recent Inquiries</h2>
                        <Link :href="route('admin.inquiries.index')" class="text-xs text-blue-600 hover:underline">View all</Link>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        <li v-if="!recentInquiries.length" class="px-4 py-8 text-center text-gray-400 text-sm">No inquiries yet.</li>
                        <li v-for="i in recentInquiries" :key="i.id" class="px-4 py-3">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-800 text-sm truncate">{{ i.name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ i.subject || '—' }}</p>
                                </div>
                                <span v-if="i.status === 'new'" class="shrink-0 px-2 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-700">New</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import StatCard from '@/Components/Admin/Shared/StatCard.vue';

const props = defineProps({
    stats:               { type: Object, default: () => ({}) },
    recentAppointments:  { type: Array,  default: () => [] },
    recentInquiries:     { type: Array,  default: () => [] },
    statusBreakdown:     { type: Array,  default: () => [] },
    weeklyTrend:         { type: Array,  default: () => [] },
});

const maxTrend = computed(() => Math.max(1, ...props.weeklyTrend.map(d => d.count)));
const maxStatus = computed(() => Math.max(1, ...props.statusBreakdown.map(s => s.count)));

function barHeight(count) {
    return `${Math.round((count / maxTrend.value) * 100)}%`;
}

function statusBarWidth(count) {
    return `${Math.round((count / maxStatus.value) * 100)}%`;
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

function statusBarColor(s) {
    return {
        pending: 'bg-yellow-400', confirmed: 'bg-green-500',
        checked_in: 'bg-cyan-500', in_consultation: 'bg-indigo-500',
        completed: 'bg-blue-500', follow_up_required: 'bg-orange-400',
        cancelled: 'bg-red-400', no_show: 'bg-gray-400',
    }[s] ?? 'bg-gray-400';
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
</script>
