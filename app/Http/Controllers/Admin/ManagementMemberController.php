<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WebsiteSettings\ManagementSettingController;
use App\Models\ManagementMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ManagementMemberController extends Controller
{
    public function index(): Response
    {
        $members = ManagementMember::orderBy('sort_order')->orderBy('id')->get();

        return Inertia::render('Admin/Management/Index', [
            'members'      => $members,
            'pageSettings' => app(ManagementSettingController::class)->currentSettings(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Management/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('management', 'public');
        }

        $data['slug'] = $this->uniqueSlug($data['name']);

        ManagementMember::create($data);

        return redirect()->route('admin.management-members.index')
            ->with('success', 'Management member created successfully.');
    }

    public function edit(ManagementMember $managementMember): Response
    {
        return Inertia::render('Admin/Management/Edit', [
            'member' => $managementMember,
        ]);
    }

    public function update(Request $request, ManagementMember $managementMember): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            if ($managementMember->photo) {
                Storage::disk('public')->delete($managementMember->photo);
            }
            $data['photo'] = $request->file('photo')->store('management', 'public');
        } else {
            unset($data['photo']);
        }

        $data['slug'] = $this->uniqueSlug($data['name'], $managementMember->id);

        $managementMember->update($data);

        return redirect()->route('admin.management-members.index')
            ->with('success', 'Management member updated successfully.');
    }

    public function destroy(ManagementMember $managementMember): RedirectResponse
    {
        if ($managementMember->photo) {
            Storage::disk('public')->delete($managementMember->photo);
        }

        $managementMember->delete();

        return redirect()->route('admin.management-members.index')
            ->with('success', 'Management member deleted successfully.');
    }

    public function toggleStatus(ManagementMember $managementMember): RedirectResponse
    {
        $managementMember->update(['is_active' => !$managementMember->is_active]);

        return back()->with('success', 'Status updated.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'          => 'required|string',
            'role'          => 'nullable|string',
            'photo'         => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'facebook_url'  => 'nullable|string',
            'twitter_url'   => 'nullable|string',
            'instagram_url' => 'nullable|string',
            'linkedin_url'  => 'nullable|string',
            'youtube_url'   => 'nullable|string',
            'sort_order'    => 'integer|min:0',
            'is_active'     => 'boolean',
        ]);
    }

    private function uniqueSlug(string $name, int $excludeId = 0): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (ManagementMember::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
