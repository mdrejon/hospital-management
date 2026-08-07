<template>
    <aside
        :class="[
            'flex flex-col bg-white shadow-lg transition-all duration-300',
            // Mobile (< lg): fixed off-canvas drawer, slides in over the content
            'fixed inset-y-0 left-0 z-40 w-64',
            mobileOpen ? 'translate-x-0' : '-translate-x-full',
            // Desktop (lg+): back in the normal flow, collapsible to icon rail
            'lg:static lg:translate-x-0 lg:z-20',
            collapsed ? 'lg:w-16' : 'lg:w-64'
        ]"
    >
        <!-- User profile section -->
        <div class="flex items-center gap-3 p-4 border-b border-gray-100">
            <img
                :src="avatarUrl"
                alt="Agent Avatar"
                class="w-10 h-10 rounded-full flex-shrink-0"
            />
            <div v-if="!iconMode" class="overflow-hidden">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ userName }}</p>
                <p class="text-xs text-gray-500 truncate">{{ userSubtitle }}</p>
            </div>
            <button
                v-if="!iconMode"
                class="ml-auto text-gray-400 hover:text-gray-600"
                @click="$emit('toggle')"
            >
                <ChevronLeftIcon class="w-4 h-4" />
            </button>
        </div>

        <!-- Toggle button when collapsed -->
        <button
            v-if="iconMode"
            class="flex justify-center p-3 text-gray-400 hover:text-gray-600 border-b border-gray-100"
            @click="$emit('toggle')"
        >
            <ChevronRightIcon class="w-4 h-4" />
        </button>

        <!-- Search -->
        <AgentSidebarSearch v-if="!iconMode" :nav-items="agentNavItems" />

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-2">
            <AgentSidebarNavItem
                v-for="item in agentNavItems"
                :key="item.name"
                :item="item"
                :collapsed="iconMode"
            />
        </nav>

        <!-- Quick Balance in Sidebar (when not collapsed) -->
        <div v-if="!iconMode" class="p-3 border-t border-gray-100 bg-gray-50/70">
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 font-medium">Wallet Balance:</span>
                <span class="font-bold text-emerald-600 font-mono">BDT {{ Number(walletBalance).toLocaleString() }}</span>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AgentSidebarSearch  from './AgentSidebarSearch.vue';
import AgentSidebarNavItem from './AgentSidebarNavItem.vue';
import agentNavItems       from './agentNavItems';

const props = defineProps({
    collapsed:  Boolean, // desktop icon-rail mode
    mobileOpen: Boolean, // mobile off-canvas drawer visibility
});
defineEmits(['toggle']);

const iconMode = computed(() => props.collapsed && !props.mobileOpen);

const page = usePage();

const userName     = computed(() => page.props.auth?.user?.name ?? 'Agent');
const agentCode    = computed(() => page.props.auth?.user?.agent_profile?.agent_code ?? '');
const userSubtitle = computed(() => agentCode.value ? `Agent • ${agentCode.value}` : 'Agent Portal');
const walletBalance = computed(() => page.props.auth?.user?.agent_profile?.wallet_balance ?? 0);

const avatarUrl = computed(() =>
    `https://ui-avatars.com/api/?name=${encodeURIComponent(userName.value)}&background=2563eb&color=fff`
);

const ChevronLeftIcon  = { template: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>` };
const ChevronRightIcon = { template: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>` };
</script>
