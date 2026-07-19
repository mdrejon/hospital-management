<template>
    <AdminLayout>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Pages</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Manage common content pages (Privacy Policy, Terms &amp; Conditions, and any other static page)</p>
                </div>
                <a :href="route('admin.pages.create')"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                    + Add Page
                </a>
            </div>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>
            <div v-if="$page.props.flash?.error"
                class="px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded">
                {{ $page.props.flash.error }}
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">#</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Title</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">URL Path</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Parent</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Order</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Status</th>
                            <th class="text-left px-4 py-3 text-gray-500 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(p, i) in pages" :key="p.id"
                            class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-gray-500">{{ i + 1 }}</td>
                            <td class="px-4 py-3 text-gray-700 font-medium">{{ p.title }}</td>
                            <td class="px-4 py-3 text-gray-500 text-xs">/{{ p.full_path }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ p.parent || '—' }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ p.sort_order }}</td>
                            <td class="px-4 py-3">
                                <button @click="toggleStatus(p)"
                                    :class="p.is_active
                                        ? 'bg-green-100 text-green-700 hover:bg-green-200'
                                        : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
                                    class="px-2.5 py-0.5 rounded-full text-xs font-semibold transition-colors">
                                    {{ p.is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a :href="route('admin.pages.edit', p.id)"
                                        class="px-3 py-1.5 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">
                                        Edit
                                    </a>
                                    <button @click="confirmDelete(p)"
                                        class="px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!pages.length">
                            <td colspan="7" class="px-4 py-10 text-center text-gray-400">
                                No pages yet. Add your first page.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Delete modal -->
        <div v-if="deleteTarget" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-80 shadow-xl">
                <h3 class="font-semibold text-gray-800 mb-2">Delete Page</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Are you sure you want to delete
                    "<strong>{{ deleteTarget.title }}</strong>"?
                    This cannot be undone.
                </p>
                <div class="flex justify-end gap-2">
                    <button @click="deleteTarget = null"
                        class="px-4 py-2 text-sm text-gray-600 border rounded hover:bg-gray-50">
                        Cancel
                    </button>
                    <button @click="doDelete"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

defineProps({
    pages: { type: Array, default: () => [] },
});

const deleteTarget = ref(null);

function confirmDelete(p) {
    deleteTarget.value = p;
}

function doDelete() {
    router.delete(route('admin.pages.destroy', deleteTarget.value.id), {
        onFinish: () => { deleteTarget.value = null; },
    });
}

function toggleStatus(p) {
    router.patch(route('admin.pages.toggle', p.id));
}
</script>
