<template>
    <AgentLayout>
        <div class="max-w-6xl mx-auto space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Book Doctor Appointment</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Book an appointment for a patient & earn your commission upon consultation</p>
                </div>
                <Link :href="route('agent.bookings.index')" class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                    &larr; Bookings History
                </Link>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                <!-- Left Column: Doctor Profile Card -->
                <div class="lg:col-span-1 sticky top-6">
                    <div v-if="selectedDoctor" class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                        <!-- Green Header section -->
                        <div class="bg-[#0b8b6a] px-6 py-8 text-center text-white space-y-4">
                            <div class="mx-auto w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mb-2 overflow-hidden border-2 border-white/30 p-1">
                                <img v-if="selectedDoctor.image_url" :src="selectedDoctor.image_url" class="w-full h-full object-cover rounded-full bg-white" />
                                <svg v-else class="w-12 h-12 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h2 class="text-lg font-black uppercase tracking-wide">{{ localized(selectedDoctor.name) }}</h2>
                            <p class="text-xs text-white/90 leading-relaxed font-medium px-2">
                                {{ localized(selectedDoctor.qualification) }}
                            </p>
                            <div class="inline-block px-4 py-1.5 bg-white/20 rounded-full text-xs font-bold tracking-widest mt-2">
                                {{ localized(selectedDoctor.specialization?.name) || selectedDoctor.department || 'SPECIALIST' }}
                            </div>
                        </div>
                        
                        <!-- Details list -->
                        <div class="p-5 space-y-4">
                            <div class="flex gap-3 items-start bg-gray-50/50 p-3 rounded-xl border border-gray-100">
                                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <div>
                                    <div class="text-3xs text-gray-400 uppercase tracking-wider font-semibold mb-0.5">Department</div>
                                    <div class="text-xs font-bold text-gray-800">{{ localized(selectedDoctor.specialization?.name) || selectedDoctor.department || 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="flex gap-3 items-start bg-gray-50/50 p-3 rounded-xl border border-gray-100">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-3xs text-gray-400 uppercase tracking-wider font-semibold mb-0.5">Location</div>
                                    <div class="text-xs font-bold text-gray-800">{{ selectedDoctor.chambers?.[0]?.name || 'Main Hospital' }}</div>
                                </div>
                            </div>
                            
                            <div class="flex gap-3 items-start bg-gray-50/50 p-3 rounded-xl border border-gray-100">
                                <div class="w-8 h-8 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-3xs text-gray-400 uppercase tracking-wider font-semibold mb-0.5">Email</div>
                                    <div class="text-xs font-bold text-gray-800">{{ selectedDoctor.email || 'N/A' }}</div>
                                </div>
                            </div>
                            
                            <div class="mt-4 bg-emerald-50 rounded-xl p-4 border border-emerald-100 text-center">
                                <div class="text-xs text-emerald-700 font-semibold mb-1">Consultation Fee</div>
                                <div class="text-xl font-black text-emerald-800">BDT {{ Number(selectedDoctor.consultation_fee || 0).toLocaleString() }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div v-else class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col items-center justify-center text-center text-gray-400 h-[500px]">
                        <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <p class="font-medium text-sm">Please select a doctor from the form to view their details.</p>
                    </div>
                </div>

                <!-- Right Column: Form -->
                <div class="lg:col-span-2">
                    <form @submit.prevent="submit" class="bg-white rounded-2xl shadow-sm p-6 lg:p-8 space-y-6">
                        <!-- Top Header "Step 1 of 2" -->
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <h2 class="text-xl font-bold text-gray-900">Book Appointment</h2>
                            <div class="px-3 py-1 bg-[#0b8b6a] text-white text-xs font-bold rounded-full">Step 1 of 2</div>
                        </div>
                        
                        <div class="flex gap-6 border-b border-gray-100 pb-3 text-xs font-semibold">
                            <div class="text-[#0b8b6a] border-b-2 border-[#0b8b6a] pb-3 -mb-3">Patient Info & Schedule</div>
                            <div class="text-gray-300">Verify Phone</div>
                        </div>

                        <!-- Select Doctor block -->
                        <div class="bg-emerald-50/30 p-5 rounded-xl border border-emerald-100 space-y-4">
                            <h3 class="text-sm font-bold text-gray-800">Select Doctor</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div v-if="false">
                                    <label class="block text-2xs font-semibold text-gray-600 mb-1">Branch</label>
                                    <select disabled class="w-full px-3 py-2 text-xs border border-gray-200 rounded-lg bg-gray-50 focus:outline-none">
                                        <option>Main Branch</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-600 mb-1">Specialization</label>
                                    <select v-model="selectedSpec" @change="form.doctor_id = ''; selectedDoctor = null" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#0b8b6a] focus:border-[#0b8b6a] bg-white outline-none">
                                        <option value="">All Specializations</option>
                                        <option v-for="spec in specializations" :key="spec.id" :value="spec.id">{{ localized(spec.name) }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-600 mb-1">Doctor *</label>
                                    <select v-model="form.doctor_id" @change="onDoctorSelect" required class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#0b8b6a] focus:border-[#0b8b6a] bg-white outline-none font-semibold">
                                        <option value="" disabled>Select doctor</option>
                                        <option v-for="doc in filteredDoctors" :key="doc.id" :value="doc.id">{{ localized(doc.name) }}</option>
                                    </select>
                                    <div v-if="form.errors.doctor_id" class="text-red-600 text-3xs mt-1">{{ form.errors.doctor_id }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Date & Time -->
                        <div class="bg-blue-50/30 p-5 rounded-xl border border-blue-100 space-y-4">
                            <h3 class="text-sm font-bold text-gray-800">Select Appointment Date & Time</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-600 mb-1">Select Date *</label>
                                    <FlatpickrInput v-model="form.appointment_date" :options="{ minDate: 'today', dateFormat: 'Y-m-d', enableTime: false }" required placeholder="Pick a date" inputClass="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#0b8b6a] focus:border-[#0b8b6a] bg-white outline-none pr-8" />
                                    <div v-if="form.errors.appointment_date" class="text-red-600 text-3xs mt-1">{{ form.errors.appointment_date }}</div>
                                </div>
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-600 mb-1">Select Time Slot *</label>
                                    <select v-model="form.time_slot" required class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#0b8b6a] focus:border-[#0b8b6a] bg-white outline-none">
                                        <option value="" disabled>Pick a time slot</option>
                                        <option value="10:00 AM - 01:00 PM">10:00 AM - 01:00 PM</option>
                                        <option value="02:00 PM - 05:00 PM">02:00 PM - 05:00 PM</option>
                                        <option value="05:00 PM - 09:00 PM">05:00 PM - 09:00 PM</option>
                                    </select>
                                    <div v-if="form.errors.time_slot" class="text-red-600 text-3xs mt-1">{{ form.errors.time_slot }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Patient Info Fields -->
                        <div class="space-y-4 pt-2">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-700 mb-1">Full Name *</label>
                                    <input v-model="form.name" type="text" required placeholder="Patient name" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#0b8b6a] outline-none" />
                                    <div v-if="form.errors.name" class="text-red-600 text-3xs mt-1">{{ form.errors.name }}</div>
                                </div>
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-700 mb-1">Phone Number *</label>
                                    <input v-model="form.phone" type="text" required placeholder="017XXXXXXXX" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#0b8b6a] outline-none" />
                                    <div v-if="form.errors.phone" class="text-red-600 text-3xs mt-1">{{ form.errors.phone }}</div>
                                </div>
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-700 mb-1">Email Address (Optional)</label>
                                    <input v-model="form.email" type="email" placeholder="patient@example.com" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#0b8b6a] outline-none" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-700 mb-1">Gender *</label>
                                    <select v-model="form.gender" required class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#0b8b6a] outline-none bg-white">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div v-if="form.errors.gender" class="text-red-600 text-3xs mt-1">{{ form.errors.gender }}</div>
                                </div>
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-700 mb-1">Marital Status *</label>
                                    <select v-model="form.marital_status" required class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#0b8b6a] outline-none bg-white">
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                    <div v-if="form.errors.marital_status" class="text-red-600 text-3xs mt-1">{{ form.errors.marital_status }}</div>
                                </div>
                            </div>

                            <!-- Age / DOB Component -->
                            <AgeDateSync v-model="form.date_of_birth" />
                            <div v-if="form.errors.date_of_birth" class="text-red-600 text-3xs mt-1">{{ form.errors.date_of_birth }}</div>

                            <div>
                                <label class="block text-2xs font-semibold text-gray-700 mb-1">Address *</label>
                                <textarea v-model="form.address" rows="2" required placeholder="Patient address" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#0b8b6a] outline-none"></textarea>
                                <div v-if="form.errors.address" class="text-red-600 text-3xs mt-1">{{ form.errors.address }}</div>
                            </div>
                        </div>

                        <!-- Commission Preview (Agent Specific) -->
                        <div class="bg-gray-800 text-white rounded-xl p-4 shadow-sm flex items-center justify-between mt-4">
                            <div>
                                <div class="text-2xs uppercase tracking-wider text-gray-400 font-semibold">Estimated Agent Commission</div>
                                <div class="text-lg font-bold text-amber-400">
                                    BDT {{ selectedDoctor ? estimatedCommission(selectedDoctor.consultation_fee) : '0' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xs text-gray-400">Rate: {{ agent?.doctor_commission_rate || 10 }}%</div>
                            </div>
                        </div>

                        <button type="submit" :disabled="form.processing || !form.doctor_id" class="w-full py-3.5 rounded-lg font-bold text-sm bg-[#0b8b6a] text-white hover:bg-emerald-700 transition-colors disabled:opacity-50 flex items-center justify-center gap-2 mt-4">
                            <span v-if="form.processing">Processing...</span>
                            <span v-else>Continue to Confirm Booking &rarr;</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AgentLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import AgentLayout from '@/Layouts/AgentLayout.vue';
import FlatpickrInput from '@/Components/Admin/Shared/FlatpickrInput.vue';
import AgeDateSync from '@/Components/Agent/AgeDateSync.vue';

const props = defineProps({
    doctors:         { type: [Array, Object], default: () => [] },
    specializations: { type: [Array, Object], default: () => [] },
    agent:           { type: Object, default: () => ({}) },
    paymentSettings: { type: Object, default: () => ({}) },
});

const today = new Date().toISOString().split('T')[0];
const selectedSpec = ref('');
const selectedDoctor = ref(null);

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

const doctorList = computed(() => {
    return Array.isArray(props.doctors) ? props.doctors : (props.doctors?.data || []);
});

const filteredDoctors = computed(() => {
    if (!selectedSpec.value) return doctorList.value;
    return doctorList.value.filter(d => d.doctor_specialization_id === selectedSpec.value || d.specialization_id === selectedSpec.value);
});

// Update the selected doctor object when the ID changes
function onDoctorSelect() {
    selectedDoctor.value = doctorList.value.find(d => d.id === form.doctor_id) || null;
}

const form = useForm({
    doctor_id: '',
    name: '',
    phone: '',
    email: '',
    gender: 'male',
    marital_status: 'Married',
    date_of_birth: '',
    address: '',
    appointment_date: '',
    time_slot: '',
    symptoms: '',
    message: '',
    payment_type: 'without_pay', // Force without_pay for agent
    payment_gateway: '',
});

function estimatedCommission(fee) {
    const rate = Number(props.agent?.doctor_commission_rate || 10);
    return Math.round((Number(fee || 0) * rate) / 100);
}

function submit() {
    form.post(route('agent.doctor.store'));
}
</script>
