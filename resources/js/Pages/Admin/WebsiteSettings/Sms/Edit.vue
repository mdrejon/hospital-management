<template>
    <AdminLayout>
        <div class="max-w-5xl mx-auto space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">SMS Gateway & Automated Alerts</h1>
                    <p class="text-xs text-gray-500 mt-1">Configure SMS API gateway credentials, automated triggers & message templates</p>
                </div>
                <div class="flex items-center gap-3">
                    <Link :href="route('admin.website-settings.sms.logs')" class="px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 shadow-xs flex items-center gap-1.5">
                        <span>📜</span> View SMS Dispatch Logs
                    </Link>
                </div>
            </div>

            <!-- Quick Test Card -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200/80 rounded-2xl p-5 shadow-xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-blue-900 mb-3 flex items-center gap-2">
                    <span>🚀</span> Test SMS Delivery
                </h3>
                <form @submit.prevent="sendTestSms" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                    <div>
                        <label class="block text-2xs font-bold text-blue-800 uppercase mb-1">Recipient Mobile Number</label>
                        <input v-model="testForm.test_phone" type="text" required placeholder="017XXXXXXXX or 88017XXXXXXXX" class="w-full px-3 py-2 text-xs border border-blue-200 rounded-lg bg-white focus:outline-none" />
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-blue-800 uppercase mb-1">Message Body</label>
                        <input v-model="testForm.test_message" type="text" required class="w-full px-3 py-2 text-xs border border-blue-200 rounded-lg bg-white focus:outline-none" />
                    </div>
                    <div>
                        <button type="submit" :disabled="testForm.processing" class="w-full py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-all flex items-center justify-center gap-1.5">
                            <span v-if="testForm.processing">Sending...</span>
                            <span v-else>Send Test SMS &rarr;</span>
                        </button>
                    </div>
                </form>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- 1. Gateway Credentials -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs">1</span>
                            Gateway Provider & API Credentials
                        </h2>
                        <div class="flex items-center gap-2">
                            <label class="text-xs font-bold text-gray-700">Master SMS Status:</label>
                            <select v-model="form.sms_enabled" class="text-xs font-semibold py-1 px-2.5 rounded-lg border bg-white" :class="form.sms_enabled === '1' ? 'text-emerald-700 border-emerald-300' : 'text-gray-500 border-gray-300'">
                                <option value="1">Enabled (Active)</option>
                                <option value="0">Disabled / Offline</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Gateway Provider</label>
                            <select v-model="form.sms_provider" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                <option value="generic_http">Generic HTTP / REST API</option>
                                <option value="ssl_wireless">SSL Wireless (Bangladesh)</option>
                                <option value="greenweb">Greenweb BD</option>
                                <option value="bulksms_bd">BulkSMS BD</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Sender ID / Masking Name</label>
                            <input v-model="form.sms_sender_id" type="text" placeholder="HOSPITAL" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">HTTP Method</label>
                            <select v-model="form.sms_method" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                <option value="GET">GET Request</option>
                                <option value="POST">POST JSON / Form-Data</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">API Endpoint URL</label>
                            <input v-model="form.sms_api_url" type="url" placeholder="https://api.sms-provider.com/send" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono text-xs" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">API Key / Token / Password</label>
                            <input v-model="form.sms_api_key" type="password" placeholder="••••••••••••••••" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono text-xs" />
                        </div>
                    </div>
                </div>

                <!-- 2. Patient Notification Templates -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-6">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-purple-700 flex items-center gap-2 border-b pb-3">
                        <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center text-xs">2</span>
                        Patient Notification Triggers & Templates
                    </h2>

                    <!-- Template 1: Doctor Booking Request -->
                    <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-900 text-xs uppercase">1. Doctor Appointment Request Received</span>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                <input v-model="form.sms_toggle_appointment_booked" type="checkbox" true-value="1" false-value="0" class="rounded text-blue-600" />
                                <span :class="form.sms_toggle_appointment_booked === '1' ? 'text-emerald-700 font-bold' : 'text-gray-400'">Active</span>
                            </label>
                        </div>
                        <div class="text-2xs text-gray-400 font-mono">Variables: {patient_name}, {doctor_name}, {date}, {serial}, {hospital_name}</div>
                        <textarea v-model="form.sms_template_appointment_booked" rows="2" class="w-full px-3 py-2 text-xs border rounded-lg bg-white focus:outline-none"></textarea>
                    </div>

                    <!-- Template 2: Doctor Appointment Confirmed -->
                    <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-900 text-xs uppercase">2. Doctor Appointment Confirmed (Date & Time Fixed)</span>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                <input v-model="form.sms_toggle_appointment_confirmed" type="checkbox" true-value="1" false-value="0" class="rounded text-blue-600" />
                                <span :class="form.sms_toggle_appointment_confirmed === '1' ? 'text-emerald-700 font-bold' : 'text-gray-400'">Active</span>
                            </label>
                        </div>
                        <div class="text-2xs text-gray-400 font-mono">Variables: {patient_name}, {doctor_name}, {date}, {time}, {serial}, {hospital_name}</div>
                        <textarea v-model="form.sms_template_appointment_confirmed" rows="2" class="w-full px-3 py-2 text-xs border rounded-lg bg-white focus:outline-none"></textarea>
                    </div>

                    <!-- Template 3: Medical Test Booked -->
                    <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-900 text-xs uppercase">3. Medical Test Order Placed</span>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                <input v-model="form.sms_toggle_test_booked" type="checkbox" true-value="1" false-value="0" class="rounded text-blue-600" />
                                <span :class="form.sms_toggle_test_booked === '1' ? 'text-emerald-700 font-bold' : 'text-gray-400'">Active</span>
                            </label>
                        </div>
                        <div class="text-2xs text-gray-400 font-mono">Variables: {patient_name}, {test_number}, {amount}, {paid}, {due}, {hospital_name}</div>
                        <textarea v-model="form.sms_template_test_booked" rows="2" class="w-full px-3 py-2 text-xs border rounded-lg bg-white focus:outline-none"></textarea>
                    </div>

                    <!-- Template 4: Diagnostic Test Report Ready -->
                    <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-900 text-xs uppercase">4. Diagnostic Test Reports Ready for Delivery</span>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                <input v-model="form.sms_toggle_test_completed" type="checkbox" true-value="1" false-value="0" class="rounded text-blue-600" />
                                <span :class="form.sms_toggle_test_completed === '1' ? 'text-emerald-700 font-bold' : 'text-gray-400'">Active</span>
                            </label>
                        </div>
                        <div class="text-2xs text-gray-400 font-mono">Variables: {patient_name}, {test_number}, {hospital_name}</div>
                        <textarea v-model="form.sms_template_test_completed" rows="2" class="w-full px-3 py-2 text-xs border rounded-lg bg-white focus:outline-none"></textarea>
                    </div>
                </div>

                <!-- 3. Agent Alerts Templates -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-6">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-emerald-700 flex items-center gap-2 border-b pb-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">3</span>
                        Agent Commission & Wallet SMS Alerts
                    </h2>

                    <!-- Template 5: Commission Credited -->
                    <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-900 text-xs uppercase">5. Agent Commission Credited</span>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                <input v-model="form.sms_toggle_commission_credited" type="checkbox" true-value="1" false-value="0" class="rounded text-blue-600" />
                                <span :class="form.sms_toggle_commission_credited === '1' ? 'text-emerald-700 font-bold' : 'text-gray-400'">Active</span>
                            </label>
                        </div>
                        <div class="text-2xs text-gray-400 font-mono">Variables: {agent_name}, {amount}, {balance}, {hospital_name}</div>
                        <textarea v-model="form.sms_template_commission_credited" rows="2" class="w-full px-3 py-2 text-xs border rounded-lg bg-white focus:outline-none"></textarea>
                    </div>

                    <!-- Template 6: Withdrawal Status -->
                    <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-900 text-xs uppercase">6. Cash Out Status (Approved / Paid / Rejected)</span>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                <input v-model="form.sms_toggle_withdrawal_status" type="checkbox" true-value="1" false-value="0" class="rounded text-blue-600" />
                                <span :class="form.sms_toggle_withdrawal_status === '1' ? 'text-emerald-700 font-bold' : 'text-gray-400'">Active</span>
                            </label>
                        </div>
                        <div class="text-2xs text-gray-400 font-mono">Variables: {withdrawal_number}, {amount}, {status}, {txn_note}, {hospital_name}</div>
                        <textarea v-model="form.sms_template_withdrawal_status" rows="2" class="w-full px-3 py-2 text-xs border rounded-lg bg-white focus:outline-none"></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-2">
                    <button type="submit" :disabled="form.processing" class="px-7 py-3 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition-all">
                        Save SMS Settings & Templates
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    settings:   { type: Object, required: true },
    recentLogs: { type: Array, default: () => [] },
});

const form = useForm({
    sms_enabled:                        props.settings.sms_enabled || '0',
    sms_provider:                       props.settings.sms_provider || 'generic_http',
    sms_api_url:                        props.settings.sms_api_url || '',
    sms_api_key:                        props.settings.sms_api_key || '',
    sms_sender_id:                      props.settings.sms_sender_id || 'HOSPITAL',
    sms_client_id:                      props.settings.sms_client_id || '',
    sms_method:                         props.settings.sms_method || 'GET',
    sms_toggle_appointment_booked:      props.settings.sms_toggle_appointment_booked || '1',
    sms_template_appointment_booked:    props.settings.sms_template_appointment_booked || '',
    sms_toggle_appointment_confirmed:   props.settings.sms_toggle_appointment_confirmed || '1',
    sms_template_appointment_confirmed: props.settings.sms_template_appointment_confirmed || '',
    sms_toggle_test_booked:             props.settings.sms_toggle_test_booked || '1',
    sms_template_test_booked:           props.settings.sms_template_test_booked || '',
    sms_toggle_test_completed:          props.settings.sms_toggle_test_completed || '1',
    sms_template_test_completed:        props.settings.sms_template_test_completed || '',
    sms_toggle_commission_credited:     props.settings.sms_toggle_commission_credited || '1',
    sms_template_commission_credited:   props.settings.sms_template_commission_credited || '',
    sms_toggle_withdrawal_status:       props.settings.sms_toggle_withdrawal_status || '1',
    sms_template_withdrawal_status:     props.settings.sms_template_withdrawal_status || '',
});

const testForm = useForm({
    test_phone: '',
    test_message: 'Modern Hospital: This is a test SMS alert verification.',
});

function submit() {
    form.post(route('admin.website-settings.sms.update'), {
        preserveScroll: true,
    });
}

function sendTestSms() {
    testForm.post(route('admin.website-settings.sms.test'), {
        preserveScroll: true,
    });
}
</script>
