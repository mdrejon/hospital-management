<template>
    <AdminLayout>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Patients</h1>
                    <p class="text-xs text-gray-400 mt-0.5">{{ patients.length }} patient{{ patients.length === 1 ? '' : 's' }} on record</p>
                </div>
                <input v-model="search" type="text" placeholder="Search name, phone or email…"
                    class="input w-72" />
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="w-full text-sm min-w-[800px]">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Patient</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Gender</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Age</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Appointments</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Last Visit</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-if="!filtered.length">
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400 text-sm">No patients found.</td>
                        </tr>
                        <tr v-for="p in filtered" :key="p.id" class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-800">{{ p.name }}</p>
                                <p class="text-xs text-gray-400">{{ p.phone }}<span v-if="p.email"> · {{ p.email }}</span></p>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs capitalize">{{ p.gender || '—' }}</td>
                            <td class="px-4 py-3 text-gray-600 text-xs">{{ p.age ?? '—' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold"
                                    :class="p.appointments_count > 1 ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600'">
                                    {{ p.appointments_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">{{ p.last_visit || '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <Link :href="route('admin.patients.show', p.id)" class="text-xs text-blue-600 hover:underline">View history</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

const props = defineProps({
    patients: { type: Array, default: () => [] },
});

const search = ref('');

const filtered = computed(() => {
    if (!search.value.trim()) return props.patients;
    const q = search.value.toLowerCase();
    return props.patients.filter(p =>
        p.name?.toLowerCase().includes(q) ||
        p.phone?.toLowerCase().includes(q) ||
        p.email?.toLowerCase().includes(q)
    );
});
</script>
