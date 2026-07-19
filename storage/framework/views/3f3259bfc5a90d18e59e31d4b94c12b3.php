<?php $__env->startSection('title', 'Page Not Found | ClinicMaster Medical & Health Care Services'); ?>

<?php $__env->startSection('content'); ?>
    <section class="ready-help" style="min-height: 60vh; display: flex; align-items: center;">
      <div class="container mx-auto text-center">
        <p class="ready-help__title" style="font-size: 5rem; line-height: 1; margin-bottom: 1rem;">404</p>
        <h1 class="ready-help__title">Page Not Found</h1>
        <p class="ready-help__desc">
          Sorry, the page you're looking for doesn't exist or may have been moved.
        </p>

        <a href="<?php echo e(route('home')); ?>" class="about__btn" style="margin-top: 2rem;">
          Back to Home
          <span class="about__btn-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </a>
      </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\errors\404.blade.php ENDPATH**/ ?>