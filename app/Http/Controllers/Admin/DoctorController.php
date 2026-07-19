<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WebsiteSettings\DoctorSettingController;
use App\Models\Doctor;
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
        return Inertia::render('Admin/Doctors/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        foreach (['photo', 'seo_og_image'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('doctors', 'public');
            }
        }

        $data['slug'] = $this->uniqueSlug($data['name']);

        if (empty($data['seo_keywords'])) {
            $data['seo_keywords'] = $this->autoKeywords($data['seo_title'] ?? '', $data['seo_description'] ?? '', $data['name']);
        }

        Doctor::create($data);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor created successfully.');
    }

    public function edit(Doctor $doctor): Response
    {
        return Inertia::render('Admin/Doctors/Edit', [
            'doctor' => $doctor,
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

        $data['slug'] = $this->uniqueSlug($data['name'], $doctor->id);

        if (empty($data['seo_keywords'])) {
            $data['seo_keywords'] = $this->autoKeywords($data['seo_title'] ?? '', $data['seo_description'] ?? '', $data['name']);
        }

        $doctor->update($data);

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

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name'          => 'required|string',
            'role'          => 'nullable|string',
            'photo'         => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'specialty'     => 'nullable|string',
            'degrees'       => 'nullable|string',
            'experience'    => 'nullable|string',
            'awards'        => 'nullable|string',
            'bio'           => 'nullable|string',
            'skills'        => 'nullable|array',
            'skills.*'      => 'nullable|string',
            'schedule'      => 'nullable|array',
            'schedule.*.day'  => 'nullable|string',
            'schedule.*.time' => 'nullable|string',
            'address'       => 'nullable|string',
            'phone'         => 'nullable|string',
            'email'         => 'nullable|email',
            'facebook_url'  => 'nullable|string',
            'twitter_url'   => 'nullable|string',
            'instagram_url' => 'nullable|string',
            'linkedin_url'  => 'nullable|string',
            'youtube_url'   => 'nullable|string',
            'is_featured'   => 'boolean',
            'sort_order'    => 'integer|min:0',
            'is_active'     => 'boolean',
            'seo_title'       => 'nullable|string',
            'seo_description' => 'nullable|string',
            'seo_keywords'    => 'nullable|string',
            'seo_og_image'    => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ]);

        if (isset($data['skills'])) {
            $data['skills'] = array_values(array_filter($data['skills']));
        }
        if (isset($data['schedule'])) {
            $data['schedule'] = array_values(
                array_filter($data['schedule'], fn($s) => !empty($s['day']) || !empty($s['time']))
            );
        }

        return $data;
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
}
