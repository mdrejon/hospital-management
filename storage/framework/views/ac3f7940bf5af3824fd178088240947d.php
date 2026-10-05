<?php
  $postUrl   = route('blog-details', $post->slug);
  $heroImage = $post->feature_image ? asset('storage/' . $post->feature_image) : asset('assets/img/slider-1.3.jpg');
  $ogImage   = $post->og_image ?: $post->feature_image;

  $seoTitle = $post->meta_title ?: ($blog['blog_seo_title'] ?? null) ?: ($post->title . ' | ClinicMaster Medical & Health Care Services');
  $seoDesc  = $post->meta_description ?: $post->excerpt ?: ($blog['blog_seo_description'] ?? null) ?: \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 160);
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>
<?php if(!empty($post->meta_keywords)): ?>
<?php $__env->startSection('meta_keywords', $post->meta_keywords); ?>
<?php endif; ?>
<?php if($ogImage): ?>
<?php $__env->startSection('og_image', asset('storage/' . $ogImage)); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>

    <!-- ===================== Breadcrumb / Page header ===================== -->
    <section class="page-header">
      <div class="page-header__media">
        <img src="<?php echo e(asset('assets/img/breadcumb.webp')); ?>" alt="Team of ClinicMaster doctors" class="page-header__bg" />
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
        <h1 class="page-header__title">Blog Details</h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="<?php echo e(route('home')); ?>">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <a href="<?php echo e(route('blog-list')); ?>">Blog</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span><?php echo e(\Illuminate\Support\Str::limit($post->title, 40)); ?></span>
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

    <!-- ===================== Blog Details ===================== -->
    <section class="blog-list">
      <div class="container mx-auto">
        <div class="blog-list__grid">
          <article class="blog-details__article">
            <img src="<?php echo e($heroImage); ?>" alt="<?php echo e($post->title); ?>" class="blog-details__hero-img" />

            <p class="blog-details__meta">
              <?php echo e(($post->published_at ?: $post->created_at)->format('F j, Y')); ?>

              <span class="blog-post-card__meta-dot"></span>
              BY <span class="blog-post-card__meta-author"><?php echo e($post->author_name ?: 'ClinicMaster Team'); ?></span>
            </p>
            <h2 class="blog-details__title"><?php echo e($post->title); ?></h2>

            <?php if($post->content): ?>
              <?php echo $post->content; ?>

            <?php elseif($post->excerpt): ?>
              <p class="blog-details__text"><?php echo e($post->excerpt); ?></p>
            <?php endif; ?>

            <div class="blog-details__share">
              <?php if(!empty($post->tags)): ?>
              <div class="blog-details__share-tags">
                <span class="blog-details__share-label">Tags:</span>
                <?php $__currentLoopData = $post->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('blog-list', ['tag' => $tag])); ?>" class="blog-details__share-tag"><?php echo e($tag); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
              <?php endif; ?>
              <div class="blog-details__share-socials">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode($postUrl)); ?>" target="_blank" rel="noopener" class="blog-details__share-social" aria-label="Share on Facebook">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode($postUrl)); ?>&text=<?php echo e(urlencode($post->title)); ?>" target="_blank" rel="noopener" class="blog-details__share-social" aria-label="Share on Twitter">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 0 1-1.9.1c.5 1.7 2.1 2.9 4 2.9A8.2 8.2 0 0 1 2 18.6a11.6 11.6 0 0 0 6.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z"/></svg>
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo e(urlencode($postUrl)); ?>" target="_blank" rel="noopener" class="blog-details__share-social" aria-label="Share on LinkedIn">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>
                </a>
                <a href="#" class="blog-details__share-social" aria-label="Share on Instagram">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></svg>
                </a>
              </div>
            </div>

            <div class="blog-details__author">
              <img src="<?php echo e($post->author_avatar ? asset('storage/' . $post->author_avatar) : asset('assets/img/about-image.webp')); ?>" alt="<?php echo e($post->author_name ?: 'ClinicMaster Team'); ?>" class="blog-details__author-photo" />
              <div>
                <h3 class="blog-details__author-name">By <?php echo e($post->author_name ?: 'ClinicMaster Team'); ?></h3>
                <p class="blog-details__author-bio">
                  <?php echo e($post->author_bio ?: 'A dedicated medical professional with extensive experience in providing compassionate, patient-centered care committed to the well-being of every patient.'); ?>

                </p>
              </div>
            </div>

            <?php if($related->isNotEmpty()): ?>
            <div class="related-blog">
              <h3 class="related-blog__title">Related Blog</h3>
              <div class="related-blog__grid">
                <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('blog-details', $rp->slug)); ?>" class="related-card">
                  <img src="<?php echo e($rp->feature_image ? asset('storage/' . $rp->feature_image) : asset('assets/img/sr-1-3.jpg')); ?>" alt="<?php echo e($rp->title); ?>" class="related-card__img" />
                  <span class="related-card__overlay" aria-hidden="true"></span>
                  <span class="related-card__date"><span class="related-card__date-dot"></span><?php echo e(($rp->published_at ?: $rp->created_at)->format('F j, Y')); ?></span>
                  <h4 class="related-card__name"><?php echo e($rp->title); ?></h4>
                  <span class="related-card__arrow">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
            <?php endif; ?>

            <div class="comments">
              <h3 class="comments__count"><?php echo e($post->approvedComments()->count()); ?> Comments</h3>
              <h4 class="comments__title">Leave A Reply</h4>

              <?php if(session('success')): ?>
              <p class="blog-post-card__desc" style="color: #16a34a;"><?php echo e(session('success')); ?></p>
              <?php endif; ?>

              <form class="comments__form" action="<?php echo e(route('blog-comments.store', $post->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="comments__row">
                  <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="comments__input" placeholder="Name" required />
                  <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="comments__input" placeholder="Email" required />
                </div>
                <textarea name="message" class="comments__textarea" placeholder="Comment" required><?php echo e(old('message')); ?></textarea>
                <?php if($errors->any()): ?>
                <p class="blog-post-card__desc" style="color: #dc2626;"><?php echo e($errors->first()); ?></p>
                <?php endif; ?>
                <button type="submit" class="comments__submit">Submit Now</button>
              </form>
            </div>
          </article>

          <aside class="blog-sidebar" data-sticky-sidebar>
            <!-- Search -->
            <div class="blog-sidebar__card">
              <h3 class="blog-sidebar__title">Search</h3>
              <form class="blog-sidebar__search" action="<?php echo e(route('blog-list')); ?>" method="GET">
                <input type="text" name="q" class="blog-sidebar__search-input" placeholder="Search.." />
                <button type="submit" class="blog-sidebar__search-btn" aria-label="Search">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                    <path d="m20 20-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  </svg>
                </button>
              </form>
            </div>

            <!-- Category -->
            <div class="blog-sidebar__card">
              <h3 class="blog-sidebar__title">Category</h3>
              <div class="blog-sidebar__cat-list">
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('blog-list', ['category' => $cat->slug])); ?>" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    <?php echo e($cat->name); ?>

                  </span>
                  <span class="blog-sidebar__cat-count">(<?php echo e($cat->blogs_count); ?>)</span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php $__currentLoopData = [['Acupressure',4],['Walking',3],['Food',3],['Therapy',5],['Health',1],['Allgemein',3],['Blood',2],['Mental Health',2]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$name, $count]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    <?php echo e($name); ?>

                  </span>
                  <span class="blog-sidebar__cat-count">(<?php echo e($count); ?>)</span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </div>
            </div>

            <!-- Latest Post -->
            <div class="blog-sidebar__card">
              <h3 class="blog-sidebar__title">Latest Post</h3>
              <div class="blog-sidebar__latest-list">
                <?php $__empty_1 = true; $__currentLoopData = $latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('blog-details', $lp->slug)); ?>" class="blog-sidebar__latest-item">
                  <img src="<?php echo e($lp->feature_image ? asset('storage/' . $lp->feature_image) : asset('assets/img/sr-1-3.jpg')); ?>" alt="" class="blog-sidebar__latest-thumb" />
                  <div>
                    <p class="blog-sidebar__latest-date"><?php echo e(($lp->published_at ?: $lp->created_at)->format('F j, Y')); ?></p>
                    <p class="blog-sidebar__latest-title"><?php echo e(\Illuminate\Support\Str::limit($lp->title, 38)); ?></p>
                  </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php $__currentLoopData = [
                  ['img' => asset('assets/img/projects-3.jpg'), 'date' => 'July 14, 2025', 'title' => 'Cardiovascular Disease: New Treatments a ...'],
                  ['img' => asset('assets/img/sr-1-3.jpg'),     'date' => 'July 14, 2025', 'title' => 'Aging and Longevity: Exploring the Scien ...'],
                  ['img' => asset('assets/img/sr-1-2.jpg'),     'date' => 'July 14, 2025', 'title' => 'Mental Health in the Modern World: Break ...'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="#" class="blog-sidebar__latest-item">
                  <img src="<?php echo e($lp['img']); ?>" alt="" class="blog-sidebar__latest-thumb" />
                  <div>
                    <p class="blog-sidebar__latest-date"><?php echo e($lp['date']); ?></p>
                    <p class="blog-sidebar__latest-title"><?php echo e($lp['title']); ?></p>
                  </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </div>
            </div>

            <!-- Tags -->
            <div class="blog-sidebar__card">
              <h3 class="blog-sidebar__title">Tags</h3>
              <div class="blog-sidebar__tags">
                <?php $__empty_1 = true; $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('blog-list', ['tag' => $t['name']])); ?>" class="blog-sidebar__tag"><?php echo e($t['name']); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php $__currentLoopData = ['Food','Walking','Mental Health','Acupressure','Health','Blood']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tagName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="#" class="blog-sidebar__tag"><?php echo e($tagName); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\frontend\blog-details.blade.php ENDPATH**/ ?>