<?php
  $heroTitle = $doc['doc_page_hero_title'] ?? 'Our Doctors';
  $heroImage = !empty($doc['doc_page_hero_image']) ? asset('storage/' . $doc['doc_page_hero_image']) : asset('assets/img/breadcumb.webp');
  $seoTitle  = $doc['doc_seo_title'] ?? 'Our Doctors | ClinicMaster Medical & Health Care Services';
  $seoDesc   = $doc['doc_seo_description'] ?? 'Meet the team of ClinicMaster doctors dedicated to compassionate, expert medical care.';
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>
<?php if(!empty($doc['doc_seo_keywords'])): ?>
<?php $__env->startSection('meta_keywords', $doc['doc_seo_keywords']); ?>
<?php endif; ?>
<?php if(!empty($doc['doc_seo_og_image'])): ?>
<?php $__env->startSection('og_image', asset('storage/' . $doc['doc_seo_og_image'])); ?>
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
          <span>Doctors</span>
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

    <!-- ===================== Doctors ===================== -->
    <?php
      $doctorCards = $doctors->isNotEmpty()
        ? $doctors->map(fn ($d) => [
            'name'     => $d->name,
            'role'     => $d->role,
            'photo'    => $d->photo ? asset('storage/' . $d->photo) : asset('assets/img/team-3.png'),
            'url'      => route('doctor-details', $d->slug),
            'facebook' => $d->facebook_url,
            'youtube'  => $d->youtube_url,
            'linkedin' => $d->linkedin_url,
          ])
        : collect([
            ['name' => 'Dr. Laron Metar',   'role' => 'Practice Service',   'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
            ['name' => 'Dr. Smith Karo',    'role' => 'Founder',            'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
            ['name' => 'Dr. Merata Baron',  'role' => 'Emergency Services', 'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
            ['name' => 'Dr. Elena Cross',   'role' => 'Cardiologist',       'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
            ['name' => 'Dr. Michael Reyes', 'role' => 'Pediatrician',       'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
            ['name' => 'Dr. Sara Owens',    'role' => 'Neurologist',        'photo' => asset('assets/img/team-3.png'), 'url' => '#', 'facebook' => null, 'youtube' => null, 'linkedin' => null],
          ]);
    ?>
    <section class="doctors-page">
      <div class="container mx-auto">
        <div class="team__head">
          <p class="team__eyebrow">
            <span class="team__eyebrow-dot"></span>
            <?php echo e($doc['doc_badge'] ?? 'Our Team Member'); ?>

            <span class="team__eyebrow-dot"></span>
          </p>
          <h2 class="team__title"><?php echo e($doc['doc_title'] ?? 'Meet Our Doctor Meeting'); ?></h2>
        </div>

        <div class="doctors-page__grid">
          <?php $__currentLoopData = $doctorCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <article class="team-card">
            <span class="team-card__corner" aria-hidden="true"></span>

            <div class="team-card__photo-wrap">
              <img src="<?php echo e($card['photo']); ?>" alt="<?php echo e($card['name']); ?>" class="team-card__photo" />
              <span class="team-card__overlay">
                <a href="<?php echo e($card['url']); ?>" class="team-card__view" aria-label="View <?php echo e($card['name']); ?> profile">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m10 6 6 6-6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
              </span>
            </div>

            <div class="team-card__social">
              <a href="<?php echo e($card['facebook'] ?: '#'); ?>" class="team-card__social-link" aria-label="Facebook">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
              </a>
              <a href="#" class="team-card__social-link" aria-label="Pinterest">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.5 2 3 5.9 3 10.2c0 2.6 1.4 4.6 3.5 5.4.3.1.6 0 .7-.4l.3-1.1c.1-.3 0-.5-.2-.8-.5-.6-.9-1.5-.9-2.7 0-3.5 2.6-6.6 6.8-6.6 3.7 0 5.7 2.3 5.7 5.3 0 4-1.8 7.4-4.4 7.4-1.5 0-2.6-1.2-2.2-2.7.4-1.7 1.2-3.6 1.2-4.9 0-1.1-.6-2.1-1.9-2.1-1.5 0-2.7 1.6-2.7 3.6 0 1.3.4 2.2.4 2.2l-1.8 7.5c-.5 2.2-.1 4.9 0 5.2 0 .2.2.2.3.1.1-.2 1.7-2.1 2.3-4.1l.9-3.4c.4.8 1.7 1.5 3.1 1.5 4.1 0 6.9-3.7 6.9-8.7C21 5.8 17.3 2 12 2z"/></svg>
              </a>
              <a href="<?php echo e($card['youtube'] ?: '#'); ?>" class="team-card__social-link" aria-label="YouTube">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M23 12s0-3.6-.5-5.3c-.3-1-1-1.8-2-2C18.9 4.2 12 4.2 12 4.2s-6.9 0-8.5.5c-1 .3-1.7 1-2 2C1 8.4 1 12 1 12s0 3.6.5 5.3c.3 1 1 1.8 2 2 1.6.5 8.5.5 8.5.5s6.9 0 8.5-.5c1-.3 1.7-1 2-2 .5-1.7.5-5.3.5-5.3zM9.8 15.5V8.5l6.2 3.5-6.2 3.5z"/></svg>
              </a>
              <a href="<?php echo e($card['linkedin'] ?: '#'); ?>" class="team-card__social-link" aria-label="LinkedIn">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>
              </a>
            </div>

            <div class="team-card__body">
              <h3 class="team-card__name"><?php echo e($card['name']); ?></h3>
              <p class="team-card__role"><?php echo e($card['role']); ?></p>
            </div>
          </article>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\frontend\doctors.blade.php ENDPATH**/ ?>