<?php
$heroTitle = $specialization->name;
$heroImage = $specialization->image ? asset('storage/' . $specialization->image) : ( !empty($doc['doc_page_hero_image']) ? asset('storage/' . $doc['doc_page_hero_image']) : asset('assets/img/breadcumb.webp') );
$seoTitle = $specialization->seo_title ?: ($specialization->name . ' | ' . config('app.name'));
$seoDesc = $specialization->seo_description ?: ($specialization->description ?? 'Meet the ' . $specialization->name . ' team of Medicare Lab Ltd. doctors dedicated to compassionate, expert medical care.');
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>
<?php if($specialization->image): ?>
<?php $__env->startSection('og_image', asset('storage/' . $specialization->image)); ?>
<?php elseif(!empty($doc['doc_seo_og_image'])): ?>
<?php $__env->startSection('og_image', asset('storage/' . $doc['doc_seo_og_image'])); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>

<!-- ===================== Breadcrumb / Page header ===================== -->
<section class="page-header">
  <div class="page-header__media">
    <img src="<?php echo e($heroImage); ?>" alt="<?php echo e($specialization->name); ?>" class="page-header__bg" />
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
      <a href="<?php echo e(route('doctors')); ?>"><?php echo e(__('frontend.breadcrumb.doctors')); ?></a>
      <span class="page-header__breadcrumb-sep">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span>
      <span><?php echo e($specialization->name); ?></span>
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

<!-- ===================== Specialization Content ===================== -->
<section class="about">
  <svg class="about__decor" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <pattern id="about-dots" width="10" height="10" patternUnits="userSpaceOnUse">
      <circle cx="2" cy="2" r="2" fill="currentColor" />
    </pattern>
    <rect width="100" height="100" fill="url(#about-dots)" />
  </svg>

  <div class="container mx-auto">
    <div class="about__grid">
      <?php if($specialization->image): ?>
      <div class="about__media">
        <div class="about__photo-wrap">
          <img src="<?php echo e(asset('storage/' . $specialization->image)); ?>" alt="<?php echo e($specialization->name); ?>" class="about__photo" />
        </div>
      </div>
      <?php endif; ?>

      <div class="about__content" <?php if(!$specialization->image): ?> style="grid-column: 1 / -1;" <?php endif; ?>>
        <?php if($specialization->heading): ?>
        <h2 class="about__title"><?php echo e($specialization->heading); ?></h2>
        <?php else: ?>
        <h2 class="about__title">About <?php echo e($specialization->name); ?></h2>
        <?php endif; ?>

        <?php if($specialization->content): ?>
        <div class="about__desc about__desc--rich">
          <?php echo nl2br(e($specialization->content)); ?>

        </div>
        <?php else: ?>
        <p class="about__desc"><?php echo e($specialization->description ?? 'Specialized medical care in ' . $specialization->name . '.'); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- ===================== Doctors ===================== -->
<?php
$doctorCards = $doctors->isNotEmpty()
? $doctors->map(fn ($d) => [
'name' => $d->name,
'role' => $d->role,
'photo' => $d->photo ? asset('storage/' . $d->photo) : asset('assets/img/team-3.png'),
'url' => route('doctor-details', $d->slug),
'facebook' => $d->facebook_url,
'youtube' => $d->youtube_url,
'linkedin' => $d->linkedin_url,
])
: collect();
?>

<?php if($doctorCards->isNotEmpty()): ?>
<section class="doctors-page bg-gray-50 pt-16 pb-20">
  <div class="container mx-auto">
    <div class="team__head">
      <p class="team__eyebrow">
        <span class="team__eyebrow-dot"></span>
        <?php echo e($doc['doc_badge'] ?? 'Our Team Member'); ?>

        <span class="team__eyebrow-dot"></span>
      </p>
      <h2 class="team__title"><?php echo e($specialization->name); ?> Specialists</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8 mt-12">
      <?php $__currentLoopData = $doctorCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <article class="bg-white rounded-lg overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:shadow-[0_4px_25px_rgba(0,0,0,0.1)] transition-shadow duration-300 group h-full border border-gray-100">
        <!-- Image & Overlay -->
        <div class="relative overflow-hidden aspect-[4/5] bg-gray-50 flex items-end justify-center">
          <a href="<?php echo e($card['url']); ?>" class="absolute inset-0 z-0">
             <img src="<?php echo e($card['photo']); ?>" alt="<?php echo e($card['name']); ?>" class="w-full h-full object-cover object-top" />
          </a>
          <!-- Hover Overlay with Social Icons -->
          <div class="absolute inset-0 bg-white/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px] pointer-events-none">
            <div class="flex items-center gap-3 translate-y-4 group-hover:translate-y-0 transition-transform duration-300 pointer-events-auto">
              <a href="<?php echo e($card['facebook'] ?: '#'); ?>" class="w-10 h-10 rounded-full bg-white text-navy flex items-center justify-center hover:bg-brand-cyan hover:text-white shadow-lg transition-colors" aria-label="Facebook">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
              </a>
              <a href="<?php echo e($card['linkedin'] ?: '#'); ?>" class="w-10 h-10 rounded-full bg-white text-navy flex items-center justify-center hover:bg-brand-cyan hover:text-white shadow-lg transition-colors" aria-label="LinkedIn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>
              </a>
              <a href="<?php echo e($card['url']); ?>" class="w-10 h-10 rounded-full bg-brand-cyan text-white flex items-center justify-center hover:bg-navy shadow-lg transition-colors" aria-label="View Profile">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
              </a>
            </div>
          </div>
        </div>
        <!-- Content -->
        <div class="p-6 text-center border-t border-gray-100">
          <p class="text-gray-500 text-[13px] mb-1.5"><?php echo e($card['role']); ?></p>
          <a href="<?php echo e($card['url']); ?>" class="inline-block hover:text-brand-cyan transition-colors">
            <h3 class="text-navy text-[19px] font-bold"><?php echo e($card['name']); ?></h3>
          </a>
        </div>
      </article>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/frontend/doctor-specialization.blade.php ENDPATH**/ ?>