<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
'testimonials' => collect(),
'testi' => [],
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
'testimonials' => collect(),
'testi' => [],
]); ?>
<?php foreach (array_filter(([
'testimonials' => collect(),
'testi' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
$testiBg = !empty($testi['testi_bg_image'])
? asset('storage/' . $testi['testi_bg_image'])
: asset('assets/img/testimonial-bg.jpg');

$testiPhoto = !empty($testi['testi_image'])
? asset('storage/' . $testi['testi_image'])
: asset('assets/img/testimonial-care.jpg');

$testiEyebrow = $testi['testi_badge'] ?? 'Our Testimonials';
$testiTitle = $testi['testi_title'] ?? 'Your Health, Our Commitment<br>Hear from Our Patients';

$homeTestimonialDefaults = [
[
'name' => 'Nicolas M. Baldwin',
'role' => 'Businessman',
'title' => 'Exceptional Care and Compassion',
'review' => 'The doctors and nurses provided me with outstanding care. From the moment walked care expertise and kindness.',
'rating' => 5,
],
[
'name' => 'Rahima Begum',
'role' => 'Patient',
'title' => 'Caring and Experienced Doctors',
'review' => 'I visited the specialist doctor chamber at Medicare Lab. The doctor was very patient and explained everything clearly. The environment was clean and welcoming.',
'rating' => 5,
],
[
'name' => 'Md. Kamal Uddin',
'role' => 'Patient',
'title' => 'Prompt & Reliable Service',
'review' => 'The home service for sample collection is a blessing. The staff came to my house on time and took the samples professionally. Highly recommended!',
'rating' => 5,
],
[
'name' => 'Sultana Akter',
'role' => 'Patient',
'title' => 'Accurate Diagnostics',
'review' => 'The digital ultrasonography and pathology reports were accurate and delivered quickly. I did not need to travel to Chattogram city for my tests.',
'rating' => 5,
],
];

$defaultTitles = [
'Exceptional Care and Compassion',
'Caring and Experienced Doctors',
'Prompt & Reliable Service',
'Accurate Diagnostics',
];

$testimonialCards = (isset($testimonials) && $testimonials->isNotEmpty())
? $testimonials->map(function($t, $idx) use ($defaultTitles) {
return [
'name' => $t->name,
'role' => $t->role,
'title' => $defaultTitles[$idx % count($defaultTitles)],
'review' => $t->review,
'rating' => (int) ($t->rating ?: 5),
];
})
: collect($homeTestimonialDefaults);
?>

<section
  class="testimonials-v2 py-20 lg:py-28 relative overflow-hidden text-white"
  data-testimonials-v2>
  <!-- Background Image & Black Overlay -->
  <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
    <img src="<?php echo e($testiBg); ?>" alt="Medical facility backdrop" class="w-full h-full object-cover object-center" />
    <!-- Rich dark/black overlay ensuring high contrast and depth -->
    <div class="absolute inset-0" style="background-color: rgba(0, 0, 0, 0.4);"></div>
    <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.45) 50%, rgba(0,0,0,0.90) 100%);"></div>
    <!-- Subtle dot pattern for depth -->
    <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:32px_32px] opacity-10"></div>
  </div>

  <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl 2xl:max-w-7xl 2k:max-w-[1720px] 4k:max-w-[2160px] relative z-10">

    <!-- Section Header (Centered) -->
    <div class="text-center max-w-2xl 2k:max-w-3xl 4k:max-w-4xl mx-auto mb-14 sm:mb-16">
      <p class="text-xs sm:text-sm font-bold tracking-widest text-white uppercase mb-3 inline-block px-4 py-1.5 rounded-full bg-red-600/90 border border-red-400/40 shadow-sm">
        <?php echo e($testiEyebrow); ?>

      </p>
      <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-white leading-[1.25] tracking-tight">
        <?php echo $testiTitle; ?>

      </h2>
    </div>

    <!-- Testimonial Content Grid (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch">

      <!-- Left Media Column (Compassionate Care Image) -->
      <div class="lg:col-span-5 flex justify-center items-center">
        <div class="w-full max-w-md lg:max-w-none rounded-2xl sm:rounded-3xl overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white/10 ring-1 ring-white/10 bg-black/20">
          <img
            src="<?php echo e($testiPhoto); ?>"
            alt="Patient care and compassion"
            class="w-full aspect-[4/4.5] sm:aspect-[4/4.8] object-cover" />
        </div>
      </div>

      <!-- Right Testimonial Slider Card Column -->
      <div class="lg:col-span-7 flex flex-col justify-center">
        <div class="bg-white rounded-2xl sm:rounded-3xl p-7 sm:p-11 shadow-[0_20px_50px_rgba(0,0,0,0.35)] border border-white/20 relative overflow-hidden flex flex-col justify-between min-h-[420px]">

          <!-- Honeycomb / Molecular Lattice Watermark Pattern on Right Side -->
          <svg class="absolute -right-6 -bottom-6 w-72 h-64 pointer-events-none text-purple-600/10" viewBox="0 0 280 240" fill="none" stroke="currentColor" stroke-width="1.6">
            <defs>
              <pattern id="hex-grid-v2" width="46" height="79.67" patternUnits="userSpaceOnUse">
                <path d="M23 0 L46 13.28 L46 39.84 L23 53.12 L0 39.84 L0 13.28 Z M23 79.67 L46 66.39 L46 39.84 M23 79.67 L0 66.39 L0 39.84" fill="none" />
                <circle cx="23" cy="0" r="2.2" fill="currentColor" fill-opacity="0.3" />
                <circle cx="46" cy="13.28" r="2.2" fill="currentColor" fill-opacity="0.3" />
                <circle cx="46" cy="39.84" r="2.2" fill="currentColor" fill-opacity="0.3" />
                <circle cx="23" cy="53.12" r="2.2" fill="currentColor" fill-opacity="0.3" />
                <circle cx="0" cy="39.84" r="2.2" fill="currentColor" fill-opacity="0.3" />
                <circle cx="0" cy="13.28" r="2.2" fill="currentColor" fill-opacity="0.3" />
              </pattern>
            </defs>
            <rect width="280" height="240" fill="url(#hex-grid-v2)" />
          </svg>

          <!-- Testimonial Slides Track -->
          <div class="relative z-10" data-testi-track>
            <?php $__currentLoopData = $testimonialCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div
              class="testi-slide transition-opacity duration-300 <?php echo e($loop->first ? 'block opacity-100' : 'hidden opacity-0'); ?>"
              data-testi-slide="<?php echo e($i); ?>">
              <!-- 5 Red Stars -->
              <div class="flex items-center gap-1.5 text-[#ef4444] mb-5">
                <?php for($s = 0; $s < ($card['rating'] ?? 5); $s++): ?>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <?php endfor; ?>
              </div>

              <!-- Quote Title (Purple Heading) -->
              <h3 class="text-[#4a1272] text-xl sm:text-2xl font-bold mb-5 leading-snug">
                <!-- &ldquo;<?php echo e($card['title']); ?>&rdquo; -->
              </h3>

              <!-- Review Quote Body -->
              <p class="text-[#0f172a] text-base sm:text-[18px] font-bold leading-relaxed mb-8">
                &ldquo;<?php echo e($card['review']); ?>&rdquo;
              </p>

              <!-- Author Section (Icon + Name/Role) -->
              <div class="pt-4 flex flex-col gap-3">
                <!-- Purple Chat Bubble Outline Icon -->
                <div class="text-[#4a1272]">
                  <svg class="w-9 h-9" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <!-- Front bubble -->
                    <path d="M18 20H8l-4 4V8a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8a4 4 0 0 1-4 4z" />
                    <!-- Back overlapping bubble -->
                    <path d="M22 8h2a4 4 0 0 1 4 4v12l-4-4h-8a4 4 0 0 1-3-1.3" />
                    <!-- Three dots in front bubble -->
                    <circle cx="8.5" cy="12" r="1" fill="currentColor" stroke="none" />
                    <circle cx="13" cy="12" r="1" fill="currentColor" stroke="none" />
                    <circle cx="17.5" cy="12" r="1" fill="currentColor" stroke="none" />
                  </svg>
                </div>
                <!-- Author Name and Role -->
                <p class="text-sm sm:text-base">
                  <span class="font-bold text-[#0f172a]"><?php echo e($card['name']); ?></span><span class="text-gray-400 font-normal">, <?php echo e($card['role']); ?></span>
                </p>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

          <!-- Bottom Right Navigation Dots -->
          <div class="flex justify-end items-center gap-2 mt-6 pt-2 relative z-10" data-testi-nav>
            <?php $__currentLoopData = $testimonialCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button
              type="button"
              class="testi-dot group relative flex items-center justify-center p-1 transition-all duration-300"
              data-testi-goto="<?php echo e($i); ?>"
              aria-label="View testimonial <?php echo e($i + 1); ?>">
              <?php if($loop->first): ?>
              <!-- Active Dot: Ring with center dot -->
              <span class="dot-indicator w-5 h-5 rounded-full border-2 border-[#4a1272] flex items-center justify-center transition-all duration-300">
                <span class="w-2 h-2 rounded-full bg-[#4a1272]"></span>
              </span>
              <?php else: ?>
              <!-- Inactive Dot: Small purple circle -->
              <span class="dot-indicator w-2.5 h-2.5 rounded-full bg-purple-300 group-hover:bg-purple-400 transition-all duration-300"></span>
              <?php endif; ?>
            </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

        </div>
      </div>

    </div>

  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('[data-testimonials-v2]');
    if (!container) return;

    const slides = container.querySelectorAll('[data-testi-slide]');
    const dotButtons = container.querySelectorAll('[data-testi-goto]');
    if (slides.length <= 1) return;

    let currentIndex = 0;
    let timer = null;

    function goToSlide(index) {
      slides.forEach((slide, idx) => {
        if (idx === index) {
          slide.classList.remove('hidden');
          setTimeout(() => slide.classList.remove('opacity-0'), 10);
        } else {
          slide.classList.add('opacity-0');
          slide.classList.add('hidden');
        }
      });

      dotButtons.forEach((btn, idx) => {
        const indicator = btn.querySelector('.dot-indicator');
        if (!indicator) return;
        if (idx === index) {
          indicator.className = 'dot-indicator w-5 h-5 rounded-full border-2 border-[#4a1272] flex items-center justify-center transition-all duration-300';
          indicator.innerHTML = '<span class="w-2 h-2 rounded-full bg-[#4a1272]"></span>';
        } else {
          indicator.className = 'dot-indicator w-2.5 h-2.5 rounded-full bg-purple-300 group-hover:bg-purple-400 transition-all duration-300';
          indicator.innerHTML = '';
        }
      });

      currentIndex = index;
    }

    dotButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const targetIndex = parseInt(btn.getAttribute('data-testi-goto'), 10);
        goToSlide(targetIndex);
        resetAutoPlay();
      });
    });

    function startAutoPlay() {
      timer = setInterval(() => {
        const nextIndex = (currentIndex + 1) % slides.length;
        goToSlide(nextIndex);
      }, 6000);
    }

    function resetAutoPlay() {
      if (timer) clearInterval(timer);
      startAutoPlay();
    }

    // Pause on hover
    container.addEventListener('mouseenter', () => {
      if (timer) clearInterval(timer);
    });

    container.addEventListener('mouseleave', () => {
      resetAutoPlay();
    });

    startAutoPlay();
  });
</script><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/components/frontend/testimonial-v2.blade.php ENDPATH**/ ?>