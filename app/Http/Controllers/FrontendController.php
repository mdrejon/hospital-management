<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Doctor;
use App\Models\DoctorSpecialization;
use App\Models\Faq;
use App\Models\GalleryImage;
use App\Models\GlobalSetting;
use App\Models\Inquiry;
use App\Models\Language;
use App\Models\ManagementMember;
use App\Models\Package;
use App\Models\Page;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FrontendController extends Controller
{
    private const ABOUT_JSON_KEYS = [
        'about_hours', 'about_features', 'about_mv_cards',
        'ceo_focus_items', 'ceo_awards', 'why_features',
    ];

    public function home(): View
    {
        return view('frontend.home', [
            'sliders'          => $this->activeSliders(),
            'about'            => $this->aboutSettings(),
            'featuredServices' => $this->featuredServices(),
            'svc'              => $this->serviceSettings(),
            'featuredDoctors'  => $this->featuredDoctors(),
            'doc'              => $this->doctorSettings(),
            'latestBlogs'      => $this->latestBlogs(4),
            'blog'             => $this->blogSettings(),
            'featuredPackages' => $this->featuredPackages(),
            'pkg'              => $this->packageSettings(),
            'appt'                    => $this->appointmentSettings(),
            'appointmentDoctors'      => $this->appointmentBookingDoctors(),
            'homeFaq'          => $this->faqSection('home'),
            'testimonials'     => $this->activeTestimonials(),
            'testi'            => $this->testimonialSettings(),
            'featuredAwards'   => $this->activeAwards(),
            'award'            => $this->awardSettings(),
        ]);
    }

    /** Admin > Website Management > Appointments > "Page Settings" tab. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function appointmentSettings(): array
    {
        try {
            return GlobalSetting::where('key', 'like', 'appt_%')->pluck('value', 'key')->toArray();
        } catch (\Throwable) {
            return [];
        }
    }

    /** Active doctors (id/name/role/fee) for the "Book Appointment" form's doctor dropdown. Empty collection if the DB isn't ready. */
    private function appointmentBookingDoctors(): Collection
    {
        try {
            return Doctor::active()->get(['id', 'name', 'role', 'consultation_fee']);
        } catch (\Throwable) {
            return collect();
        }
    }

    /** Featured packages for the home page "Health Packages" section. Empty collection if the DB isn't ready. */
    private function featuredPackages(): Collection
    {
        try {
            return Package::featured()->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    /** Admin > Website Management > Packages > "Page Settings" tab. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function packageSettings(): array
    {
        try {
            return GlobalSetting::where('key', 'like', 'pkg_%')->pluck('value', 'key')->toArray();
        } catch (\Throwable) {
            return [];
        }
    }

    /** Featured services for the home page "Departments" section. Empty collection if the DB isn't ready. */
    private function featuredServices(): Collection
    {
        try {
            return Service::featured()->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    /** Admin > Website Management > Services > "Page Settings" tab. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function serviceSettings(): array
    {
        try {
            $settings = GlobalSetting::where('key', 'like', 'svc_%')->pluck('value', 'key')->toArray();

            foreach (['svc_badge', 'svc_title', 'svc_desc', 'svc_btn_text', 'svc_page_hero_title', 'svc_help_title', 'svc_help_desc', 'svc_seo_title', 'svc_seo_description'] as $key) {
                if (array_key_exists($key, $settings)) {
                    $settings[$key] = GlobalSetting::getTranslated($key);
                }
            }

            return $settings;
        } catch (\Throwable) {
            return [];
        }
    }

    /** Featured doctors for the home page "Meet Our Doctor" section. Empty collection if the DB isn't ready. */
    private function featuredDoctors(): Collection
    {
        try {
            return Doctor::featured()->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    /** Admin > Website Management > Doctors > "Page Settings" tab. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function doctorSettings(): array
    {
        try {
            $settings = GlobalSetting::where('key', 'like', 'doc_%')->pluck('value', 'key')->toArray();

            foreach (['doc_home_badge', 'doc_home_title', 'doc_page_hero_title', 'doc_badge', 'doc_title', 'doc_seo_title', 'doc_seo_description'] as $key) {
                if (array_key_exists($key, $settings)) {
                    $settings[$key] = GlobalSetting::getTranslated($key);
                }
            }

            return $settings;
        } catch (\Throwable) {
            return [];
        }
    }

    /** Hero slides from Admin > Global Settings > Hero Slider. Empty collection if the DB isn't ready. */
    private function activeSliders(): Collection
    {
        try {
            return Slider::active()->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    /** Admin > Website Management > About Settings. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function aboutSettings(): array
    {
        try {
            $settings = GlobalSetting::query()
                ->where(function ($q) {
                    $q->where('key', 'like', 'about_%')
                        ->orWhere('key', 'like', 'ceo_%')
                        ->orWhere('key', 'like', 'why_%');
                })
                ->pluck('value', 'key')
                ->toArray();
        } catch (\Throwable) {
            return [];
        }

        foreach ([
            'about_hero_title', 'about_seo_title', 'about_seo_description',
            'about_title', 'about_desc', 'about_page_desc', 'about_hours_title', 'about_more_btn_text',
            'about_mv_title', 'about_mv_desc',
            'ceo_badge_label', 'ceo_eyebrow', 'ceo_title', 'ceo_message', 'ceo_focus_label',
            'why_badge', 'why_title', 'why_desc', 'why_badge_number', 'why_badge_label',
        ] as $key) {
            if (array_key_exists($key, $settings)) {
                $settings[$key] = GlobalSetting::getTranslated($key);
            }
        }

        foreach (self::ABOUT_JSON_KEYS as $jsonKey) {
            $settings[$jsonKey] = !empty($settings[$jsonKey]) ? json_decode($settings[$jsonKey], true) : [];
        }

        // Reshape repeater text sub-fields to the resolved-locale string (mirrors the {en,bn} shape written by AboutSettingController).
        $tr = fn ($v) => is_array($v) ? ($v[app()->getLocale()] ?: $v[config('app.fallback_locale')] ?? '') : $v;

        $settings['about_hours'] = collect($settings['about_hours'] ?? [])->map(fn ($item) => [
            'day' => $tr($item['day'] ?? ''), 'time' => $tr($item['time'] ?? ''),
        ])->values()->all();

        $settings['about_features'] = collect($settings['about_features'] ?? [])->map($tr)->values()->all();

        $settings['about_mv_cards'] = collect($settings['about_mv_cards'] ?? [])->map(fn ($item) => [
            'title' => $tr($item['title'] ?? ''), 'description' => $tr($item['description'] ?? ''),
        ])->values()->all();

        $settings['ceo_focus_items'] = collect($settings['ceo_focus_items'] ?? [])->map($tr)->values()->all();

        $settings['ceo_awards'] = collect($settings['ceo_awards'] ?? [])->map(fn ($item) => array_merge($item, [
            'label' => $tr($item['label'] ?? ''),
        ]))->values()->all();

        $settings['why_features'] = collect($settings['why_features'] ?? [])->map(fn ($item) => array_merge($item, [
            'title' => $tr($item['title'] ?? ''), 'description' => $tr($item['description'] ?? ''),
        ]))->values()->all();

        return $settings;
    }

    public function about(): View
    {
        return view('frontend.about', [
            'about'    => $this->aboutSettings(),
            'aboutFaq' => $this->faqSection('about'),
        ]);
    }

    public function achievements(): View
    {
        return view('frontend.achievements', [
            'ach'          => $this->achievementsSettings(),
            'testimonials' => $this->activeTestimonials(),
            'testi'        => $this->testimonialSettings(),
            'awards'       => $this->activeAwards(),
            'award'        => $this->awardSettings(),
        ]);
    }

    /** Admin > Website Management > Achievements Settings. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function achievementsSettings(): array
    {
        try {
            $settings = GlobalSetting::where('key', 'like', 'ach_%')->pluck('value', 'key')->toArray();

            foreach (['ach_hero_title', 'ach_title', 'ach_desc', 'ach_seo_title', 'ach_seo_description'] as $key) {
                if (array_key_exists($key, $settings)) {
                    $settings[$key] = GlobalSetting::getTranslated($key);
                }
            }
        } catch (\Throwable) {
            return [];
        }

        $items    = !empty($settings['ach_items']) ? json_decode($settings['ach_items'], true) : [];
        $locale   = app()->getLocale();
        $fallback = Language::defaultLanguage()?->code ?? config('app.fallback_locale');
        $resolve  = function ($value) use ($locale, $fallback) {
            if (!is_array($value)) return $value;
            return $value[$locale] ?: ($value[$fallback] ?? reset($value));
        };
        $settings['ach_items'] = collect($items)->map(function ($item) use ($resolve) {
            $item['title'] = $resolve($item['title'] ?? null);
            $item['desc']  = $resolve($item['desc'] ?? null);
            return $item;
        })->all();

        return $settings;
    }

    public function appointment(): View
    {
        return view('frontend.appointment', [
            'appt'               => $this->appointmentSettings(),
            'appointmentDoctors' => $this->appointmentBookingDoctors(),
        ]);
    }

    public function blogList(Request $request): View
    {
        $query = Blog::published()->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->get('category')));
        }
        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->get('tag'));
        }
        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")->orWhere('excerpt', 'like', "%{$search}%"));
        }

        $blogs = $query->orderByDesc('published_at')->orderByDesc('id')->paginate(6)->withQueryString();

        return view('frontend.blog-list', array_merge([
            'blogs'          => $blogs,
            'blog'           => $this->blogSettings(),
            'activeCategory' => $request->get('category'),
            'activeTag'      => $request->get('tag'),
            'searchQuery'    => $request->get('q'),
        ], $this->blogSidebarData()));
    }

    public function blogDetails(string $slug): View
    {
        $post = Blog::published()->where('slug', $slug)->with('category')->firstOrFail();
        $post->increment('view_count');

        $related = Blog::published()
            ->where('id', '!=', $post->id)
            ->when($post->category_id, fn ($q) => $q->where('category_id', $post->category_id))
            ->orderByDesc('published_at')
            ->take(2)
            ->get();

        if ($related->count() < 2) {
            $more = Blog::published()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $related->pluck('id'))
                ->orderByDesc('published_at')
                ->take(2 - $related->count())
                ->get();
            $related = $related->concat($more);
        }

        return view('frontend.blog-details', array_merge([
            'post'    => $post,
            'related' => $related,
            'blog'    => $this->blogSettings(),
        ], $this->blogSidebarData()));
    }

    public function submitBlogComment(Request $request, Blog $blog): RedirectResponse
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string',
        ]);
        $data['blog_id'] = $blog->id;

        BlogComment::create($data);

        return back()->with('success', 'Thanks! Your comment has been submitted and is awaiting approval.');
    }

    /** Latest published posts for the home page Blog section. Empty collection if the DB isn't ready. */
    private function latestBlogs(int $count): Collection
    {
        try {
            return Blog::published()->orderByDesc('published_at')->take($count)->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    /** Admin > Website Management > Blog Page Settings. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function blogSettings(): array
    {
        try {
            $settings = GlobalSetting::where('key', 'like', 'blog_%')->pluck('value', 'key')->toArray();

            foreach (['blog_home_title', 'blog_hero_title', 'blog_seo_title', 'blog_seo_description'] as $key) {
                if (array_key_exists($key, $settings)) {
                    $settings[$key] = GlobalSetting::getTranslated($key);
                }
            }

            return $settings;
        } catch (\Throwable) {
            return [];
        }
    }

    /** Shared blog sidebar data (categories with counts, latest posts, popular tags). Empty collections if the DB isn't ready. */
    private function blogSidebarData(): array
    {
        try {
            $categories = BlogCategory::active()
                ->withCount(['blogs' => fn ($q) => $q->published()])
                ->get();

            $latestPosts = Blog::published()->orderByDesc('published_at')->take(3)->get();

            $tagCounts = [];
            foreach (Blog::published()->pluck('tags') as $tags) {
                foreach ((array) $tags as $tag) {
                    if (!$tag) continue;
                    $tagCounts[$tag] = ($tagCounts[$tag] ?? 0) + 1;
                }
            }
            arsort($tagCounts);
            $tags = collect($tagCounts)->take(12)->map(fn ($count, $name) => ['name' => $name, 'count' => $count])->values();

            return compact('categories', 'latestPosts', 'tags');
        } catch (\Throwable) {
            return ['categories' => collect(), 'latestPosts' => collect(), 'tags' => collect()];
        }
    }

    public function contact(): View
    {
        return view('frontend.contact', [
            'contact' => $this->contactSettings(),
        ]);
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'nullable|string|max:30',
            'message'    => 'nullable|string',
        ]);

        Inquiry::create([
            'type'       => Inquiry::TYPE_CONTACT_PAGE,
            'name'       => trim($data['first_name'] . ' ' . ($data['last_name'] ?? '')),
            'email'      => $data['email'],
            'phone'      => $data['phone'] ?? null,
            'subject'    => 'Contact Page Submission',
            'message'    => $data['message'] ?? null,
            'status'     => Inquiry::STATUS_NEW,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Thank you for reaching out! We've received your message and will get back to you shortly.");
    }

    /** Admin > Website Management > Contact Settings. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function contactSettings(): array
    {
        try {
            $settings = GlobalSetting::where('key', 'like', 'contact_%')->pluck('value', 'key')->toArray();

            foreach (['contact_hero_title', 'contact_title', 'contact_desc', 'contact_talk_text', 'contact_rating_text', 'contact_form_title', 'contact_form_btn_text', 'contact_seo_title', 'contact_seo_description'] as $key) {
                if (array_key_exists($key, $settings)) {
                    $settings[$key] = GlobalSetting::getTranslated($key);
                }
            }

            return $settings;
        } catch (\Throwable) {
            return [];
        }
    }

    public function doctors(Request $request): View
    {
        $specialization = null;
        $query = Doctor::active();

        if ($request->filled('specialization')) {
            $specialization = DoctorSpecialization::where('slug', $request->string('specialization'))->first();
            if ($specialization) {
                $query->where('doctor_specialization_id', $specialization->id);
            }
        }

        return view('frontend.doctors', [
            'doctors'        => $query->get(),
            'doc'            => $this->doctorSettings(),
            'specialization' => $specialization,
        ]);
    }

    public function doctorDetails(string $slug): View
    {
        $doctor = Doctor::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('frontend.doctor-details', [
            'doctor'             => $doctor,
            'doc'                => $this->doctorSettings(),
            'appointmentDoctors' => $this->appointmentBookingDoctors(),
            'appt'               => $this->appointmentSettings(),
        ]);
    }

    public function faq(): View
    {
        return view('frontend.faq', [
            'faqPage' => $this->faqPageSettings(),
            'faqData' => $this->faqSection('faq'),
        ]);
    }

    /** Admin > Website Management > FAQ's > Page Settings. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function faqPageSettings(): array
    {
        try {
            $settings = GlobalSetting::where('key', 'like', 'faq_page_%')
                ->orWhere('key', 'like', 'faq_hero_%')
                ->orWhere('key', 'like', 'faq_seo_%')
                ->pluck('value', 'key')->toArray();

            foreach (['faq_hero_title', 'faq_seo_title', 'faq_seo_description', 'faq_page_badge', 'faq_page_title', 'faq_page_desc'] as $key) {
                if (array_key_exists($key, $settings)) {
                    $settings[$key] = GlobalSetting::getTranslated($key);
                }
            }

            return $settings;
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * FAQ section for the given page (home|about|faq): heading fields (badge/title/description/image)
     * from the first active `Faq` group for that page (Admin > Website Management > FAQ's), plus the
     * merged Q&A items from every active group assigned to that page. Empty/blank if the DB isn't ready.
     */
    private function faqSection(string $page): array
    {
        $tr = fn ($v) => is_array($v) ? ($v[app()->getLocale()] ?: $v[config('app.fallback_locale')] ?? '') : $v;

        try {
            $groups = Faq::forPage($page)->get();
            $first  = $groups->first();

            return [
                'badge'       => $first?->badge ?? '',
                'title'       => $first?->title ?? '',
                'description' => $first?->description ?? '',
                'image'       => $first?->image ? asset('storage/' . $first->image) : null,
                'image_alt'   => $first?->image_alt ?? '',
                'items'       => $groups->flatMap(fn ($group) => $group->items ?? [])
                    ->map(fn ($item) => [
                        'question' => $tr($item['question'] ?? ''),
                        'answer'   => $tr($item['answer'] ?? ''),
                    ]),
            ];
        } catch (\Throwable) {
            return ['badge' => '', 'title' => '', 'description' => '', 'image' => null, 'image_alt' => '', 'items' => collect()];
        }
    }

    /** Active patient testimonials for the Home + Achievements "Testimonials" section. Empty collection if the DB isn't ready. */
    private function activeTestimonials(): Collection
    {
        try {
            return Testimonial::active()->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    /** Admin > Website Management > Testimonials > section settings. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function testimonialSettings(): array
    {
        try {
            $settings = GlobalSetting::where('key', 'like', 'testi_%')->pluck('value', 'key')->toArray();

            foreach (['testi_badge', 'testi_title', 'testi_image_alt'] as $key) {
                if (array_key_exists($key, $settings)) {
                    $settings[$key] = GlobalSetting::getTranslated($key);
                }
            }

            return $settings;
        } catch (\Throwable) {
            return [];
        }
    }

    /** Active awards for the Home "Awards" slider and the Achievements page list. Empty collection if the DB isn't ready. */
    private function activeAwards(): Collection
    {
        try {
            return Award::active()->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    /** Admin > Website Management > Awards > section settings — covers both the Home slider (award_*) and Achievements list (ach_award_*) headings. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function awardSettings(): array
    {
        try {
            $settings = GlobalSetting::where('key', 'like', 'award_%')
                ->orWhere('key', 'like', 'ach_award_%')
                ->pluck('value', 'key')
                ->toArray();

            foreach (['award_badge', 'award_title', 'award_desc', 'ach_award_title', 'ach_award_desc'] as $key) {
                if (array_key_exists($key, $settings)) {
                    $settings[$key] = GlobalSetting::getTranslated($key);
                }
            }

            return $settings;
        } catch (\Throwable) {
            return [];
        }
    }

    public function gallery(): View
    {
        return view('frontend.gallery', [
            'images'   => $this->galleryImages(),
            'gallery'  => $this->gallerySettings(),
        ]);
    }

    /** Active gallery images for the public Gallery page. Empty collection if the DB isn't ready. */
    private function galleryImages(): Collection
    {
        try {
            return GalleryImage::active()->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    /** Admin > Website Management > Gallery > Section Header / Hero / SEO settings. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function gallerySettings(): array
    {
        try {
            $settings = GlobalSetting::where('key', 'like', 'gallery_%')->pluck('value', 'key')->toArray();

            foreach (['gallery_badge', 'gallery_title', 'gallery_subtitle', 'gallery_hero_title', 'gallery_seo_title', 'gallery_seo_description'] as $key) {
                if (array_key_exists($key, $settings)) {
                    $settings[$key] = GlobalSetting::getTranslated($key);
                }
            }

            return $settings;
        } catch (\Throwable) {
            return [];
        }
    }

    public function history(): View
    {
        return view('frontend.history', [
            'hist' => $this->historySettings(),
        ]);
    }

    /** Admin > Website Management > History Settings. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function historySettings(): array
    {
        try {
            $settings = GlobalSetting::where('key', 'like', 'hist_%')->pluck('value', 'key')->toArray();

            foreach (['hist_hero_title', 'hist_badge', 'hist_title', 'hist_desc', 'hist_seo_title', 'hist_seo_description'] as $key) {
                if (array_key_exists($key, $settings)) {
                    $settings[$key] = GlobalSetting::getTranslated($key);
                }
            }
        } catch (\Throwable) {
            return [];
        }

        $timeline = !empty($settings['hist_timeline']) ? json_decode($settings['hist_timeline'], true) : [];
        $locale   = app()->getLocale();
        $fallback = Language::defaultLanguage()?->code ?? config('app.fallback_locale');
        $resolve  = function ($value) use ($locale, $fallback) {
            if (!is_array($value)) return $value;
            return $value[$locale] ?: ($value[$fallback] ?? reset($value));
        };
        $settings['hist_timeline'] = collect($timeline)->map(function ($item) use ($resolve) {
            $item['tag']     = $resolve($item['tag'] ?? null);
            $item['heading'] = $resolve($item['heading'] ?? null);
            $item['content'] = $resolve($item['content'] ?? null);
            $item['badges']  = collect($item['badges'] ?? [])->map($resolve)->filter()->values()->all();
            return $item;
        })->all();

        return $settings;
    }

    public function management(): View
    {
        return view('frontend.management', [
            'members' => $this->managementMembers(),
            'mgmt'    => $this->managementSettings(),
        ]);
    }

    /** Active management team members. Empty collection if the DB isn't ready. */
    private function managementMembers(): Collection
    {
        try {
            return ManagementMember::active()->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    /** Admin > Website Management > Management Team > Page Settings. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function managementSettings(): array
    {
        try {
            return GlobalSetting::where('key', 'like', 'mgmt_%')->pluck('value', 'key')->toArray();
        } catch (\Throwable) {
            return [];
        }
    }

    public function mdMessage(): View
    {
        return view('frontend.md-message', [
            'about' => $this->aboutSettings(),
        ]);
    }

    public function services(): View
    {
        return view('frontend.services', [
            'services' => Service::active()->get(),
            'svc'      => $this->serviceSettings(),
        ]);
    }

    public function serviceDetails(string $slug): View
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('frontend.service-details', [
            'service'         => $service,
            'serviceDoctors'  => $service->doctors()->active()->get(),
            'allServices'     => Service::active()->get(),
            'svc'             => $this->serviceSettings(),
        ]);
    }

    public function packages(): View
    {
        return view('frontend.packages', [
            'packages' => Package::active()->get(),
            'pkg'      => $this->packageSettings(),
        ]);
    }

    public function packageDetails(string $slug): View
    {
        $package = Package::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('frontend.package-details', [
            'package'      => $package,
            'allPackages'  => Package::active()->get(),
            'pkg'          => $this->packageSettings(),
        ]);
    }

    public function search(Request $request): View
    {
        $query   = trim((string) $request->get('q', ''));
        $results = collect();

        if ($query !== '') {
            try {
                $results = $results
                    ->merge(
                        Doctor::active()
                            ->where(fn ($q) => $q->where('name', 'like', "%{$query}%")->orWhere('specialty', 'like', "%{$query}%"))
                            ->get()
                            ->map(fn ($d) => [
                                'type'     => 'Doctor',
                                'title'    => $d->name,
                                'desc'     => $d->listText('specialty'),
                                'image'    => $d->photo ? asset('storage/' . $d->photo) : asset('assets/img/team-3.png'),
                                'icon_svg' => null,
                                'url'      => route('doctor-details', $d->slug),
                            ])
                    )
                    ->merge(
                        Service::active()
                            ->where(fn ($q) => $q->where('title', 'like', "%{$query}%")->orWhere('short_desc', 'like', "%{$query}%"))
                            ->get()
                            ->map(fn ($s) => [
                                'type'     => 'Service',
                                'title'    => $s->title,
                                'desc'     => $s->short_desc,
                                'image'    => $s->image ? asset('storage/' . $s->image) : asset('assets/img/sr-1-1.jpg'),
                                'icon_svg' => $s->icon_svg,
                                'url'      => route('service-details', $s->slug),
                            ])
                    )
                    ->merge(
                        Package::active()
                            ->where(fn ($q) => $q->where('title', 'like', "%{$query}%")->orWhere('short_desc', 'like', "%{$query}%"))
                            ->get()
                            ->map(fn ($p) => [
                                'type'     => 'Package',
                                'title'    => $p->title,
                                'desc'     => $p->short_desc,
                                'image'    => $p->image ? asset('storage/' . $p->image) : asset('assets/img/sr-1-2.jpg'),
                                'icon_svg' => null,
                                'url'      => route('package-details', $p->slug),
                            ])
                    )
                    ->merge(
                        Blog::published()
                            ->where(fn ($q) => $q->where('title', 'like', "%{$query}%")->orWhere('excerpt', 'like', "%{$query}%"))
                            ->get()
                            ->map(fn ($b) => [
                                'type'     => 'Blog',
                                'title'    => $b->title,
                                'desc'     => $b->excerpt,
                                'image'    => $b->feature_image ? asset('storage/' . $b->feature_image) : asset('assets/img/blog-one.png'),
                                'icon_svg' => null,
                                'url'      => route('blog-details', $b->slug),
                            ])
                    );
            } catch (\Throwable) {
                $results = collect();
            }
        }

        return view('frontend.search', [
            'query'   => $query,
            'results' => $results,
        ]);
    }

    public function showPage(string $path): View
    {
        $path = trim($path, '/');
        $slug = collect(explode('/', $path))->last();

        $page = Page::active()
            ->where('slug', $slug)
            ->get()
            ->first(fn ($p) => $p->fullPath() === $path);

        if (!$page) {
            abort(404);
        }

        return view('frontend.page', [
            'page'  => $page,
            'trail' => $page->breadcrumbTrail(),
        ]);
    }
}
