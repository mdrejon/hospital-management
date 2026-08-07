<template>
    <AdminLayout>
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Add Diagnostic Medical Test</h1>
                    <p class="text-xs text-gray-500 mt-1">Configure pricing, sample collection instructions, and report delivery timeframe</p>
                </div>
                <Link :href="route('admin.medical-tests.index')" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs">
                    &larr; Back to Catalog
                </Link>
            </div>

            <!-- Language Tabs -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase mr-2">Language:</span>
                    <button v-for="lang in languages" :key="lang.code" type="button" @click="activeLang = lang.code" :class="activeLang === lang.code ? 'bg-blue-600 text-white font-bold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'" class="px-3 py-1 text-xs rounded-lg uppercase transition-all">
                        {{ lang.name }} ({{ lang.code }})
                    </button>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- 1. Categorization & Identity -->
                <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-blue-700">1. Basic Identification</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Category *</label>
                            <select v-model="form.category_id" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                <option value="">Select Category</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ localized(cat.name) }}</option>
                            </select>
                            <span v-if="form.errors.category_id" class="text-xs text-red-600">{{ form.errors.category_id }}</span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Test Code / Identifier *</label>
                            <input v-model="form.code" type="text" required placeholder="e.g. CBC-001, LFT-102" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono" />
                            <span v-if="form.errors.code" class="text-xs text-red-600">{{ form.errors.code }}</span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Test Name ({{ activeLang }}) *</label>
                            <input v-model="form.name[activeLang]" type="text" required placeholder="e.g. Complete Blood Count (CBC)" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Test Description ({{ activeLang }})</label>
                            <textarea v-model="form.description[activeLang]" rows="2" placeholder="Clinical purpose of test..." class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. Pricing & Discounts -->
                <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-emerald-700">2. Pricing & Discounts</h2>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Standard Price (BDT) *</label>
                            <input v-model="form.price" type="number" step="0.01" min="0" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none font-bold text-gray-900" placeholder="e.g. 800" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Discount Type</label>
                            <select v-model="form.discount_type" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount (BDT)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Discount Value</label>
                            <input v-model="form.discount_amount" type="number" step="0.01" min="0" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="0" />
                        </div>

                        <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-200 text-center">
                            <div class="text-2xs font-semibold text-emerald-700 uppercase">Effective Net Price</div>
                            <div class="text-xl font-black text-emerald-800 mt-0.5">BDT {{ calculatedNetPrice.toLocaleString() }}</div>
                        </div>
                    </div>
                </div>

                <!-- 3. Specimen, Guidelines & Settings -->
                <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-purple-700">3. Sample & Preparation Guidelines</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Sample / Specimen Type</label>
                            <input v-model="form.sample_type" type="text" placeholder="e.g. Blood (EDTA), Fasting Blood, Urine" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Report Delivery Time</label>
                            <input v-model="form.delivery_time" type="text" placeholder="e.g. 4 Hours, 24 Hours, Same Day" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Preparation Instructions ({{ activeLang }})</label>
                            <textarea v-model="form.preparation_instructions[activeLang]" rows="2" placeholder="e.g. 10-12 hours overnight fasting required..." class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        </div>

                        <div class="flex items-center gap-2">
                            <input id="test-home-sample" v-model="form.is_home_sample_allowed" type="checkbox" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500" />
                            <label for="test-home-sample" class="text-xs font-medium text-gray-700">Home Sample Collection Available</label>
                        </div>

                        <div class="flex items-center gap-2">
                            <input id="test-active" v-model="form.is_active" type="checkbox" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500" />
                            <label for="test-active" class="text-xs font-medium text-gray-700">Test Active & Available for Booking</label>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <Link :href="route('admin.medical-tests.index')" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">
                        Cancel
                    </Link>
                    <button type="submit" :disabled="form.processing" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs transition-all flex items-center gap-2">
                        <span>+</span> Create Medical Test
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    categories: { type: Array, default: () => [] },
    languages:  { type: Array, default: () => [{ code: 'en', name: 'English' }] },
});

const activeLang = ref(props.languages[0]?.code || 'en');

const form = useForm({
    category_id: '',
    code: '',
    name: {},
    description: {},
    preparation_instructions: {},
    price: '',
    discount_price: null,
    discount_amount: 0,
    discount_type: 'percentage',
    sample_type: 'Blood',
    delivery_time: 'Same Day (4-6 Hours)',
    sort_order: 0,
    is_home_sample_allowed: false,
    is_active: true,
});

props.languages.forEach(l => {
    form.name[l.code] = '';
    form.description[l.code] = '';
    form.preparation_instructions[l.code] = '';
});

const calculatedNetPrice = computed(() => {
    const base = parseFloat(form.price) || 0;
    const disc = parseFloat(form.discount_amount) || 0;
    if (disc <= 0) return base;
    if (form.discount_type === 'percentage') {
        return Math.max(0, base - (base * (disc / 100)));
    }
    return Math.max(0, base - disc);
});

function localized(field) {
    if (!field) return '';
    if (typeof field === 'string') return field;
    return field['en'] || Object.values(field)[0] || '';
}

function submit() {
    form.discount_price = calculatedNetPrice.value;
    form.post(route('admin.medical-tests.store'));
}
</script>
