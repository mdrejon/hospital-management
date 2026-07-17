<?php $__env->startSection('title', 'About Us | ClinicMaster Medical & Health Care Services'); ?>

<?php $__env->startSection('content'); ?>

    <!-- ===================== Breadcrumb / Page header ===================== -->
    <section class="page-header">
      <div class="page-header__media">
        <img src="<?php echo e(asset('assets/img/breadcumb.webp')); ?>" alt="Team of ClinicMaster doctors" class="page-header__bg" />
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
        <h1 class="page-header__title">About Us</h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="<?php echo e(route('home')); ?>">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span>About Us</span>
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

    <!-- ===================== About Us ===================== -->
    <section class="about">
      <svg class="about__decor" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <pattern id="about-dots" width="10" height="10" patternUnits="userSpaceOnUse">
          <circle cx="2" cy="2" r="2" fill="currentColor" />
        </pattern>
        <rect width="100" height="100" fill="url(#about-dots)" />
      </svg>

      <div class="container mx-auto">
        <div class="about__grid">
          <div class="about__media">
            <div class="about__photo-wrap">
              <img src="<?php echo e(asset('assets/img/about-image.webp')); ?>" alt="Smiling male doctor with arms crossed" class="about__photo" />
 

              <div class="about__hours-card">
                <span class="about__hours-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                  </svg>
                </span>
                <h3 class="about__hours-title">Open Hours</h3>
                <div class="about__hours-list">
                  <div class="about__hours-row">
                    <span class="about__hours-day">Monday</span>
                    <span class="about__hours-time">09:30 - 07:30</span>
                  </div>
                  <div class="about__hours-row">
                    <span class="about__hours-day">Tuesday</span>
                    <span class="about__hours-time">09:30 - 07:30</span>
                  </div>
                  <div class="about__hours-row">
                    <span class="about__hours-day">Wednesday</span>
                    <span class="about__hours-time">09:30 - 07:30</span>
                  </div>
                  <div class="about__hours-row">
                    <span class="about__hours-day">Thursday</span>
                    <span class="about__hours-time">09:30 - 07:30</span>
                  </div>
                  <div class="about__hours-row">
                    <span class="about__hours-day">Friday</span>
                    <span class="about__hours-time">09:30 - 07:30</span>
                  </div>
                  <div class="about__hours-row">
                    <span class="about__hours-day">Saturday</span>
                    <span class="about__hours-time">09:30 - 07:30</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="about__content">
            <h2 class="about__title">World Class Patient Facilities Designed For You</h2>
            <p class="about__desc">
              Experience the future of healthcare. Our state-of-the-art facilities are equipped with the latest
              technology, ensuring you receive the world's best quality treatment. Here, cutting-edge tools meet
              unparalleled expertise, providing a comfortable and effective path to optimal health.
            </p>

            <div class="about__features">
              <div>
                <div class="about__feature">
                  <span class="about__feature-check">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  Comprehensive Specialties
                </div>
                <div class="about__feature">
                  <span class="about__feature-check">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  Emergency Services
                </div>
                <div class="about__feature">
                  <span class="about__feature-check">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  Intensive Care Units (ICUs)
                </div>
                <div class="about__feature">
                  <span class="about__feature-check">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  Telemedicine Facilities
                </div>
                <div class="about__feature">
                  <span class="about__feature-check">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  Multidisciplinary Team
                </div>
              </div>

              <div>
                <div class="about__feature">
                  <span class="about__feature-check">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  Research and Development
                </div>
                <div class="about__feature">
                  <span class="about__feature-check">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  Advanced Imaging Services
                </div>
                <div class="about__feature">
                  <span class="about__feature-check">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  Rehabilitation Services
                </div>
                <div class="about__feature">
                  <span class="about__feature-check">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  Patient-Centric Approach
                </div>
                <div class="about__feature">
                  <span class="about__feature-check">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  Health Information Technology
                </div>
              </div>
            </div>

            <div class="about__cta-row">
              <a href="<?php echo e(route('appointment')); ?>" class="about__btn">
                Appointment
                <span class="about__btn-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>

              <a href="tel:11234567890" class="about__contact">
                <span class="about__contact-icon">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
                  </svg>
                </span>
                <span class="about__contact-text">
                  <span class="about__contact-label">Contact us?</span>
                  <span class="about__contact-value">1 123 456 7890</span>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== Mission & Vision ===================== -->
    <section class="mission-vision">
      <div class="container mx-auto">
        <div class="mission-vision__grid">
          <div>
            <h2 class="mission-vision__title">Inspirational Health Our <span class="accent">Vision</span> And Mission</h2>
            <p class="mission-vision__desc">
              To enhance the health and well-being of our community by providing compassionate, high-quality
              healthcare services through dedicated professionals and advanced medical practices.
            </p>

            <div class="mission-vision__list">
              <div class="mission-vision__card">
                <span class="mission-vision__icon">
                  <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.6"/>
                    <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.6"/>
                    <circle cx="12" cy="12" r="1" fill="currentColor"/>
                  </svg>
                </span>
                <div>
                  <h3 class="mission-vision__card-title">Mission</h3>
                  <p class="mission-vision__card-desc">
                    Delivering compassionate, patient-centred care through skilled professionals and dependable,
                    modern medical practices for every member of our community.
                  </p>
                </div>
              </div>

              <div class="mission-vision__card">
                <span class="mission-vision__icon">
                  <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/>
                  </svg>
                </span>
                <div>
                  <h3 class="mission-vision__card-title">Vision</h3>
                  <p class="mission-vision__card-desc">
                    To be the region's most trusted healthcare partner, recognised for clinical excellence,
                    innovation, and genuine care for every patient we serve.
                  </p>
                </div>
              </div>

              <div class="mission-vision__card">
                <span class="mission-vision__icon">
                  <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 3h12l4 6-10 12L2 9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                    <path d="M2 9h20M9 3l-3 6 6 12 6-12-3-6" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
                  </svg>
                </span>
                <div>
                  <h3 class="mission-vision__card-title">Values</h3>
                  <p class="mission-vision__card-desc">
                    Integrity, compassion, and accountability guide every decision we make, from the bedside to
                    the boardroom.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="mission-vision__media">
            <img src="<?php echo e(asset('assets/img/sr-1-2.jpg')); ?>" alt="Doctor speaking with a patient" class="mission-vision__img" />
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== Our CEO Message ===================== -->
    <section class="ceo-message">
      <div class="container mx-auto">
        <div class="ceo-message__grid">
          <div class="ceo-message__media">
            <img src="<?php echo e(asset('assets/img/about-image.webp')); ?>" alt="Dr. Natali Jackson, CEO of ClinicMaster" class="ceo-message__img" />
            <div class="ceo-message__badge">
              <span class="ceo-message__badge-value">16+</span>
              <span class="ceo-message__badge-label">Years<br />Experienced</span>
            </div>
          </div>

          <div>
            <p class="ceo-message__eyebrow">
              <span class="ceo-message__eyebrow-dot"></span>
              Our CEO Message
              <span class="ceo-message__eyebrow-dot"></span>
            </p>
            <h2 class="ceo-message__title">Meet Dr. Natali Jackson</h2>
            <p class="ceo-message__desc">
              As CEO of ClinicMaster, I'm committed to building a hospital where compassionate care meets clinical
              excellence. Every decision we make, from staffing to technology, starts with what's best for the
              patients and families who trust us with their health.
            </p>

            <p class="ceo-message__focus-label">Leadership Focus</p>
            <div class="ceo-message__checklist">
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                Patient-Centered Care
              </span>
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                Clinical Innovation
              </span>
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                Operational Excellence
              </span>
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                Community Outreach
              </span>
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                Quality Assurance
              </span>
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                Strategic Growth
              </span>
            </div>

            <div class="ceo-message__awards">
              <div class="ceo-message__award">
                <span class="ceo-message__award-icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2l2.5 5 5.5.6-4 3.9 1 5.5L12 14.8 7 17l1-5.5-4-3.9L9.5 7 12 2z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                  </svg>
                </span>
                <div>
                  <p class="ceo-message__award-year">ClinicMaster 2024</p>
                  <p class="ceo-message__award-org">Quality and Accreditation Institute</p>
                  <a href="<?php echo e(route('achievements')); ?>" class="ceo-message__award-link">Healthcare Leadership Award</a>
                </div>
              </div>

              <div class="ceo-message__award">
                <span class="ceo-message__award-icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2l2.5 5 5.5.6-4 3.9 1 5.5L12 14.8 7 17l1-5.5-4-3.9L9.5 7 12 2z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                  </svg>
                </span>
                <div>
                  <p class="ceo-message__award-year">ClinicMaster 2023</p>
                  <p class="ceo-message__award-org">National Hospital Federation</p>
                  <a href="<?php echo e(route('achievements')); ?>" class="ceo-message__award-link">Excellence in Patient Care</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/frontend/about.blade.php ENDPATH**/ ?>