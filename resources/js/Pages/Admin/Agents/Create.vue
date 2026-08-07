<template>
    <AdminLayout>
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Add New Agent</h1>
                    <p class="text-xs text-gray-500 mt-1">Register a new hospital booking & marketing partner</p>
                </div>
                <Link :href="route('admin.agents.index')" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-xs">
                    &larr; Back to List
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- 1. Account & Personal Info -->
                <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-blue-700 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs">1</span>
                        Basic Account Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Full Name *</label>
                            <input v-model="form.name" type="text" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="e.g. Rahim Chowdhury" />
                            <span v-if="form.errors.name" class="text-xs text-red-600">{{ form.errors.name }}</span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Email Address *</label>
                            <input v-model="form.email" type="email" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="e.g. rahim@example.com" />
                            <span v-if="form.errors.email" class="text-xs text-red-600">{{ form.errors.email }}</span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Mobile Phone *</label>
                            <input v-model="form.phone" type="text" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="e.g. 01712345678" />
                            <span v-if="form.errors.phone" class="text-xs text-red-600">{{ form.errors.phone }}</span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Login Password *</label>
                            <input v-model="form.password" type="password" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Minimum 8 characters" />
                            <span v-if="form.errors.password" class="text-xs text-red-600">{{ form.errors.password }}</span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">National ID (NID) Number</label>
                            <input v-model="form.nid_number" type="text" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="NID number" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">NID Document Upload</label>
                            <input type="file" @change="e => form.nid_file = e.target.files[0]" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Address / Location</label>
                            <input v-model="form.address" type="text" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Street address, City" />
                        </div>
                    </div>
                </div>

                <!-- 2. Commission Configuration -->
                <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-purple-700 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center text-xs">2</span>
                        Commission Structure & Account Status
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Commission Type</label>
                            <select v-model="form.commission_type" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount (BDT)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Doctor Appointment Rate</label>
                            <div class="relative">
                                <input v-model="form.doctor_commission_rate" type="number" step="0.1" min="0" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10" />
                                <span class="absolute right-3 top-2.5 text-xs text-gray-400 font-bold">{{ form.commission_type === 'percentage' ? '%' : 'BDT' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Medical Test Rate</label>
                            <div class="relative">
                                <input v-model="form.test_commission_rate" type="number" step="0.1" min="0" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10" />
                                <span class="absolute right-3 top-2.5 text-xs text-gray-400 font-bold">{{ form.commission_type === 'percentage' ? '%' : 'BDT' }}</span>
                            </div>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Account Status</label>
                            <select v-model="form.status" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                <option value="active">Active (Can book & earn immediately)</option>
                                <option value="pending">Pending Approval</option>
                                <option value="inactive">Inactive / Suspended</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 3. Default Payout Method -->
                <div class="bg-white rounded-xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-emerald-700 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">3</span>
                        Default Payout / Cash-Out Details
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Payout Method</label>
                            <select v-model="form.payout_method" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                <option value="bkash">bKash</option>
                                <option value="nagad">Nagad</option>
                                <option value="rocket">Rocket</option>
                                <option value="upay">Upay</option>
                                <option value="bank">Bank Transfer</option>
                            </select>
                        </div>

                        <div v-if="form.payout_method !== 'bank'">
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Mobile Banking Number</label>
                            <input v-model="form.payout_account_number" type="text" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="01XXXXXXXXX" />
                        </div>

                        <div v-if="form.payout_method !== 'bank'">
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Account Type</label>
                            <select v-model="form.payout_account_type" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                <option value="personal">Personal Account</option>
                                <option value="agent">Agent Account</option>
                            </select>
                        </div>
                    </div>

                    <!-- Bank Details if Bank Transfer Selected -->
                    <div v-if="form.payout_method === 'bank'" class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Bank Name</label>
                            <input v-model="form.bank_name" type="text" class="w-full px-3 py-2 text-sm border rounded-lg bg-white focus:outline-none" placeholder="e.g. Islami Bank Bangladesh" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Branch Name</label>
                            <input v-model="form.bank_branch" type="text" class="w-full px-3 py-2 text-sm border rounded-lg bg-white focus:outline-none" placeholder="e.g. Dhanmondi Branch" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Routing Number</label>
                            <input v-model="form.bank_routing" type="text" class="w-full px-3 py-2 text-sm border rounded-lg bg-white focus:outline-none" placeholder="e.g. 125272828" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Account Name & Number</label>
                            <input v-model="form.bank_account_name" type="text" class="w-full px-3 py-2 text-sm border rounded-lg bg-white focus:outline-none" placeholder="Account Name / A/C No" />
                        </div>
                    </div>
                </div>

                <!-- Submit buttons -->
                <div class="flex items-center justify-end gap-3 pt-4">
                    <Link :href="route('admin.agents.index')" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">
                        Cancel
                    </Link>
                    <button type="submit" :disabled="form.processing" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 shadow-sm transition-all flex items-center gap-2">
                        <svg v-if="form.processing" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                        Create Agent Account
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    nid_number: '',
    nid_file: null,
    address: '',
    commission_type: 'percentage',
    doctor_commission_rate: 10.0,
    test_commission_rate: 15.0,
    status: 'active',
    payout_method: 'bkash',
    payout_account_number: '',
    payout_account_type: 'personal',
    bank_name: '',
    bank_branch: '',
    bank_routing: '',
    bank_account_name: '',
});

function submit() {
    form.post(route('admin.agents.store'), {
        forceFormData: true,
    });
}
</script>
