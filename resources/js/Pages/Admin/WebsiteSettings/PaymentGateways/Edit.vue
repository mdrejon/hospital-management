<template>
    <AdminLayout>
        <div class="max-w-6xl mx-auto space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Payment Gateways & Online Checkout</h1>
                    <p class="text-xs text-gray-500 mt-1">Configure SSLCommerz and bKash payment gateway credentials, modes, and global booking payment rules</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="activeTab = 'transactions'" class="px-3.5 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs flex items-center gap-1.5">
                        <span>💳</span> Transaction History ({{ transactions?.total || 0 }})
                    </button>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="flex items-center gap-2 border-b border-gray-200 text-xs font-semibold">
                <button type="button" @click="activeTab = 'gateways'" :class="activeTab === 'gateways' ? 'text-blue-700 border-b-2 border-blue-600 pb-2.5 font-bold' : 'text-gray-500 hover:text-gray-700 pb-2.5'">
                    Gateway Configurations
                </button>
                <button type="button" @click="activeTab = 'transactions'" :class="activeTab === 'transactions' ? 'text-blue-700 border-b-2 border-blue-600 pb-2.5 font-bold' : 'text-gray-500 hover:text-gray-700 pb-2.5'">
                    Online Payments Log ({{ transactions?.total || 0 }})
                </button>
            </div>

            <!-- TAB 1: GATEWAY CONFIGURATIONS -->
            <div v-show="activeTab === 'gateways'">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Global Checkout Rules -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900 flex items-center gap-2 border-b border-gray-100 pb-3">
                            <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs">1</span>
                            General Booking Payment Options
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-200/70 space-y-2">
                                <label class="block text-xs font-bold text-gray-800">Without Pay / Pay at Hospital Option</label>
                                <p class="text-2xs text-gray-500">Allow patients and agents to book appointments & tests with "Without Pay" (Payment settled at hospital counter).</p>
                                <div class="pt-2">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" v-model="form.payment_allow_without_pay" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                        <span class="ml-3 text-xs font-semibold text-gray-700">
                                            {{ form.payment_allow_without_pay ? 'Enabled (Pay at Counter Allowed)' : 'Disabled (Online Payment Required)' }}
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-200/70 space-y-2">
                                <label class="block text-xs font-bold text-gray-800">Default Currency</label>
                                <p class="text-2xs text-gray-500">Currency symbol/code passed to bKash and SSLCommerz gateways.</p>
                                <div class="pt-1">
                                    <input v-model="form.payment_currency" type="text" placeholder="BDT" class="w-full sm:w-40 px-3 py-1.5 text-xs font-mono font-bold border border-gray-300 rounded-lg bg-white focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SSLCommerz Gateway Box -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 pb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-200 flex items-center justify-center font-bold text-blue-700 text-sm">
                                    SSL
                                </div>
                                <div>
                                    <h2 class="text-sm font-bold text-gray-900">SSLCommerz Hosted Gateway</h2>
                                    <p class="text-2xs text-gray-500">Accept Visa, MasterCard, Amex, Nagad, Rocket, DBBL, and 30+ Bangladesh Bank accounts</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-1.5 text-xs">
                                    <label class="font-semibold text-gray-600">Mode:</label>
                                    <select v-model="form.sslcommerz_mode" class="px-2.5 py-1 text-xs border rounded-lg bg-white font-medium">
                                        <option value="sandbox">Sandbox (Testing)</option>
                                        <option value="live">Live (Production)</option>
                                    </select>
                                </div>

                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" v-model="form.sslcommerz_enabled" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ml-2.5 text-xs font-bold" :class="form.sslcommerz_enabled ? 'text-blue-700' : 'text-gray-400'">
                                        {{ form.sslcommerz_enabled ? 'Active' : 'Disabled' }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Store ID *</label>
                                <input v-model="form.sslcommerz_store_id" type="text" placeholder="e.g. yourstorelive or testbox" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                                <div v-if="form.errors.sslcommerz_store_id" class="text-red-600 text-2xs mt-1">{{ form.errors.sslcommerz_store_id }}</div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Store Password *</label>
                                <input v-model="form.sslcommerz_store_password" type="password" placeholder="••••••••••••" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                                <div v-if="form.errors.sslcommerz_store_password" class="text-red-600 text-2xs mt-1">{{ form.errors.sslcommerz_store_password }}</div>
                            </div>
                        </div>

                        <div class="bg-blue-50/60 rounded-xl p-3.5 border border-blue-100 text-2xs text-blue-800 flex items-start gap-2">
                            <span class="text-sm">ℹ️</span>
                            <div class="space-y-0.5 leading-relaxed">
                                <span class="font-bold">IPN & Callback Endpoints:</span>
                                <div>Success: <code class="bg-white/80 px-1 py-0.5 rounded font-mono">{{ route('payment.sslcommerz.success') }}</code></div>
                                <div>IPN URL: <code class="bg-white/80 px-1 py-0.5 rounded font-mono">{{ route('payment.sslcommerz.ipn') }}</code></div>
                            </div>
                        </div>
                    </div>

                    <!-- bKash Gateway Box -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 pb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-pink-50 border border-pink-200 flex items-center justify-center font-bold text-pink-700 text-sm">
                                    bKash
                                </div>
                                <div>
                                    <h2 class="text-sm font-bold text-gray-900">bKash Direct & Tokenized Payment</h2>
                                    <p class="text-2xs text-gray-500">Direct wallet debit with authentic bKash checkout popup</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-1.5 text-xs">
                                    <label class="font-semibold text-gray-600">Mode:</label>
                                    <select v-model="form.bkash_mode" class="px-2.5 py-1 text-xs border rounded-lg bg-white font-medium">
                                        <option value="sandbox">Sandbox (Testing)</option>
                                        <option value="live">Live (Production)</option>
                                    </select>
                                </div>

                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" v-model="form.bkash_enabled" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-pink-600"></div>
                                    <span class="ml-2.5 text-xs font-bold" :class="form.bkash_enabled ? 'text-pink-700' : 'text-gray-400'">
                                        {{ form.bkash_enabled ? 'Active' : 'Disabled' }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">App Key *</label>
                                <input v-model="form.bkash_app_key" type="text" placeholder="bKash Merchant App Key" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-pink-500 focus:outline-none" />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">App Secret *</label>
                                <input v-model="form.bkash_app_secret" type="password" placeholder="••••••••••••" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-pink-500 focus:outline-none" />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">API Username *</label>
                                <input v-model="form.bkash_username" type="text" placeholder="Merchant API Username" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-pink-500 focus:outline-none" />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">API Password *</label>
                                <input v-model="form.bkash_password" type="password" placeholder="••••••••••••" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-pink-500 focus:outline-none" />
                            </div>
                        </div>
                    </div>

                    <!-- Save Actions -->
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="submit" :disabled="form.processing" class="px-6 py-2.5 rounded-xl font-bold text-xs text-white bg-blue-600 hover:bg-blue-700 shadow-md transition-all flex items-center gap-2 disabled:opacity-50">
                            <span v-if="form.processing">Saving Configurations...</span>
                            <span v-else>Save Payment Settings &rarr;</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 2: TRANSACTIONS HISTORY -->
            <div v-show="activeTab === 'transactions'" class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
                <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-xs uppercase tracking-wider text-gray-800">Online Transactions Log</h3>
                    <span class="text-2xs text-gray-400">Total: {{ transactions?.total || 0 }} payments</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 font-semibold text-2xs uppercase tracking-wider">
                            <tr>
                                <th class="p-3.5">Transaction ID</th>
                                <th class="p-3.5">Booking / Item</th>
                                <th class="p-3.5">Gateway</th>
                                <th class="p-3.5">Amount</th>
                                <th class="p-3.5">Status</th>
                                <th class="p-3.5">Date</th>
                                <th class="p-3.5 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="tx in transactions?.data" :key="tx.id" class="hover:bg-gray-50/70 transition-colors">
                                <td class="p-3.5 font-mono font-bold text-gray-900">{{ tx.transaction_id }}</td>
                                <td class="p-3.5">
                                    <div v-if="tx.payable_type?.includes('Appointment')" class="space-y-0.5">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-3xs font-bold bg-blue-100 text-blue-800">Doctor Appointment</span>
                                        <div class="font-medium text-gray-800">{{ tx.payable?.name || 'Patient' }}</div>
                                    </div>
                                    <div v-else-if="tx.payable_type?.includes('MedicalTestBooking')" class="space-y-0.5">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-3xs font-bold bg-purple-100 text-purple-800">{{ tx.payable?.booking_number }}</span>
                                        <div class="font-medium text-gray-800">{{ tx.payable?.patient_name || 'Patient' }}</div>
                                    </div>
                                    <div v-else class="text-gray-400">#{{ tx.payable_id }}</div>
                                </td>
                                <td class="p-3.5">
                                    <span class="font-semibold uppercase text-2xs px-2 py-0.5 rounded" :class="tx.gateway === 'bkash' ? 'bg-pink-50 text-pink-700' : 'bg-blue-50 text-blue-700'">
                                        {{ tx.gateway }}
                                    </span>
                                </td>
                                <td class="p-3.5 font-mono font-bold text-gray-900">
                                    {{ tx.currency }} {{ Number(tx.amount).toFixed(2) }}
                                </td>
                                <td class="p-3.5">
                                    <span v-if="tx.status === 'successful'" class="inline-flex items-center px-2 py-0.5 rounded-full text-2xs font-bold bg-emerald-100 text-emerald-800">
                                        ✓ Paid
                                    </span>
                                    <span v-else-if="tx.status === 'pending'" class="inline-flex items-center px-2 py-0.5 rounded-full text-2xs font-bold bg-amber-100 text-amber-800">
                                        ⏱ Pending
                                    </span>
                                    <span v-else-if="tx.status === 'cancelled'" class="inline-flex items-center px-2 py-0.5 rounded-full text-2xs font-bold bg-gray-100 text-gray-700">
                                        Cancelled
                                    </span>
                                    <span v-else class="inline-flex items-center px-2 py-0.5 rounded-full text-2xs font-bold bg-red-100 text-red-800">
                                        Failed
                                    </span>
                                </td>
                                <td class="p-3.5 text-gray-400 text-2xs">
                                    {{ new Date(tx.created_at).toLocaleString() }}
                                </td>
                                <td class="p-3.5 text-right">
                                    <a :href="route('payment.receipt', tx.id)" target="_blank" class="px-2.5 py-1 text-2xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded transition-colors">
                                        View Voucher
                                    </a>
                                </td>
                            </tr>

                            <tr v-if="!transactions?.data || transactions.data.length === 0">
                                <td colspan="7" class="p-8 text-center text-gray-400">
                                    No payment transactions recorded yet.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    settings:     { type: Object, default: () => ({}) },
    transactions: { type: Object, default: () => ({ data: [] }) },
});

const activeTab = ref('gateways');

const form = useForm({
    payment_allow_without_pay: props.settings?.payment_allow_without_pay ?? true,
    payment_currency:          props.settings?.payment_currency || 'BDT',
    sslcommerz_enabled:        props.settings?.sslcommerz_enabled ?? false,
    sslcommerz_store_id:       props.settings?.sslcommerz_store_id || '',
    sslcommerz_store_password: props.settings?.sslcommerz_store_password || '',
    sslcommerz_mode:           props.settings?.sslcommerz_mode || 'sandbox',
    bkash_enabled:             props.settings?.bkash_enabled ?? false,
    bkash_app_key:             props.settings?.bkash_app_key || '',
    bkash_app_secret:          props.settings?.bkash_app_secret || '',
    bkash_username:            props.settings?.bkash_username || '',
    bkash_password:            props.settings?.bkash_password || '',
    bkash_mode:                props.settings?.bkash_mode || 'sandbox',
});

function submit() {
    form.post(route('admin.website-settings.payment-gateways.update'), {
        preserveScroll: true,
    });
}
</script>
