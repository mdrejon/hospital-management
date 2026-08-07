<template>
    <AgentLayout>
        <div class="max-w-4xl mx-auto space-y-5">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Agent Profile & Account Settings</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Manage your contact information, security credentials, and payout accounts</p>
                </div>
                <div class="px-2.5 py-1 rounded bg-blue-50 border border-blue-200 text-blue-800 text-xs font-mono font-semibold">
                    Agent ID: {{ agent?.agent_code }}
                </div>
            </div>

            <!-- Profile Summary Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-700 font-bold text-lg flex items-center justify-center">
                        {{ user?.name?.charAt(0) || 'A' }}
                    </div>
                    <div class="space-y-0.5">
                        <div class="font-semibold text-gray-800 text-base">{{ user?.name }}</div>
                        <div class="text-xs text-gray-500 flex items-center gap-2">
                            <span>{{ user?.email }}</span>
                            <span>•</span>
                            <span>{{ agent?.phone }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-5 border-t sm:border-t-0 sm:border-l border-gray-200 pt-3 sm:pt-0 sm:pl-5 text-xs">
                    <div>
                        <div class="text-gray-400">Doctor Commission</div>
                        <div class="text-sm font-bold text-blue-600">{{ agent?.doctor_commission_rate }}%</div>
                    </div>
                    <div>
                        <div class="text-gray-400">Test Commission</div>
                        <div class="text-sm font-bold text-purple-600">{{ agent?.test_commission_rate }}%</div>
                    </div>
                    <div>
                        <div class="text-gray-400">Status</div>
                        <div class="text-xs font-semibold uppercase text-green-600">{{ agent?.status }}</div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <form @submit.prevent="submit" class="space-y-5">
                <!-- 1. Personal & Contact -->
                <div class="bg-white rounded-lg shadow-sm p-5 space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-blue-700 border-b border-gray-100 pb-2.5">
                        1. Personal Information
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Full Name *</label>
                            <input v-model="form.name" type="text" required class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                            <div v-if="form.errors.name" class="text-red-600 text-xs mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Email Address *</label>
                            <input v-model="form.email" type="email" required class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                            <div v-if="form.errors.email" class="text-red-600 text-xs mt-1">{{ form.errors.email }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Primary Mobile Phone *</label>
                            <input v-model="form.phone" type="text" required class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none font-mono" />
                            <div v-if="form.errors.phone" class="text-red-600 text-xs mt-1">{{ form.errors.phone }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">City / District</label>
                            <input v-model="form.city" type="text" placeholder="e.g. Dhaka" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Full Address</label>
                        <textarea v-model="form.address" rows="2" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none"></textarea>
                    </div>
                </div>

                <!-- 2. Payout Account Configuration -->
                <div class="bg-white rounded-lg shadow-sm p-5 space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-emerald-700 border-b border-gray-100 pb-2.5">
                        2. Cash Out & Withdrawal Payout Settings
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Payout Channel</label>
                            <select v-model="form.payout_method" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none bg-white">
                                <option value="bkash">bKash</option>
                                <option value="nagad">Nagad</option>
                                <option value="rocket">Rocket</option>
                                <option value="upay">Upay</option>
                                <option value="bank">Bank Transfer</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Account Number</label>
                            <input v-model="form.payout_account_number" type="text" placeholder="01XXXXXXXXX" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded font-mono focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Account Type</label>
                            <select v-model="form.payout_account_type" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none bg-white">
                                <option value="personal">Personal Account</option>
                                <option value="agent">Agent Account</option>
                            </select>
                        </div>
                    </div>

                    <!-- Bank details if bank selected -->
                    <div v-if="form.payout_method === 'bank'" class="p-3.5 rounded bg-gray-50 border border-gray-200 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-0.5">Bank Name</label>
                            <input v-model="form.bank_name" type="text" placeholder="e.g. Dutch-Bangla Bank" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded bg-white" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-0.5">Account Name</label>
                            <input v-model="form.bank_account_name" type="text" placeholder="Full Account Name" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded bg-white" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-0.5">Branch Name</label>
                            <input v-model="form.bank_branch" type="text" placeholder="e.g. Dhanmondi" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded bg-white" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-0.5">Routing Number</label>
                            <input v-model="form.bank_routing" type="text" placeholder="9-digit routing" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded bg-white font-mono" />
                        </div>
                    </div>
                </div>

                <!-- 3. NID & Verification -->
                <div class="bg-white rounded-lg shadow-sm p-5 space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-purple-700 border-b border-gray-100 pb-2.5">
                        3. NID Identity Verification
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">NID Number</label>
                            <input v-model="form.nid_number" type="text" placeholder="National ID number" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Upload Updated NID Document</label>
                            <input type="file" @change="e => form.nid_file = e.target.files[0]" class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                        </div>
                    </div>
                </div>

                <!-- 4. Security & Password Change -->
                <div class="bg-white rounded-lg shadow-sm p-5 space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-amber-700 border-b border-gray-100 pb-2.5">
                        4. Change Account Password (Leave blank to keep current)
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">New Password</label>
                            <input v-model="form.password" type="password" placeholder="At least 8 characters" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                            <div v-if="form.errors.password" class="text-red-600 text-xs mt-1">{{ form.errors.password }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Confirm New Password</label>
                            <input v-model="form.password_confirmation" type="password" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-2">
                    <button type="submit" :disabled="form.processing" class="px-5 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors shadow-sm disabled:opacity-50">
                        Update Agent Profile
                    </button>
                </div>
            </form>
        </div>
    </AgentLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AgentLayout from '@/Layouts/AgentLayout.vue';

const props = defineProps({
    agent: { type: Object, required: true },
    user:  { type: Object, required: true },
});

const form = useForm({
    name:                  props.user?.name || '',
    email:                 props.user?.email || '',
    phone:                 props.agent?.phone || '',
    nid_number:            props.agent?.nid_number || '',
    nid_file:              null,
    address:               props.agent?.address || '',
    city:                  props.agent?.city || '',
    payout_method:         props.agent?.payout_method || 'bkash',
    payout_account_number: props.agent?.payout_account_number || '',
    payout_account_type:   props.agent?.payout_account_type || 'personal',
    bank_name:             props.agent?.bank_details?.bank_name || '',
    bank_branch:           props.agent?.bank_details?.branch || '',
    bank_routing:          props.agent?.bank_details?.routing || '',
    bank_account_name:     props.agent?.bank_details?.account_name || '',
    password:              '',
    password_confirmation: '',
});

function submit() {
    form.post(route('agent.profile.update'), {
        forceFormData: true,
        preserveScroll: true,
    });
}
</script>
