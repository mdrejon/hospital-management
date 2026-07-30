<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\GlobalSetting;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AwardController extends Controller
{
    private array $sectionKeys = [
        'award_badge', 'award_title', 'award_desc',
        'ach_award_title', 'ach_award_desc',
    ];

    /** Human-readable copy shown to visitors — edited per-locale. */
    private array $translatableKeys = [
        'award_badge', 'award_title', 'award_desc', 'ach_award_title', 'ach_award_desc',
    ];

    public function index(): Response
    {
        $settings = GlobalSetting::whereIn('key', $this->sectionKeys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->sectionKeys as $key) {
            $settings[$key] ??= null;
        }

        foreach ($this->translatableKeys as $key) {
            $settings[$key] = GlobalSetting::getTranslatedArray($key);
        }

        return Inertia::render('Admin/Awards/Index', [
            'awards'   => Award::orderBy('sort_order')->orderBy('id')->get(),
            'settings' => $settings,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('seal_image')) {
            $data['seal_image'] = $request->file('seal_image')->store('awards', 'public');
        } else {
            unset($data['seal_image']);
        }

        Award::create($data);

        return back()->with('success', 'Award added successfully.');
    }

    public function update(Request $request, Award $award): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('seal_image')) {
            if ($award->seal_image) {
                Storage::disk('public')->delete($award->seal_image);
            }
            $data['seal_image'] = $request->file('seal_image')->store('awards', 'public');
        } elseif ($request->boolean('remove_seal_image')) {
            if ($award->seal_image) {
                Storage::disk('public')->delete($award->seal_image);
            }
            $data['seal_image'] = null;
        } else {
            unset($data['seal_image']);
        }

        $award->update($data);

        return back()->with('success', 'Award updated.');
    }

    public function destroy(Award $award): RedirectResponse
    {
        if ($award->seal_image) {
            Storage::disk('public')->delete($award->seal_image);
        }

        $award->delete();

        return back()->with('success', 'Award deleted.');
    }

    public function toggleStatus(Award $award): RedirectResponse
    {
        $award->update(['is_active' => !$award->is_active]);

        return back()->with('success', 'Award status updated.');
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $rules = [];
        foreach ($this->translatableKeys as $key) {
            $rules[$key] = 'nullable|array';
            $rules["$key.*"] = 'nullable|string';
        }

        $data = $request->validate($rules);

        foreach ($this->translatableKeys as $key) {
            if (array_key_exists($key, $data)) {
                GlobalSetting::setTranslated($key, $data[$key] ?? []);
                unset($data[$key]);
            }
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Awards section settings saved.');
    }

    private function validated(Request $request): array
    {
        $default = Language::defaultLanguage()?->code ?? config('app.locale');

        $data = $request->validate([
            'title'             => 'required|array',
            "title.$default"    => 'required|string',
            'title.*'           => 'nullable|string',
            'subtitle'          => 'nullable|array',
            'subtitle.*'        => 'nullable|string',
            'link_text'         => 'nullable|array',
            'link_text.*'       => 'nullable|string',
            'link_url'     => 'nullable|string',
            // No SVG: uploads are served from the app's own origin, and an SVG can carry script.
            'seal_image'   => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'seal_variant' => 'required|integer|min:1|max:3',
            'sort_order'   => 'integer|min:0',
            'is_active'    => 'boolean',
        ]);

        return $data;
    }
}
