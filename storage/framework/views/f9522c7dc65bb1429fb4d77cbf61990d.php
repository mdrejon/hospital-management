<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $__env->yieldContent('title', __('frontend.meta.default_title')); ?></title>
  <meta name="description" content="<?php echo $__env->yieldContent('meta_description', __('frontend.meta.default_description')); ?>" />
  <?php if (! empty(trim($__env->yieldContent('meta_keywords')))): ?>
  <meta name="keywords" content="<?php echo $__env->yieldContent('meta_keywords'); ?>" />
  <?php endif; ?>
  <meta property="og:title" content="<?php echo $__env->yieldContent('og_title', __('frontend.meta.default_title')); ?>" />
  <meta property="og:description" content="<?php echo $__env->yieldContent('og_description', __('frontend.meta.default_description')); ?>" />
  <?php if (! empty(trim($__env->yieldContent('og_image')))): ?>
  <meta property="og:image" content="<?php echo $__env->yieldContent('og_image'); ?>" />
  <?php endif; ?>
  <?php
    $faviconPath = !empty($headerSettings['header_favicon']) ? asset('storage/' . $headerSettings['header_favicon']) : asset('favicon.ico');
    $faviconExt  = strtolower(pathinfo($headerSettings['header_favicon'] ?? 'favicon.ico', PATHINFO_EXTENSION));
    $faviconType = ['png' => 'image/png', 'svg' => 'image/svg+xml', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'webp' => 'image/webp'][$faviconExt] ?? 'image/x-icon';
  ?>
  <link rel="icon" href="<?php echo e($faviconPath); ?>" type="<?php echo e($faviconType); ?>" />
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

  <!-- Floating Contact Buttons -->
  <style>
    .floating-btn {
      position: fixed;
      bottom: 24px;
      z-index: 50;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 9999px;
      color: #fff;
      transition: transform 0.2s ease, background-color 0.2s ease;
      text-decoration: none;
    }
    .floating-btn:hover {
      transform: translateY(-4px);
    }
    .floating-btn--talk {
      left: 24px;
      background-color: #dc2626;
      padding: 10px;
      box-shadow: 0 4px 14px rgba(220, 38, 38, 0.4);
    }
    .floating-btn--talk:hover {
      background-color: #b91c1c;
    }
    .floating-btn--talk-icon {
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 9999px;
      padding: 6px;
      margin-right: 8px;
    }
    .floating-btn--whatsapp {
      right: 24px;
      background-color: #25D366;
      padding: 12px;
      box-shadow: 0 4px 14px rgba(37, 211, 102, 0.4);
    }
    .floating-btn--whatsapp:hover {
      background-color: #128C7E;
    }
    .floating-btn-text {
      font-weight: 500;
      padding-right: 12px;
      font-size: 14px;
    }
  </style>

  <?php if(($footerSettings['footer_lets_talk_enabled'] ?? '0') === '1' && !empty($footerSettings['footer_lets_talk_phone'])): ?>
  <a href="tel:<?php echo e(preg_replace('/[^0-9+]/', '', $footerSettings['footer_lets_talk_phone'])); ?>" class="floating-btn floating-btn--talk" aria-label="Let's Talk">
    <div class="floating-btn--talk-icon">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <span class="floating-btn-text">Let's Talk</span>
  </a>
  <?php endif; ?>

  <?php if(($footerSettings['footer_whatsapp_enabled'] ?? '0') === '1' && !empty($footerSettings['footer_whatsapp_number'])): ?>
  <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $footerSettings['footer_whatsapp_number'])); ?>" target="_blank" rel="noopener noreferrer" class="floating-btn floating-btn--whatsapp" aria-label="WhatsApp">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.489-1.761-1.663-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
    </svg>
  </a>
  <?php endif; ?>
</body>
</html>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/layouts/frontend.blade.php ENDPATH**/ ?>