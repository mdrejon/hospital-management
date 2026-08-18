<template>
    <AgentLayout>
        <div class="max-w-5xl mx-auto space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Create Medical Test Booking</h1>
                    <p class="text-xs text-gray-500 mt-1">Book diagnostic and pathology tests for walk-in or referred patients</p>
                </div>
                <Link :href="route('agent.bookings.tests')" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs">
                    &larr; Back to Bookings
                </Link>
            </div>

            <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Patient & Doctor/Agent Info (2 cols) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- 1. Patient Details -->
                    <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-blue-700">1. Patient Information</h2>

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
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Email (Optional)</label>
                                <input v-model="form.email" type="email" placeholder="patient@example.com" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                                <span v-if="form.errors.email" class="text-xs text-red-600">{{ form.errors.email }}</span>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Date of Birth</label>
                                <AgeDateSync v-model="form.date_of_birth" />
                                <span v-if="form.errors.date_of_birth" class="text-xs text-red-600">{{ form.errors.date_of_birth }}</span>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Address / Notes</label>
                                <input v-model="form.address" type="text" placeholder="Patient location or address..." class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            </div>
                        </div>
                    </div>

                    <!-- 2. Referring Doctor & Schedule -->
                    <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-purple-700">2. Referral & Schedule</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Referred By Doctor (Optional)</label>
                                <select v-model="form.doctor_id" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                    <option :value="null">-- None / Self Referral --</option>
                                    <option v-for="d in doctors" :key="d.id" :value="d.id">Dr. {{ localized(d.name) }}</option>
                                </select>
                            </div>

                            <div class="hidden md:block">
                                <!-- Empty space to match grid layout -->
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Booking Date *</label>
                                <FlatpickrInput v-model="form.booking_date" required :options="{ dateFormat: 'Y-m-d' }" placeholder="Select Booking Date" />
                                <span v-if="form.errors.booking_date" class="text-xs text-red-600">{{ form.errors.booking_date }}</span>
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
                            <div v-if="totalDiscounts > 0" class="flex justify-between text-emerald-600">
                                <span>Total Discounts Applied:</span>
                                <span class="font-semibold">- BDT {{ totalDiscounts.toLocaleString() }}</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between items-baseline">
                                <span class="text-sm font-bold text-gray-900">Net Payable Amount:</span>
                                <span class="text-xl font-black text-blue-700">BDT {{ netPayable.toLocaleString() }}</span>
                            </div>
                        </div>

                        <!-- Agent Commission Box -->
                        <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-900 space-y-1">
                            <div class="text-xs uppercase font-bold tracking-wider text-emerald-700">Your Agent Commission</div>
                            <div class="text-xl font-black text-emerald-700">BDT {{ agentCommission.toLocaleString() }}</div>
                            <div class="text-xs text-emerald-600">{{ agentRate }}% commission credited to your wallet</div>
                        </div>

                        <!-- Payment Collection -->
                        <div class="border-t pt-4 space-y-4">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700">Payment Option</h3>

                            <div class="space-y-2">
                                <!-- Without Pay -->
                                <div v-if="paymentSettings?.allow_without_pay !== false" @click="form.payment_type = 'without_pay'" :class="[
                                    'p-3 rounded-lg border cursor-pointer transition-all flex items-start gap-3 text-sm',
                                    form.payment_type === 'without_pay' ? 'border-purple-600 bg-purple-50/50 ring-1 ring-purple-500' : 'border-gray-200 hover:bg-gray-50'
                                ]">
                                    <input type="radio" name="payment_type" value="without_pay" :checked="form.payment_type === 'without_pay'" class="mt-1 text-purple-600 w-4 h-4" />
                                    <div>
                                        <div class="font-bold text-gray-900">🏥 Pay at Lab / Counter</div>
                                        <div class="text-xs text-gray-500 mt-0.5">Without Pay (Settle at hospital)</div>
                                    </div>
                                </div>

                                <!-- Online Payment -->
                                <div v-if="paymentSettings?.has_online" @click="form.payment_type = 'online'" :class="[
                                    'p-3 rounded-lg border cursor-pointer transition-all flex items-start gap-3 text-sm',
                                    form.payment_type === 'online' ? 'border-purple-600 bg-purple-50/50 ring-1 ring-purple-500' : 'border-gray-200 hover:bg-gray-50'
                                ]">
                                    <input type="radio" name="payment_type" value="online" :checked="form.payment_type === 'online'" class="mt-1 text-purple-600 w-4 h-4" />
                                    <div>
                                        <div class="font-bold text-gray-900">💳 Online Payment</div>
                                        <div class="text-xs text-emerald-600 font-medium mt-0.5">bKash / SSLCommerz</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gateway selector if online -->
                            <div v-if="form.payment_type === 'online'" class="grid grid-cols-2 gap-2 pt-1">
                                <div v-if="paymentSettings?.gateways?.bkash" @click="form.payment_gateway = 'bkash'" :class="[
                                    'p-2 rounded-lg border cursor-pointer text-center text-sm font-semibold',
                                    form.payment_gateway === 'bkash' ? 'border-pink-600 bg-pink-50 text-pink-700 font-bold shadow-sm' : 'border-gray-200 text-gray-600 hover:bg-gray-50'
                                ]">
                                    bKash
                                </div>
                                <div v-if="paymentSettings?.gateways?.sslcommerz" @click="form.payment_gateway = 'sslcommerz'" :class="[
                                    'p-2 rounded-lg border cursor-pointer text-center text-sm font-semibold',
                                    form.payment_gateway === 'sslcommerz' ? 'border-blue-600 bg-blue-50 text-blue-700 font-bold shadow-sm' : 'border-gray-200 text-gray-600 hover:bg-gray-50'
                                ]">
                                    SSLCommerz
                                </div>
                            </div>
                        </div>

                        <button type="submit" :disabled="form.processing || form.test_ids.length === 0" class="w-full py-3 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                            <span v-if="form.processing">Processing...</span>
                            <span v-else-if="form.payment_type === 'online'">Proceed to Online Payment</span>
                            <span v-else>Confirm & Generate Booking</span>
                        </button>
                    </div>
                </div>
            </form>
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
    categories:      { type: [Array, Object], default: () => [] },
    allTests:        { type: [Array, Object], default: () => [] },
    doctors:         { type: [Array, Object], default: () => [] },
    agent:           { type: Object, default: () => ({}) },
    paymentSettings: { type: Object, default: () => ({}) },
});

const today = new Date().toISOString().split('T')[0];
const testSearch = ref('');

const agentRate = computed(() => Number(props.agent?.test_commission_rate || 15));

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

const testsList = computed(() => {
    return Array.isArray(props.allTests) ? props.allTests : (props.allTests?.data || []);
});

const filteredTests = computed(() => {
    if (!testSearch.value) return testsList.value;
    const q = testSearch.value.toLowerCase();
    return testsList.value.filter(t => {
        const name = localized(t.name).toLowerCase();
        const code = (t.code || '').toLowerCase();
        return name.includes(q) || code.includes(q);
    });
});

const defaultGateway = computed(() => {
    if (props.paymentSettings?.gateways?.bkash) return 'bkash';
    if (props.paymentSettings?.gateways?.sslcommerz) return 'sslcommerz';
    return '';
});

const form = useForm({
    patient_name: '',
    phone: '',
    email: '',
    gender: 'male',
    marital_status: 'Married',
    date_of_birth: '',
    address: '',
    doctor_id: null,
    booking_date: today,
    preferred_date: '',
    test_ids: [],
    notes: '',
    payment_type: props.paymentSettings?.allow_without_pay !== false ? 'without_pay' : 'online',
    payment_gateway: defaultGateway.value || 'bkash',
});

// Calculate totals based on selected checkboxes
const selectedTestObjects = computed(() => {
    return testsList.value.filter(t => form.test_ids.includes(t.id));
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

const agentCommission = computed(() => {
    return Math.round((netPayable.value * agentRate.value) / 100);
});

function submit() {
    form.post(route('agent.test.store'));
}
</script>
