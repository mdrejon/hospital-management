<template>
    <AdminLayout>
        <div class="max-w-6xl space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-1">
                        <Link :href="route('admin.blog-comments.index')" class="hover:text-blue-600">All Comments</Link>
                        <span>/</span>
                        <span class="text-gray-600 truncate max-w-xs">{{ displayTranslatable(blog.title, languages) }}</span>
                    </div>
                    <h1 class="text-lg font-semibold text-gray-800">Comments on "{{ displayTranslatable(blog.title, languages) }}"</h1>
                    <p class="text-sm text-gray-500 mt-0.5">{{ comments.length }} top-level comment{{ comments.length === 1 ? '' : 's' }}.</p>
                </div>
                <Link :href="route('admin.blog.edit', blog.id)"
                    class="px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm rounded hover:bg-gray-50 transition-colors">
                    Edit Post
                </Link>
            </div>

            <!-- Flash -->
            <!-- Comments -->
            <div class="space-y-4">
                <div v-if="!comments.length" class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-12 text-center text-gray-400 text-sm">
                    No comments on this post yet.
                </div>

                <div v-for="comment in comments" :key="comment.id"
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden"
                    :class="!comment.is_approved && 'ring-1 ring-amber-200'">

                    <!-- Top-level comment -->
                    <div class="px-4 py-3.5 flex items-start gap-3">
                        <img :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(comment.name)}&background=0D3D2E&color=fff&size=40`"
                            class="w-8 h-8 rounded-full flex-shrink-0 mt-0.5" :alt="comment.name" />
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="font-medium text-gray-800 text-sm">{{ comment.name }}</p>
                                <span class="text-xs text-gray-400">{{ comment.email }}</span>
                                <span :class="['text-xs rounded-full px-2 py-0.5 font-medium', comment.is_approved
                                    ? 'bg-green-50 text-green-700 border border-green-200'
                                    : 'bg-amber-50 text-amber-700 border border-amber-200']">
                                    {{ comment.is_approved ? 'Approved' : 'Pending' }}
                                </span>
                                <span class="text-xs text-gray-400">{{ formatDate(comment.created_at) }}</span>
                            </div>
                            <p class="text-gray-700 text-sm mt-1">{{ comment.message }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <button @click="toggleApprove(comment)"
                                    :class="['text-xs px-2.5 py-1 rounded border font-medium transition-colors', comment.is_approved
                                        ? 'border-amber-300 text-amber-700 hover:bg-amber-50'
                                        : 'border-green-300 text-green-700 hover:bg-green-50']">
                                    {{ comment.is_approved ? 'Unapprove' : 'Approve' }}
                                </button>
                                <button @click="deleteComment(comment)"
                                    class="text-xs px-2.5 py-1 rounded border border-red-300 text-red-600 hover:bg-red-50 font-medium transition-colors">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Replies -->
                    <div v-if="comment.replies?.length" class="border-t border-gray-100 bg-gray-50/60 pl-8 divide-y divide-gray-100">
                        <div v-for="reply in comment.replies" :key="reply.id" class="px-4 py-3.5 flex items-start gap-3">
                            <img :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(reply.name)}&background=0D3D2E&color=fff&size=40`"
                                class="w-7 h-7 rounded-full flex-shrink-0 mt-0.5" :alt="reply.name" />
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <p class="font-medium text-gray-800 text-sm">{{ reply.name }}</p>
                                    <span class="text-xs text-gray-400">{{ reply.email }}</span>
                                    <span class="text-xs text-gray-400">{{ formatDate(reply.created_at) }}</span>
                                </div>
                                <p class="text-gray-700 text-sm mt-1">{{ reply.message }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <button @click="toggleApprove(reply)"
                                        class="text-xs px-2.5 py-1 rounded border border-amber-300 text-amber-700 hover:bg-amber-50 font-medium transition-colors">
                                        Unapprove
                                    </button>
                                    <button @click="deleteComment(reply)"
                                        class="text-xs px-2.5 py-1 rounded border border-red-300 text-red-600 hover:bg-red-50 font-medium transition-colors">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import { displayTranslatable } from '@/Composables/useTranslatable';

defineProps({
    blog:     { type: Object, required: true },
    comments: { type: Array,  default: () => [] },
});

const languages = computed(() => usePage().props.languages ?? []);

function toggleApprove(comment) {
    router.patch(route('admin.blog-comments.approve', comment.id), {}, { preserveScroll: true });
}

function deleteComment(comment) {
    if (!confirm('Delete this comment and all its replies?')) return;
    router.delete(route('admin.blog-comments.destroy', comment.id), { preserveScroll: true });
}

function formatDate(dateStr) {
    if (!dateStr) return '—';
    return new Date(dateStr).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
}
</script>
