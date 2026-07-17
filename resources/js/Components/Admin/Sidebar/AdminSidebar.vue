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

function canView(module) {
    if (!module) return true; // no module restriction
    const perms = page.props.auth?.permissions;
    if (perms === null || perms === undefined) return true; // super admin
    return perms?.[module]?.view ?? false;
}

const visibleNavItems = computed(() =>
    navItems.filter(item => canView(item.module ?? null))
);

// Inline minimal SVG icons to avoid external dependency
const ChevronLeftIcon  = { template: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>` };
const ChevronRightIcon = { template: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>` };

const navItems = [
    // ── Dashboard ──────────────────────────────────────────────────────────
    {
        name: 'Dashboard',
        route: 'admin.dashboard',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>`,
    },

    // ── Inquiries ───────────────────────────────────────────────────────────
    {
        name: 'Inquiries',
        route: 'admin.inquiries.index',
        module: 'inquiries',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>`,
        children: [
            { name: 'List',              route: 'admin.inquiries.index' },
            // { name: 'View & Make Reply', route: null },
        ],
    },

    // ── Website Management ──────────────────────────────────────────────────
    {
        name: 'Website Management',
        route: null,
        module: 'website-management',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>`,
        children: [
            { name: 'About Settings', route: 'admin.website-settings.about.edit' },
            { name: 'Services',       route: 'admin.services.index' },
            { name: 'Gallery',        route: 'admin.website-settings.gallery.index' },
            { name: "FAQ's",          route: 'admin.faqs.index' },
            { name: 'Testimonials',   route: 'admin.testimonials.index' },
            { name: 'Blog Category',  route: 'admin.blog-categories.index' },
            { name: 'Blog Posts',     route: 'admin.blog.index' },
        ],
    },

    // ── Global Settings ─────────────────────────────────────────────────────
    {
        name: 'Global Settings',
        route: 'admin.website-settings.sliders.index',
        module: 'global-settings',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`,
        children: [
            { name: 'Hero Slider',       route: 'admin.website-settings.sliders.index' },
            { name: 'Header Settings',   route: 'admin.website-settings.header.edit' },
            { name: 'Footer Settings',   route: 'admin.website-settings.footer.edit' },

            { name: 'History Settings',  route: 'admin.website-settings.history.edit' },
            { name: 'Contact Settings',  route: 'admin.website-settings.contact.edit' },
            { name: 'Services Settings', route: 'admin.website-settings.services.edit' },
            { name: 'Blog Settings',     route: 'admin.website-settings.blog-page.edit' },
            { name: 'Email Notifications', route: 'admin.website-settings.email-notifications.edit' },
            { name: 'Facilities',        route: 'admin.facilities.index' },
            // { name: 'Room Features',     route: null },
            // { name: 'Social Media',      route: null },
            // { name: 'SEO Settings',      route: null },
            // { name: 'General Settings',  route: null },
        ],
    },

    // ── Email SMTP Setting ──────────────────────────────────────────────────
    {
        name: 'Email SMTP Setting',
        route: 'admin.website-settings.mail.edit',
        module: 'email-smtp-setting',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>`,
    },

    // ── User Management ─────────────────────────────────────────────────────
    {
        name: 'User Management',
        route: 'admin.users.index',
        module: 'user-management',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 010 7.75"/></svg>`,
        children: [
            { name: 'Users',    route: 'admin.users.index' },
            { name: 'Add User', route: 'admin.users.create' },
            { name: 'Roles',    route: 'admin.roles.index' },
            { name: 'Add Role', route: 'admin.roles.create' },
        ],
    },

    // ── Backup ──────────────────────────────────────────────────────────────
    {
        name: 'Backup',
        route: 'admin.backups.index',
        module: 'backups',
        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4 4 4-4m-4-5v9"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.88 18.09A5 5 0 0018 9h-1.26A8 8 0 103 16.29"/></svg>`,
    },
];
</script>
