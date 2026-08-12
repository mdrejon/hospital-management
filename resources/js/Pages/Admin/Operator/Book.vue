<template>
    <AdminLayout>
        <div class="max-w-3xl space-y-4">
            <div class="flex items-center gap-3">
                <a :href="route('admin.operator.dashboard')" class="text-gray-400 hover:text-gray-600 text-sm">← Back</a>
                <h1 class="text-lg font-semibold text-gray-800">Book Appointment (Operator)</h1>
            </div>

            <div v-if="Object.keys(form.errors).length" class="px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded">
                Please fix the errors below.
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- Patient search / register -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Patient</h2>
                    <div>
                        <label class="label">Search existing patient (by phone or name)</label>
                        <input v-model="patientQuery" @input="searchPatients" type="text" class="input" placeholder="Search…" />
                        <div v-if="patientResults.length" class="mt-2 border rounded divide-y max-h-48 overflow-y-auto">
                            <button type="button" v-for="p in patientResults" :key="p.id" @click="selectPatient(p)"
                                class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50">
                                <span class="font-medium">{{ p.name }}</span>
                                <span class="text-gray-400 text-xs"> — {{ p.phone }}</span>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Patient Name <span class="text-red-500">*</span></label>
                            <input v-model="form.patient_name" type="text" class="input" />
                            <InputError :message="form.errors.patient_name" />
                        </div>
                        <div>
                            <label class="label">Mobile Number <span class="text-red-500">*</span></label>
                            <input v-model="form.phone" type="text" class="input" />
                            <InputError :message="form.errors.phone" />
                        </div>
                        <div>
                            <label class="label">Date of Birth</label>
                            <FlatpickrInput v-model="form.date_of_birth" :options="{ maxDate: 'today', dateFormat: 'Y-m-d' }" placeholder="Select Date of Birth" />
                        </div>
                        <div>
                            <label class="label">Gender <span class="text-red-500">*</span></label>
                            <select v-model="form.gender" class="input">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="label">Email</label>
                            <input v-model="form.email" type="email" class="input" />
                        </div>
                        <div class="col-span-2">
                            <label class="label">Address</label>
                            <input v-model="form.address" type="text" class="input" />
                        </div>
                    </div>
                </section>

                <!-- Appointment details -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Appointment</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Appointment Type <span class="text-red-500">*</span></label>
                            <select v-model="form.appointment_type" class="input">
                                <option value="opd">Outpatient Consultation (OPD)</option>
                                <option value="follow_up">Follow-up Consultation</option>
                            </select>
                        </div>
                        <div>
                            <label class="label">Department / Speciality</label>
                            <select v-model="form.department_id" @change="onDepartmentChange" class="input">
                                <option value="">All Departments</option>
                                <option v-for="d in departments" :key="d.id" :value="d.id">{{ d.title }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="label">Doctor <span class="text-red-500">*</span></label>
                            <select v-model="form.doctor_id" @change="onDoctorChange" class="input">
                                <option value="">Choose a Doctor</option>
                                <option v-for="d in filteredDoctors" :key="d.id" :value="d.id">
                                    {{ d.name }}{{ d.role ? ' — ' + d.role : '' }}{{ d.consultation_fee ? ' (' + d.consultation_fee + ')' : '' }}
                                </option>
                            </select>
                            <InputError :message="form.errors.doctor_id" />
                        </div>
                        <div>
                            <label class="label">Appointment Date <span class="text-red-500">*</span></label>
                            <FlatpickrInput v-model="form.appointment_date" @update:modelValue="loadSlots" :options="{ minDate: 'today', dateFormat: 'Y-m-d' }" :disabled="!form.doctor_id" placeholder="Select Appointment Date" />
                            <InputError :message="form.errors.appointment_date" />
                        </div>
                        <div class="col-span-2">
                            <label class="label">Available Time Slot <span class="text-red-500">*</span></label>
                            <div class="flex flex-wrap gap-2 mt-1">
                                <span v-if="slotsLoading" class="text-xs text-gray-400">Loading slots…</span>
                                <span v-else-if="form.appointment_date && !slots.length" class="text-xs text-red-500">No slots available — choose another date.</span>
                                <button v-for="s in slots" :key="s" type="button" @click="form.time_slot = s"
                                    :class="form.time_slot === s ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:border-blue-400'"
                                    class="px-3 py-1.5 rounded-full text-xs font-medium border">
                                    {{ s }}
                                </button>
                            </div>
                            <InputError :message="form.errors.time_slot" />
                        </div>
                        <div class="col-span-2">
                            <label class="label">Reason for Visit / Symptoms</label>
                            <textarea v-model="form.symptoms" rows="3" class="input resize-none"></textarea>
                        </div>
                    </div>
                </section>

                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing || !form.time_slot"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Confirming…' : 'Generate Serial & Confirm' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import FlatpickrInput from '@/Components/Admin/Shared/FlatpickrInput.vue';

const props = defineProps({
    departments: { type: Array, default: () => [] },
    doctors:     { type: Array, default: () => [] },
});

const today = new Date().toISOString().slice(0, 10);

const form = useForm({
    patient_id: null,
    patient_name: '',
    phone: '',
    email: '',
    date_of_birth: '',
    gender: 'male',
    address: '',
    appointment_type: 'opd',
    department_id: '',
    department: '',
    doctor_id: '',
    appointment_date: '',
    time_slot: '',
    symptoms: '',
});

// ── Patient search ──
const patientQuery = ref('');
const patientResults = ref([]);
let searchTimer = null;
function searchPatients() {
    clearTimeout(searchTimer);
    if (!patientQuery.value.trim()) { patientResults.value = []; return; }
    searchTimer = setTimeout(() => {
        fetch(route('admin.operator.patients.search') + '?q=' + encodeURIComponent(patientQuery.value))
            .then(r => r.json())
            .then(data => { patientResults.value = data.patients || []; });
    }, 300);
}
function selectPatient(p) {
    form.patient_id = p.id;
    form.patient_name = p.name;
    form.phone = p.phone;
    form.email = p.email || '';
    form.date_of_birth = (p.date_of_birth || '').slice(0, 10);
    form.gender = p.gender || 'male';
    form.address = p.address || '';
    patientResults.value = [];
    patientQuery.value = '';
}

// ── Doctor filtering ──
const filteredDoctors = ref(props.doctors);
function onDepartmentChange() {
    form.doctor_id = '';
    resetSlots();
    fetch(route('admin.operator.doctors') + (form.department_id ? '?department_id=' + form.department_id : ''))
        .then(r => r.json())
        .then(data => { filteredDoctors.value = data.doctors || []; });
}

// ── Slots ──
const slots = ref([]);
const slotsLoading = ref(false);
function resetSlots() {
    slots.value = [];
    form.time_slot = '';
    form.appointment_date = '';
}
function onDoctorChange() {
    resetSlots();
}
function loadSlots() {
    form.time_slot = '';
    slots.value = [];
    if (!form.doctor_id || !form.appointment_date) return;
    slotsLoading.value = true;
    fetch(route('admin.operator.slots') + '?doctor_id=' + form.doctor_id + '&date=' + form.appointment_date)
        .then(r => r.json())
        .then(data => { slots.value = data.slots || []; })
        .finally(() => { slotsLoading.value = false; });
}

function submit() {
    const dept = props.departments.find(d => d.id === form.department_id);
    form.department = dept ? dept.title : '';
    form.post(route('admin.operator.book.store'));
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
