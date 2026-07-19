<?php
  $heroTitle = $ach['ach_hero_title'] ?? 'Our Achievements';
  $heroImage = !empty($ach['ach_hero_image']) ? asset('storage/' . $ach['ach_hero_image']) : asset('assets/img/breadcumb.webp');
  $seoTitle  = $ach['ach_seo_title'] ?? 'Our Achievements | ClinicMaster Medical & Health Care Services';
  $seoDesc   = $ach['ach_seo_description'] ?? "Explore ClinicMaster's awards, accreditations, and commitment to patient care.";
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>
<?php if(!empty($ach['ach_seo_keywords'])): ?>
<?php $__env->startSection('meta_keywords', $ach['ach_seo_keywords']); ?>
<?php endif; ?>
<?php if(!empty($ach['ach_seo_og_image'])): ?>
<?php $__env->startSection('og_image', asset('storage/' . $ach['ach_seo_og_image'])); ?>
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
        <h1 class="page-header__title"><?php echo e($heroTitle); ?></h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="<?php echo e(route('home')); ?>">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span>Our Achievements</span>
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

    <!-- ===================== Always Ready To Help ===================== -->
    <?php
      $readyHelpItems = !empty($ach['ach_items']) ? $ach['ach_items'] : [
        ['title' => 'Emergency Help',    'desc' => 'Round-the-clock ambulance and emergency response, ready whenever you need us most.'],
        ['title' => 'Enriched Pharmacy', 'desc' => 'A fully stocked in-house pharmacy with genuine medicines and expert pharmacists.'],
        ['title' => 'Medical Treatment', 'desc' => 'Comprehensive specialist care and modern treatment across every department.'],
      ];
    ?>
    <section class="ready-help">
      <div class="container mx-auto">
        <div class="ready-help__head">
          <h2 class="ready-help__title"><?php echo e($ach['ach_title'] ?? 'We Are Always Ready To Help You & Your Family'); ?></h2>
          <span class="ready-help__pulse" aria-hidden="true">
            <svg viewBox="0 0 64 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M2 10h12l4-7 8 14 4-7h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M46 10h4M54 10h4M62 10h.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </span>
          <p class="ready-help__desc">
            <?php echo e($ach['ach_desc'] ?? 'From emergencies to everyday care, our team stands beside you at every step of your health journey.'); ?>

          </p>
        </div>

        <div class="ready-help__grid">
          <div class="ready-help__item">
            <span class="ready-help__icon">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 7h12v9H2z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                <path d="M14 9h3.5L21 12.5V16h-7" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                <circle cx="6.5" cy="18" r="2" stroke="currentColor" stroke-width="1.6"/>
                <circle cx="16.5" cy="18" r="2" stroke="currentColor" stroke-width="1.6"/>
                <path d="M8 9.5v4M6 11.5h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </span>
            <h3 class="ready-help__item-title"><?php echo e($readyHelpItems[0]['title'] ?? 'Emergency Help'); ?></h3>
            <p class="ready-help__item-desc">
              <?php echo e($readyHelpItems[0]['desc'] ?? 'Round-the-clock ambulance and emergency response, ready whenever you need us most.'); ?>

            </p>
          </div>

          <span class="ready-help__connector" aria-hidden="true"></span>

          <div class="ready-help__item">
            <span class="ready-help__icon">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="7" y="8" width="10" height="13" rx="2" stroke="currentColor" stroke-width="1.6"/>
                <path d="M9 4.5h6V8H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                <path d="M12 12v5M9.5 14.5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </span>
            <h3 class="ready-help__item-title"><?php echo e($readyHelpItems[1]['title'] ?? 'Enriched Pharmacy'); ?></h3>
            <p class="ready-help__item-desc">
              <?php echo e($readyHelpItems[1]['desc'] ?? 'A fully stocked in-house pharmacy with genuine medicines and expert pharmacists.'); ?>

            </p>
          </div>

          <span class="ready-help__connector" aria-hidden="true"></span>

          <div class="ready-help__item">
            <span class="ready-help__icon">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.5 3H3a1 1 0 0 0-1 1v5a6 6 0 0 0 12 0V4a1 1 0 0 0-1-1h-1.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8 15v1.5a5.5 5.5 0 0 0 11 0V13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <circle cx="19" cy="10.5" r="2.2" stroke="currentColor" stroke-width="1.6"/>
              </svg>
            </span>
            <h3 class="ready-help__item-title"><?php echo e($readyHelpItems[2]['title'] ?? 'Medical Treatment'); ?></h3>
            <p class="ready-help__item-desc">
              <?php echo e($readyHelpItems[2]['desc'] ?? 'Comprehensive specialist care and modern treatment across every department.'); ?>

            </p>
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
              $achTestiImage    = !empty($testi['testi_image']) ? asset('storage/' . $testi['testi_image']) : asset('assets/img/1752043437.img2.png');
              $achTestiImageAlt = ($testi['testi_image_alt'] ?? null) ?: 'Doctor smiling with arms crossed';
            ?>
            <img
              src="<?php echo e($achTestiImage); ?>"
              alt="<?php echo e($achTestiImageAlt); ?>"
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
                  $achTestimonialDefaults = [
                    ['name' => 'Emma Carter', 'role' => 'Patient', 'avatar' => asset('assets/img/sr-1-2.jpg'), 'title' => 'Best Treatment', 'review' => "From the first visit, I felt completely at ease. The staff was warm, patient, and incredibly supportive. They took time to listen and explain everything clearly. Their kindness made a real difference in my recovery. I'm thankful for such a caring team."],
                    ['name' => 'Rihana Roy', 'role' => 'Patient', 'avatar' => asset('assets/img/sr-1-3.jpg'), 'title' => 'Caring Staff', 'review' => "My experience here was nothing short of amazing. The team treated me with kindness and genuine care. Every step of my treatment was handled with professionalism. I felt heard, supported, and completely at ease. I'm truly grateful for the care I received."],
                    ['name' => 'Daniel Cruz', 'role' => 'Patient', 'avatar' => asset('assets/img/projects-2.jpg'), 'title' => 'Compassionate Care', 'review' => "The team walked me through every step before they even touched an instrument. What could have been stressful turned into the calmest checkup I've ever had. I finally look forward to my visits."],
                  ];
                  $achTestimonialCards = (isset($testimonials) && $testimonials->isNotEmpty())
                    ? $testimonials->map(fn($t) => ['name' => $t->name, 'role' => $t->role, 'avatar' => $t->avatar ? asset('storage/' . $t->avatar) : asset('assets/img/sr-1-2.jpg'), 'title' => null, 'review' => $t->review])
                    : collect($achTestimonialDefaults);
                ?>
                <?php $__currentLoopData = $achTestimonialCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

    <!-- ===================== Awards (list) ===================== -->
    <?php
      $achAwardDefaults = [
        ['title' => 'ClinicMaster 2024', 'subtitle' => 'Quality and Accreditation Institute', 'link_text' => 'Save the Children', 'link_url' => '#', 'seal_variant' => 1],
        ['title' => 'ClinicMaster 2024', 'subtitle' => 'Quality and Accreditation Institute', 'link_text' => 'Save the Children', 'link_url' => '#', 'seal_variant' => 2],
        ['title' => 'ClinicMaster 2024', 'subtitle' => 'Quality and Accreditation Institute', 'link_text' => 'Save the Children', 'link_url' => '#', 'seal_variant' => 3],
        ['title' => 'ClinicMaster 2024', 'subtitle' => 'Quality and Accreditation Institute', 'link_text' => 'Save the Children', 'link_url' => '#', 'seal_variant' => 1],
      ];
      $achAwardCards = (isset($awards) && $awards->isNotEmpty())
        ? $awards->map(fn($a) => ['title' => $a->title, 'subtitle' => $a->subtitle, 'link_text' => $a->link_text, 'link_url' => $a->link_url ?: '#', 'seal_variant' => $a->seal_variant])
        : collect($achAwardDefaults);
    ?>
    <section class="awards">
      <div class="container mx-auto">
        <div class="ready-help__head">
          <h2 class="ready-help__title"><?php echo e(($award['ach_award_title'] ?? null) ?: 'Our Awards & Accreditations'); ?></h2>
          <p class="ready-help__desc">
            <?php echo e(($award['ach_award_desc'] ?? null) ?: 'Recognitions that reflect our continued commitment to quality care and clinical excellence.'); ?>

          </p>
        </div>

        <div class="mx-auto mt-16 grid max-w-5xl grid-cols-1 gap-12 sm:grid-cols-2 lg:grid-cols-4">
          <?php $__currentLoopData = $achAwardCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $awardCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="ready-help__item">
            <span class="ready-help__icon">
              <?php if(($awardCard['seal_variant'] ?? 1) === 1): ?>
              <svg width="40" height="40" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M48 4 86 26v44L48 92 10 70V26z" stroke="currentColor" stroke-width="1.6"/>
                <text x="48" y="46" text-anchor="middle" font-size="14" font-weight="800" fill="currentColor">WHO</text>
                <text x="48" y="56" text-anchor="middle" font-size="6" fill="currentColor" opacity="0.7">Medizone</text>
                <text x="48" y="64" text-anchor="middle" font-size="6" fill="currentColor" opacity="0.7">2024</text>
              </svg>
              <?php elseif(($awardCard['seal_variant'] ?? 1) === 2): ?>
              <svg width="40" height="40" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="1.6" stroke-dasharray="3 4"/>
                <circle cx="48" cy="48" r="32" stroke="currentColor" stroke-width="1.2"/>
                <text x="48" y="56" text-anchor="middle" font-size="12" font-weight="800" fill="currentColor">WHO</text>
                <text x="48" y="64" text-anchor="middle" font-size="5.5" fill="currentColor" opacity="0.7">Medizone</text>
              </svg>
              <?php else: ?>
              <svg width="40" height="40" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="48" cy="48" r="36" stroke="currentColor" stroke-width="1.6"/>
                <path d="M18 40c6 20 10 30 20 36M78 40c-6 20-10 30-20 36" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                <text x="48" y="44" text-anchor="middle" font-size="12" font-weight="800" fill="currentColor">WHO</text>
                <text x="48" y="53" text-anchor="middle" font-size="5.5" fill="currentColor" opacity="0.7">Medizone</text>
              </svg>
              <?php endif; ?>
            </span>
            <h3 class="ready-help__item-title"><?php echo e($awardCard['title']); ?></h3>
            <p class="ready-help__item-desc"><?php echo e($awardCard['subtitle']); ?></p>
            <?php if($awardCard['link_text']): ?>
              <a href="<?php echo e($awardCard['link_url'] ?: '#'); ?>" class="award-card__link"><?php echo e($awardCard['link_text']); ?></a>
            <?php endif; ?>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\frontend\achievements.blade.php ENDPATH**/ ?>