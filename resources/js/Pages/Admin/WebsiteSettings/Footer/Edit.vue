<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <h1 class="text-lg font-semibold text-gray-800">Footer Settings</h1>

            <form @submit.prevent="submit" class="space-y-6">

                <!-- Brand -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Brand Section</h2>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Footer Logo</label>
                        <DropZone @change="onLogoChange" hint="JPEG / PNG / WebP — max 5 MB. Recommended size: 100×100px" preview-class="w-full h-28 object-contain p-2 bg-gray-50"
                            :existing-preview="currentLogo ? '/storage/' + currentLogo : null" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Brand Description</label>
                        <LanguageTabs v-model="activeLang" />
                        <textarea v-model="form.footer_brand_description[activeLang]" rows="3" class="input" placeholder="ClinicMaster Ipsum Dolor Sit Amet, Consectuer Adipiscing Elit..."></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Facebook URL</label>
                            <input v-model="form.footer_facebook_url" type="text" class="input" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Twitter / X URL</label>
                            <input v-model="form.footer_twitter_url" type="text" class="input" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Instagram URL</label>
                            <input v-model="form.footer_instagram_url" type="text" class="input" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">YouTube URL</label>
                            <input v-model="form.footer_youtube_url" type="text" class="input" />
                        </div>
                    </div>
                </section>

                <!-- Our Services Links -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-3">
                    <div class="flex items-center justify-between border-b pb-2">
                        <h2 class="text-sm font-semibold text-gray-700">"Our Services" Column</h2>
                        <button type="button" @click="addLink('footer_service_links')" class="text-xs text-blue-600 hover:underline">+ Add Link</button>
                    </div>
                    <LanguageTabs v-model="activeLang" />
                    <div v-for="(link, i) in form.footer_service_links" :key="i" class="flex items-center gap-3">
                        <input v-model="link.label[activeLang]" type="text" placeholder="Label" class="input flex-1" />
                        <input v-model="link.url"   type="text" placeholder="URL"   class="input flex-1" />
                        <button type="button" @click="removeLink('footer_service_links', i)" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                    </div>
                    <p v-if="!form.footer_service_links.length" class="text-xs text-gray-400">No links yet.</p>
                </section>

                <!-- Our Stores Links -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-3">
                    <div class="flex items-center justify-between border-b pb-2">
                        <h2 class="text-sm font-semibold text-gray-700">"Our Stores" Column</h2>
                        <button type="button" @click="addLink('footer_store_links')" class="text-xs text-blue-600 hover:underline">+ Add Link</button>
                    </div>
                    <LanguageTabs v-model="activeLang" />
                    <div v-for="(link, i) in form.footer_store_links" :key="i" class="flex items-center gap-3">
                        <input v-model="link.label[activeLang]" type="text" placeholder="Label" class="input flex-1" />
                        <input v-model="link.url"   type="text" placeholder="URL"   class="input flex-1" />
                        <button type="button" @click="removeLink('footer_store_links', i)" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                    </div>
                    <p v-if="!form.footer_store_links.length" class="text-xs text-gray-400">No links yet.</p>
                </section>

                <!-- Useful Links -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-3">
                    <div class="flex items-center justify-between border-b pb-2">
                        <h2 class="text-sm font-semibold text-gray-700">"Useful Links" Column</h2>
                        <button type="button" @click="addLink('footer_useful_links')" class="text-xs text-blue-600 hover:underline">+ Add Link</button>
                    </div>
                    <LanguageTabs v-model="activeLang" />
                    <div v-for="(link, i) in form.footer_useful_links" :key="i" class="flex items-center gap-3">
                        <input v-model="link.label[activeLang]" type="text" placeholder="Label" class="input flex-1" />
                        <input v-model="link.url"   type="text" placeholder="URL"   class="input flex-1" />
                        <button type="button" @click="removeLink('footer_useful_links', i)" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                    </div>
                    <p v-if="!form.footer_useful_links.length" class="text-xs text-gray-400">No links yet.</p>
                </section>

                <!-- Quick Links -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-3">
                    <div class="flex items-center justify-between border-b pb-2">
                        <h2 class="text-sm font-semibold text-gray-700">"Quick Links" Column</h2>
                        <button type="button" @click="addLink('footer_quick_links')" class="text-xs text-blue-600 hover:underline">+ Add Link</button>
                    </div>
                    <LanguageTabs v-model="activeLang" />
                    <div v-for="(link, i) in form.footer_quick_links" :key="i" class="flex items-center gap-3">
                        <input v-model="link.label[activeLang]" type="text" placeholder="Label" class="input flex-1" />
                        <input v-model="link.url"   type="text" placeholder="URL"   class="input flex-1" />
                        <button type="button" @click="removeLink('footer_quick_links', i)" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                    </div>
                    <p v-if="!form.footer_quick_links.length" class="text-xs text-gray-400">No links yet.</p>
                </section>

                <!-- Official Contact Info -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Official Contact Info</h2>
                    <LanguageTabs v-model="activeLang" />
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Phone Line 1</label>
                            <input v-model="form.footer_phone_1[activeLang]" type="text" class="input" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Phone Line 2</label>
                            <input v-model="form.footer_phone_2[activeLang]" type="text" class="input" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Phone Line 3</label>
                            <input v-model="form.footer_phone_3[activeLang]" type="text" class="input" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Email 1</label>
                            <input v-model="form.footer_email_1" type="email" class="input" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Email 2</label>
                            <input v-model="form.footer_email_2" type="email" class="input" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Opening Time</label>
                            <input v-model="form.footer_opening_time[activeLang]" type="text" class="input" placeholder="Mon-Thu: 8:00am-5:00pm Fri: 8:00am-1:00pm" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Address Line 1</label>
                            <input v-model="form.footer_address_line1[activeLang]" type="text" class="input" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Address Line 2</label>
                            <input v-model="form.footer_address_line2[activeLang]" type="text" class="input" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Website URL</label>
                            <input v-model="form.footer_website_url" type="text" class="input" />
                        </div>
                    </div>
                </section>

                <!-- Newsletter & Copyright -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Newsletter & Copyright</h2>
                    <LanguageTabs v-model="activeLang" />
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Newsletter Title</label>
                        <input v-model="form.footer_newsletter_title[activeLang]" type="text" class="input" placeholder="Stay Updated With ClinicMaster..." />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Copyright Text</label>
                        <input v-model="form.footer_copyright_text[activeLang]" type="text" class="input" placeholder="Smart Freamework Theme. All Rights Reserved." />
                        <p class="text-xs text-gray-400 mt-1">Shown after the auto-updating year, e.g. "&copy; {{ currentYear }} [this text]".</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Privacy Policy URL</label>
                            <input v-model="form.footer_privacy_url" type="text" class="input" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Terms URL</label>
                            <input v-model="form.footer_terms_url" type="text" class="input" />
                        </div>
                    </div>
                </section>
                <!-- Floating Contact Buttons -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Floating Contact Buttons</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Let's Talk -->
                        <div class="border rounded-lg p-4 space-y-3 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <h3 class="font-medium text-gray-800 flex items-center gap-2">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    "Let's Talk" Button
                                </h3>
                                <label class="flex items-center cursor-pointer gap-2">
                                    <input type="checkbox" v-model="form.footer_lets_talk_enabled" class="sr-only peer" />
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600 relative"></div>
                                    <span class="text-xs text-gray-600 font-medium select-none">{{ form.footer_lets_talk_enabled ? 'Enabled' : 'Disabled' }}</span>
                                </label>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Phone Number</label>
                                <input v-model="form.footer_lets_talk_phone" type="text" class="input bg-white" placeholder="e.g. +1234567890" />
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="border rounded-lg p-4 space-y-3 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <h3 class="font-medium text-gray-800 flex items-center gap-2">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                    WhatsApp Button
                                </h3>
                                <label class="flex items-center cursor-pointer gap-2">
                                    <input type="checkbox" v-model="form.footer_whatsapp_enabled" class="sr-only peer" />
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600 relative"></div>
                                    <span class="text-xs text-gray-600 font-medium select-none">{{ form.footer_whatsapp_enabled ? 'Enabled' : 'Disabled' }}</span>
                                </label>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">WhatsApp Number (with country code)</label>
                                <input v-model="form.footer_whatsapp_number" type="text" class="input bg-white" placeholder="e.g. 1234567890" />
                            </div>
                        </div>
                    </div>
                </section>

                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing" class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Saving...' : 'Save Footer Settings' }}
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
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import LanguageTabs from '@/Components/Admin/Shared/LanguageTabs.vue';
import { emptyTranslatable, defaultLangCode } from '@/Composables/useTranslatable';

const props = defineProps({
    settings: { type: Object, required: true },
});

const languages = computed(() => usePage().props.languages ?? []);
const activeLang = ref(defaultLangCode(languages.value));

const currentYear = new Date().getFullYear();
const currentLogo = ref(props.settings.footer_logo);

const seed = (key) => ({ ...emptyTranslatable(languages.value), ...(props.settings[key] || {}) });
const seedLinks = (key) => (props.settings[key] ?? []).map(link => ({
    ...link,
    label: { ...emptyTranslatable(languages.value), ...(link.label || {}) },
}));

const form = useForm({
    footer_logo:              null,
    footer_brand_description: seed('footer_brand_description'),
    footer_facebook_url:      props.settings.footer_facebook_url ?? '',
    footer_twitter_url:       props.settings.footer_twitter_url ?? '',
    footer_instagram_url:     props.settings.footer_instagram_url ?? '',
    footer_youtube_url:       props.settings.footer_youtube_url ?? '',
    footer_quick_links:       seedLinks('footer_quick_links'),
    footer_service_links:     seedLinks('footer_service_links'),
    footer_store_links:       seedLinks('footer_store_links'),
    footer_useful_links:      seedLinks('footer_useful_links'),
    footer_phone_1:           seed('footer_phone_1'),
    footer_phone_2:           seed('footer_phone_2'),
    footer_phone_3:           seed('footer_phone_3'),
    footer_email_1:           props.settings.footer_email_1 ?? '',
    footer_email_2:           props.settings.footer_email_2 ?? '',
    footer_address_line1:     seed('footer_address_line1'),
    footer_address_line2:     seed('footer_address_line2'),
    footer_website_url:       props.settings.footer_website_url ?? '',
    footer_opening_time:      seed('footer_opening_time'),
    footer_newsletter_title:  seed('footer_newsletter_title'),
    footer_privacy_url:       props.settings.footer_privacy_url ?? '',
    footer_terms_url:         props.settings.footer_terms_url ?? '',
    footer_copyright_text:    seed('footer_copyright_text'),
    footer_lets_talk_phone:   props.settings.footer_lets_talk_phone ?? '',
    footer_lets_talk_enabled: props.settings.footer_lets_talk_enabled == '1',
    footer_whatsapp_number:   props.settings.footer_whatsapp_number ?? '',
    footer_whatsapp_enabled:  props.settings.footer_whatsapp_enabled == '1',
});

function onLogoChange(file) {
    if (!file) return;
    form.footer_logo = file;
}

function addLink(field)        { form[field].push({ label: emptyTranslatable(languages.value), url: '' }); }
function removeLink(field, i)  { form[field].splice(i, 1); }

function submit() {
    form.post(route('admin.website-settings.footer.update'), {
        forceFormData: true,
    });
}
</script>

<style scoped>
.input {
    @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none;
}
</style>
