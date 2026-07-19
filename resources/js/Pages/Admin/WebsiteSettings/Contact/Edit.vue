<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-4">
            <h1 class="text-lg font-semibold text-gray-800">Contact Page Settings</h1>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">

                <!-- ─── Page Hero & Breadcrumb ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Page Hero &amp; Breadcrumb</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Hero Background Image</label>
                            <DropZone @change="file => onImg('hero', file)" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-44 object-cover"
                                :existing-preview="settings.contact_hero_image ? '/storage/' + settings.contact_hero_image : null" />
                            <InputError :message="form.errors.contact_hero_image" />
                        </div>
                        <div>
                            <label class="label">Page Title (Breadcrumb)</label>
                            <input v-model="form.contact_hero_title" type="text" class="input"
                                placeholder="Contact Us" />
                            <InputError :message="form.errors.contact_hero_title" />
                        </div>
                    </div>
                </section>

                <!-- ─── Main Content (left column) ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Main Content (left column)</h2>
                    <div>
                        <label class="label">Section Title</label>
                        <input v-model="form.contact_title" type="text" class="input"
                            placeholder="Connect With Us For Your Healthcare Needs" />
                        <InputError :message="form.errors.contact_title" />
                    </div>
                    <div>
                        <label class="label">Description</label>
                        <textarea v-model="form.contact_desc" rows="3" class="input resize-none"
                            placeholder="Reach out for support, feedback, or to schedule an appointment. Fill out the form, and we'll promptly assist you and confirm your visit with our healthcare professionals."></textarea>
                        <InputError :message="form.errors.contact_desc" />
                    </div>
                    <div>
                        <label class="label">"Talk to a Doctor" Text <span class="text-xs text-gray-400">(next to the doctor avatars)</span></label>
                        <input v-model="form.contact_talk_text" type="text" class="input" placeholder="Talk to over 215 doctor" />
                        <InputError :message="form.errors.contact_talk_text" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Rating Score</label>
                            <input v-model="form.contact_rating_score" type="text" class="input" placeholder="4.8" />
                            <InputError :message="form.errors.contact_rating_score" />
                        </div>
                        <div>
                            <label class="label">Rating Text</label>
                            <input v-model="form.contact_rating_text" type="text" class="input" placeholder="12k ratings on google" />
                            <InputError :message="form.errors.contact_rating_text" />
                        </div>
                    </div>
                </section>

                <!-- ─── SEO Configuration ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">SEO Configuration</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="label">Meta Title <span class="text-gray-400 font-normal">({{ form.contact_seo_title.length }}/160)</span></label>
                            <input v-model="form.contact_seo_title" type="text" maxlength="160" class="input"
                                placeholder="Contact Us | ClinicMaster Medical & Health Care Services" />
                            <InputError :message="form.errors.contact_seo_title" />
                        </div>
                        <div class="col-span-2">
                            <label class="label">Meta Description <span class="text-gray-400 font-normal">({{ form.contact_seo_description.length }}/320)</span></label>
                            <textarea v-model="form.contact_seo_description" rows="2" maxlength="320"
                                class="input resize-none"
                                placeholder="Get in touch with ClinicMaster. We're happy to help you schedule an appointment or answer your questions."></textarea>
                            <InputError :message="form.errors.contact_seo_description" />
                        </div>
                        <div>
                            <label class="label">Keywords</label>
                            <input v-model="form.contact_seo_keywords" type="text" class="input"
                                placeholder="contact clinicmaster, hospital contact, book appointment" />
                            <InputError :message="form.errors.contact_seo_keywords" />
                        </div>
                        <div>
                            <label class="label">OG / Social Share Image</label>
                            <DropZone @change="file => onImg('og', file)" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-36 object-cover"
                                :existing-preview="settings.contact_seo_og_image ? '/storage/' + settings.contact_seo_og_image : null" />
                            <InputError :message="form.errors.contact_seo_og_image" />
                        </div>
                    </div>
                </section>

                <!-- ─── Phone Numbers ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">
                        Phone Numbers
                        <span class="text-xs text-gray-400 font-normal ml-2">also used in Header &amp; Footer</span>
                    </h2>
                    <div class="grid grid-cols-1 gap-3">
                        <div v-for="n in 3" :key="n">
                            <label class="label">Phone {{ n }}</label>
                            <div class="flex items-center gap-2">
                                <span class="flex-shrink-0 w-8 h-9 flex items-center justify-center bg-gray-50 border border-r-0 border-gray-300 rounded-l text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                                </span>
                                <input v-model="form[`footer_phone_${n}`]" type="text"
                                    class="input rounded-l-none flex-1"
                                    placeholder="1 123 456 7890" />
                            </div>
                            <InputError :message="form.errors[`footer_phone_${n}`]" />
                        </div>
                    </div>
                </section>

                <!-- ─── Email Addresses ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">
                        Email Addresses
                        <span class="text-xs text-gray-400 font-normal ml-2">also used in Header &amp; Footer</span>
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Primary Email</label>
                            <input v-model="form.footer_email_1" type="email" class="input"
                                placeholder="info@example.com" />
                            <InputError :message="form.errors.footer_email_1" />
                        </div>
                        <div>
                            <label class="label">Secondary Email</label>
                            <input v-model="form.footer_email_2" type="email" class="input"
                                placeholder="support@example.com" />
                            <InputError :message="form.errors.footer_email_2" />
                        </div>
                    </div>
                </section>

                <!-- ─── Address ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">
                        Address
                        <span class="text-xs text-gray-400 font-normal ml-2">also used in Header &amp; Footer</span>
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Address Line 1</label>
                            <input v-model="form.footer_address_line1" type="text" class="input"
                                placeholder="234 Oak Drive" />
                            <InputError :message="form.errors.footer_address_line1" />
                        </div>
                        <div>
                            <label class="label">Address Line 2</label>
                            <input v-model="form.footer_address_line2" type="text" class="input"
                                placeholder="Villagetown, USA" />
                            <InputError :message="form.errors.footer_address_line2" />
                        </div>
                    </div>
                </section>

                <!-- ─── Social Links ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">
                        Social Links
                        <span class="text-xs text-gray-400 font-normal ml-2">also used in Header &amp; Footer</span>
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div v-for="social in socials" :key="social.key">
                            <label class="label">{{ social.label }}</label>
                            <div class="flex items-center gap-2">
                                <span class="flex-shrink-0 w-8 h-9 flex items-center justify-center bg-gray-50 border border-r-0 border-gray-300 rounded-l text-gray-400" v-html="social.icon"></span>
                                <input v-model="form[social.key]" type="text" class="input rounded-l-none"
                                    :placeholder="social.placeholder" />
                            </div>
                            <InputError :message="form.errors[social.key]" />
                        </div>
                    </div>
                </section>

                <!-- ─── Contact Form Settings ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Contact Form (right panel)</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Form Title</label>
                            <input v-model="form.contact_form_title" type="text" class="input"
                                placeholder="Make An Appointment Apply For Treatments" />
                            <InputError :message="form.errors.contact_form_title" />
                        </div>
                        <div>
                            <label class="label">Submit Button Text</label>
                            <input v-model="form.contact_form_btn_text" type="text" class="input"
                                placeholder="Appointment" />
                            <InputError :message="form.errors.contact_form_btn_text" />
                        </div>
                    </div>
                </section>

                <!-- ─── Google Maps ─── -->
                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Google Maps</h2>
                    <p class="text-xs text-gray-500">
                        Go to <strong>Google Maps</strong> → search your location → Share → Embed a map → copy only the <code class="bg-gray-100 px-1 rounded">src="..."</code> URL.
                    </p>
                    <div>
                        <label class="label">Maps Embed URL (src value only)</label>
                        <textarea v-model="form.contact_map_embed" rows="3" class="input resize-none font-mono text-xs"
                            placeholder="https://www.google.com/maps/embed?pb=..."></textarea>
                        <InputError :message="form.errors.contact_map_embed" />
                    </div>
                    <!-- Live preview -->
                    <div v-if="form.contact_map_embed" class="mt-2 rounded-lg overflow-hidden border border-gray-200 h-48">
                        <iframe :src="form.contact_map_embed"
                            class="w-full h-full"
                            allowfullscreen loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Map preview">
                        </iframe>
                    </div>
                    <div>
                        <label class="label">"Open in Maps" Link URL <span class="text-xs text-gray-400">(the button above the map)</span></label>
                        <input v-model="form.contact_map_open_url" type="text" class="input"
                            placeholder="https://www.google.com/maps?q=..." />
                        <InputError :message="form.errors.contact_map_open_url" />
                    </div>
                </section>

                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Saving...' : 'Save Contact Settings' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import InputError   from '@/Components/InputError.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';

const props = defineProps({
    settings: { type: Object, required: true },
});

const s = props.settings;

const form = useForm({
    // Hero
    contact_hero_title:       s.contact_hero_title       ?? '',
    contact_hero_image:       null,
    // Main content
    contact_title:            s.contact_title            ?? '',
    contact_desc:             s.contact_desc             ?? '',
    contact_talk_text:        s.contact_talk_text        ?? '',
    contact_rating_score:     s.contact_rating_score     ?? '',
    contact_rating_text:      s.contact_rating_text      ?? '',
    // SEO
    contact_seo_title:        s.contact_seo_title        ?? '',
    contact_seo_description:  s.contact_seo_description  ?? '',
    contact_seo_keywords:     s.contact_seo_keywords     ?? '',
    contact_seo_og_image:     null,
    // Phone
    footer_phone_1:         s.footer_phone_1         ?? '',
    footer_phone_2:         s.footer_phone_2         ?? '',
    footer_phone_3:         s.footer_phone_3         ?? '',
    // Email
    footer_email_1:         s.footer_email_1         ?? '',
    footer_email_2:         s.footer_email_2         ?? '',
    // Address
    footer_address_line1:   s.footer_address_line1   ?? '',
    footer_address_line2:   s.footer_address_line2   ?? '',
    // Social
    footer_facebook_url:    s.footer_facebook_url    ?? '',
    footer_twitter_url:     s.footer_twitter_url     ?? '',
    footer_instagram_url:   s.footer_instagram_url   ?? '',
    footer_youtube_url:     s.footer_youtube_url     ?? '',
    // Form
    contact_form_title:     s.contact_form_title     ?? '',
    contact_form_btn_text:  s.contact_form_btn_text  ?? '',
    // Map
    contact_map_embed:      s.contact_map_embed      ?? '',
    contact_map_open_url:   s.contact_map_open_url   ?? '',
});

const socials = [
    {
        key: 'footer_facebook_url', label: 'Facebook URL',
        placeholder: 'https://facebook.com/clinicmaster',
        icon: `<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>`,
    },
    {
        key: 'footer_twitter_url', label: 'Twitter / X URL',
        placeholder: 'https://x.com/clinicmaster',
        icon: `<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>`,
    },
    {
        key: 'footer_instagram_url', label: 'Instagram URL',
        placeholder: 'https://instagram.com/clinicmaster',
        icon: `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>`,
    },
    {
        key: 'footer_youtube_url', label: 'YouTube URL',
        placeholder: 'https://youtube.com/@clinicmaster',
        icon: `<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#fff"/></svg>`,
    },
];

function onImg(type, file) {
    if (!file) return;
    if (type === 'hero') { form.contact_hero_image  = file; }
    if (type === 'og')   { form.contact_seo_og_image = file; }
}

function submit() {
    form.post(route('admin.website-settings.contact.update'), {
        forceFormData: true,
    });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
