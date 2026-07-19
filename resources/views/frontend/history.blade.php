@extends('layouts.frontend')

@php
  $heroTitle = $hist['hist_hero_title'] ?? 'Our History';
  $heroImage = !empty($hist['hist_hero_image']) ? asset('storage/' . $hist['hist_hero_image']) : asset('assets/img/breadcumb.webp');
  $seoTitle  = $hist['hist_seo_title'] ?? 'Our History | ClinicMaster Medical & Health Care Services';
  $seoDesc   = $hist['hist_seo_description'] ?? "From a humble clinic to the region's most trusted hospital — explore the milestones that shaped ClinicMaster.";
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

      <div class="page-header__social">
        <a href="#" class="page-header__social-link" aria-label="Facebook">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
        </a>
        <a href="#" class="page-header__social-link" aria-label="Twitter">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 0 1-1.9.1c.5 1.7 2.1 2.9 4 2.9A8.2 8.2 0 0 1 2 18.6a11.6 11.6 0 0 0 6.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z"/></svg>
        </a>
        <a href="#" class="page-header__social-link" aria-label="LinkedIn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>
        </a>
        <a href="#" class="page-header__social-link" aria-label="Instagram">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></svg>
        </a>
      </div>

      <div class="page-header__media">
        <img src="{{ $heroImage }}" alt="Team of ClinicMaster doctors" class="page-header__bg" />
        <span class="page-header__overlay"></span>
      </div>

      <div class="page-header__inner">
        <h1 class="page-header__title">{{ $heroTitle }}</h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('home') }}">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span>{{ $heroTitle }}</span>
        </nav>
      </div>

      <a href="tel:11234567890" class="page-header__call">
        <span class="page-header__call-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
          </svg>
        </span>
        <span class="page-header__call-text">1 123 456 7890</span>
      </a>
    </section>

    <!-- ===================== Our History Timeline ===================== -->
    @php
      $histFallbackImages = [asset('assets/img/slider-1.2.jpg'), asset('assets/img/sr-1-1.jpg'), asset('assets/img/sr-1-3.jpg'), asset('assets/img/projects-3.jpg'), asset('assets/img/slider-1.3.jpg')];
      $timeline = !empty($hist['hist_timeline']) ? $hist['hist_timeline'] : [
        ['year' => '2013', 'tag' => 'Foundation',   'heading' => 'Grand Opening — ClinicMaster Is Born',           'content' => 'With a vision to redefine community healthcare, ClinicMaster opened its doors on 36D Street, Brooklyn in 2013 with a small team of dedicated physicians.', 'badges' => ['30 Beds Launched', '24/7 Emergency', 'Outpatient Care'], 'image' => null, 'reversed' => false],
        ['year' => '2016', 'tag' => 'Diagnostics',  'heading' => 'Advanced Diagnostic & Imaging Center',            'content' => 'In 2016, ClinicMaster unveiled a full diagnostic wing — bringing MRI, CT scanning and a modern pathology laboratory together under one roof.', 'badges' => ['MRI & CT Scan', 'Digital X-Ray', 'Pathology Lab'], 'image' => null, 'reversed' => true],
        ['year' => '2019', 'tag' => 'Critical Care','heading' => 'Dedicated ICU & Cardiac Wing',                    'content' => 'A 20-bed intensive care unit and a specialised cardiac wing opened in 2019, giving the community round-the-clock access to life-saving critical care.', 'badges' => ['20-Bed ICU', 'Cardiology Dept', '24/7 CCU'], 'image' => null, 'reversed' => false],
        ['year' => '2022', 'tag' => 'Innovation',   'heading' => 'Telemedicine & Digital Care Launch',              'content' => "ClinicMaster went digital in 2022 — online appointment booking, video consultations and e-prescriptions brought expert care into patients' homes.", 'badges' => ['Video Consultations', 'Online Booking', 'E-Prescriptions'], 'image' => null, 'reversed' => true],
        ['year' => '2025', 'tag' => 'Recognition',  'heading' => 'Award-Winning Patient Care',                      'content' => 'Today ClinicMaster stands nationally accredited — a 150-bed hospital trusted by thousands of families and honoured for excellence in patient care.', 'badges' => ['150+ Beds', '75+ Specialists', 'National Accreditation'], 'image' => null, 'reversed' => false],
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
          {{ $hist['hist_desc'] ?? "From a humble clinic to the region's most trusted hospital — explore the milestones that shaped ClinicMaster into the award-winning healthcare destination it is today." }}
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
