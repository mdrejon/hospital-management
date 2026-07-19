@extends('layouts.frontend')

@php
  $heroTitle   = $about['about_hero_title'] ?? 'About Us';
  $heroImage   = !empty($about['about_hero_image']) ? asset('storage/' . $about['about_hero_image']) : asset('assets/img/breadcumb.webp');
  $seoTitle    = $about['about_seo_title'] ?? 'About Us | ClinicMaster Medical & Health Care Services';
  $seoDesc     = $about['about_seo_description'] ?? "Learn about ClinicMaster's mission, values, and leadership.";
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
        <img src="{{ $heroImage }}" alt="Team of ClinicMaster doctors" class="page-header__bg" />
        <span class="page-header__overlay"></span>
      </div>

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

      <div class="page-header__inner">
        <h1 class="page-header__title">{{ $heroTitle }}</h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('home') }}">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span>About Us</span>
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

    <!-- ===================== About Us ===================== -->
    @php
      $aboutPhoto      = !empty($about['about_photo']) ? asset('storage/' . $about['about_photo']) : asset('assets/img/about-image.webp');
      $aboutHoursTitle = $about['about_hours_title'] ?? 'Open Hours';
      $aboutHours      = !empty($about['about_hours']) ? $about['about_hours'] : [
        ['day' => 'Monday',    'time' => '09:30 - 07:30'],
        ['day' => 'Tuesday',   'time' => '09:30 - 07:30'],
        ['day' => 'Wednesday', 'time' => '09:30 - 07:30'],
        ['day' => 'Thursday',  'time' => '09:30 - 07:30'],
        ['day' => 'Friday',    'time' => '09:30 - 07:30'],
        ['day' => 'Saturday',  'time' => '09:30 - 07:30'],
      ];
      $aboutTitle    = $about['about_title'] ?? 'World Class Patient Facilities Designed For You';
      $aboutDesc     = $about['about_desc'] ?? "Experience the future of healthcare. Our state-of-the-art facilities are equipped with the latest technology, ensuring you receive the world's best quality treatment. Here, cutting-edge tools meet unparalleled expertise, providing a comfortable and effective path to optimal health.";
      $aboutFeatures = !empty($about['about_features']) ? $about['about_features'] : [
        'Comprehensive Specialties', 'Emergency Services', 'Intensive Care Units (ICUs)', 'Telemedicine Facilities', 'Multidisciplinary Team',
        'Research and Development', 'Advanced Imaging Services', 'Rehabilitation Services', 'Patient-Centric Approach', 'Health Information Technology',
      ];
      $aboutFeatureCols = collect($aboutFeatures)->chunk((int) ceil(count($aboutFeatures) / 2));
      $aboutBtnText  = $about['about_more_btn_text'] ?? 'Appointment';
      $aboutBtnUrl   = ($about['about_more_btn_url'] ?? null) ?: route('appointment');
      $aboutPhone    = $headerSettings['header_phone'] ?? '1 123 456 7890';
    @endphp
    <section class="about">
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
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
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
                      <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
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
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>

              <a href="tel:{{ $aboutPhone }}" class="about__contact">
                <span class="about__contact-icon">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
                  </svg>
                </span>
                <span class="about__contact-text">
                  <span class="about__contact-label">Contact us?</span>
                  <span class="about__contact-value">{{ $aboutPhone }}</span>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== Mission & Vision ===================== -->
    @php
      $mvTitle = $about['about_mv_title'] ?? 'Inspirational Health Our Vision And Mission';
      $mvDesc  = $about['about_mv_desc'] ?? 'To enhance the health and well-being of our community by providing compassionate, high-quality healthcare services through dedicated professionals and advanced medical practices.';
      $mvImage = !empty($about['about_mv_image']) ? asset('storage/' . $about['about_mv_image']) : asset('assets/img/sr-1-2.jpg');
      $mvIcons = [
        '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="1" fill="currentColor"/></svg>',
        '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>',
        '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 3h12l4 6-10 12L2 9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M2 9h20M9 3l-3 6 6 12 6-12-3-6" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/></svg>',
      ];
      $mvCards = !empty($about['about_mv_cards']) ? $about['about_mv_cards'] : [
        ['title' => 'Mission', 'description' => 'Delivering compassionate, patient-centred care through skilled professionals and dependable, modern medical practices for every member of our community.'],
        ['title' => 'Vision',  'description' => "To be the region's most trusted healthcare partner, recognised for clinical excellence, innovation, and genuine care for every patient we serve."],
        ['title' => 'Values',  'description' => 'Integrity, compassion, and accountability guide every decision we make, from the bedside to the boardroom.'],
      ];
    @endphp
    <section class="mission-vision">
      <div class="container mx-auto">
        <div class="mission-vision__grid">
          <div>
            <h2 class="mission-vision__title">{{ $mvTitle }}</h2>
            <p class="mission-vision__desc">
              {{ $mvDesc }}
            </p>

            <div class="mission-vision__list">
              @foreach($mvCards as $i => $card)
              <div class="mission-vision__card">
                <span class="mission-vision__icon">
                  {!! $mvIcons[$i] ?? $mvIcons[0] !!}
                </span>
                <div>
                  <h3 class="mission-vision__card-title">{{ $card['title'] }}</h3>
                  <p class="mission-vision__card-desc">
                    {{ $card['description'] }}
                  </p>
                </div>
              </div>
              @endforeach
            </div>
          </div>

          <div class="mission-vision__media">
            <img src="{{ $mvImage }}" alt="Doctor speaking with a patient" class="mission-vision__img" />
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== Our CEO Message ===================== -->
    @php
      $ceoImage      = !empty($about['ceo_image']) ? asset('storage/' . $about['ceo_image']) : asset('assets/img/about-image.webp');
      $ceoBadgeValue = $about['ceo_badge_value'] ?? '16+';
      $ceoBadgeLabel = $about['ceo_badge_label'] ?? 'Years Experienced';
      $ceoEyebrow    = $about['ceo_eyebrow'] ?? 'Our CEO Message';
      $ceoTitle      = $about['ceo_title'] ?? 'Meet Dr. Natali Jackson';
      $ceoMessage    = $about['ceo_message'] ?? "As CEO of ClinicMaster, I'm committed to building a hospital where compassionate care meets clinical excellence. Every decision we make, from staffing to technology, starts with what's best for the patients and families who trust us with their health.";
      $ceoFocusLabel = $about['ceo_focus_label'] ?? 'Leadership Focus';
      $ceoFocusItems = !empty($about['ceo_focus_items']) ? $about['ceo_focus_items'] : [
        'Patient-Centered Care', 'Clinical Innovation', 'Operational Excellence', 'Community Outreach', 'Quality Assurance', 'Strategic Growth',
      ];
      $ceoAwards = !empty($about['ceo_awards']) ? $about['ceo_awards'] : [
        ['year' => 'ClinicMaster 2024', 'org' => 'Quality and Accreditation Institute', 'label' => 'Healthcare Leadership Award'],
        ['year' => 'ClinicMaster 2023', 'org' => 'National Hospital Federation',        'label' => 'Excellence in Patient Care'],
      ];
    @endphp
    <section class="ceo-message">
      <div class="container mx-auto">
        <div class="ceo-message__grid">
          <div class="ceo-message__media">
            <img src="{{ $ceoImage }}" alt="{{ $ceoTitle }}" class="ceo-message__img" />
            <div class="ceo-message__badge">
              <span class="ceo-message__badge-value">{{ $ceoBadgeValue }}</span>
              <span class="ceo-message__badge-label">{!! nl2br(e($ceoBadgeLabel)) !!}</span>
            </div>
          </div>

          <div>
            <p class="ceo-message__eyebrow">
              <span class="ceo-message__eyebrow-dot"></span>
              {{ $ceoEyebrow }}
              <span class="ceo-message__eyebrow-dot"></span>
            </p>
            <h2 class="ceo-message__title">{{ $ceoTitle }}</h2>
            <p class="ceo-message__desc">
              {{ $ceoMessage }}
            </p>

            <p class="ceo-message__focus-label">{{ $ceoFocusLabel }}</p>
            <div class="ceo-message__checklist">
              @foreach($ceoFocusItems as $item)
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                {{ $item }}
              </span>
              @endforeach
            </div>

            <div class="ceo-message__awards">
              @foreach($ceoAwards as $award)
              <div class="ceo-message__award">
                <span class="ceo-message__award-icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2l2.5 5 5.5.6-4 3.9 1 5.5L12 14.8 7 17l1-5.5-4-3.9L9.5 7 12 2z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                  </svg>
                </span>
                <div>
                  <p class="ceo-message__award-year">{{ $award['year'] }}</p>
                  <p class="ceo-message__award-org">{{ $award['org'] }}</p>
                  <a href="{{ route('achievements') }}" class="ceo-message__award-link">{{ $award['label'] }}</a>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== FAQ ===================== -->
    @php
      $aboutFaqDefaults = [
        ['question' => 'What insurance plans do you accept?', 'answer' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its. The point of using Lorem Ipsum is that it has a more-or-less normal distribution'],
        ['question' => 'Do I need a referral to see a specialist?', 'answer' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its. The point of using Lorem Ipsum is that it has a more-or-less normal distribution'],
        ['question' => 'What should I bring to my first visit?', 'answer' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its. The point of using Lorem Ipsum is that it has a more-or-less normal distribution'],
        ['question' => 'How can I access my medical records?', 'answer' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its. The point of using Lorem Ipsum is that it has a more-or-less normal distribution'],
      ];
      $aboutFaqCards = (isset($aboutFaqs) && $aboutFaqs->isNotEmpty()) ? $aboutFaqs : collect($aboutFaqDefaults);
    @endphp
    <section class="faq">
      <img src="{{ asset('assets/img/faq-bg.png') }}" alt="" class="faq__bg" aria-hidden="true" />

      <div class="container relative mx-auto">
        <div class="faq__grid">
          <div class="faq__copy">
            <h2 class="faq__title">Frequently Asked Questions</h2>
            <p class="faq__desc">
              Answers to the questions our patients ask us most about visiting ClinicMaster.
            </p>

            <div class="faq__list">
              @foreach($aboutFaqCards as $faqIndex => $faqCard)
                <div class="faq-item @if($faqIndex === 0) is-open @endif">
                  <button type="button" class="faq-item__question" data-faq-toggle>
                    {{ $faqCard['question'] ?? '' }}
                    <span class="faq-item__icon">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                  </button>
                  <div class="faq-item__answer">
                    <p>{{ $faqCard['answer'] ?? '' }}</p>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="faq__media">
            <img src="{{ asset('assets/img/faq.webp') }}" alt="Smiling doctor on a call, ready to answer your questions" class="faq__photo" />

            <div class="faq__contact-card">
              <div class="faq__contact-info">
                <span class="faq__contact-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
                  </svg>
                </span>
                <div>
                  <p class="faq__contact-label">Contact us?</p>
                  <p class="faq__contact-value">{{ $aboutPhone }}</p>
                </div>
              </div>

              <a href="{{ route('appointment') }}" class="faq__contact-btn">
                Appointment
                <span class="faq__contact-btn-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
