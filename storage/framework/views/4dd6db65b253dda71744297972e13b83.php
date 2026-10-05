<?php
$heroTitle = $pkg['pkg_page_hero_title'] ?? 'Our Health Packages';
$heroImage = !empty($pkg['pkg_page_hero_image']) ? asset('storage/' . $pkg['pkg_page_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $pkg['pkg_seo_title'] ?? ('Our Health Packages | ' . config('app.name'));
$seoDesc = $pkg['pkg_seo_description'] ?? 'Explore Medicare Lab Ltd.\'s health packages designed for every stage of life.';
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>
<?php if(!empty($pkg['pkg_seo_keywords'])): ?>
<?php $__env->startSection('meta_keywords', $pkg['pkg_seo_keywords']); ?>
<?php endif; ?>
<?php if(!empty($pkg['pkg_seo_og_image'])): ?>
<?php $__env->startSection('og_image', asset('storage/' . $pkg['pkg_seo_og_image'])); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>

<!-- ===================== Breadcrumb / Page header ===================== -->
<section class="page-header">
  <div class="page-header__media">
    <img src="<?php echo e($heroImage); ?>" alt="Team of Medicare Lab Ltd. doctors" class="page-header__bg" />
    <span class="page-header__overlay"></span>
  </div>

  <span class="page-header__badge">24/7 Emergency Service</span>

  <div class="page-header__social">
    <a href="#" class="page-header__social-link" aria-label="Facebook">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
        <path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z" />
      </svg>
    </a>
    <a href="#" class="page-header__social-link" aria-label="Twitter">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
        <path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 0 1-1.9.1c.5 1.7 2.1 2.9 4 2.9A8.2 8.2 0 0 1 2 18.6a11.6 11.6 0 0 0 6.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z" />
      </svg>
    </a>
    <a href="#" class="page-header__social-link" aria-label="LinkedIn">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
        <path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z" />
      </svg>
    </a>
    <a href="#" class="page-header__social-link" aria-label="Instagram">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
        <rect x="3.5" y="3.5" width="17" height="17" rx="5" />
        <circle cx="12" cy="12" r="4" />
        <circle cx="17.2" cy="6.8" r="1" />
      </svg>
    </a>
  </div>

  <div class="page-header__inner">
    <h1 class="page-header__title"><?php echo e($heroTitle); ?></h1>
    <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
      <a href="<?php echo e(route('home')); ?>"><?php echo e(__('frontend.nav.home')); ?></a>
      <span class="page-header__breadcrumb-sep">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span>
      <span><?php echo e(__('frontend.breadcrumb.packages')); ?></span>
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

<!-- ===================== Packages List ===================== -->
<?php
$packageCards = $packages->isNotEmpty()
? $packages->map(fn ($p) => [
'title' => $p->title,
'desc' => $p->short_desc,
'image' => $p->image ? asset('storage/' . $p->image) : asset('assets/img/sr-1-2.jpg'),
'url' => route('package-details', $p->slug),
])
: collect([
['title' => 'Full Body Checkup', 'desc' => 'Comprehensive screening to catch health issues early.', 'image' => asset('assets/img/sr-1-2.jpg'), 'url' => '#'],
['title' => 'Dermatology & Wellness', 'desc' => 'Specialized skin and wellness treatments for every age.', 'image' => asset('assets/img/sr-1-3.jpg'), 'url' => '#'],
['title' => 'Cardiac Care Package', 'desc' => 'Complete heart health evaluation and monitoring.', 'image' => asset('assets/img/about-image.webp'),'url' => '#'],
['title' => 'Pediatric Care Package', 'desc' => 'Gentle, thorough checkups designed for children.', 'image' => asset('assets/img/slider-1.2.jpg'), 'url' => '#'],
['title' => 'Surgical Care Package', 'desc' => 'Pre and post-operative care from expert surgeons.', 'image' => asset('assets/img/sr-1-1.jpg'), 'url' => '#'],
['title' => 'Emergency Response Package', 'desc' => 'Round-the-clock critical care when it matters most.', 'image' => asset('assets/img/slider-1.3.jpg'), 'url' => '#'],
]);
?>
<section class="packages py-24 bg-cyan-50/40 relative overflow-hidden">
  <!-- Animated Floating Element -->
  <div class="absolute top-1/2 left-10 opacity-10 animate-pulse text-navy pointer-events-none z-0" style="animation-duration: 5s;">
    <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/></svg>
  </div>
  <div class="container mx-auto px-4 lg:px-0">
    <div class="text-center mb-14 max-w-2xl mx-auto">
      <h2 class="text-3xl lg:text-[40px] font-bold text-navy mb-4 leading-[1.2]">
        <?php echo e($pkg['pkg_desc'] ?? 'Complete Health Solutions — Because You Deserve the Best'); ?>

      </h2>
      <div class="flex justify-center items-center gap-1.5 mb-4 text-brand-cyan">
        <!-- Heartbeat Line -->
        <span class="text-lg font-bold tracking-tighter">--</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h3l2.5-4.5 3 9 2.5-4.5h4" />
        </svg>
        <span class="text-lg font-bold tracking-tighter">--</span>
      </div>
    </div>

    <!-- Standard Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full max-w-7xl mx-auto px-4">
      <?php $__currentLoopData = $packageCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="group relative overflow-hidden aspect-[4/3] w-full bg-white rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.06)] hover:shadow-[0_10px_30px_rgba(0,0,0,0.1)] transition-shadow duration-300">
        <!-- Background Image -->
        <img src="<?php echo e($card['image']); ?>" alt="<?php echo e($card['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />

        <!-- Hover Overlay -->
        <div class="absolute inset-0 bg-[#2b88f3]/85 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center backdrop-blur-[1px]">
          <!-- Hidden Title that appears on hover for context -->
          <h3 class="text-white font-bold text-xl mb-4 translate-y-4 group-hover:translate-y-0 transition-transform duration-300 opacity-0 group-hover:opacity-100 text-center px-4">
            <?php echo e($card['title']); ?>

          </h3>
          <!-- View Details Button -->
          <a href="<?php echo e($card['url']); ?>" class="bg-white text-[#2b88f3] text-[14px] font-bold py-2.5 px-6 rounded transition-colors duration-300 hover:bg-navy hover:text-white shadow-lg shadow-black/10 translate-y-4 group-hover:translate-y-0 transform">
            View Details
          </a>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<!-- ===================== Scroll Animation Script ===================== -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Add base classes for animation to all containers inside sections
    const containers = document.querySelectorAll('section > .container');
    containers.forEach(el => {
      // Avoid hero section and testimonials since they have custom structure
      if(!el.closest('.hero') && !el.closest('.page-header') && !el.closest('.testimonials')) {
        el.classList.add('transition-all', 'duration-[1200ms]', 'ease-out', 'opacity-0', 'translate-y-12');
      }
    });

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.remove('opacity-0', 'translate-y-12');
          entry.target.classList.add('opacity-100', 'translate-y-0');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

    containers.forEach(el => {
      if(!el.closest('.hero') && !el.closest('.page-header') && !el.closest('.testimonials')) {
        observer.observe(el);
      }
    });
  });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/frontend/packages.blade.php ENDPATH**/ ?>