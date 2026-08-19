<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialization;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class DoctorSpecializationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/DoctorSpecializations/Index', [
            'specializations' => DoctorSpecialization::withCount('doctors')->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $default = Language::defaultLanguage()?->code ?? config('app.locale');

        $data = $request->validate([
            'name'          => 'required|array',
            "name.$default" => 'required|string',
            'name.*'        => 'nullable|string',
            'description'   => 'nullable|array',
            'description.*' => 'nullable|string',
            'heading'       => 'nullable|array',
            'heading.*'     => 'nullable|string',
            'content'       => 'nullable|array',
            'content.*'     => 'nullable|string',
            'seo_title'     => 'nullable|array',
            'seo_title.*'   => 'nullable|string',
            'seo_description'   => 'nullable|array',
            'seo_description.*' => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'is_active'     => 'boolean',
            'sort_order'    => 'integer|min:0',
        ]);

        $data['slug'] = $this->uniqueSlug($this->slugSource($data['name'], $default));

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('doctor-specializations', 'public');
        }

        DoctorSpecialization::create($data);

        return back()->with('success', 'Specialization created.');
    }

    public function update(Request $request, DoctorSpecialization $doctorSpecialization): RedirectResponse
    {
        $default = Language::defaultLanguage()?->code ?? config('app.locale');

        $data = $request->validate([
            'name'          => 'required|array',
            "name.$default" => 'required|string',
            'name.*'        => 'nullable|string',
            'description'   => 'nullable|array',
            'description.*' => 'nullable|string',
            'heading'       => 'nullable|array',
            'heading.*'     => 'nullable|string',
            'content'       => 'nullable|array',
            'content.*'     => 'nullable|string',
            'seo_title'     => 'nullable|array',
            'seo_title.*'   => 'nullable|string',
            'seo_description'   => 'nullable|array',
            'seo_description.*' => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'is_active'     => 'boolean',
            'sort_order'    => 'integer|min:0',
        ]);

        if ($doctorSpecialization->getTranslation('name', 'en') !== $this->slugSource($data['name'], $default)) {
            $data['slug'] = $this->uniqueSlug($this->slugSource($data['name'], $default), $doctorSpecialization->id);
        }

        if ($request->hasFile('image')) {
            if ($doctorSpecialization->image) {
                Storage::disk('public')->delete($doctorSpecialization->image);
            }
            $data['image'] = $request->file('image')->store('doctor-specializations', 'public');
        }

        $doctorSpecialization->update($data);

        return back()->with('success', 'Specialization updated.');
    }

    public function destroy(DoctorSpecialization $doctorSpecialization): RedirectResponse
    {
        if ($doctorSpecialization->image) {
            Storage::disk('public')->delete($doctorSpecialization->image);
        }
        $doctorSpecialization->delete();

        return back()->with('success', 'Specialization deleted.');
    }

    public function toggleStatus(DoctorSpecialization $doctorSpecialization): RedirectResponse
    {
        $doctorSpecialization->update(['is_active' => !$doctorSpecialization->is_active]);

        return back()->with('success', 'Status updated.');
    }

    /** Slugs are always built from the English text — regardless of which language is set as the site default — so URLs stay Latin/readable even on a Bangla-first site. Falls back to the default locale, then any filled locale, if English is blank. */
    private function slugSource(array $translatable, string $default): string
    {
        if (filled($translatable['en'] ?? null)) {
            return $translatable['en'];
        }
        if (filled($translatable[$default] ?? null)) {
            return $translatable[$default];
        }
        return collect($translatable)->first(fn ($v) => filled($v)) ?? '';
    }

    private function uniqueSlug(string $name, int $excludeId = 0): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (DoctorSpecialization::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
