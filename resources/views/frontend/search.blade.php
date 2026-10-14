@extends('layouts.frontend')

@section('title', ($query !== '' ? 'Search results for "' . $query . '"' : 'Search') . ' | ' . config('app.name'))

@section('content')

<!-- ===================== Breadcrumb / Page header ===================== -->
<section class="page-header">
  <div class="page-header__media">
    <img src="{{ asset('assets/img/breadcumb.webp') }}" alt="Team of Medicare Lab Ltd. doctors" class="page-header__bg" />
    <span class="page-header__overlay"></span>
  </div>

  <span class="page-header__badge">24/7 Emergency Service</span>

  <x-frontend.page-header-social />

  <div class="page-header__inner">
    <h1 class="page-header__title">{{ __('frontend.breadcrumb.search_results') }}</h1>
    <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">{{ __('frontend.nav.home') }}</a>
      <span class="page-header__breadcrumb-sep">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span>
      <span>{{ __('frontend.breadcrumb.search') }}</span>
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

<!-- ===================== Search Results ===================== -->
<section class="services">
  <div class="container mx-auto">
    <div class="services__head">
      <p class="services__eyebrow">{{ $results->count() }} result{{ $results->count() === 1 ? '' : 's' }} found</p>
      <h2 class="services__title">
        @if($query !== '')
        Search results for &ldquo;{{ $query }}&rdquo;
        @else
        What are you looking for?
        @endif
      </h2>
    </div>

    @if($query === '')
    <p class="mt-6 text-center text-slate-500">Use the search box in the header to find doctors, services, packages, and articles.</p>
    @elseif($results->isEmpty())
    <p class="mt-6 text-center text-slate-500">No results found for &ldquo;{{ $query }}&rdquo;. Try a different keyword.</p>
    @else
    <div class="services__grid">
      @foreach($results as $card)
      <article class="service-card">
        <div class="service-card__media">
          <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="service-card__img" />
          <span class="service-card__icon">
            {!! $card['icon_svg'] ?: '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M9 4a3 3 0 0 0-3 3 3 3 0 0 0-1 5.8A3 3 0 0 0 8 17a3 3 0 0 0 3-3V7a3 3 0 0 0-2-3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
              <path d="M15 4a3 3 0 0 1 3 3 3 3 0 0 1 1 5.8A3 3 0 0 1 16 17a3 3 0 0 1-3-3V7a3 3 0 0 1 2-3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            </svg>' !!}
          </span>
        </div>
        <div class="service-card__body">
          <p class="service-card__desc" style="font-weight:700; margin-bottom: 0.25rem;">{{ $card['type'] }}</p>
          <h3 class="service-card__title">{{ $card['title'] }}</h3>
          <p class="service-card__desc">{{ $card['desc'] }}</p>
          <a href="{{ $card['url'] }}" class="service-card__btn">
            Read more
            <span class="service-card__btn-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
          </a>
        </div>
      </article>
      @endforeach
    </div>
    @endif
  </div>
</section>
@endsection