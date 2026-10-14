@props(['packageCards', 'pkg' => []])

{{--
  Packages V2 — Modern hospital design
  Full-bleed image grid/slider, each card shows a branded info box
  anchored to the bottom-left corner (always visible), with a "+"
  link button top-right on hover. Matches the screenshot reference.
--}}

<section class="pkg-v2 py-section relative overflow-hidden" style="background: linear-gradient(160deg, #eaf6ff 0%, #f0f9ff 45%, #e8f4fd 100%);">
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

  <!-- Full-bleed Slider -->
  <div class="packages__slider relative" data-packages-slider>
    <div class="packages__viewport overflow-hidden">
      <div class="packages__track flex" data-packages-track>
        @foreach($packageCards as $index => $card)
        <div class="packages__slide shrink-0 w-full sm:w-1/2 lg:w-1/3 2xl:w-1/4">
          <div class="pkg-v2__card group relative overflow-hidden" style="height: 380px;">

            <!-- Background image with zoom -->
            <img
              src="{{ $card['image'] }}"
              alt="{{ $card['title'] }}"
              class="pkg-v2__img absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105" />

            <!-- Subtle gradient so info box stands out -->
            <div class="absolute inset-0 bg-gradient-to-t from-navy/60 via-navy/10 to-transparent pointer-events-none"></div>

            <!-- "+" Quick-link button — top right, appears on hover -->
            <a
              href="{{ $card['url'] }}"
              class="pkg-v2__plus absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-brand-cyan text-white flex items-center justify-center opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300 shadow-lg hover:bg-white hover:text-brand-cyan"
              aria-label="View {{ $card['title'] }}"
              tabindex="-1">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
              </svg>
            </a>

            <!-- Info card anchored bottom-left -->
            <div class="pkg-v2__info absolute bottom-5 left-5 right-5 z-10">
              <div class="pkg-v2__info-box bg-brand-primary/90 backdrop-blur-sm rounded-lg px-5 py-4 transition-all duration-300 group-hover:bg-brand-cyan shadow-xl">
                <h3 class="pkg-v2__title text-white font-bold text-h6 mb-1.5">
                  {{ $card['title'] }}
                </h3>
                @if(!empty($card['desc']))
                <p class="pkg-v2__desc text-white/85 text-caption leading-relaxed line-clamp-2">
                  {{ $card['desc'] }}
                </p>
                @endif
                <a
                  href="{{ $card['url'] }}"
                  class="pkg-v2__link inline-flex items-center gap-1.5 mt-3 text-white/90 text-btn-sm font-semibold hover:text-white transition-colors duration-200 uppercase tracking-wide">
                  Read More
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                  </svg>
                </a>
              </div>
            </div>

          </div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Prev / Next arrows -->
    <button
      type="button"
      class="packages__nav is-prev absolute top-1/2 left-3 lg:left-5 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white/90 text-navy shadow-md flex items-center justify-center hover:bg-brand-cyan hover:text-white transition-all duration-200"
      data-packages-prev
      aria-label="Previous packages">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <button
      type="button"
      class="packages__nav is-next absolute top-1/2 right-3 lg:right-5 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white/90 text-navy shadow-md flex items-center justify-center hover:bg-brand-cyan hover:text-white transition-all duration-200"
      data-packages-next
      aria-label="Next packages">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
      </svg>
    </button>
  </div>

  <!-- Dots -->
  <div class="packages__dots mt-8 mb-16 flex justify-center gap-2" data-packages-dots></div>
</section>

<style>
  /* V2-specific tweaks that are easiest to keep co-located */
  .pkg-v2__card {
    cursor: default;
  }

  .pkg-v2__info-box {
    will-change: transform;
  }

  .packages__dots {
    display: none;
  }

  .packages__dot {
    width: 8px;
    height: 8px;
    border-radius: 9999px;
    background-color: rgb(var(--color-primary) / 0.25);
    border: none;
    cursor: pointer;
    transition: background-color 0.2s, transform 0.2s;
  }

  .packages__dot.is-active {
    background-color: rgb(var(--color-primary));
    transform: scale(1.35);
  }
</style>