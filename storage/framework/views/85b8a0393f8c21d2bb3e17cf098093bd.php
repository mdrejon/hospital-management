<?php $__env->startSection('title', 'Our Services | ClinicMaster Medical & Health Care Services'); ?>

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
        <h1 class="page-header__title">Our Services</h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="<?php echo e(route('home')); ?>">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span>Services</span>
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

    <!-- ===================== Services ===================== -->
    <section class="services">
      <div class="container mx-auto">
        <div class="services__head">
          <p class="services__eyebrow">Explore Medical Department</p>
          <h2 class="services__title">Complete Health Solutions — Because You Deserve the Best</h2>
        </div>

        <div class="services__grid">
          <!-- Mental Health & Wellness -->
          <article class="service-card">
            <div class="service-card__media">
              <img src="<?php echo e(asset('assets/img/sr-1-2.jpg')); ?>" alt="Therapist talking with a patient" class="service-card__img" />
              <span class="service-card__icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9 4a3 3 0 0 0-3 3 3 3 0 0 0-1 5.8A3 3 0 0 0 8 17a3 3 0 0 0 3-3V7a3 3 0 0 0-2-3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                  <path d="M15 4a3 3 0 0 1 3 3 3 3 0 0 1 1 5.8A3 3 0 0 1 16 17a3 3 0 0 1-3-3V7a3 3 0 0 1 2-3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <div class="service-card__body">
              <h3 class="service-card__title">Mental Health &amp; Wellness</h3>
              <p class="service-card__desc">Counseling, therapy, and psychiatric care for mental well-being.</p>
              <a href="<?php echo e(route('service-details')); ?>" class="service-card__btn">
                Read more
                <span class="service-card__btn-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
            </div>
          </article>

          <!-- Emergency & Urgent Care -->
          <article class="service-card">
            <div class="service-card__media">
              <img src="<?php echo e(asset('assets/img/appoinment.jpg')); ?>" alt="Doctor attending to an elderly patient" class="service-card__img" />
              <span class="service-card__icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 3a5 5 0 0 1 5 5v6H7V8a5 5 0 0 1 5-5z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                  <path d="M5 14h14v3a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-3zM12 3V1M9 21h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
              </span>
            </div>
            <div class="service-card__body">
              <h3 class="service-card__title">Emergency &amp; Urgent Care</h3>
              <p class="service-card__desc">24/7 medical assistance for accidents and critical health conditions.</p>
              <a href="<?php echo e(route('service-details')); ?>" class="service-card__btn">
                Read more
                <span class="service-card__btn-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
            </div>
          </article>

          <!-- Diagnostic & Laboratory -->
          <article class="service-card">
            <div class="service-card__media">
              <img src="<?php echo e(asset('assets/img/projects-4.jpg')); ?>" alt="Lab technician examining a sample under a microscope" class="service-card__img" />
              <span class="service-card__icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9 2h6M10 2v6.5L5.5 18a2 2 0 0 0 1.8 2.9h9.4a2 2 0 0 0 1.8-2.9L14 8.5V2" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                  <path d="M7.5 15h9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
              </span>
            </div>
            <div class="service-card__body">
              <h3 class="service-card__title">Diagnostic &amp; Laboratory</h3>
              <p class="service-card__desc">Blood tests, imaging (X-rays, MRIs, CT scans), and screenings diagnosis.</p>
              <a href="<?php echo e(route('service-details')); ?>" class="service-card__btn">
                Read more
                <span class="service-card__btn-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
            </div>
          </article>

          <!-- Maternity & Pediatric Care -->
          <article class="service-card">
            <div class="service-card__media">
              <img src="<?php echo e(asset('assets/img/slider-1.2.jpg')); ?>" alt="Doctor examining a baby patient" class="service-card__img" />
              <span class="service-card__icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 20s-7-4.5-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 5c-2.5 4.5-9.5 9-9.5 9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                  <path d="M12 9v4M10 11h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
              </span>
            </div>
            <div class="service-card__body">
              <h3 class="service-card__title">Maternity &amp; Pediatric Care</h3>
              <p class="service-card__desc">Comprehensive care for expecting mothers, newborns, children's health.</p>
              <a href="<?php echo e(route('service-details')); ?>" class="service-card__btn">
                Read more
                <span class="service-card__btn-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
            </div>
          </article>

          <!-- Dental Care Services -->
          <article class="service-card">
            <div class="service-card__media">
              <img src="<?php echo e(asset('assets/img/projects-2.jpg')); ?>" alt="Dentist examining a young patient" class="service-card__img" />
              <span class="service-card__icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 3c-2.2 0-3.8 1-5 1-1.5 0-2.5 1.3-2.5 3.3 0 2.2.7 4.7 1.4 6.9.5 1.7.9 3.6 1.6 4.9.4.8 1 1.4 1.8 1.4.9 0 1.3-.8 1.6-1.9.3-1.1.4-2.5 1.1-2.5s.8 1.4 1.1 2.5c.3 1.1.7 1.9 1.6 1.9.8 0 1.4-.6 1.8-1.4.7-1.3 1.1-3.2 1.6-4.9.7-2.2 1.4-4.7 1.4-6.9C19.5 5.3 18.5 4 17 4c-1.2 0-2.8-1-5-1z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <div class="service-card__body">
              <h3 class="service-card__title">Dental Care Services</h3>
              <p class="service-card__desc">Our Dental Care Services are designed to provide comprehensive treatment.</p>
              <a href="<?php echo e(route('service-details')); ?>" class="service-card__btn">
                Read more
                <span class="service-card__btn-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
            </div>
          </article>

          <!-- Surgery Care -->
          <article class="service-card">
            <div class="service-card__media">
              <img src="<?php echo e(asset('assets/img/sr-1-1.jpg')); ?>" alt="Surgical team performing an operation" class="service-card__img" />
              <span class="service-card__icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4 20 14 10M14 10l6-6M14 10l3 3M17 4l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <div class="service-card__body">
              <h3 class="service-card__title">Surgery Care</h3>
              <p class="service-card__desc">Our Surgery Care services provide expert, compassionate treatment.</p>
              <a href="<?php echo e(route('service-details')); ?>" class="service-card__btn">
                Read more
                <span class="service-card__btn-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
            </div>
          </article>
        </div>
      </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\frontend\services.blade.php ENDPATH**/ ?>