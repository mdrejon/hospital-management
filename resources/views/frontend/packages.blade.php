@extends('layouts.frontend')

@php
$heroTitle = $pkg['pkg_page_hero_title'] ?? 'Our Health Packages';
$heroImage = !empty($pkg['pkg_page_hero_image']) ? asset('storage/' . $pkg['pkg_page_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $pkg['pkg_seo_title'] ?? ('Our Health Packages | ' . config('app.name'));
$seoDesc = $pkg['pkg_seo_description'] ?? 'Explore Sitakund Modern Hospital Ltd.\'s health packages designed for every stage of life.';
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
    <img src="{{ $heroImage }}" alt="Team of Sitakund Modern Hospital Ltd. doctors" class="page-header__bg" />
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
<section class="services">
  <div class="container mx-auto">
    <div class="services__head">
      <p class="services__eyebrow">Our Health Packages</p>
      <h2 class="services__title">{{ $pkg['pkg_desc'] ?? 'Complete Health Solutions — Because You Deserve the Best' }}</h2>
    </div>

    <div class="services__grid">
      @foreach($packageCards as $card)
      <article class="service-card">
        <div class="service-card__media">
          <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="service-card__img" />
        </div>
        <div class="service-card__body">
          <h3 class="service-card__title">{{ $card['title'] }}</h3>
          <p class="service-card__desc">{{ $card['desc'] }}</p>
          <a href="{{ $card['url'] }}" class="service-card__btn">
            Read more
            <span class="service-card__btn-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
          </a>
        </div>
      </article>
      @endforeach
    </div>
  </div>
</section>
@endsection