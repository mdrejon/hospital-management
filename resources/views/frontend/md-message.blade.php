@extends('layouts.frontend')

@php
$ceoImage = !empty($about['ceo_image']) ? asset('storage/' . $about['ceo_image']) : asset('assets/img/about-image.webp');
$ceoBadgeValue = !empty(trim($about['ceo_badge_value'] ?? '')) ? $about['ceo_badge_value'] : null;
$ceoBadgeLabel = !empty(trim($about['ceo_badge_label'] ?? '')) ? $about['ceo_badge_label'] : null;
$ceoEyebrow = !empty(trim($about['ceo_eyebrow'] ?? '')) ? $about['ceo_eyebrow'] : null;
$ceoTitle = !empty(trim($about['ceo_title'] ?? '')) ? $about['ceo_title'] : null;
$ceoMessage = !empty(trim($about['ceo_message'] ?? '')) ? $about['ceo_message'] : null;
$ceoFocusLabel = !empty(trim($about['ceo_focus_label'] ?? '')) ? $about['ceo_focus_label'] : null;
$ceoFocusItems = !empty($about['ceo_focus_items']) ? array_filter($about['ceo_focus_items'], fn($item) => !empty(trim((string)$item))) : [];
$ceoAwards = !empty($about['ceo_awards']) ? array_filter($about['ceo_awards'], function($award) {
    return !empty(trim($award['year'] ?? '')) || !empty(trim($award['org'] ?? '')) || !empty(trim($award['label'] ?? ''));
}) : [];
$seoTitle = $about['about_seo_title'] ?? (($ceoTitle ? $ceoTitle . ' | ' : '') . 'Message From MD/CEO | ' . config('app.name'));
$seoDesc = $ceoMessage ? \Illuminate\Support\Str::limit(str_replace(["\n", "\r"], ' ', $ceoMessage), 160) : '';
@endphp

@section('title', $seoTitle)
@if($seoDesc)
@section('meta_description', $seoDesc)
@section('og_description', $seoDesc)
@endif
@section('og_title', $seoTitle)

@section('content')

<!-- ===================== Breadcrumb / Page header ===================== -->
<section class="page-header">
  <div class="page-header__media">
    <img src="{{ asset('assets/img/breadcumb.webp') }}" alt="Team of Medicare Lab Ltd. doctors" class="page-header__bg" />
    <span class="page-header__overlay"></span>
  </div>

  <span class="page-header__badge">24/7 Emergency Service</span>

  <x-frontend.page-header-social />

  <div class="page-header__inner">
    <h1 class="page-header__title">Message From MD/CEO</h1>
    <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">{{ __('frontend.nav.home') }}</a>
      <span class="page-header__breadcrumb-sep">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span>
      <span>{{ __('frontend.breadcrumb.md_message') }}</span>
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

<!-- ===================== Message From MD/CEO ===================== -->
<section class="ceo-message">
  <div class="container mx-auto">
    <div class="ceo-message__grid">
      <div class="ceo-message__media">
        <img src="{{ $ceoImage }}" alt="{{ $ceoTitle ?? 'CEO' }}" class="ceo-message__img" />
        @if(!empty($ceoBadgeValue))
        <div class="ceo-message__badge">
          <span class="ceo-message__badge-value">{{ $ceoBadgeValue }}</span>
          @if(!empty($ceoBadgeLabel))
          <span class="ceo-message__badge-label">{!! nl2br(e($ceoBadgeLabel)) !!}</span>
          @endif
        </div>
        @endif
      </div>

      <div>
        @if(!empty($ceoEyebrow))
        <p class="ceo-message__eyebrow">
          <span class="ceo-message__eyebrow-dot"></span>
          {{ $ceoEyebrow }}
          <span class="ceo-message__eyebrow-dot"></span>
        </p>
        @endif

        @if(!empty($ceoTitle))
        <h2 class="ceo-message__title">{{ $ceoTitle }}</h2>
        @endif

        @if(!empty($ceoMessage))
          @foreach(preg_split('/\n{2,}/', $ceoMessage) as $paragraph)
          <p class="ceo-message__desc">
            {{ trim($paragraph) }}
          </p>
          @endforeach
        @endif

        @if(!empty($ceoFocusItems))
          @if(!empty($ceoFocusLabel))
          <p class="ceo-message__focus-label">{{ $ceoFocusLabel }}</p>
          @endif
          <div class="ceo-message__checklist">
            @foreach($ceoFocusItems as $item)
            <span class="ceo-message__check">
              <span class="ceo-message__check-icon">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
              {{ $item }}
            </span>
            @endforeach
          </div>
        @endif

        @if(!empty($ceoAwards))
        <div class="ceo-message__awards">
          @foreach($ceoAwards as $award)
          <div class="ceo-message__award">
            <span class="ceo-message__award-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2l2.5 5 5.5.6-4 3.9 1 5.5L12 14.8 7 17l1-5.5-4-3.9L9.5 7 12 2z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round" />
              </svg>
            </span>
            <div>
              @if(!empty(trim($award['year'] ?? '')))
              <p class="ceo-message__award-year">{{ $award['year'] }}</p>
              @endif
              @if(!empty(trim($award['org'] ?? '')))
              <p class="ceo-message__award-org">{{ $award['org'] }}</p>
              @endif
              @if(!empty(trim($award['label'] ?? '')))
              <a href="{{ route('achievements') }}" class="ceo-message__award-link">{{ $award['label'] }}</a>
              @endif
            </div>
          </div>
          @endforeach
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection