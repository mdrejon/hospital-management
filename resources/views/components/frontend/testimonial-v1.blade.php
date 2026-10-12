@props([
    'testimonials' => collect(),
    'testi' => [],
])

@php
$testiImage = !empty($testi['testi_image']) ? asset('storage/' . $testi['testi_image']) : asset('assets/img/1752043437.img2.png');
$testiImageAlt = ($testi['testi_image_alt'] ?? null) ?: 'Doctor smiling with arms crossed';
$testiTitle = ($testi['testi_title'] ?? null) ?: __('frontend.home.testimonials_title');

$homeTestimonialDefaults = [
    ['name' => 'Emma Carter', 'role' => 'Patient', 'avatar' => asset('assets/img/sr-1-2.jpg'), 'title' => 'Best Treatment', 'review' => "From the first visit, I felt completely at ease. The staff was warm, patient, and incredibly supportive. They took time to listen and explain everything clearly. Their kindness made a real difference in my recovery. I'm thankful for such a caring team."],
    ['name' => 'Rihana Roy', 'role' => 'Patient', 'avatar' => asset('assets/img/sr-1-3.jpg'), 'title' => 'Caring Staff', 'review' => "My experience here was nothing short of amazing. The team treated me with kindness and genuine care. Every step of my treatment was handled with professionalism. I felt heard, supported, and completely at ease. I'm truly grateful for the care I received."],
    ['name' => 'Daniel Cruz', 'role' => 'Patient', 'avatar' => asset('assets/img/projects-2.jpg'), 'title' => 'Compassionate Care', 'review' => "The team walked me through every step before they even touched an instrument. What could have been stressful turned into the calmest checkup I've ever had. I finally look forward to my visits."],
];

$homeTestimonialCards = (isset($testimonials) && $testimonials->isNotEmpty())
    ? $testimonials->map(fn($t) => [
        'name' => $t->name,
        'role' => $t->role,
        'avatar' => $t->avatar ? asset('storage/' . $t->avatar) : asset('assets/img/sr-1-2.jpg'),
        'title' => null,
        'review' => $t->review,
    ])
    : collect($homeTestimonialDefaults);
@endphp

<section class="testimonials">
  <img src="{{ asset('assets/img/bg-testimonial.webp') }}" alt="" class="testimonials__bg" aria-hidden="true" />
  <span class="testimonials__overlay" aria-hidden="true"></span>

  <div class="container relative mx-auto">
    <div class="testimonials__grid">
      <div class="testimonials__media">
        <span class="testimonials__ring"></span>
        <span class="testimonials__ring is-inner"></span>
        <span class="testimonials__orbit" aria-hidden="true"><span class="testimonials__ping"></span></span>
        <span class="testimonials__orbit is-slow" aria-hidden="true"><span class="testimonials__ping"></span></span>
        <span class="testimonials__orbit is-reverse" aria-hidden="true"><span class="testimonials__ping"></span></span>
        <img
          src="{{ $testiImage }}"
          alt="{{ $testiImageAlt }}"
          class="testimonials__photo" />
      </div>

      <div class="testimonials__content">
        <h2 class="testimonials__title">{{ $testiTitle }}</h2>

        <div class="testimonial-slider" data-testimonials-slider>
          <button type="button" class="testimonials__nav is-prev" data-testimonials-prev aria-label="Previous testimonial">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 12H5M11 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
          <button type="button" class="testimonials__nav is-next" data-testimonials-next aria-label="Next testimonial">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>

          <div class="testimonial-slider__viewport">
            <div class="testimonial-slider__track" data-testimonials-track>
              @foreach($homeTestimonialCards as $tCard)
              <div class="testimonial-card">
                <div class="testimonial-card__media">
                  <div class="testimonial-card__photo-wrap">
                    <img src="{{ $tCard['avatar'] }}" alt="{{ $tCard['name'] }}" class="testimonial-card__photo" />
                    <button type="button" class="testimonial-card__play">
                      <span class="testimonial-card__play-icon">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M8 5v14l11-7z" />
                        </svg>
                      </span>
                      {{ __('frontend.home.watch_video') }}
                    </button>
                  </div>
                  <p class="testimonial-card__name">{{ $tCard['name'] }}</p>
                  <p class="testimonial-card__role">{{ $tCard['role'] }}</p>
                </div>

                <div class="testimonial-card__body">
                  @if(!empty($tCard['title']))
                  <h3 class="testimonial-card__title">{{ $tCard['title'] }}</h3>
                  @endif
                  <p class="testimonial-card__quote">
                    {{ $tCard['review'] }}
                  </p>

                  <span class="testimonial-card__mark" aria-hidden="true">
                    <span class="testimonial-card__mark-ring"></span>
                    <span class="testimonial-card__mark-ring is-offset"></span>
                  </span>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="testimonials__dots" data-testimonials-dots></div>
      </div>
    </div>
  </div>
</section>
