<script setup>
import { useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ColorPicker } from "vue3-colorpicker";
import "vue3-colorpicker/style.css";

const props = defineProps({
    settings: {
        type: Object,
        default: () => ({}),
    },
});

const defaultColors = {
    theme_color_primary: '#0072BB',
    theme_color_secondary: '#EEF3F8',
    theme_color_navy: '#003354',
    theme_color_navy_dark: '#002238',
    theme_color_accent_green: '#87C540',
    theme_color_accent_red: '#ED1B24',
};

const form = useForm({
    theme_color_primary: props.settings.theme_color_primary || defaultColors.theme_color_primary,
    theme_color_secondary: props.settings.theme_color_secondary || defaultColors.theme_color_secondary,
    theme_color_navy: props.settings.theme_color_navy || defaultColors.theme_color_navy,
    theme_color_navy_dark: props.settings.theme_color_navy_dark || defaultColors.theme_color_navy_dark,
    theme_color_accent_green: props.settings.theme_color_accent_green || defaultColors.theme_color_accent_green,
    theme_color_accent_red: props.settings.theme_color_accent_red || defaultColors.theme_color_accent_red,
});

const submit = () => {
    form.post(route('admin.website-settings.theme.update'), {
        preserveScroll: true,
    });
};

const resetToDefault = () => {
    if (confirm('Are you sure you want to remove all custom colors and revert to the default theme?')) {
        router.post(route('admin.website-settings.theme.reset'), {}, {
            preserveScroll: true,
            onSuccess: () => {
                Object.assign(form, defaultColors);
            }
        });
    }
};
</script>

<template>
    <AdminLayout title="Theme Settings">
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Frontend Theme Colors</h2>
                <p class="text-gray-600 mb-6 text-sm">
                    Customize the look and feel of the frontend website by selecting your preferred colors using the color picker or typing a HEX code (e.g., #2563eb).
                </p>

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Primary Color -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Primary Color</label>
                            <div class="flex items-center space-x-3">
                                <color-picker v-model:pureColor="form.theme_color_primary" format="hex" shape="square" disableAlpha />
                                <input type="text" v-model="form.theme_color_primary" placeholder="#FFFFFF" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm uppercase" maxlength="7">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Used for buttons, main links, and highlights.</p>
                        </div>

                        <!-- Secondary Color -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Color (Footer Background)</label>
                            <div class="flex items-center space-x-3">
                                <color-picker v-model:pureColor="form.theme_color_secondary" format="hex" shape="square" disableAlpha />
                                <input type="text" v-model="form.theme_color_secondary" placeholder="#FFFFFF" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm uppercase" maxlength="7">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Used for footer backgrounds and secondary elements.</p>
                        </div>

                        <!-- Navy Color -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Navy Color (Main Text)</label>
                            <div class="flex items-center space-x-3">
                                <color-picker v-model:pureColor="form.theme_color_navy" format="hex" shape="square" disableAlpha />
                                <input type="text" v-model="form.theme_color_navy" placeholder="#FFFFFF" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm uppercase" maxlength="7">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Main text color and headings.</p>
                        </div>

                        <!-- Navy Dark Color -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dark Navy Color</label>
                            <div class="flex items-center space-x-3">
                                <color-picker v-model:pureColor="form.theme_color_navy_dark" format="hex" shape="square" disableAlpha />
                                <input type="text" v-model="form.theme_color_navy_dark" placeholder="#FFFFFF" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm uppercase" maxlength="7">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Darker variant for contrast.</p>
                        </div>

                        <!-- Accent Green -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Accent Green Color</label>
                            <div class="flex items-center space-x-3">
                                <color-picker v-model:pureColor="form.theme_color_accent_green" format="hex" shape="square" disableAlpha />
                                <input type="text" v-model="form.theme_color_accent_green" placeholder="#FFFFFF" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm uppercase" maxlength="7">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Used for success states and accents.</p>
                        </div>

                        <!-- Accent Red -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Accent Red Color</label>
                            <div class="flex items-center space-x-3">
                                <color-picker v-model:pureColor="form.theme_color_accent_red" format="hex" shape="square" disableAlpha />
                                <input type="text" v-model="form.theme_color_accent_red" placeholder="#FFFFFF" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm uppercase" maxlength="7">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Used for error states and specific accents.</p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button"
                                @click="resetToDefault"
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Reset to Default
                        </button>
                        <button type="submit"
                                :disabled="form.processing"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                            {{ form.processing ? 'Saving...' : 'Save Settings' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
