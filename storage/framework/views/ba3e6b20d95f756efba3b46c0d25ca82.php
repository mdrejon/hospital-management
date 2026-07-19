<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $__env->yieldContent('title', 'ClinicMaster | Medical & Health Care Services'); ?></title>
  <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'ClinicMaster provides compassionate, modern medical and health care services.'); ?>" />
  <?php if (! empty(trim($__env->yieldContent('meta_keywords')))): ?>
  <meta name="keywords" content="<?php echo $__env->yieldContent('meta_keywords'); ?>" />
  <?php endif; ?>
  <meta property="og:title" content="<?php echo $__env->yieldContent('og_title', 'ClinicMaster | Medical & Health Care Services'); ?>" />
  <meta property="og:description" content="<?php echo $__env->yieldContent('og_description', 'ClinicMaster provides compassionate, modern medical and health care services.'); ?>" />
  <?php if (! empty(trim($__env->yieldContent('og_image')))): ?>
  <meta property="og:image" content="<?php echo $__env->yieldContent('og_image'); ?>" />
  <?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo e(asset('assets/main.css')); ?>" />
</head>
<body class="font-sans">

  <?php if (isset($component)) { $__componentOriginal1dc762f2ce942f7f71b31288216cfc8b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1dc762f2ce942f7f71b31288216cfc8b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1dc762f2ce942f7f71b31288216cfc8b)): ?>
<?php $attributes = $__attributesOriginal1dc762f2ce942f7f71b31288216cfc8b; ?>
<?php unset($__attributesOriginal1dc762f2ce942f7f71b31288216cfc8b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1dc762f2ce942f7f71b31288216cfc8b)): ?>
<?php $component = $__componentOriginal1dc762f2ce942f7f71b31288216cfc8b; ?>
<?php unset($__componentOriginal1dc762f2ce942f7f71b31288216cfc8b); ?>
<?php endif; ?>

  <!-- ===================== Main content ===================== -->
  <main>
    <?php echo $__env->yieldContent('content'); ?>
  </main>

  <?php if (isset($component)) { $__componentOriginalbf18abedf5585b715c19d869055fa37a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbf18abedf5585b715c19d869055fa37a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbf18abedf5585b715c19d869055fa37a)): ?>
<?php $attributes = $__attributesOriginalbf18abedf5585b715c19d869055fa37a; ?>
<?php unset($__attributesOriginalbf18abedf5585b715c19d869055fa37a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbf18abedf5585b715c19d869055fa37a)): ?>
<?php $component = $__componentOriginalbf18abedf5585b715c19d869055fa37a; ?>
<?php unset($__componentOriginalbf18abedf5585b715c19d869055fa37a); ?>
<?php endif; ?>

  <script src="<?php echo e(asset('assets/main.js')); ?>"></script>
</body>
</html>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\layouts\frontend.blade.php ENDPATH**/ ?>