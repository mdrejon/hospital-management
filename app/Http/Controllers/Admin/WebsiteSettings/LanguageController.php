<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class LanguageController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/WebsiteSettings/Languages/Index', [
            'languages' => Language::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $language = Language::create($data);

        if ($language->is_default) {
            Language::where('id', '!=', $language->id)->update(['is_default' => false]);
        }

        return back()->with('success', 'Language added successfully.');
    }

    public function update(Request $request, Language $language): RedirectResponse
    {
        $data = $this->validated($request, $language);

        $language->update($data);

        if ($language->is_default) {
            Language::where('id', '!=', $language->id)->update(['is_default' => false]);
        }

        return back()->with('success', 'Language updated.');
    }

    public function destroy(Language $language): RedirectResponse
    {
        if ($language->is_default) {
            return back()->with('error', 'The default language cannot be deleted.');
        }

        $language->delete();

        return back()->with('success', 'Language deleted.');
    }

    public function toggleStatus(Language $language): RedirectResponse
    {
        if ($language->is_default && $language->is_active) {
            return back()->with('error', 'The default language cannot be deactivated.');
        }

        $language->update(['is_active' => !$language->is_active]);

        return back()->with('success', 'Language status updated.');
    }

    public function setDefault(Language $language): RedirectResponse
    {
        Language::where('id', '!=', $language->id)->update(['is_default' => false]);
        $language->update(['is_default' => true, 'is_active' => true]);

        return back()->with('success', 'Default language updated.');
    }

    private function validated(Request $request, ?Language $language = null): array
    {
        $request->merge(['code' => strtolower((string) $request->input('code'))]);

        return $request->validate([
            'code' => [
                'required', 'string', 'max:10', 'regex:/^[a-z-]+$/',
                Rule::unique('languages', 'code')->ignore($language?->id),
            ],
            'name'        => 'required|string|max:100',
            'native_name' => 'required|string|max:100',
            'direction'   => 'required|in:ltr,rtl',
            'sort_order'  => 'integer|min:0',
            'is_default'  => 'boolean',
            'is_active'   => 'boolean',
        ]);
    }
}
