<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'about' => [],
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'about' => [],
]); ?>
<?php foreach (array_filter(([
    'about' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
$whyBadge = $about['why_badge'] ?? 'Why Choose Us';
$whyTitle = $about['why_title'] ?? 'Reliable & Quality Service';
$whyDesc = $about['why_desc'] ?? "Modern lab facilities, experienced doctors, digital ECG, and reliable quality service — all under one roof.";
$whyPhoto = !empty($about['why_photo']) ? asset('storage/' . $about['why_photo']) : asset('assets/img/choose-us-image.webp');
$whyBgPhoto = !empty($about['why_bg_photo']) 
    ? asset('storage/' . $about['why_bg_photo']) 
    : asset('assets/img/Why-choose-us-bg.webp');

$whyBadgeNumber = $about['why_badge_number'] ?? '10+';
$whyBadgeLabel = $about['why_badge_label'] ?? 'Years Experienced';

$whyFeatures = !empty($about['why_features']) ? $about['why_features'] : [
    ['title' => 'Experienced Specialist Doctors', 'description' => 'we have provided indoor care to over 24,273 patients and more than 187,200 outpatient consultations.'],
    ['title' => 'Modern Technology', 'description' => 'We were the first in Sitakunda to introduce Digital X-Ray and 4-D Ultrasonography, with Endoscopy and Colonoscopy facilities coming soon.'],
    ['title' => 'Affordable Healthcare', 'description' => 'Round-the-clock emergency department, pharmacy, ambulance service, digital X-ray and ECG — our team of 64 staff members is with you 24 hours a day.'],
    ['title' => 'Friendly & Caring Environment', 'description' => 'Specialist doctor chambers every day, covering Gynecology, General Surgery, Medicine, Orthopedics, Pediatrics, ENT and Diabetology.'],
];
?>

<section 
  class="relative py-20 lg:py-28 bg-gray-950 overflow-hidden bg-cover bg-center bg-no-repeat text-white"
  style="background-image: url('<?php echo e($whyBgPhoto); ?>');"
>
  <!-- Black Shade Overlay -->
  <div class="absolute inset-0 bg-gradient-to-r from-black/95 via-black/85 to-black/75 pointer-events-none"></div>

  <!-- Subtle Decorative Grid Lines -->
  <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:32px_32px] opacity-10 pointer-events-none"></div>

  <div class="container mx-auto px-4 sm:px-6 lg:px-16 relative z-10">
    <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">

      <!-- Left Content (White Text) -->
      <div class="lg:w-1/2">
        <p class="text-brand-cyan italic text-2xl lg:text-[28px] mb-3" style="font-family: 'Georgia', serif;">
          <?php echo e($whyBadge); ?>

        </p>
        <h2 class="text-3xl lg:text-[44px] font-bold text-white mb-6 leading-[1.2] tracking-tight">
          <?php echo e($whyTitle); ?>

        </h2>
        <p class="text-gray-300 text-[15px] leading-relaxed mb-12 max-w-[520px]">
          <?php echo e($whyDesc); ?>

        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-10">
          <?php $__currentLoopData = $whyFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
          $icons = [
            '<svg class="w-8 h-8 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>', // Shield
            '<svg class="w-8 h-8 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
            </svg>', // Tech
            '<svg class="w-8 h-8 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>', // Heart
            '<svg class="w-8 h-8 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
            </svg>'  // Care
          ];
          $icon = $icons[$i % count($icons)];
          ?>
          <div class="flex gap-4 items-start">
            <div class="shrink-0 p-2 rounded-xl bg-white/10 border border-white/15 text-brand-cyan shadow-sm">
              <?php echo $icon; ?>

            </div>
            <div>
              <h3 class="text-white font-bold text-[16px] mb-2 leading-snug"><?php echo e($feature['title']); ?></h3>
              <p class="text-gray-300 text-[13px] leading-relaxed"><?php echo e($feature['description']); ?></p>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>

      <!-- Right Image (Stylish Curved Left Edge) -->
      <div class="lg:w-1/2 relative flex justify-center items-center mt-12 lg:mt-0">
        
        <!-- Glowing Circular Backdrop Rings -->
        <div class="absolute -left-6 bottom-0 w-[420px] h-[420px] rounded-full border-2 border-brand-cyan/20 -z-10 pointer-events-none"></div>
        <div class="absolute -left-12 -top-6 w-[280px] h-[280px] rounded-full border border-white/10 -z-10 pointer-events-none"></div>

        <!-- Stylish Curved Image Frame -->
        <div class="relative z-10 w-full max-w-lg overflow-hidden rounded-l-[80px] sm:rounded-l-[120px] rounded-r-3xl shadow-2xl border-4 border-white/15 bg-white/5 backdrop-blur-sm">
          <img 
            src="<?php echo e($whyPhoto); ?>" 
            alt="<?php echo e($whyTitle); ?>" 
            class="w-full h-auto object-cover max-h-[520px] transition-transform duration-500 hover:scale-105" 
          />
        </div>

        <!-- Floating Experience Badge -->
        <?php if(!empty($whyBadgeNumber)): ?>
        <div class="absolute -bottom-5 left-4 sm:-bottom-6 sm:left-6 z-20 flex flex-col items-center justify-center rounded-2xl bg-brand-cyan px-5 py-4 text-center shadow-2xl border-2 border-white/30 backdrop-blur-md">
          <span class="text-2xl sm:text-3xl font-extrabold text-white leading-none"><?php echo e($whyBadgeNumber); ?></span>
          <span class="text-xs font-semibold text-white/95 mt-1"><?php echo e($whyBadgeLabel); ?></span>
        </div>
        <?php endif; ?>

      </div>

    </div>
  </div>
</section>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/components/frontend/why-choose-us.blade.php ENDPATH**/ ?>