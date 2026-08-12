<template>
    <AdminLayout>
        <div class="max-w-5xl mx-auto space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Create Medical Test Booking</h1>
                    <p class="text-xs text-gray-500 mt-1">Book diagnostic and pathology tests for walk-in or referred patients</p>
                </div>
                <Link :href="route('admin.medical-test-bookings.index')" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs">
                    &larr; Back to Bookings
                </Link>
            </div>

            <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Patient & Doctor/Agent Info (2 cols) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- 1. Patient Details -->
                    <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-blue-700">1. Patient Information</h2>

                        <!-- Existing Patient Select / Autofill -->
                        <div v-if="patients.length > 0">
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Select Existing Patient (Optional)</label>
                            <select @change="onSelectPatient($event)" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                <option value="">-- Or type new patient details below --</option>
                                <option v-for="p in patients" :key="p.id" :value="p.id">{{ p.name }} ({{ p.phone }})</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Patient Full Name *</label>
                                <input v-model="form.patient_name" type="text" required placeholder="Full Name" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                                <span v-if="form.errors.patient_name" class="text-xs text-red-600">{{ form.errors.patient_name }}</span>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Mobile Phone (For SMS Alert) *</label>
                                <input v-model="form.phone" type="text" required placeholder="01XXXXXXXXX" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                                <span v-if="form.errors.phone" class="text-xs text-red-600">{{ form.errors.phone }}</span>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Gender *</label>
                                <select v-model="form.gender" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Date of Birth</label>
                                <FlatpickrInput v-model="form.date_of_birth" :options="{ maxDate: 'today', dateFormat: 'Y-m-d' }" placeholder="Select Date" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Address / Notes</label>
                                <input v-model="form.address" type="text" placeholder="Patient location or address..." class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            </div>
                        </div>
                    </div>

                    <!-- 2. Referring Doctor & Agent -->
                    <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-purple-700">2. Referral & Schedule</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Referred By Doctor (Optional)</label>
                                <select v-model="form.doctor_id" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                    <option :value="null">-- None / Self Referral --</option>
                                    <option v-for="d in doctors" :key="d.id" :value="d.id">Dr. {{ d.name }}</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Booked Via Agent (Commission Earned)</label>
                                <select v-model="form.agent_id" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                    <option :value="null">-- Direct / Hospital Desk --</option>
                                    <option v-for="a in agents" :key="a.id" :value="a.id">{{ a.user?.name }} (Code: {{ a.agent_code }})</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Booking Date *</label>
                                <FlatpickrInput v-model="form.booking_date" required :options="{ dateFormat: 'Y-m-d' }" placeholder="Select Booking Date" />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Preferred Sample Collection Date</label>
                                <FlatpickrInput v-model="form.preferred_date" :options="{ dateFormat: 'Y-m-d' }" placeholder="Select Preferred Date" />
                            </div>
                        </div>
                    </div>

                    <!-- 3. Tests Selection List -->
                    <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-blue-700">3. Select Tests ({{ form.test_ids.length }} selected)</h2>
                            <input v-model="testSearch" type="text" placeholder="Filter tests catalog..." class="px-3 py-1 text-xs border rounded-lg focus:outline-none w-48" />
                        </div>

                        <div class="max-h-72 overflow-y-auto divide-y divide-gray-100 border rounded-xl p-2 bg-gray-50/50">
                            <div v-for="t in filteredTests" :key="t.id" class="p-3 hover:bg-white rounded-lg transition-colors flex items-center justify-between">
                                <label :for="'test-' + t.id" class="flex items-center gap-3 cursor-pointer flex-1">
                                    <input :id="'test-' + t.id" type="checkbox" :value="t.id" v-model="form.test_ids" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500" />
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ localized(t.name) }}</div>
                                        <div class="text-xs text-gray-400 font-mono">Code: {{ t.code }} &bull; Sample: {{ t.sample_type || 'N/A' }}</div>
                                    </div>
                                </label>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-gray-900">BDT {{ Number(t.final_price).toLocaleString() }}</div>
                                    <div v-if="t.discount_amount > 0" class="text-2xs text-gray-400 line-through">BDT {{ Number(t.price).toLocaleString() }}</div>
                                </div>
                            </div>
                            <div v-if="filteredTests.length === 0" class="text-center py-6 text-xs text-gray-400">
                                No diagnostic tests match your search.
                            </div>
                        </div>
                        <span v-if="form.errors.test_ids" class="text-xs text-red-600">{{ form.errors.test_ids }}</span>
                    </div>
                </div>

                <!-- Right: Billing & Payment Summary (1 col) -->
                <div class="space-y-6">
                    <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-6 space-y-5 sticky top-4">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-emerald-700 border-b pb-3">Billing Summary</h2>

                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal ({{ form.test_ids.length }} tests):</span>
                                <span class="font-semibold text-gray-900">BDT {{ totalSubtotal.toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between text-emerald-600">
                                <span>Total Discounts Applied:</span>
                                <span class="font-semibold">- BDT {{ totalDiscounts.toLocaleString() }}</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between items-baseline">
                                <span class="text-sm font-bold text-gray-900">Net Payable Amount:</span>
                                <span class="text-xl font-black text-blue-700">BDT {{ netPayable.toLocaleString() }}</span>
                            </div>
                        </div>

                        <!-- Payment Collection -->
                        <div class="border-t pt-4 space-y-4">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700">Collect Advance / Full Payment</h3>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Paid Amount (BDT)</label>
                                <input v-model="form.paid_amount" type="number" step="0.01" min="0" :max="netPayable" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none font-bold" />
                            </div>

                            <div v-if="form.paid_amount > 0">
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Payment Method</label>
                                <select v-model="form.payment_method" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                    <option value="cash">Cash Desk</option>
                                    <option value="bkash">bKash</option>
                                    <option value="nagad">Nagad</option>
                                    <option value="rocket">Rocket</option>
                                    <option value="card">Debit / Credit Card</option>
                                </select>
                            </div>

                            <div class="p-3 rounded-lg text-xs" :class="remainingDue > 0 ? 'bg-rose-50 text-rose-800' : 'bg-emerald-50 text-emerald-800'">
                                <div class="flex justify-between font-bold">
                                    <span>Remaining Due Balance:</span>
                                    <span>BDT {{ remainingDue.toLocaleString() }}</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" :disabled="form.processing || form.test_ids.length === 0" class="w-full py-3 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                            <span v-if="form.processing">Processing...</span>
                            <span v-else>Confirm & Generate Booking</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FlatpickrInput from '@/Components/Admin/Shared/FlatpickrInput.vue';

const props = defineProps({
    tests:    { type: Array, default: () => [] },
    doctors:  { type: Array, default: () => [] },
    agents:   { type: Array, default: () => [] },
    patients: { type: Array, default: () => [] },
});

const testSearch = ref('');

const form = useForm({
    patient_id: null,
    doctor_id: null,
    agent_id: null,
    patient_name: '',
    phone: '',
    email: '',
    gender: 'male',
    date_of_birth: '',
    address: '',
    booking_date: new Date().toISOString().split('T')[0],
    preferred_date: '',
    test_ids: [],
    paid_amount: 0,
    payment_method: 'cash',
    notes: '',
});

function localized(field) {
    if (!field) return '';
    if (typeof field === 'string') return field;
    return field['en'] || Object.values(field)[0] || '';
}

const filteredTests = computed(() => {
    if (!testSearch.value) return props.tests;
    const q = testSearch.value.toLowerCase();
    return props.tests.filter(t => {
        const name = localized(t.name).toLowerCase();
        const code = (t.code || '').toLowerCase();
        return name.includes(q) || code.includes(q);
    });
});

const selectedTestObjects = computed(() => {
    return props.tests.filter(t => form.test_ids.includes(t.id));
});

const totalSubtotal = computed(() => {
    return selectedTestObjects.value.reduce((acc, t) => acc + (parseFloat(t.price) || 0), 0);
});

const totalDiscounts = computed(() => {
    return selectedTestObjects.value.reduce((acc, t) => {
        const base = parseFloat(t.price) || 0;
        const finalP = parseFloat(t.final_price) || 0;
        return acc + Math.max(0, base - finalP);
    }, 0);
});

const netPayable = computed(() => {
    return Math.max(0, totalSubtotal.value - totalDiscounts.value);
});

const remainingDue = computed(() => {
    const paid = parseFloat(form.paid_amount) || 0;
    return Math.max(0, netPayable.value - paid);
});

function onSelectPatient(e) {
    const id = e.target.value;
    if (!id) return;
    const p = props.patients.find(x => x.id == id);
    if (p) {
        form.patient_id = p.id;
        form.patient_name = p.name;
        form.phone = p.phone;
        form.email = p.email || '';
        form.gender = p.gender || 'male';
        form.date_of_birth = p.date_of_birth || '';
        form.address = p.address || '';
    }
}

function submit() {
    form.post(route('admin.medical-test-bookings.store'));
}
</script>
