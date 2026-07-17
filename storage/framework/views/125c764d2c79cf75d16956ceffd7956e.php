<?php $__env->startSection('title', 'Doctor Details | ClinicMaster Medical & Health Care Services'); ?>

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
        <h1 class="page-header__title">Doctor Details</h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="<?php echo e(route('home')); ?>">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <a href="<?php echo e(route('doctors')); ?>">Doctors</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span>Rihana Roy</span>
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
    <!-- ===================== Doctors ===================== -->
    <!-- ===================== Doctor Detail ===================== -->
    <section class="doctor-detail">
      <div class="container mx-auto">
        <div class="doctor-detail__grid">
          <!-- Sidebar -->
          <aside class="doctor-detail__sidebar">
            <div class="doctor-photo-card">
              <img src="<?php echo e(asset('assets/img/team-3.png')); ?>" alt="Dr. Rihana Roy" class="doctor-photo-card__img" />
              <div class="doctor-photo-card__social">
                <a href="#" class="doctor-photo-card__social-link" aria-label="LinkedIn">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>
                </a>
                <a href="#" class="doctor-photo-card__social-link" aria-label="Instagram">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></svg>
                </a>
                <a href="#" class="doctor-photo-card__social-link" aria-label="Facebook">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
                </a>
                <a href="#" class="doctor-photo-card__social-link" aria-label="X">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.3 3H21l-6.4 7.3L22 21h-6.5l-5-6.6-5.8 6.6H2l6.9-7.9L2 3h6.6l4.6 6.1L18.3 3zM17.2 19h1.5L7.9 4.9H6.3L17.2 19z"/></svg>
                </a>
                <a href="#" class="doctor-photo-card__social-link" aria-label="YouTube">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M23 12s0-3.6-.5-5.3c-.3-1-1-1.8-2-2C18.9 4.2 12 4.2 12 4.2s-6.9 0-8.5.5c-1 .3-1.7 1-2 2C1 8.4 1 12 1 12s0 3.6.5 5.3c.3 1 1 1.8 2 2 1.6.5 8.5.5 8.5.5s6.9 0 8.5-.5c1-.3 1.7-1 2-2 .5-1.7.5-5.3.5-5.3zM9.8 15.5V8.5l6.2 3.5-6.2 3.5z"/></svg>
                </a>
              </div>
            </div>

            <div class="doctor-schedule">
              <h3 class="doctor-schedule__title">My Time Schedule</h3>
              <div class="doctor-schedule__row">
                <span class="doctor-schedule__day">Monday</span>
                <span class="doctor-schedule__time">11:00 AM – 6:00 PM</span>
              </div>
              <div class="doctor-schedule__row">
                <span class="doctor-schedule__day">Tuesday</span>
                <span class="doctor-schedule__time">11:00 AM – 6:00 PM</span>
              </div>
              <div class="doctor-schedule__row">
                <span class="doctor-schedule__day">Wednesday</span>
                <span class="doctor-schedule__time">11:00 AM – 6:00 PM</span>
              </div>
              <div class="doctor-schedule__row">
                <span class="doctor-schedule__day">Thursday</span>
                <span class="doctor-schedule__time">11:00 AM – 6:00 PM</span>
              </div>
              <div class="doctor-schedule__row">
                <span class="doctor-schedule__day">Friday</span>
                <span class="doctor-schedule__time">11:00 AM – 6:00 PM</span>
              </div>
              <div class="doctor-schedule__row">
                <span class="doctor-schedule__day">Saturday</span>
                <span class="doctor-schedule__time">11:00 AM – 6:00 PM</span>
              </div>
            </div>

            <div class="doctor-contact">
              <div class="doctor-contact__item">
                <span class="doctor-contact__icon">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 21s7-6.1 7-11.5A7 7 0 0 0 5 9.5C5 14.9 12 21 12 21z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                    <circle cx="12" cy="9.5" r="2.4" stroke="currentColor" stroke-width="1.6"/>
                  </svg>
                </span>
                <div>
                  <p class="doctor-contact__label">Address</p>
                  <p class="doctor-contact__value">234 Oak Drive, Villagetown, USA</p>
                </div>
              </div>

              <div class="doctor-contact__item">
                <span class="doctor-contact__icon">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
                  </svg>
                </span>
                <div>
                  <p class="doctor-contact__label">Call Us</p>
                  <p class="doctor-contact__value">0 123-456-7890</p>
                </div>
              </div>

              <div class="doctor-contact__item">
                <span class="doctor-contact__icon">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 4h16v16H4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                    <path d="m4 6 8 7 8-7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                <div>
                  <p class="doctor-contact__label">Send us a Mail</p>
                  <p class="doctor-contact__value">info@example.com</p>
                </div>
              </div>
            </div>
          </aside>

          <!-- Content -->
          <div>
            <h1 class="doctor-detail__name">Rihana Roy</h1>
            <p class="doctor-detail__specialty">MD, Aesthetic &amp; Reconstructive Medical</p>
            <p class="doctor-detail__desc">
              Dr. Rihana Roy is a pediatrician with an MBBS and M.D. in Medicine, practicing at various medical
              institutions. She specializes in the care of infants, children, and adolescents, addressing a wide
              range of health concerns from routine check-ups to complex medical conditions. Dr. Roy is committed to
              providing compassionate and comprehensive care, ensuring the well-being of her young patients. Her
              practice emphasizes preventive health, early diagnosis, and family-centered treatment approaches. She
              is associated with multiple hospitals, contributing to the healthcare community through her expertise
              and dedication.
            </p>

            <div class="doctor-info-table">
              <div class="doctor-info-table__row">
                <span class="doctor-info-table__label">Specialty</span>
                <span class="doctor-info-table__value">Gynecology</span>
              </div>
              <div class="doctor-info-table__row">
                <span class="doctor-info-table__label">Degrees</span>
                <span class="doctor-info-table__value">MD, Aesthetic &amp; Reconstructive Medical</span>
              </div>
              <div class="doctor-info-table__row">
                <span class="doctor-info-table__label">Experience</span>
                <span class="doctor-info-table__value">30 years, New York Urgent Medical Care Serving California</span>
              </div>
              <div class="doctor-info-table__row">
                <span class="doctor-info-table__label">Awards</span>
                <span class="doctor-info-table__value">World Medical Congress – 2023</span>
              </div>
            </div>

            <h2 class="service-detail__subtitle">Professional Skills</h2>
            <div class="ceo-message__checklist mt-6">
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                Primary Care &amp; Diagnosis
              </span>
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                Chronic Disease Management
              </span>
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                Patient Education &amp; Preventive Health
              </span>
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                Multidisciplinary Collaboration
              </span>
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                Clinical Decision Making
              </span>
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                Basic Emergency Care
              </span>
            </div>

            <h2 class="service-detail__subtitle">My Time Schedule</h2>
            <div class="doctor-schedule-full">
              <div class="doctor-schedule-full__row">
                <span class="doctor-schedule-full__day">Monday</span>
                <span class="doctor-schedule-full__time">11:00 AM – 6:00 PM</span>
              </div>
              <div class="doctor-schedule-full__row">
                <span class="doctor-schedule-full__day">Tuesday</span>
                <span class="doctor-schedule-full__time">11:00 AM – 6:00 PM</span>
              </div>
              <div class="doctor-schedule-full__row">
                <span class="doctor-schedule-full__day">Wednesday</span>
                <span class="doctor-schedule-full__time">11:00 AM – 6:00 PM</span>
              </div>
              <div class="doctor-schedule-full__row">
                <span class="doctor-schedule-full__day">Thursday</span>
                <span class="doctor-schedule-full__time">11:00 AM – 6:00 PM</span>
              </div>
              <div class="doctor-schedule-full__row">
                <span class="doctor-schedule-full__day">Friday</span>
                <span class="doctor-schedule-full__time">11:00 AM – 6:00 PM</span>
              </div>
              <div class="doctor-schedule-full__row">
                <span class="doctor-schedule-full__day">Saturday</span>
                <span class="doctor-schedule-full__time">11:00 AM – 6:00 PM</span>
              </div>
            </div>

            <div class="appointment__card mt-8">
              <form class="appointment__form">
                <div class="appointment__field-group is-half">
                  <input type="text" class="appointment__field" placeholder="First Name" />
                </div>
                <div class="appointment__field-group is-half">
                  <input type="text" class="appointment__field" placeholder="Last Name" />
                </div>
                <div class="appointment__field-group is-half">
                  <input type="email" class="appointment__field" placeholder="Your Email" />
                </div>
                <div class="appointment__field-group is-half">
                  <input type="tel" class="appointment__field" placeholder="Phone Number" />
                </div>
                <div class="appointment__field-group">
                  <textarea class="appointment__field" placeholder="Message" rows="1"></textarea>
                </div>

                <div class="appointment__field-group">
                  <button type="submit" class="appointment__submit">
                    Appointment
                    <span class="appointment__submit-icon">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/frontend/doctor-details.blade.php ENDPATH**/ ?>