<?php
  $heroImage = !empty($pkg['pkg_page_hero_image']) ? asset('storage/' . $pkg['pkg_page_hero_image']) : asset('assets/img/breadcumb.webp');
  $seoTitle  = $package->seo_title ?: ($pkg['pkg_seo_title'] ?? null) ?: ($package->title . ' | ClinicMaster Medical & Health Care Services');
  $seoDesc   = $package->seo_description ?: ($pkg['pkg_seo_description'] ?? null) ?: $package->short_desc ?: 'Learn more about this health package at ClinicMaster.';
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>
<?php if(!empty($package->seo_keywords)): ?>
<?php $__env->startSection('meta_keywords', $package->seo_keywords); ?>
<?php elseif(!empty($pkg['pkg_seo_keywords'])): ?>
<?php $__env->startSection('meta_keywords', $pkg['pkg_seo_keywords']); ?>
<?php endif; ?>
<?php if(!empty($package->seo_og_image)): ?>
<?php $__env->startSection('og_image', asset('storage/' . $package->seo_og_image)); ?>
<?php elseif(!empty($pkg['pkg_seo_og_image'])): ?>
<?php $__env->startSection('og_image', asset('storage/' . $pkg['pkg_seo_og_image'])); ?>
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
        <h1 class="page-header__title">Package Details</h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="<?php echo e(route('home')); ?>">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <a href="<?php echo e(route('packages')); ?>">Packages</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span><?php echo e($package->title); ?></span>
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

    <!-- ===================== Package Detail ===================== -->
    <section class="service-detail">
      <div class="container mx-auto">
        <div class="service-detail__grid">
          <!-- Sidebar -->
          <aside class="service-sidebar">
            <nav class="service-sidebar__nav">
              <h3 class="service-sidebar__title">All Packages</h3>

              <?php $__currentLoopData = $allPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <a href="<?php echo e(route('package-details', $p->slug)); ?>" class="service-sidebar__link <?php echo e($p->id === $package->id ? 'is-active' : ''); ?>">
                <?php echo e($p->title); ?>

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
              <h4 class="service-sidebar__help-title">Do you need any help?</h4>
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
          <div>
            <?php if($package->image): ?>
            <img src="<?php echo e(asset('storage/' . $package->image)); ?>" alt="<?php echo e($package->title); ?>" class="w-full h-auto max-h-[420px] object-cover rounded-lg mb-6" />
            <?php endif; ?>

            <h1 class="service-detail__title"><?php echo e($package->title); ?></h1>
            <p class="service-detail__desc">
              <?php if($package->description): ?>
                <?php echo $package->description; ?>

              <?php else: ?>
                <?php echo e($package->short_desc ?: 'Learn more about our ' . $package->title . ' and how our specialists can help you.'); ?>

              <?php endif; ?>
            </p>
          </div>
        </div>

        <!-- Secondary image + experience badge + features checklist -->
        <?php
          $pkgSecondaryImage = $package->secondary_image ? asset('storage/' . $package->secondary_image) : asset('assets/img/about-image.webp');
          $pkgBadgeValue = $package->badge_value ?: '28+';
          $pkgBadgeLabel = $package->badge_label ?: 'Years';
          $pkgFeatures = !empty($package->features) ? $package->features : [
            'Monthly Checkups Medical Service', 'Proactive and Fast Results Best', 'Medical Service Caring Medical',
            'Dedicated Specialist Consultation', 'Advanced Diagnostic Screening', 'Personalised Follow-Up Care',
          ];
          $pkgFeatureCols = collect($pkgFeatures)->chunk((int) ceil(count($pkgFeatures) / 2));
        ?>
        <div class="ceo-message__grid mt-12">
          <div class="ceo-message__media">
            <img src="<?php echo e($pkgSecondaryImage); ?>" alt="<?php echo e($package->title); ?>" class="ceo-message__img" />
            <div class="ceo-message__badge">
              <span class="ceo-message__badge-value"><?php echo e($pkgBadgeValue); ?></span>
              <span class="ceo-message__badge-label"><?php echo e($pkgBadgeLabel); ?></span>
            </div>
          </div>

          <div>
            <h2 class="service-detail__subtitle">Package Highlights</h2>
            <div class="about__features">
              <?php $__currentLoopData = $pkgFeatureCols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
          </div>
        </div>
      </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\frontend\package-details.blade.php ENDPATH**/ ?>