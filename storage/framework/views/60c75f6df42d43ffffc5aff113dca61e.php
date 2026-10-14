<?php
$heroTitle = $appt['appt_page_hero_title'] ?? 'Book Appointment';
$heroImage = !empty($appt['appt_page_hero_image']) ? asset('storage/' . $appt['appt_page_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $appt['appt_seo_title'] ?? ('Book Appointment | ' . config('app.name'));
$seoDesc = $appt['appt_seo_description'] ?? 'Schedule your visit with Sitakund Modern Hospital Ltd. in just a few clicks — fast, easy appointment booking.';
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>
<?php if(!empty($appt['appt_seo_keywords'])): ?>
<?php $__env->startSection('meta_keywords', $appt['appt_seo_keywords']); ?>
<?php endif; ?>
<?php if(!empty($appt['appt_seo_og_image'])): ?>
<?php $__env->startSection('og_image', asset('storage/' . $appt['appt_seo_og_image'])); ?>
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
      <span><?php echo e($heroTitle); ?></span>
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
<?php if (isset($component)) { $__componentOriginald60bc4ce403b880ef3c1cf57c71fbc24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald60bc4ce403b880ef3c1cf57c71fbc24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.book-appointment','data' => ['settings' => $appt,'doctors' => $appointmentDoctors,'specializations' => $appointmentSpecializations,'source' => 'appointment_page']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.book-appointment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['settings' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($appt),'doctors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($appointmentDoctors),'specializations' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($appointmentSpecializations),'source' => 'appointment_page']); ?>
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
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/frontend/appointment.blade.php ENDPATH**/ ?>