
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['award']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['award']); ?>
<?php foreach (array_filter((['award']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
  $sealImage   = $award['seal_image'] ?? null;
  $sealVariant = (int) ($award['seal_variant'] ?? 1);
  $title       = $award['title'] ?? '';
  $linkText    = $award['link_text'] ?? null;
?>

<div class="award-card">
  <?php if($sealImage): ?>
    <img src="<?php echo e($sealImage); ?>" alt="<?php echo e($title); ?>" class="award-card__seal award-card__seal--img" loading="lazy" draggable="false" />
  <?php elseif($sealVariant === 1): ?>
    <svg class="award-card__seal" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path d="M48 4 86 26v44L48 92 10 70V26z" stroke="currentColor" stroke-width="1.6"/>
      <text x="48" y="46" text-anchor="middle" font-size="14" font-weight="800" fill="currentColor">WHO</text>
      <text x="48" y="56" text-anchor="middle" font-size="6" fill="currentColor" opacity="0.7">Medizone</text>
      <text x="48" y="64" text-anchor="middle" font-size="6" fill="currentColor" opacity="0.7">2024</text>
      <text x="17" y="22" font-size="9" fill="currentColor">★</text>
      <text x="72" y="22" font-size="9" fill="currentColor">★</text>
      <text x="17" y="82" font-size="9" fill="currentColor">★</text>
      <text x="72" y="82" font-size="9" fill="currentColor">★</text>
    </svg>
  <?php elseif($sealVariant === 2): ?>
    <svg class="award-card__seal" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="1.6" stroke-dasharray="3 4"/>
      <circle cx="48" cy="48" r="32" stroke="currentColor" stroke-width="1.2"/>
      <path d="M38 36 42 42 48 34 54 42 58 36 56 46H40z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
      <text x="48" y="56" text-anchor="middle" font-size="12" font-weight="800" fill="currentColor">WHO</text>
      <text x="48" y="64" text-anchor="middle" font-size="5.5" fill="currentColor" opacity="0.7">Medizone</text>
      <text x="48" y="71" text-anchor="middle" font-size="5.5" fill="currentColor" opacity="0.7">2024</text>
    </svg>
  <?php else: ?>
    <svg class="award-card__seal" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <circle cx="48" cy="48" r="36" stroke="currentColor" stroke-width="1.6"/>
      <path d="M18 40c6 20 10 30 20 36M78 40c-6 20-10 30-20 36" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
      <path d="M20 44c4 2 8 2 12-1M76 44c-4 2-8 2-12-1M22 56c4 1 8 0 11-3M74 56c-4 1-8 0-11-3M26 66c3 1 6 0 8-2M70 66c-3 1-6 0-8-2" stroke="currentColor" stroke-width="1.1" stroke-linecap="round"/>
      <text x="48" y="44" text-anchor="middle" font-size="12" font-weight="800" fill="currentColor">WHO</text>
      <text x="48" y="53" text-anchor="middle" font-size="5.5" fill="currentColor" opacity="0.7">Medizone</text>
      <text x="48" y="60" text-anchor="middle" font-size="5.5" fill="currentColor" opacity="0.7">2024</text>
    </svg>
  <?php endif; ?>

  <h3 class="award-card__title"><?php echo e($title); ?></h3>
  <p class="award-card__subtitle"><?php echo e($award['subtitle'] ?? ''); ?></p>
  <?php if($linkText): ?>
    <a href="<?php echo e($award['link_url'] ?: '#'); ?>" class="award-card__link"><?php echo e($linkText); ?></a>
  <?php endif; ?>
</div>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\components\frontend\award-card.blade.php ENDPATH**/ ?>