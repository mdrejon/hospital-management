<?php
  $heroTitle = $svc['svc_page_hero_title'] ?? 'Our Services';
  $heroImage = !empty($svc['svc_page_hero_image']) ? asset('storage/' . $svc['svc_page_hero_image']) : asset('assets/img/breadcumb.webp');
  $seoTitle  = $svc['svc_seo_title'] ?? 'Our Services | ClinicMaster Medical & Health Care Services';
  $seoDesc   = $svc['svc_seo_description'] ?? 'Explore the full range of medical and health care services offered by ClinicMaster.';
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>
<?php if(!empty($svc['svc_seo_keywords'])): ?>
<?php $__env->startSection('meta_keywords', $svc['svc_seo_keywords']); ?>
<?php endif; ?>
<?php if(!empty($svc['svc_seo_og_image'])): ?>
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
        <h1 class="page-header__title"><?php echo e($heroTitle); ?></h1>
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
    <?php
      $defaultIcon = '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 4a3 3 0 0 0-3 3 3 3 0 0 0-1 5.8A3 3 0 0 0 8 17a3 3 0 0 0 3-3V7a3 3 0 0 0-2-3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M15 4a3 3 0 0 1 3 3 3 3 0 0 1 1 5.8A3 3 0 0 1 16 17a3 3 0 0 1-3-3V7a3 3 0 0 1 2-3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>';
      $serviceCards = $services->isNotEmpty()
        ? $services->map(fn ($s) => [
            'title'    => $s->title,
            'desc'     => $s->short_desc,
            'icon_svg' => $s->icon_svg,
            'image'    => $s->image ? asset('storage/' . $s->image) : asset('assets/img/sr-1-2.jpg'),
            'url'      => route('service-details', $s->slug),
          ])
        : collect([
            ['title' => 'Mental Health & Wellness',     'desc' => 'Counseling, therapy, and psychiatric care for mental well-being.', 'icon_svg' => null, 'image' => asset('assets/img/sr-1-2.jpg'), 'url' => '#'],
            ['title' => 'Emergency & Urgent Care',       'desc' => '24/7 medical assistance for accidents and critical health conditions.', 'icon_svg' => null, 'image' => asset('assets/img/appoinment.jpg'), 'url' => '#'],
            ['title' => 'Diagnostic & Laboratory',       'desc' => 'Blood tests, imaging (X-rays, MRIs, CT scans), and screenings diagnosis.', 'icon_svg' => null, 'image' => asset('assets/img/projects-4.jpg'), 'url' => '#'],
            ['title' => 'Maternity & Pediatric Care',    'desc' => "Comprehensive care for expecting mothers, newborns, children's health.", 'icon_svg' => null, 'image' => asset('assets/img/slider-1.2.jpg'), 'url' => '#'],
            ['title' => 'Dental Care Services',          'desc' => 'Our Dental Care Services are designed to provide comprehensive treatment.', 'icon_svg' => null, 'image' => asset('assets/img/projects-2.jpg'), 'url' => '#'],
            ['title' => 'Surgery Care',                  'desc' => 'Our Surgery Care services provide expert, compassionate treatment.', 'icon_svg' => null, 'image' => asset('assets/img/sr-1-1.jpg'), 'url' => '#'],
          ]);
    ?>
    <section class="services">
      <div class="container mx-auto">
        <div class="services__head">
          <p class="services__eyebrow">Explore Medical Department</p>
          <h2 class="services__title">Complete Health Solutions — Because You Deserve the Best</h2>
        </div>

        <div class="services__grid">
          <?php $__currentLoopData = $serviceCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <article class="service-card">
            <div class="service-card__media">
              <img src="<?php echo e($card['image']); ?>" alt="<?php echo e($card['title']); ?>" class="service-card__img" />
              <span class="service-card__icon">
                <?php echo $card['icon_svg'] ?: $defaultIcon; ?>

              </span>
            </div>
            <div class="service-card__body">
              <h3 class="service-card__title"><?php echo e($card['title']); ?></h3>
              <p class="service-card__desc"><?php echo e($card['desc']); ?></p>
              <a href="<?php echo e($card['url']); ?>" class="service-card__btn">
                Read more
                <span class="service-card__btn-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </a>
            </div>
          </article>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\frontend\services.blade.php ENDPATH**/ ?>