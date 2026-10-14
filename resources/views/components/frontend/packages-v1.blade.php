@props(['packageCards', 'pkg' => []])

<section class="packages py-section bg-cyan-50/40 relative overflow-hidden">
  <!-- Animated Floating Element -->
  <div class="absolute top-1/2 left-10 opacity-10 animate-pulse text-navy pointer-events-none z-0" style="animation-duration: 5s;">
    <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
    </svg>
  </div>

  <div class="container mx-auto px-4 lg:px-0">
    <!-- Centered Heading Area -->
    <div class="text-center mb-section-gap max-w-2xl 2k:max-w-3xl 4k:max-w-4xl mx-auto">
      @if(!empty($pkg['pkg_badge']))
      <p class="text-brand-cyan font-bold tracking-widest uppercase text-eyebrow mb-3">
        {{ $pkg['pkg_badge'] }}
      </p>
      @endif
      <h2 class="text-h2 font-bold text-navy mb-4">
        {{ $pkg['pkg_title'] ?? 'We Maintain Cleanliness Rules Inside Our Hospital' }}
      </h2>
      <div class="flex justify-center items-center gap-1.5 mb-4 text-brand-cyan">
        <span class="text-h5 font-bold tracking-tighter">--</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h3l2.5-4.5 3 9 2.5-4.5h4" />
        </svg>
        <span class="text-h5 font-bold tracking-tighter">--</span>
      </div>
    </div>

    <!-- Packages Slider -->
    <div class="packages__slider relative px-0" data-packages-slider>
      <div class="packages__viewport overflow-hidden">
        <div class="packages__track flex" data-packages-track>
          @foreach($packageCards as $card)
          <div class="packages__slide w-full sm:w-1/2 md:w-1/3 2xl:w-1/4 shrink-0">
            <div class="group relative overflow-hidden aspect-square lg:aspect-auto lg:h-[350px] w-full border-r-[2px] border-white">
              <!-- Background Image -->
              <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
              <!-- Hover Overlay -->
              <div class="absolute inset-0 bg-brand-cyan/85 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center backdrop-blur-[1px]">
                <h3 class="text-white font-bold text-h4 mb-4 translate-y-4 group-hover:translate-y-0 transition-transform duration-300 opacity-0 group-hover:opacity-100 text-center px-4">
                  {{ $card['title'] }}
                </h3>
                <a href="{{ $card['url'] }}" class="bg-white text-brand-cyan text-btn font-bold py-2.5 px-6 rounded transition-colors duration-300 hover:bg-navy hover:text-white shadow-lg shadow-black/10 translate-y-4 group-hover:translate-y-0 transform">
                  View Details
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <!-- Navigation Arrows -->
      <button type="button" class="packages__nav is-prev !absolute !top-1/2 !left-4 !-translate-y-1/2 !w-12 !h-12 !rounded-full !bg-white shadow-[0_4px_15px_rgba(0,0,0,0.1)] flex items-center justify-center text-navy hover:!bg-brand-cyan hover:!text-white transition z-10" data-packages-prev aria-label="Previous packages">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button type="button" class="packages__nav is-next !absolute !top-1/2 !right-4 !-translate-y-1/2 !w-12 !h-12 !rounded-full !bg-white shadow-[0_4px_15px_rgba(0,0,0,0.1)] flex items-center justify-center text-navy hover:!bg-brand-cyan hover:!text-white transition z-10" data-packages-next aria-label="Next packages">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>

    <!-- Dots -->
    <div class="packages__dots mt-10 flex justify-center gap-2" data-packages-dots></div>
  </div>
</section>

