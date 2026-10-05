@extends('layouts.frontend')

@php
$heroTitle = $doc['doc_page_hero_title'] ?? 'Our Doctors';
$heroImage = !empty($doc['doc_page_hero_image']) ? asset('storage/' . $doc['doc_page_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $doc['doc_seo_title'] ?? ('Our Doctors | ' . config('app.name'));
$seoDesc = $doc['doc_seo_description'] ?? 'Meet the team of Medicare Lab Ltd. doctors dedicated to compassionate, expert medical care.';
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDesc)
@section('og_title', $seoTitle)
@section('og_description', $seoDesc)
@if(!empty($doc['doc_seo_keywords']))
@section('meta_keywords', $doc['doc_seo_keywords'])
@endif
@if(!empty($doc['doc_seo_og_image']))
@section('og_image', asset('storage/' . $doc['doc_seo_og_image']))
@endif

@section('content')

<!-- ===================== Breadcrumb / Page header ===================== -->
<section class="page-header">
  <div class="page-header__media">
    <img src="{{ $heroImage }}" alt="Team of Medicare Lab Ltd. doctors" class="page-header__bg" />
    <span class="page-header__overlay"></span>
  </div>

  <span class="page-header__badge">24/7 Emergency Service</span>

  <div class="page-header__social">
    <a href="#" class="page-header__social-link" aria-label="Facebook">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
        <path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z" />
      </svg>
    </a>
    <a href="#" class="page-header__social-link" aria-label="Twitter">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
        <path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 0 1-1.9.1c.5 1.7 2.1 2.9 4 2.9A8.2 8.2 0 0 1 2 18.6a11.6 11.6 0 0 0 6.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z" />
      </svg>
    </a>
    <a href="#" class="page-header__social-link" aria-label="LinkedIn">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
        <path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z" />
      </svg>
    </a>
    <a href="#" class="page-header__social-link" aria-label="Instagram">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
        <rect x="3.5" y="3.5" width="17" height="17" rx="5" />
        <circle cx="12" cy="12" r="4" />
        <circle cx="17.2" cy="6.8" r="1" />
      </svg>
    </a>
  </div>

  <div class="page-header__inner">
    <h1 class="page-header__title">{{ $heroTitle }}</h1>
    <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">{{ __('frontend.nav.home') }}</a>
      <span class="page-header__breadcrumb-sep">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span>
      <span>{{ __('frontend.breadcrumb.doctors') }}</span>
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

<!-- ===================== Doctors ===================== -->
@php
// Demo placeholder doctors only make sense when nothing is filtered — a
// specialization filter legitimately returning zero doctors should show
// an honest empty state, not unrelated fake names.
$doctorCards = $doctors->isNotEmpty()
? $doctors->map(fn ($d) => [
'name' => $d->name,
'role' => $d->role,
'photo' => $d->photo ? asset('storage/' . $d->photo) : asset('assets/img/team-3.png'),
'url' => route('doctor-details', $d->slug),
'facebook' => $d->facebook_url,
'youtube' => $d->youtube_url,
'linkedin' => $d->linkedin_url,
])
: (isset($specialization) && $specialization ? collect() : collect([
['name' => 'Dr. Laron Metar', 'role' => 'Practice Service', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
['name' => 'Dr. Smith Karo', 'role' => 'Founder', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
['name' => 'Dr. Merata Baron', 'role' => 'Emergency Services', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
['name' => 'Dr. Elena Cross', 'role' => 'Cardiologist', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
['name' => 'Dr. Michael Reyes', 'role' => 'Pediatrician', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
['name' => 'Dr. Sara Owens', 'role' => 'Neurologist', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
]));
@endphp
<section class="doctors-page !py-24 bg-white relative overflow-hidden">
  <!-- Animated Floating Element -->
  <div class="absolute bottom-20 right-10 opacity-[0.08] animate-spin text-brand-cyan pointer-events-none z-0" style="animation-duration: 20s;">
    <svg width="150" height="150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><circle cx="12" cy="12" r="10" stroke-dasharray="4 4"/></svg>
  </div>
  <div class="container mx-auto">
    <div class="team__head">
      <p class="team__eyebrow">
        <span class="team__eyebrow-dot"></span>
        {{ $doc['doc_badge'] ?? 'Our Team Member' }}
        <span class="team__eyebrow-dot"></span>
      </p>
      <h2 class="team__title">{{ $doc['doc_title'] ?? 'Meet Our Doctor Meeting' }}</h2>
      @if(isset($specialization) && $specialization)
      <p class="mt-3 text-sm text-muted">
        Showing: <strong class="text-navy">{{ $specialization->name }}</strong>
        <a href="{{ route('doctors') }}" class="text-brand-cyan hover:underline ml-2">Clear filter</a>
      </p>
      @endif
    </div>

    @if(isset($specialization) && $specialization && $doctorCards->isEmpty())
    <p class="text-center text-muted py-12">No doctors found under "{{ $specialization->name }}" yet. Please check back soon.</p>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8 mt-12">
      @foreach($doctorCards as $card)
      <article class="bg-white rounded-lg overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:shadow-[0_4px_25px_rgba(0,0,0,0.1)] transition-shadow duration-300 group h-full border border-gray-100">
        <!-- Image & Overlay -->
        <div class="relative overflow-hidden aspect-[4/5] bg-gray-50 flex items-end justify-center">
          <a href="{{ $card['url'] }}" class="absolute inset-0 z-0">
             <img src="{{ $card['photo'] }}" alt="{{ $card['name'] }}" class="w-full h-full object-cover object-top" />
          </a>
          <!-- Hover Overlay with Social Icons -->
          <div class="absolute inset-0 bg-white/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px] pointer-events-none">
            <div class="flex items-center gap-3 translate-y-4 group-hover:translate-y-0 transition-transform duration-300 pointer-events-auto">
              <a href="{{ $card['facebook'] ?: '#' }}" class="w-10 h-10 rounded-full bg-white text-navy flex items-center justify-center hover:bg-brand-cyan hover:text-white shadow-lg transition-colors" aria-label="Facebook">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
              </a>
              <a href="{{ $card['linkedin'] ?: '#' }}" class="w-10 h-10 rounded-full bg-white text-navy flex items-center justify-center hover:bg-brand-cyan hover:text-white shadow-lg transition-colors" aria-label="LinkedIn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>
              </a>
              <a href="{{ $card['url'] }}" class="w-10 h-10 rounded-full bg-brand-cyan text-white flex items-center justify-center hover:bg-navy shadow-lg transition-colors" aria-label="View Profile">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
              </a>
            </div>
          </div>
        </div>
        <!-- Content -->
        <div class="p-6 text-center border-t border-gray-100">
          <p class="text-gray-500 text-[13px] mb-1.5">{{ $card['role'] }}</p>
          <a href="{{ $card['url'] }}" class="inline-block hover:text-brand-cyan transition-colors">
            <h3 class="text-navy text-[19px] font-bold">{{ $card['name'] }}</h3>
          </a>
        </div>
      </article>
      @endforeach
    </div>
    @endif
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