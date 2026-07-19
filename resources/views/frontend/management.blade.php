@extends('layouts.frontend')

@php
  $heroTitle = $mgmt['mgmt_hero_title'] ?? 'Our Management';
  $heroImage = !empty($mgmt['mgmt_hero_image']) ? asset('storage/' . $mgmt['mgmt_hero_image']) : asset('assets/img/breadcumb.webp');
  $seoTitle  = $mgmt['mgmt_seo_title'] ?? 'Our Management | ClinicMaster Medical & Health Care Services';
  $seoDesc   = $mgmt['mgmt_seo_description'] ?? "Meet the leadership team guiding ClinicMaster's mission of compassionate, expert healthcare.";
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDesc)
@section('og_title', $seoTitle)
@section('og_description', $seoDesc)
@if(!empty($mgmt['mgmt_seo_keywords']))
@section('meta_keywords', $mgmt['mgmt_seo_keywords'])
@endif
@if(!empty($mgmt['mgmt_seo_og_image']))
@section('og_image', asset('storage/' . $mgmt['mgmt_seo_og_image']))
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
          <span>Our Management</span>
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

    <!-- ===================== Our Management ===================== -->
    @php
      $mgmtSocialIcons = [
        'linkedin'  => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>',
        'facebook'  => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>',
        'twitter'   => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 0 1-1.9.1c.5 1.7 2.1 2.9 4 2.9A8.2 8.2 0 0 1 2 18.6a11.6 11.6 0 0 0 6.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z"/></svg>',
        'instagram' => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></svg>',
        'youtube'   => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M23 12s0-3.6-.5-5.3c-.3-1-1-1.8-2-2C18.9 4.2 12 4.2 12 4.2s-6.9 0-8.5.5c-1 .3-1.7 1-2 2C1 8.4 1 12 1 12s0 3.6.5 5.3c.3 1 1 1.8 2 2 1.6.5 8.5.5 8.5.5s6.9 0 8.5-.5c1-.3 1.7-1 2-2 .5-1.7.5-5.3.5-5.3zM9.8 15.5V8.5l6.2 3.5-6.2 3.5z"/></svg>',
      ];
      $mgmtCards = $members->isNotEmpty()
        ? $members->map(fn ($m) => [
            'name'      => $m->name,
            'role'      => $m->role,
            'photo'     => $m->photo ? asset('storage/' . $m->photo) : asset('assets/img/team-3.png'),
            'linkedin'  => $m->linkedin_url,
            'facebook'  => $m->facebook_url,
            'twitter'   => $m->twitter_url,
            'instagram' => $m->instagram_url,
            'youtube'   => $m->youtube_url,
          ])
        : collect([
            ['name' => 'Nashid Martines',   'role' => 'Chairman & Founder'],
            ['name' => 'Dr. Natali Jackson','role' => 'Chief Executive Officer'],
            ['name' => 'Kenneth Fong',      'role' => 'Managing Director'],
            ['name' => 'Rihana Roy',        'role' => 'Chief Medical Officer'],
            ['name' => 'Danial Frankie',    'role' => 'Chief of Cardiac Surgery'],
            ['name' => 'Marcus Bennett',    'role' => 'Chief Financial Officer'],
            ['name' => 'Sofia Almeida',     'role' => 'Director of Nursing'],
            ['name' => 'Adrian Cole',       'role' => 'Director of Operations'],
          ])->map(fn ($m) => array_merge($m, [
            'photo' => asset('assets/img/team-3.png'),
            'linkedin' => null, 'facebook' => null, 'twitter' => null, 'instagram' => null, 'youtube' => null,
          ]));
    @endphp
    <section class="management">
      <div class="container mx-auto">
        <div class="team__head">
          <p class="team__eyebrow">
            <span class="team__eyebrow-dot"></span>
            {{ $mgmt['mgmt_badge'] ?? 'Our Leadership' }}
            <span class="team__eyebrow-dot"></span>
          </p>
          <h2 class="team__title">{{ $mgmt['mgmt_title'] ?? 'Meet Our Management Team' }}</h2>
        </div>

        <div class="management__grid">
          @foreach($mgmtCards as $card)
          <article class="mgmt-card">
            <div class="mgmt-card__photo-wrap">
              <img src="{{ $card['photo'] }}" alt="{{ $card['name'] }}{{ $card['role'] ? ', ' . $card['role'] : '' }}" class="mgmt-card__photo" />
            </div>

            <div class="mgmt-card__bar">
              <div>
                <h3 class="mgmt-card__name">{{ $card['name'] }}</h3>
                <p class="mgmt-card__role">{{ $card['role'] }}</p>
              </div>
              <a href="{{ route('management') }}" class="mgmt-card__arrow" aria-label="View {{ $card['name'] }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </a>
            </div>

            <div class="mgmt-card__social">
              @foreach(['linkedin' => 'LinkedIn', 'facebook' => 'Facebook', 'twitter' => 'Twitter', 'instagram' => 'Instagram', 'youtube' => 'YouTube'] as $key => $label)
              <a href="{{ $card[$key] ?: '#' }}" class="mgmt-card__social-link" aria-label="{{ $label }}">
                {!! $mgmtSocialIcons[$key] !!}
              </a>
              @endforeach
            </div>
          </article>
          @endforeach

        </div>
      </div>
    </section>
@endsection
