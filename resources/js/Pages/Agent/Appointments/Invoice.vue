<template>
    <div class="invoice-container">
        <!-- Action Buttons (Hidden when printing) -->
        <div class="no-print actions">
            <button @click="printInvoice" class="btn btn-primary">
                Print Invoice
            </button>
            <button @click="closeTab" class="btn btn-secondary">
                Close
            </button>
        </div>

        <!-- Invoice Paper -->
        <div class="invoice">
            <!-- Header -->
            <div class="header">
                <div class="logo">
                    <!-- Usually you'd use a real logo here, but text is safe -->
                    <h1>Sitakund Modern Hospital Ltd.</h1>
                    <p>36D Street Brooklyn, New York</p>
                    <p>Phone: +1 (234) 5688 9990</p>
                </div>
                <div class="invoice-details">
                    <h2>APPOINTMENT SLIP</h2>
                    <p><strong>Appointment ID:</strong> #{{ booking.id }}</p>
                    <p><strong>Date:</strong> {{ new Date(booking.created_at).toLocaleDateString() }}</p>
                    <p><strong>Status:</strong> <span class="status">{{ booking.status.toUpperCase() }}</span></p>
                </div>
            </div>

            <!-- Patient & Doctor Info -->
            <div class="info-section">
                <div class="patient-info">
                    <h3>Patient Details</h3>
                    <p><strong>Name:</strong> {{ booking.name }}</p>
                    <p><strong>Phone:</strong> {{ booking.phone || 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ booking.email || 'N/A' }}</p>
                </div>
                <div class="doctor-info">
                    <h3>Appointment Details</h3>
                    <p>
                        <strong>Doctor:</strong>
                        <span v-if="booking.doctor">Dr. {{ displayTranslatable(booking.doctor.name, langs) }}</span>
                        <span v-else-if="booking.preferred_doctor">{{ booking.preferred_doctor }}</span>
                        <span v-else>N/A</span>
                    </p>
                    <p>
                        <strong>Date & Time:</strong>
                        {{ booking.appointment_date || booking.preferred_date || 'N/A' }}
                        {{ booking.time_slot ? 'at ' + booking.time_slot : '' }}
                    </p>
                    <p v-if="booking.agent">
                        <strong>Agent:</strong> {{ booking.agent.user?.name }} ({{ booking.agent.agent_code }})
                    </p>
                </div>
            </div>

            <!-- Items Table -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th class="text-left">Description</th>
                        <th class="text-right">Price (BDT)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left">
                            <strong>Doctor Consultation Fee</strong>
                            <div v-if="booking.doctor?.specialization" style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">
                                Specialization: {{ displayTranslatable(booking.doctor.specialization.name, langs) }}
                            </div>
                            <div v-else-if="booking.department" style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">
                                Department: {{ booking.department }}
                            </div>
                        </td>
                        <td class="text-right">{{ Number(booking.fee || 0).toLocaleString() }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Financials -->
            <div class="totals-section">
                <div class="notes">
                    <p><strong>Notes:</strong></p>
                    <p>{{ booking.notes || 'No additional notes.' }}</p>
                </div>
                <div class="totals">
                    <div class="total-row grand-total">
                        <span>Consultation Fee:</span>
                        <span>BDT {{ Number(booking.fee || 0).toLocaleString() }}</span>
                    </div>
                    <div class="total-row paid">
                        <span>Paid Amount:</span>
                        <span>BDT {{ Number(booking.paid_amount || 0).toLocaleString() }}</span>
                    </div>
                    <div class="total-row due" :class="{'text-emerald-600': dueAmount === 0}">
                        <span>Due Balance:</span>
                        <span>BDT {{ Number(dueAmount).toLocaleString() }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>Thank you for choosing Sitakund Modern Hospital.</p>
                <p>This is a computer-generated invoice and requires no signature.</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { displayTranslatable } from '@/Composables/useTranslatable';

const props = defineProps({
    booking: { type: Object, required: true },
});

const langs = computed(() => usePage().props.languages ?? []);

const dueAmount = computed(() => {
    return Math.max(0, (props.booking.fee || 0) - (props.booking.paid_amount || 0));
});

function printInvoice() {
    window.print();
}

function closeTab() {
    window.close();
}

onMounted(() => {
    // Automatically trigger print popup when the page loads
    setTimeout(() => {
        window.print();
    }, 500);
});
</script>

<style scoped>
/* Reset and base styles for invoice */
.invoice-container {
    background-color: #f3f4f6;
    min-height: 100vh;
    padding: 2rem;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    color: #374151;
}

.actions {
    max-width: 800px;
    margin: 0 auto 1rem auto;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    font-size: 0.875rem;
    transition: opacity 0.2s;
}
.btn:hover { opacity: 0.9; }
.btn-primary { background-color: #2563eb; color: white; }
.btn-secondary { background-color: #e5e7eb; color: #4b5563; }

.invoice {
    max-width: 800px;
    margin: 0 auto;
    background: #ffffff;
    padding: 3rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.header {
    display: flex;
    justify-content: space-between;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 1.5rem;
    margin-bottom: 1.5rem;
}

.logo h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #111827;
    margin: 0 0 0.5rem 0;
}
.logo p { margin: 0; font-size: 0.875rem; color: #6b7280; }

.invoice-details { text-align: right; }
.invoice-details h2 { margin: 0 0 0.5rem 0; font-size: 1.5rem; color: #2563eb; letter-spacing: 0.05em; }
.invoice-details p { margin: 0.25rem 0; font-size: 0.875rem; }
.status {
    background: #fef3c7; color: #92400e; padding: 0.125rem 0.375rem; border-radius: 0.25rem; font-weight: 600; font-size: 0.75rem;
}

.info-section {
    display: flex;
    justify-content: space-between;
    margin-bottom: 2rem;
    gap: 2rem;
}

.patient-info, .doctor-info {
    flex: 1;
}
.patient-info h3, .doctor-info h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 0.5rem;
    margin-bottom: 0.75rem;
    text-transform: uppercase;
}
.patient-info p, .doctor-info p {
    margin: 0.25rem 0;
    font-size: 0.875rem;
}
.capitalize { text-transform: capitalize; }

.items-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 2rem;
}
.items-table th {
    background-color: #f9fafb;
    color: #4b5563;
    font-size: 0.75rem;
    text-transform: uppercase;
    font-weight: 700;
    padding: 0.75rem;
    border-bottom: 2px solid #e5e7eb;
}
.items-table td {
    padding: 1rem 0.75rem;
    font-size: 0.875rem;
    border-bottom: 1px solid #e5e7eb;
}
.text-left { text-align: left; }
.text-center { text-align: center; }
.text-right { text-align: right; }

.totals-section {
    display: flex;
    justify-content: space-between;
    margin-bottom: 3rem;
}
.notes {
    flex: 1;
    padding-right: 2rem;
    font-size: 0.875rem;
    color: #6b7280;
}
.totals {
    flex: 1;
    max-width: 300px;
}
.total-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    font-size: 0.875rem;
}
.total-row.discount { color: #059669; }
.total-row.grand-total {
    font-weight: 800;
    font-size: 1.125rem;
    color: #111827;
    border-top: 2px solid #e5e7eb;
    border-bottom: 2px solid #e5e7eb;
    padding: 0.75rem 0;
    margin: 0.5rem 0;
}
.total-row.due {
    font-weight: 700;
    color: #dc2626;
}
.text-emerald-600 {
    color: #059669 !important;
}

.footer {
    text-align: center;
    color: #9ca3af;
    font-size: 0.75rem;
    border-top: 1px solid #e5e7eb;
    padding-top: 1rem;
}
.footer p { margin: 0.25rem 0; }

/* Print-specific styles */
@media print {
    .invoice-container {
        padding: 0;
        background-color: white;
    }
    .no-print {
        display: none !important;
    }
    .invoice {
        box-shadow: none;
        padding: 0;
        width: 100%;
        max-width: 100%;
    }
    body {
        margin: 0;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}
</style>
