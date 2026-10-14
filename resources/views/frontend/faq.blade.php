@extends('layouts.frontend')

@php
$heroTitle = $faqPage['faq_hero_title'] ?? 'FAQ';
$heroImage = !empty($faqPage['faq_hero_image']) ? asset('storage/' . $faqPage['faq_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $faqPage['faq_seo_title'] ?? ('FAQ | ' . config('app.name'));
$seoDesc = $faqPage['faq_seo_description'] ?? "Answers to the questions patients ask us most often. Can't find what you're looking for? Reach out and our team will be glad to help.";
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDesc)
@section('og_title', $seoTitle)
@section('og_description', $seoDesc)
@if(!empty($faqPage['faq_seo_keywords']))
@section('meta_keywords', $faqPage['faq_seo_keywords'])
@endif
@if(!empty($faqPage['faq_seo_og_image']))
@section('og_image', asset('storage/' . $faqPage['faq_seo_og_image']))
@endif

@section('content')

<!-- ===================== Breadcrumb / Page header ===================== -->
<section class="page-header">
  <div class="page-header__media">
    <img src="{{ $heroImage }}" alt="Team of Sitakund Modern Hospital Ltd. doctors" class="page-header__bg" />
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
      <span>{{ __('frontend.breadcrumb.faq') }}</span>
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

<!-- ===================== FAQ ===================== -->
@php
$faqTitle = ($faqPage['faq_page_title'] ?? null) ?: ($faqData['title'] ?: 'Frequently Asked Questions');
$faqDesc = ($faqPage['faq_page_desc'] ?? null) ?: ($faqData['description'] ?: "Answers to the questions patients ask us most often. Can't find what you're looking for? Reach out and our team will be glad to help.");
$faqPhoto = !empty($faqPage['faq_page_image']) ? asset('storage/' . $faqPage['faq_page_image']) : ($faqData['image'] ?: asset('assets/img/about-image.webp'));
$faqPhotoAlt = $faqData['image_alt'] ?: 'Smiling doctor ready to answer your questions';
$faqList = (!empty($faqData['items']) && $faqData['items']->isNotEmpty()) ? $faqData['items'] : collect([
['question' => 'What types of treatments do you offer?', 'answer' => 'Sitakund Modern Hospital Ltd. offers a full range of services, from routine check-ups and diagnostics to specialist care in cardiology, pediatrics, dental, maternity, surgery, and emergency medicine. Visit our Services page for the complete list.'],
['question' => 'How do I book my appointment?', 'answer' => "You can book online through our Appointment page by choosing a department, preferred doctor, and time slot, or call us directly at 1 123 456 7890. You'll receive a confirmation once your visit is scheduled."],
['question' => 'Can I cancel or reschedule my appointment?', 'answer' => 'Yes. Appointments can be rescheduled or cancelled free of charge up to 24 hours in advance by calling our front desk or emailing support@hospital.com.'],
['question' => 'Do you accept health insurance?', 'answer' => 'We work with most major insurance providers. Bring your insurance card to your first visit, or contact our billing team beforehand to confirm your coverage and any out-of-pocket costs.'],
['question' => 'Is emergency care available 24/7?', 'answer' => 'Yes, our Emergency & Urgent Care department is staffed around the clock, every day of the year, with a dedicated ambulance and trauma team on standby.'],
['question' => 'Can I get a telemedicine consultation?', 'answer' => 'Absolutely. Many of our specialists offer video consultations for follow-ups and non-emergency concerns. Select "Telemedicine" when booking your appointment online.'],
]);
@endphp
<section class="faq">
  <div class="container mx-auto">
    <div class="faq__grid">
      <div>
        <h2 class="faq__title">{{ $faqTitle }}</h2>
        <p class="faq__desc">
          {{ $faqDesc }}
        </p>

        <div class="faq__list">
          @foreach($faqList as $i => $qa)
          <div class="faq-item {{ $i === 0 ? 'is-open' : '' }}">
            <button type="button" class="faq-item__question" data-faq-toggle>
              {{ $qa['question'] ?? '' }}
              <span class="faq-item__icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </button>
            <div class="faq-item__answer">
              <p>
                {{ $qa['answer'] ?? '' }}
              </p>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="faq__media">
        <img src="{{ $faqPhoto }}" alt="{{ $faqPhotoAlt }}" class="faq__photo" />

        @include('frontend.partials.faq-contact-card', ['phone' => $footerSettings['footer_phone_1'] ?? '1 123 456 7890'])
      </div>
    </div>
  </div>
</section>
@endsection