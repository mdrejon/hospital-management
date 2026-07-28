<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\GlobalSetting;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class FaqController extends Controller
{
    public function index(): Response
    {
        $pageKeys = [
            'faq_hero_image', 'faq_hero_title',
            'faq_seo_title', 'faq_seo_description', 'faq_seo_keywords', 'faq_seo_og_image',
            'faq_page_badge', 'faq_page_title', 'faq_page_desc', 'faq_page_image',
        ];

        $faqSettings = GlobalSetting::whereIn('key', $pageKeys)->pluck('value', 'key')->toArray();
        foreach ($pageKeys as $k) { $faqSettings[$k] ??= null; }

        return Inertia::render('Admin/Faq/Index', [
            'homeFaqs'    => Faq::where('page', 'home')->orderBy('sort_order')->orderBy('id')->get(),
            'aboutFaqs'   => Faq::where('page', 'about')->orderBy('sort_order')->orderBy('id')->get(),
            'faqFaqs'     => Faq::where('page', 'faq')->orderBy('sort_order')->orderBy('id')->get(),
            'faqSettings' => $faqSettings,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Faq/Create', [
            'pages' => $this->pages(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('faqs', 'public');
        }

        Faq::create($data);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ group created successfully.');
    }

    public function edit(Faq $faq): Response
    {
        return Inertia::render('Admin/Faq/Edit', [
            'faq'   => $faq,
            'pages' => $this->pages(),
        ]);
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($faq->image) {
                Storage::disk('public')->delete($faq->image);
            }
            $data['image'] = $request->file('image')->store('faqs', 'public');
        } else {
            unset($data['image']);
        }

        $faq->update($data);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ group updated successfully.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        if ($faq->image) {
            Storage::disk('public')->delete($faq->image);
        }

        $faq->delete();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ group deleted.');
    }

    public function toggleStatus(Faq $faq): RedirectResponse
    {
        $faq->update(['is_active' => !$faq->is_active]);

        return back()->with('success', 'FAQ status updated.');
    }

    private function validated(Request $request): array
    {
        $default = Language::defaultLanguage()?->code ?? config('app.locale');

        $data = $request->validate([
            'page'                => 'required|in:home,about,faq',
            'badge'               => 'nullable|array',
            'badge.*'             => 'nullable|string',
            'title'               => 'nullable|array',
            'title.*'             => 'nullable|string',
            'description'         => 'nullable|array',
            'description.*'       => 'nullable|string',
            'image'               => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'image_alt'           => 'nullable|array',
            'image_alt.*'         => 'nullable|string',
            'items'               => 'required|array|min:1',
            "items.*.question.$default" => 'required|string',
            'items.*.question.*' => 'nullable|string',
            "items.*.answer.$default"   => 'required|string',
            'items.*.answer.*'   => 'nullable|string',
            'sort_order'        => 'integer|min:0',
            'is_active'         => 'boolean',
        ]);

        // Remove items blank in every locale
        $data['items'] = array_values(
            array_filter($data['items'], fn($i) => !empty(array_filter($i['question'] ?? [])) && !empty(array_filter($i['answer'] ?? [])))
        );

        return $data;
    }

    private function pages(): array
    {
        return [
            ['value' => 'home',  'label' => 'Home Page'],
            ['value' => 'about', 'label' => 'About Page'],
            ['value' => 'faq',   'label' => 'FAQ Page'],
        ];
    }
}
