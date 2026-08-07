<template>
    <AgentLayout>
        <div class="max-w-4xl mx-auto space-y-5">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Book Doctor Appointment</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Book an appointment for a patient & earn your commission upon consultation</p>
                </div>
                <Link :href="route('agent.bookings.index')" class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                    &larr; Bookings History
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-5">
                <!-- 1. Doctor Selection -->
                <div class="bg-white rounded-lg shadow-sm p-5 space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-blue-700 border-b border-gray-100 pb-2.5">
                        1. Select Doctor & Specialization
                    </h2>

                    <!-- Filter by department -->
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" @click="selectedDept = ''" :class="selectedDept === '' ? 'bg-blue-600 text-white font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-2.5 py-1 rounded text-xs transition-colors">
                            All Departments
                        </button>
                        <button v-for="dept in departments" :key="dept" type="button" @click="selectedDept = dept" :class="selectedDept === dept ? 'bg-blue-600 text-white font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-2.5 py-1 rounded text-xs transition-colors">
                            {{ localized(dept) }}
                        </button>
                    </div>

                    <!-- Doctors Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 max-h-80 overflow-y-auto p-1">
                        <div v-for="doc in filteredDoctors" :key="doc.id" @click="selectDoctor(doc)" :class="[
                            'p-3 rounded border cursor-pointer transition-all flex flex-col justify-between',
                            form.doctor_id === doc.id ? 'border-blue-600 bg-blue-50/50 ring-1 ring-blue-500' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'
                        ]">
                            <div class="space-y-0.5">
                                <div class="font-semibold text-xs text-gray-900">{{ localized(doc.name) }}</div>
                                <div class="text-2xs text-blue-600 font-medium">{{ localized(doc.specialization?.name) || doc.department || 'Specialist' }}</div>
                                <div class="text-2xs text-gray-400 truncate">{{ localized(doc.qualification) }}</div>
                            </div>
                            <div class="mt-2.5 pt-2 border-t border-gray-100 flex items-center justify-between text-2xs">
                                <span class="font-medium text-gray-700">Fee: BDT {{ Number(doc.consultation_fee || 0).toLocaleString() }}</span>
                                <span class="font-bold text-emerald-600">+BDT {{ estimatedCommission(doc.consultation_fee) }}</span>
                            </div>
                        </div>
                    </div>
                    <div v-if="form.errors.doctor_id" class="text-red-600 text-xs">{{ form.errors.doctor_id }}</div>
                </div>

                <!-- 2. Date & Time -->
                <div class="bg-white rounded-lg shadow-sm p-5 space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-purple-700 border-b border-gray-100 pb-2.5">
                        2. Appointment Schedule
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Appointment Date *</label>
                            <input v-model="form.appointment_date" type="date" :min="today" required class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                            <div v-if="form.errors.appointment_date" class="text-red-600 text-xs mt-1">{{ form.errors.appointment_date }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Preferred Time Slot</label>
                            <select v-model="form.time_slot" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none bg-white">
                                <option value="10:00 AM - 01:00 PM">Morning (10:00 AM - 01:00 PM)</option>
                                <option value="02:00 PM - 05:00 PM">Afternoon (02:00 PM - 05:00 PM)</option>
                                <option value="05:00 PM - 09:00 PM">Evening (05:00 PM - 09:00 PM)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 3. Patient Information -->
                <div class="bg-white rounded-lg shadow-sm p-5 space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-emerald-700 border-b border-gray-100 pb-2.5">
                        3. Patient Details
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Patient Full Name *</label>
                            <input v-model="form.name" type="text" required placeholder="Patient full name" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                            <div v-if="form.errors.name" class="text-red-600 text-xs mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Patient Mobile Phone *</label>
                            <input v-model="form.phone" type="text" required placeholder="017XXXXXXXX" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                            <div v-if="form.errors.phone" class="text-red-600 text-xs mt-1">{{ form.errors.phone }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Patient Email (Optional)</label>
                            <input v-model="form.email" type="email" placeholder="patient@example.com" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Symptoms / Chief Complaints</label>
                            <input v-model="form.symptoms" type="text" placeholder="e.g. Chest pain, Fever, General checkup" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Additional Notes</label>
                        <textarea v-model="form.message" rows="2" placeholder="Any special notes or referral remarks..." class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none"></textarea>
                    </div>
                </div>

                <!-- 4. Payment Method Selection -->
                <div class="bg-white rounded-lg shadow-sm p-5 space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-indigo-700 border-b border-gray-100 pb-2.5">
                        4. Payment Option
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Without Pay -->
                        <div v-if="paymentSettings?.allow_without_pay !== false" @click="form.payment_type = 'without_pay'" :class="[
                            'p-4 rounded-xl border cursor-pointer transition-all flex items-start gap-3',
                            form.payment_type === 'without_pay' ? 'border-blue-600 bg-blue-50/40 ring-1 ring-blue-500' : 'border-gray-200 hover:border-gray-300 bg-gray-50/50'
                        ]">
                            <input type="radio" name="payment_type" value="without_pay" :checked="form.payment_type === 'without_pay'" class="mt-1 text-blue-600 focus:ring-blue-500" />
                            <div class="space-y-1">
                                <div class="font-bold text-xs text-gray-900 flex items-center gap-1.5">
                                    <span>🏥 Pay at Hospital Counter</span>
                                    <span class="text-3xs px-1.5 py-0.2 bg-gray-200 text-gray-700 rounded font-semibold">Without Pay</span>
                                </div>
                                <p class="text-2xs text-gray-500 leading-relaxed">
                                    No payment required right now. The patient will pay the fee directly at the hospital reception.
                                </p>
                            </div>
                        </div>

                        <!-- Online Payment -->
                        <div v-if="paymentSettings?.has_online" @click="form.payment_type = 'online'" :class="[
                            'p-4 rounded-xl border cursor-pointer transition-all flex items-start gap-3',
                            form.payment_type === 'online' ? 'border-blue-600 bg-blue-50/40 ring-1 ring-blue-500' : 'border-gray-200 hover:border-gray-300 bg-gray-50/50'
                        ]">
                            <input type="radio" name="payment_type" value="online" :checked="form.payment_type === 'online'" class="mt-1 text-blue-600 focus:ring-blue-500" />
                            <div class="space-y-1">
                                <div class="font-bold text-xs text-gray-900 flex items-center gap-1.5">
                                    <span>💳 Pay Online Instantly</span>
                                    <span class="text-3xs px-1.5 py-0.2 bg-emerald-100 text-emerald-800 rounded font-semibold">Instant Confirmation</span>
                                </div>
                                <p class="text-2xs text-gray-500 leading-relaxed">
                                    Pay immediately using bKash, SSLCommerz (Cards/Nagad/Rocket/Net Banking).
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Online Gateways Sub-Options -->
                    <div v-if="form.payment_type === 'online'" class="pt-2 border-t border-gray-100 space-y-3">
                        <label class="block text-2xs font-bold uppercase tracking-wider text-gray-600">Select Online Payment Gateway:</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- bKash -->
                            <div v-if="paymentSettings?.gateways?.bkash" @click="form.payment_gateway = 'bkash'" :class="[
                                'p-3.5 rounded-lg border cursor-pointer transition-all flex items-center justify-between',
                                form.payment_gateway === 'bkash' ? 'border-pink-600 bg-pink-50/50 ring-1 ring-pink-500' : 'border-gray-200 hover:bg-gray-50'
                            ]">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded bg-pink-600 text-white font-black flex items-center justify-center text-xs shadow-xs">
                                        bK
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-gray-900">bKash Payment</div>
                                        <div class="text-3xs text-gray-400">Direct wallet payment</div>
                                    </div>
                                </div>
                                <input type="radio" name="payment_gateway" value="bkash" :checked="form.payment_gateway === 'bkash'" class="text-pink-600" />
                            </div>

                            <!-- SSLCommerz -->
                            <div v-if="paymentSettings?.gateways?.sslcommerz" @click="form.payment_gateway = 'sslcommerz'" :class="[
                                'p-3.5 rounded-lg border cursor-pointer transition-all flex items-center justify-between',
                                form.payment_gateway === 'sslcommerz' ? 'border-blue-600 bg-blue-50/50 ring-1 ring-blue-500' : 'border-gray-200 hover:bg-gray-50'
                            ]">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded bg-blue-700 text-white font-black flex items-center justify-center text-xs shadow-xs">
                                        SSL
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-gray-900">SSLCommerz</div>
                                        <div class="text-3xs text-gray-400">Cards / Nagad / Rocket / Banks</div>
                                    </div>
                                </div>
                                <input type="radio" name="payment_gateway" value="sslcommerz" :checked="form.payment_gateway === 'sslcommerz'" class="text-blue-600" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. Summary & Commission Preview -->
                <div class="bg-gray-800 text-white rounded-lg p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-0.5">
                        <div class="text-2xs uppercase tracking-wider text-gray-400 font-semibold">Estimated Agent Commission</div>
                        <div class="text-xl font-bold text-amber-400">
                            BDT {{ selectedDoctor ? estimatedCommission(selectedDoctor.consultation_fee) : '0' }}
                        </div>
                        <div class="text-2xs text-gray-400">
                            Based on your {{ agent?.doctor_commission_rate || 10 }}% commission rate
                        </div>
                    </div>

                    <button type="submit" :disabled="form.processing || !form.doctor_id" class="px-5 py-2.5 rounded font-bold text-xs bg-blue-600 text-white hover:bg-blue-700 transition-colors disabled:opacity-50 flex items-center gap-1.5">
                        <span v-if="form.processing">Processing Booking...</span>
                        <span v-else-if="form.payment_type === 'online'">Proceed to Online Payment &rarr;</span>
                        <span v-else>Confirm Booking (Pay at Hospital) &rarr;</span>
                    </button>
                </div>
            </form>
        </div>
    </AgentLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import AgentLayout from '@/Layouts/AgentLayout.vue';

const props = defineProps({
    doctors:         { type: [Array, Object], default: () => [] },
    departments:     { type: [Array, Object], default: () => [] },
    agent:           { type: Object, default: () => ({}) },
    paymentSettings: { type: Object, default: () => ({}) },
});

const today = new Date().toISOString().split('T')[0];
const selectedDept = ref('');
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
    if (!selectedDept.value) return doctorList.value;
    return doctorList.value.filter(d => (localized(d.specialization?.name) || d.department) === selectedDept.value);
});

// Default gateway selection
const defaultGateway = computed(() => {
    if (props.paymentSettings?.gateways?.bkash) return 'bkash';
    if (props.paymentSettings?.gateways?.sslcommerz) return 'sslcommerz';
    return '';
});

const form = useForm({
    doctor_id: '',
    name: '',
    phone: '',
    email: '',
    appointment_date: today,
    time_slot: '10:00 AM - 01:00 PM',
    symptoms: '',
    message: '',
    payment_type: props.paymentSettings?.allow_without_pay !== false ? 'without_pay' : 'online',
    payment_gateway: defaultGateway.value || 'bkash',
});

function selectDoctor(doc) {
    form.doctor_id = doc.id;
    selectedDoctor.value = doc;
}

function estimatedCommission(fee) {
    const rate = Number(props.agent?.doctor_commission_rate || 10);
    return Math.round((Number(fee || 0) * rate) / 100);
}

function submit() {
    form.post(route('agent.doctor.store'));
}
</script>
