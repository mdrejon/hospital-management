<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <h1 class="text-lg font-semibold text-gray-800">About Section Settings</h1>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">

                <!-- ─── About Section (Home + About page) ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">About Section <span class="text-xs font-normal text-gray-400">(shown on Home page and About page)</span></h2>
                    <LanguageTabs v-model="activeLang" />

                    <div>
                        <label class="label">Photo</label>
                        <DropZone @change="file => form.about_photo = file" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-44 object-cover"
                            :existing-preview="currentAboutPhoto ? '/storage/' + currentAboutPhoto : null" />
                        <InputError :message="form.errors.about_photo" />
                    </div>
                    <div>
                        <label class="label">Title</label>
                        <input v-model="form.about_title[activeLang]" type="text" class="input" placeholder="World Class Patient Facilities Designed For You" />
                        <InputError :message="form.errors[`about_title.${activeLang}`]" />
                    </div>
                    <div>
                        <label class="label">Description <span class="text-xs text-gray-400">(shown on the Home page — and on the About page unless the editor description below is filled)</span></label>
                        <textarea v-model="form.about_desc[activeLang]" rows="3" class="input" placeholder="Experience the future of healthcare..."></textarea>
                        <InputError :message="form.errors[`about_desc.${activeLang}`]" />
                    </div>
                    <div>
                        <label class="label">About Page Description <span class="text-xs text-gray-400">(About page only — when filled it replaces the plain description above on the About page; the Home page always keeps the plain one)</span></label>
                        <RichEditor v-model="form.about_page_desc[activeLang]" />
                        <InputError :message="form.errors[`about_page_desc.${activeLang}`]" />
                    </div>

                    <div class="border-t pt-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="label mb-0">Opening Hours Card</label>
                        </div>
                        <input v-model="form.about_hours_title[activeLang]" type="text" class="input" placeholder="Open Hours" />
                        <div v-for="(row, i) in form.about_hours" :key="i" class="flex items-center gap-3">
                            <input v-model="row.day[activeLang]" type="text" placeholder="Day (e.g. Monday)" class="input flex-1" />
                            <input v-model="row.time[activeLang]" type="text" placeholder="Time (e.g. 09:30 - 07:30)" class="input flex-1" />
                            <button type="button" @click="form.about_hours.splice(i, 1)" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                        </div>
                        <button type="button" @click="form.about_hours.push({ day: emptyTranslatable(languages), time: emptyTranslatable(languages) })" class="text-xs text-blue-600 hover:underline">+ Add Row</button>
                    </div>

                    <div class="border-t pt-4 space-y-3">
                        <label class="label mb-0">Feature Checklist <span class="text-xs text-gray-400">(shown in two columns)</span></label>
                        <div v-for="(item, i) in form.about_features" :key="i" class="flex items-center gap-3">
                            <input v-model="form.about_features[i][activeLang]" type="text" placeholder="e.g. Comprehensive Specialties" class="input flex-1" />
                            <button type="button" @click="form.about_features.splice(i, 1)" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                        </div>
                        <button type="button" @click="form.about_features.push(emptyTranslatable(languages))" class="text-xs text-blue-600 hover:underline">+ Add Feature</button>
                    </div>

                    <div class="border-t pt-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">CTA Button Text <span class="text-xs text-gray-400">(Home page only)</span></label>
                            <input v-model="form.about_more_btn_text[activeLang]" type="text" class="input" placeholder="Appointment" />
                        </div>
                        <div>
                            <label class="label">CTA Button URL</label>
                            <input v-model="form.about_more_btn_url" type="text" class="input" placeholder="/appointment" />
                        </div>
                    </div>
                </section>

                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Saving...' : 'Save About Settings' }}
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
import InputError   from '@/Components/InputError.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import LanguageTabs from '@/Components/Admin/Shared/LanguageTabs.vue';
import RichEditor from '@/Components/Admin/Shared/RichEditor.vue';
import { emptyTranslatable, defaultLangCode } from '@/Composables/useTranslatable';

const props = defineProps({
    settings: { type: Object, required: true },
});

const languages = computed(() => usePage().props.languages ?? []);
const activeLang = ref(defaultLangCode(languages.value));

const s = props.settings;
const seed = (key, fallback = {}) => ({ ...emptyTranslatable(languages.value), ...fallback, ...(s[key] || {}) });

const currentAboutPhoto = ref(s.about_photo);

const form = useForm({
    about_photo:        null,
    about_title:         seed('about_title'),
    about_desc:           seed('about_desc'),
    about_page_desc:      seed('about_page_desc'),
    about_hours_title:    seed('about_hours_title'),
    about_hours:          Array.isArray(s.about_hours) ? s.about_hours.map(r => ({ day: { ...emptyTranslatable(languages.value), ...r.day }, time: { ...emptyTranslatable(languages.value), ...r.time } })) : [],
    about_features:       Array.isArray(s.about_features) ? s.about_features.map(f => ({ ...emptyTranslatable(languages.value), ...f })) : [],
    about_more_btn_text:  seed('about_more_btn_text'),
    about_more_btn_url:   s.about_more_btn_url ?? '',
});

function submit() {
    form.post(route('admin.website-settings.global-about.update'), {
        forceFormData: true,
    });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
