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
          <div class="hero-slide__content pl-8 lg:pl-16 !max-w-2xl 2k:!max-w-3xl 4k:!max-w-4xl" data-hero-content>
            @if($slide['eyebrow'])
            <p class="hero-slide__eyebrow !block !text-brand-cyan !italic !mb-4" style="font-family: 'Georgia', serif;">
              {{ $slide['eyebrow'] }}
            </p>
            @endif
            <h1 class="hero-slide__title !text-navy !font-bold !mb-5">
              {{ $slide['title'] }}
              @if($slide['accent'])
              <br>
              <span class="accent !text-brand-cyan">{{ $slide['accent'] }}</span>
              @endif
            </h1>
            @if($slide['desc'])
            <p class="hero-slide__desc !text-gray-500 !max-w-[480px] 2k:!max-w-[680px] 4k:!max-w-[900px]">
              {{ $slide['desc'] }}
            </p>
            @endif
            <a href="{{ $slide['button_url'] ?: route('appointment') }}" class="hero-slide__cta !bg-brand-cyan !text-white !rounded-full !pr-7 !pl-2 !py-2 hover:!bg-navy !transition !duration-300 shadow-lg shadow-brand-cyan/30">
              <span class="w-8 h-8 rounded-full bg-white text-brand-cyan flex items-center justify-center mr-3 shrink-0">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M13 2L3 14h8v8l10-12h-8V2z" />
                </svg>
              </span>
              <span class="!font-bold !normal-case !tracking-normal !text-white">{{ $slide['button_text'] ?: 'View All Services' }}</span>
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
<x-frontend.about-v2 :about="$about" :header-settings="$headerSettings" />


<!-- ===================== Why Choose Us ===================== -->
<x-frontend.why-choose-us :about="$about" />

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
<section class="departments py-section bg-slate-50 relative overflow-hidden">
  <!-- Animated Floating Element -->
  <div class="absolute top-20 left-10 opacity-20 animate-bounce text-navy pointer-events-none z-0" style="animation-duration: 4s;">
    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <circle cx="12" cy="12" r="10" />
      <path stroke-linecap="round" d="M12 8v8m-4-4h8" />
    </svg>
  </div>
  <div class="container mx-auto px-4">
    <!-- Heading Area -->
    <div class="text-center mb-section-gap max-w-2xl 2k:max-w-3xl 4k:max-w-4xl mx-auto">
      <p class="text-brand-cyan font-bold tracking-widest uppercase text-eyebrow mb-3">
        {{ $svc['svc_badge'] ?? __('frontend.home.services_badge') }}
      </p>
      <h2 class="text-h2 font-bold text-navy mb-6">
        {{ $svc['svc_title'] ?? __('frontend.home.services_title') }}
      </h2>
      <p class="text-gray-500 text-body mb-8 leading-relaxed">
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
          <h3 class="text-navy text-h4 font-bold mb-3 transition-colors duration-300 group-hover:text-white">
            {{ $card['title'] }}
          </h3>
          <p class="text-gray-500 text-small leading-relaxed mb-6 transition-colors duration-300 group-hover:text-white/90 line-clamp-3">
            {{ $card['desc'] }}
          </p>

          <a href="{{ $card['url'] }}" class="mt-auto inline-flex items-center gap-2 text-navy text-btn font-bold transition-colors duration-300 group-hover:text-white group-hover:opacity-90">
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
<section class="team py-section bg-white relative overflow-hidden">
  <!-- Animated Floating Element -->
  <div class="absolute bottom-20 right-10 opacity-[0.08] animate-spin text-brand-cyan pointer-events-none z-0" style="animation-duration: 20s;">
    <svg width="150" height="150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
      <circle cx="12" cy="12" r="10" stroke-dasharray="4 4" />
    </svg>
  </div>
  <div class="container mx-auto px-4">
    <!-- Centered Heading Area -->
    <div class="text-center mb-section-gap max-w-2xl 2k:max-w-3xl 4k:max-w-4xl mx-auto">
      @if(!empty($doc['doc_home_badge']))
      <p class="text-brand-cyan font-bold tracking-widest uppercase text-eyebrow mb-3">
        {{ $doc['doc_home_badge'] }}
      </p>
      @endif
      <h2 class="text-h2 font-bold text-navy mb-4">
        {{ $doc['doc_home_title'] ?? 'We Have Specialist Doctors To Solve Your Problems' }}
      </h2>
      <div class="flex justify-center items-center gap-1.5 mb-4 text-brand-cyan">
        <!-- Heartbeat Line -->
        <span class="text-h5 font-bold tracking-tighter">--</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h3l2.5-4.5 3 9 2.5-4.5h4" />
        </svg>
        <span class="text-h5 font-bold tracking-tighter">--</span>
      </div>
      <!-- <p class="text-gray-500 text-body">
        {{ $doc['doc_home_desc'] ?? 'Lorem ipsum dolor sit amet consectetur adipiscing elit praesent aliquet. pretiumts' }}
      </p> -->
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
                <p class="text-gray-500 text-small mb-1.5">{{ $card['role'] }}</p>
                <h3 class="text-navy text-h4 font-bold">{{ $card['name'] }}</h3>
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

<!-- ===================== Health Packages (V2 — modern card style) ===================== -->
{{-- Switch to <x-frontend.packages-v1 ...> for the hover-overlay style --}}
@php
$packageCards = $featuredPackages->isNotEmpty()
? $featuredPackages->map(fn ($p) => [
'title' => $p->title,
'desc' => $p->short_desc,
'image' => $p->image ? asset('storage/' . $p->image) : asset('assets/img/sr-1-2.jpg'),
'url' => route('package-details', $p->slug),
])
: collect([
['title' => 'Full Body Checkup Package', 'desc' => 'Comprehensive screening covering blood tests, ECG and ultrasonography.', 'image' => asset('assets/img/sr-1-2.jpg'), 'url' => route('packages')],
['title' => 'Antenatal Care Package', 'desc' => 'Complete pregnancy care from check-up to delivery, guided by our Gynecology & Obstetrics team.', 'image' => asset('assets/img/sr-1-3.jpg'), 'url' => route('packages')],
['title' => 'Cardiac Care Package', 'desc' => 'Full heart health evaluation and monitoring by our Cardiology specialists.', 'image' => asset('assets/img/about-image.webp'), 'url' => route('packages')],
['title' => 'Diabetic Care Package', 'desc' => 'Regular diabetes monitoring and consultation from our Diabetic Center.', 'image' => asset('assets/img/slider-1.2.jpg'), 'url' => route('packages')],
['title' => 'Emergency & Ambulance Package', 'desc' => '24-hour emergency response with ambulance pickup for critical situations.', 'image' => asset('assets/img/sr-1-1.jpg'), 'url' => route('packages')],
['title' => 'Pediatric Care Package', 'desc' => 'Gentle, thorough checkups designed for children of every age.', 'image' => asset('assets/img/slider-1.3.jpg'), 'url' => route('packages')],
]);
@endphp
<x-frontend.packages-v2 :package-cards="$packageCards" :pkg="$pkg" />


<!-- ===================== FAQ ===================== -->
{{-- FAQ Version 1 (Displayed on home page as requested: "need to show v1 in home page too") --}}
<x-frontend.faq-v1 :home-faq="$homeFaq" :footer-settings="$footerSettings" />

{{-- To switch to FAQ Version 2 (Red numbered accordion):
<x-frontend.faq-v2 :home-faq="$homeFaq" />
--}}


<!-- ===================== Testimonials ===================== -->
<x-frontend.testimonial-v2 :testimonials="$testimonials" :testi="$testi" />


<!-- ===================== Awards ===================== -->
<section class="awards">
  <div class="container mx-auto">
    <div class="awards__grid">
      <div class="awards__intro">
        @if(!empty($award['award_badge']))
        <p class="text-brand-cyan font-bold tracking-widest uppercase text-eyebrow mb-2">
          {{ $award['award_badge'] }}
        </p>
        @endif
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
<x-frontend.blog-v2 :latest-blogs="$latestBlogs" :blog="$blog" />

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
@endsection