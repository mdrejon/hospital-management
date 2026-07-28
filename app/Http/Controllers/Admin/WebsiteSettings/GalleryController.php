<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Models\GlobalSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class GalleryController extends Controller
{
    private array $sectionKeys = [
        'gallery_badge', 'gallery_title', 'gallery_subtitle',
        'gallery_hero_image', 'gallery_hero_title',
        'gallery_seo_title', 'gallery_seo_description', 'gallery_seo_keywords', 'gallery_seo_og_image',
    ];

    /** Human-readable copy shown to visitors — edited per-locale. */
    private array $translatableKeys = [
        'gallery_badge', 'gallery_title', 'gallery_subtitle', 'gallery_hero_title',
        'gallery_seo_title', 'gallery_seo_description',
    ];

    public function index(): Response
    {
        $images = GalleryImage::orderBy('sort_order')->orderBy('id')->get();

        $settings = GlobalSetting::whereIn('key', $this->sectionKeys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->sectionKeys as $key) {
            $settings[$key] ??= null;
        }

        foreach ($this->translatableKeys as $key) {
            $settings[$key] = GlobalSetting::getTranslatedArray($key);
        }

        return Inertia::render('Admin/WebsiteSettings/Gallery/Index', [
            'images'   => $images,
            'settings' => $settings,
        ]);
    }

    /** Upload one or more images at once */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'images'    => 'required|array|min:1',
            'images.*'  => 'image|mimes:jpeg,jpg,png,webp',
        ]);

        $nextOrder = (GalleryImage::max('sort_order') ?? -1) + 1;

        foreach ($request->file('images') as $file) {
            GalleryImage::create([
                'image'      => $file->store('gallery', 'public'),
                'alt'        => $request->input('alt', ''),
                'sort_order' => $nextOrder++,
                'is_active'  => true,
            ]);
        }

        return back()->with('success', 'Gallery image(s) uploaded successfully.');
    }

    /** Update alt / sub_title / caption(title) / sort_order for a single image */
    public function update(Request $request, GalleryImage $gallery): RedirectResponse
    {
        $data = $request->validate([
            'alt'          => 'nullable|array',
            'alt.*'        => 'nullable|string',
            'sub_title'    => 'nullable|array',
            'sub_title.*'  => 'nullable|string',
            'caption'      => 'nullable|array',
            'caption.*'    => 'nullable|string',
            'sort_order' => 'integer|min:0',
        ]);

        $gallery->update($data);

        return back()->with('success', 'Gallery image updated.');
    }

    public function destroy(GalleryImage $gallery): RedirectResponse
    {
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return back()->with('success', 'Gallery image deleted.');
    }

    public function toggleStatus(GalleryImage $gallery): RedirectResponse
    {
        $gallery->update(['is_active' => !$gallery->is_active]);

        return back()->with('success', 'Gallery image status updated.');
    }

    /** Save section header + hero + SEO settings */
    public function updateSettings(Request $request): RedirectResponse
    {
        $rules = [
            'gallery_seo_keywords'    => 'nullable|string',
            'gallery_hero_image'      => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'gallery_seo_og_image'    => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ];
        foreach ($this->translatableKeys as $key) {
            $rules[$key] = 'nullable|array';
            $rules["$key.*"] = 'nullable|string';
        }

        $data = $request->validate($rules);

        foreach (['gallery_hero_image', 'gallery_seo_og_image'] as $imgKey) {
            if ($request->hasFile($imgKey)) {
                $existing = GlobalSetting::get($imgKey);
                if ($existing) {
                    Storage::disk('public')->delete($existing);
                }
                $data[$imgKey] = $request->file($imgKey)->store('settings', 'public');
            } else {
                unset($data[$imgKey]);
            }
        }

        foreach ($this->translatableKeys as $key) {
            if (array_key_exists($key, $data)) {
                GlobalSetting::setTranslated($key, $data[$key] ?? []);
                unset($data[$key]);
            }
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Gallery settings saved.');
    }

    /** Bulk reorder: receives [{id, sort_order}, ...] */
    public function reorder(Request $request): RedirectResponse
    {
        $request->validate([
            'order'            => 'required|array',
            'order.*.id'       => 'required|integer|exists:gallery_images,id',
            'order.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->input('order') as $item) {
            GalleryImage::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return back()->with('success', 'Gallery order saved.');
    }
}
