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
                alt="Admin Avatar"
                class="w-10 h-10 rounded-full flex-shrink-0"
            />
            <div v-if="!iconMode" class="overflow-hidden">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ userName }}</p>
                <p class="text-xs text-gray-500 truncate">{{ userRole }}</p>
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
        <SidebarSearch v-if="!iconMode" :nav-items="visibleNavItems" />

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-2">
            <SidebarNavItem
                v-for="item in visibleNavItems"
                :key="item.name"
                :item="item"
                :collapsed="iconMode"
            />
        </nav>
    </aside>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import SidebarSearch  from './SidebarSearch.vue';
import SidebarNavItem from './SidebarNavItem.vue';
import navItems       from './navItems';

const props = defineProps({
    collapsed:  Boolean, // desktop icon-rail mode
    mobileOpen: Boolean, // mobile off-canvas drawer visibility
});
defineEmits(['toggle']);

// The icon rail only exists on desktop; the mobile drawer always shows full content.
const iconMode = computed(() => props.collapsed && !props.mobileOpen);

const page = usePage();

const userName  = computed(() => page.props.auth?.user?.name ?? 'Admin');
const userRole  = computed(() => page.props.auth?.role_name ?? 'Admin');
const avatarUrl = computed(() =>
    `https://ui-avatars.com/api/?name=${encodeURIComponent(userName.value)}&background=4f46e5&color=fff`
);

function canView(item) {
    if (item.developerOnly && !page.props.auth?.is_developer) {
        return false;
    }
    
    if (!item.module) return true; // no module restriction
    const perms = page.props.auth?.permissions;
    if (perms === null || perms === undefined) return true; // super admin
    return perms?.[item.module]?.view ?? false;
}

const visibleNavItems = computed(() => {
    return navItems.map(item => {
        if (!canView(item)) return null;
        
        if (item.children) {
            const visibleChildren = item.children.filter(child => {
                if (child.developerOnly && !page.props.auth?.is_developer) return false;
                return true;
            });
            if (visibleChildren.length === 0) return null;
            return { ...item, children: visibleChildren };
        }
        
        return item;
    }).filter(Boolean);
});

// Inline minimal SVG icons to avoid external dependency
const ChevronLeftIcon  = { template: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>` };
const ChevronRightIcon = { template: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>` };

</script>
