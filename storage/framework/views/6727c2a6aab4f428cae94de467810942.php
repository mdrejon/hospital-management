<?php
$heroTitle = $svc['svc_page_hero_title'] ?? 'Our Services';
$heroImage = !empty($svc['svc_page_hero_image']) ? asset('storage/' . $svc['svc_page_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $svc['svc_seo_title'] ?? ('Our Services | ' . config('app.name'));
$seoDesc = $svc['svc_seo_description'] ?? 'Explore the full range of medical and health care services offered by Sitakund Modern Hospital Ltd..';
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
    <img src="<?php echo e($heroImage); ?>" alt="Team of Sitakund Modern Hospital Ltd. doctors" class="page-header__bg" />
    <span class="page-header__overlay"></span>
  </div>

  <span class="page-header__badge">24/7 Emergency Service</span>

  <?php if (isset($component)) { $__componentOriginalf541cdfc2c462e982d1ee013ac35e2c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf541cdfc2c462e982d1ee013ac35e2c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.page-header-social','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.page-header-social'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf541cdfc2c462e982d1ee013ac35e2c5)): ?>
<?php $attributes = $__attributesOriginalf541cdfc2c462e982d1ee013ac35e2c5; ?>
<?php unset($__attributesOriginalf541cdfc2c462e982d1ee013ac35e2c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf541cdfc2c462e982d1ee013ac35e2c5)): ?>
<?php $component = $__componentOriginalf541cdfc2c462e982d1ee013ac35e2c5; ?>
<?php unset($__componentOriginalf541cdfc2c462e982d1ee013ac35e2c5); ?>
<?php endif; ?>

  <div class="page-header__inner">
    <h1 class="page-header__title"><?php echo e($heroTitle); ?></h1>
    <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
      <a href="<?php echo e(route('home')); ?>"><?php echo e(__('frontend.nav.home')); ?></a>
      <span class="page-header__breadcrumb-sep">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span>
      <span><?php echo e(__('frontend.breadcrumb.services')); ?></span>
    </nav>
  </div>

  <a href="tel:<?php echo e(preg_replace('/[^0-9+]/', '', $headerSettings['header_phone'] ?? '11234567890')); ?>" class="page-header__call">
    <span class="page-header__call-icon">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6" />
      </svg>
    </span>
    <span class="page-header__call-text"><?php echo e($headerSettings['header_phone'] ?? '1 123 456 7890'); ?></span>
  </a>
</section>

<!-- ===================== Services ===================== -->
<?php
$defaultIcon = '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M9 4a3 3 0 0 0-3 3 3 3 0 0 0-1 5.8A3 3 0 0 0 8 17a3 3 0 0 0 3-3V7a3 3 0 0 0-2-3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
  <path d="M15 4a3 3 0 0 1 3 3 3 3 0 0 1 1 5.8A3 3 0 0 1 16 17a3 3 0 0 1-3-3V7a3 3 0 0 1 2-3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
</svg>';
$serviceCards = $services->isNotEmpty()
? $services->map(fn ($s) => [
'title' => $s->title,
'desc' => $s->short_desc,
'icon_svg' => $s->icon_svg,
'image' => $s->image ? asset('storage/' . $s->image) : asset('assets/img/sr-1-2.jpg'),
'url' => route('service-details', $s->slug),
])
: collect([
['title' => 'Mental Health & Wellness', 'desc' => 'Counseling, therapy, and psychiatric care for mental well-being.', 'icon_svg' => null, 'image' => asset('assets/img/sr-1-2.jpg'), 'url' => '#'],
['title' => 'Emergency & Urgent Care', 'desc' => '24/7 medical assistance for accidents and critical health conditions.', 'icon_svg' => null, 'image' => asset('assets/img/appoinment.jpg'), 'url' => '#'],
['title' => 'Diagnostic & Laboratory', 'desc' => 'Blood tests, imaging (X-rays, MRIs, CT scans), and screenings diagnosis.', 'icon_svg' => null, 'image' => asset('assets/img/projects-4.jpg'), 'url' => '#'],
['title' => 'Maternity & Pediatric Care', 'desc' => "Comprehensive care for expecting mothers, newborns, children's health.", 'icon_svg' => null, 'image' => asset('assets/img/slider-1.2.jpg'), 'url' => '#'],
['title' => 'Dental Care Services', 'desc' => 'Our Dental Care Services are designed to provide comprehensive treatment.', 'icon_svg' => null, 'image' => asset('assets/img/projects-2.jpg'), 'url' => '#'],
['title' => 'Surgery Care', 'desc' => 'Our Surgery Care services provide expert, compassionate treatment.', 'icon_svg' => null, 'image' => asset('assets/img/sr-1-1.jpg'), 'url' => '#'],
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
                <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/frontend/services.blade.php ENDPATH**/ ?>