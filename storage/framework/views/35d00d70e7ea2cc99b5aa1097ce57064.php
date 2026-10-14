<?php
  $heroTitle    = $pageSettings['video_gallery_hero_title'] ?? 'Video Gallery';
  $heroSubtitle = $pageSettings['video_gallery_hero_subtitle'] ?? 'Watch our medical documentaries, expert doctor interviews, surgical showcases, and patient recovery stories.';
  $heroImage    = !empty($pageSettings['video_gallery_banner_image']) ? asset('storage/' . $pageSettings['video_gallery_banner_image']) : asset('assets/img/breadcumb.webp');
  $seoTitle     = $pageSettings['video_gallery_seo_title'] ?? ('Video Gallery | ' . config('app.name'));
  $seoDesc      = $pageSettings['video_gallery_seo_description'] ?? "Explore Modern Hospital's video gallery featuring patient testimonials, advanced surgery walkthroughs, and health tips.";
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>

<?php $__env->startSection('content'); ?>

    <!-- ===================== Breadcrumb / Page header ===================== -->
    <section class="page-header">
      <div class="page-header__media">
        <img src="<?php echo e($heroImage); ?>" alt="Hospital Video Gallery" class="page-header__bg" />
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
          <a href="<?php echo e(route('home')); ?>"><?php echo e(__('frontend.nav.home')); ?></a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span>Video Gallery</span>
        </nav>
      </div>

      <a href="tel:<?php echo e(preg_replace('/[^0-9+]/', '', $headerSettings['header_phone'] ?? '11234567890')); ?>" class="page-header__call">
        <span class="page-header__call-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
          </svg>
        </span>
        <span class="page-header__call-text"><?php echo e($headerSettings['header_phone'] ?? '1 123 456 7890'); ?></span>
      </a>
    </section>

    <!-- ===================== Video Gallery Section ===================== -->
    <section class="video-gallery-section">
      <div class="container mx-auto">
        <div class="team__head">
          <p class="team__eyebrow">
            <span class="team__eyebrow-dot"></span>
            <?php echo e($pageSettings['video_gallery_badge'] ?? 'Our Video Gallery'); ?>

            <span class="team__eyebrow-dot"></span>
          </p>
          <h2 class="team__title"><?php echo e($pageSettings['video_gallery_title'] ?? 'Explore Our Healthcare Stories'); ?></h2>
        </div>

        <?php if(!empty($heroSubtitle)): ?>
        <p class="gallery__desc">
          <?php echo e($heroSubtitle); ?>

        </p>
        <?php endif; ?>

        <?php
          $videoItems = $videos->isNotEmpty()
            ? $videos
            : collect([
                (object)[
                  'id' => 1,
                  'title' => 'World-Class Cardiovascular Surgery Department Showcase',
                  'subtitle' => 'Take a look inside our cutting-edge catheterization lab and heart surgery units.',
                  'video_type' => 'youtube',
                  'video_id' => 'dQw4w9WgXcQ',
                  'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                  'thumbnail_image' => 'assets/img/sr-1-1.jpg',
                  'duration' => '04:15',
                  'is_featured' => true,
                ],
                (object)[
                  'id' => 2,
                  'title' => 'Patient Recovery Testimonial: Kidney Transplant Success',
                  'subtitle' => 'How our dedicated nephrology team gave Mr. Kamal a second chance at life.',
                  'video_type' => 'youtube',
                  'video_id' => 'dQw4w9WgXcQ',
                  'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                  'thumbnail_image' => 'assets/img/slider-1.2.jpg',
                  'duration' => '03:40',
                  'is_featured' => false,
                ],
                (object)[
                  'id' => 3,
                  'title' => 'Advanced MRI & CT Scan Diagnostic Imaging Lab Tour',
                  'subtitle' => 'Fast, ultra-precise imaging technology for accurate patient diagnosis.',
                  'video_type' => 'youtube',
                  'video_id' => 'dQw4w9WgXcQ',
                  'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                  'thumbnail_image' => 'assets/img/projects-4.jpg',
                  'duration' => '05:20',
                  'is_featured' => false,
                ],
                (object)[
                  'id' => 4,
                  'title' => '24/7 Emergency Trauma & Ambulance Service Overview',
                  'subtitle' => 'Our rapid-response medical personnel saving lives around the clock.',
                  'video_type' => 'youtube',
                  'video_id' => 'dQw4w9WgXcQ',
                  'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                  'thumbnail_image' => 'assets/img/slider-1.3.jpg',
                  'duration' => '02:50',
                  'is_featured' => false,
                ],
                (object)[
                  'id' => 5,
                  'title' => 'Pediatric Care & Child Health Department Walkthrough',
                  'subtitle' => 'Creating a gentle, fearless clinical environment for our young patients.',
                  'video_type' => 'youtube',
                  'video_id' => 'dQw4w9WgXcQ',
                  'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                  'thumbnail_image' => 'assets/img/projects-2.jpg',
                  'duration' => '04:00',
                  'is_featured' => false,
                ],
                (object)[
                  'id' => 6,
                  'title' => 'Doctor Insights: Preventive Health Checkups for Families',
                  'subtitle' => 'Essential yearly screenings that keep you and your loved ones protected.',
                  'video_type' => 'youtube',
                  'video_id' => 'dQw4w9WgXcQ',
                  'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                  'thumbnail_image' => 'assets/img/sr-1-2.jpg',
                  'duration' => '06:10',
                  'is_featured' => false,
                ],
            ]);
        ?>

        <!-- Videos Grid -->
        <div class="video-gallery__grid">
          <?php $__currentLoopData = $videoItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $vTitle = is_array($item->title) ? ($item->title[app()->getLocale()] ?? reset($item->title)) : $item->title;
              $vSub   = is_array($item->subtitle) ? ($item->subtitle[app()->getLocale()] ?? reset($item->subtitle)) : $item->subtitle;
              $thumb  = !empty($item->thumbnail_image) 
                ? (str_starts_with($item->thumbnail_image, 'http') || str_starts_with($item->thumbnail_image, 'assets/') ? asset($item->thumbnail_image) : asset('storage/' . $item->thumbnail_image))
                : asset('assets/img/breadcumb.webp');
              
              // Embed link calculation
              $embedUrl = $item->video_url;
              if ($item->video_type === 'youtube' && !empty($item->video_id)) {
                $embedUrl = "https://www.youtube.com/embed/{$item->video_id}?autoplay=1";
              } elseif ($item->video_type === 'vimeo' && !empty($item->video_id)) {
                $embedUrl = "https://player.vimeo.com/video/{$item->video_id}?autoplay=1";
              }
            ?>

            <article class="video-card group">
              <!-- Video Thumbnail & Play Trigger -->
              <div class="video-card__media js-video-trigger" data-embed="<?php echo e($embedUrl); ?>" data-type="<?php echo e($item->video_type); ?>" data-title="<?php echo e($vTitle); ?>">
                <img src="<?php echo e($thumb); ?>" alt="<?php echo e($vTitle); ?>" class="video-card__img" />
                <span class="video-card__overlay"></span>
                
                <!-- Animated Play Button -->
                <button type="button" class="video-card__play" aria-label="Play <?php echo e($vTitle); ?>">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                </button>

                <!-- Video Type Badge -->
                <span class="video-card__badge-type">
                  <?php echo e(strtoupper($item->video_type ?? 'VIDEO')); ?>

                </span>

                <?php if(!empty($item->duration)): ?>
                  <span class="video-card__badge-duration">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <?php echo e($item->duration); ?>

                  </span>
                <?php endif; ?>
              </div>

              <!-- Card Content Body -->
              <div class="video-card__body">
                <div>
                  <div class="video-card__meta">
                    <span class="video-card__tag">
                      <span class="video-card__tag-dot"></span>
                      Modern Hospital
                    </span>
                    <?php if(!empty($item->is_featured)): ?>
                      <span class="video-card__featured-pill">Featured</span>
                    <?php endif; ?>
                  </div>

                  <h3 class="video-card__title">
                    <a href="javascript:void(0)" class="js-video-trigger" data-embed="<?php echo e($embedUrl); ?>" data-type="<?php echo e($item->video_type); ?>" data-title="<?php echo e($vTitle); ?>">
                      <?php echo e($vTitle); ?>

                    </a>
                  </h3>

                  <?php if(!empty($vSub)): ?>
                    <p class="video-card__desc">
                      <?php echo e($vSub); ?>

                    </p>
                  <?php endif; ?>
                </div>

                <div class="video-card__footer">
                  <button type="button" class="video-card__btn js-video-trigger" data-embed="<?php echo e($embedUrl); ?>" data-type="<?php echo e($item->video_type); ?>" data-title="<?php echo e($vTitle); ?>">
                    <span>Watch Video</span>
                    <span class="video-card__btn-icon">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                  </button>
                  <span class="video-card__channel">HD Quality</span>
                </div>
              </div>
            </article>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

      </div>
    </section>

    <!-- ===================== Video Lightbox Modal ===================== -->
    <div id="videoModal" class="video-lightbox" role="dialog" aria-modal="true" aria-label="Video Player">
      <div class="video-lightbox__backdrop" id="videoModalBackdrop"></div>
      <div class="video-lightbox__container">
        <!-- Modal Header -->
        <div class="video-lightbox__header">
          <div class="video-lightbox__title-wrap">
            <span class="video-lightbox__dot"></span>
            <h4 id="videoModalTitle" class="video-lightbox__title">Video Player</h4>
          </div>
          <button type="button" id="closeVideoModal" class="video-lightbox__close" aria-label="Close video player">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>
        <!-- Responsive Iframe Container -->
        <div class="video-lightbox__player">
          <iframe id="videoIframe" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/frontend/video-gallery.blade.php ENDPATH**/ ?>