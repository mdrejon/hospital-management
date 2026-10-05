@extends('layouts.frontend')

@section('title', $headerSettings['header_site_name'] ?? __('frontend.meta.default_title'))

@section('content')

<!-- ===================== Hero ===================== -->
@php
// Dynamic slides from Admin > Global Settings > Hero Slider, falling back
// to the two static demo slides below when none have been configured yet.
$heroSlides = $sliders->isNotEmpty()
? $sliders->map(fn ($s) => [
'image' => $s->background_image ? asset('storage/' . $s->background_image) : asset('assets/img/slider-1.2.jpg'),
'image_alt' => $s->title,
'eyebrow' => $s->label,
'title' => $s->title,
'accent' => $s->subtitle,
'desc' => $s->description,
'button_text' => $s->button_text,
'button_url' => $s->button_url,
])
: collect([
[
'image' => asset('assets/img/slider-1.2.jpg'),
'image_alt' => 'Doctor examining a baby patient',
'eyebrow' => 'Our people and society',
'title' => 'Best Medics, Doctors',
'accent' => 'and physicians',
'desc' => "Conveniently drive go forward architectures with future-proof growth strategies. Energistically supply low-risk high-yield process improvements for mission-critical testing procedures",
'button_text' => 'View All Services',
'button_url' => route('services'),
],
[
'image' => asset('assets/img/slider-1.3.jpg'),
'image_alt' => 'Medical team performing a procedure on a patient',
'eyebrow' => 'We Care For You',
'title' => 'Compassionate Care,',
'accent' => 'Trusted Doctors',
'desc' => 'Our specialists combine advanced technology with genuine compassion to give every patient the care they deserve.',
'button_text' => 'Make Appointment',
'button_url' => route('appointment'),
],
]);
@endphp
<section class="hero !bg-gray-50" data-hero>
  <div class="hero__viewport h-full w-full relative">
    <div class="hero__track flex h-full transition-transform duration-700 ease-out" data-hero-track>

      @foreach($heroSlides as $slide)
      <div class="hero-slide w-full flex-shrink-0 relative">
        <img src="{{ $slide['image'] }}" alt="{{ $slide['image_alt'] }}" class="hero-slide__bg !object-top" />

        <!-- Gradient overlay -->
        <span class="hero-slide__overlay !bg-gradient-to-r !from-white/95 !via-white/70 !to-transparent !opacity-100"></span>

        <div class="hero-slide__inner !max-w-none w-full !px-4 lg:!px-16 flex items-center h-full relative z-10">
          <div class="hero-slide__content pl-8 lg:pl-16 !max-w-2xl" data-hero-content>
            @if($slide['eyebrow'])
            <p class="hero-slide__eyebrow !block !text-brand-cyan !italic !text-2xl lg:!text-[28px] !mb-4" style="font-family: 'Georgia', serif;">
              {{ $slide['eyebrow'] }}
            </p>
            @endif
            <h1 class="hero-slide__title !text-navy !text-4xl !font-bold !mb-5">
              {{ $slide['title'] }}
              @if($slide['accent'])
              <br>
              <span class="accent !text-brand-cyan">{{ $slide['accent'] }}</span>
              @endif
            </h1>
            @if($slide['desc'])
            <p class="hero-slide__desc !text-gray-500 !text-sm lg:!text-[15px] !max-w-[480px]">
              {{ $slide['desc'] }}
            </p>
            @endif
            <a href="{{ $slide['button_url'] ?: route('appointment') }}" class="hero-slide__cta !bg-brand-cyan !text-white !rounded-full !pr-7 !pl-2 !py-2 hover:!bg-navy !transition !duration-300 shadow-lg shadow-brand-cyan/30">
              <span class="w-8 h-8 rounded-full bg-white text-brand-cyan flex items-center justify-center mr-3 shrink-0">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M13 2L3 14h8v8l10-12h-8V2z" />
                </svg>
              </span>
              <span class="!font-bold !text-[14px] !normal-case !tracking-normal !text-white">{{ $slide['button_text'] ?: 'View All Services' }}</span>
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Vertical dot nav (moved to left edge using tailwind overrides) -->
    <div class="hero__dots !right-auto !left-6 lg:!left-12 !items-start">
      @foreach($heroSlides as $i => $slide)
      <button type="button" class="hero__dot !h-2.5 !w-2.5 !border-none !bg-navy transition-all duration-300 [&.is-active]:!bg-brand-cyan [&.is-active]:scale-125" data-hero-dot aria-label="Go to slide {{ $i + 1 }}"></button>
      @endforeach
    </div>
  </div>
</section>

<!-- ===================== About Us ===================== -->
@php
$aboutPhoto = !empty($about['about_photo']) ? asset('storage/' . $about['about_photo']) : asset('assets/img/about-image.webp');
$aboutHoursTitle = $about['about_hours_title'] ?? 'Open Hours';
$aboutHours = !empty($about['about_hours']) ? $about['about_hours'] : [
['day' => 'Monday', 'time' => '09:30 - 07:30'],
['day' => 'Tuesday', 'time' => '09:30 - 07:30'],
['day' => 'Wednesday', 'time' => '09:30 - 07:30'],
['day' => 'Thursday', 'time' => '09:30 - 07:30'],
['day' => 'Friday', 'time' => '09:30 - 07:30'],
['day' => 'Saturday', 'time' => '09:30 - 07:30'],
];
$aboutTitle = $about['about_title'] ?? __('frontend.home.about_title');
$aboutDesc = $about['about_desc'] ?? __('frontend.home.about_desc');
$aboutFeatures = !empty($about['about_features']) ? $about['about_features'] : [
'Comprehensive Specialties', 'Emergency Services', 'Intensive Care Units (ICUs)', 'Telemedicine Facilities', 'Multidisciplinary Team',
'Research and Development', 'Advanced Imaging Services', 'Rehabilitation Services', 'Patient-Centric Approach', 'Health Information Technology',
];
$aboutFeatureCols = collect($aboutFeatures)->chunk((int) ceil(count($aboutFeatures) / 2));
$aboutBtnText = $about['about_more_btn_text'] ?? __('frontend.common.read_more');
$aboutBtnUrl = ($about['about_more_btn_url'] ?? null) ?: route('about');
$aboutPhone = $headerSettings['header_phone'] ?? '1 123 456 7890';
@endphp
<section class="about bg-blue-50/40 relative overflow-hidden">
  <!-- Animated Floating Medical Cross -->
  <div class="absolute top-10 right-10 opacity-30 animate-pulse text-brand-cyan pointer-events-none z-0">
    <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
    </svg>
  </div>
  <svg class="about__decor" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <pattern id="about-dots" width="10" height="10" patternUnits="userSpaceOnUse">
      <circle cx="2" cy="2" r="2" fill="currentColor" />
    </pattern>
    <rect width="100" height="100" fill="url(#about-dots)" />
  </svg>

  <div class="container mx-auto">
    <div class="about__grid">
      <div class="about__media">
        <div class="about__photo-wrap">
          <img src="{{ $aboutPhoto }}" alt="Smiling male doctor with arms crossed" class="about__photo" />


          <div class="about__hours-card">
            <span class="about__hours-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6" />
                <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
              </svg>
            </span>
            <h3 class="about__hours-title">{{ $aboutHoursTitle }}</h3>
            <div class="about__hours-list">
              @foreach($aboutHours as $row)
              <div class="about__hours-row">
                <span class="about__hours-day">{{ $row['day'] }}</span>
                <span class="about__hours-time">{{ $row['time'] }}</span>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <div class="about__content">
        <h2 class="about__title">{{ $aboutTitle }}</h2>
        <p class="about__desc">
          {{ $aboutDesc }}
        </p>

        <div class="about__features">
          @foreach($aboutFeatureCols as $col)
          <div>
            @foreach($col as $feature)
            <div class="about__feature">
              <span class="about__feature-check">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
              {{ $feature }}
            </div>
            @endforeach
          </div>
          @endforeach
        </div>

        <div class="about__cta-row">
          <a href="{{ $aboutBtnUrl }}" class="about__btn">
            {{ $aboutBtnText }}
            <span class="about__btn-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
          </a>

          <a href="tel:{{ $aboutPhone }}" class="about__contact">
            <span class="about__contact-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6" />
              </svg>
            </span>
            <span class="about__contact-text">
              <span class="about__contact-label">{{ __('frontend.faq.contact_label') }}</span>
              <span class="about__contact-value">{{ $aboutPhone }}</span>
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===================== Why Choose Us ===================== -->
@php
$whyBadge = $about['why_badge'] ?? '7 Star Care & Protection';
$whyTitle = $about['why_title'] ?? 'We love your loved ones';
$whyDesc = $about['why_desc'] ?? "Proactively revolutionize granular customer service after pandemic internal or 'organic' sources. Distinctively impact proactive human capital rather than client-centered benefits.";
$whyPhoto = !empty($about['why_photo']) ? asset('storage/' . $about['why_photo']) : asset('assets/img/choose-us-image.webp');
$whyBgPhoto = !empty($about['why_bg_photo']) ? asset('storage/' . $about['why_bg_photo']) : null;
$whyFeatures = !empty($about['why_features']) ? $about['why_features'] : [
['title' => '100% Safe & Trusted', 'description' => 'Professional web-readiness via ubiquitous human capital.'],
['title' => 'Specialist Surgery', 'description' => 'Professional web-readiness via ubiquitous human capital.'],
['title' => '24/7 take care staff', 'description' => 'Professional web-readiness via ubiquitous human capital.'],
['title' => 'Medicine service','description' => 'Professional web-readiness via ubiquitous human capital.'],
];
@endphp
<section class="relative py-24 bg-white overflow-hidden">
  <!-- Background Pattern (Left) -->
  <div class="absolute left-0 top-0 w-64 h-full bg-[radial-gradient(#0ea5e9_2px,transparent_2px)] [background-size:24px_24px] opacity-10 pointer-events-none"></div>
  <!-- Background Pattern (Right) -->
  <div class="absolute right-0 top-0 w-64 h-full bg-[radial-gradient(#9ca3af_2px,transparent_2px)] [background-size:24px_24px] opacity-20 pointer-events-none"></div>

  <div class="container mx-auto px-4 lg:px-16 relative z-10">
    <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-20">

      <!-- Left Content -->
      <div class="lg:w-1/2">
        <p class="text-brand-cyan italic text-2xl lg:text-[28px] mb-3" style="font-family: 'Georgia', serif;">
          {{ $whyBadge }}
        </p>
        <h2 class="text-3xl lg:text-[44px] font-bold text-navy mb-6 leading-[1.2]">
          {{ $whyTitle }}
        </h2>
        <p class="text-gray-500 text-[15px] leading-relaxed mb-12 max-w-[500px]">
          {{ $whyDesc }}
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-10">
          @foreach($whyFeatures as $i => $feature)
          @php
          // Simple icons based on index to mimic the screenshot
          $icons = [
          '<svg class="w-9 h-9 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
          </svg>', // Shield
          '<svg class="w-9 h-9 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
          </svg>', // Mouse/Click
          '<svg class="w-9 h-9 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
          </svg>', // Heart
          '<svg class="w-9 h-9 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
          </svg>' // Flask
          ];
          $icon = $icons[$i % count($icons)];
          @endphp
          <div class="flex gap-4">
            <div class="shrink-0 mt-1">
              {!! $icon !!}
            </div>
            <div>
              <h3 class="text-navy font-bold text-[16px] mb-2">{{ $feature['title'] }}</h3>
              <p class="text-gray-400 text-[13px] leading-relaxed">{{ $feature['description'] }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Right Image -->
      <div class="lg:w-1/2 relative flex justify-center mt-12 lg:mt-0">
        <!-- Cyan circular arc decoration -->
        <div class="absolute right-0 bottom-0 w-[450px] h-[450px] rounded-full border border-brand-cyan/50 -z-10 translate-x-12 translate-y-12"></div>
        <img src="{{ $whyPhoto }}" alt="{{ $whyTitle }}" class="max-w-full h-auto relative z-10" />
      </div>

    </div>
  </div>
</section>

<!-- ===================== Departments ===================== -->
@php
$deptDefaultIcon = '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M12 3s7 7.5 7 12a7 7 0 1 1-14 0c0-4.5 7-12 7-12z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
</svg>';
$deptCards = $featuredServices->isNotEmpty()
? $featuredServices->map(fn ($s) => [
'title' => $s->title,
'desc' => $s->short_desc,
'icon_svg' => $s->icon_svg,
'image' => $s->image ? asset('storage/' . $s->image) : asset('assets/img/slider-1.3.jpg'),
'url' => route('service-details', $s->slug),
])
: collect([
['title' => 'Haematology', 'desc' => 'Continually evisculate goal-oriented portals rather than prospective channels. Appropriately customize excellent imperatives for mission-critical products.', 'icon_svg' => null, 'image' => asset('assets/img/slider-1.3.jpg'), 'url' => route('services')],
['title' => 'Pediatrician', 'desc' => 'Continually evisculate goal-oriented portals rather than prospective channels. Appropriately customize excellent imperatives for mission-critical products.', 'icon_svg' => '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M12 20s-7-4.5-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 5c-2.5 4.5-9.5 9-9.5 9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
  <path d="M12 9v4M10 11h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
</svg>', 'image' => asset('assets/img/slider-1.2.jpg'), 'url' => route('services')],
['title' => 'Cardiologist', 'desc' => 'Continually evisculate goal-oriented portals rather than prospective channels. Appropriately customize excellent imperatives for mission-critical products.', 'icon_svg' => '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M3 12h4l2-6 4 12 2-6h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
</svg>', 'image' => asset('assets/img/about-image.webp'), 'url' => route('services')],
]);
@endphp
<section class="departments py-24 bg-slate-50 relative overflow-hidden">
  <!-- Animated Floating Element -->
  <div class="absolute top-20 left-10 opacity-20 animate-bounce text-navy pointer-events-none z-0" style="animation-duration: 4s;">
    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <circle cx="12" cy="12" r="10" />
      <path stroke-linecap="round" d="M12 8v8m-4-4h8" />
    </svg>
  </div>
  <div class="container mx-auto px-4">
    <!-- Heading Area -->
    <div class="text-center mb-16 max-w-2xl mx-auto">
      <p class="text-brand-cyan font-bold tracking-widest uppercase text-sm mb-3">
        {{ $svc['svc_badge'] ?? __('frontend.home.services_badge') }}
      </p>
      <h2 class="text-3xl lg:text-[40px] font-bold text-navy mb-6 leading-[1.2]">
        {{ $svc['svc_title'] ?? __('frontend.home.services_title') }}
      </h2>
      <p class="text-gray-500 text-[15px] mb-8 leading-relaxed">
        {{ $svc['svc_desc'] ?? __('frontend.home.services_desc') }}
      </p>
      @if(!empty($svc['svc_btn_url']))
      <a href="{{ $svc['svc_btn_url'] }}" class="inline-flex items-center justify-center bg-brand-cyan hover:bg-navy text-white font-bold py-3 px-8 rounded-full transition-colors duration-300">
        {{ $svc['svc_btn_text'] ?? __('frontend.home.view_all_services') }}
      </a>
      @endif
    </div>

    <!-- 3-Column Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($deptCards as $card)
      <article class="group bg-white overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.06)] hover:shadow-[0_10px_30px_rgba(0,0,0,0.1)] transition-all duration-300 relative flex flex-col h-full border border-gray-50">

        <!-- Image Area -->
        <div class="h-[240px] w-full relative shrink-0 z-10">
          <div class="w-full h-full overflow-hidden">
            <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
          </div>

          <!-- Icon Circle -->
          <div class="absolute -bottom-7 left-1/2 -translate-x-1/2 z-20">
            <div class="relative w-[56px] h-[56px] rounded-full bg-brand-cyan border-[4px] border-white flex items-center justify-center text-white shadow-sm">
              <span class="w-6 h-6 flex items-center justify-center">
                {!! $card['icon_svg'] ?: $deptDefaultIcon !!}
              </span>
            </div>
          </div>
        </div>

        <!-- Content Area -->
        <div class="pt-14 pb-8 px-6 text-center transition-colors duration-300 group-hover:bg-brand-cyan flex-grow flex flex-col items-center relative z-0 bg-white">
          <h3 class="text-navy text-[20px] font-bold mb-3 transition-colors duration-300 group-hover:text-white">
            {{ $card['title'] }}
          </h3>
          <p class="text-gray-500 text-[14px] leading-relaxed mb-6 transition-colors duration-300 group-hover:text-white/90 line-clamp-3">
            {{ $card['desc'] }}
          </p>

          <a href="{{ $card['url'] }}" class="mt-auto inline-flex items-center gap-2 text-navy text-[14px] font-bold transition-colors duration-300 group-hover:text-white group-hover:opacity-90">
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
            Read More
          </a>
        </div>

      </article>
      @endforeach
    </div>
  </div>
</section>

<!-- ===================== Team ===================== -->
@php
$teamCards = $featuredDoctors->isNotEmpty()
? $featuredDoctors->map(fn ($d) => [
'name' => $d->name,
'role' => $d->role,
'photo' => $d->photo ? asset('storage/' . $d->photo) : asset('assets/img/team-3.png'),
'url' => route('doctor-details', $d->slug),
'facebook' => $d->facebook_url,
'youtube' => $d->youtube_url,
'linkedin' => $d->linkedin_url,
])
: collect([
['name' => 'Collis Molate', 'role' => 'Neurosurgeon', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
['name' => 'Domani Plavon', 'role' => 'Neurosurgeon', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
['name' => 'John Mard', 'role' => 'Dental Surgeon', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
['name' => 'Amanal Frond', 'role' => 'Neurosurgeon', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
['name' => 'Michael Reyes', 'role' => 'Pediatrician', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
['name' => 'Sara Owens', 'role' => 'Neurologist', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
]);
@endphp
<section class="team !py-24 bg-white relative overflow-hidden">
  <!-- Animated Floating Element -->
  <div class="absolute bottom-20 right-10 opacity-[0.08] animate-spin text-brand-cyan pointer-events-none z-0" style="animation-duration: 20s;">
    <svg width="150" height="150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
      <circle cx="12" cy="12" r="10" stroke-dasharray="4 4" />
    </svg>
  </div>
  <div class="container mx-auto px-4">
    <!-- Centered Heading Area -->
    <div class="text-center mb-14 max-w-2xl mx-auto">
      <h2 class="text-3xl lg:text-[40px] font-bold text-navy mb-4 leading-[1.2]">
        {{ $doc['doc_home_title'] ?? 'We Have Specialist Doctors To Solve Your Problems' }}
      </h2>
      <div class="flex justify-center items-center gap-1.5 mb-4 text-brand-cyan">
        <!-- Heartbeat Line -->
        <span class="text-lg font-bold tracking-tighter">--</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h3l2.5-4.5 3 9 2.5-4.5h4" />
        </svg>
        <span class="text-lg font-bold tracking-tighter">--</span>
      </div>
      <p class="text-gray-500 text-[15px]">
        {{ $doc['doc_home_desc'] ?? 'Lorem ipsum dolor sit amet consectetur adipiscing elit praesent aliquet. pretiumts' }}
      </p>
    </div>

    <!-- Slider -->
    <div class="team__slider relative" data-team-slider>
      <div class="team__viewport overflow-hidden pb-4">
        <div class="team__track flex" data-team-track>

          @foreach($teamCards as $card)
          <div class="team__slide px-4 w-full md:w-1/2 lg:w-1/4 shrink-0">
            <article class="bg-white rounded-lg overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:shadow-[0_4px_25px_rgba(0,0,0,0.1)] transition-shadow duration-300 group h-full border border-gray-100">
              <!-- Image & Overlay -->
              <div class="relative overflow-hidden aspect-[4/5] bg-gray-50 flex items-end justify-center">
                <img src="{{ $card['photo'] }}" alt="{{ $card['name'] }}" class="w-full h-full object-cover object-top" />
                <!-- Hover Overlay with Social Icons -->
                <div class="absolute inset-0 bg-white/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                  <div class="flex items-center gap-3 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    <a href="{{ $card['facebook'] ?: '#' }}" class="w-10 h-10 rounded-full bg-white text-navy flex items-center justify-center hover:bg-brand-cyan hover:text-white shadow-lg transition-colors" aria-label="Facebook">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z" />
                      </svg>
                    </a>
                    <a href="{{ $card['linkedin'] ?: '#' }}" class="w-10 h-10 rounded-full bg-white text-navy flex items-center justify-center hover:bg-brand-cyan hover:text-white shadow-lg transition-colors" aria-label="LinkedIn">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z" />
                      </svg>
                    </a>
                    <a href="{{ $card['youtube'] ?: '#' }}" class="w-10 h-10 rounded-full bg-white text-navy flex items-center justify-center hover:bg-brand-cyan hover:text-white shadow-lg transition-colors" aria-label="YouTube">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23 12s0-3.6-.5-5.3c-.3-1-1-1.8-2-2C18.9 4.2 12 4.2 12 4.2s-6.9 0-8.5.5c-1 .3-1.7 1-2 2C1 8.4 1 12 1 12s0 3.6.5 5.3c.3 1 1 1.8 2 2 1.6.5 8.5.5 8.5.5s6.9 0 8.5-.5c1-.3 1.7-1 2-2 .5-1.7.5-5.3.5-5.3zM9.8 15.5V8.5l6.2 3.5-6.2 3.5z" />
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <!-- Content -->
              <div class="p-6 text-center border-t border-gray-100">
                <p class="text-gray-500 text-[13px] mb-1.5">{{ $card['role'] }}</p>
                <h3 class="text-navy text-[19px] font-bold">{{ $card['name'] }}</h3>
              </div>
            </article>
          </div>
          @endforeach

        </div>
      </div>

      <!-- Navigation Arrows (overridden to look cleaner) -->
      <button type="button" class="team__nav is-prev !absolute !top-1/2 !-left-4 lg:!-left-6 !-translate-y-1/2 !w-12 !h-12 !rounded-full !bg-white shadow-[0_4px_15px_rgba(0,0,0,0.1)] flex items-center justify-center text-navy hover:!bg-brand-cyan hover:!text-white transition z-10" data-team-prev aria-label="Previous doctors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button type="button" class="team__nav is-next !absolute !top-1/2 !-right-4 lg:!-right-6 !-translate-y-1/2 !w-12 !h-12 !rounded-full !bg-white shadow-[0_4px_15px_rgba(0,0,0,0.1)] flex items-center justify-center text-navy hover:!bg-brand-cyan hover:!text-white transition z-10" data-team-next aria-label="Next doctors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>

    <!-- Dots -->
    <div class="team__dots mt-10 flex justify-center gap-2" data-team-dots></div>
  </div>
</section>

<!-- ===================== Health Packages ===================== -->
@php
$packageCards = $featuredPackages->isNotEmpty()
? $featuredPackages->map(fn ($p) => [
'title' => $p->title,
'desc' => $p->short_desc,
'image' => $p->image ? asset('storage/' . $p->image) : asset('assets/img/sr-1-2.jpg'),
'url' => route('package-details', $p->slug),
])
: collect([
['title' => 'Full Body Checkup', 'desc' => 'Comprehensive screening to catch health issues early.', 'image' => asset('assets/img/sr-1-2.jpg'), 'url' => route('packages')],
['title' => 'Dermatology & Wellness', 'desc' => 'Specialized skin and wellness treatments for every age.', 'image' => asset('assets/img/sr-1-3.jpg'), 'url' => route('packages')],
['title' => 'Cardiac Care Package', 'desc' => 'Complete heart health evaluation and monitoring.', 'image' => asset('assets/img/about-image.webp'),'url' => route('packages')],
['title' => 'Pediatric Care Package', 'desc' => 'Gentle, thorough checkups designed for children.', 'image' => asset('assets/img/slider-1.2.jpg'), 'url' => route('packages')],
['title' => 'Surgical Care Package', 'desc' => 'Pre and post-operative care from expert surgeons.', 'image' => asset('assets/img/sr-1-1.jpg'), 'url' => route('packages')],
['title' => 'Emergency Response Package', 'desc' => 'Round-the-clock critical care when it matters most.', 'image' => asset('assets/img/slider-1.3.jpg'), 'url' => route('packages')],
]);
@endphp
<section class="packages py-24 bg-cyan-50/40 relative overflow-hidden">
  <!-- Animated Floating Element -->
  <div class="absolute top-1/2 left-10 opacity-10 animate-pulse text-navy pointer-events-none z-0" style="animation-duration: 5s;">
    <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
    </svg>
  </div>
  <div class="container mx-auto px-4 lg:px-0">
    <!-- Centered Heading Area -->
    <div class="text-center mb-14 max-w-2xl mx-auto">
      <h2 class="text-3xl lg:text-[40px] font-bold text-navy mb-4 leading-[1.2]">
        {{ $pkg['pkg_title'] ?? 'We Maintain Cleanliness Rules Inside Our Hospital' }}
      </h2>
      <div class="flex justify-center items-center gap-1.5 mb-4 text-brand-cyan">
        <!-- Heartbeat Line -->
        <span class="text-lg font-bold tracking-tighter">--</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h3l2.5-4.5 3 9 2.5-4.5h4" />
        </svg>
        <span class="text-lg font-bold tracking-tighter">--</span>
      </div>
      <p class="text-gray-400 text-[15px]">
        {{ $pkg['pkg_desc'] ?? 'Lorem ipsum dolor sit amet consectetur adipiscing elit praesent aliquet. pretiumts' }}
      </p>
    </div>

    <!-- Packages Slider -->
    <div class="packages__slider relative px-0" data-packages-slider>
      <div class="packages__viewport overflow-hidden">
        <div class="packages__track flex" data-packages-track>
          @foreach($packageCards as $card)
          <div class="packages__slide w-full md:w-1/2 lg:w-1/3 2xl:w-1/4 shrink-0">
            <div class="group relative overflow-hidden aspect-square lg:aspect-auto lg:h-[350px] w-full border-r-[2px] border-white">
              <!-- Background Image -->
              <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />

              <!-- Hover Overlay -->
              <div class="absolute inset-0 bg-[#2b88f3]/85 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center backdrop-blur-[1px]">
                <!-- Hidden Title that appears on hover for context -->
                <h3 class="text-white font-bold text-xl mb-4 translate-y-4 group-hover:translate-y-0 transition-transform duration-300 opacity-0 group-hover:opacity-100 text-center px-4">
                  {{ $card['title'] }}
                </h3>
                <!-- View Details Button -->
                <a href="{{ $card['url'] }}" class="bg-white text-[#2b88f3] text-[14px] font-bold py-2.5 px-6 rounded transition-colors duration-300 hover:bg-navy hover:text-white shadow-lg shadow-black/10 translate-y-4 group-hover:translate-y-0 transform">
                  View Details
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Navigation Arrows -->
      <button type="button" class="packages__nav is-prev !absolute !top-1/2 !left-4 !-translate-y-1/2 !w-12 !h-12 !rounded-full !bg-white shadow-[0_4px_15px_rgba(0,0,0,0.1)] flex items-center justify-center text-navy hover:!bg-brand-cyan hover:!text-white transition z-10" data-packages-prev aria-label="Previous packages">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button type="button" class="packages__nav is-next !absolute !top-1/2 !right-4 !-translate-y-1/2 !w-12 !h-12 !rounded-full !bg-white shadow-[0_4px_15px_rgba(0,0,0,0.1)] flex items-center justify-center text-navy hover:!bg-brand-cyan hover:!text-white transition z-10" data-packages-next aria-label="Next packages">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>

    <!-- Dots -->
    <div class="packages__dots mt-10 flex justify-center gap-2" data-packages-dots></div>
  </div>
</section>

<!-- ===================== FAQ ===================== -->
<section class="faq !py-24 bg-white relative overflow-hidden">
  <!-- Subtle circular lines background decoration (bottom left) -->
  <svg class="absolute -bottom-20 -left-20 w-[400px] h-[400px] text-brand-cyan/5 pointer-events-none" viewBox="0 0 100 100" fill="none">
    <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="1.5" />
    <circle cx="50" cy="50" r="30" stroke="currentColor" stroke-width="1.5" />
    <circle cx="50" cy="50" r="20" stroke="currentColor" stroke-width="1.5" />
  </svg>

  <div class="container relative mx-auto px-4 lg:px-0 z-10">
    <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">

      <!-- Left: Image -->
      <div class="lg:w-[45%] w-full shrink-0 flex justify-center lg:justify-start">
        @php
        $faqImage = $homeFaq['image'] ?: asset('assets/img/faq.webp');
        $faqImageAlt = $homeFaq['image_alt'] ?: 'Smiling doctor';
        @endphp
        <img src="{{ $faqImage }}" alt="{{ $faqImageAlt }}" class="w-full h-auto rounded-[24px] shadow-lg object-cover" />
      </div>

      <!-- Right: Accordion -->
      <div class="lg:w-[55%] w-full flex flex-col gap-5">
        @php
        $homeFaqDefaults = [
        ['question' => 'Medical Eye facilisis erat id odio', 'answer' => "If you are diagnosed with high blood pressure, it's a good idea to have an eye examination. Hypertension can cause changes to the blood vessels in the retina (the back of the eye). These changes can be detected and monitored by eye examinations."],
        ['question' => 'Medical Eye facilisis erat id odio', 'answer' => "If you are diagnosed with high blood pressure, it's a good idea to have an eye examination. Hypertension can cause changes to the blood vessels in the retina (the back of the eye). These changes can be detected and monitored by eye examinations."],
        ['question' => 'Medical Eye facilisis erat id odio', 'answer' => "If you are diagnosed with high blood pressure, it's a good idea to have an eye examination. Hypertension can cause changes to the blood vessels in the retina (the back of the eye). These changes can be detected and monitored by eye examinations."],
        ['question' => 'Medical Eye facilisis erat id odio', 'answer' => "If you are diagnosed with high blood pressure, it's a good idea to have an eye examination. Hypertension can cause changes to the blood vessels in the retina (the back of the eye). These changes can be detected and monitored by eye examinations."],
        ];
        $homeFaqCards = (!empty($homeFaq['items']) && $homeFaq['items']->isNotEmpty()) ? $homeFaq['items'] : collect($homeFaqDefaults);
        @endphp

        @foreach($homeFaqCards as $faqIndex => $faqCard)
        <div class="faq-item group @if($faqIndex === 0) is-open @endif !bg-white border border-gray-100 !rounded-[20px] overflow-hidden shadow-[0_4px_15px_rgba(0,0,0,0.02)] transition-all duration-300 [&.is-open]:border-brand-cyan/20">

          <button type="button" class="faq-item__question !flex !w-full !items-center !justify-between !px-6 !py-5 transition-colors duration-300 group-[.is-open]:!bg-brand-cyan" data-faq-toggle>

            <div class="flex items-center gap-4">
              <!-- Unopened Icon: Number -->
              <span class="flex items-center justify-center w-8 h-8 shrink-0 rounded-full bg-brand-cyan text-white text-[14px] font-bold group-[.is-open]:hidden">
                {{ str_pad($faqIndex + 1, 2, '0', STR_PAD_LEFT) }}
              </span>
              <!-- Opened Icon: Checkmark -->
              <span class="items-center justify-center w-8 h-8 shrink-0 rounded-full bg-white text-brand-cyan hidden group-[.is-open]:flex shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7" />
                </svg>
              </span>

              <!-- Title -->
              <span class="text-[17px] font-bold text-navy group-[.is-open]:!text-white text-left leading-snug transition-colors">
                {{ $faqCard['question'] ?? '' }}
              </span>
            </div>

            <!-- Chevron -->
            <span class="!flex !w-6 !h-6 !items-center !justify-center shrink-0 text-brand-cyan group-[.is-open]:!text-white transition-transform duration-300 group-[.is-open]:!rotate-180 group-[.is-open]:!-rotate-180">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 9l-7 7-7-7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
          </button>

          <!-- Answer Wrapper -->
          <div class="faq-item__answer !px-0 !pb-0 !bg-white">
            <div class="overflow-hidden">
              <div class="px-6 pb-6 pt-4 text-gray-500 text-[14px] lg:text-[15px] leading-relaxed border-t border-gray-100">
                <p>{{ $faqCard['answer'] ?? '' }}</p>
              </div>
            </div>
          </div>

        </div>
        @endforeach
      </div>

    </div>
  </div>
</section>


<!-- ===================== Testimonials ===================== -->
<section class="testimonials">
  <img src="{{ asset('assets/img/bg-testimonial.webp') }}" alt="" class="testimonials__bg" aria-hidden="true" />
  <span class="testimonials__overlay" aria-hidden="true"></span>

  <div class="container relative mx-auto">
    <div class="testimonials__grid">
      <div class="testimonials__media">
        <span class="testimonials__ring"></span>
        <span class="testimonials__ring is-inner"></span>
        <span class="testimonials__orbit" aria-hidden="true"><span class="testimonials__ping"></span></span>
        <span class="testimonials__orbit is-slow" aria-hidden="true"><span class="testimonials__ping"></span></span>
        <span class="testimonials__orbit is-reverse" aria-hidden="true"><span class="testimonials__ping"></span></span>
        @php
        $testiImage = !empty($testi['testi_image']) ? asset('storage/' . $testi['testi_image']) : asset('assets/img/1752043437.img2.png');
        $testiImageAlt = ($testi['testi_image_alt'] ?? null) ?: 'Doctor smiling with arms crossed';
        @endphp
        <img
          src="{{ $testiImage }}"
          alt="{{ $testiImageAlt }}"
          class="testimonials__photo" />
      </div>

      <div class="testimonials__content">
        <h2 class="testimonials__title">{{ ($testi['testi_title'] ?? null) ?: __('frontend.home.testimonials_title') }}</h2>

        <div class="testimonial-slider" data-testimonials-slider>
          <button type="button" class="testimonials__nav is-prev" data-testimonials-prev aria-label="Previous testimonial">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 12H5M11 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
          <button type="button" class="testimonials__nav is-next" data-testimonials-next aria-label="Next testimonial">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>

          <div class="testimonial-slider__viewport">
            <div class="testimonial-slider__track" data-testimonials-track>
              @php
              $homeTestimonialDefaults = [
              ['name' => 'Emma Carter', 'role' => 'Patient', 'avatar' => asset('assets/img/sr-1-2.jpg'), 'title' => 'Best Treatment', 'review' => "From the first visit, I felt completely at ease. The staff was warm, patient, and incredibly supportive. They took time to listen and explain everything clearly. Their kindness made a real difference in my recovery. I'm thankful for such a caring team."],
              ['name' => 'Rihana Roy', 'role' => 'Patient', 'avatar' => asset('assets/img/sr-1-3.jpg'), 'title' => 'Caring Staff', 'review' => "My experience here was nothing short of amazing. The team treated me with kindness and genuine care. Every step of my treatment was handled with professionalism. I felt heard, supported, and completely at ease. I'm truly grateful for the care I received."],
              ['name' => 'Daniel Cruz', 'role' => 'Patient', 'avatar' => asset('assets/img/projects-2.jpg'), 'title' => 'Compassionate Care', 'review' => "The team walked me through every step before they even touched an instrument. What could have been stressful turned into the calmest checkup I've ever had. I finally look forward to my visits."],
              ];
              $homeTestimonialCards = (isset($testimonials) && $testimonials->isNotEmpty())
              ? $testimonials->map(fn($t) => ['name' => $t->name, 'role' => $t->role, 'avatar' => $t->avatar ? asset('storage/' . $t->avatar) : asset('assets/img/sr-1-2.jpg'), 'title' => null, 'review' => $t->review])
              : collect($homeTestimonialDefaults);
              @endphp
              @foreach($homeTestimonialCards as $tCard)
              <div class="testimonial-card">
                <div class="testimonial-card__media">
                  <div class="testimonial-card__photo-wrap">
                    <img src="{{ $tCard['avatar'] }}" alt="{{ $tCard['name'] }}" class="testimonial-card__photo" />
                    <button type="button" class="testimonial-card__play">
                      <span class="testimonial-card__play-icon">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M8 5v14l11-7z" />
                        </svg>
                      </span>
                      {{ __('frontend.home.watch_video') }}
                    </button>
                  </div>
                  <p class="testimonial-card__name">{{ $tCard['name'] }}</p>
                  <p class="testimonial-card__role">{{ $tCard['role'] }}</p>
                </div>

                <div class="testimonial-card__body">
                  @if($tCard['title'])
                  <h3 class="testimonial-card__title">{{ $tCard['title'] }}</h3>
                  @endif
                  <p class="testimonial-card__quote">
                    {{ $tCard['review'] }}
                  </p>

                  <span class="testimonial-card__mark" aria-hidden="true">
                    <span class="testimonial-card__mark-ring"></span>
                    <span class="testimonial-card__mark-ring is-offset"></span>
                  </span>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="testimonials__dots" data-testimonials-dots></div>
      </div>
    </div>
  </div>
</section>


<!-- ===================== Awards ===================== -->
<section class="awards">
  <div class="container mx-auto">
    <div class="awards__grid">
      <div class="awards__intro">
        <h2 class="awards__title">{{ ($award['award_title'] ?? null) ?: __('frontend.home.awards_title') }}</h2>
        <p class="awards__desc">
          {{ ($award['award_desc'] ?? null) ?: __('frontend.home.awards_desc') }}
        </p>
      </div>

      @php
      $homeAwardCards = \App\Support\AwardCards::from($featuredAwards ?? null);
      @endphp
      <div class="awards__slider" data-awards-slider>
        <div class="awards__track" data-awards-track>
          @foreach($homeAwardCards as $awardCard)
          <x-frontend.award-card :award="$awardCard" />
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== Blog ===================== -->
@php
$blogFallbackImages = [asset('assets/img/blog-one.png'), asset('assets/img/blog-2.png'), null, asset('assets/img/blog-4.jpg')];
$blogCards = $latestBlogs->isNotEmpty()
? $latestBlogs->values()->map(fn ($b, $i) => [
'title' => $b->title,
'date' => ($b->published_at ?: $b->created_at)->format('F j, Y'),
'image' => $b->feature_image ? asset('storage/' . $b->feature_image) : ($blogFallbackImages[$i % 4] ?? asset('assets/img/blog-2.png')),
'url' => route('blog-details', $b->slug),
])
: collect([
['title' => 'The Skincare Routine That Works Expert Tips.', 'date' => 'July 6, 2025', 'image' => asset('assets/img/blog-one.png'), 'url' => '#'],
['title' => 'The Art of Managing Business and Patient Care', 'date' => 'July 9, 2025', 'image' => asset('assets/img/blog-2.png'), 'url' => '#'],
['title' => 'Strategies for Balancing Business Demands wit …', 'date' => 'July 9, 2025', 'image' => null, 'url' => '#'],
['title' => 'Effective Healthcare Tips', 'date' => 'July 9, 2025', 'image' => asset('assets/img/blog-4.jpg'), 'url' => '#'],
]);
@endphp
<section class="blog">
  <div class="container mx-auto">
    <div class="blog__head">
      <h2 class="blog__title">{{ $blog['blog_home_title'] ?? __('frontend.home.blog_title') }}</h2>
      <a href="{{ route('blog-list') }}" class="btn-view-all">
        {{ __('frontend.common.view_all') }}
        <span class="btn-view-all__icon">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
      </a>
    </div>

    <div class="blog__grid">
      @foreach($blogCards as $card)
      @if($loop->index === 0)
      <!-- Card A: full-bleed photo with a dark navy title overlaid at
                 the top over a soft white scrim (so it stays legible no
                 matter what's behind it) and a Read More CTA at the bottom,
                 mirroring cards B/D's overlay pattern but light-on-photo. -->
      <article class="blog-card blog-card--split is-tall">
        <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="blog-card__img" />
        <span class="blog-card--split__scrim" aria-hidden="true"></span>
        <div class="blog-card--split__top">
          <span class="blog-card__date"><span class="blog-card__date-dot"></span>{{ $card['date'] }}</span>
          <h3 class="blog-card--split__title">{{ $card['title'] }}</h3>
        </div>
        <a href="{{ $card['url'] }}" class="blog-card--split__cta">
          {{ __('frontend.common.read_more') }}
          <span class="blog-card--split__cta-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
        </a>
        <span class="blog-card--split__bubble"></span>
      </article>
      @elseif($loop->index === 2)
      <!-- Card C: plain copy card, no image -->
      <article class="blog-card blog-card--plain">
        <div>
          <span class="blog-card__date"><span class="blog-card__date-dot"></span>{{ $card['date'] }}</span>
          <h3 class="blog-card--plain__title">{{ $card['title'] }}</h3>
        </div>
        <div class="blog-card--plain__footer">
          <a href="{{ $card['url'] }}" class="blog-card__arrow" aria-label="Read more">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </a>
        </div>
      </article>
      @else
      <!-- Card B/D: full-bleed photo, overlay content -->
      <article class="blog-card blog-card--photo {{ $loop->index === 1 ? 'is-tall' : '' }}">
        <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="blog-card__img" @if($loop->index === 1) style="object-position: 50% 20%;" @endif />
        <span class="blog-card__overlay"></span>
        <span class="blog-card__date relative z-10 w-fit"><span class="blog-card__date-dot"></span>{{ $card['date'] }}</span>
        <div class="blog-card--photo__footer">
          <h3 class="blog-card--photo__title">{{ $card['title'] }}</h3>
          <a href="{{ $card['url'] }}" class="blog-card__arrow" aria-label="Read more">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </a>
        </div>
      </article>
      @endif
      @endforeach
    </div>
  </div>
</section>

<!-- ===================== Scroll Animation Script ===================== -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Add base classes for animation to all containers inside sections
    const containers = document.querySelectorAll('section > .container');
    containers.forEach(el => {
      // Avoid hero section and testimonials since they have custom structure
      if (!el.closest('.hero') && !el.closest('.testimonials')) {
        el.classList.add('transition-all', 'duration-[1200ms]', 'ease-out', 'opacity-0', 'translate-y-12');
      }
    });

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.remove('opacity-0', 'translate-y-12');
          entry.target.classList.add('opacity-100', 'translate-y-0');
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: "0px 0px -50px 0px"
    });

    containers.forEach(el => {
      if (!el.closest('.hero') && !el.closest('.testimonials')) {
        observer.observe(el);
      }
    });
  });
</script>

<!-- ===================== Make an Appointment ===================== -->
<!-- <x-frontend.book-appointment :settings="$appt" :doctors="$appointmentDoctors" :specializations="$appointmentSpecializations" source="home" /> -->
@endsection