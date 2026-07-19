<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\GlobalSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AwardController extends Controller
{
    private array $sectionKeys = [
        'award_badge', 'award_title', 'award_desc',
        'ach_award_title', 'ach_award_desc',
    ];

    public function index(): Response
    {
        $settings = GlobalSetting::whereIn('key', $this->sectionKeys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->sectionKeys as $key) {
            $settings[$key] ??= null;
        }

        return Inertia::render('Admin/Awards/Index', [
            'awards'   => Award::orderBy('sort_order')->orderBy('id')->get(),
            'settings' => $settings,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Award::create($this->validated($request));

        return back()->with('success', 'Award added successfully.');
    }

    public function update(Request $request, Award $award): RedirectResponse
    {
        $award->update($this->validated($request));

        return back()->with('success', 'Award updated.');
    }

    public function destroy(Award $award): RedirectResponse
    {
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
        $data = $request->validate([
            'award_badge'      => 'nullable|string',
            'award_title'      => 'nullable|string',
            'award_desc'       => 'nullable|string',
            'ach_award_title'  => 'nullable|string',
            'ach_award_desc'   => 'nullable|string',
        ]);

        GlobalSetting::setMany($data);

        return back()->with('success', 'Awards section settings saved.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title'        => 'required|string',
            'subtitle'     => 'nullable|string',
            'link_text'    => 'nullable|string',
            'link_url'     => 'nullable|string',
            'seal_variant' => 'required|integer|min:1|max:3',
            'sort_order'   => 'integer|min:0',
            'is_active'    => 'boolean',
        ]);

        return $data;
    }
}
