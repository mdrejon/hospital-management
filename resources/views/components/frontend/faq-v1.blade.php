@props([
'faqData' => [],
'homeFaq' => [],
'faqPage' => [],
'footerSettings' => [],
])

@php
$faqInfo = !empty($faqData) ? $faqData : ($homeFaq ?: []);
$faqBadge = ($faqPage['faq_page_badge'] ?? null) ?: ($faqInfo['badge'] ?? null);
$faqTitle = ($faqPage['faq_page_title'] ?? null) ?: ($faqInfo['title'] ?: 'Frequently Asked Questions');
$faqDesc = ($faqPage['faq_page_desc'] ?? null) ?: ($faqInfo['description'] ?? "Answers to the questions patients ask us most often. Can't find what you're looking for? Reach out and our team will be glad to help.");
$faqPhoto = !empty($faqPage['faq_page_image'])
? asset('storage/' . $faqPage['faq_page_image'])
: (!empty($faqInfo['image']) ? $faqInfo['image'] : asset('assets/img/about-image.webp'));
$faqPhotoAlt = $faqInfo['image_alt'] ?: 'Smiling doctor ready to answer your questions';

$defaultFaqs = [
['question' => 'What types of treatments do you offer?', 'answer' => 'Medicare Lab Ltd. offers a full range of services, from routine check-ups and diagnostics to specialist care in cardiology, pediatrics, dental, maternity, surgery, and emergency medicine. Visit our Services page for the complete list.'],
['question' => 'How do I book my appointment?', 'answer' => "You can book online through our Appointment page by choosing a department, preferred doctor, and time slot, or call us directly at 1 123 456 7890. You'll receive a confirmation once your visit is scheduled."],
['question' => 'Can I cancel or reschedule my appointment?', 'answer' => 'Yes. Appointments can be rescheduled or cancelled free of charge up to 24 hours in advance by calling our front desk or emailing support@hospital.com.'],
['question' => 'Do you accept health insurance?', 'answer' => 'We work with most major insurance providers. Bring your insurance card to your first visit, or contact our billing team beforehand to confirm your coverage and any out-of-pocket costs.'],
['question' => 'Is emergency care available 24/7?', 'answer' => 'Yes, our Emergency & Urgent Care department is staffed around the clock, every day of the year, with a dedicated ambulance and trauma team on standby.'],
['question' => 'Can I get a telemedicine consultation?', 'answer' => 'Absolutely. Many of our specialists offer video consultations for follow-ups and non-emergency concerns. Select "Telemedicine" when booking your appointment online.'],
];

$faqList = (!empty($faqInfo['items']) && $faqInfo['items']->isNotEmpty()) ? $faqInfo['items'] : collect($defaultFaqs);
$phone = $footerSettings['footer_phone_1'] ?? '1 123 456 7890';
@endphp

<section class="faq py-section bg-white relative overflow-hidden" data-faq-v1>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl 2xl:max-w-7xl 2k:max-w-[1720px] 4k:max-w-[2160px] relative z-10">
    <div class="faq__grid">
      <div class="faq__copy">
        @if(!empty($faqBadge))
        <p class="text-brand-cyan font-bold tracking-widest uppercase text-eyebrow mb-3">
          {{ $faqBadge }}
        </p>
        @endif
        <h2 class="faq__title text-h2 font-extrabold text-navy tracking-tight">
          {{ $faqTitle }}
        </h2>
        <p class="faq__desc mt-4 max-w-lg 2k:max-w-xl text-body leading-relaxed text-slate-500">
          {{ $faqDesc }}
        </p>

        <div class="faq__list mt-8 flex flex-col gap-3">
          @foreach($faqList as $i => $qa)
          <div class="faq-item {{ $i === 0 ? 'is-open' : '' }} overflow-hidden rounded-xl [&.is-open]:bg-white [&.is-open]:ring-1 [&.is-open]:ring-slate-100 transition-all duration-300">
            <button type="button" class="faq-item__question flex w-full items-center justify-between gap-4 px-5 py-4 text-left text-h6 font-bold text-navy" data-faq-toggle>
              <span>{{ $qa['question'] ?? '' }}</span>
              <span class="faq-item__icon flex h-6 w-6 shrink-0 items-center justify-center text-brand-cyan transition-transform duration-200">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </button>
            <div class="faq-item__answer grid grid-rows-[0fr] px-5 text-body-sm leading-relaxed text-slate-500 transition-all duration-300 [&.is-open]:grid-rows-[1fr] [&.is-open]:pb-4">
              <div class="overflow-hidden">
                <p class="pt-1 pb-3 text-gray-500">
                  {{ $qa['answer'] ?? '' }}
                </p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="faq__media relative mx-auto w-full max-w-md lg:max-w-none">
        <img src="{{ $faqPhoto }}" alt="{{ $faqPhotoAlt }}" class="faq__photo relative aspect-[4/5] w-full rounded-3xl object-cover shadow-xl" />

        @include('frontend.partials.faq-contact-card', ['phone' => $phone])
      </div>
    </div>
  </div>
</section>