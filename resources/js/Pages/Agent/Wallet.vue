<template>
    <AgentLayout>
        <div class="space-y-5">
            <!-- Header & Action -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Wallet & Cash Out Management</h1>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Track commissions, request cash outs to bKash / Nagad / Rocket / Bank, and view complete transaction ledger.
                    </p>
                </div>
                <button 
                    @click="openWithdrawModal" 
                    :disabled="agent.wallet_balance < minWithdrawalAmount"
                    class="px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-md shadow-sm transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span>💵</span> Request Cash Out
                </button>
            </div>

            <!-- Financial Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- 1. Available Balance -->
                <div class="rounded-lg p-5 text-white bg-emerald-600 flex flex-col justify-between shadow-sm">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-emerald-100">Available Wallet Balance</p>
                        <p class="text-2xl font-bold leading-tight mt-1">BDT {{ Number(agent.wallet_balance).toLocaleString() }}</p>
                    </div>
                    <div class="pt-3 mt-3 border-t border-emerald-500/50 flex items-center justify-between text-xs text-emerald-100">
                        <span>Min: BDT {{ minWithdrawalAmount }}</span>
                        <button v-if="agent.wallet_balance >= minWithdrawalAmount" @click="openWithdrawModal" class="underline font-semibold hover:text-white">Cash Out &rarr;</button>
                    </div>
                </div>

                <!-- 2. Lifetime Earned -->
                <div class="rounded-lg p-5 text-white bg-blue-600 flex flex-col justify-between shadow-sm">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-blue-100">Total Lifetime Earnings</p>
                        <p class="text-2xl font-bold leading-tight mt-1">BDT {{ Number(agent.total_earned_commission).toLocaleString() }}</p>
                    </div>
                    <div class="pt-3 mt-3 border-t border-blue-500/50 flex items-center justify-between text-xs text-blue-100">
                        <span>Pending:</span>
                        <strong class="font-mono">BDT {{ Number(stats.pending_commissions || 0).toLocaleString() }}</strong>
                    </div>
                </div>

                <!-- 3. Total Withdrawn -->
                <div class="rounded-lg p-5 text-white bg-indigo-600 flex flex-col justify-between shadow-sm">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-indigo-100">Total Paid Out</p>
                        <p class="text-2xl font-bold leading-tight mt-1">BDT {{ Number(agent.total_withdrawn_commission).toLocaleString() }}</p>
                    </div>
                    <div class="pt-3 mt-3 border-t border-indigo-500/50 flex items-center justify-between text-xs text-indigo-100">
                        <span>In Queue:</span>
                        <strong class="font-mono">BDT {{ Number(stats.pending_withdrawals_sum || 0).toLocaleString() }}</strong>
                    </div>
                </div>

                <!-- 4. Commission Rates -->
                <div class="rounded-lg p-5 bg-white border border-gray-200 flex flex-col justify-between shadow-sm">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Your Commission Rates</p>
                        <div class="mt-2 space-y-1 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">🩺 Doctor Booking:</span>
                                <span class="font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ agent.doctor_commission_rate }}{{ agent.commission_type === 'percentage' ? '%' : ' BDT' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">🔬 Medical Test:</span>
                                <span class="font-bold text-purple-600 bg-purple-50 px-2 py-0.5 rounded">{{ agent.test_commission_rate }}{{ agent.commission_type === 'percentage' ? '%' : ' BDT' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 pt-2 mt-2 border-t border-gray-100">
                        Default Payout: <strong class="text-gray-700 capitalize">{{ agent.payout_method || 'bKash' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Tabbed Main Container: 1. Commissions Breakdown, 2. Cash Out Requests, 3. Ledger -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <!-- Navigation Tabs -->
                <div class="flex items-center gap-6 px-6 pt-3 border-b border-gray-200 text-xs">
                    <button 
                        @click="activeTab = 'commissions'" 
                        :class="activeTab === 'commissions' ? 'text-blue-600 border-blue-600 font-semibold' : 'text-gray-500 border-transparent hover:text-gray-700'"
                        class="pb-3 border-b-2 uppercase tracking-wider transition-colors whitespace-nowrap flex items-center gap-2"
                    >
                        <span>📊</span> Commissions Earned ({{ commissions?.total || 0 }})
                    </button>
                    <button 
                        @click="activeTab = 'withdrawals'" 
                        :class="activeTab === 'withdrawals' ? 'text-blue-600 border-blue-600 font-semibold' : 'text-gray-500 border-transparent hover:text-gray-700'"
                        class="pb-3 border-b-2 uppercase tracking-wider transition-colors whitespace-nowrap flex items-center gap-2"
                    >
                        <span>💵</span> Cash Out Requests ({{ withdrawals?.total || 0 }})
                    </button>
                    <button 
                        @click="activeTab = 'ledger'" 
                        :class="activeTab === 'ledger' ? 'text-blue-600 border-blue-600 font-semibold' : 'text-gray-500 border-transparent hover:text-gray-700'"
                        class="pb-3 border-b-2 uppercase tracking-wider transition-colors whitespace-nowrap flex items-center gap-2"
                    >
                        <span>📑</span> Complete Ledger ({{ transactions?.total || 0 }})
                    </button>
                </div>

                <!-- 1. COMMISSIONS BREAKDOWN TAB -->
                <div v-if="activeTab === 'commissions'">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-600">
                            <thead class="bg-gray-50 text-xs font-semibold text-gray-600 border-b border-gray-200">
                                <tr>
                                    <th class="px-5 py-3">Booking / Reference</th>
                                    <th class="px-5 py-3">Service Type</th>
                                    <th class="px-5 py-3">Details & Remarks</th>
                                    <th class="px-5 py-3">Rate Applied</th>
                                    <th class="px-5 py-3 text-right">Commission Earned</th>
                                    <th class="px-5 py-3 text-center">Status</th>
                                    <th class="px-5 py-3 text-right">Credited Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="com in commissions?.data || []" :key="com.id" class="hover:bg-gray-50">
                                    <td class="px-5 py-3.5 font-mono font-semibold text-gray-800">
                                        {{ com.booking_reference || ('#' + com.source_id) }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span 
                                            :class="com.source_type === 'appointment' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-purple-50 text-purple-700 border-purple-200'"
                                            class="px-2 py-0.5 rounded text-2xs font-semibold uppercase border inline-flex items-center gap-1"
                                        >
                                            <span>{{ com.source_type === 'appointment' ? '🩺' : '🔬' }}</span>
                                            {{ com.source_type === 'appointment' ? 'Doctor Booking' : 'Medical Test' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-700 max-w-xs truncate">
                                        {{ com.notes || '—' }}
                                    </td>
                                    <td class="px-5 py-3.5 font-medium text-gray-700">
                                        {{ com.commission_rate }}%
                                    </td>
                                    <td class="px-5 py-3.5 text-right font-mono font-bold text-emerald-600">
                                        +BDT {{ Number(com.amount).toLocaleString() }}
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <span :class="commissionStatusBadge(com.status)" class="px-2 py-0.5 rounded-full text-2xs font-semibold uppercase">
                                            {{ com.status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right text-gray-400">
                                        {{ com.credited_at ? new Date(com.credited_at).toLocaleString() : (new Date(com.created_at).toLocaleString()) }}
                                    </td>
                                </tr>
                                <tr v-if="!commissions?.data || commissions.data.length === 0">
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                        <div class="text-2xl mb-1">🏷️</div>
                                        <div class="font-medium text-gray-600">No commissions recorded yet.</div>
                                        <div class="text-xs text-gray-400 mt-0.5">Book doctor appointments or medical tests to start earning commissions!</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="commissions?.links?.length > 3" class="p-3.5 border-t border-gray-100 flex justify-center gap-1">
                        <Link 
                            v-for="(link, i) in commissions.links" 
                            :key="i" 
                            :href="link.url || '#'" 
                            :class="[link.active ? 'bg-blue-600 text-white font-semibold' : 'text-gray-600 hover:bg-gray-100', !link.url ? 'opacity-40 cursor-not-allowed' : '']" 
                            class="px-3 py-1 rounded text-xs" 
                            v-html="link.label"
                        />
                    </div>
                </div>

                <!-- 2. CASH OUT REQUESTS TAB -->
                <div v-if="activeTab === 'withdrawals'">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-600">
                            <thead class="bg-gray-50 text-xs font-semibold text-gray-600 border-b border-gray-200">
                                <tr>
                                    <th class="px-5 py-3">Withdrawal ID</th>
                                    <th class="px-5 py-3">Cash Out Amount</th>
                                    <th class="px-5 py-3">Payment Channel</th>
                                    <th class="px-5 py-3">Recipient Details</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Admin Note / TrxID</th>
                                    <th class="px-5 py-3 text-right">Requested At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="wd in withdrawals?.data || []" :key="wd.id" class="hover:bg-gray-50">
                                    <td class="px-5 py-3.5 font-mono font-semibold text-gray-800">#{{ wd.withdrawal_number }}</td>
                                    <td class="px-5 py-3.5 font-mono font-bold text-gray-900">
                                        BDT {{ Number(wd.amount).toLocaleString() }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span :class="payoutMethodBadge(wd.payout_method)" class="px-2 py-0.5 rounded font-semibold uppercase text-2xs border inline-flex items-center gap-1">
                                            <span>{{ payoutMethodIcon(wd.payout_method) }}</span>
                                            {{ wd.payout_method }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-xs">
                                        <div class="font-mono font-medium text-gray-800">{{ wd.account_number }}</div>
                                        <div class="text-2xs text-gray-400 capitalize">Type: {{ wd.account_type || 'Personal' }}</div>
                                        <div v-if="wd.bank_details" class="text-2xs text-gray-500 mt-0.5">
                                            {{ wd.bank_details.bank_name }} - {{ wd.bank_details.branch }} ({{ wd.bank_details.account_name }})
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span :class="withdrawalStatusBadge(wd.status)" class="px-2 py-0.5 rounded-full text-2xs font-semibold uppercase">
                                            {{ wd.status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-xs text-gray-500 max-w-xs">
                                        <div v-if="wd.transaction_id" class="font-mono text-2xs text-emerald-700 font-bold">
                                            TrxID: {{ wd.transaction_id }}
                                        </div>
                                        <div class="text-gray-600">{{ wd.admin_notes || '—' }}</div>
                                    </td>
                                    <td class="px-5 py-3.5 text-right text-gray-400">
                                        {{ new Date(wd.created_at).toLocaleString() }}
                                    </td>
                                </tr>
                                <tr v-if="!withdrawals?.data || withdrawals.data.length === 0">
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                        <div class="text-2xl mb-1">💸</div>
                                        <div class="font-medium text-gray-600">No cash out requests submitted yet.</div>
                                        <div class="text-xs text-gray-400 mt-0.5">Once you have at least BDT {{ minWithdrawalAmount }} in your wallet, you can submit cash out requests!</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="withdrawals?.links?.length > 3" class="p-3.5 border-t border-gray-100 flex justify-center gap-1">
                        <Link 
                            v-for="(link, i) in withdrawals.links" 
                            :key="i" 
                            :href="link.url || '#'" 
                            :class="[link.active ? 'bg-blue-600 text-white font-semibold' : 'text-gray-600 hover:bg-gray-100', !link.url ? 'opacity-40 cursor-not-allowed' : '']" 
                            class="px-3 py-1 rounded text-xs" 
                            v-html="link.label"
                        />
                    </div>
                </div>

                <!-- 3. COMPLETE WALLET LEDGER TAB -->
                <div v-if="activeTab === 'ledger'">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-600">
                            <thead class="bg-gray-50 text-xs font-semibold text-gray-600 border-b border-gray-200">
                                <tr>
                                    <th class="px-5 py-3">Transaction Type</th>
                                    <th class="px-5 py-3">Description</th>
                                    <th class="px-5 py-3 text-right">Amount</th>
                                    <th class="px-5 py-3 text-right">Balance Before</th>
                                    <th class="px-5 py-3 text-right">Balance After</th>
                                    <th class="px-5 py-3 text-right">Date & Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="tx in transactions?.data || []" :key="tx.id" class="hover:bg-gray-50">
                                    <td class="px-5 py-3.5">
                                        <span 
                                            :class="tx.type.includes('credit') || tx.type.includes('refund') ? 'text-emerald-700 bg-emerald-50 border-emerald-200' : 'text-rose-700 bg-rose-50 border-rose-200'" 
                                            class="px-2 py-0.5 rounded-full font-semibold uppercase text-2xs border"
                                        >
                                            {{ tx.type.replace('_', ' ') }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 font-medium text-gray-800">{{ tx.description }}</td>
                                    <td class="px-5 py-3.5 text-right font-mono font-bold" :class="tx.type.includes('credit') || tx.type.includes('refund') ? 'text-emerald-600' : 'text-rose-600'">
                                        {{ tx.type.includes('credit') || tx.type.includes('refund') ? '+' : '-' }}BDT {{ Number(tx.amount).toLocaleString() }}
                                    </td>
                                    <td class="px-5 py-3.5 text-right font-mono text-gray-500">BDT {{ Number(tx.balance_before).toLocaleString() }}</td>
                                    <td class="px-5 py-3.5 text-right font-mono font-semibold text-gray-800">BDT {{ Number(tx.balance_after).toLocaleString() }}</td>
                                    <td class="px-5 py-3.5 text-right text-gray-400">{{ new Date(tx.created_at).toLocaleString() }}</td>
                                </tr>
                                <tr v-if="!transactions?.data || transactions.data.length === 0">
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                        <div class="text-2xl mb-1">📑</div>
                                        No ledger transactions recorded yet.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="transactions?.links?.length > 3" class="p-3.5 border-t border-gray-100 flex justify-center gap-1">
                        <Link 
                            v-for="(link, i) in transactions.links" 
                            :key="i" 
                            :href="link.url || '#'" 
                            :class="[link.active ? 'bg-blue-600 text-white font-semibold' : 'text-gray-600 hover:bg-gray-100', !link.url ? 'opacity-40 cursor-not-allowed' : '']" 
                            class="px-3 py-1 rounded text-xs" 
                            v-html="link.label"
                        />
                    </div>
                </div>
            </div>

            <!-- CASH OUT / WITHDRAWAL REQUEST MODAL -->
            <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40">
                <div class="bg-white rounded-lg max-w-lg w-full p-6 shadow-xl space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-base font-bold">💵</span>
                            <div>
                                <h3 class="font-semibold text-gray-800 text-sm">Request Cash Out</h3>
                                <p class="text-xs text-gray-400">Available: <strong class="text-emerald-700">BDT {{ Number(agent.wallet_balance).toLocaleString() }}</strong></p>
                            </div>
                        </div>
                        <button @click="showModal = false" class="w-7 h-7 rounded hover:bg-gray-100 text-gray-400 hover:text-gray-600 text-lg flex items-center justify-center">&times;</button>
                    </div>

                    <form @submit.prevent="submitWithdrawal" class="space-y-4">
                        <!-- Amount Input & Quick Chips -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="text-xs font-semibold text-gray-700">Withdrawal Amount (BDT) *</label>
                                <span class="text-xs text-gray-400">Min: BDT {{ minWithdrawalAmount }}</span>
                            </div>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-400 font-semibold text-xs">BDT</span>
                                <input 
                                    v-model="withdrawForm.amount" 
                                    type="number" 
                                    :min="minWithdrawalAmount" 
                                    :max="agent.wallet_balance" 
                                    step="0.01" 
                                    required 
                                    class="w-full pl-12 pr-3 py-1.5 text-sm font-semibold border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none" 
                                />
                            </div>
                            <!-- Quick Chips -->
                            <div class="flex items-center gap-2 mt-2">
                                <button 
                                    v-for="preset in [500, 1000, 2000]" 
                                    :key="preset" 
                                    v-show="agent.wallet_balance >= preset"
                                    type="button" 
                                    @click="withdrawForm.amount = preset" 
                                    class="px-2 py-0.5 rounded bg-gray-100 hover:bg-gray-200 text-xs font-medium text-gray-700 transition-colors"
                                >
                                    BDT {{ preset }}
                                </button>
                                <button 
                                    type="button" 
                                    @click="withdrawForm.amount = agent.wallet_balance" 
                                    class="px-2 py-0.5 rounded bg-emerald-50 hover:bg-emerald-100 text-xs font-semibold text-emerald-700 transition-colors"
                                >
                                    Max (BDT {{ Number(agent.wallet_balance).toLocaleString() }})
                                </button>
                            </div>
                            <div v-if="withdrawForm.errors.amount" class="text-red-600 text-xs mt-1">{{ withdrawForm.errors.amount }}</div>
                        </div>

                        <!-- Bangladeshi Payment Methods Selector -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Select Payout Channel *</label>
                            <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                                <button 
                                    v-for="method in paymentMethods" 
                                    :key="method.id"
                                    type="button" 
                                    @click="withdrawForm.payout_method = method.id"
                                    :class="withdrawForm.payout_method === method.id ? 'border-2 border-blue-600 bg-blue-50 font-semibold' : 'border border-gray-200 hover:bg-gray-50'"
                                    class="p-2 rounded flex flex-col items-center justify-center text-center transition-all"
                                >
                                    <span class="text-base mb-0.5">{{ method.icon }}</span>
                                    <span class="text-xs text-gray-800">{{ method.name }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Mobile Banking Fields (bKash, Nagad, Rocket, Upay) -->
                        <div v-if="withdrawForm.payout_method !== 'bank'" class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-3 rounded bg-gray-50 border border-gray-200">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">
                                    {{ withdrawForm.payout_method.toUpperCase() }} Account Number *
                                </label>
                                <input 
                                    v-model="withdrawForm.account_number" 
                                    type="text" 
                                    required 
                                    placeholder="01XXXXXXXXX" 
                                    class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded font-mono bg-white focus:ring-1 focus:ring-blue-500 focus:outline-none" 
                                />
                                <div v-if="withdrawForm.errors.account_number" class="text-red-600 text-xs mt-1">{{ withdrawForm.errors.account_number }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Account Type *</label>
                                <select v-model="withdrawForm.account_type" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded bg-white focus:ring-1 focus:ring-blue-500 focus:outline-none">
                                    <option value="personal">Personal Account</option>
                                    <option value="agent">Agent Account</option>
                                </select>
                            </div>
                        </div>

                        <!-- Bank Transfer Fields -->
                        <div v-if="withdrawForm.payout_method === 'bank'" class="p-3 rounded bg-gray-50 border border-gray-200 space-y-2">
                            <div class="text-xs font-semibold text-gray-500">Bank Account Details</div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-0.5">Bank Name *</label>
                                    <input v-model="withdrawForm.bank_name" type="text" placeholder="e.g. Dutch-Bangla Bank" required class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded bg-white" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-0.5">Account Holder Name *</label>
                                    <input v-model="withdrawForm.account_name" type="text" placeholder="Full name on account" required class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded bg-white" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-0.5">Bank Account Number *</label>
                                    <input v-model="withdrawForm.account_number" type="text" placeholder="1234567890" required class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded bg-white font-mono" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-0.5">Branch Name</label>
                                    <input v-model="withdrawForm.bank_branch" type="text" placeholder="e.g. Dhanmondi Branch" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded bg-white" />
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-0.5">Routing Number (Optional)</label>
                                <input v-model="withdrawForm.bank_routing" type="text" placeholder="9-digit routing" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded bg-white font-mono" />
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                            <button type="button" @click="showModal = false" class="px-3.5 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded transition-colors">
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                :disabled="withdrawForm.processing || agent.wallet_balance < minWithdrawalAmount" 
                                class="px-4 py-1.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded transition-colors disabled:opacity-50"
                            >
                                <span v-if="withdrawForm.processing">Submitting...</span>
                                <span v-else>Confirm & Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AgentLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AgentLayout from '@/Layouts/AgentLayout.vue';

const props = defineProps({
    agent: {
        type: Object,
        required: true
    },
    commissions: {
        type: Object,
        default: () => ({ data: [], total: 0, links: [] })
    },
    withdrawals: {
        type: Object,
        default: () => ({ data: [], total: 0, links: [] })
    },
    transactions: {
        type: Object,
        default: () => ({ data: [], total: 0, links: [] })
    },
    stats: {
        type: Object,
        default: () => ({
            pending_commissions: 0,
            pending_withdrawals_sum: 0,
        })
    },
    minWithdrawalAmount: {
        type: Number,
        default: 100
    }
});

const activeTab = ref('commissions');
const showModal = ref(false);

const paymentMethods = [
    { id: 'bkash',  name: 'bKash',  icon: '📱' },
    { id: 'nagad',  name: 'Nagad',  icon: '💳' },
    { id: 'rocket', name: 'Rocket', icon: '🚀' },
    { id: 'upay',   name: 'Upay',   icon: '⚡' },
    { id: 'bank',   name: 'Bank',   icon: '🏦' }
];

const withdrawForm = useForm({
    amount: props.minWithdrawalAmount,
    payout_method: props.agent.payout_method || 'bkash',
    account_number: props.agent.payout_account_number || '',
    account_type: props.agent.payout_account_type || 'personal',
    bank_name: props.agent.bank_details?.bank_name || '',
    account_name: props.agent.bank_details?.account_name || '',
    bank_branch: props.agent.bank_details?.branch || '',
    bank_routing: props.agent.bank_details?.routing_number || ''
});

function openWithdrawModal() {
    withdrawForm.payout_method = props.agent.payout_method || 'bkash';
    withdrawForm.account_number = props.agent.payout_account_number || '';
    withdrawForm.account_type = props.agent.payout_account_type || 'personal';
    if (props.agent.bank_details) {
        withdrawForm.bank_name = props.agent.bank_details.bank_name || '';
        withdrawForm.account_name = props.agent.bank_details.account_name || '';
        withdrawForm.bank_branch = props.agent.bank_details.branch || '';
        withdrawForm.bank_routing = props.agent.bank_details.routing_number || '';
    }
    showModal.value = true;
}

function submitWithdrawal() {
    withdrawForm.post(route('agent.wallet.withdraw'), {
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = false;
            activeTab.value = 'withdrawals';
        }
    });
}

function commissionStatusBadge(status) {
    const s = String(status || '').toLowerCase();
    if (s === 'credited' || s === 'approved') return 'bg-green-100 text-green-700';
    if (s === 'pending') return 'bg-amber-100 text-amber-700';
    if (s === 'cancelled' || s === 'reversed') return 'bg-red-100 text-red-700';
    return 'bg-gray-100 text-gray-700';
}

function withdrawalStatusBadge(status) {
    const s = String(status || '').toLowerCase();
    if (s === 'approved') return 'bg-green-100 text-green-700';
    if (s === 'pending') return 'bg-amber-100 text-amber-700';
    if (s === 'processing') return 'bg-blue-100 text-blue-700';
    if (s === 'rejected') return 'bg-red-100 text-red-700';
    return 'bg-gray-100 text-gray-700';
}

function payoutMethodBadge(method) {
    const m = String(method || '').toLowerCase();
    if (m === 'bkash') return 'bg-pink-50 text-pink-700 border-pink-200';
    if (m === 'nagad') return 'bg-orange-50 text-orange-700 border-orange-200';
    if (m === 'rocket') return 'bg-purple-50 text-purple-700 border-purple-200';
    if (m === 'bank') return 'bg-blue-50 text-blue-700 border-blue-200';
    return 'bg-gray-50 text-gray-700 border-gray-200';
}

function payoutMethodIcon(method) {
    const m = String(method || '').toLowerCase();
    if (m === 'bkash') return '📱';
    if (m === 'nagad') return '💳';
    if (m === 'rocket') return '🚀';
    if (m === 'bank') return '🏦';
    return '⚡';
}
</script>
