<?php
  $heroImage = !empty($svc['svc_page_hero_image']) ? asset('storage/' . $svc['svc_page_hero_image']) : asset('assets/img/breadcumb.webp');
  $seoTitle  = $service->seo_title ?: ($svc['svc_seo_title'] ?? null) ?: ($service->title . ' | ClinicMaster Medical & Health Care Services');
  $seoDesc   = $service->seo_description ?: ($svc['svc_seo_description'] ?? null) ?: $service->short_desc ?: 'Learn more about this service at ClinicMaster.';
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>
<?php if(!empty($service->seo_keywords)): ?>
<?php $__env->startSection('meta_keywords', $service->seo_keywords); ?>
<?php elseif(!empty($svc['svc_seo_keywords'])): ?>
<?php $__env->startSection('meta_keywords', $svc['svc_seo_keywords']); ?>
<?php endif; ?>
<?php if(!empty($service->seo_og_image)): ?>
<?php $__env->startSection('og_image', asset('storage/' . $service->seo_og_image)); ?>
<?php elseif(!empty($svc['svc_seo_og_image'])): ?>
<?php $__env->startSection('og_image', asset('storage/' . $svc['svc_seo_og_image'])); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>

    <!-- ===================== Breadcrumb / Page header ===================== -->
    <section class="page-header">
      <div class="page-header__media">
        <img src="<?php echo e($heroImage); ?>" alt="Team of ClinicMaster doctors" class="page-header__bg" />
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
        <h1 class="page-header__title">Service Details</h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="<?php echo e(route('home')); ?>">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <a href="<?php echo e(route('services')); ?>">Services</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span><?php echo e($service->title); ?></span>
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
    <!-- ===================== Service Detail ===================== -->
    <section class="service-detail">
      <div class="container mx-auto">
        <div class="service-detail__grid">
          <!-- Sidebar -->
          <aside class="service-sidebar">
            <nav class="service-sidebar__nav">
              <h3 class="service-sidebar__title">All Services</h3>

              <?php $__currentLoopData = $allServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <a href="<?php echo e(route('service-details', $s->slug)); ?>" class="service-sidebar__link <?php echo e($s->id === $service->id ? 'is-active' : ''); ?>">
                <?php echo e($s->title); ?>

                <span class="service-sidebar__link-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>

            <div class="service-sidebar__help">
              <span class="service-sidebar__help-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M21 11.5a8.4 8.4 0 0 1-3.8 7 8.4 8.4 0 0 1-9.1.2L4 20l1.4-3.7A8.4 8.4 0 0 1 12.5 3a8.5 8.5 0 0 1 8.5 8.5z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                  <path d="M8.5 10.5h7M8.5 14h4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
              </span>
              <h4 class="service-sidebar__help-title"><?php echo e($svc['svc_help_title'] ?? 'Do you need any help?'); ?></h4>
              <div class="service-sidebar__help-divider"></div>
              <div class="service-sidebar__help-contact">
                <p><?php echo e($headerSettings['header_phone'] ?? '1 123 456 7890'); ?></p>
                <p><?php echo e($headerSettings['header_email'] ?? 'sales@smartfreamework.com'); ?></p>
              </div>
              <a href="<?php echo e(route('contact')); ?>" class="service-sidebar__help-btn">
                Contact Us
                <span class="service-sidebar__help-btn-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
            </div>
          </aside>

          <!-- Content -->
          <?php
            $serviceFeatures = !empty($service->features) ? $service->features : [
              'Comprehensive Specialties', 'Emergency Services', 'Intensive Care Units (ICUs)', 'Telemedicine Facilities', 'Multidisciplinary Team',
              'Research and Development', 'Advanced Imaging Services', 'Rehabilitation Services', 'Patient-Centric Approach', 'Health Information Technology',
            ];
            $serviceFeatureCols = collect($serviceFeatures)->chunk((int) ceil(count($serviceFeatures) / 2));
          ?>
          <div>
            <h1 class="service-detail__title"><?php echo e($service->title); ?></h1>
            <p class="service-detail__desc">
              <?php if($service->description): ?>
                <?php echo $service->description; ?>

              <?php else: ?>
                <?php echo e($service->short_desc ?: 'Learn more about our ' . $service->title . ' service and how our specialists can help you.'); ?>

              <?php endif; ?>
            </p>

            <h2 class="service-detail__subtitle">Steps in <?php echo e($service->title); ?></h2>
            <div class="about__features">
              <?php $__currentLoopData = $serviceFeatureCols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div>
                <?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="about__feature">
                  <span class="about__feature-check">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  <?php echo e($feature); ?>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <h2 class="service-detail__subtitle">Available Doctors</h2>
            <?php
              $serviceDoctorDefaults = [
                ['name' => 'Rihana Roy',      'role' => 'Senior Cardiologist',        'photo' => asset('assets/img/team-3.png'), 'url' => route('doctors'), 'facebook' => null, 'instagram' => null, 'linkedin' => null],
                ['name' => 'Danial Frankie',  'role' => 'Interventional Cardiologist', 'photo' => asset('assets/img/team-3.png'), 'url' => route('doctors'), 'facebook' => null, 'instagram' => null, 'linkedin' => null],
                ['name' => 'Kenneth Fong',    'role' => 'Cardiac Surgeon',            'photo' => asset('assets/img/team-3.png'), 'url' => route('doctors'), 'facebook' => null, 'instagram' => null, 'linkedin' => null],
                ['name' => 'Nashla Martines', 'role' => 'Vascular Specialist',         'photo' => asset('assets/img/team-3.png'), 'url' => route('doctors'), 'facebook' => null, 'instagram' => null, 'linkedin' => null],
              ];
              $serviceDoctorCards = (isset($serviceDoctors) && $serviceDoctors->isNotEmpty())
                ? $serviceDoctors->map(fn($d) => [
                    'name'      => $d->name,
                    'role'      => $d->role,
                    'photo'     => $d->photo ? asset('storage/' . $d->photo) : asset('assets/img/team-3.png'),
                    'url'       => route('doctor-details', $d->slug),
                    'facebook'  => $d->facebook_url,
                    'instagram' => $d->instagram_url,
                    'linkedin'  => $d->linkedin_url,
                  ])
                : collect($serviceDoctorDefaults);
            ?>
            <div class="service-doctors">
              <?php $__currentLoopData = $serviceDoctorCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <article class="team-card">
                <span class="team-card__corner" aria-hidden="true"></span>

                <div class="team-card__photo-wrap">
                  <img src="<?php echo e($sd['photo']); ?>" alt="Dr. <?php echo e($sd['name']); ?>" class="team-card__photo" />
                  <span class="team-card__overlay">
                    <a href="<?php echo e($sd['url']); ?>" class="team-card__view" aria-label="View Dr. <?php echo e($sd['name']); ?> profile">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m10 6 6 6-6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </a>
                  </span>
                </div>

                <div class="team-card__social">
                  <a href="<?php echo e($sd['facebook'] ?: '#'); ?>" class="team-card__social-link" aria-label="Facebook">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
                  </a>
                  <a href="<?php echo e($sd['instagram'] ?: '#'); ?>" class="team-card__social-link" aria-label="Instagram">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></svg>
                  </a>
                  <a href="<?php echo e($sd['linkedin'] ?: '#'); ?>" class="team-card__social-link" aria-label="LinkedIn">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>
                  </a>
                  <a href="#" class="team-card__social-link" aria-label="X">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M18.3 3H21l-6.4 7.3L22 21h-6.5l-5-6.6-5.8 6.6H2l6.9-7.9L2 3h6.6l4.6 6.1L18.3 3zM17.2 19h1.5L7.9 4.9H6.3L17.2 19z"/></svg>
                  </a>
                </div>

                <div class="team-card__body">
                  <h3 class="team-card__name"><?php echo e($sd['name']); ?></h3>
                  <p class="team-card__role"><?php echo e($sd['role']); ?></p>
                </div>
              </article>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <h2 class="service-detail__subtitle">Frequently asked questions</h2>
            <?php
              $serviceFaqs = !empty($service->faqs) ? $service->faqs : [
                ['question' => 'Can I cancel my appointment', 'answer' => 'Yes, appointments can be cancelled or rescheduled up to 24 hours in advance by contacting our front desk or through your patient portal.'],
                ['question' => 'What types of treatments do you offer?', 'answer' => 'Our specialists offer a full range of diagnostic, preventive, and treatment options tailored to each patient\'s needs.'],
                ['question' => 'How do I book my appointment?', 'answer' => 'You can book an appointment online through our Appointment page, or call our front desk directly.'],
                ['question' => 'Do you accept health insurance?', 'answer' => 'We accept most major health insurance plans. Please contact our billing team to confirm your specific coverage.'],
              ];
            ?>
            <div class="faq__list mt-8">
              <?php $__currentLoopData = $serviceFaqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="faq-item <?php echo e($i === 0 ? 'is-open' : ''); ?>">
                <button type="button" class="faq-item__question" data-faq-toggle>
                  <?php echo e($faq['question']); ?>

                  <span class="faq-item__icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                </button>
                <div class="faq-item__answer">
                  <p>
                    <?php echo e($faq['answer']); ?>

                  </p>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/frontend/service-details.blade.php ENDPATH**/ ?>