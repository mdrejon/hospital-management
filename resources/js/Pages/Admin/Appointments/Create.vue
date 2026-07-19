<template>
    <AdminLayout>
        <div class="max-w-2xl space-y-4">
            <div class="flex items-center gap-3">
                <a :href="route('admin.appointments.index')" class="text-gray-400 hover:text-gray-600 text-sm">← Back</a>
                <h1 class="text-lg font-semibold text-gray-800">Add Manual Appointment</h1>
            </div>
            <p class="text-xs text-gray-400 -mt-2">Use this to record an appointment taken over the phone or in person.</p>

            <form @submit.prevent="submit" class="space-y-6">
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Patient Name <span class="text-red-500">*</span></label>
                            <input v-model="form.name" type="text" class="input" placeholder="e.g. John Carter" />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div>
                            <label class="label">Email <span class="text-red-500">*</span></label>
                            <input v-model="form.email" type="email" class="input" placeholder="e.g. john@example.com" />
                            <InputError :message="form.errors.email" />
                        </div>
                        <div>
                            <label class="label">Phone</label>
                            <input v-model="form.phone" type="text" class="input" placeholder="e.g. 1 123 456 7890" />
                            <InputError :message="form.errors.phone" />
                        </div>
                        <div>
                            <label class="label">Preferred Date &amp; Time</label>
                            <input v-model="form.preferred_date" type="text" class="input" placeholder="e.g. 20 Jul 2026, 11:00 AM" />
                            <InputError :message="form.errors.preferred_date" />
                        </div>
                        <div>
                            <label class="label">Department</label>
                            <select v-model="form.department" class="input">
                                <option value="">— Select —</option>
                                <option v-for="d in departments" :key="d" :value="d">{{ d }}</option>
                            </select>
                            <InputError :message="form.errors.department" />
                        </div>
                        <div>
                            <label class="label">Preferred Doctor</label>
                            <select v-model="form.preferred_doctor" class="input">
                                <option value="">— Select —</option>
                                <option v-for="d in doctors" :key="d" :value="d">{{ d }}</option>
                            </select>
                            <InputError :message="form.errors.preferred_doctor" />
                        </div>
                        <div>
                            <label class="label">Status</label>
                            <select v-model="form.status" class="input">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <InputError :message="form.errors.status" />
                        </div>
                        <div class="col-span-2">
                            <label class="label">Message</label>
                            <textarea v-model="form.message" rows="3" class="input resize-none"></textarea>
                            <InputError :message="form.errors.message" />
                        </div>
                        <div class="col-span-2">
                            <label class="label">Internal Notes <span class="text-xs text-gray-400">(staff only)</span></label>
                            <textarea v-model="form.notes" rows="2" class="input resize-none"></textarea>
                            <InputError :message="form.errors.notes" />
                        </div>
                    </div>
                </section>

                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
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

defineProps({
    departments: { type: Array, default: () => [] },
    doctors:     { type: Array, default: () => [] },
});

const form = useForm({
    name:             '',
    email:            '',
    phone:            '',
    department:       '',
    preferred_doctor: '',
    preferred_date:   '',
    message:          '',
    status:           'pending',
    notes:            '',
});

function submit() {
    form.post(route('admin.appointments.store'));
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
