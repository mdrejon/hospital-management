@extends('layouts.frontend')

@php
$heroTitle = $hist['hist_hero_title'] ?? 'Our History';
$heroImage = !empty($hist['hist_hero_image']) ? asset('storage/' . $hist['hist_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $hist['hist_seo_title'] ?? ('Our History | ' . config('app.name'));
$seoDesc = $hist['hist_seo_description'] ?? "From a humble clinic to the region's most trusted hospital — explore the milestones that shaped Medicare Lab Ltd..";
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDesc)
@section('og_title', $seoTitle)
@section('og_description', $seoDesc)
@if(!empty($hist['hist_seo_keywords']))
@section('meta_keywords', $hist['hist_seo_keywords'])
@endif
@if(!empty($hist['hist_seo_og_image']))
@section('og_image', asset('storage/' . $hist['hist_seo_og_image']))
@endif

@section('content')

<!-- ===================== Breadcrumb / Page header ===================== -->
<section class="page-header">
  <span class="page-header__badge">24/7 Emergency Service</span>

  <x-frontend.page-header-social />

  <div class="page-header__media">
    <img src="{{ $heroImage }}" alt="Team of Medicare Lab Ltd. doctors" class="page-header__bg" />
    <span class="page-header__overlay"></span>
  </div>

  <div class="page-header__inner">
    <h1 class="page-header__title">{{ $heroTitle }}</h1>
    <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">{{ __('frontend.nav.home') }}</a>
      <span class="page-header__breadcrumb-sep">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span>
      <span>{{ $heroTitle }}</span>
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

<!-- ===================== Our History Timeline ===================== -->
@php
$histFallbackImages = [asset('assets/img/slider-1.2.jpg'), asset('assets/img/sr-1-1.jpg'), asset('assets/img/sr-1-3.jpg'), asset('assets/img/projects-3.jpg'), asset('assets/img/slider-1.3.jpg')];
$timeline = !empty($hist['hist_timeline']) ? $hist['hist_timeline'] : [
['year' => '2013', 'tag' => 'Foundation', 'heading' => 'Grand Opening — Medicare Lab Ltd. Is Born', 'content' => 'With a vision to redefine community healthcare, Medicare Lab Ltd. opened its doors on 36D Street, Brooklyn in 2013 with a small team of dedicated physicians.', 'badges' => ['30 Beds Launched', '24/7 Emergency', 'Outpatient Care'], 'image' => null, 'reversed' => false],
['year' => '2016', 'tag' => 'Diagnostics', 'heading' => 'Advanced Diagnostic & Imaging Center', 'content' => 'In 2016, Medicare Lab Ltd. unveiled a full diagnostic wing — bringing MRI, CT scanning and a modern pathology laboratory together under one roof.', 'badges' => ['MRI & CT Scan', 'Digital X-Ray', 'Pathology Lab'], 'image' => null, 'reversed' => true],
['year' => '2019', 'tag' => 'Critical Care','heading' => 'Dedicated ICU & Cardiac Wing', 'content' => 'A 20-bed intensive care unit and a specialised cardiac wing opened in 2019, giving the community round-the-clock access to life-saving critical care.', 'badges' => ['20-Bed ICU', 'Cardiology Dept', '24/7 CCU'], 'image' => null, 'reversed' => false],
['year' => '2022', 'tag' => 'Innovation', 'heading' => 'Telemedicine & Digital Care Launch', 'content' => "Medicare Lab Ltd. went digital in 2022 — online appointment booking, video consultations and e-prescriptions brought expert care into patients' homes.", 'badges' => ['Video Consultations', 'Online Booking', 'E-Prescriptions'], 'image' => null, 'reversed' => true],
['year' => '2025', 'tag' => 'Recognition', 'heading' => 'Award-Winning Patient Care', 'content' => 'Today Medicare Lab Ltd. stands nationally accredited — a 150-bed hospital trusted by thousands of families and honoured for excellence in patient care.', 'badges' => ['150+ Beds', '75+ Specialists', 'National Accreditation'], 'image' => null, 'reversed' => false],
];
@endphp
<section class="history">
  <div class="container mx-auto">
    <p class="history__eyebrow">
      <span class="history__eyebrow-dot"></span>
      {{ $hist['hist_badge'] ?? 'Our Journey' }}
      <span class="history__eyebrow-dot"></span>
    </p>
    <h2 class="history__title">{{ $hist['hist_title'] ?? 'A Decade of Care, Compassion & Excellence' }}</h2>
    <p class="history__desc">
      {{ $hist['hist_desc'] ?? "From a humble clinic to the region's most trusted hospital — explore the milestones that shaped Medicare Lab Ltd. into the award-winning healthcare destination it is today." }}
    </p>

    <div class="history__timeline">
      <span class="history__line" aria-hidden="true"></span>

      @foreach($timeline as $i => $item)
      <article class="history-item {{ !empty($item['reversed']) ? 'history-item--reverse' : '' }}">
        <div class="history-item__media">
          <img src="{{ !empty($item['image']) ? asset('storage/' . $item['image']) : $histFallbackImages[$i % count($histFallbackImages)] }}" alt="{{ $item['heading'] ?? '' }}" class="history-item__img" />
        </div>
        <div class="history-item__node">
          <span class="history-item__year">{{ $item['year'] ?? '' }}</span>
        </div>
        <div class="history-item__content">
          @if(!empty($item['tag']))
          <span class="history-item__badge">{{ $item['tag'] }}</span>
          @endif
          <h3 class="history-item__title">{{ $item['heading'] ?? '' }}</h3>
          @if(!empty($item['content']))
          <p class="history-item__desc">
            {{ $item['content'] }}
          </p>
          @endif
          @if(!empty($item['badges']))
          <div class="history-item__tags">
            @foreach($item['badges'] as $badge)
            <span class="history-item__tag">{{ $badge }}</span>
            @endforeach
          </div>
          @endif
        </div>
      </article>
      @endforeach
    </div>
  </div>
</section>
@endsection