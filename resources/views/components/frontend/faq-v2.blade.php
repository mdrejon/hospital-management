@props([
    'homeFaq' => [],
    'faqData' => [],
    'faqPage' => [],
])

@php
$faqInfo = !empty($homeFaq) ? $homeFaq : ($faqData ?: []);
$faqBadge = ($faqPage['faq_page_badge'] ?? null) ?: ($faqInfo['badge'] ?? null);
$faqTitle = ($faqPage['faq_page_title'] ?? null) ?: ($faqInfo['title'] ?? null);
$faqImage = !empty($faqInfo['image']) ? $faqInfo['image'] : asset('assets/img/faq.webp');
$faqImageAlt = $faqInfo['image_alt'] ?: 'Doctor assisting patient over phone';

$defaultFaqs = [
    [
        'question' => 'What are your opening hours?',
        'answer'   => 'Our diagnostic center is open every day from 8:00 AM to 8:00 PM.',
    ],
    [
        'question' => 'How can I book a serial for a doctor?',
        'answer'   => 'You can easily book online through our Appointment page by selecting your department and doctor, or by calling our hotline directly.',
    ],
    [
        'question' => 'What diagnostic tests are available?',
        'answer'   => 'We offer digital X-Ray, 4D Ultrasonography, computerized pathology, ECG, Echocardiography, endoscopy, and complete health checkup packages.',
    ],
    [
        'question' => 'Do you provide home services?',
        'answer'   => 'Yes, our certified phlebotomists provide safe and convenient home sample collection services for blood and diagnostic tests.',
    ],
];

$faqCards = (!empty($faqInfo['items']) && $faqInfo['items']->isNotEmpty()) ? $faqInfo['items'] : collect($defaultFaqs);
@endphp

<section class="faq-v2 py-20 lg:py-28 bg-white relative overflow-hidden" data-faq-v2>
  <!-- Subtle circular lines background decoration (bottom left) -->
  <svg class="absolute -bottom-20 -left-20 w-[400px] h-[400px] text-brand-cyan/5 pointer-events-none" viewBox="0 0 100 100" fill="none">
    <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="1.5" />
    <circle cx="50" cy="50" r="30" stroke="currentColor" stroke-width="1.5" />
    <circle cx="50" cy="50" r="20" stroke="currentColor" stroke-width="1.5" />
  </svg>

  <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl 2xl:max-w-7xl 2k:max-w-[1720px] 4k:max-w-[2160px] relative z-10">
    <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">

      <!-- Left: Image -->
      <div class="lg:w-[45%] w-full shrink-0 flex justify-center lg:justify-start">
        <div class="relative w-full max-w-lg lg:max-w-none">
          <img 
            src="{{ $faqImage }}" 
            alt="{{ $faqImageAlt }}" 
            class="w-full h-auto rounded-[26px] shadow-[0_15px_35px_rgba(0,0,0,0.08)] object-cover" 
          />
        </div>
      </div>

      <!-- Right: Accordion with Red Theme & Numbered Pills -->
      <div class="lg:w-[55%] w-full flex flex-col gap-4 sm:gap-5">
        @if(!empty($faqBadge) || !empty($faqTitle))
        <div class="mb-2">
          @if(!empty($faqBadge))
          <p class="text-brand-cyan font-bold tracking-widest uppercase text-sm mb-2">
            {{ $faqBadge }}
          </p>
          @endif
          @if(!empty($faqTitle))
          <h2 class="text-3xl sm:text-4xl font-extrabold text-navy leading-[1.25] tracking-tight">
            {{ $faqTitle }}
          </h2>
          @endif
        </div>
        @endif

        @foreach($faqCards as $faqIndex => $faqCard)
        <div class="faq-item group {{ $loop->first ? 'is-open' : '' }} bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-[0_4px_16px_rgba(0,0,0,0.02)] transition-all duration-300 [&.is-open]:border-[#c61d35]/20 [&.is-open]:shadow-[0_8px_25px_rgba(198,29,53,0.08)]">

          <button 
            type="button" 
            class="faq-item__question flex w-full items-center justify-between px-6 py-5 transition-colors duration-300 group-[.is-open]:bg-[#c61d35]" 
            data-faq-toggle
          >
            <div class="flex items-center gap-4">
              <!-- Unopened Icon: Number (Red Pill) -->
              <span class="flex items-center justify-center w-8 h-8 shrink-0 rounded-full bg-[#c61d35] text-white text-xs sm:text-[13px] font-bold group-[.is-open]:hidden shadow-sm">
                {{ str_pad($faqIndex + 1, 2, '0', STR_PAD_LEFT) }}
              </span>
              <!-- Opened Icon: Checkmark (White Pill with Red Icon) -->
              <span class="items-center justify-center w-8 h-8 shrink-0 rounded-full bg-white text-[#c61d35] hidden group-[.is-open]:flex shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
              </span>

              <!-- Title -->
              <span class="text-base sm:text-[17px] font-bold text-navy group-[.is-open]:text-white text-left leading-snug transition-colors">
                {{ $faqCard['question'] ?? '' }}
              </span>
            </div>

            <!-- Chevron Icon -->
            <span class="flex w-6 h-6 items-center justify-center shrink-0 text-[#c61d35] group-[.is-open]:text-white transition-transform duration-300 group-[.is-open]:rotate-180">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 9l-7 7-7-7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
          </button>

          <!-- Answer Wrapper -->
          <div class="faq-item__answer px-0 pb-0 bg-white">
            <div class="overflow-hidden">
              <div class="px-6 pb-6 pt-4 text-gray-500 text-sm sm:text-[15px] leading-relaxed border-t border-gray-100">
                <p>{{ $faqCard['answer'] ?? '' }}</p>
              </div>
            </div>
          </div>

        </div>
        @endforeach
      </div>

    </div>
  </div>
</section>
