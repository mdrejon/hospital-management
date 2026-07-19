<?php $__env->startSection('title', 'ClinicMaster | Medical & Health Care Services'); ?>

<?php $__env->startSection('content'); ?>

    <!-- ===================== Hero ===================== -->
    <?php
      // Dynamic slides from Admin > Global Settings > Hero Slider, falling back
      // to the two static demo slides below when none have been configured yet.
      $heroSlides = $sliders->isNotEmpty()
        ? $sliders->map(fn ($s) => [
            'image'       => $s->background_image ? asset('storage/' . $s->background_image) : asset('assets/img/slider-1.2.jpg'),
            'image_alt'   => $s->title,
            'eyebrow'     => $s->label,
            'title'       => $s->title,
            'accent'      => $s->subtitle,
            'desc'        => $s->description,
            'button_text' => $s->button_text,
            'button_url'  => $s->button_url,
          ])
        : collect([
            [
              'image'       => asset('assets/img/slider-1.2.jpg'),
              'image_alt'   => 'Doctor examining a baby patient',
              'eyebrow'     => 'Wellcome To Medical!',
              'title'       => 'Best of Practice Place Medical',
              'accent'      => 'Doctor',
              'desc'        => "Today, Barry's is on the cusp of continued global expansion with over 100,000 members working out weekly in studios",
              'button_text' => 'Make Appointment',
              'button_url'  => route('appointment'),
            ],
            [
              'image'       => asset('assets/img/slider-1.3.jpg'),
              'image_alt'   => 'Medical team performing a procedure on a patient',
              'eyebrow'     => 'We Care For You',
              'title'       => 'Compassionate Care, Trusted',
              'accent'      => 'Doctors',
              'desc'        => 'Our specialists combine advanced technology with genuine compassion to give every patient the care they deserve.',
              'button_text' => 'Make Appointment',
              'button_url'  => route('appointment'),
            ],
          ]);
    ?>
    <section class="hero" data-hero>
      <div class="hero__viewport">
        <div class="hero__track" data-hero-track>

          <?php $__currentLoopData = $heroSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="hero-slide">
            <img src="<?php echo e($slide['image']); ?>" alt="<?php echo e($slide['image_alt']); ?>" class="hero-slide__bg" />
            <span class="hero-slide__overlay"></span>

            <div class="hero-slide__inner">
              <div class="hero-slide__content" data-hero-content>
                <?php if($slide['eyebrow']): ?>
                <p class="hero-slide__eyebrow">
                  <span class="hero-slide__eyebrow-dot"></span>
                  <?php echo e($slide['eyebrow']); ?>

                  <span class="hero-slide__eyebrow-dot"></span>
                </p>
                <?php endif; ?>
                <h1 class="hero-slide__title">
                  <?php echo e($slide['title']); ?>

                  <?php if($slide['accent']): ?><span class="accent"><?php echo e($slide['accent']); ?></span><?php endif; ?>
                </h1>
                <?php if($slide['desc']): ?>
                <p class="hero-slide__desc">
                  <?php echo e($slide['desc']); ?>

                </p>
                <?php endif; ?>
                <a href="<?php echo e($slide['button_url'] ?: route('appointment')); ?>" class="hero-slide__cta">
                  <?php echo e($slide['button_text'] ?: 'Make Appointment'); ?>

                  <span class="hero-slide__cta-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                    </svg>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Follow-social rail -->
        <div class="hero__social">
          <div class="hero__social-icons">
            <a href="#" class="hero__social-link" aria-label="Instagram">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></svg>
            </a>
            <a href="#" class="hero__social-link" aria-label="Twitter">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 0 1-1.9.1c.5 1.7 2.1 2.9 4 2.9A8.2 8.2 0 0 1 2 18.6a11.6 11.6 0 0 0 6.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z"/></svg>
            </a>
            <a href="#" class="hero__social-link" aria-label="Facebook">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
            </a>
          </div>
          <span class="hero__social-label">Follow Social :</span>
        </div>

        <!-- Vertical dot nav -->
        <div class="hero__dots">
          <span class="hero__dot-tick"></span>
          <?php $__currentLoopData = $heroSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <button type="button" class="hero__dot" data-hero-dot aria-label="Go to slide <?php echo e($i + 1); ?>"></button>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </section>

    <!-- ===================== About Us ===================== -->
    <?php
      $aboutPhoto      = !empty($about['about_photo']) ? asset('storage/' . $about['about_photo']) : asset('assets/img/about-image.webp');
      $aboutHoursTitle = $about['about_hours_title'] ?? 'Open Hours';
      $aboutHours      = !empty($about['about_hours']) ? $about['about_hours'] : [
        ['day' => 'Monday',    'time' => '09:30 - 07:30'],
        ['day' => 'Tuesday',   'time' => '09:30 - 07:30'],
        ['day' => 'Wednesday', 'time' => '09:30 - 07:30'],
        ['day' => 'Thursday',  'time' => '09:30 - 07:30'],
        ['day' => 'Friday',    'time' => '09:30 - 07:30'],
        ['day' => 'Saturday',  'time' => '09:30 - 07:30'],
      ];
      $aboutTitle    = $about['about_title'] ?? 'World Class Patient Facilities Designed For You';
      $aboutDesc     = $about['about_desc'] ?? "Experience the future of healthcare. Our state-of-the-art facilities are equipped with the latest technology, ensuring you receive the world's best quality treatment. Here, cutting-edge tools meet unparalleled expertise, providing a comfortable and effective path to optimal health.";
      $aboutFeatures = !empty($about['about_features']) ? $about['about_features'] : [
        'Comprehensive Specialties', 'Emergency Services', 'Intensive Care Units (ICUs)', 'Telemedicine Facilities', 'Multidisciplinary Team',
        'Research and Development', 'Advanced Imaging Services', 'Rehabilitation Services', 'Patient-Centric Approach', 'Health Information Technology',
      ];
      $aboutFeatureCols = collect($aboutFeatures)->chunk((int) ceil(count($aboutFeatures) / 2));
      $aboutBtnText  = $about['about_more_btn_text'] ?? 'Appointment';
      $aboutBtnUrl   = ($about['about_more_btn_url'] ?? null) ?: route('appointment');
      $aboutPhone    = $headerSettings['header_phone'] ?? '1 123 456 7890';
    ?>
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
              <img src="<?php echo e($aboutPhoto); ?>" alt="Smiling male doctor with arms crossed" class="about__photo" />


              <div class="about__hours-card">
                <span class="about__hours-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                  </svg>
                </span>
                <h3 class="about__hours-title"><?php echo e($aboutHoursTitle); ?></h3>
                <div class="about__hours-list">
                  <?php $__currentLoopData = $aboutHours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="about__hours-row">
                    <span class="about__hours-day"><?php echo e($row['day']); ?></span>
                    <span class="about__hours-time"><?php echo e($row['time']); ?></span>
                  </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </div>
            </div>
          </div>

          <div class="about__content">
            <h2 class="about__title"><?php echo e($aboutTitle); ?></h2>
            <p class="about__desc">
              <?php echo e($aboutDesc); ?>

            </p>

            <div class="about__features">
              <?php $__currentLoopData = $aboutFeatureCols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

            <div class="about__cta-row">
              <a href="<?php echo e($aboutBtnUrl); ?>" class="about__btn">
                <?php echo e($aboutBtnText); ?>

                <span class="about__btn-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>

              <a href="tel:<?php echo e($aboutPhone); ?>" class="about__contact">
                <span class="about__contact-icon">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
                  </svg>
                </span>
                <span class="about__contact-text">
                  <span class="about__contact-label">Contact us?</span>
                  <span class="about__contact-value"><?php echo e($aboutPhone); ?></span>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== Departments ===================== -->
    <?php
      $deptDefaultIcon = '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3s7 7.5 7 12a7 7 0 1 1-14 0c0-4.5 7-12 7-12z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>';
      $deptCards = $featuredServices->isNotEmpty()
        ? $featuredServices->map(fn ($s) => [
            'title'    => $s->title,
            'desc'     => $s->short_desc,
            'icon_svg' => $s->icon_svg,
            'image'    => $s->image ? asset('storage/' . $s->image) : asset('assets/img/slider-1.3.jpg'),
            'url'      => route('service-details', $s->slug),
          ])
        : collect([
            ['title' => 'Haematology',  'desc' => 'Continually evisculate goal-oriented portals rather than prospective channels. Appropriately customize excellent imperatives for mission-critical products.', 'icon_svg' => null, 'image' => asset('assets/img/slider-1.3.jpg'),  'url' => route('services')],
            ['title' => 'Pediatrician', 'desc' => 'Continually evisculate goal-oriented portals rather than prospective channels. Appropriately customize excellent imperatives for mission-critical products.', 'icon_svg' => '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 20s-7-4.5-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 5c-2.5 4.5-9.5 9-9.5 9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M12 9v4M10 11h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>', 'image' => asset('assets/img/slider-1.2.jpg'), 'url' => route('services')],
            ['title' => 'Cardiologist', 'desc' => 'Continually evisculate goal-oriented portals rather than prospective channels. Appropriately customize excellent imperatives for mission-critical products.', 'icon_svg' => '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12h4l2-6 4 12 2-6h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>', 'image' => asset('assets/img/about-image.webp'), 'url' => route('services')],
          ]);
    ?>
    <section class="departments">
      <svg class="departments__decor" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <pattern id="departments-dots" width="10" height="10" patternUnits="userSpaceOnUse">
          <circle cx="2" cy="2" r="2" fill="currentColor" />
        </pattern>
        <rect width="100" height="100" fill="url(#departments-dots)" />
      </svg>

      <div class="departments__banner">
        <img src="<?php echo e(asset('assets/img/slider-1.3.jpg')); ?>" alt="" class="departments__banner-bg" />
        <span class="departments__banner-overlay"></span>

        <div class="departments__head">
          <p class="departments__eyebrow"><?php echo e($svc['svc_badge'] ?? 'Medical & General Care!'); ?></p>
          <h2 class="departments__title"><?php echo e($svc['svc_title'] ?? 'Amazing Services'); ?></h2>
          <p class="departments__desc">
            <?php echo e($svc['svc_desc'] ?? 'Proactively revolutionize granular customer service after pandemic internal or "organic" sources distinctively impact proactive human'); ?>

          </p>
          <a href="<?php echo e(($svc['svc_btn_url'] ?? null) ?: route('services')); ?>" class="btn-services-all" style="margin-top:14px;display:inline-flex;">
            <?php echo e($svc['svc_btn_text'] ?? 'View All Services'); ?>

          </a>
        </div>
      </div>

      <div class="departments__body">
        <div class="departments__slider" data-departments-slider>
          <div class="departments__viewport">
            <div class="departments__track" data-departments-track>

              <?php $__currentLoopData = $deptCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="departments__slide">
                <article class="department-card <?php echo e($i === 1 ? 'is-alt' : ''); ?>">
                  <div class="department-card__body">
                    <h3 class="department-card__title"><?php echo e($card['title']); ?></h3>
                    <p class="department-card__desc">
                      <?php echo e($card['desc']); ?>

                    </p>
                  </div>
                  <div class="department-card__media">
                    <div class="department-card__badge">
                      <span class="department-card__icon">
                        <?php echo $card['icon_svg'] ?: $deptDefaultIcon; ?>

                      </span>
                      <a href="<?php echo e($card['url']); ?>" class="department-card__arrow" aria-label="View <?php echo e($card['title']); ?>">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </a>
                    </div>
                    <img src="<?php echo e($card['image']); ?>" alt="<?php echo e($card['title']); ?>" class="department-card__img" />
                  </div>
                </article>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>

          <button type="button" class="departments__nav is-prev" data-departments-prev aria-label="Previous departments">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m14 6-6 6 6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <button type="button" class="departments__nav is-next" data-departments-next aria-label="Next departments">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m10 6 6 6-6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
        </div>

        <div class="departments__dots" data-departments-dots></div>
 
      </div>
    </section>

    <!-- ===================== Team ===================== -->
    <?php
      $teamCards = $featuredDoctors->isNotEmpty()
        ? $featuredDoctors->map(fn ($d) => [
            'name'     => $d->name,
            'role'     => $d->role,
            'photo'    => $d->photo ? asset('storage/' . $d->photo) : asset('assets/img/team-3.png'),
            'url'      => route('doctor-details', $d->slug),
            'facebook' => $d->facebook_url,
            'youtube'  => $d->youtube_url,
            'linkedin' => $d->linkedin_url,
          ])
        : collect([
            ['name' => 'Dr. Laron Metar',   'role' => 'Practice Service',   'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
            ['name' => 'Dr. Smith Karo',    'role' => 'Founder',            'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
            ['name' => 'Dr. Merata Baron',  'role' => 'Emergency Services', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
            ['name' => 'Dr. Elena Cross',   'role' => 'Cardiologist',       'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
            ['name' => 'Dr. Michael Reyes', 'role' => 'Pediatrician',       'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
            ['name' => 'Dr. Sara Owens',    'role' => 'Neurologist',        'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
          ]);
    ?>
    <section class="team">
      <div class="container mx-auto">
        <div class="team__head">
          <p class="team__eyebrow">
            <span class="team__eyebrow-dot"></span>
            <?php echo e($doc['doc_home_badge'] ?? 'Our Doctor'); ?>

            <span class="team__eyebrow-dot"></span>
          </p>
          <h2 class="team__title"><?php echo e($doc['doc_home_title'] ?? 'Meet Our Doctor'); ?></h2>
        </div>

        <div class="team__slider" data-team-slider>
          <div class="team__viewport">
            <div class="team__track" data-team-track>

              <?php $__currentLoopData = $teamCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="team__slide">
                <article class="team-card">
                  <span class="team-card__corner" aria-hidden="true"></span>

                  <div class="team-card__photo-wrap">
                    <img src="<?php echo e($card['photo']); ?>" alt="<?php echo e($card['name']); ?>" class="team-card__photo" />
                    <span class="team-card__overlay">
                      <a href="<?php echo e($card['url']); ?>" class="team-card__view" aria-label="View <?php echo e($card['name']); ?> profile">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="m10 6 6 6-6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </a>
                    </span>
                  </div>

                  <div class="team-card__social">
                    <a href="<?php echo e($card['facebook'] ?: '#'); ?>" class="team-card__social-link" aria-label="Facebook">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
                    </a>
                    <a href="#" class="team-card__social-link" aria-label="Pinterest">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.5 2 3 5.9 3 10.2c0 2.6 1.4 4.6 3.5 5.4.3.1.6 0 .7-.4l.3-1.1c.1-.3 0-.5-.2-.8-.5-.6-.9-1.5-.9-2.7 0-3.5 2.6-6.6 6.8-6.6 3.7 0 5.7 2.3 5.7 5.3 0 4-1.8 7.4-4.4 7.4-1.5 0-2.6-1.2-2.2-2.7.4-1.7 1.2-3.6 1.2-4.9 0-1.1-.6-2.1-1.9-2.1-1.5 0-2.7 1.6-2.7 3.6 0 1.3.4 2.2.4 2.2l-1.8 7.5c-.5 2.2-.1 4.9 0 5.2 0 .2.2.2.3.1.1-.2 1.7-2.1 2.3-4.1l.9-3.4c.4.8 1.7 1.5 3.1 1.5 4.1 0 6.9-3.7 6.9-8.7C21 5.8 17.3 2 12 2z"/></svg>
                    </a>
                    <a href="<?php echo e($card['youtube'] ?: '#'); ?>" class="team-card__social-link" aria-label="YouTube">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M23 12s0-3.6-.5-5.3c-.3-1-1-1.8-2-2C18.9 4.2 12 4.2 12 4.2s-6.9 0-8.5.5c-1 .3-1.7 1-2 2C1 8.4 1 12 1 12s0 3.6.5 5.3c.3 1 1 1.8 2 2 1.6.5 8.5.5 8.5.5s6.9 0 8.5-.5c1-.3 1.7-1 2-2 .5-1.7.5-5.3.5-5.3zM9.8 15.5V8.5l6.2 3.5-6.2 3.5z"/></svg>
                    </a>
                    <a href="<?php echo e($card['linkedin'] ?: '#'); ?>" class="team-card__social-link" aria-label="LinkedIn">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>
                    </a>
                  </div>

                  <div class="team-card__body">
                    <h3 class="team-card__name"><?php echo e($card['name']); ?></h3>
                    <p class="team-card__role"><?php echo e($card['role']); ?></p>
                  </div>
                </article>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>

          <button type="button" class="team__nav is-prev" data-team-prev aria-label="Previous doctors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m14 6-6 6 6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <button type="button" class="team__nav is-next" data-team-next aria-label="Next doctors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m10 6 6 6-6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
        </div>

        <div class="team__dots" data-team-dots></div>
      </div>
    </section>

    <!-- ===================== Why Choose Us ===================== -->
    <?php
      $whyTitle = $about['why_title'] ?? 'Why Choose Us For Your Health Care Needs';
      $whyFeatures = !empty($about['why_features']) ? $about['why_features'] : [
        ['icon_svg' => null, 'title' => 'More Experience',       'description' => 'Our team of highly qualified specialists delivers exceptional care with years of experience.'],
        ['icon_svg' => null, 'title' => 'Seamless Care',         'description' => 'State-of-the-art medical equipment and cutting-edge technology for accurate diagnosis.'],
        ['icon_svg' => null, 'title' => 'The Right Answers',     'description' => 'Round-the-clock emergency services with rapid response teams always on standby.'],
        ['icon_svg' => null, 'title' => 'Unparalleled Expertise','description' => 'Quality healthcare at competitive prices with transparent billing and insurance support.'],
      ];
      $whyCheckIcon = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
    ?>
    <section class="why-choose">
      <div class="container mx-auto">
        <div class="why-choose__grid">

          <!-- Media -->
          <div class="why-choose__media">
            <div class="why-choose__photo">
              <img src="<?php echo e(asset('assets/img/choose-us-image.webp')); ?>" alt="Why choose us" class="why-choose__photo-img" />
            </div>
            <div class="why-choose__badge">
              <span class="why-choose__badge-number">20+</span>
              <span class="why-choose__badge-label">Years Experienced</span>
            </div>
          </div>

          <!-- Content -->
          <div class="why-choose__content">
            <h2 class="why-choose__title">
              <?php echo e($whyTitle); ?>

            </h2>

            <div class="why-choose__features">
              <?php $__currentLoopData = $whyFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="why-choose__feature">
                <span class="why-choose__feature-icon">
                  <?php echo $feature['icon_svg'] ?: $whyCheckIcon; ?>

                </span>
                <div class="why-choose__feature-text">
                  <h3 class="why-choose__feature-title"><?php echo e($feature['title']); ?></h3>
                  <p class="why-choose__feature-desc">
                    <?php echo e($feature['description']); ?>

                  </p>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ===================== Health Packages ===================== -->
    <?php
      $packageCards = $featuredPackages->isNotEmpty()
        ? $featuredPackages->map(fn ($p) => [
            'title' => $p->title,
            'desc'  => $p->short_desc,
            'image' => $p->image ? asset('storage/' . $p->image) : asset('assets/img/sr-1-2.jpg'),
            'url'   => route('package-details', $p->slug),
          ])
        : collect([
            ['title' => 'Full Body Checkup',          'desc' => 'Comprehensive screening to catch health issues early.',       'image' => asset('assets/img/sr-1-2.jpg'),      'url' => route('packages')],
            ['title' => 'Dermatology & Wellness',      'desc' => 'Specialized skin and wellness treatments for every age.',      'image' => asset('assets/img/sr-1-3.jpg'),      'url' => route('packages')],
            ['title' => 'Cardiac Care Package',        'desc' => 'Complete heart health evaluation and monitoring.',             'image' => asset('assets/img/about-image.webp'),'url' => route('packages')],
            ['title' => 'Pediatric Care Package',      'desc' => 'Gentle, thorough checkups designed for children.',             'image' => asset('assets/img/slider-1.2.jpg'),  'url' => route('packages')],
            ['title' => 'Surgical Care Package',       'desc' => 'Pre and post-operative care from expert surgeons.',            'image' => asset('assets/img/sr-1-1.jpg'),      'url' => route('packages')],
            ['title' => 'Emergency Response Package',  'desc' => 'Round-the-clock critical care when it matters most.',          'image' => asset('assets/img/slider-1.3.jpg'),  'url' => route('packages')],
          ]);
    ?>
    <section class="packages">
      <div class="packages__head">
        <p class="packages__eyebrow">
          <span class="packages__eyebrow-dot"></span>
          <?php echo e($pkg['pkg_badge'] ?? 'Our Health Packages'); ?>

          <span class="packages__eyebrow-dot"></span>
        </p>
        <h2 class="packages__title">
          <?php echo e($pkg['pkg_title'] ?? 'Best Medical Assistance Packages'); ?>

        </h2>
      </div>

      <div class="packages__slider" data-packages-slider>
        <div class="packages__viewport">
          <div class="packages__track" data-packages-track>

            <?php $__currentLoopData = $packageCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="packages__slide">
              <article class="package-card group">
                <img src="<?php echo e($card['image']); ?>" alt="<?php echo e($card['title']); ?>" class="package-card__img" />
                <span class="package-card__overlay"></span>
                <a href="<?php echo e($card['url']); ?>" class="package-card__plus" aria-label="View <?php echo e($card['title']); ?> package">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                  </svg>
                </a>
                <div class="package-card__caption">
                  <h3 class="package-card__title"><?php echo e($card['title']); ?></h3>
                  <p class="package-card__desc"><?php echo e($card['desc']); ?></p>
                </div>
              </article>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>

        <button type="button" class="packages__nav is-prev" data-packages-prev aria-label="Previous packages">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="m14 6-6 6 6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <button type="button" class="packages__nav is-next" data-packages-next aria-label="Next packages">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="m10 6 6 6-6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>

      <div class="packages__dots" data-packages-dots></div>
    </section>
 
     <!-- ===================== FAQ ===================== -->
    <section class="faq">
      <img src="<?php echo e(asset('assets/img/faq-bg.png')); ?>" alt="" class="faq__bg" aria-hidden="true" />

      <div class="container relative mx-auto">
        <div class="faq__grid">
          <div class="faq__copy">
            <h2 class="faq__title">Frequently Asked Questions</h2>
            <p class="faq__desc">
              It is a long established fact that a reader will be distracted by the readable content of a page when
              looking at its layout.
            </p>

            <div class="faq__list">
              <?php
                $homeFaqDefaults = [
                  ['question' => 'What types of treatments do you offer?', 'answer' => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its. The point of using Lorem Ipsum is that it has a more-or-less normal distribution"],
                  ['question' => 'How do i book my appointment ?', 'answer' => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its. The point of using Lorem Ipsum is that it has a more-or-less normal distribution"],
                  ['question' => 'Can i cancel my appointment', 'answer' => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its. The point of using Lorem Ipsum is that it has a more-or-less normal distribution"],
                  ['question' => 'How much do you charge for pedicure ?', 'answer' => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its. The point of using Lorem Ipsum is that it has a more-or-less normal distribution"],
                ];
                $homeFaqCards = (isset($homeFaqs) && $homeFaqs->isNotEmpty()) ? $homeFaqs : collect($homeFaqDefaults);
              ?>
              <?php $__currentLoopData = $homeFaqCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faqIndex => $faqCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="faq-item <?php if($faqIndex === 0): ?> is-open <?php endif; ?>">
                  <button type="button" class="faq-item__question" data-faq-toggle>
                    <?php echo e($faqCard['question'] ?? ''); ?>

                    <span class="faq-item__icon">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                  </button>
                  <div class="faq-item__answer">
                    <p><?php echo e($faqCard['answer'] ?? ''); ?></p>
                  </div>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>

          <div class="faq__media">
            <img src="<?php echo e(asset('assets/img/faq.webp')); ?>" alt="Smiling doctor on a call, ready to answer your questions" class="faq__photo" />

            <div class="faq__contact-card">
              <div class="faq__contact-info">
                <span class="faq__contact-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
                  </svg>
                </span>
                <div>
                  <p class="faq__contact-label">Contact us?</p>
                  <p class="faq__contact-value">1 123 456 7890</p>
                </div>
              </div>

              <a href="<?php echo e(route('appointment')); ?>" class="faq__contact-btn">
                Appointment
                <span class="faq__contact-btn-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ===================== Testimonials ===================== -->
    <section class="testimonials">
      <img src="<?php echo e(asset('assets/img/bg-testimonial.webp')); ?>" alt="" class="testimonials__bg" aria-hidden="true" />
      <span class="testimonials__overlay" aria-hidden="true"></span>

      <div class="container relative mx-auto">
        <div class="testimonials__grid">
          <div class="testimonials__media">
            <span class="testimonials__ring"></span>
            <span class="testimonials__ring is-inner"></span>
            <span class="testimonials__orbit" aria-hidden="true"><span class="testimonials__ping"></span></span>
            <span class="testimonials__orbit is-slow" aria-hidden="true"><span class="testimonials__ping"></span></span>
            <span class="testimonials__orbit is-reverse" aria-hidden="true"><span class="testimonials__ping"></span></span>
            <?php
              $testiImage    = !empty($testi['testi_image']) ? asset('storage/' . $testi['testi_image']) : asset('assets/img/1752043437.img2.png');
              $testiImageAlt = ($testi['testi_image_alt'] ?? null) ?: 'Doctor smiling with arms crossed';
            ?>
            <img
              src="<?php echo e($testiImage); ?>"
              alt="<?php echo e($testiImageAlt); ?>"
              class="testimonials__photo"
            />
          </div>

          <div class="testimonials__content">
            <h2 class="testimonials__title"><?php echo e(($testi['testi_title'] ?? null) ?: 'Real Patients, Real Stories. And Our Achievements'); ?></h2>

            <div class="testimonial-slider" data-testimonials-slider>
              <button type="button" class="testimonials__nav is-prev" data-testimonials-prev aria-label="Previous testimonial">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M19 12H5M11 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
              <button type="button" class="testimonials__nav is-next" data-testimonials-next aria-label="Next testimonial">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>

              <div class="testimonial-slider__viewport">
                <div class="testimonial-slider__track" data-testimonials-track>
                <?php
                  $homeTestimonialDefaults = [
                    ['name' => 'Emma Carter', 'role' => 'Patient', 'avatar' => asset('assets/img/sr-1-2.jpg'), 'title' => 'Best Treatment', 'review' => "From the first visit, I felt completely at ease. The staff was warm, patient, and incredibly supportive. They took time to listen and explain everything clearly. Their kindness made a real difference in my recovery. I'm thankful for such a caring team."],
                    ['name' => 'Rihana Roy', 'role' => 'Patient', 'avatar' => asset('assets/img/sr-1-3.jpg'), 'title' => 'Caring Staff', 'review' => "My experience here was nothing short of amazing. The team treated me with kindness and genuine care. Every step of my treatment was handled with professionalism. I felt heard, supported, and completely at ease. I'm truly grateful for the care I received."],
                    ['name' => 'Daniel Cruz', 'role' => 'Patient', 'avatar' => asset('assets/img/projects-2.jpg'), 'title' => 'Compassionate Care', 'review' => "The team walked me through every step before they even touched an instrument. What could have been stressful turned into the calmest checkup I've ever had. I finally look forward to my visits."],
                  ];
                  $homeTestimonialCards = (isset($testimonials) && $testimonials->isNotEmpty())
                    ? $testimonials->map(fn($t) => ['name' => $t->name, 'role' => $t->role, 'avatar' => $t->avatar ? asset('storage/' . $t->avatar) : asset('assets/img/sr-1-2.jpg'), 'title' => null, 'review' => $t->review])
                    : collect($homeTestimonialDefaults);
                ?>
                <?php $__currentLoopData = $homeTestimonialCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="testimonial-card">
                  <div class="testimonial-card__media">
                    <div class="testimonial-card__photo-wrap">
                      <img src="<?php echo e($tCard['avatar']); ?>" alt="<?php echo e($tCard['name']); ?>" class="testimonial-card__photo" />
                      <button type="button" class="testimonial-card__play">
                        <span class="testimonial-card__play-icon">
                          <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                        </span>
                        Watch The Video
                      </button>
                    </div>
                    <p class="testimonial-card__name"><?php echo e($tCard['name']); ?></p>
                    <p class="testimonial-card__role"><?php echo e($tCard['role']); ?></p>
                  </div>

                  <div class="testimonial-card__body">
                    <?php if($tCard['title']): ?>
                      <h3 class="testimonial-card__title"><?php echo e($tCard['title']); ?></h3>
                    <?php endif; ?>
                    <p class="testimonial-card__quote">
                      <?php echo e($tCard['review']); ?>

                    </p>

                    <span class="testimonial-card__mark" aria-hidden="true">
                      <span class="testimonial-card__mark-ring"></span>
                      <span class="testimonial-card__mark-ring is-offset"></span>
                    </span>
                  </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </div>
            </div>

            <div class="testimonials__dots" data-testimonials-dots></div>
          </div>
        </div>
      </div>
    </section>


    <!-- ===================== Awards ===================== -->
    <section class="awards">
      <div class="container mx-auto">
        <div class="awards__grid">
          <div class="awards__intro">
            <h2 class="awards__title"><?php echo e(($award['award_title'] ?? null) ?: 'Awards'); ?></h2>
            <p class="awards__desc">
              <?php echo e(($award['award_desc'] ?? null) ?: 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'); ?>

            </p>
          </div>

          <div class="awards__slider" data-awards-slider>
            <div class="awards__track" data-awards-track>
              <?php
                $homeAwardDefaults = [
                  ['title' => 'ClinicMaster 2024', 'subtitle' => 'Quality and Accreditation Institute', 'link_text' => 'Save the Children', 'link_url' => '#', 'seal_variant' => 1],
                  ['title' => 'ClinicMaster 2024', 'subtitle' => 'Quality and Accreditation Institute', 'link_text' => 'Save the Children', 'link_url' => '#', 'seal_variant' => 2],
                  ['title' => 'ClinicMaster 2024', 'subtitle' => 'Quality and Accreditation Institute', 'link_text' => 'Save the Children', 'link_url' => '#', 'seal_variant' => 3],
                  ['title' => 'ClinicMaster 2024', 'subtitle' => 'Quality and Accreditation Institute', 'link_text' => 'Save the Children', 'link_url' => '#', 'seal_variant' => 1],
                  ['title' => 'ClinicMaster 2024', 'subtitle' => 'Quality and Accreditation Institute', 'link_text' => 'Save the Children', 'link_url' => '#', 'seal_variant' => 2],
                  ['title' => 'ClinicMaster 2024', 'subtitle' => 'Quality and Accreditation Institute', 'link_text' => 'Save the Children', 'link_url' => '#', 'seal_variant' => 3],
                ];
                $homeAwardCards = (isset($featuredAwards) && $featuredAwards->isNotEmpty())
                  ? $featuredAwards->map(fn($a) => ['title' => $a->title, 'subtitle' => $a->subtitle, 'link_text' => $a->link_text, 'link_url' => $a->link_url ?: '#', 'seal_variant' => $a->seal_variant])
                  : collect($homeAwardDefaults);
              ?>
              <?php $__currentLoopData = $homeAwardCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $awardCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="award-card">
                <?php if(($awardCard['seal_variant'] ?? 1) === 1): ?>
                <svg class="award-card__seal" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M48 4 86 26v44L48 92 10 70V26z" stroke="currentColor" stroke-width="1.6"/>
                  <text x="48" y="46" text-anchor="middle" font-size="14" font-weight="800" fill="currentColor">WHO</text>
                  <text x="48" y="56" text-anchor="middle" font-size="6" fill="currentColor" opacity="0.7">Medizone</text>
                  <text x="48" y="64" text-anchor="middle" font-size="6" fill="currentColor" opacity="0.7">2024</text>
                  <text x="17" y="22" font-size="9" fill="currentColor">★</text>
                  <text x="72" y="22" font-size="9" fill="currentColor">★</text>
                  <text x="17" y="82" font-size="9" fill="currentColor">★</text>
                  <text x="72" y="82" font-size="9" fill="currentColor">★</text>
                </svg>
                <?php elseif(($awardCard['seal_variant'] ?? 1) === 2): ?>
                <svg class="award-card__seal" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="1.6" stroke-dasharray="3 4"/>
                  <circle cx="48" cy="48" r="32" stroke="currentColor" stroke-width="1.2"/>
                  <path d="M38 36 42 42 48 34 54 42 58 36 56 46H40z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
                  <text x="48" y="56" text-anchor="middle" font-size="12" font-weight="800" fill="currentColor">WHO</text>
                  <text x="48" y="64" text-anchor="middle" font-size="5.5" fill="currentColor" opacity="0.7">Medizone</text>
                  <text x="48" y="71" text-anchor="middle" font-size="5.5" fill="currentColor" opacity="0.7">2024</text>
                </svg>
                <?php else: ?>
                <svg class="award-card__seal" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="48" cy="48" r="36" stroke="currentColor" stroke-width="1.6"/>
                  <path d="M18 40c6 20 10 30 20 36M78 40c-6 20-10 30-20 36" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                  <path d="M20 44c4 2 8 2 12-1M76 44c-4 2-8 2-12-1M22 56c4 1 8 0 11-3M74 56c-4 1-8 0-11-3M26 66c3 1 6 0 8-2M70 66c-3 1-6 0-8-2" stroke="currentColor" stroke-width="1.1" stroke-linecap="round"/>
                  <text x="48" y="44" text-anchor="middle" font-size="12" font-weight="800" fill="currentColor">WHO</text>
                  <text x="48" y="53" text-anchor="middle" font-size="5.5" fill="currentColor" opacity="0.7">Medizone</text>
                  <text x="48" y="60" text-anchor="middle" font-size="5.5" fill="currentColor" opacity="0.7">2024</text>
                </svg>
                <?php endif; ?>
                <h3 class="award-card__title"><?php echo e($awardCard['title']); ?></h3>
                <p class="award-card__subtitle"><?php echo e($awardCard['subtitle']); ?></p>
                <?php if($awardCard['link_text']): ?>
                  <a href="<?php echo e($awardCard['link_url'] ?: '#'); ?>" class="award-card__link"><?php echo e($awardCard['link_text']); ?></a>
                <?php endif; ?>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== Blog ===================== -->
    <?php
      $blogFallbackImages = [asset('assets/img/blog-one.png'), asset('assets/img/blog-2.png'), null, asset('assets/img/blog-4.jpg')];
      $blogCards = $latestBlogs->isNotEmpty()
        ? $latestBlogs->values()->map(fn ($b, $i) => [
            'title' => $b->title,
            'date'  => ($b->published_at ?: $b->created_at)->format('F j, Y'),
            'image' => $b->feature_image ? asset('storage/' . $b->feature_image) : ($blogFallbackImages[$i % 4] ?? asset('assets/img/blog-2.png')),
            'url'   => route('blog-details', $b->slug),
          ])
        : collect([
            ['title' => 'The Skincare Routine That Works Expert Tips.', 'date' => 'July 6, 2025', 'image' => asset('assets/img/blog-one.png'), 'url' => '#'],
            ['title' => 'The Art of Managing Business and Patient Care', 'date' => 'July 9, 2025', 'image' => asset('assets/img/blog-2.png'), 'url' => '#'],
            ['title' => 'Strategies for Balancing Business Demands wit …', 'date' => 'July 9, 2025', 'image' => null, 'url' => '#'],
            ['title' => 'Effective Healthcare Tips', 'date' => 'July 9, 2025', 'image' => asset('assets/img/blog-4.jpg'), 'url' => '#'],
          ]);
    ?>
    <section class="blog">
      <div class="container mx-auto">
        <div class="blog__head">
          <h2 class="blog__title"><?php echo e($blog['blog_home_title'] ?? 'Stay Informed With Our Latest Health Blogs'); ?></h2>
          <a href="<?php echo e(route('blog-list')); ?>" class="btn-view-all">
            View All
            <span class="btn-view-all__icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </a>
        </div>

        <div class="blog__grid">
          <?php $__currentLoopData = $blogCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($loop->index === 0): ?>
            <!-- Card A: full-bleed photo with a dark navy title overlaid at
                 the top over a soft white scrim (so it stays legible no
                 matter what's behind it) and a Read More CTA at the bottom,
                 mirroring cards B/D's overlay pattern but light-on-photo. -->
            <article class="blog-card blog-card--split is-tall">
              <img src="<?php echo e($card['image']); ?>" alt="<?php echo e($card['title']); ?>" class="blog-card__img" />
              <span class="blog-card--split__scrim" aria-hidden="true"></span>
              <div class="blog-card--split__top">
                <span class="blog-card__date"><span class="blog-card__date-dot"></span><?php echo e($card['date']); ?></span>
                <h3 class="blog-card--split__title"><?php echo e($card['title']); ?></h3>
              </div>
              <a href="<?php echo e($card['url']); ?>" class="blog-card--split__cta">
                Read More
                <span class="blog-card--split__cta-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
              <span class="blog-card--split__bubble"></span>
            </article>
            <?php elseif($loop->index === 2): ?>
            <!-- Card C: plain copy card, no image -->
            <article class="blog-card blog-card--plain">
              <div>
                <span class="blog-card__date"><span class="blog-card__date-dot"></span><?php echo e($card['date']); ?></span>
                <h3 class="blog-card--plain__title"><?php echo e($card['title']); ?></h3>
              </div>
              <div class="blog-card--plain__footer">
                <a href="<?php echo e($card['url']); ?>" class="blog-card__arrow" aria-label="Read more">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
              </div>
            </article>
            <?php else: ?>
            <!-- Card B/D: full-bleed photo, overlay content -->
            <article class="blog-card blog-card--photo <?php echo e($loop->index === 1 ? 'is-tall' : ''); ?>">
              <img src="<?php echo e($card['image']); ?>" alt="<?php echo e($card['title']); ?>" class="blog-card__img" <?php if($loop->index === 1): ?> style="object-position: 50% 20%;" <?php endif; ?> />
              <span class="blog-card__overlay"></span>
              <span class="blog-card__date relative z-10 w-fit"><span class="blog-card__date-dot"></span><?php echo e($card['date']); ?></span>
              <div class="blog-card--photo__footer">
                <h3 class="blog-card--photo__title"><?php echo e($card['title']); ?></h3>
                <a href="<?php echo e($card['url']); ?>" class="blog-card__arrow" aria-label="Read more">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
              </div>
            </article>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </section>

    <!-- ===================== Make an Appointment ===================== -->
    <?php if (isset($component)) { $__componentOriginald60bc4ce403b880ef3c1cf57c71fbc24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald60bc4ce403b880ef3c1cf57c71fbc24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.book-appointment','data' => ['settings' => $appt,'doctors' => $appointmentDoctors,'departments' => $appointmentDepartments,'source' => 'home']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.book-appointment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['settings' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($appt),'doctors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($appointmentDoctors),'departments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($appointmentDepartments),'source' => 'home']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald60bc4ce403b880ef3c1cf57c71fbc24)): ?>
<?php $attributes = $__attributesOriginald60bc4ce403b880ef3c1cf57c71fbc24; ?>
<?php unset($__attributesOriginald60bc4ce403b880ef3c1cf57c71fbc24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald60bc4ce403b880ef3c1cf57c71fbc24)): ?>
<?php $component = $__componentOriginald60bc4ce403b880ef3c1cf57c71fbc24; ?>
<?php unset($__componentOriginald60bc4ce403b880ef3c1cf57c71fbc24); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\frontend\home.blade.php ENDPATH**/ ?>