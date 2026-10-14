@extends('layouts.frontend')

@php
$heroTitle = $appt['appt_page_hero_title'] ?? 'Book Appointment';
$heroImage = !empty($appt['appt_page_hero_image']) ? asset('storage/' . $appt['appt_page_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $appt['appt_seo_title'] ?? ('Book Appointment | ' . config('app.name'));
$seoDesc = $appt['appt_seo_description'] ?? 'Schedule your visit with Sitakund Modern Hospital Ltd. in just a few clicks — fast, easy appointment booking.';
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDesc)
@section('og_title', $seoTitle)
@section('og_description', $seoDesc)
@if(!empty($appt['appt_seo_keywords']))
@section('meta_keywords', $appt['appt_seo_keywords'])
@endif
@if(!empty($appt['appt_seo_og_image']))
@section('og_image', asset('storage/' . $appt['appt_seo_og_image']))
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
      <span>{{ $heroTitle }}</span>
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
<x-frontend.book-appointment :settings="$appt" :doctors="$appointmentDoctors" :specializations="$appointmentSpecializations" source="appointment_page" />
@endsection