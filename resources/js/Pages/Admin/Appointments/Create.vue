<template>
    <AdminLayout>
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Add Manual Appointment</h1>
                    <p class="text-xs text-gray-500 mt-1">Use this to record an appointment taken over the phone or in person.</p>
                </div>
                <a :href="route('admin.appointments.index')" class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    &larr; Back to List
                </a>
            </div>

            <form @submit.prevent="submit" class="bg-white rounded-2xl shadow-sm p-6 lg:p-8 space-y-6">
                
                <!-- Doctor & Schedule -->
                <div class="bg-emerald-50/30 p-5 rounded-xl border border-emerald-100 space-y-4">
                    <h3 class="text-sm font-bold text-gray-800 border-b border-emerald-100/50 pb-2">Doctor & Schedule</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-2xs font-semibold text-gray-600 mb-1">Specialization</label>
                            <select v-model="form.specialization_id" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white outline-none">
                                <option value="">— All Specializations —</option>
                                <option v-for="s in specializations" :key="s.id" :value="s.id">{{ s.name }}</option>
                            </select>
                            <InputError :message="form.errors.specialization_id" />
                        </div>
                        <div>
                            <label class="block text-2xs font-semibold text-gray-600 mb-1">Preferred Doctor</label>
                            <select v-model="form.preferred_doctor" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white outline-none">
                                <option value="">— Select —</option>
                                <option v-for="d in filteredDoctors" :key="d.id" :value="d.name">{{ d.name }}</option>
                            </select>
                            <InputError :message="form.errors.preferred_doctor" />
                        </div>
                        <div>
                            <label class="block text-2xs font-semibold text-gray-600 mb-1">Preferred Date & Time</label>
                            <FlatpickrInput v-model="form.preferred_date" placeholder="e.g. 20 Jul 2026, 11:00 AM" inputClass="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white outline-none" />
                            <InputError :message="form.errors.preferred_date" />
                        </div>
                        <div>
                            <label class="block text-2xs font-semibold text-gray-600 mb-1">Status</label>
                            <select v-model="form.status" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white outline-none">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <InputError :message="form.errors.status" />
                        </div>
                    </div>
                </div>

                <!-- Patient Information -->
                <div class="bg-blue-50/30 p-5 rounded-xl border border-blue-100 space-y-4">
                    <h3 class="text-sm font-bold text-gray-800 border-b border-blue-100/50 pb-2">Patient Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-2xs font-semibold text-gray-600 mb-1">Patient Name <span class="text-red-500">*</span></label>
                            <input v-model="form.name" type="text" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="e.g. John Carter" />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div>
                            <label class="block text-2xs font-semibold text-gray-600 mb-1">Phone</label>
                            <input v-model="form.phone" type="text" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="e.g. 017XXXXXXXX" />
                            <InputError :message="form.errors.phone" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-2xs font-semibold text-gray-600 mb-1">Email <span class="text-red-500">*</span></label>
                            <input v-model="form.email" type="email" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="e.g. john@example.com" />
                            <InputError :message="form.errors.email" />
                        </div>
                    </div>
                </div>

                <!-- Additional Details -->
                <div class="space-y-4 pt-2">
                    <div>
                        <label class="block text-2xs font-semibold text-gray-700 mb-1">Message</label>
                        <textarea v-model="form.message" rows="3" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-gray-400 focus:border-gray-400 outline-none resize-none"></textarea>
                        <InputError :message="form.errors.message" />
                    </div>
                    <div>
                        <label class="block text-2xs font-semibold text-gray-700 mb-1">Internal Notes <span class="text-gray-400 font-normal">(staff only)</span></label>
                        <textarea v-model="form.notes" rows="2" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-gray-400 focus:border-gray-400 outline-none resize-none bg-gray-50"></textarea>
                        <InputError :message="form.errors.notes" />
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-8 py-3 rounded-lg font-bold text-sm bg-blue-600 text-white hover:bg-blue-700 transition-colors disabled:opacity-50">
                        {{ form.processing ? 'Saving...' : 'Create Appointment' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import FlatpickrInput from '@/Components/Admin/Shared/FlatpickrInput.vue';

import { computed } from 'vue';

const props = defineProps({
    specializations: { type: Array, default: () => [] },
    doctors:         { type: Array, default: () => [] },
});

const form = useForm({
    name:             '',
    email:            '',
    phone:            '',
    specialization_id:'',
    preferred_doctor: '',
    preferred_date:   '',
    message:          '',
    status:           'pending',
    notes:            '',
});

const filteredDoctors = computed(() => {
    if (!form.specialization_id) return props.doctors;
    return props.doctors.filter(d => d.specialization_id === form.specialization_id);
});

function submit() {
    form.post(route('admin.appointments.store'));
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
