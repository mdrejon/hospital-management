<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WebsiteSettings\ServiceSettingController;
use App\Models\Doctor;
use App\Models\Language;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        $services = Service::orderBy('sort_order')->orderBy('id')->get();

        return Inertia::render('Admin/Services/Index', [
            'services'     => $services,
            'pageSettings' => app(ServiceSettingController::class)->currentSettings(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Services/Create', [
            'doctors' => $this->doctorOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $doctorIds = $data['doctor_ids'] ?? [];
        unset($data['doctor_ids']);

        foreach (['image', 'seo_og_image'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('services', 'public');
            }
        }

        $data['slug'] = $this->uniqueSlug($this->slugSource($data['title']));

        if (empty($data['seo_keywords'])) {
            $data['seo_keywords'] = $this->autoKeywords(
                $data['seo_title'][$this->defaultLocale()] ?? '',
                $data['seo_description'][$this->defaultLocale()] ?? '',
                $data['title'][$this->defaultLocale()] ?? ''
            );
        }

        $service = Service::create($data);
        $service->doctors()->sync($doctorIds);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(Service $service): Response
    {
        return Inertia::render('Admin/Services/Edit', [
            'service' => array_merge($service->toArray(), [
                'doctor_ids' => $service->doctors()->pluck('doctors.id'),
            ]),
            'doctors' => $this->doctorOptions(),
        ]);
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $this->validated($request);
        $doctorIds = $data['doctor_ids'] ?? [];
        unset($data['doctor_ids']);

        foreach (['image', 'seo_og_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($service->$field) {
                    Storage::disk('public')->delete($service->$field);
                }
                $data[$field] = $request->file($field)->store('services', 'public');
            } else {
                unset($data[$field]);
            }
        }

        $data['slug'] = $this->uniqueSlug($this->slugSource($data['title']), $service->id);

        if (empty($data['seo_keywords'])) {
            $data['seo_keywords'] = $this->autoKeywords(
                $data['seo_title'][$this->defaultLocale()] ?? '',
                $data['seo_description'][$this->defaultLocale()] ?? '',
                $data['title'][$this->defaultLocale()] ?? ''
            );
        }

        $service->update($data);
        $service->doctors()->sync($doctorIds);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        foreach (['image', 'seo_og_image'] as $field) {
            if ($service->$field) {
                Storage::disk('public')->delete($service->$field);
            }
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    public function toggleStatus(Service $service): RedirectResponse
    {
        $service->update(['is_active' => !$service->is_active]);

        return back()->with('success', 'Service status updated.');
    }

    private function defaultLocale(): string
    {
        return Language::defaultLanguage()?->code ?? config('app.locale');
    }

    /** Slugs are always built from the English text — regardless of which language is set as the site default — so URLs stay Latin/readable even on a Bangla-first site. Falls back to the default locale, then any filled locale, if English is blank. */
    private function slugSource(array $translatable): string
    {
        if (filled($translatable['en'] ?? null)) {
            return $translatable['en'];
        }
        if (filled($translatable[$this->defaultLocale()] ?? null)) {
            return $translatable[$this->defaultLocale()];
        }
        return collect($translatable)->first(fn ($v) => filled($v)) ?? '';
    }

    private function validated(Request $request): array
    {
        $default = $this->defaultLocale();

        $data = $request->validate([
            'title'             => 'required|array',
            "title.$default"    => 'required|string',
            'title.*'           => 'nullable|string',
            'icon_svg'          => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'short_desc'        => 'nullable|array',
            'short_desc.*'      => 'nullable|string',
            'description'       => 'nullable|array',
            'description.*'     => 'nullable|string',
            'features'          => 'nullable|array',
            'features.*.*'      => 'nullable|string',
            'faqs'              => 'nullable|array',
            'faqs.*.question.*' => 'nullable|string',
            'faqs.*.answer.*'   => 'nullable|string',
            'doctor_ids'        => 'nullable|array',
            'doctor_ids.*'      => 'exists:doctors,id',
            'is_featured'       => 'boolean',
            'sort_order'        => 'integer|min:0',
            'is_active'         => 'boolean',
            'seo_title'         => 'nullable|array',
            'seo_title.*'       => 'nullable|string',
            'seo_description'   => 'nullable|array',
            'seo_description.*' => 'nullable|string',
            'seo_keywords'      => 'nullable|string',
            'seo_og_image'      => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ]);

        // Sanitise arrays — remove entries blank in every locale
        if (isset($data['features'])) {
            $data['features'] = array_values(array_filter(
                $data['features'],
                fn ($f) => is_array($f) && count(array_filter($f)) > 0
            ));
        }
        if (isset($data['faqs'])) {
            $data['faqs'] = array_values(array_filter(
                $data['faqs'],
                fn ($f) => !empty(array_filter($f['question'] ?? [])) || !empty(array_filter($f['answer'] ?? []))
            ));
        }

        return $data;
    }

    /**
     * Doctor options for the "Available Doctors" picker. `name` is translatable and
     * `specialty` is a list of translatable values — both are resolved to plain
     * current-locale strings here, since toArray() would emit the raw {en,bn} shapes.
     */
    private function doctorOptions()
    {
        return Doctor::active()->get(['id', 'name', 'specialty'])
            ->map(fn (Doctor $d) => [
                'id'        => $d->id,
                'name'      => $d->name,
                'specialty' => $d->listText('specialty'),
            ]);
    }

    private function uniqueSlug(string $title, int $excludeId = 0): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;

        while (Service::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
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
