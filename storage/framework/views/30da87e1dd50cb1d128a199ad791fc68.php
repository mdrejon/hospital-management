<?php
$heroTitle = $gallery['gallery_hero_title'] ?? 'Our Gallery';
$heroImage = !empty($gallery['gallery_hero_image']) ? asset('storage/' . $gallery['gallery_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $gallery['gallery_seo_title'] ?? ('Gallery | ' . config('app.name'));
$seoDesc = $gallery['gallery_seo_description'] ?? "Browse photos of Sitakund Modern Hospital Ltd.'s treatment rooms, diagnostic facilities, and medical team.";
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>
<?php if(!empty($gallery['gallery_seo_keywords'])): ?>
<?php $__env->startSection('meta_keywords', $gallery['gallery_seo_keywords']); ?>
<?php endif; ?>
<?php if(!empty($gallery['gallery_seo_og_image'])): ?>
<?php $__env->startSection('og_image', asset('storage/' . $gallery['gallery_seo_og_image'])); ?>
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
      <span><?php echo e(__('frontend.breadcrumb.gallery')); ?></span>
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

<!-- ===================== Gallery ===================== -->
<?php
$aspectClasses = ['aspect-[4/3]', 'aspect-[3/4]', 'aspect-square', 'aspect-[4/5]', 'aspect-[16/11]', 'aspect-[3/4]', 'aspect-square', 'aspect-[4/3]', 'aspect-[4/5]'];
$galleryCards = $images->values()->map(fn ($img, $i) => [
'image' => asset('storage/' . $img->image),
'alt' => $img->alt ?: $img->caption ?: 'Sitakund Modern Hospital Ltd. gallery photo',
'sub_title' => $img->sub_title,
'title' => $img->caption,
'aspect' => $aspectClasses[$i % count($aspectClasses)],
]);
?>
<section class="gallery">
  <div class="container mx-auto">
    <?php if($galleryCards->isEmpty()): ?>
    <div class="py-16 text-center">
      <h3 class="text-h3 font-bold text-gray-500">No photo gallery available at this moment</h3>
    </div>
    <?php else: ?>
    <div class="team__head">
      <p class="team__eyebrow">
        <span class="team__eyebrow-dot"></span>
        <?php echo e($gallery['gallery_badge'] ?? 'Our Gallery'); ?>

        <span class="team__eyebrow-dot"></span>
      </p>
      <h2 class="team__title"><?php echo e($gallery['gallery_title'] ?? 'Inside Our Hospital'); ?></h2>
    </div>
    <p class="gallery__desc">
      <?php echo e($gallery['gallery_subtitle'] ?? "From modern treatment rooms to advanced diagnostic facilities — take a look at the spaces and people behind Sitakund Modern Hospital Ltd.'s award-winning care."); ?>

    </p>

    <div class="gallery__grid">
      <?php $__currentLoopData = $galleryCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="#" class="gallery-item" data-gallery-item>
        <img src="<?php echo e($card['image']); ?>" alt="<?php echo e($card['alt']); ?>" class="gallery-item__img <?php echo e($card['aspect']); ?>" />
        <span class="gallery-item__overlay">
          <span class="gallery-item__expand">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15 4h5v5M9 20H4v-5M20 4l-6 6M4 20l6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
          <?php if($card['sub_title'] || $card['title']): ?>
          <span class="gallery-item__caption">
            <?php if($card['sub_title']): ?>
            <span class="gallery-item__tag"><span class="gallery-item__tag-dot"></span><?php echo e($card['sub_title']); ?></span>
            <?php endif; ?>
            <?php if($card['title']): ?>
            <span class="gallery-item__title"><?php echo e($card['title']); ?></span>
            <?php endif; ?>
          </span>
          <?php endif; ?>
        </span>
      </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- Lightbox overlay -->
<div class="lightbox" data-lightbox role="dialog" aria-modal="true" aria-label="Image preview">
  <img src="" alt="" class="lightbox__img" data-lightbox-img />
  <button type="button" class="lightbox__close" data-lightbox-close aria-label="Close preview">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="m6 6 12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
    </svg>
  </button>
  <button type="button" class="lightbox__nav is-prev" data-lightbox-prev aria-label="Previous image">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M19 12H5M11 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </button>
  <button type="button" class="lightbox__nav is-next" data-lightbox-next aria-label="Next image">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </button>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/frontend/gallery.blade.php ENDPATH**/ ?>