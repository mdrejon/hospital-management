<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-6">
            <h1 class="text-lg font-semibold text-gray-800">Language Management</h1>
            <p class="text-sm text-gray-500 -mt-4">
                Manage which languages visitors can switch between on the website. The default language is used whenever a
                translation is missing.
            </p>

            <!-- Flash -->
            <!-- ── Add / Edit Language ── -->
            <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">
                    {{ editingId ? 'Edit Language' : 'Add New Language' }}
                </h2>
                <form @submit.prevent="submitLanguage" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Language Code <span class="text-red-500">*</span></label>
                            <input v-model="form.code" type="text" class="input" placeholder="e.g. en, bn" maxlength="10" />
                            <p class="text-xs text-gray-400 mt-1">ISO code used internally, e.g. "en" or "bn".</p>
                            <InputError :message="form.errors.code" />
                        </div>
                        <div>
                            <label class="label">Name (English) <span class="text-red-500">*</span></label>
                            <input v-model="form.name" type="text" class="input" placeholder="e.g. English" />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div>
                            <label class="label">Native Name <span class="text-red-500">*</span></label>
                            <input v-model="form.native_name" type="text" class="input" placeholder="e.g. বাংলা" />
                            <InputError :message="form.errors.native_name" />
                        </div>
                        <div>
                            <label class="label">Text Direction</label>
                            <select v-model="form.direction" class="input">
                                <option value="ltr">Left to Right (LTR)</option>
                                <option value="rtl">Right to Left (RTL)</option>
                            </select>
                            <InputError :message="form.errors.direction" />
                        </div>
                        <div>
                            <label class="label">Sort Order</label>
                            <input v-model.number="form.sort_order" type="number" min="0" class="input" />
                            <InputError :message="form.errors.sort_order" />
                        </div>
                        <div class="flex items-end gap-6 pb-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input v-model="form.is_active" type="checkbox" class="w-4 h-4 rounded text-blue-600" />
                                <span class="text-sm text-gray-600">Active</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input v-model="form.is_default" type="checkbox" class="w-4 h-4 rounded text-blue-600" />
                                <span class="text-sm text-gray-600">Set as default</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-end">
                        <button v-if="editingId" type="button" @click="resetForm"
                            class="px-4 py-2 text-sm text-gray-600 border rounded hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" :disabled="form.processing"
                            class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                            {{ form.processing ? 'Saving...' : (editingId ? 'Update Language' : 'Add Language') }}
                        </button>
                    </div>
                </form>
            </section>

            <!-- ── Languages List ── -->
            <section class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-700">All Languages ({{ languages.length }})</h2>
                </div>
                <div v-if="!languages.length" class="px-6 py-10 text-center text-gray-400 text-sm">
                    No languages yet — add one above.
                </div>
                <div v-else class="divide-y divide-gray-50">
                    <div v-for="l in languages" :key="l.id"
                        class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50 transition-colors">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-800 text-sm">{{ l.native_name }}</span>
                                <span class="text-xs text-gray-400">({{ l.name }})</span>
                                <span class="text-[11px] font-mono px-1.5 py-0.5 bg-gray-100 text-gray-500 rounded">{{ l.code }}</span>
                                <span v-if="l.is_default"
                                    class="px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Default</span>
                            </div>
                            <p class="text-xs text-gray-500">Direction: {{ l.direction.toUpperCase() }} · Sort {{ l.sort_order }}</p>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <button v-if="!l.is_default" @click="makeDefault(l)"
                                class="px-3 py-1.5 bg-blue-50 text-blue-700 text-xs rounded hover:bg-blue-100">
                                Make Default
                            </button>
                            <button @click="toggleStatus(l)"
                                :disabled="l.is_default && l.is_active"
                                :class="l.is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'"
                                class="px-2 py-0.5 rounded-full text-xs font-semibold disabled:opacity-60 disabled:cursor-not-allowed">
                                {{ l.is_active ? 'Active' : 'Inactive' }}
                            </button>
                            <button @click="startEdit(l)"
                                class="px-3 py-1.5 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">
                                Edit
                            </button>
                            <button v-if="!l.is_default" @click="confirmDelete(l)"
                                class="px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Delete modal -->
        <div v-if="deleteTarget" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-80 shadow-xl">
                <h3 class="font-semibold text-gray-800 mb-2">Delete Language</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Remove "<strong>{{ deleteTarget?.native_name }}</strong>"? Existing translated content in this language
                    will remain stored but no longer be editable via language tabs. Cannot be undone.
                </p>
                <div class="flex justify-end gap-2">
                    <button @click="deleteTarget = null"
                        class="px-4 py-2 text-sm text-gray-600 border rounded hover:bg-gray-50">Cancel</button>
                    <button @click="doDelete"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    languages: { type: Array, default: () => [] },
});

// ── Add / Edit form ──
const editingId = ref(null);

const form = useForm({
    code:        '',
    name:        '',
    native_name: '',
    direction:   'ltr',
    sort_order:  0,
    is_active:   true,
    is_default:  false,
});

function startEdit(l) {
    editingId.value    = l.id;
    form.code          = l.code;
    form.name          = l.name;
    form.native_name   = l.native_name;
    form.direction     = l.direction;
    form.sort_order    = l.sort_order;
    form.is_active     = l.is_active;
    form.is_default    = l.is_default;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
    editingId.value = null;
    form.reset();
}

function submitLanguage() {
    if (editingId.value) {
        form.transform(data => ({ ...data, _method: 'PUT' }))
            .post(route('admin.website-settings.languages.update', editingId.value), {
                onSuccess: () => resetForm(),
            });
    } else {
        form.post(route('admin.website-settings.languages.store'), {
            onSuccess: () => resetForm(),
        });
    }
}

// ── Status / Default / Delete ──
function toggleStatus(l) {
    router.patch(route('admin.website-settings.languages.toggle', l.id));
}

function makeDefault(l) {
    router.patch(route('admin.website-settings.languages.set-default', l.id));
}

const deleteTarget = ref(null);
function confirmDelete(l) { deleteTarget.value = l; }
function doDelete() {
    router.delete(route('admin.website-settings.languages.destroy', deleteTarget.value.id), {
        onFinish: () => { deleteTarget.value = null; },
    });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
