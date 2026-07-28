<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class BlogCategoryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/BlogCategories/Index', [
            'categories' => BlogCategory::withCount('blogs')->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $default = Language::defaultLanguage()?->code ?? config('app.locale');

        $data = $request->validate([
            'name'              => 'required|array',
            "name.$default"     => 'required|string',
            'name.*'            => 'nullable|string',
            'description'       => 'nullable|array',
            'description.*'     => 'nullable|string',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer|min:0',
        ]);

        $data['slug'] = $this->uniqueSlug($data['name'][$default] ?? '');

        BlogCategory::create($data);

        return back()->with('success', 'Category created.');
    }

    public function update(Request $request, BlogCategory $blogCategory): RedirectResponse
    {
        $default = Language::defaultLanguage()?->code ?? config('app.locale');

        $data = $request->validate([
            'name'              => 'required|array',
            "name.$default"     => 'required|string',
            'name.*'            => 'nullable|string',
            'description'       => 'nullable|array',
            'description.*'     => 'nullable|string',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer|min:0',
        ]);

        if ($blogCategory->getTranslation('name', $default) !== ($data['name'][$default] ?? '')) {
            $data['slug'] = $this->uniqueSlug($data['name'][$default] ?? '', $blogCategory->id);
        }

        $blogCategory->update($data);

        return back()->with('success', 'Category updated.');
    }

    public function destroy(BlogCategory $blogCategory): RedirectResponse
    {
        $blogCategory->delete();

        return back()->with('success', 'Category deleted.');
    }

    public function toggleStatus(BlogCategory $blogCategory): RedirectResponse
    {
        $blogCategory->update(['is_active' => !$blogCategory->is_active]);

        return back()->with('success', 'Status updated.');
    }

    private function uniqueSlug(string $name, int $excludeId = 0): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (BlogCategory::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
