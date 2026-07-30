<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WebsiteSettings\DoctorSettingController;
use App\Models\Doctor;
use App\Models\DoctorAvailability;
use App\Models\DoctorChamber;
use App\Models\DoctorLeave;
use App\Models\DoctorSpecialization;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class DoctorController extends Controller
{
    public function index(): Response
    {
        $doctors = Doctor::orderBy('sort_order')->orderBy('id')->get();

        return Inertia::render('Admin/Doctors/Index', [
            'doctors'      => $doctors,
            'pageSettings' => app(DoctorSettingController::class)->currentSettings(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Doctors/Create', [
            'specializations' => $this->specializationOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        foreach (['photo', 'seo_og_image'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('doctors', 'public');
            }
        }

        $data['slug'] = $this->uniqueSlug($this->slugSource($data['name']));

        if (empty($data['seo_keywords'])) {
            $data['seo_keywords'] = $this->autoKeywords(
                $data['seo_title'][$this->defaultLocale()] ?? '',
                $data['seo_description'][$this->defaultLocale()] ?? '',
                $data['name'][$this->defaultLocale()] ?? ''
            );
        }

        [$chambers, $availabilities, $leaves] = $this->extractRelated($data);

        $doctor = Doctor::create($data);
        $this->syncRelated($doctor, $chambers, $availabilities, $leaves);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor created successfully.');
    }

    public function edit(Doctor $doctor): Response
    {
        return Inertia::render('Admin/Doctors/Edit', [
            'doctor' => array_merge($doctor->toArray(), [
                'chambers'       => $doctor->chambers,
                'availabilities' => $doctor->availabilities,
                'leaves'         => $doctor->leaves()->orderBy('date')->get(),
            ]),
            'specializations' => $this->specializationOptions(),
        ]);
    }

    public function update(Request $request, Doctor $doctor): RedirectResponse
    {
        $data = $this->validated($request);

        foreach (['photo', 'seo_og_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($doctor->$field) {
                    Storage::disk('public')->delete($doctor->$field);
                }
                $data[$field] = $request->file($field)->store('doctors', 'public');
            } else {
                unset($data[$field]);
            }
        }

        $data['slug'] = $this->uniqueSlug($this->slugSource($data['name']), $doctor->id);

        if (empty($data['seo_keywords'])) {
            $data['seo_keywords'] = $this->autoKeywords(
                $data['seo_title'][$this->defaultLocale()] ?? '',
                $data['seo_description'][$this->defaultLocale()] ?? '',
                $data['name'][$this->defaultLocale()] ?? ''
            );
        }

        [$chambers, $availabilities, $leaves] = $this->extractRelated($data);

        $doctor->update($data);
        $this->syncRelated($doctor, $chambers, $availabilities, $leaves);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        foreach (['photo', 'seo_og_image'] as $field) {
            if ($doctor->$field) {
                Storage::disk('public')->delete($doctor->$field);
            }
        }

        $doctor->delete();

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor deleted successfully.');
    }

    public function toggleStatus(Doctor $doctor): RedirectResponse
    {
        $doctor->update(['is_active' => !$doctor->is_active]);

        return back()->with('success', 'Doctor status updated.');
    }

    private function defaultLocale(): string
    {
        return Language::defaultLanguage()?->code ?? config('app.locale');
    }

    /**
     * Specialization options for the doctor form's dropdown. `name` is translatable —
     * accessing it via the magic getter (not toArray()) resolves it to the current
     * locale's plain string instead of the raw {en,bn} array.
     */
    private function specializationOptions()
    {
        return DoctorSpecialization::active()->get(['id', 'name'])
            ->map(fn (DoctorSpecialization $s) => [
                'id'   => $s->id,
                'name' => $s->name,
            ]);
    }

    private function validated(Request $request): array
    {
        $default = $this->defaultLocale();

        $data = $request->validate([
            'name'          => 'required|array',
            "name.$default" => 'required|string',
            'name.*'        => 'nullable|string',
            'role'          => 'nullable|array',
            'role.*'        => 'nullable|string',
            'photo'         => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'specialty'      => 'nullable|array',
            'specialty.*.*'  => 'nullable|string',
            'doctor_specialization_id' => 'nullable|exists:doctor_specializations,id',
            'degrees'        => 'nullable|array',
            'degrees.*.*'    => 'nullable|string',
            'experience'     => 'nullable|array',
            'experience.*.*' => 'nullable|string',
            'awards'         => 'nullable|array',
            'awards.*.*'     => 'nullable|string',
            'bio'           => 'nullable|array',
            'bio.*'         => 'nullable|string',
            'skills'        => 'nullable|array',
            'skills.*.*'    => 'nullable|string',
            'schedule'          => 'nullable|array',
            'schedule.*.day'    => 'nullable|array',
            'schedule.*.day.*'  => 'nullable|string',
            'schedule.*.time'   => 'nullable|array',
            'schedule.*.time.*' => 'nullable|string',
            'consultation_fee' => 'nullable|numeric|min:0',
            'chambers'                      => 'nullable|array',
            'chambers.*.name'               => 'nullable|array',
            'chambers.*.name.*'             => 'nullable|string',
            'chambers.*.hospital_branch'    => 'nullable|array',
            'chambers.*.hospital_branch.*'  => 'nullable|string',
            'chambers.*.floor'              => 'nullable|array',
            'chambers.*.floor.*'            => 'nullable|string',
            'chambers.*.room_no'            => 'nullable|array',
            'chambers.*.room_no.*'          => 'nullable|string',
            'chambers.*.address'            => 'nullable|array',
            'chambers.*.address.*'          => 'nullable|string',
            'chambers.*.contact_number'     => 'nullable|array',
            'chambers.*.contact_number.*'   => 'nullable|string',
            'chambers.*.google_map_url'     => 'nullable|string',
            'chambers.*.is_own_hospital'    => 'boolean',
            'availabilities'                        => 'nullable|array',
            'availabilities.*.weekday'              => 'required_with:availabilities|integer|min:0|max:6',
            'availabilities.*.start_time'           => 'required_with:availabilities|date_format:H:i',
            'availabilities.*.end_time'             => 'required_with:availabilities|date_format:H:i|after:availabilities.*.start_time',
            'availabilities.*.slot_duration_minutes' => 'nullable|integer|min:5|max:180',
            'availabilities.*.is_active'            => 'boolean',
            'leaves'             => 'nullable|array',
            'leaves.*.date'      => 'required_with:leaves|date',
            'leaves.*.reason'    => 'nullable|string',
            'address'       => 'nullable|array',
            'address.*'     => 'nullable|string',
            'phone'         => 'nullable|array',
            'phone.*'       => 'nullable|string',
            'email'         => 'nullable|email',
            'facebook_url'  => 'nullable|string',
            'twitter_url'   => 'nullable|string',
            'instagram_url' => 'nullable|string',
            'linkedin_url'  => 'nullable|string',
            'youtube_url'   => 'nullable|string',
            'is_featured'   => 'boolean',
            'sort_order'    => 'integer|min:0',
            'is_active'     => 'boolean',
            'seo_title'         => 'nullable|array',
            'seo_title.*'       => 'nullable|string',
            'seo_description'   => 'nullable|array',
            'seo_description.*' => 'nullable|string',
            'seo_keywords'    => 'nullable|string',
            'seo_og_image'    => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ]);

        // Sanitise arrays — remove entries blank in every locale
        foreach (Doctor::TRANSLATABLE_LISTS as $field) {
            if (isset($data[$field])) {
                $data[$field] = array_values(array_filter(
                    $data[$field],
                    fn ($entry) => is_array($entry) && count(array_filter($entry)) > 0
                ));
            }
        }
        if (isset($data['schedule'])) {
            $data['schedule'] = array_values(
                array_filter($data['schedule'], fn ($s) => $this->hasText($s['day'] ?? null) || $this->hasText($s['time'] ?? null))
            );
        }

        return $data;
    }

    /** True if a translatable value (a {locale => text} array, or a bare legacy string) has text in at least one locale. */
    private function hasText($value): bool
    {
        return !empty(array_filter(is_array($value) ? $value : [$value]));
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

    private function uniqueSlug(string $name, int $excludeId = 0): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (Doctor::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
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

    /** Pulls the chamber/availability/leave arrays out of the validated payload — they live on their own tables, not the doctors row. */
    private function extractRelated(array &$data): array
    {
        $chambers       = $data['chambers'] ?? [];
        $availabilities = $data['availabilities'] ?? [];
        $leaves         = $data['leaves'] ?? [];

        unset($data['chambers'], $data['availabilities'], $data['leaves']);

        return [$chambers, $availabilities, $leaves];
    }

    /** Full replace-sync — simplest correct approach for these small, admin-edited row sets. */
    private function syncRelated(Doctor $doctor, array $chambers, array $availabilities, array $leaves): void
    {
        $doctor->chambers()->delete();
        foreach ($chambers as $i => $chamber) {
            if (!$this->hasText($chamber['name'] ?? null)) {
                continue;
            }
            DoctorChamber::create(array_merge($chamber, [
                'doctor_id'   => $doctor->id,
                'sort_order'  => $i,
                'is_active'   => true,
            ]));
        }

        $doctor->availabilities()->delete();
        foreach ($availabilities as $availability) {
            if (empty($availability['start_time']) || empty($availability['end_time'])) {
                continue;
            }
            DoctorAvailability::create([
                'doctor_id'              => $doctor->id,
                'weekday'                => $availability['weekday'],
                'start_time'             => $availability['start_time'],
                'end_time'               => $availability['end_time'],
                'slot_duration_minutes'  => $availability['slot_duration_minutes'] ?? 15,
                'is_active'              => $availability['is_active'] ?? true,
            ]);
        }

        $doctor->leaves()->delete();
        foreach ($leaves as $leave) {
            if (empty($leave['date'])) {
                continue;
            }
            DoctorLeave::create([
                'doctor_id' => $doctor->id,
                'date'      => $leave['date'],
                'reason'    => $leave['reason'] ?? null,
            ]);
        }
    }
}
