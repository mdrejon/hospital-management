@extends('layouts.frontend')

@php
$heroTitle = $svc['svc_page_hero_title'] ?? 'Our Services';
$heroImage = !empty($svc['svc_page_hero_image']) ? asset('storage/' . $svc['svc_page_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $svc['svc_seo_title'] ?? ('Our Services | ' . config('app.name'));
$seoDesc = $svc['svc_seo_description'] ?? 'Explore the full range of medical and health care services offered by Medicare Lab Ltd..';
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDesc)
@section('og_title', $seoTitle)
@section('og_description', $seoDesc)
@if(!empty($svc['svc_seo_keywords']))
@section('meta_keywords', $svc['svc_seo_keywords'])
@endif
@if(!empty($svc['svc_seo_og_image']))
@section('og_image', asset('storage/' . $svc['svc_seo_og_image']))
@endif

@section('content')

<!-- ===================== Breadcrumb / Page header ===================== -->
<section class="page-header">
  <div class="page-header__media">
    <img src="{{ $heroImage }}" alt="Team of Medicare Lab Ltd. doctors" class="page-header__bg" />
    <span class="page-header__overlay"></span>
  </div>

  <span class="page-header__badge">24/7 Emergency Service</span>

  <x-frontend.page-header-social />

  <div class="page-header__inner">
    <h1 class="page-header__title">{{ $heroTitle }}</h1>
    <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">{{ __('frontend.nav.home') }}</a>
      <span class="page-header__breadcrumb-sep">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span>
      <span>{{ __('frontend.breadcrumb.services') }}</span>
    </nav>
  </div>

  <a href="tel:{{ preg_replace('/[^0-9+]/', '', $headerSettings['header_phone'] ?? '11234567890') }}" class="page-header__call">
    <span class="page-header__call-icon">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6" />
      </svg>
    </span>
    <span class="page-header__call-text">{{ $headerSettings['header_phone'] ?? '1 123 456 7890' }}</span>
  </a>
</section>

<!-- ===================== Services ===================== -->
@php
$defaultIcon = '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M9 4a3 3 0 0 0-3 3 3 3 0 0 0-1 5.8A3 3 0 0 0 8 17a3 3 0 0 0 3-3V7a3 3 0 0 0-2-3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
  <path d="M15 4a3 3 0 0 1 3 3 3 3 0 0 1 1 5.8A3 3 0 0 1 16 17a3 3 0 0 1-3-3V7a3 3 0 0 1 2-3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
</svg>';
$serviceCards = $services->isNotEmpty()
? $services->map(fn ($s) => [
'title' => $s->title,
'desc' => $s->short_desc,
'icon_svg' => $s->icon_svg,
'image' => $s->image ? asset('storage/' . $s->image) : asset('assets/img/sr-1-2.jpg'),
'url' => route('service-details', $s->slug),
])
: collect([
['title' => 'Mental Health & Wellness', 'desc' => 'Counseling, therapy, and psychiatric care for mental well-being.', 'icon_svg' => null, 'image' => asset('assets/img/sr-1-2.jpg'), 'url' => '#'],
['title' => 'Emergency & Urgent Care', 'desc' => '24/7 medical assistance for accidents and critical health conditions.', 'icon_svg' => null, 'image' => asset('assets/img/appoinment.jpg'), 'url' => '#'],
['title' => 'Diagnostic & Laboratory', 'desc' => 'Blood tests, imaging (X-rays, MRIs, CT scans), and screenings diagnosis.', 'icon_svg' => null, 'image' => asset('assets/img/projects-4.jpg'), 'url' => '#'],
['title' => 'Maternity & Pediatric Care', 'desc' => "Comprehensive care for expecting mothers, newborns, children's health.", 'icon_svg' => null, 'image' => asset('assets/img/slider-1.2.jpg'), 'url' => '#'],
['title' => 'Dental Care Services', 'desc' => 'Our Dental Care Services are designed to provide comprehensive treatment.', 'icon_svg' => null, 'image' => asset('assets/img/projects-2.jpg'), 'url' => '#'],
['title' => 'Surgery Care', 'desc' => 'Our Surgery Care services provide expert, compassionate treatment.', 'icon_svg' => null, 'image' => asset('assets/img/sr-1-1.jpg'), 'url' => '#'],
]);
@endphp
<section class="services py-section bg-slate-50 relative overflow-hidden">
  <!-- Animated Floating Element -->
  <div class="absolute top-20 left-10 opacity-20 animate-bounce text-navy pointer-events-none z-0" style="animation-duration: 4s;">
    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v8m-4-4h8"/></svg>
  </div>
  <div class="container mx-auto px-4">
    <!-- Heading Area -->
    <div class="text-center mb-section-gap max-w-2xl mx-auto">
      <p class="text-brand-cyan font-bold tracking-widest uppercase text-eyebrow mb-3">
        Explore Medical Department
      </p>
      <h2 class="text-h2 font-bold text-navy mb-6">
        Complete Health Solutions — Because You Deserve the Best
      </h2>
    </div>

    <!-- 3-Column Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($serviceCards as $card)
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
                {!! $card['icon_svg'] ?: $defaultIcon !!}
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
<!-- ===================== Scroll Animation Script ===================== -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Add base classes for animation to all containers inside sections
    const containers = document.querySelectorAll('section > .container');
    containers.forEach(el => {
      // Avoid hero section and testimonials since they have custom structure
      if(!el.closest('.hero') && !el.closest('.page-header') && !el.closest('.testimonials')) {
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
    }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

    containers.forEach(el => {
      if(!el.closest('.hero') && !el.closest('.page-header') && !el.closest('.testimonials')) {
        observer.observe(el);
      }
    });
  });
</script>

@endsection