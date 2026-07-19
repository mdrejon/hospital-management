<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Award;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Doctor;
use App\Models\Faq;
use App\Models\GalleryImage;
use App\Models\GlobalSetting;
use App\Models\Inquiry;
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
            'appointmentDoctors'      => $this->appointmentDoctorNames(),
            'appointmentDepartments'  => $this->appointmentDepartments(),
            'homeFaqs'         => $this->faqItems('home'),
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

    /** Active doctor names for the "Book Appointment" form's doctor dropdown. Empty collection if the DB isn't ready. */
    private function appointmentDoctorNames(): Collection
    {
        try {
            return Doctor::active()->pluck('name');
        } catch (\Throwable) {
            return collect();
        }
    }

    /** Active service titles for the "Book Appointment" form's department dropdown. Empty collection if the DB isn't ready. */
    private function appointmentDepartments(): Collection
    {
        try {
            return Service::active()->pluck('title');
        } catch (\Throwable) {
            return collect();
        }
    }

    public function submitAppointment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'             => 'nullable|string|max:255',
            'first_name'       => 'nullable|string|max:255',
            'last_name'        => 'nullable|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'nullable|string|max:30',
            'department'       => 'nullable|string',
            'preferred_doctor' => 'nullable|string',
            'preferred_date'   => 'nullable|string',
            'message'          => 'nullable|string',
            'source'           => 'nullable|in:home,appointment_page,doctor_details_page',
        ]);

        $name = $data['name'] ?? trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''));
        if ($name === '') {
            return back()->withErrors(['name' => 'Please enter your name.'])->withInput();
        }
        unset($data['first_name'], $data['last_name']);

        $data['name']      = $name;
        $data['source']    = $data['source'] ?? 'appointment_page';
        $data['status']    = 'pending';
        $data['is_manual']  = false;

        Appointment::create($data);

        return back()->with('success', "Thank you! Your appointment request has been received — we'll contact you shortly to confirm.");
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
            return GlobalSetting::where('key', 'like', 'svc_%')->pluck('value', 'key')->toArray();
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
            return GlobalSetting::where('key', 'like', 'doc_%')->pluck('value', 'key')->toArray();
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

        foreach (self::ABOUT_JSON_KEYS as $jsonKey) {
            $settings[$jsonKey] = !empty($settings[$jsonKey]) ? json_decode($settings[$jsonKey], true) : [];
        }

        return $settings;
    }

    public function about(): View
    {
        return view('frontend.about', [
            'about'    => $this->aboutSettings(),
            'aboutFaqs' => $this->faqItems('about'),
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
        } catch (\Throwable) {
            return [];
        }

        $settings['ach_items'] = !empty($settings['ach_items']) ? json_decode($settings['ach_items'], true) : [];

        return $settings;
    }

    public function appointment(): View
    {
        return view('frontend.appointment', [
            'appt'                   => $this->appointmentSettings(),
            'appointmentDoctors'     => $this->appointmentDoctorNames(),
            'appointmentDepartments' => $this->appointmentDepartments(),
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
            return GlobalSetting::where('key', 'like', 'blog_%')->pluck('value', 'key')->toArray();
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
            return GlobalSetting::where('key', 'like', 'contact_%')->pluck('value', 'key')->toArray();
        } catch (\Throwable) {
            return [];
        }
    }

    public function doctors(): View
    {
        return view('frontend.doctors', [
            'doctors' => Doctor::active()->get(),
            'doc'     => $this->doctorSettings(),
        ]);
    }

    public function doctorDetails(string $slug): View
    {
        $doctor = Doctor::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('frontend.doctor-details', [
            'doctor' => $doctor,
            'doc'    => $this->doctorSettings(),
        ]);
    }

    public function faq(): View
    {
        return view('frontend.faq', [
            'faqPage'  => $this->faqPageSettings(),
            'faqItems' => $this->faqItems('faq'),
        ]);
    }

    /** Admin > Website Management > FAQ's > Page Settings. Empty array (falls back to static defaults) if the DB isn't ready. */
    private function faqPageSettings(): array
    {
        try {
            return GlobalSetting::where('key', 'like', 'faq_page_%')
                ->orWhere('key', 'like', 'faq_hero_%')
                ->orWhere('key', 'like', 'faq_seo_%')
                ->pluck('value', 'key')->toArray();
        } catch (\Throwable) {
            return [];
        }
    }

    /** Merged Q&A items from all active FAQ groups assigned to the given page. Empty collection if the DB isn't ready. */
    private function faqItems(string $page): Collection
    {
        try {
            return Faq::forPage($page)->get()->flatMap(fn ($group) => $group->items ?? []);
        } catch (\Throwable) {
            return collect();
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
            return GlobalSetting::where('key', 'like', 'testi_%')->pluck('value', 'key')->toArray();
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
            return GlobalSetting::where('key', 'like', 'award_%')
                ->orWhere('key', 'like', 'ach_award_%')
                ->pluck('value', 'key')
                ->toArray();
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
            return GlobalSetting::where('key', 'like', 'gallery_%')->pluck('value', 'key')->toArray();
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
        } catch (\Throwable) {
            return [];
        }

        $settings['hist_timeline'] = !empty($settings['hist_timeline']) ? json_decode($settings['hist_timeline'], true) : [];

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
                                'desc'     => $d->specialty,
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
