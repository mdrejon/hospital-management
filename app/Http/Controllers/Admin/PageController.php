<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function index(): Response
    {
        $pages = Page::with('parent:id,title')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn ($p) => [
                'id'         => $p->id,
                'title'      => $p->title,
                'slug'       => $p->slug,
                'full_path'  => $p->fullPath(),
                'parent'     => $p->parent?->title,
                'sort_order' => $p->sort_order,
                'is_active'  => $p->is_active,
            ]);

        return Inertia::render('Admin/Pages/Index', [
            'pages' => $pages,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Pages/Create', [
            'parentOptions' => $this->parentOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $request->file('hero_image')->store('pages', 'public');
        }
        if ($request->hasFile('seo_og_image')) {
            $data['seo_og_image'] = $request->file('seo_og_image')->store('pages', 'public');
        }

        $data['slug'] = $this->uniqueSlug($data['title'], $data['parent_id'] ?? null);

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page): Response
    {
        return Inertia::render('Admin/Pages/Edit', [
            'page'          => $page,
            'parentOptions' => $this->parentOptions($page),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $data = $this->validated($request);

        if (($data['parent_id'] ?? null) !== null) {
            if ((int) $data['parent_id'] === $page->id) {
                return back()->withErrors(['parent_id' => 'A page cannot be its own parent.'])->withInput();
            }
            if ($this->isDescendant($page, (int) $data['parent_id'])) {
                return back()->withErrors(['parent_id' => 'You cannot set a child page as the parent (this would create a loop).'])->withInput();
            }
        }

        foreach (['hero_image', 'seo_og_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($page->$field) {
                    Storage::disk('public')->delete($page->$field);
                }
                $data[$field] = $request->file($field)->store('pages', 'public');
            } else {
                unset($data[$field]);
            }
        }

        $data['slug'] = $this->uniqueSlug($data['title'], $data['parent_id'] ?? null, $page->id);

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        if ($page->children()->exists()) {
            return back()->with('error', 'This page has child pages. Delete or reassign them first.');
        }

        foreach (['hero_image', 'seo_og_image'] as $field) {
            if ($page->$field) {
                Storage::disk('public')->delete($page->$field);
            }
        }

        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }

    public function toggleStatus(Page $page): RedirectResponse
    {
        $page->update(['is_active' => !$page->is_active]);

        return back()->with('success', 'Page status updated.');
    }

    /** All pages except the one being edited and its descendants (would create a parent loop). */
    private function parentOptions(?Page $excluding = null): array
    {
        $excludedIds = [];
        if ($excluding) {
            $excludedIds[] = $excluding->id;
            $this->collectDescendantIds($excluding, $excludedIds);
        }

        return Page::whereNotIn('id', $excludedIds)
            ->orderBy('title')
            ->get()
            ->map(fn ($p) => ['id' => $p->id, 'title' => $p->title, 'full_path' => $p->fullPath()])
            ->toArray();
    }

    private function collectDescendantIds(Page $page, array &$ids): void
    {
        foreach ($page->children as $child) {
            $ids[] = $child->id;
            $this->collectDescendantIds($child, $ids);
        }
    }

    private function isDescendant(Page $page, int $candidateParentId): bool
    {
        $ids = [];
        $this->collectDescendantIds($page, $ids);

        return in_array($candidateParentId, $ids, true);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'parent_id'        => 'nullable|exists:pages,id',
            'title'            => 'required|string',
            'breadcrumb_title' => 'nullable|string',
            'hero_image'       => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'content'          => 'nullable|string',
            'is_active'        => 'boolean',
            'sort_order'       => 'integer|min:0',
            'seo_title'        => 'nullable|string',
            'seo_description'  => 'nullable|string',
            'seo_keywords'     => 'nullable|string',
            'seo_og_image'     => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ]);

        return $data;
    }

    private function uniqueSlug(string $title, ?int $parentId, int $excludeId = 0): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;

        while (
            Page::where('slug', $slug)
                ->where('parent_id', $parentId)
                ->where('id', '!=', $excludeId)
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
