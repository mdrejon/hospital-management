<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WebsiteSettings\PackageSettingController;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PackageController extends Controller
{
    public function index(): Response
    {
        $packages = Package::orderBy('sort_order')->orderBy('id')->get();

        return Inertia::render('Admin/Packages/Index', [
            'packages'     => $packages,
            'pageSettings' => app(PackageSettingController::class)->currentSettings(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Packages/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        foreach (['image', 'secondary_image', 'seo_og_image'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('packages', 'public');
            }
        }

        $data['slug'] = $this->uniqueSlug($data['title']);

        if (empty($data['seo_keywords'])) {
            $data['seo_keywords'] = $this->autoKeywords($data['seo_title'] ?? '', $data['seo_description'] ?? '', $data['title']);
        }

        Package::create($data);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package created successfully.');
    }

    public function edit(Package $package): Response
    {
        return Inertia::render('Admin/Packages/Edit', [
            'package' => $package,
        ]);
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $data = $this->validated($request);

        foreach (['image', 'secondary_image', 'seo_og_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($package->$field) {
                    Storage::disk('public')->delete($package->$field);
                }
                $data[$field] = $request->file($field)->store('packages', 'public');
            } else {
                unset($data[$field]);
            }
        }

        $data['slug'] = $this->uniqueSlug($data['title'], $package->id);

        if (empty($data['seo_keywords'])) {
            $data['seo_keywords'] = $this->autoKeywords($data['seo_title'] ?? '', $data['seo_description'] ?? '', $data['title']);
        }

        $package->update($data);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        foreach (['image', 'secondary_image', 'seo_og_image'] as $field) {
            if ($package->$field) {
                Storage::disk('public')->delete($package->$field);
            }
        }

        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package deleted successfully.');
    }

    public function toggleStatus(Package $package): RedirectResponse
    {
        $package->update(['is_active' => !$package->is_active]);

        return back()->with('success', 'Package status updated.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title'            => 'required|string',
            'image'            => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'short_desc'       => 'nullable|string',
            'description'      => 'nullable|string',
            'features'         => 'nullable|array',
            'features.*'       => 'nullable|string',
            'secondary_image'  => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'badge_value'      => 'nullable|string',
            'badge_label'      => 'nullable|string',
            'is_featured'      => 'boolean',
            'sort_order'       => 'integer|min:0',
            'is_active'        => 'boolean',
            'seo_title'        => 'nullable|string',
            'seo_description'  => 'nullable|string',
            'seo_keywords'     => 'nullable|string',
            'seo_og_image'     => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ]);

        if (isset($data['features'])) {
            $data['features'] = array_values(array_filter($data['features']));
        }

        return $data;
    }

    private function uniqueSlug(string $title, int $excludeId = 0): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;

        while (Package::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    private function autoKeywords(string|null ...$texts): string
    {
        static $stop = [
            'a','an','the','and','or','but','in','on','at','to','for','of','with',
            'by','from','as','is','was','are','were','be','been','being','have',
            'has','had','do','does','did','will','would','could','should','may',
            'might','can','this','that','these','those','it','its','we','our',
            'you','your',
        ];
        $text  = implode(' ', array_filter($texts, fn($t) => $t !== null && $t !== ''));
        $words = preg_split('/\W+/u', mb_strtolower(strip_tags($text)), -1, PREG_SPLIT_NO_EMPTY);
        $words = array_filter($words, fn($w) => mb_strlen($w) > 3 && !in_array($w, $stop, true));
        return implode(', ', array_slice(array_unique(array_values($words)), 0, 12));
    }
}
