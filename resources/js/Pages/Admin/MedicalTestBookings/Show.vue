<template>
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-xl">
                        🧪
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-xl font-bold text-gray-900">Order #{{ booking.booking_number }}</h1>
                            <span :class="statusBadge(booking.status)" class="px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase">
                                {{ formatStatus(booking.status) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">Booked on {{ new Date(booking.created_at).toLocaleString() }} &bull; Patient: <strong class="text-gray-800">{{ booking.patient_name }}</strong></p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a :href="route('admin.medical-test-bookings.invoice', booking.id)" target="_blank" class="px-3.5 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs flex items-center gap-1.5">
                        <span>🖨️</span> Print Invoice / Token
                    </a>
                    <Link :href="route('admin.medical-test-bookings.index')" class="px-3.5 py-2 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        &larr; Back
                    </Link>
                </div>
            </div>

            <!-- Agent Commission Banner (if booked via agent) -->
            <div v-if="booking.agent" class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200/80 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-sm">
                        🧑‍💼
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase text-emerald-800 tracking-wider">Referred By Agent</div>
                        <div class="text-sm font-semibold text-gray-900">{{ booking.agent.user?.name }} (Code: {{ booking.agent.agent_code }}) &bull; {{ booking.agent.phone }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-xs text-emerald-700 font-medium">Agent Commission Earned:</div>
                    <div class="text-lg font-black text-emerald-900">BDT {{ Number(booking.agent_commission_amount || 0).toLocaleString() }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Test Items & Lab Reports (2 cols) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- 1. Ordered Tests & Report Upload -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <div class="flex items-center justify-between border-b pb-3">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900">Diagnostic Tests ({{ booking.items?.length || 0 }})</h2>
                            <span class="text-xs text-gray-500 font-mono">Total Bill: BDT {{ Number(booking.total_amount).toLocaleString() }}</span>
                        </div>

                        <div class="divide-y divide-gray-100">
                            <div v-for="item in booking.items" :key="item.id" class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="space-y-1">
                                    <div class="font-bold text-gray-900 text-sm">{{ item.test_name }}</div>
                                    <div class="text-xs text-gray-400 font-mono">Code: {{ item.test_code }} &bull; Specimen: {{ item.medical_test?.sample_type || 'Blood' }}</div>
                                    <div class="text-xs text-blue-600">Standard Price: BDT {{ Number(item.unit_price).toLocaleString() }} <span v-if="item.discount_amount > 0" class="text-emerald-600">(- BDT {{ Number(item.discount_amount).toLocaleString() }} discount)</span></div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <!-- Report download or upload -->
                                    <div v-if="item.report_file" class="flex items-center gap-2">
                                        <a :href="'/storage/' + item.report_file" target="_blank" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-lg text-xs font-bold flex items-center gap-1">
                                            <span>📄</span> View Report
                                        </a>
                                        <button @click="openReportUpload(item)" title="Replace Report" class="p-1.5 text-gray-400 hover:text-gray-600 text-xs">
                                            ✏️
                                        </button>
                                    </div>
                                    <div v-else>
                                        <button @click="openReportUpload(item)" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-xs font-semibold flex items-center gap-1">
                                            <span>📤</span> Upload Report PDF
                                        </button>
                                    </div>

                                    <div class="text-right min-w-[90px]">
                                        <div class="text-sm font-black text-gray-900">BDT {{ Number(item.final_price).toLocaleString() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Patient & Referral Details -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 border-b pb-2">Patient Profile</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
                            <div>
                                <span class="text-gray-400 block">Name</span>
                                <strong class="text-gray-900 text-sm">{{ booking.patient_name }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Phone</span>
                                <strong class="text-gray-900 text-sm font-mono">{{ booking.phone }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Gender & Age</span>
                                <span class="text-gray-800 capitalize">{{ booking.gender }} {{ booking.date_of_birth ? `(${booking.date_of_birth})` : '' }}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-400 block">Address</span>
                                <span class="text-gray-800">{{ booking.address || 'Not specified' }}</span>
                            </div>
                            <div v-if="booking.doctor">
                                <span class="text-gray-400 block">Referring Doctor</span>
                                <span class="text-blue-700 font-semibold">Dr. {{ displayTranslatable(booking.doctor.name, langs) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Status Update & Payment Collection (1 col) -->
                <div class="space-y-6">
                    <!-- Status Progression -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900 border-b pb-2">Process & Lab Status</h3>

                        <form @submit.prevent="submitStatus" class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Update Status</label>
                                <select v-model="statusForm.status" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                    <option value="pending">Pending</option>
                                    <option value="sample_collected">Sample Collected</option>
                                    <option value="processing">In Lab Processing</option>
                                    <option value="completed">Completed / Report Ready</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Report Delivery Date</label>
                                <FlatpickrInput v-model="statusForm.report_delivery_date" :options="{ dateFormat: 'Y-m-d' }" placeholder="Select Report Delivery Date" />
                            </div>

                            <button type="submit" :disabled="statusForm.processing" class="w-full py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs transition-all">
                                Update Lab Status
                            </button>
                        </form>
                    </div>

                    <!-- Financial & Payment Updates -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900 border-b pb-2">Billing & Payment</h3>

                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal:</span>
                                <span class="font-semibold text-gray-900">BDT {{ Number(booking.subtotal).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between text-emerald-600">
                                <span>Discounts:</span>
                                <span class="font-semibold">- BDT {{ Number(booking.discount_amount).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between text-gray-900 font-bold border-t pt-2">
                                <span>Net Total:</span>
                                <span>BDT {{ Number(booking.total_amount).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between text-blue-600">
                                <span>Paid So Far:</span>
                                <span class="font-bold">BDT {{ Number(booking.paid_amount).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between font-black text-sm" :class="booking.due_amount > 0 ? 'text-rose-600' : 'text-emerald-600'">
                                <span>Due Balance:</span>
                                <span>BDT {{ Number(booking.due_amount).toLocaleString() }}</span>
                            </div>
                        </div>

                        <!-- Payment Collection Form -->
                        <div v-if="booking.due_amount > 0" class="border-t pt-3 space-y-3">
                            <h4 class="text-2xs font-bold uppercase tracking-wider text-gray-500">Collect Due Payment</h4>
                            <form @submit.prevent="submitPayment" class="space-y-3">
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-600 uppercase mb-0.5">Collect Amount (BDT)</label>
                                    <input v-model="paymentForm.paid_amount" type="number" step="0.01" min="1" :max="booking.due_amount" required class="w-full px-3 py-1.5 text-xs border rounded-lg focus:outline-none font-bold" />
                                </div>
                                <div>
                                    <label class="block text-2xs font-semibold text-gray-600 uppercase mb-0.5">Method</label>
                                    <select v-model="paymentForm.payment_method" class="w-full px-3 py-1.5 text-xs border rounded-lg focus:outline-none bg-white">
                                        <option value="cash">Cash</option>
                                        <option value="bkash">bKash</option>
                                        <option value="nagad">Nagad</option>
                                        <option value="rocket">Rocket</option>
                                        <option value="card">Card</option>
                                    </select>
                                </div>
                                <button type="submit" :disabled="paymentForm.processing" class="w-full py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition-all">
                                    Record Payment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Upload Modal -->
            <div v-if="uploadingItem" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs">
                <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h3 class="font-bold text-gray-900 text-lg">Upload Diagnostic Report</h3>
                        <button @click="uploadingItem = null" class="text-gray-400 hover:text-gray-600">&times;</button>
                    </div>

                    <div class="p-3 bg-blue-50 text-blue-900 rounded-lg text-xs space-y-1">
                        <div><strong>Test:</strong> {{ uploadingItem.test_name }} ({{ uploadingItem.test_code }})</div>
                        <div><strong>Patient:</strong> {{ booking.patient_name }}</div>
                    </div>

                    <form @submit.prevent="submitReportUpload" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Select Report PDF File *</label>
                            <input type="file" accept=".pdf,image/*" required @change="e => uploadForm.report_file = e.target.files[0]" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Lab Technologist / Doctor Notes</label>
                            <textarea v-model="uploadForm.report_notes" rows="2" placeholder="Clinical notes, findings..." class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="uploadingItem = null" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                            <button type="submit" :disabled="uploadForm.processing" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm">
                                Save Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FlatpickrInput from '@/Components/Admin/Shared/FlatpickrInput.vue';
import { displayTranslatable } from '@/Composables/useTranslatable';

const props = defineProps({
    booking: { type: Object, required: true },
});

const langs = computed(() => usePage().props.languages ?? []);

const uploadingItem = ref(null);

const statusForm = useForm({
    status: props.booking.status,
    report_delivery_date: props.booking.report_delivery_date || '',
});

const paymentForm = useForm({
    paid_amount: props.booking.due_amount,
    payment_method: 'cash',
    transaction_id: '',
});

const uploadForm = useForm({
    report_file: null,
    report_notes: '',
});

function formatStatus(status) {
    switch (status) {
        case 'sample_collected': return 'Sample Collected';
        case 'processing':       return 'In Lab Processing';
        case 'completed':        return 'Report Ready';
        default:                 return status.charAt(0).toUpperCase() + status.slice(1);
    }
}

function statusBadge(status) {
    switch (status) {
        case 'pending':          return 'bg-amber-100 text-amber-800 border border-amber-200';
        case 'sample_collected': return 'bg-cyan-100 text-cyan-800 border border-cyan-200';
        case 'processing':       return 'bg-blue-100 text-blue-800 border border-blue-200';
        case 'completed':        return 'bg-emerald-100 text-emerald-800 border border-emerald-200';
        case 'cancelled':        return 'bg-rose-100 text-rose-800 border border-rose-200';
        default:                 return 'bg-gray-100 text-gray-700';
    }
}

function submitStatus() {
    statusForm.patch(route('admin.medical-test-bookings.update-status', props.booking.id), {
        preserveScroll: true,
    });
}

function submitPayment() {
    paymentForm.patch(route('admin.medical-test-bookings.update-payment', props.booking.id), {
        preserveScroll: true,
    });
}

function openReportUpload(item) {
    uploadingItem.value = item;
    uploadForm.reset();
    uploadForm.report_notes = item.report_notes || '';
}

function submitReportUpload() {
    if (!uploadingItem.value) return;
    uploadForm.post(route('admin.medical-test-bookings.upload-report', uploadingItem.value.id), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            uploadingItem.value = null;
            uploadForm.reset();
        }
    });
}

</script>
