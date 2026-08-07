<template>
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Video Gallery CMS</h1>
                    <p class="text-xs text-gray-500 mt-1">Manage hospital documentaries, patient stories, health tips & surgical videos</p>
                </div>
                <button v-if="activeTab === 'videos'" @click="openCreateModal" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-xs transition-all flex items-center gap-2">
                    <span>+</span> Add Video
                </button>
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200 flex gap-6">
                <button @click="activeTab = 'videos'" :class="activeTab === 'videos' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 text-sm border-b-2 transition-colors">
                    Videos Catalog ({{ videos.length }})
                </button>
                <button @click="activeTab = 'page_settings'" :class="activeTab === 'page_settings' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-3 text-sm border-b-2 transition-colors">
                    Page & SEO Settings
                </button>
            </div>

            <!-- 1. Videos Catalog Tab -->
            <div v-if="activeTab === 'videos'" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div v-for="video in videos" :key="video.id" class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden group hover:shadow-md transition-all flex flex-col">
                        <!-- Thumbnail Preview -->
                        <div class="relative aspect-video bg-gray-900 overflow-hidden">
                            <img v-if="video.thumbnail_image" :src="video.thumbnail_image.startsWith('http') ? video.thumbnail_image : '/storage/' + video.thumbnail_image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            <div v-else class="w-full h-full flex items-center justify-center text-gray-600 text-3xl">
                                🎬
                            </div>
                            <!-- Play Icon Badge -->
                            <a :href="video.video_url" target="_blank" class="absolute inset-0 m-auto w-12 h-12 rounded-full bg-red-600/90 text-white flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </a>
                            <!-- Type Badge -->
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-2xs font-bold uppercase bg-black/60 text-white backdrop-blur-xs">
                                {{ video.video_type }}
                            </span>
                            <span v-if="video.duration" class="absolute bottom-2 right-2 px-2 py-0.5 rounded text-2xs font-mono bg-black/70 text-white">
                                {{ video.duration }}
                            </span>
                        </div>

                        <!-- Info -->
                        <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm line-clamp-1">{{ localized(video.title) }}</h3>
                                <p v-if="video.subtitle" class="text-xs text-gray-500 mt-1 line-clamp-2">{{ localized(video.subtitle) }}</p>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-xs">
                                <span :class="video.is_active ? 'text-emerald-700 bg-emerald-50' : 'text-gray-500 bg-gray-100'" class="px-2 py-0.5 rounded font-semibold">
                                    {{ video.is_active ? 'Active' : 'Hidden' }}
                                </span>

                                <div class="flex items-center gap-2">
                                    <button @click="openEditModal(video)" class="p-1 text-gray-500 hover:text-blue-600">
                                        ✏️ Edit
                                    </button>
                                    <button @click="confirmDelete(video)" class="p-1 text-gray-500 hover:text-red-600">
                                        🗑️ Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="videos.length === 0" class="text-center py-16 bg-white rounded-2xl border border-gray-200 text-gray-400">
                    <div class="text-4xl mb-2">🎥</div>
                    No videos added yet. Click "+ Add Video" to publish a video.
                </div>
            </div>

            <!-- 2. Page & SEO Settings Tab -->
            <div v-if="activeTab === 'page_settings'" class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-6 max-w-3xl">
                <!-- Language Selector -->
                <div class="flex border-b gap-4">
                    <button v-for="lang in languages" :key="lang.code" type="button" @click="activeLang = lang.code" :class="activeLang === lang.code ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500'" class="pb-2 text-xs border-b-2 uppercase">
                        {{ lang.name }} ({{ lang.code }})
                    </button>
                </div>

                <form @submit.prevent="savePageSettings" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Hero Title ({{ activeLang }})</label>
                        <input v-model="pageForm.video_gallery_hero_title[activeLang]" type="text" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="e.g. Hospital Video Gallery" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Hero Subtitle ({{ activeLang }})</label>
                        <textarea v-model="pageForm.video_gallery_hero_subtitle[activeLang]" rows="2" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Watch our latest surgeries, medical technology showcases, and patient testimonials..."></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Banner / Background Image</label>
                        <input type="file" @change="e => pageForm.video_gallery_banner_image = e.target.files[0]" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700" />
                    </div>

                    <div class="border-t pt-4 space-y-4">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-700">Search Engine Optimization (SEO)</h4>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">SEO Title ({{ activeLang }})</label>
                            <input v-model="pageForm.video_gallery_seo_title[activeLang]" type="text" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">SEO Meta Description ({{ activeLang }})</label>
                            <textarea v-model="pageForm.video_gallery_seo_description[activeLang]" rows="2" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" :disabled="pageForm.processing" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs transition-all">
                            Save Gallery Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Create / Edit Video Modal -->
            <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs">
                <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h3 class="font-bold text-gray-900 text-lg">{{ editingVideo ? 'Edit Video' : 'Add Video to Gallery' }}</h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                    </div>

                    <!-- Language selector -->
                    <div class="flex border-b gap-4">
                        <button v-for="lang in languages" :key="lang.code" type="button" @click="activeLang = lang.code" :class="activeLang === lang.code ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500'" class="pb-2 text-xs border-b-2 uppercase">
                            {{ lang.name }} ({{ lang.code }})
                        </button>
                    </div>

                    <form @submit.prevent="saveVideo" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Video Title ({{ activeLang }}) *</label>
                            <input v-model="videoForm.title[activeLang]" type="text" required placeholder="e.g. Advanced Cardiac Surgery Unit Tour" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Subtitle / Short Description ({{ activeLang }})</label>
                            <textarea v-model="videoForm.subtitle[activeLang]" rows="2" placeholder="Brief caption..." class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Platform</label>
                                <select v-model="videoForm.video_type" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                    <option value="youtube">YouTube</option>
                                    <option value="vimeo">Vimeo</option>
                                    <option value="custom">MP4 / Direct Link</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Duration (e.g. 05:24)</label>
                                <input v-model="videoForm.duration" type="text" placeholder="05:30" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Video URL *</label>
                            <input v-model="videoForm.video_url" type="url" required placeholder="https://www.youtube.com/watch?v=..." class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono text-xs" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Custom Thumbnail Image (Optional)</label>
                            <input type="file" accept="image/*" @change="e => videoForm.thumbnail_image = e.target.files[0]" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700" />
                        </div>

                        <div class="flex items-center gap-4 pt-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input v-model="videoForm.is_featured" type="checkbox" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500" />
                                <span class="text-xs font-medium text-gray-700">Featured Video</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input v-model="videoForm.is_active" type="checkbox" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500" />
                                <span class="text-xs font-medium text-gray-700">Active / Published</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3 border-t">
                            <button type="button" @click="showModal = false" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                            <button type="submit" :disabled="videoForm.processing" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-xs">
                                {{ editingVideo ? 'Update' : 'Publish' }} Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    videos:       { type: Array, default: () => [] },
    languages:    { type: Array, default: () => [{ code: 'en', name: 'English' }] },
    pageSettings: { type: Object, default: () => ({}) },
});

const activeTab = ref('videos');
const activeLang = ref(props.languages[0]?.code || 'en');
const showModal = ref(false);
const editingVideo = ref(null);

function localized(field) {
    if (!field) return '';
    if (typeof field === 'string') return field;
    return field[activeLang.value] || field['en'] || Object.values(field)[0] || '';
}

const videoForm = useForm({
    title: {},
    subtitle: {},
    video_type: 'youtube',
    video_url: '',
    thumbnail_image: null,
    duration: '',
    is_featured: false,
    is_active: true,
});

function openCreateModal() {
    editingVideo.value = null;
    videoForm.reset();
    videoForm.title = {};
    videoForm.subtitle = {};
    props.languages.forEach(l => {
        videoForm.title[l.code] = '';
        videoForm.subtitle[l.code] = '';
    });
    videoForm.video_type = 'youtube';
    videoForm.is_active = true;
    showModal.value = true;
}

function openEditModal(video) {
    editingVideo.value = video;
    videoForm.title = typeof video.title === 'object' ? { ...video.title } : { en: video.title };
    videoForm.subtitle = typeof video.subtitle === 'object' ? { ...video.subtitle } : { en: video.subtitle };
    props.languages.forEach(l => {
        if (!videoForm.title[l.code]) videoForm.title[l.code] = '';
        if (!videoForm.subtitle[l.code]) videoForm.subtitle[l.code] = '';
    });
    videoForm.video_type = video.video_type || 'youtube';
    videoForm.video_url = video.video_url;
    videoForm.duration = video.duration || '';
    videoForm.is_featured = Boolean(video.is_featured);
    videoForm.is_active = Boolean(video.is_active);
    showModal.value = true;
}

function saveVideo() {
    if (editingVideo.value) {
        videoForm.transform(data => ({ ...data, _method: 'PUT' }))
            .post(route('admin.website-settings.video-gallery.update', editingVideo.value.id), {
                forceFormData: true,
                onSuccess: () => { showModal.value = false; }
            });
    } else {
        videoForm.post(route('admin.website-settings.video-gallery.store'), {
            forceFormData: true,
            onSuccess: () => { showModal.value = false; }
        });
    }
}

function confirmDelete(v) {
    if (confirm(`Delete video "${localized(v.title)}"?`)) {
        router.delete(route('admin.website-settings.video-gallery.destroy', v.id));
    }
}

// Page Settings Form
const pageForm = useForm({
    video_gallery_hero_title: typeof props.pageSettings.video_gallery_hero_title === 'object' ? { ...props.pageSettings.video_gallery_hero_title } : { en: props.pageSettings.video_gallery_hero_title || 'Video Gallery' },
    video_gallery_hero_subtitle: typeof props.pageSettings.video_gallery_hero_subtitle === 'object' ? { ...props.pageSettings.video_gallery_hero_subtitle } : { en: props.pageSettings.video_gallery_hero_subtitle || '' },
    video_gallery_banner_image: null,
    video_gallery_seo_title: typeof props.pageSettings.video_gallery_seo_title === 'object' ? { ...props.pageSettings.video_gallery_seo_title } : { en: props.pageSettings.video_gallery_seo_title || '' },
    video_gallery_seo_description: typeof props.pageSettings.video_gallery_seo_description === 'object' ? { ...props.pageSettings.video_gallery_seo_description } : { en: props.pageSettings.video_gallery_seo_description || '' },
});

props.languages.forEach(l => {
    if (!pageForm.video_gallery_hero_title[l.code]) pageForm.video_gallery_hero_title[l.code] = '';
    if (!pageForm.video_gallery_hero_subtitle[l.code]) pageForm.video_gallery_hero_subtitle[l.code] = '';
    if (!pageForm.video_gallery_seo_title[l.code]) pageForm.video_gallery_seo_title[l.code] = '';
    if (!pageForm.video_gallery_seo_description[l.code]) pageForm.video_gallery_seo_description[l.code] = '';
});

function savePageSettings() {
    pageForm.post(route('admin.website-settings.video-gallery.settings'), {
        forceFormData: true,
        preserveScroll: true,
    });
}
</script>
