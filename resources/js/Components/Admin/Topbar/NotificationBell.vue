<template>
    <div class="relative" data-notification-bell>
        <button class="relative p-1.5 rounded-full text-gray-500 hover:bg-gray-100" @click="toggle">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span v-if="unreadCount > 0"
                class="absolute -top-0.5 -right-0.5 flex items-center justify-center min-w-[16px] h-4 px-1 rounded-full bg-red-500 text-white text-[10px] font-bold">
                {{ unreadCount > 9 ? '9+' : unreadCount }}
            </span>
        </button>

        <div v-if="open" class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded shadow-lg z-50 max-h-96 overflow-y-auto">
            <div class="px-4 py-2 border-b border-gray-100 flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-800">Notifications</p>
                <button v-if="unreadCount > 0" @click="markAllRead" class="text-xs text-blue-600 hover:underline">Mark all read</button>
            </div>
            <div v-if="!notifications.length" class="px-4 py-6 text-center text-xs text-gray-400">No notifications yet.</div>
            <a v-for="n in notifications" :key="n.id" :href="n.url || '#'"
                @click="markRead(n)"
                :class="n.read_at ? 'bg-white' : 'bg-blue-50'"
                class="block px-4 py-3 border-b border-gray-50 hover:bg-gray-50">
                <p class="text-sm font-medium text-gray-800">{{ n.title }}</p>
                <p v-if="n.body" class="text-xs text-gray-500 mt-0.5">{{ n.body }}</p>
                <p class="text-[11px] text-gray-400 mt-1">{{ timeAgo(n.created_at) }}</p>
            </a>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';

const open = ref(false);
const notifications = ref([]);
const unreadCount = ref(0);
let poller = null;

function load() {
    fetch(route('admin.notifications.index'))
        .then(r => r.json())
        .then(data => {
            notifications.value = data.notifications || [];
            unreadCount.value = data.unread_count || 0;
        })
        .catch(() => {});
}

function toggle() {
    open.value = !open.value;
    if (open.value) load();
}

function markRead(n) {
    if (n.read_at) return;
    n.read_at = new Date().toISOString();
    unreadCount.value = Math.max(0, unreadCount.value - 1);
    router.patch(route('admin.notifications.read', n.id), {}, { preserveScroll: true, preserveState: true, only: [] });
}

function markAllRead() {
    notifications.value.forEach(n => { n.read_at = n.read_at || new Date().toISOString(); });
    unreadCount.value = 0;
    router.patch(route('admin.notifications.read-all'), {}, { preserveScroll: true, preserveState: true, only: [] });
}

function timeAgo(dateStr) {
    const diff = Math.max(0, (Date.now() - new Date(dateStr).getTime()) / 1000);
    if (diff < 60) return 'just now';
    if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
    if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
    return Math.floor(diff / 86400) + 'd ago';
}

function onClickOutside(e) {
    if (!e.target.closest('[data-notification-bell]')) open.value = false;
}

onMounted(() => {
    load();
    poller = setInterval(load, 60000);
    document.addEventListener('click', onClickOutside);
});
onUnmounted(() => {
    clearInterval(poller);
    document.removeEventListener('click', onClickOutside);
});
</script>
