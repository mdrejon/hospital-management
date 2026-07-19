<template>
    <div class="space-y-6">

        <!-- ── Basic Info ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Basic Information</h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label">Name <span class="text-red-500">*</span></label>
                    <input v-model="form.name" type="text" class="input" placeholder="e.g. Dr. Natali Jackson" />
                    <InputError :message="form.errors.name" />
                </div>
                <div>
                    <label class="label">URL Slug <span class="text-gray-400 font-normal text-xs">(auto-generated)</span></label>
                    <input :value="slugPreview" type="text" class="input bg-gray-50 text-gray-500 cursor-not-allowed" readonly />
                </div>
                <div>
                    <label class="label">Role / Title</label>
                    <input v-model="form.role" type="text" class="input" placeholder="e.g. Chief Executive Officer" />
                    <InputError :message="form.errors.role" />
                </div>
                <div>
                    <label class="label">Sort Order</label>
                    <input v-model.number="form.sort_order" type="number" min="0" class="input" />
                    <InputError :message="form.errors.sort_order" />
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input v-model="form.is_active" type="checkbox" class="w-4 h-4 rounded text-blue-600" />
                        <span class="text-sm text-gray-600">Active</span>
                    </label>
                </div>
            </div>
        </section>

        <!-- ── Photo ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Photo</h2>
            <DropZone @change="file => onFile(file, 'photo')" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-40 h-40 object-cover"
                :existing-preview="existing?.photo ? '/storage/' + existing.photo : null" />
            <InputError :message="form.errors.photo" />
        </section>

        <!-- ── Social Links ── -->
        <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Social Links</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label">LinkedIn URL</label>
                    <input v-model="form.linkedin_url" type="text" class="input" placeholder="https://linkedin.com/…" />
                </div>
                <div>
                    <label class="label">Facebook URL</label>
                    <input v-model="form.facebook_url" type="text" class="input" placeholder="https://facebook.com/…" />
                </div>
                <div>
                    <label class="label">Twitter / X URL</label>
                    <input v-model="form.twitter_url" type="text" class="input" placeholder="https://x.com/…" />
                </div>
                <div>
                    <label class="label">Instagram URL</label>
                    <input v-model="form.instagram_url" type="text" class="input" placeholder="https://instagram.com/…" />
                </div>
                <div>
                    <label class="label">YouTube URL</label>
                    <input v-model="form.youtube_url" type="text" class="input" placeholder="https://youtube.com/@…" />
                </div>
            </div>
        </section>

    </div>
</template>

<script setup>
import { computed } from 'vue';
import InputError from '@/Components/InputError.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';

const props = defineProps({
    form:     { type: Object, required: true },
    existing: { type: Object, default: null },
});

const emit = defineEmits(['image-change']);

const slugPreview = computed(() => {
    return (props.form.name || '')
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
});

function onFile(file, field) {
    if (!file) return;
    emit('image-change', { field, file });
}
</script>

<style scoped>
.label  { @apply block text-sm text-gray-600 mb-1; }
.input  { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
