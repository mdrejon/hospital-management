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
                <slot />
            </main>
        </div>
        
        <!-- Global Toast Notification -->
        <ToastMessage />
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import AgentSidebar from '@/Components/Agent/Sidebar/AgentSidebar.vue';
import AgentTopbar  from '@/Components/Agent/Topbar/AgentTopbar.vue';
import ToastMessage from '@/Components/ToastMessage.vue';

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
