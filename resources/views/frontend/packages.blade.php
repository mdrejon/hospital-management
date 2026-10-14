@extends('layouts.frontend')

@php
$heroTitle = $pkg['pkg_page_hero_title'] ?? 'Our Health Packages';
$heroImage = !empty($pkg['pkg_page_hero_image']) ? asset('storage/' . $pkg['pkg_page_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $pkg['pkg_seo_title'] ?? ('Our Health Packages | ' . config('app.name'));
$seoDesc = $pkg['pkg_seo_description'] ?? 'Explore Medicare Lab Ltd.\'s health packages designed for every stage of life.';
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDesc)
@section('og_title', $seoTitle)
@section('og_description', $seoDesc)
@if(!empty($pkg['pkg_seo_keywords']))
@section('meta_keywords', $pkg['pkg_seo_keywords'])
@endif
@if(!empty($pkg['pkg_seo_og_image']))
@section('og_image', asset('storage/' . $pkg['pkg_seo_og_image']))
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
      <span>{{ __('frontend.breadcrumb.packages') }}</span>
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

<!-- ===================== Packages List ===================== -->
@php
$packageCards = $packages->isNotEmpty()
? $packages->map(fn ($p) => [
'title' => $p->title,
'desc' => $p->short_desc,
'image' => $p->image ? asset('storage/' . $p->image) : asset('assets/img/sr-1-2.jpg'),
'url' => route('package-details', $p->slug),
])
: collect([
['title' => 'Full Body Checkup', 'desc' => 'Comprehensive screening to catch health issues early.', 'image' => asset('assets/img/sr-1-2.jpg'), 'url' => '#'],
['title' => 'Dermatology & Wellness', 'desc' => 'Specialized skin and wellness treatments for every age.', 'image' => asset('assets/img/sr-1-3.jpg'), 'url' => '#'],
['title' => 'Cardiac Care Package', 'desc' => 'Complete heart health evaluation and monitoring.', 'image' => asset('assets/img/about-image.webp'),'url' => '#'],
['title' => 'Pediatric Care Package', 'desc' => 'Gentle, thorough checkups designed for children.', 'image' => asset('assets/img/slider-1.2.jpg'), 'url' => '#'],
['title' => 'Surgical Care Package', 'desc' => 'Pre and post-operative care from expert surgeons.', 'image' => asset('assets/img/sr-1-1.jpg'), 'url' => '#'],
['title' => 'Emergency Response Package', 'desc' => 'Round-the-clock critical care when it matters most.', 'image' => asset('assets/img/slider-1.3.jpg'), 'url' => '#'],
]);
@endphp
<section class="packages py-section bg-cyan-50/40 relative overflow-hidden">
  <!-- Animated Floating Element -->
  <div class="absolute top-1/2 left-10 opacity-10 animate-pulse text-navy pointer-events-none z-0" style="animation-duration: 5s;">
    <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
    </svg>
  </div>
  <div class="container mx-auto px-4 lg:px-0">
    <div class="text-center mb-section-gap max-w-2xl mx-auto">
      @if(!empty($pkg['pkg_badge']))
      <p class="text-brand-cyan font-bold tracking-widest uppercase text-eyebrow mb-3">
        {{ $pkg['pkg_badge'] }}
      </p>
      @endif
      <h2 class="text-h2 font-bold text-navy mb-4">
        {{ $pkg['pkg_desc'] ?? 'Complete Health Solutions — Because You Deserve the Best' }}
      </h2>
      <div class="flex justify-center items-center gap-1.5 mb-4 text-brand-cyan">
        <!-- Heartbeat Line -->
        <span class="text-h5 font-bold tracking-tighter">--</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h3l2.5-4.5 3 9 2.5-4.5h4" />
        </svg>
        <span class="text-h5 font-bold tracking-tighter">--</span>
      </div>
    </div>

    <!-- Standard Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full max-w-7xl mx-auto px-4">
      @foreach($packageCards as $card)
      <div class="group relative overflow-hidden aspect-[4/3] w-full bg-white rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.06)] hover:shadow-[0_10px_30px_rgba(0,0,0,0.1)] transition-shadow duration-300">
        <!-- Background Image -->
        <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />

        <!-- Hover Overlay -->
        <div class="absolute inset-0 bg-[#2b88f3]/85 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center backdrop-blur-[1px]">
          <!-- Hidden Title that appears on hover for context -->
          <h3 class="text-white font-bold text-h4 mb-4 translate-y-4 group-hover:translate-y-0 transition-transform duration-300 opacity-0 group-hover:opacity-100 text-center px-4">
            {{ $card['title'] }}
          </h3>
          <!-- View Details Button -->
          <a href="{{ $card['url'] }}" class="bg-white text-[#2b88f3] text-btn font-bold py-2.5 px-6 rounded transition-colors duration-300 hover:bg-navy hover:text-white shadow-lg shadow-black/10 translate-y-4 group-hover:translate-y-0 transform">
            View Details
          </a>
        </div>
      </div>
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
      if (!el.closest('.hero') && !el.closest('.page-header') && !el.closest('.testimonials')) {
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
      if (!el.closest('.hero') && !el.closest('.page-header') && !el.closest('.testimonials')) {
        observer.observe(el);
      }
    });
  });
</script>

@endsection