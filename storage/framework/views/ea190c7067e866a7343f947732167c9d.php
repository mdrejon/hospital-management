<?php $__env->startSection('title', 'Blog | ClinicMaster Medical & Health Care Services'); ?>

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
        <h1 class="page-header__title">Our Blog</h1>
        <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
          <a href="<?php echo e(route('home')); ?>">Home</a>
          <span class="page-header__breadcrumb-sep">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span>Blog</span>
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

    <!-- ===================== Services ===================== -->
    <!-- ===================== Doctors ===================== -->
    <!-- ===================== Blog List ===================== -->
    <section class="blog-list">
      <div class="container mx-auto">
        <div class="blog-list__grid">
          <div class="blog-list__posts">
            <!-- Aging and Longevity -->
            <article class="blog-post-card">
              <div class="blog-post-card__media">
                <img src="<?php echo e(asset('assets/img/sr-1-3.jpg')); ?>" alt="Doctor reading a book" class="blog-post-card__img" />
              </div>
              <div>
                <p class="blog-post-card__meta">
                  July 14, 2025
                  <span class="blog-post-card__meta-dot"></span>
                  BY <span class="blog-post-card__meta-author">Kelly Smith</span>
                </p>
                <h3 class="blog-post-card__title">Aging and Longevity: Exploring the Science of Healthy A ...</h3>
                <p class="blog-post-card__desc">
                  Explore how science is redefining aging with breakthroughs in health and longevity. Learn simple,
                  effective habits to help ...
                </p>
                <a href="<?php echo e(route('blog-details')); ?>" class="blog-post-card__btn">
                  Read More
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
              </div>
            </article>

            <!-- Cardiovascular Disease -->
            <article class="blog-post-card">
              <div class="blog-post-card__media">
                <img src="<?php echo e(asset('assets/img/projects-3.jpg')); ?>" alt="Doctor holding a heart model" class="blog-post-card__img" />
              </div>
              <div>
                <p class="blog-post-card__meta">
                  July 14, 2025
                  <span class="blog-post-card__meta-dot"></span>
                  BY <span class="blog-post-card__meta-author">Kelly Smith</span>
                </p>
                <h3 class="blog-post-card__title">Cardiovascular Disease: New Treatments and Preventative ...</h3>
                <p class="blog-post-card__desc">
                  Heart disease may be common, but it's increasingly preventable. Explore new treatments and
                  strategies that support a longer ...
                </p>
                <a href="<?php echo e(route('blog-details')); ?>" class="blog-post-card__btn">
                  Read More
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
              </div>
            </article>

            <!-- Mental Health in the Modern World -->
            <article class="blog-post-card">
              <div class="blog-post-card__media">
                <img src="<?php echo e(asset('assets/img/sr-1-2.jpg')); ?>" alt="Therapist comforting a patient" class="blog-post-card__img" />
              </div>
              <div>
                <p class="blog-post-card__meta">
                  July 14, 2025
                  <span class="blog-post-card__meta-dot"></span>
                  BY <span class="blog-post-card__meta-author">Kelly Smith</span>
                </p>
                <h3 class="blog-post-card__title">Mental Health in the Modern World: Breaking the Stigma ...</h3>
                <p class="blog-post-card__desc">
                  Mental health is more visible than ever, but stigma still lingers. Explore how awareness, access,
                  and compassion are ...
                </p>
                <a href="<?php echo e(route('blog-details')); ?>" class="blog-post-card__btn">
                  Read More
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
              </div>
            </article>

            <!-- Strategies for Balancing Business Demands -->
            <article class="blog-post-card">
              <div class="blog-post-card__media">
                <img src="<?php echo e(asset('assets/img/appoinment.jpg')); ?>" alt="Doctor consulting with a patient" class="blog-post-card__img" />
              </div>
              <div>
                <p class="blog-post-card__meta">
                  July 9, 2025
                  <span class="blog-post-card__meta-dot"></span>
                  BY <span class="blog-post-card__meta-author">Kelly Smith</span>
                </p>
                <h3 class="blog-post-card__title">Strategies for Balancing Business Demands with Optimal ...</h3>
                <p class="blog-post-card__desc">
                  Running a practice while delivering great care is a balancing act. Discover practical strategies
                  for managing both without ...
                </p>
                <a href="<?php echo e(route('blog-details')); ?>" class="blog-post-card__btn">
                  Read More
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
              </div>
            </article>

            <!-- The Impact of Artificial Intelligence on Medical -->
            <article class="blog-post-card">
              <div class="blog-post-card__media">
                <img src="<?php echo e(asset('assets/img/about-image.webp')); ?>" alt="Two doctors smiling in a clinic" class="blog-post-card__img" />
              </div>
              <div>
                <p class="blog-post-card__meta">
                  July 14, 2025
                  <span class="blog-post-card__meta-dot"></span>
                  BY <span class="blog-post-card__meta-author">Kelly Smith</span>
                </p>
                <h3 class="blog-post-card__title">The Impact of Artificial Intelligence on Medical.</h3>
                <p class="blog-post-card__desc">
                  AI is transforming how we diagnose, treat, and manage health. Discover the groundbreaking role it
                  plays in the ...
                </p>
                <a href="<?php echo e(route('blog-details')); ?>" class="blog-post-card__btn">
                  Read More
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
              </div>
            </article>

            <!-- The Role of Nutrition in Preventative Medicine -->
            <article class="blog-post-card">
              <div class="blog-post-card__media">
                <img src="<?php echo e(asset('assets/img/slider-1.3.jpg')); ?>" alt="Medical team wearing masks" class="blog-post-card__img" />
              </div>
              <div>
                <p class="blog-post-card__meta">
                  July 14, 2025
                  <span class="blog-post-card__meta-dot"></span>
                  BY <span class="blog-post-card__meta-author">Kelly Smith</span>
                </p>
                <h3 class="blog-post-card__title">The Role of Nutrition in Preventative Medicine</h3>
                <p class="blog-post-card__desc">
                  Nutrition isn't just about diet—it's a pillar of disease prevention. Explore how the right foods
                  can protect your ...
                </p>
                <a href="<?php echo e(route('blog-details')); ?>" class="blog-post-card__btn">
                  Read More
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
              </div>
            </article>

            <button type="button" class="blog-list__load-more">Load More</button>
          </div>

          <aside class="blog-sidebar" data-sticky-sidebar>
            <!-- Search -->
            <div class="blog-sidebar__card">
              <h3 class="blog-sidebar__title">Search</h3>
              <form class="blog-sidebar__search">
                <input type="text" class="blog-sidebar__search-input" placeholder="Search.." />
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
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Acupressure
                  </span>
                  <span class="blog-sidebar__cat-count">(4)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Walking
                  </span>
                  <span class="blog-sidebar__cat-count">(3)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Food
                  </span>
                  <span class="blog-sidebar__cat-count">(3)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Therapy
                  </span>
                  <span class="blog-sidebar__cat-count">(5)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Health
                  </span>
                  <span class="blog-sidebar__cat-count">(1)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Allgemein
                  </span>
                  <span class="blog-sidebar__cat-count">(3)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Blood
                  </span>
                  <span class="blog-sidebar__cat-count">(2)</span>
                </a>
                <a href="#" class="blog-sidebar__cat-link">
                  <span class="blog-sidebar__cat-left">
                    <span class="blog-sidebar__cat-arrow">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    Mental Health
                  </span>
                  <span class="blog-sidebar__cat-count">(2)</span>
                </a>
              </div>
            </div>

            <!-- Latest Post -->
            <div class="blog-sidebar__card">
              <h3 class="blog-sidebar__title">Latest Post</h3>
              <div class="blog-sidebar__latest-list">
                <a href="<?php echo e(route('blog-details')); ?>" class="blog-sidebar__latest-item">
                  <img src="<?php echo e(asset('assets/img/projects-3.jpg')); ?>" alt="" class="blog-sidebar__latest-thumb" />
                  <div>
                    <p class="blog-sidebar__latest-date">July 14, 2025</p>
                    <p class="blog-sidebar__latest-title">Cardiovascular Disease: New Treatments a ...</p>
                  </div>
                </a>
                <a href="<?php echo e(route('blog-details')); ?>" class="blog-sidebar__latest-item">
                  <img src="<?php echo e(asset('assets/img/sr-1-3.jpg')); ?>" alt="" class="blog-sidebar__latest-thumb" />
                  <div>
                    <p class="blog-sidebar__latest-date">July 14, 2025</p>
                    <p class="blog-sidebar__latest-title">Aging and Longevity: Exploring the Scien ...</p>
                  </div>
                </a>
                <a href="<?php echo e(route('blog-details')); ?>" class="blog-sidebar__latest-item">
                  <img src="<?php echo e(asset('assets/img/sr-1-2.jpg')); ?>" alt="" class="blog-sidebar__latest-thumb" />
                  <div>
                    <p class="blog-sidebar__latest-date">July 14, 2025</p>
                    <p class="blog-sidebar__latest-title">Mental Health in the Modern World: Break ...</p>
                  </div>
                </a>
              </div>
            </div>

            <!-- Tags -->
            <div class="blog-sidebar__card">
              <h3 class="blog-sidebar__title">Tags</h3>
              <div class="blog-sidebar__tags">
                <a href="#" class="blog-sidebar__tag">Food</a>
                <a href="#" class="blog-sidebar__tag">Walking</a>
                <a href="#" class="blog-sidebar__tag">Mental Health</a>
                <a href="#" class="blog-sidebar__tag">Acupressure</a>
                <a href="#" class="blog-sidebar__tag">Health</a>
                <a href="#" class="blog-sidebar__tag">Blood</a>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/frontend/blog-list.blade.php ENDPATH**/ ?>