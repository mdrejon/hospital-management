<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-6">
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-800">Doctor Specializations</h1>
                <Link :href="route('admin.doctors.index')"
                    class="text-sm text-gray-500 hover:text-gray-700">← Doctors</Link>
            </div>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <!-- Add / Edit Form -->
            <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">
                    {{ editingId ? 'Edit Specialization' : 'Add New Specialization' }}
                </h2>
                <form @submit.prevent="submitSpecialization" class="space-y-4">
                    <LanguageTabs v-model="activeLang" />
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Specialization Name <span class="text-red-500">*</span></label>
                            <input v-model="form.name[activeLang]" type="text" class="input" placeholder="Cardiology" />
                            <p v-if="form.errors[`name.${activeLang}`]" class="text-xs text-red-500 mt-1">{{ form.errors[`name.${activeLang}`] }}</p>
                        </div>
                        <div>
                            <label class="label">Sort Order</label>
                            <input v-model.number="form.sort_order" type="number" min="0" class="input" />
                        </div>
                        <div class="col-span-2">
                            <label class="label">Description</label>
                            <textarea v-model="form.description[activeLang]" rows="2" class="input"
                                placeholder="Brief description of this specialization..."></textarea>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input v-model="form.is_active" type="checkbox" class="w-4 h-4 rounded text-blue-600" />
                            <span class="text-sm text-gray-600">Active</span>
                        </label>
                        <div class="flex gap-2">
                            <button v-if="editingId" type="button" @click="cancelEdit"
                                class="px-4 py-2 text-sm border border-gray-300 rounded text-gray-600 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" :disabled="form.processing"
                                class="px-5 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                                {{ form.processing ? 'Saving...' : (editingId ? 'Update Specialization' : 'Add Specialization') }}
                            </button>
                        </div>
                    </div>
                </form>
            </section>

            <!-- Specializations Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Name</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Slug</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Doctors</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-if="specializations.length === 0">
                            <td colspan="5" class="text-center py-8 text-gray-400">No specializations yet. Add one above.</td>
                        </tr>
                        <tr v-for="spec in specializations" :key="spec.id" class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-800">{{ displayTranslatable(spec.name, languages) }}</p>
                                <p v-if="spec.description" class="text-xs text-gray-400 line-clamp-1 mt-0.5">{{ displayTranslatable(spec.description, languages) }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs font-mono">{{ spec.slug }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ spec.doctors_count }}</td>
                            <td class="px-4 py-3">
                                <span :class="[
                                    'inline-block text-xs rounded-full px-2.5 py-1 font-medium',
                                    spec.is_active
                                        ? 'bg-green-50 text-green-700 border border-green-200'
                                        : 'bg-gray-100 text-gray-500 border border-gray-200'
                                ]">
                                    {{ spec.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" @click="toggleStatus(spec)"
                                        class="text-xs px-2.5 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50 font-medium">
                                        {{ spec.is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                    <button type="button" @click="startEdit(spec)"
                                        class="text-xs px-2.5 py-1 rounded border border-blue-300 text-blue-700 hover:bg-blue-50 font-medium">
                                        Edit
                                    </button>
                                    <button type="button" @click="deleteSpecialization(spec)"
                                        class="text-xs px-2.5 py-1 rounded border border-red-300 text-red-600 hover:bg-red-50 font-medium">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Delete Confirm Modal -->
        <div v-if="deletingSpec" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm">
                <h3 class="text-base font-semibold text-gray-800 mb-2">Delete Specialization</h3>
                <p class="text-sm text-gray-600 mb-5">
                    Delete <strong>{{ displayTranslatable(deletingSpec?.name, languages) }}</strong>? Doctors in this specialization will be uncategorized.
                </p>
                <div class="flex justify-end gap-3">
                    <button @click="deletingSpec = null"
                        class="px-4 py-2 text-sm border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button @click="confirmDelete"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, useForm, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import LanguageTabs from '@/Components/Admin/Shared/LanguageTabs.vue';
import { emptyTranslatable, seedTranslatable, displayTranslatable, defaultLangCode } from '@/Composables/useTranslatable';

const props = defineProps({
    specializations: Array,
});

const languages = computed(() => usePage().props.languages ?? []);
const activeLang = ref(defaultLangCode(languages.value));

const editingId    = ref(null);
const deletingSpec = ref(null);

const form = useForm({
    name:        emptyTranslatable(languages.value),
    description: emptyTranslatable(languages.value),
    is_active:   true,
    sort_order:  0,
});

function submitSpecialization() {
    if (editingId.value) {
        form.put(route('admin.doctor-specializations.update', editingId.value), {
            onSuccess: () => cancelEdit(),
        });
    } else {
        form.post(route('admin.doctor-specializations.store'), {
            onSuccess: () => form.reset(),
        });
    }
}

function startEdit(spec) {
    editingId.value  = spec.id;
    form.name        = seedTranslatable(languages.value, spec.name);
    form.description = seedTranslatable(languages.value, spec.description);
    form.is_active    = spec.is_active;
    form.sort_order   = spec.sort_order ?? 0;
    form.clearErrors();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function cancelEdit() {
    editingId.value = null;
    form.reset();
    form.clearErrors();
}

function toggleStatus(spec) {
    router.patch(route('admin.doctor-specializations.toggle', spec.id));
}

function deleteSpecialization(spec) {
    deletingSpec.value = spec;
}

function confirmDelete() {
    router.delete(route('admin.doctor-specializations.destroy', deletingSpec.value.id), {
        onFinish: () => { deletingSpec.value = null; },
    });
}
</script>

<style scoped>
.label { @apply block text-sm font-medium text-gray-700 mb-1.5; }
.input { @apply w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-colors bg-white; }
textarea.input { @apply resize-none; }
</style>
