<template>
    <AdminLayout>
        <div class="max-w-4xl space-y-6">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Email Notification Settings</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Control which automatic emails are sent when a visitor submits a contact or inquiry form.
                </p>
            </div>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">

                <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700 border-b pb-2">Inquiry Notifications</h2>
                    <div class="flex flex-col gap-2">
                        <label class="toggle-row">
                            <input type="checkbox" v-model="form.email_toggle_new_inquiry_customer">
                            <span>Send confirmation to customer on new contact/inquiry submission</span>
                        </label>
                        <label class="toggle-row">
                            <input type="checkbox" v-model="form.email_toggle_new_inquiry_admin">
                            <span>Notify admin on new contact/inquiry submission</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-400">
                        Admin recipient addresses are configured on the
                        <a :href="route('admin.website-settings.mail.edit')" class="text-blue-600 hover:underline">Email SMTP Settings</a>
                        page ("Admin Receiver Emails").
                    </p>
                </section>

                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                        {{ form.processing ? 'Saving...' : 'Save Settings' }}
                    </button>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';

const props = defineProps({
    settings: { type: Object, default: () => ({}) },
});

const form = useForm({ ...props.settings });

function submit() {
    form.transform(data => ({ ...data, _method: 'PUT' }))
        .post(route('admin.website-settings.email-notifications.update'));
}
</script>

<style scoped>
.toggle-row { @apply flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer; }
.toggle-row input[type="checkbox"] { @apply w-4 h-4; }
</style>
