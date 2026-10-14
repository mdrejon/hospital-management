@extends('layouts.frontend')

@php
$heroTitle = $svc['svc_page_hero_title'] ?? 'Our Services';
$heroImage = !empty($svc['svc_page_hero_image']) ? asset('storage/' . $svc['svc_page_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $svc['svc_seo_title'] ?? ('Our Services | ' . config('app.name'));
$seoDesc = $svc['svc_seo_description'] ?? 'Explore the full range of medical and health care services offered by Sitakund Modern Hospital Ltd..';
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
<section class="services">
  <div class="container mx-auto">
    <div class="services__head">
      <p class="services__eyebrow">Explore Medical Department</p>
      <h2 class="services__title">Complete Health Solutions — Because You Deserve the Best</h2>
    </div>

    <div class="services__grid">
      @foreach($serviceCards as $card)
      <article class="service-card">
        <div class="service-card__media">
          <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="service-card__img" />
          <span class="service-card__icon">
            {!! $card['icon_svg'] ?: $defaultIcon !!}
          </span>
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