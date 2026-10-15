@extends('layouts.frontend')

@php
$heroTitle = $about['about_hero_title'] ?? 'About Us';
$heroImage = !empty($about['about_hero_image']) ? asset('storage/' . $about['about_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $about['about_seo_title'] ?? ('About Us | ' . config('app.name'));
$seoDesc = $about['about_seo_description'] ?? "Learn about Medicare Lab Ltd.'s mission, values, and leadership.";
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDesc)
@section('og_title', $seoTitle)
@section('og_description', $seoDesc)
@if(!empty($about['about_seo_keywords']))
@section('meta_keywords', $about['about_seo_keywords'])
@endif
@if(!empty($about['about_seo_og_image']))
@section('og_image', asset('storage/' . $about['about_seo_og_image']))
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
      <span>{{ __('frontend.breadcrumb.about_us') }}</span>
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

<!-- ===================== About Us ===================== -->
@php
$aboutPhoto = !empty($about['about_photo']) ? asset('storage/' . $about['about_photo']) : asset('assets/img/about-image.webp');
$aboutHoursTitle = !empty(trim($about['about_hours_title'] ?? '')) ? $about['about_hours_title'] : null;
$aboutHours = !empty($about['about_hours']) ? $about['about_hours'] : [];
$aboutTitle = !empty(trim($about['about_title'] ?? '')) ? $about['about_title'] : null;
$aboutDesc = !empty(trim($about['about_desc'] ?? '')) ? $about['about_desc'] : null;
// About-page-only rich description: replaces the shared plain desc here (never on Home)
// when the admin actually typed something — an empty TipTap doc still saves "<p></p>".
$aboutRichDesc = trim(strip_tags($about['about_page_desc'] ?? '')) !== '' ? $about['about_page_desc'] : null;
$aboutFeatures = !empty($about['about_features']) ? $about['about_features'] : [];
$aboutFeatureCols = !empty($aboutFeatures) ? collect($aboutFeatures)->chunk((int) ceil(count($aboutFeatures) / 2)) : collect([]);
$aboutPhone = !empty(trim($headerSettings['header_phone'] ?? '')) ? $headerSettings['header_phone'] : null;
@endphp
<section class="about bg-blue-50/40 relative overflow-hidden">
  <!-- Animated Floating Medical Cross -->
  <div class="absolute top-10 right-10 opacity-30 animate-pulse text-brand-cyan pointer-events-none z-0">
    <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
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
          <img src="{{ $aboutPhoto }}" alt="{{ $aboutTitle ?? 'About Us' }}" class="about__photo" />

          @if(!empty($aboutHours))
          <div class="about__hours-card">
            <span class="about__hours-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6" />
                <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
              </svg>
            </span>
            @if(!empty($aboutHoursTitle))
            <h3 class="about__hours-title">{{ $aboutHoursTitle }}</h3>
            @endif
            <div class="about__hours-list">
              @foreach($aboutHours as $row)
              <div class="about__hours-row">
                <span class="about__hours-day">{{ $row['day'] }}</span>
                <span class="about__hours-time">{{ $row['time'] }}</span>
              </div>
              @endforeach
            </div>
          </div>
          @endif
        </div>
      </div>

      <div class="about__content">
        @if(!empty($aboutTitle))
        <h2 class="about__title">{{ $aboutTitle }}</h2>
        @endif
        @if($aboutRichDesc)
        <div class="about__desc about__desc--rich">{!! $aboutRichDesc !!}</div>
        @elseif(!empty($aboutDesc))
        <p class="about__desc">
          {{ $aboutDesc }}
        </p>
        @endif

        @if(!empty($aboutFeatures))
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
        @endif

        {{-- CTA button intentionally omitted here — it only shows on the Home page's About section. --}}
        @if(!empty($aboutPhone))
        <div class="about__cta-row">
          <a href="tel:{{ preg_replace('/[^0-9+]/', '', $aboutPhone) }}" class="about__contact">
            <span class="about__contact-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6" />
              </svg>
            </span>
            <span class="about__contact-text">
              <span class="about__contact-label">Contact us?</span>
              <span class="about__contact-value">{{ $aboutPhone }}</span>
            </span>
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>

<!-- ===================== Mission & Vision ===================== -->
@php
$mvTitle = !empty(trim($about['about_mv_title'] ?? '')) ? $about['about_mv_title'] : null;
$mvDesc = !empty(trim($about['about_mv_desc'] ?? '')) ? $about['about_mv_desc'] : null;
$mvImage = !empty($about['about_mv_image']) ? asset('storage/' . $about['about_mv_image']) : null;
$mvIcons = [
'<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.6" />
  <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.6" />
  <circle cx="12" cy="12" r="1" fill="currentColor" />
</svg>',
'<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
  <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6" />
</svg>',
'<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M6 3h12l4 6-10 12L2 9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
  <path d="M2 9h20M9 3l-3 6 6 12 6-12-3-6" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round" />
</svg>',
];
$mvCards = !empty($about['about_mv_cards']) ? $about['about_mv_cards'] : [];
@endphp
@if(!empty($mvTitle) || !empty($mvDesc) || !empty($mvCards) || !empty($mvImage))
<section class="mission-vision">
  <div class="container mx-auto">
    <div class="mission-vision__grid">
      <div>
        @if(!empty($mvTitle))
        <h2 class="mission-vision__title">{{ $mvTitle }}</h2>
        @endif
        @if(!empty($mvDesc))
        <p class="mission-vision__desc">
          {{ $mvDesc }}
        </p>
        @endif

        @if(!empty($mvCards))
        <div class="mission-vision__list">
          @foreach($mvCards as $i => $card)
          <div class="mission-vision__card">
            <span class="mission-vision__icon">
              {!! $mvIcons[$i] ?? $mvIcons[0] !!}
            </span>
            <div>
              @if(!empty(trim($card['title'] ?? '')))
              <h3 class="mission-vision__card-title">{{ $card['title'] }}</h3>
              @endif
              @if(!empty(trim($card['description'] ?? '')))
              <p class="mission-vision__card-desc">
                {{ $card['description'] }}
              </p>
              @endif
            </div>
          </div>
          @endforeach
        </div>
        @endif
      </div>

      @if(!empty($mvImage))
      <div class="mission-vision__media">
        <img src="{{ $mvImage }}" alt="{{ $mvTitle ?? 'Mission and Vision' }}" class="mission-vision__img" />
      </div>
      @endif
    </div>
  </div>
</section>
@endif

<!-- ===================== Our CEO Message ===================== -->
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
@endphp
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
        <p class="ceo-message__desc">
          {{ $ceoMessage }}
        </p>
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

<!-- ===================== FAQ ===================== -->
@php
$aboutFaqTitle = !empty(trim($aboutFaq['title'] ?? '')) ? $aboutFaq['title'] : 'Frequently Asked Questions';
$aboutFaqDesc = !empty(trim($aboutFaq['description'] ?? '')) ? $aboutFaq['description'] : null;
$aboutFaqPhoto = !empty($aboutFaq['image']) ? $aboutFaq['image'] : asset('assets/img/faq.webp');
$aboutFaqPhotoAlt = !empty($aboutFaq['image_alt']) ? $aboutFaq['image_alt'] : $aboutFaqTitle;
$aboutFaqCards = (!empty($aboutFaq['items']) && $aboutFaq['items']->isNotEmpty()) ? $aboutFaq['items'] : collect([]);
@endphp
<section class="faq">
  <img src="{{ asset('assets/img/faq-bg.png') }}" alt="" class="faq__bg" aria-hidden="true" />

  <div class="container relative mx-auto">
    <div class="faq__grid">
      <div class="faq__copy">
        <h2 class="faq__title">{{ $aboutFaqTitle }}</h2>
        @if(!empty($aboutFaqDesc))
        <p class="faq__desc">
          {{ $aboutFaqDesc }}
        </p>
        @endif

        @if($aboutFaqCards->isNotEmpty())
        <div class="faq__list">
          @foreach($aboutFaqCards as $faqIndex => $faqCard)
          <div class="faq-item @if($faqIndex === 0) is-open @endif">
            <button type="button" class="faq-item__question" data-faq-toggle>
              {{ $faqCard['question'] ?? '' }}
              <span class="faq-item__icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </button>
            <div class="faq-item__answer">
              <p>{{ $faqCard['answer'] ?? '' }}</p>
            </div>
          </div>
          @endforeach
        </div>
        @endif
      </div>

      <div class="faq__media">
        <img src="{{ $aboutFaqPhoto }}" alt="{{ $aboutFaqPhotoAlt }}" class="faq__photo" />

        @include('frontend.partials.faq-contact-card', ['phone' => $aboutPhone])
      </div>
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