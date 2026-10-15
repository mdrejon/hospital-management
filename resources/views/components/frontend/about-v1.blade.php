@props([
    'about' => [],
    'headerSettings' => [],
])

@php
$aboutPhoto = !empty($about['about_photo']) ? asset('storage/' . $about['about_photo']) : asset('assets/img/about-image.webp');
$aboutHoursTitle = !empty(trim($about['about_hours_title'] ?? '')) ? $about['about_hours_title'] : null;
$aboutHours = !empty($about['about_hours']) ? $about['about_hours'] : [];
$aboutTitle = !empty(trim($about['about_title'] ?? '')) ? $about['about_title'] : null;
$aboutDesc = !empty(trim($about['about_desc'] ?? '')) ? $about['about_desc'] : null;
$aboutFeatures = !empty($about['about_features']) ? $about['about_features'] : [];
$aboutFeatureCols = !empty($aboutFeatures) ? collect($aboutFeatures)->chunk((int) ceil(count($aboutFeatures) / 2)) : collect([]);
$aboutBtnText = !empty(trim($about['about_more_btn_text'] ?? '')) ? $about['about_more_btn_text'] : null;
$aboutBtnUrl = ($about['about_more_btn_url'] ?? null) ?: route('about');
$aboutPhone = !empty(trim($headerSettings['header_phone'] ?? '')) ? $headerSettings['header_phone'] : null;
@endphp

<section class="about bg-blue-50/40 relative overflow-hidden">
  <!-- Animated Floating Medical Cross -->
  <div class="absolute top-10 right-10 opacity-30 animate-pulse text-brand-cyan pointer-events-none z-0">
    <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
    </svg>
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
        @if(!empty($aboutDesc))
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

        @if(!empty($aboutBtnText) || !empty($aboutPhone))
        <div class="about__cta-row">
          @if(!empty($aboutBtnText))
          <a href="{{ $aboutBtnUrl }}" class="about__btn">
            {{ $aboutBtnText }}
            <span class="about__btn-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
          </a>
          @endif

          @if(!empty($aboutPhone))
          <a href="tel:{{ preg_replace('/[^0-9+]/', '', $aboutPhone) }}" class="about__contact">
            <span class="about__contact-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6" />
              </svg>
            </span>
            <span class="about__contact-text">
              <span class="about__contact-label">{{ __('frontend.faq.contact_label') }}</span>
              <span class="about__contact-value">{{ $aboutPhone }}</span>
            </span>
          </a>
          @endif
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
