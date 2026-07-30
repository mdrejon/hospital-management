<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <h1 class="text-lg font-semibold text-gray-800">Why Choose Us Settings</h1>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">

                <!-- ─── Why Choose Us (Home page) ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Why Choose Us Section <span class="text-xs font-normal text-gray-400">(Home page only)</span></h2>
                    <LanguageTabs v-model="activeLang" />

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Section Photo</label>
                            <DropZone @change="file => form.why_photo = file" hint="JPEG / PNG / WebP — portrait (4:5) works best"
                                preview-class="w-full h-44 object-cover"
                                :existing-preview="currentPhoto ? '/storage/' + currentPhoto : null" />
                            <InputError :message="form.errors.why_photo" />
                        </div>
                        <div>
                            <label class="label">Section Background <span class="text-xs text-gray-400">(optional)</span></label>
                            <DropZone @change="file => form.why_bg_photo = file" hint="JPEG / PNG / WebP — wide image behind the section"
                                preview-class="w-full h-44 object-cover"
                                :existing-preview="currentBgPhoto ? '/storage/' + currentBgPhoto : null" />
                            <InputError :message="form.errors.why_bg_photo" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Badge Text</label>
                            <input v-model="form.why_badge[activeLang]" type="text" class="input" placeholder="WHY CHOOSE US" />
                        </div>
                        <div>
                            <label class="label">Section Title</label>
                            <input v-model="form.why_title[activeLang]" type="text" class="input" placeholder="Why Choose Us For Your Health Care Needs" />
                        </div>
                        <div class="col-span-2">
                            <label class="label">Section Description</label>
                            <textarea v-model="form.why_desc[activeLang]" rows="2" class="input"></textarea>
                        </div>
                    </div>

                    <div class="border-t pt-4 space-y-3">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Photo Badge <span class="normal-case font-normal text-gray-400">(the blue box over the photo)</span></p>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label">Number</label>
                                <input v-model="form.why_badge_number[activeLang]" type="text" class="input" placeholder="20+" />
                            </div>
                            <div>
                                <label class="label">Label</label>
                                <input v-model="form.why_badge_label[activeLang]" type="text" class="input" placeholder="Years Experienced" />
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Feature Cards</p>
                            <button type="button" @click="form.why_features.push({ title: emptyTranslatable(languages), description: emptyTranslatable(languages) })" class="text-xs text-blue-600 hover:underline">+ Add Feature Card</button>
                        </div>
                        <div v-for="(feat, i) in form.why_features" :key="i" class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="flex items-center justify-between bg-gray-50 px-4 py-2 border-b border-gray-200">
                                <span class="text-xs font-semibold text-gray-600">Card {{ i + 1 }}</span>
                                <button type="button" @click="form.why_features.splice(i, 1)" class="w-6 h-6 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded text-xs">&times;</button>
                            </div>
                            <div class="p-4 space-y-3">
                                <div>
                                    <label class="label text-xs">Title</label>
                                    <input v-model="feat.title[activeLang]" type="text" class="input" placeholder="More Experience" />
                                </div>
                                <div>
                                    <label class="label text-xs">Description</label>
                                    <textarea v-model="feat.description[activeLang]" rows="2" class="input"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Saving...' : 'Save Why Choose Us Settings' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import LanguageTabs from '@/Components/Admin/Shared/LanguageTabs.vue';
import { emptyTranslatable, defaultLangCode } from '@/Composables/useTranslatable';

const props = defineProps({
    settings: { type: Object, required: true },
});

const languages = computed(() => usePage().props.languages ?? []);
const activeLang = ref(defaultLangCode(languages.value));

const s = props.settings;
const seed = (key, fallback = {}) => ({ ...emptyTranslatable(languages.value), ...fallback, ...(s[key] || {}) });

const currentPhoto = ref(s.why_photo);
const currentBgPhoto = ref(s.why_bg_photo);

const form = useForm({
    why_photo:        null,
    why_bg_photo:     null,
    why_badge:        seed('why_badge'),
    why_title:        seed('why_title'),
    why_desc:         seed('why_desc'),
    why_badge_number: seed('why_badge_number'),
    why_badge_label:  seed('why_badge_label'),
    why_features: Array.isArray(s.why_features) ? s.why_features.map(f => ({
        title:       { ...emptyTranslatable(languages.value), ...f.title },
        description: { ...emptyTranslatable(languages.value), ...f.description },
    })) : [],
});

function submit() {
    form.post(route('admin.website-settings.why-choose-us.update'), {
        forceFormData: true,
    });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
