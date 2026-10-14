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
    $faviconPath = !empty($headerSettings['header_favicon']) ? asset('storage/' . $headerSettings['header_favicon']) . '?v=' . time() : asset('favicon.ico') . '?v=' . time();
    $faviconExt  = strtolower(pathinfo($headerSettings['header_favicon'] ?? 'favicon.ico', PATHINFO_EXTENSION));
    $faviconType = ['png' => 'image/png', 'svg' => 'image/svg+xml', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'webp' => 'image/webp'][$faviconExt] ?? 'image/x-icon';
  ?>
  <link rel="icon" href="<?php echo e($faviconPath); ?>" type="<?php echo e($faviconType); ?>" />
  <link rel="manifest" href="<?php echo e(route('manifest')); ?>" />
  <meta name="theme-color" content="#0f172a" />
  <link rel="apple-touch-icon" href="<?php echo e($faviconPath); ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo e(asset('assets/main.css')); ?>" />
  <?php if(!empty($themeSettings)): ?>
  <style>
    :root {
      <?php if(!empty($themeSettings['theme_color_primary'])): ?>
      --color-primary: <?php echo e($themeSettings['theme_color_primary']); ?>;
      <?php endif; ?>
      <?php if(!empty($themeSettings['theme_color_secondary'])): ?>
      --color-secondary: <?php echo e($themeSettings['theme_color_secondary']); ?>;
      <?php endif; ?>
      <?php if(!empty($themeSettings['theme_color_navy'])): ?>
      --color-navy: <?php echo e($themeSettings['theme_color_navy']); ?>;
      <?php endif; ?>
      <?php if(!empty($themeSettings['theme_color_navy_dark'])): ?>
      --color-navy-dark: <?php echo e($themeSettings['theme_color_navy_dark']); ?>;
      <?php endif; ?>
      <?php if(!empty($themeSettings['theme_color_accent_green'])): ?>
      --color-accent-green: <?php echo e($themeSettings['theme_color_accent_green']); ?>;
      <?php endif; ?>
      <?php if(!empty($themeSettings['theme_color_accent_red'])): ?>
      --color-accent-red: <?php echo e($themeSettings['theme_color_accent_red']); ?>;
      <?php endif; ?>
    }
  </style>
  <?php endif; ?>
</head>
<body>

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

  <!-- Floating Action Buttons -->
  <style>
    .floating-btn {
      position: fixed;
      z-index: 50;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 9999px;
      color: #fff;
      text-decoration: none;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
    }

    /* WhatsApp Pill on Bottom-Left (the scroll-to-top button owns the right) */
    .floating-btn--whatsapp {
      left: 24px;
      bottom: 24px;
      background-color: #25D366;
      padding: 7px 16px 7px 7px;
      box-shadow: 0 4px 14px rgba(37, 211, 102, 0.45);
      transition: transform 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }
    .floating-btn--whatsapp:hover {
      background-color: #1ea952;
      transform: translateY(-3px);
      box-shadow: 0 6px 18px rgba(37, 211, 102, 0.55);
    }
    .floating-btn--whatsapp-icon {
      background-color: rgba(255, 255, 255, 0.22);
      border-radius: 9999px;
      width: 34px;
      height: 34px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 8px;
      flex-shrink: 0;
    }
    .floating-btn--whatsapp-text {
      font-weight: 600;
      font-size: var(--fs-btn);
      line-height: 1;
      padding-right: 2px;
      color: #ffffff;
      white-space: nowrap;
    }

    /* Scroll To Top Button (Hidden at top, visible on scroll) */
    .floating-btn--scroll-top {
      right: 24px;
      bottom: 24px;
      width: 44px;
      height: 44px;
      background-color: #0072BB;
      box-shadow: 0 4px 14px rgba(0, 114, 187, 0.35);
      border: none;
      cursor: pointer;
      opacity: 0;
      visibility: hidden;
      transform: translateY(12px) scale(0.9);
      pointer-events: none;
      transition: opacity 0.25s ease, visibility 0.25s ease, transform 0.25s ease, background-color 0.2s ease;
    }
    .floating-btn--scroll-top.is-visible {
      opacity: 1;
      visibility: visible;
      transform: translateY(0) scale(1);
      pointer-events: auto;
    }
    .floating-btn--scroll-top:hover {
      background-color: #003354;
      box-shadow: 0 6px 18px rgba(0, 51, 84, 0.45);
      transform: translateY(-3px) scale(1.05);
    }
  </style>

  <?php if(($footerSettings['footer_whatsapp_enabled'] ?? '0') === '1' && !empty($footerSettings['footer_whatsapp_number'])): ?>
  <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $footerSettings['footer_whatsapp_number'])); ?>" target="_blank" rel="noopener noreferrer" id="floatingWhatsappBtn" class="floating-btn floating-btn--whatsapp" aria-label="WhatsApp Talk" title="WhatsApp">
    <div class="floating-btn--whatsapp-icon">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.489-1.761-1.663-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
      </svg>
    </div>
    <span class="floating-btn--whatsapp-text"><?php echo e(__('frontend.home.talk')); ?></span>
  </a>
  <?php endif; ?>

  <!-- Scroll To Top Button -->
  <button type="button" id="scrollToTopBtn" class="floating-btn floating-btn--scroll-top" aria-label="Scroll to top" title="Scroll to top">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 19V5M5 12l7-7 7 7"/>
    </svg>
  </button>

  <script>
    (function () {
      var scrollBtn = document.getElementById('scrollToTopBtn');

      function checkScroll() {
        var isScrolled = window.scrollY > 180;
        if (scrollBtn) {
          if (isScrolled) {
            scrollBtn.classList.add('is-visible');
          } else {
            scrollBtn.classList.remove('is-visible');
          }
        }
      }

      window.addEventListener('scroll', checkScroll, { passive: true });
      checkScroll();

      if (scrollBtn) {
        scrollBtn.addEventListener('click', function (e) {
          e.preventDefault();
          window.scrollTo({ top: 0, behavior: 'smooth' });
        });
      }
    })();
  </script>

  <script src="<?php echo e(asset('assets/main.js')); ?>" defer></script>
  <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
          .then(registration => {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
          })
          .catch(err => {
            console.log('ServiceWorker registration failed: ', err);
          });
      });
    }
  </script>
</body>
</html>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/layouts/frontend.blade.php ENDPATH**/ ?>