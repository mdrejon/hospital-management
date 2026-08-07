<template>
    <div class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans">
        <div class="sm:mx-auto sm:w-full sm:max-w-xl text-center px-4">
            <Link :href="route('home')" class="inline-flex items-center gap-2 mb-4">
                <div class="w-10 h-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black text-xl shadow-lg">
                    +
                </div>
                <span class="text-xl font-black text-white tracking-tight">Modern Hospital</span>
            </Link>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                Become an Official Hospital Agent Partner
            </h2>
            <p class="mt-2 text-xs sm:text-sm text-slate-400">
                Book doctor appointments and medical tests for patients & earn attractive commissions on every booking.
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-xl px-4">
            <div class="bg-slate-800/90 backdrop-blur-md border border-slate-700/80 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                <!-- Flash error -->
                <div v-if="$page.props.flash?.error" class="p-4 rounded-xl bg-rose-950/60 border border-rose-800 text-rose-300 text-xs font-semibold">
                    {{ $page.props.flash.error }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Step 1: Personal & Account Info -->
                    <div class="space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-blue-400 flex items-center gap-2">
                            <span>1.</span> Account & Contact Details
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-300 mb-1">Full Name *</label>
                                <input v-model="form.name" type="text" required placeholder="e.g. Tanvir Ahmed" class="w-full px-3 py-2 text-xs bg-slate-900/80 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                                <div v-if="form.errors.name" class="text-rose-400 text-2xs mt-1">{{ form.errors.name }}</div>
                            </div>

                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-300 mb-1">Mobile Phone (Primary) *</label>
                                <input v-model="form.phone" type="text" required placeholder="017XXXXXXXX" class="w-full px-3 py-2 text-xs bg-slate-900/80 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                                <div v-if="form.errors.phone" class="text-rose-400 text-2xs mt-1">{{ form.errors.phone }}</div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-2xs font-bold uppercase text-slate-300 mb-1">Email Address *</label>
                            <input v-model="form.email" type="email" required placeholder="agent@example.com" class="w-full px-3 py-2 text-xs bg-slate-900/80 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            <div v-if="form.errors.email" class="text-rose-400 text-2xs mt-1">{{ form.errors.email }}</div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-300 mb-1">Password *</label>
                                <input v-model="form.password" type="password" required placeholder="At least 8 characters" class="w-full px-3 py-2 text-xs bg-slate-900/80 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                                <div v-if="form.errors.password" class="text-rose-400 text-2xs mt-1">{{ form.errors.password }}</div>
                            </div>

                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-300 mb-1">Confirm Password *</label>
                                <input v-model="form.password_confirmation" type="password" required class="w-full px-3 py-2 text-xs bg-slate-900/80 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Verification (NID & Address) -->
                    <div class="space-y-4 pt-4 border-t border-slate-700/60">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-purple-400 flex items-center gap-2">
                            <span>2.</span> Identity Verification (NID / Smart Card)
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-300 mb-1">NID / Smart Card Number</label>
                                <input v-model="form.nid_number" type="text" placeholder="10 or 17 digit NID" class="w-full px-3 py-2 text-xs bg-slate-900/80 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            </div>

                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-300 mb-1">Upload NID Copy (JPG/PNG/PDF)</label>
                                <input type="file" @change="e => form.nid_file = e.target.files[0]" class="w-full text-2xs text-slate-400 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-2xs file:font-semibold file:bg-slate-700 file:text-slate-200" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-300 mb-1">City / Region</label>
                                <input v-model="form.city" type="text" placeholder="e.g. Dhaka" class="w-full px-3 py-2 text-xs bg-slate-900/80 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            </div>
                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-300 mb-1">Address</label>
                                <input v-model="form.address" type="text" placeholder="House/Road/Area" class="w-full px-3 py-2 text-xs bg-slate-900/80 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Commission Payout Setup -->
                    <div class="space-y-4 pt-4 border-t border-slate-700/60">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-400 flex items-center gap-2">
                            <span>3.</span> Wallet Withdrawal / Payout Method
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-300 mb-1">Payout Channel</label>
                                <select v-model="form.payout_method" class="w-full px-3 py-2 text-xs bg-slate-900/80 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    <option value="bkash">bKash</option>
                                    <option value="nagad">Nagad</option>
                                    <option value="rocket">Rocket</option>
                                    <option value="upay">Upay</option>
                                    <option value="bank">Bank Transfer</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-300 mb-1">Account Number</label>
                                <input v-model="form.payout_account_number" type="text" placeholder="01XXXXXXXXX" class="w-full px-3 py-2 text-xs bg-slate-900/80 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono" />
                            </div>

                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-300 mb-1">Account Type</label>
                                <select v-model="form.payout_account_type" class="w-full px-3 py-2 text-xs bg-slate-900/80 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    <option value="personal">Personal Account</option>
                                    <option value="agent">Agent Account</option>
                                </select>
                            </div>
                        </div>

                        <!-- Bank Details (Conditional) -->
                        <div v-if="form.payout_method === 'bank'" class="p-4 rounded-2xl bg-slate-900/60 border border-slate-700/80 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-400 mb-1">Bank Name</label>
                                <input v-model="form.bank_name" type="text" placeholder="e.g. Dutch-Bangla Bank" class="w-full px-3 py-2 text-xs bg-slate-900 border border-slate-700 rounded-lg text-white" />
                            </div>
                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-400 mb-1">Account Holder Name</label>
                                <input v-model="form.bank_account_name" type="text" placeholder="Full name on account" class="w-full px-3 py-2 text-xs bg-slate-900 border border-slate-700 rounded-lg text-white" />
                            </div>
                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-400 mb-1">Branch Name</label>
                                <input v-model="form.bank_branch" type="text" placeholder="e.g. Dhanmondi" class="w-full px-3 py-2 text-xs bg-slate-900 border border-slate-700 rounded-lg text-white" />
                            </div>
                            <div>
                                <label class="block text-2xs font-bold uppercase text-slate-400 mb-1">Routing Number</label>
                                <input v-model="form.bank_routing" type="text" placeholder="9 digit routing" class="w-full px-3 py-2 text-xs bg-slate-900 border border-slate-700 rounded-lg text-white font-mono" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" :disabled="form.processing" class="w-full py-3 px-6 rounded-2xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 shadow-xl transition-all flex items-center justify-center gap-2">
                            <span v-if="form.processing">Registering Account...</span>
                            <span v-else>Complete Agent Registration & Get Started &rarr;</span>
                        </button>
                    </div>

                    <div class="text-center text-xs text-slate-400 pt-2">
                        Already have an agent or hospital staff account?
                        <Link :href="route('login')" class="text-blue-400 font-bold hover:underline ml-1">Log in here</Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    nid_number: '',
    nid_file: null,
    address: '',
    city: '',
    payout_method: 'bkash',
    payout_account_number: '',
    payout_account_type: 'personal',
    bank_name: '',
    bank_branch: '',
    bank_routing: '',
    bank_account_name: '',
});

function submit() {
    form.post(route('agent.register.submit'), {
        forceFormData: true,
    });
}
</script>
