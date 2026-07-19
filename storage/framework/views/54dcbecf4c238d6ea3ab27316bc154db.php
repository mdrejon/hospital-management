<?php
  $ceoImage      = !empty($about['ceo_image']) ? asset('storage/' . $about['ceo_image']) : asset('assets/img/about-image.webp');
  $ceoBadgeValue = $about['ceo_badge_value'] ?? '16+';
  $ceoBadgeLabel = $about['ceo_badge_label'] ?? "Years\nExperienced";
  $ceoEyebrow    = $about['ceo_eyebrow'] ?? 'A Message From Our MD/CEO';
  $ceoTitle      = $about['ceo_title'] ?? 'Dr. Natali Jackson';
  $ceoMessage    = $about['ceo_message'] ?? "As CEO of ClinicMaster, I'm committed to building a hospital where compassionate care meets clinical excellence. Every decision we make, from staffing to technology, starts with what's best for the patients and families who trust us with their health.\n\nWhen we opened our doors over a decade ago, our promise was simple: treat every patient like family. That promise has guided every expansion, every new department, and every hire since — and it's why thousands of families continue to choose ClinicMaster for their care today.\n\nI'm proud of what our doctors, nurses, and support staff accomplish every single day. Whether you're here for a routine check-up or a life-changing procedure, you have my personal commitment that you'll be treated with the dignity, honesty, and warmth every patient deserves.";
  $ceoFocusLabel = $about['ceo_focus_label'] ?? 'Leadership Focus';
  $ceoFocusItems = !empty($about['ceo_focus_items']) ? $about['ceo_focus_items'] : [
    'Patient-Centered Care', 'Clinical Innovation', 'Operational Excellence', 'Community Outreach', 'Quality Assurance', 'Strategic Growth',
  ];
  $ceoAwards = !empty($about['ceo_awards']) ? $about['ceo_awards'] : [
    ['year' => 'ClinicMaster 2024', 'org' => 'Quality and Accreditation Institute', 'label' => 'Healthcare Leadership Award'],
    ['year' => 'ClinicMaster 2023', 'org' => 'National Hospital Federation',        'label' => 'Excellence in Patient Care'],
  ];
  $seoTitle = $about['about_seo_title'] ?? ($ceoTitle . ' | Message From MD/CEO | ClinicMaster Medical & Health Care Services');
  $seoDesc  = \Illuminate\Support\Str::limit(str_replace(["\n", "\r"], ' ', $ceoMessage), 160);
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>

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
        <h1 class="page-header__title">Message From MD/CEO</h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="<?php echo e(route('home')); ?>">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span>Message From MD/CEO</span>
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

    <!-- ===================== Message From MD/CEO ===================== -->
    <section class="ceo-message">
      <div class="container mx-auto">
        <div class="ceo-message__grid">
          <div class="ceo-message__media">
            <img src="<?php echo e($ceoImage); ?>" alt="<?php echo e($ceoTitle); ?>" class="ceo-message__img" />
            <div class="ceo-message__badge">
              <span class="ceo-message__badge-value"><?php echo e($ceoBadgeValue); ?></span>
              <span class="ceo-message__badge-label"><?php echo nl2br(e($ceoBadgeLabel)); ?></span>
            </div>
          </div>

          <div>
            <p class="ceo-message__eyebrow">
              <span class="ceo-message__eyebrow-dot"></span>
              <?php echo e($ceoEyebrow); ?>

              <span class="ceo-message__eyebrow-dot"></span>
            </p>
            <h2 class="ceo-message__title"><?php echo e($ceoTitle); ?></h2>
            <?php $__currentLoopData = preg_split('/\n{2,}/', $ceoMessage); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paragraph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p class="ceo-message__desc">
              <?php echo e(trim($paragraph)); ?>

            </p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <p class="ceo-message__focus-label"><?php echo e($ceoFocusLabel); ?></p>
            <div class="ceo-message__checklist">
              <?php $__currentLoopData = $ceoFocusItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <span class="ceo-message__check">
                <span class="ceo-message__check-icon">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                <?php echo e($item); ?>

              </span>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="ceo-message__awards">
              <?php $__currentLoopData = $ceoAwards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="ceo-message__award">
                <span class="ceo-message__award-icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2l2.5 5 5.5.6-4 3.9 1 5.5L12 14.8 7 17l1-5.5-4-3.9L9.5 7 12 2z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                  </svg>
                </span>
                <div>
                  <p class="ceo-message__award-year"><?php echo e($award['year']); ?></p>
                  <p class="ceo-message__award-org"><?php echo e($award['org']); ?></p>
                  <a href="<?php echo e(route('achievements')); ?>" class="ceo-message__award-link"><?php echo e($award['label']); ?></a>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\frontend\md-message.blade.php ENDPATH**/ ?>