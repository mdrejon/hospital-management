@extends('layouts.frontend')

@section('title', 'Gallery | ClinicMaster Medical & Health Care Services')

@section('content')

    <!-- ===================== Breadcrumb / Page header ===================== -->
    <section class="page-header">
      <div class="page-header__media">
        <img src="{{ asset('assets/img/breadcumb.webp') }}" alt="Team of ClinicMaster doctors" class="page-header__bg" />
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
        <h1 class="page-header__title">Our Gallery</h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('home') }}">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span>Gallery</span>
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

    <!-- ===================== Gallery ===================== -->
    <section class="gallery">
      <div class="container mx-auto">
        <div class="team__head">
          <p class="team__eyebrow">
            <span class="team__eyebrow-dot"></span>
            Our Gallery
            <span class="team__eyebrow-dot"></span>
          </p>
          <h2 class="team__title">Inside Our <span class="accent">Hospital</span></h2>
        </div>
        <p class="gallery__desc">
          From modern treatment rooms to advanced diagnostic facilities &mdash; take a look at the spaces and
          people behind ClinicMaster's award-winning care.
        </p>

        <div class="gallery__grid">
          <a href="#" class="gallery-item" data-gallery-item>
            <img src="{{ asset('assets/img/slider-1.2.jpg') }}" alt="ClinicMaster treatment room" class="gallery-item__img aspect-[4/3]" />
            <span class="gallery-item__overlay">
              <span class="gallery-item__expand">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15 4h5v5M9 20H4v-5M20 4l-6 6M4 20l6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span class="gallery-item__caption">
                <span class="gallery-item__tag"><span class="gallery-item__tag-dot"></span>Child Care</span>
                <span class="gallery-item__title">Gentle Pediatric Checkups</span>
              </span>
            </span>
          </a>

          <a href="#" class="gallery-item" data-gallery-item>
            <img src="{{ asset('assets/img/sr-1-1.jpg') }}" alt="Radiology and imaging department" class="gallery-item__img aspect-[3/4]" />
            <span class="gallery-item__overlay">
              <span class="gallery-item__expand">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15 4h5v5M9 20H4v-5M20 4l-6 6M4 20l6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span class="gallery-item__caption">
                <span class="gallery-item__tag"><span class="gallery-item__tag-dot"></span>Surgery</span>
                <span class="gallery-item__title">Modern Operating Theatre</span>
              </span>
            </span>
          </a>

          <a href="#" class="gallery-item" data-gallery-item>
            <img src="{{ asset('assets/img/projects-2.jpg') }}" alt="Doctors reviewing patient charts" class="gallery-item__img aspect-square" />
            <span class="gallery-item__overlay">
              <span class="gallery-item__expand">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15 4h5v5M9 20H4v-5M20 4l-6 6M4 20l6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span class="gallery-item__caption">
                <span class="gallery-item__tag"><span class="gallery-item__tag-dot"></span>Consultation</span>
                <span class="gallery-item__title">Patient Case Review</span>
              </span>
            </span>
          </a>

          <a href="#" class="gallery-item" data-gallery-item>
            <img src="{{ asset('assets/img/sr-1-2.jpg') }}" alt="Doctor consulting with a patient" class="gallery-item__img aspect-[4/5]" />
            <span class="gallery-item__overlay">
              <span class="gallery-item__expand">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15 4h5v5M9 20H4v-5M20 4l-6 6M4 20l6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span class="gallery-item__caption">
                <span class="gallery-item__tag"><span class="gallery-item__tag-dot"></span>Dental Care</span>
                <span class="gallery-item__title">Comfortable Dental Visits</span>
              </span>
            </span>
          </a>

          <a href="#" class="gallery-item" data-gallery-item>
            <img src="{{ asset('assets/img/slider-1.3.jpg') }}" alt="Medical team on duty" class="gallery-item__img aspect-[16/11]" />
            <span class="gallery-item__overlay">
              <span class="gallery-item__expand">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15 4h5v5M9 20H4v-5M20 4l-6 6M4 20l6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span class="gallery-item__caption">
                <span class="gallery-item__tag"><span class="gallery-item__tag-dot"></span>Emergency</span>
                <span class="gallery-item__title">Round-the-Clock Response</span>
              </span>
            </span>
          </a>

          <a href="#" class="gallery-item" data-gallery-item>
            <img src="{{ asset('assets/img/projects-3.jpg') }}" alt="Cardiology department" class="gallery-item__img aspect-[3/4]" />
            <span class="gallery-item__overlay">
              <span class="gallery-item__expand">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15 4h5v5M9 20H4v-5M20 4l-6 6M4 20l6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span class="gallery-item__caption">
                <span class="gallery-item__tag"><span class="gallery-item__tag-dot"></span>Cardiology</span>
                <span class="gallery-item__title">Advanced Cardiac Care</span>
              </span>
            </span>
          </a>

          <a href="#" class="gallery-item" data-gallery-item>
            <img src="{{ asset('assets/img/sr-1-3.jpg') }}" alt="Doctor in the medical library" class="gallery-item__img aspect-square" />
            <span class="gallery-item__overlay">
              <span class="gallery-item__expand">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15 4h5v5M9 20H4v-5M20 4l-6 6M4 20l6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span class="gallery-item__caption">
                <span class="gallery-item__tag"><span class="gallery-item__tag-dot"></span>Dermatology</span>
                <span class="gallery-item__title">Skin & Laser Treatments</span>
              </span>
            </span>
          </a>

          <a href="#" class="gallery-item" data-gallery-item>
            <img src="{{ asset('assets/img/projects-4.jpg') }}" alt="Surgery preparation room" class="gallery-item__img aspect-[4/3]" />
            <span class="gallery-item__overlay">
              <span class="gallery-item__expand">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15 4h5v5M9 20H4v-5M20 4l-6 6M4 20l6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span class="gallery-item__caption">
                <span class="gallery-item__tag"><span class="gallery-item__tag-dot"></span>Laboratory</span>
                <span class="gallery-item__title">Precision Diagnostics</span>
              </span>
            </span>
          </a>

          <a href="#" class="gallery-item" data-gallery-item>
            <img src="{{ asset('assets/img/appoinment.jpg') }}" alt="Reception and appointment desk" class="gallery-item__img aspect-[4/5]" />
            <span class="gallery-item__overlay">
              <span class="gallery-item__expand">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15 4h5v5M9 20H4v-5M20 4l-6 6M4 20l6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span class="gallery-item__caption">
                <span class="gallery-item__tag"><span class="gallery-item__tag-dot"></span>Appointments</span>
                <span class="gallery-item__title">One-on-One Guidance</span>
              </span>
            </span>
          </a>
        </div>
      </div>
    </section>

    <!-- Lightbox overlay -->
    <div class="lightbox" data-lightbox role="dialog" aria-modal="true" aria-label="Image preview">
      <img src="" alt="" class="lightbox__img" data-lightbox-img />
      <button type="button" class="lightbox__close" data-lightbox-close aria-label="Close preview">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="m6 6 12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button>
      <button type="button" class="lightbox__nav is-prev" data-lightbox-prev aria-label="Previous image">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M19 12H5M11 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
      <button type="button" class="lightbox__nav is-next" data-lightbox-next aria-label="Next image">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
    </div>
@endsection
