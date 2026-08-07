<template>
    <div class="flex h-screen bg-gray-100 overflow-hidden">
        <!-- Mobile backdrop -->
        <div
            v-if="mobileOpen"
            class="fixed inset-0 bg-black/40 z-30 lg:hidden"
            @click="mobileOpen = false"
        ></div>

        <!-- Agent Sidebar -->
        <AgentSidebar
            :collapsed="sidebarCollapsed"
            :mobile-open="mobileOpen"
            @toggle="toggleSidebar"
        />

        <!-- Main content area -->
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">
            <!-- Agent Topbar -->
            <AgentTopbar @toggle-sidebar="toggleSidebar" />

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6">
                <!-- Flash messages -->
                <div v-if="$page.props.flash?.success" class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ $page.props.flash.success }}</span>
                </div>
                <div v-if="$page.props.flash?.error" class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $page.props.flash.error }}</span>
                </div>

                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import AgentSidebar from '@/Components/Agent/Sidebar/AgentSidebar.vue';
import AgentTopbar  from '@/Components/Agent/Topbar/AgentTopbar.vue';

const COLLAPSE_KEY = 'agent.sidebar-collapsed';

const sidebarCollapsed = ref(
    typeof window !== 'undefined' && window.localStorage.getItem(COLLAPSE_KEY) === '1'
);
const mobileOpen = ref(false);

const isDesktop = () => window.matchMedia('(min-width: 1024px)').matches;

function toggleSidebar() {
    if (isDesktop()) {
        sidebarCollapsed.value = !sidebarCollapsed.value;
        window.localStorage.setItem(COLLAPSE_KEY, sidebarCollapsed.value ? '1' : '0');
    } else {
        mobileOpen.value = !mobileOpen.value;
    }
}

let stopNavListener = null;
onMounted(() => {
    stopNavListener = router.on('navigate', () => { mobileOpen.value = false; });
});
onUnmounted(() => stopNavListener && stopNavListener());
</script>
