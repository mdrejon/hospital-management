<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'latestBlogs' => collect(),
    'blog' => [],
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'latestBlogs' => collect(),
    'blog' => [],
]); ?>
<?php foreach (array_filter(([
    'latestBlogs' => collect(),
    'blog' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
$blogEyebrow = $blog['blog_badge'] ?? 'Blog & News';
$blogTitle = !empty($blog['blog_home_title'])
    ? $blog['blog_home_title']
    : (__('frontend.home.blog_title') !== 'frontend.home.blog_title'
        ? __('frontend.home.blog_title')
        : 'Stay Informed The Latest in<br>Medical Care & Wellness');

$blogFallbackImages = [
    asset('assets/img/blog-one.png'),
    asset('assets/img/blog-2.png'),
    asset('assets/img/blog-4.jpg'),
    asset('assets/img/sr-1-1.jpg'),
];

$blogCards = $latestBlogs->isNotEmpty()
    ? $latestBlogs->values()->map(function ($b, $i) use ($blogFallbackImages) {
        return [
            'title'          => $b->title,
            'date'           => ($b->published_at ?: $b->created_at)->format('d M Y'),
            'image'          => $b->feature_image ? asset('storage/' . $b->feature_image) : ($blogFallbackImages[$i % 4] ?? asset('assets/img/blog-2.png')),
            'url'            => route('blog-details', $b->slug),
            'category'       => $b->category?->name ?? 'Medical Care',
            'comments_count' => $b->approved_comments_count ?? 0,
        ];
    })
    : collect([
        [
            'title'          => 'Understanding Telemedicine The New Era of Virtual Care',
            'date'           => '10 February 2025',
            'image'          => asset('assets/img/blog-one.png'),
            'url'            => route('blog-list'),
            'category'       => 'Medical Care',
            'comments_count' => 0,
        ],
        [
            'title'          => 'The Future of Healthcare Innovations in Medical Care',
            'date'           => '05 Feb 2025',
            'image'          => asset('assets/img/blog-2.png'),
            'url'            => route('blog-list'),
            'category'       => 'Innovations',
            'comments_count' => 0,
        ],
        [
            'title'          => 'Emergency Care You Need to Know Before a Crisis',
            'date'           => '05 Feb 2025',
            'image'          => asset('assets/img/blog-4.jpg'),
            'url'            => route('blog-list'),
            'category'       => 'Emergency',
            'comments_count' => 0,
        ],
        [
            'title'          => 'Best Role of Mental Health in Overall Well-Being',
            'date'           => '05 Feb 2025',
            'image'          => asset('assets/img/sr-1-1.jpg'),
            'url'            => route('blog-list'),
            'category'       => 'Mental Health',
            'comments_count' => 0,
        ],
    ]);

$primaryCard = $blogCards->first();
$secondaryCards = $blogCards->slice(1, 3);
?>

<section class="blog-v2 py-section bg-white relative overflow-hidden" data-blog-v2>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl 2xl:max-w-7xl 2k:max-w-[1720px] 4k:max-w-[2160px] relative z-10">
    
    <!-- Section Header (Centered) -->
    <div class="text-center max-w-2xl 2k:max-w-3xl 4k:max-w-4xl mx-auto mb-section-gap">
      <p class="text-eyebrow font-bold tracking-wider text-[#ef4444] uppercase mb-2 inline-block">
        <?php echo e($blogEyebrow); ?>

      </p>
      <h2 class="text-h2 font-extrabold text-navy tracking-tight">
        <?php echo $blogTitle; ?>

      </h2>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-stretch">
      
      <!-- Left Column: Featured Large Card -->
      <?php if($primaryCard): ?>
      <div class="lg:col-span-6 flex flex-col">
        <article class="group relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-[0_10px_30px_rgba(0,0,0,0.06)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)] transition-all duration-300 flex-1 min-h-[440px] sm:min-h-[500px] lg:min-h-[540px] flex flex-col justify-end">
          <!-- Background Image -->
          <img 
            src="<?php echo e($primaryCard['image']); ?>" 
            alt="<?php echo e($primaryCard['title']); ?>" 
            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" 
          />
          
          <!-- Gradient Overlay -->
          <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent pointer-events-none"></div>

          <!-- Bottom Card Content -->
          <div class="relative z-10 p-6 sm:p-8 lg:p-10 flex flex-col">
            <h3 class="mb-4">
              <a 
                href="<?php echo e($primaryCard['url']); ?>" 
                class="text-white font-bold text-h3 hover:text-brand-cyan transition-colors line-clamp-2 drop-shadow-sm"
              >
                <?php echo e($primaryCard['title']); ?>

              </a>
            </h3>

            <!-- Divider -->
            <div class="w-full h-px bg-white/20 mb-3.5"></div>

            <!-- Meta Row -->
            <div class="text-white/85 text-small font-medium flex flex-wrap items-center gap-2.5 sm:gap-3">
              <span><?php echo e($primaryCard['category']); ?></span>
              <span class="inline-block w-1 h-1 rounded-full bg-white/60"></span>
              <span><?php echo e($primaryCard['date']); ?></span>
              <span class="inline-block w-1 h-1 rounded-full bg-white/60"></span>
              <span class="inline-flex items-center gap-1.5">
                Comments <?php echo e($primaryCard['comments_count']); ?>

                <svg class="w-3.5 h-3.5 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                </svg>
              </span>
            </div>
          </div>
        </article>
      </div>
      <?php endif; ?>

      <!-- Right Column: 3 Horizontal Cards -->
      <div class="lg:col-span-6 flex flex-col justify-between gap-4 sm:gap-5 lg:gap-6">
        <?php $__currentLoopData = $secondaryCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article class="group flex flex-col sm:flex-row items-stretch gap-3.5 sm:gap-4 lg:gap-5 flex-1">
          <!-- Thumbnail Image -->
          <a 
            href="<?php echo e($secCard['url']); ?>" 
            class="w-full sm:w-44 md:w-52 lg:w-44 xl:w-52 aspect-[16/10] sm:aspect-[4/3] rounded-2xl overflow-hidden shrink-0 relative shadow-sm block"
          >
            <img 
              src="<?php echo e($secCard['image']); ?>" 
              alt="<?php echo e($secCard['title']); ?>" 
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" 
            />
          </a>

          <!-- Pastel Content Box -->
          <div class="flex-1 bg-[#eaf4f7] rounded-2xl p-4 sm:p-5 lg:p-6 flex flex-col justify-between transition-all duration-300 hover:bg-[#e0eff3] hover:shadow-sm">
            <h3 class="mb-2.5">
              <a 
                href="<?php echo e($secCard['url']); ?>" 
                class="text-navy font-bold text-h6 line-clamp-2 hover:text-brand-cyan transition-colors"
              >
                <?php echo e($secCard['title']); ?>

              </a>
            </h3>

            <!-- Bottom Meta Row -->
            <div class="flex items-center gap-2 text-caption text-gray-500 font-medium pt-2 border-t border-cyan-900/5">
              <span><?php echo e($secCard['date']); ?></span>
              <span class="inline-block w-1 h-1 rounded-full bg-gray-400"></span>
              <span class="inline-flex items-center gap-1">
                Comments <?php echo e($secCard['comments_count']); ?>

                <svg class="w-3.5 h-3.5 opacity-60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                </svg>
              </span>
            </div>
          </div>
        </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

    </div>

  </div>
</section>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/components/frontend/blog-v2.blade.php ENDPATH**/ ?>