<template>
    <header class="flex items-center justify-between h-14 px-4 bg-white border-b border-gray-200 shadow-sm flex-shrink-0">
        <!-- Hamburger / sidebar toggle -->
        <button
            class="p-1.5 rounded text-gray-500 hover:bg-gray-100"
            @click="$emit('toggle-sidebar')"
        >
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <line x1="3" y1="6"  x2="21" y2="6"  stroke-width="2" stroke-linecap="round"/>
                <line x1="3" y1="12" x2="21" y2="12" stroke-width="2" stroke-linecap="round"/>
                <line x1="3" y1="18" x2="21" y2="18" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>

        <!-- Right actions -->
        <div class="flex items-center gap-2.5 sm:gap-3">
            <!-- Quick Booking Actions -->
            <Link
                :href="route('agent.doctor.create')"
                class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors"
            >
                <span>+ Doctor Booking</span>
            </Link>

            <Link
                :href="route('agent.test.create')"
                class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors"
            >
                <span>+ Medical Test</span>
            </Link>

            <!-- Wallet Balance Badge -->
            <Link
                :href="route('agent.wallet.index')"
                class="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-xs font-bold hover:bg-emerald-100 transition-colors"
                title="View Wallet & Cash Out"
            >
                <span class="text-xs uppercase font-medium text-emerald-600">Balance:</span>
                <span>BDT {{ Number(walletBalance).toLocaleString() }}</span>
            </Link>

            <!-- View Site -->
            <a
                :href="route('home')"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-gray-500 hover:bg-gray-100"
                title="Go to Home (opens in a new tab)"
            >
                <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                <span class="hidden sm:block text-sm font-medium">Go to Home</span>
            </a>

            <!-- Dark mode toggle -->
            <button
                class="p-1.5 rounded-full text-gray-500 hover:bg-gray-100"
                @click="toggleDark"
                :title="isDark ? 'Light mode' : 'Dark mode'"
            >
                <svg v-if="isDark" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="5"/>
                    <line x1="12" y1="1"  x2="12" y2="3"/>
                    <line x1="12" y1="21" x2="12" y2="23"/>
                    <line x1="4.22" y1="4.22"   x2="5.64"  "y2="5.64"/>
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                    <line x1="1"  y1="12" x2="3"  y2="12"/>
                    <line x1="21" y1="12" x2="23" y2="12"/>
                    <line x1="4.22" y1="19.78" x2="5.64"  y2="18.36"/>
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                </svg>
                <svg v-else class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
            </button>

            <!-- User avatar / dropdown -->
            <div class="relative" ref="dropdownRef">
                <button class="flex items-center gap-2" @click="userMenuOpen = !userMenuOpen">
                    <img
                        :src="avatarUrl"
                        :alt="userName"
                        class="w-8 h-8 rounded-full"
                    />
                    <span class="hidden sm:block text-sm font-medium text-gray-700 max-w-[120px] truncate">{{ userName }}</span>
                </button>

                <!-- Dropdown -->
                <div
                    v-if="userMenuOpen"
                    class="absolute right-0 mt-2 w-52 bg-white border border-gray-200 rounded-lg shadow-lg z-50 py-1"
                >
                    <div class="px-4 py-2 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ userName }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ userSubtitle }}</p>
                    </div>

                    <Link
                        :href="route('agent.profile.show')"
                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                        @click="userMenuOpen = false"
                    >
                        <span>👤</span> My Profile & Payout
                    </Link>

                    <Link
                        :href="route('agent.wallet.index')"
                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                        @click="userMenuOpen = false"
                    >
                        <span>💳</span> Wallet & Cash Out
                    </Link>

                    <hr class="my-1 border-gray-100" />

                    <a
                        :href="route('logout')"
                        class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                        @click.prevent="logout"
                    >
                        <span>🚪</span> Logout
                    </a>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

defineEmits(['toggle-sidebar']);

const page = usePage();
const isDark = ref(false);
const userMenuOpen = ref(false);
const dropdownRef = ref(null);

const userName      = computed(() => page.props.auth?.user?.name ?? 'Agent');
const agentCode     = computed(() => page.props.auth?.user?.agent_profile?.agent_code ?? '');
const userSubtitle  = computed(() => agentCode.value ? `Agent • ${agentCode.value}` : 'Agent Portal');
const walletBalance = computed(() => page.props.auth?.user?.agent_profile?.wallet_balance ?? 0);

const avatarUrl = computed(() =>
    `https://ui-avatars.com/api/?name=${encodeURIComponent(userName.value)}&background=2563eb&color=fff`
);

function toggleDark() {
    isDark.value = !isDark.value;
    document.documentElement.classList.toggle('dark', isDark.value);
}

function logout() {
    router.post(route('logout'));
}

function handleClickOutside(e) {
    if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
        userMenuOpen.value = false;
    }
}

onMounted(() => document.addEventListener('click', handleClickOutside));
onUnmounted(() => document.removeEventListener('click', handleClickOutside));
</script>
