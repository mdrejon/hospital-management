<template>
    <AgentLayout>
        <div class="space-y-5">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Order Medical Tests</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Book lab tests & health checkups for patients. Earn instant commissions credited to your wallet.</p>
                </div>
                <Link :href="route('agent.bookings.index', { tab: 'tests' })" class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                    &larr; Test Bookings History
                </Link>
            </div>

            <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">
                <!-- Left 2 Cols: Catalog & Patient Form -->
                <div class="lg:col-span-2 space-y-5">
                    <!-- 1. Test Selection Catalog -->
                    <div class="bg-white rounded-lg shadow-sm p-5 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 pb-2.5">
                            <h2 class="text-xs font-bold uppercase tracking-wider text-purple-700">
                                1. Select Diagnostic Tests ({{ selectedTests.length }} chosen)
                            </h2>
                            <input v-model="searchQuery" type="text" placeholder="Search tests..." class="px-3 py-1.5 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-purple-500 w-full sm:w-60" />
                        </div>

                        <!-- Categories filter -->
                        <div class="flex flex-wrap gap-1.5">
                            <button type="button" @click="selectedCategoryId = ''" :class="selectedCategoryId === '' ? 'bg-purple-600 text-white font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-2.5 py-1 rounded text-xs transition-colors">
                                All Categories
                            </button>
                            <button v-for="cat in categories" :key="cat.id" type="button" @click="selectedCategoryId = cat.id" :class="selectedCategoryId === cat.id ? 'bg-purple-600 text-white font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-2.5 py-1 rounded text-xs transition-colors">
                                {{ localized(cat.name) }}
                            </button>
                        </div>

                        <!-- Tests List -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-96 overflow-y-auto p-1">
                            <div v-for="test in filteredTests" :key="test.id" @click="toggleTest(test)" :class="[
                                'p-3 rounded border cursor-pointer transition-all flex flex-col justify-between',
                                isSelected(test) ? 'border-purple-600 bg-purple-50/50 ring-1 ring-purple-500' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'
                            ]">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <div class="font-semibold text-xs text-gray-900">{{ localized(test.name) }}</div>
                                        <div class="text-2xs font-mono text-gray-400 mt-0.5">{{ test.code }} • {{ localized(test.category?.name) }}</div>
                                    </div>
                                    <input type="checkbox" :checked="isSelected(test)" class="w-4 h-4 rounded text-purple-600 focus:ring-purple-500 mt-0.5" />
                                </div>

                                <div class="mt-2.5 pt-2 border-t border-gray-100 flex items-center justify-between text-2xs">
                                    <div>
                                        <span class="font-bold text-gray-900">BDT {{ Number(test.final_price).toLocaleString() }}</span>
                                        <span v-if="test.discount_percent > 0" class="text-2xs text-gray-400 line-through ml-1.5">BDT {{ Number(test.price).toLocaleString() }}</span>
                                    </div>
                                    <span class="font-bold text-emerald-600">+BDT {{ Math.round((test.final_price * agentRate) / 100) }} comm.</span>
                                </div>
                            </div>
                        </div>
                        <div v-if="form.errors.test_ids" class="text-red-600 text-xs">{{ form.errors.test_ids }}</div>
                    </div>

                    <!-- 2. Patient Information -->
                    <div class="bg-white rounded-lg shadow-sm p-5 space-y-4">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-blue-700 border-b border-gray-100 pb-2.5">
                            2. Patient Information
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Patient Full Name *</label>
                                <input v-model="form.patient_name" type="text" required placeholder="Patient full name" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-purple-500 focus:outline-none" />
                                <div v-if="form.errors.patient_name" class="text-red-600 text-xs mt-1">{{ form.errors.patient_name }}</div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Mobile Phone (For SMS) *</label>
                                <input v-model="form.phone" type="text" required placeholder="017XXXXXXXX" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-purple-500 focus:outline-none" />
                                <div v-if="form.errors.phone" class="text-red-600 text-xs mt-1">{{ form.errors.phone }}</div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Gender *</label>
                                <select v-model="form.gender" required class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-purple-500 focus:outline-none bg-white">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Date of Birth</label>
                                <input v-model="form.date_of_birth" type="date" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-purple-500 focus:outline-none" />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Referring Doctor (Optional)</label>
                                <select v-model="form.doctor_id" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-purple-500 focus:outline-none bg-white">
                                    <option :value="null">None / Self-Referred</option>
                                    <option v-for="doc in doctors" :key="doc.id" :value="doc.id">{{ localized(doc.name) }}</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Sample Collection / Booking Date</label>
                                <input v-model="form.booking_date" type="date" :min="today" required class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-purple-500 focus:outline-none" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Patient Address / Notes</label>
                            <textarea v-model="form.address" rows="2" placeholder="Address or special lab remarks..." class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-purple-500 focus:outline-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Right Col: Summary & Order Calculation & Payment Options -->
                <div class="bg-white rounded-lg shadow-sm p-5 space-y-4 sticky top-6">
                    <h3 class="font-semibold text-gray-800 text-sm border-b border-gray-100 pb-2.5">Test Order Summary</h3>

                    <!-- Selected items list -->
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        <div v-for="test in selectedTests" :key="test.id" class="flex items-center justify-between text-xs py-1 border-b border-gray-100">
                            <div class="overflow-hidden pr-2">
                                <div class="font-medium text-gray-800 truncate">{{ localized(test.name) }}</div>
                                <div class="text-2xs text-gray-400 font-mono">{{ test.code }}</div>
                            </div>
                            <div class="font-mono font-semibold text-gray-900 shrink-0">
                                BDT {{ Number(test.final_price).toLocaleString() }}
                            </div>
                        </div>

                        <div v-if="selectedTests.length === 0" class="py-6 text-center text-xs text-gray-400">
                            No tests selected yet. Click tests from the left catalog to add.
                        </div>
                    </div>

                    <!-- Totals -->
                    <div class="pt-2.5 border-t border-gray-100 space-y-1.5 text-xs">
                        <div class="flex justify-between text-gray-500">
                            <span>Subtotal:</span>
                            <span class="font-mono">BDT {{ subtotal.toLocaleString() }}</span>
                        </div>
                        <div v-if="discountTotal > 0" class="flex justify-between text-emerald-600">
                            <span>Catalog Discount:</span>
                            <span class="font-mono">-BDT {{ discountTotal.toLocaleString() }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-gray-900 pt-1.5 border-t">
                            <span>Patient Bill Total:</span>
                            <span class="font-mono text-purple-700">BDT {{ totalPayable.toLocaleString() }}</span>
                        </div>
                    </div>

                    <!-- Agent Commission Box -->
                    <div class="p-3 rounded bg-emerald-50 border border-emerald-200 text-emerald-900 space-y-0.5">
                        <div class="text-2xs uppercase font-bold tracking-wider text-emerald-700">Your Agent Commission</div>
                        <div class="text-lg font-bold text-emerald-700">BDT {{ agentCommission.toLocaleString() }}</div>
                        <div class="text-2xs text-emerald-600">{{ agentRate }}% commission credited to your wallet</div>
                    </div>

                    <!-- Payment Options -->
                    <div class="pt-2 border-t border-gray-100 space-y-2.5">
                        <label class="block text-2xs font-bold uppercase tracking-wider text-gray-700">Payment Option</label>

                        <div class="space-y-2">
                            <!-- Without Pay -->
                            <div v-if="paymentSettings?.allow_without_pay !== false" @click="form.payment_type = 'without_pay'" :class="[
                                'p-2.5 rounded border cursor-pointer transition-all flex items-start gap-2 text-xs',
                                form.payment_type === 'without_pay' ? 'border-purple-600 bg-purple-50/50 ring-1 ring-purple-500' : 'border-gray-200 hover:bg-gray-50'
                            ]">
                                <input type="radio" name="payment_type" value="without_pay" :checked="form.payment_type === 'without_pay'" class="mt-0.5 text-purple-600" />
                                <div>
                                    <div class="font-semibold text-gray-800">🏥 Pay at Lab / Counter</div>
                                    <div class="text-3xs text-gray-400">Without Pay (Settle at hospital)</div>
                                </div>
                            </div>

                            <!-- Online Payment -->
                            <div v-if="paymentSettings?.has_online" @click="form.payment_type = 'online'" :class="[
                                'p-2.5 rounded border cursor-pointer transition-all flex items-start gap-2 text-xs',
                                form.payment_type === 'online' ? 'border-purple-600 bg-purple-50/50 ring-1 ring-purple-500' : 'border-gray-200 hover:bg-gray-50'
                            ]">
                                <input type="radio" name="payment_type" value="online" :checked="form.payment_type === 'online'" class="mt-0.5 text-purple-600" />
                                <div>
                                    <div class="font-semibold text-gray-800">💳 Online Payment</div>
                                    <div class="text-3xs text-emerald-600">bKash / SSLCommerz</div>
                                </div>
                            </div>
                        </div>

                        <!-- Gateway selector if online -->
                        <div v-if="form.payment_type === 'online'" class="grid grid-cols-2 gap-2 pt-1">
                            <div v-if="paymentSettings?.gateways?.bkash" @click="form.payment_gateway = 'bkash'" :class="[
                                'p-2 rounded border cursor-pointer text-center text-xs font-semibold',
                                form.payment_gateway === 'bkash' ? 'border-pink-600 bg-pink-50 text-pink-700 font-bold' : 'border-gray-200 text-gray-600 hover:bg-gray-50'
                            ]">
                                bKash
                            </div>
                            <div v-if="paymentSettings?.gateways?.sslcommerz" @click="form.payment_gateway = 'sslcommerz'" :class="[
                                'p-2 rounded border cursor-pointer text-center text-xs font-semibold',
                                form.payment_gateway === 'sslcommerz' ? 'border-blue-600 bg-blue-50 text-blue-700 font-bold' : 'border-gray-200 text-gray-600 hover:bg-gray-50'
                            ]">
                                SSLCommerz
                            </div>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" :disabled="form.processing || selectedTests.length === 0" class="w-full py-2.5 rounded font-bold text-xs text-white bg-purple-600 hover:bg-purple-700 transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                        <span v-if="form.processing">Processing Order...</span>
                        <span v-else-if="form.payment_type === 'online'">Proceed to Online Payment &rarr;</span>
                        <span v-else>Confirm Test Booking &rarr;</span>
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
    categories:      { type: [Array, Object], default: () => [] },
    allTests:        { type: [Array, Object], default: () => [] },
    doctors:         { type: [Array, Object], default: () => [] },
    agent:           { type: Object, default: () => ({}) },
    paymentSettings: { type: Object, default: () => ({}) },
});

const today = new Date().toISOString().split('T')[0];
const selectedCategoryId = ref('');
const searchQuery = ref('');
const selectedTests = ref([]);

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
    return testsList.value.filter(t => {
        const matchesCat = !selectedCategoryId.value || t.medical_test_category_id === selectedCategoryId.value;
        const name = localized(t.name).toLowerCase();
        const code = (t.code || '').toLowerCase();
        const q = searchQuery.value.toLowerCase();
        const matchesSearch = !q || name.includes(q) || code.includes(q);
        return matchesCat && matchesSearch;
    });
});

function isSelected(test) {
    return selectedTests.value.some(t => t.id === test.id);
}

function toggleTest(test) {
    if (isSelected(test)) {
        selectedTests.value = selectedTests.value.filter(t => t.id !== test.id);
    } else {
        selectedTests.value.push(test);
    }
    form.test_ids = selectedTests.value.map(t => t.id);
}

const subtotal = computed(() => {
    return selectedTests.value.reduce((sum, t) => sum + Number(t.price || 0), 0);
});

const totalPayable = computed(() => {
    return selectedTests.value.reduce((sum, t) => sum + Number(t.final_price || 0), 0);
});

const discountTotal = computed(() => {
    return Math.max(0, subtotal.value - totalPayable.value);
});

const agentCommission = computed(() => {
    return Math.round((totalPayable.value * agentRate.value) / 100);
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
    date_of_birth: '',
    address: '',
    doctor_id: null,
    booking_date: today,
    preferred_date: today,
    test_ids: [],
    notes: '',
    payment_type: props.paymentSettings?.allow_without_pay !== false ? 'without_pay' : 'online',
    payment_gateway: defaultGateway.value || 'bkash',
});

function submit() {
    form.post(route('agent.test.store'));
}
</script>
