<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\MedicalTestCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class MedicalTestCategoryController extends Controller
{
    public function index(): Response
    {
        $categories = MedicalTestCategory::withCount('tests')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return Inertia::render('Admin/MedicalTests/Categories', [
            'categories' => $categories,
            'languages'  => Language::active(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $defaultLocale = config('app.locale', 'en');
        $validated = $request->validate([
            'name'          => ['required', 'array'],
            'name.' . $defaultLocale => ['required', 'string', 'max:255'],
            'slug'          => ['nullable', 'string', 'max:255', 'unique:medical_test_categories,slug'],
            'description'   => ['nullable', 'array'],
            'icon'          => ['nullable', 'string', 'max:100'],
            'sort_order'    => ['nullable', 'integer', 'min:0'],
            'is_active'     => ['boolean'],
        ]);

        if (empty($validated['slug'])) {
            $slugSource = $validated['name'][$defaultLocale] ?? reset($validated['name']);
            $slug = Str::slug($slugSource);
            $count = MedicalTestCategory::where('slug', 'like', "{$slug}%")->count();
            $validated['slug'] = $count > 0 ? "{$slug}-" . ($count + 1) : $slug;
        }

        MedicalTestCategory::create($validated);

        return back()->with('success', 'Medical test category created successfully.');
    }

    public function update(Request $request, MedicalTestCategory $category): RedirectResponse
    {
        $defaultLocale = config('app.locale', 'en');
        $validated = $request->validate([
            'name'          => ['required', 'array'],
            'name.' . $defaultLocale => ['required', 'string', 'max:255'],
            'slug'          => ['nullable', 'string', 'max:255', 'unique:medical_test_categories,slug,' . $category->id],
            'description'   => ['nullable', 'array'],
            'icon'          => ['nullable', 'string', 'max:100'],
            'sort_order'    => ['nullable', 'integer', 'min:0'],
            'is_active'     => ['boolean'],
        ]);

        $category->update($validated);

        return back()->with('success', 'Medical test category updated successfully.');
    }

    public function destroy(MedicalTestCategory $category): RedirectResponse
    {
        if ($category->tests()->exists()) {
            return back()->with('error', 'Cannot delete category with associated tests. Please delete or reassign the tests first.');
        }

        $category->delete();

        return back()->with('success', 'Medical test category deleted successfully.');
    }
}
