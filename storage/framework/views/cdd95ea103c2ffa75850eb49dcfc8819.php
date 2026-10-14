
<?php
  $socialLinks = array_filter([
    'Facebook'    => ($headerSettings['header_facebook_url'] ?? null) ?: ($footerSettings['footer_facebook_url'] ?? null),
    'Twitter / X' => ($headerSettings['header_twitter_url'] ?? null) ?: ($footerSettings['footer_twitter_url'] ?? null),
    'LinkedIn'    => $headerSettings['header_linkedin_url'] ?? null,
    'Instagram'   => ($headerSettings['header_instagram_url'] ?? null) ?: ($footerSettings['footer_instagram_url'] ?? null),
    'YouTube'     => $footerSettings['footer_youtube_url'] ?? null,
  ]);
?>

<?php if($socialLinks): ?>
  <div class="page-header__social">
    <?php $__currentLoopData = $socialLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e($url); ?>" target="_blank" rel="noopener noreferrer" class="page-header__social-link" aria-label="<?php echo e($label); ?>">
        <?php switch($label):
          case ('Facebook'): ?>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z" />
            </svg>
            <?php break; ?>
          <?php case ('Twitter / X'): ?>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
            </svg>
            <?php break; ?>
          <?php case ('LinkedIn'): ?>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z" />
            </svg>
            <?php break; ?>
          <?php case ('Instagram'): ?>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
              <rect x="3.5" y="3.5" width="17" height="17" rx="5" />
              <circle cx="12" cy="12" r="4" />
              <circle cx="17.2" cy="6.8" r="1" />
            </svg>
            <?php break; ?>
          <?php case ('YouTube'): ?>
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M23 7.2a3 3 0 0 0-2.1-2.1C19 4.6 12 4.6 12 4.6s-7 0-8.9.5A3 3 0 0 0 1 7.2 31 31 0 0 0 .5 12a31 31 0 0 0 .5 4.8 3 3 0 0 0 2.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.1 31 31 0 0 0 .5-4.8 31 31 0 0 0-.5-4.8zM9.8 15.1V8.9l5.8 3.1-5.8 3.1z" />
            </svg>
            <?php break; ?>
        <?php endswitch; ?>
      </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
<?php endif; ?>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/components/frontend/page-header-social.blade.php ENDPATH**/ ?>