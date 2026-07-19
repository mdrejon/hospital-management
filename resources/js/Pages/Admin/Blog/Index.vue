<template>
    <AdminLayout>
        <div class="max-w-6xl space-y-4">
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-800">Blog Management</h1>
                <Link v-if="tab === 'list'" :href="route('admin.blog.create')"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                    + Add New Post
                </Link>
            </div>

            <div v-if="$page.props.flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200 flex gap-6">
                <button type="button" @click="tab = 'list'"
                    :class="tab === 'list' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2.5 text-sm font-medium border-b-2 transition-colors">
                    Blog Posts List
                </button>
                <button type="button" @click="tab = 'settings'"
                    :class="tab === 'settings' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2.5 text-sm font-medium border-b-2 transition-colors">
                    Page Settings
                </button>
            </div>

            <!-- ═══════════ Blog Posts List tab ═══════════ -->
            <div v-if="tab === 'list'" class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Post</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Category</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-if="blogs.length === 0">
                            <td colspan="5" class="text-center py-10 text-gray-400 text-sm">No posts yet. <Link :href="route('admin.blog.create')" class="text-blue-600 hover:underline">Create your first post</Link>.</td>
                        </tr>
                        <tr v-for="blog in blogs" :key="blog.id" class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img v-if="blog.feature_image"
                                        :src="'/storage/' + blog.feature_image"
                                        class="w-14 h-10 object-cover rounded border border-gray-200 flex-shrink-0" />
                                    <div v-else
                                        class="w-14 h-10 bg-gray-100 rounded border border-gray-200 flex-shrink-0 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 line-clamp-1">{{ blog.title }}</p>
                                        <p class="text-xs text-gray-400">/blog/{{ blog.slug }}</p>
                                        <span v-if="blog.is_featured" class="inline-block text-xs text-yellow-600 bg-yellow-50 border border-yellow-200 rounded px-1.5 py-0.5 mt-0.5">★ Featured</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ blog.category || '—' }}</td>
                            <td class="px-4 py-3">
                                <span :class="[
                                    'inline-block text-xs rounded-full px-2.5 py-1 font-medium',
                                    blog.status === 'published'
                                        ? 'bg-green-50 text-green-700 border border-green-200'
                                        : 'bg-amber-50 text-amber-700 border border-amber-200'
                                ]">
                                    {{ blog.status === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs">{{ blog.published_at || '—' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" @click="toggleStatus(blog)"
                                        :class="[
                                            'text-xs px-2.5 py-1 rounded border font-medium transition-colors',
                                            blog.status === 'published'
                                                ? 'border-amber-300 text-amber-700 hover:bg-amber-50'
                                                : 'border-green-300 text-green-700 hover:bg-green-50'
                                        ]">
                                        {{ blog.status === 'published' ? 'Unpublish' : 'Publish' }}
                                    </button>
                                    <Link :href="route('admin.blog.comments', blog.id)"
                                        class="relative text-xs px-2.5 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50 font-medium">
                                        Comments
                                        <span v-if="blog.pending_comments > 0"
                                            class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">
                                            {{ blog.pending_comments }}
                                        </span>
                                    </Link>
                                    <Link :href="route('admin.blog.edit', blog.id)"
                                        class="text-xs px-2.5 py-1 rounded border border-blue-300 text-blue-700 hover:bg-blue-50 font-medium">
                                        Edit
                                    </Link>
                                    <button type="button" @click="deletePost(blog)"
                                        class="text-xs px-2.5 py-1 rounded border border-red-300 text-red-600 hover:bg-red-50 font-medium">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ═══════════ Page Settings tab ═══════════ -->
            <div v-else class="max-w-3xl space-y-4">
                <form @submit.prevent="submitSettings" enctype="multipart/form-data" class="space-y-4">

                    <!-- Home Page Blog Section -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Home Page — Blog Preview Section</h2>
                        <p class="text-xs text-gray-400 -mt-2">Shows your 4 most recent published posts.</p>
                        <div>
                            <label class="label">Section Title</label>
                            <input v-model="settingsForm.blog_home_title" type="text" class="input" placeholder="Stay Informed With Our Latest Health Blogs" />
                            <InputError :message="settingsForm.errors.blog_home_title" />
                        </div>
                    </section>

                    <!-- Page Hero & Breadcrumb -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Blog List Page — Hero &amp; Breadcrumb</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 md:col-span-1">
                                <label class="label">Hero Background Image</label>
                                <DropZone @change="file => onImg('hero', file)" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-44 object-cover"
                                    :existing-preview="currentHeroImg ? '/storage/' + currentHeroImg : null" />
                                <InputError :message="settingsForm.errors.blog_hero_image" />
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="label">Page Title (Breadcrumb)</label>
                                <input v-model="settingsForm.blog_hero_title" type="text" class="input" placeholder="Our Blog" />
                                <InputError :message="settingsForm.errors.blog_hero_title" />
                            </div>
                        </div>
                    </section>

                    <!-- SEO Configuration -->
                    <section class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Blog List Page — SEO Configuration</h2>
                        <div>
                            <label class="label">Meta Title <span class="text-xs text-gray-400">(max 160 chars, auto-filled if left blank)</span></label>
                            <input v-model="settingsForm.blog_seo_title" @input="onMetaTitleInput" type="text" maxlength="160" class="input"
                                placeholder="Blog | ClinicMaster Medical & Health Care Services" />
                            <p class="text-xs text-gray-400 mt-1">{{ (settingsForm.blog_seo_title || '').length }}/160</p>
                            <InputError :message="settingsForm.errors.blog_seo_title" />
                        </div>
                        <div>
                            <label class="label">Meta Description <span class="text-xs text-gray-400">(max 320 chars)</span></label>
                            <textarea v-model="settingsForm.blog_seo_description" @input="onMetaDescInput" rows="3" maxlength="320" class="input resize-none"
                                placeholder="Read the latest health tips, medical insights, and hospital news from ClinicMaster..."></textarea>
                            <p class="text-xs text-gray-400 mt-1">{{ (settingsForm.blog_seo_description || '').length }}/320</p>
                            <InputError :message="settingsForm.errors.blog_seo_description" />
                        </div>
                        <div>
                            <label class="label">Meta Keywords <span class="text-xs text-gray-400">(comma-separated, auto-filled if left blank)</span></label>
                            <input v-model="settingsForm.blog_seo_keywords" @input="onMetaKeywordsInput" type="text" class="input"
                                placeholder="health blog, medical tips, clinicmaster news" />
                            <InputError :message="settingsForm.errors.blog_seo_keywords" />
                        </div>
                        <div>
                            <label class="label">OG / Social Share Image <span class="text-xs text-gray-400">(recommended 1200×630px)</span></label>
                            <DropZone @change="file => onImg('og', file)" hint="JPEG / PNG / WebP — max 5 MB" preview-class="w-full h-36 object-cover"
                                :existing-preview="currentOgImg ? '/storage/' + currentOgImg : null" />
                            <InputError :message="settingsForm.errors.blog_seo_og_image" />
                        </div>
                    </section>

                    <div class="flex justify-end">
                        <button type="submit" :disabled="settingsForm.processing"
                            class="px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 disabled:opacity-60">
                            {{ settingsForm.processing ? 'Saving...' : 'Save Settings' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirm Modal -->
        <div v-if="deletingBlog" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm">
                <h3 class="text-base font-semibold text-gray-800 mb-2">Delete Post</h3>
                <p class="text-sm text-gray-600 mb-5">
                    Are you sure you want to delete <strong>{{ deletingBlog.title }}</strong>? This cannot be undone.
                </p>
                <div class="flex justify-end gap-3">
                    <button @click="deletingBlog = null"
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
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import DropZone from '@/Components/Admin/Shared/DropZone.vue';
import { useSeoAutoFill } from '@/Composables/useSeoAutoFill';

const props = defineProps({
    blogs:        { type: Array,  default: () => [] },
    pageSettings: { type: Object, default: () => ({}) },
});

const tab = ref('list');
const deletingBlog = ref(null);

function toggleStatus(blog) {
    router.patch(route('admin.blog.toggle', blog.id));
}

function deletePost(blog) {
    deletingBlog.value = blog;
}

function confirmDelete() {
    router.delete(route('admin.blog.destroy', deletingBlog.value.id), {
        onFinish: () => { deletingBlog.value = null; },
    });
}

// ── Page Settings tab ──
const currentHeroImg = ref(props.pageSettings.blog_hero_image  ?? null);
const currentOgImg   = ref(props.pageSettings.blog_seo_og_image ?? null);

const settingsForm = useForm({
    blog_home_title:      props.pageSettings.blog_home_title      ?? '',
    blog_hero_title:      props.pageSettings.blog_hero_title      ?? '',
    blog_seo_title:       props.pageSettings.blog_seo_title       ?? '',
    blog_seo_description: props.pageSettings.blog_seo_description ?? '',
    blog_seo_keywords:    props.pageSettings.blog_seo_keywords    ?? '',
    blog_hero_image:      null,
    blog_seo_og_image:    null,
});

const { onMetaTitleInput, onMetaDescInput, onMetaKeywordsInput } = useSeoAutoFill(settingsForm, {
    titleSource: () => settingsForm.blog_hero_title,
    descSource:  () => settingsForm.blog_seo_description,
    titleKey:    'blog_seo_title',
    descKey:     'blog_seo_description',
    keywordsKey: 'blog_seo_keywords',
    titleSuffix: ' | ClinicMaster',
});

function onImg(type, file) {
    if (!file) return;
    if (type === 'hero') settingsForm.blog_hero_image   = file;
    if (type === 'og')   settingsForm.blog_seo_og_image = file;
}

function submitSettings() {
    settingsForm.post(route('admin.website-settings.blog-page.update'), {
        forceFormData: true,
        preserveScroll: true,
    });
}
</script>

<style scoped>
.label { @apply block text-sm text-gray-600 mb-1; }
.input { @apply w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none; }
</style>
