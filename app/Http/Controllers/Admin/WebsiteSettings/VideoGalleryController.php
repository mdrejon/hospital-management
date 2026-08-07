<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use App\Models\Language;
use App\Models\VideoGallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class VideoGalleryController extends Controller
{
    private array $pageSettingKeys = [
        'video_gallery_hero_title',
        'video_gallery_hero_subtitle',
        'video_gallery_banner_image',
        'video_gallery_seo_title',
        'video_gallery_seo_description',
        'video_gallery_seo_keywords',
    ];

    public function index(): Response
    {
        $videos = VideoGallery::orderBy('sort_order')->orderBy('id')->get();

        $pageSettings = [];
        foreach ($this->pageSettingKeys as $key) {
            $pageSettings[$key] = GlobalSetting::get($key, '');
        }

        return Inertia::render('Admin/WebsiteSettings/VideoGallery/Index', [
            'videos'       => $videos,
            'languages'    => Language::active(),
            'pageSettings' => $pageSettings,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $defaultLocale = config('app.locale', 'en');
        $validated = $request->validate([
            'title'           => ['required', 'array'],
            'title.' . $defaultLocale => ['required', 'string', 'max:255'],
            'subtitle'        => ['nullable', 'array'],
            'video_type'      => ['required', 'in:youtube,vimeo,custom'],
            'video_url'       => ['required', 'string'],
            'thumbnail_image' => ['nullable', 'file', 'image', 'max:5120'],
            'duration'        => ['nullable', 'string', 'max:20'],
            'is_featured'     => ['boolean'],
            'is_active'       => ['boolean'],
        ]);

        $extracted = VideoGallery::extractVideoDetails($validated['video_url'], $validated['video_type']);
        $validated['video_id'] = $extracted['video_id'];

        if ($request->hasFile('thumbnail_image')) {
            $validated['thumbnail_image'] = $request->file('thumbnail_image')->store('video-gallery', 'public');
        } elseif (!empty($extracted['thumbnail'])) {
            $validated['thumbnail_image'] = $extracted['thumbnail'];
        }

        $validated['sort_order'] = (VideoGallery::max('sort_order') ?? 0) + 1;

        VideoGallery::create($validated);

        return back()->with('success', 'Video added to gallery successfully.');
    }

    public function update(Request $request, VideoGallery $videoGallery): RedirectResponse
    {
        $defaultLocale = config('app.locale', 'en');
        $validated = $request->validate([
            'title'           => ['required', 'array'],
            'title.' . $defaultLocale => ['required', 'string', 'max:255'],
            'subtitle'        => ['nullable', 'array'],
            'video_type'      => ['required', 'in:youtube,vimeo,custom'],
            'video_url'       => ['required', 'string'],
            'thumbnail_image' => ['nullable', 'file', 'image', 'max:5120'],
            'duration'        => ['nullable', 'string', 'max:20'],
            'is_featured'     => ['boolean'],
            'is_active'       => ['boolean'],
        ]);

        $extracted = VideoGallery::extractVideoDetails($validated['video_url'], $validated['video_type']);
        $validated['video_id'] = $extracted['video_id'];

        if ($request->hasFile('thumbnail_image')) {
            if ($videoGallery->thumbnail_image && !str_starts_with($videoGallery->thumbnail_image, 'http') && Storage::disk('public')->exists($videoGallery->thumbnail_image)) {
                Storage::disk('public')->delete($videoGallery->thumbnail_image);
            }
            $validated['thumbnail_image'] = $request->file('thumbnail_image')->store('video-gallery', 'public');
        }

        $videoGallery->update($validated);

        return back()->with('success', 'Video updated successfully.');
    }

    public function destroy(VideoGallery $videoGallery): RedirectResponse
    {
        if ($videoGallery->thumbnail_image && !str_starts_with($videoGallery->thumbnail_image, 'http') && Storage::disk('public')->exists($videoGallery->thumbnail_image)) {
            Storage::disk('public')->delete($videoGallery->thumbnail_image);
        }

        $videoGallery->delete();

        return back()->with('success', 'Video deleted from gallery.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $request->validate([
            'ordered_ids'   => ['required', 'array'],
            'ordered_ids.*' => ['integer', 'exists:video_galleries,id'],
        ]);

        foreach ($request->input('ordered_ids') as $index => $id) {
            VideoGallery::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return back()->with('success', 'Video gallery order updated.');
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'video_gallery_hero_title'      => ['nullable', 'string', 'max:255'],
            'video_gallery_hero_subtitle'   => ['nullable', 'string', 'max:255'],
            'video_gallery_banner_image'    => ['nullable', 'file', 'image', 'max:5120'],
            'video_gallery_seo_title'       => ['nullable', 'string', 'max:255'],
            'video_gallery_seo_description' => ['nullable', 'string'],
            'video_gallery_seo_keywords'    => ['nullable', 'string'],
        ]);

        if ($request->hasFile('video_gallery_banner_image')) {
            $old = GlobalSetting::get('video_gallery_banner_image');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $validated['video_gallery_banner_image'] = $request->file('video_gallery_banner_image')->store('banners', 'public');
        }

        GlobalSetting::setMany($validated);

        return back()->with('success', 'Video gallery settings saved.');
    }
}
