<?php
  $socialLinks = [
    [
      'key'   => 'facebook',
      'label' => 'Facebook',
      'url'   => !empty($headerSettings['header_facebook_url']) ? $headerSettings['header_facebook_url'] : (!empty($footerSettings['footer_facebook_url']) ? $footerSettings['footer_facebook_url'] : null),
      'icon'  => 'facebook',
    ],
    [
      'key'   => 'twitter',
      'label' => 'Twitter / X',
      'url'   => !empty($headerSettings['header_twitter_url']) ? $headerSettings['header_twitter_url'] : (!empty($footerSettings['footer_twitter_url']) ? $footerSettings['footer_twitter_url'] : null),
      'icon'  => 'twitter',
    ],
    [
      'key'   => 'linkedin',
      'label' => 'LinkedIn',
      'url'   => !empty($headerSettings['header_linkedin_url']) ? $headerSettings['header_linkedin_url'] : null,
      'icon'  => 'linkedin',
    ],
    [
      'key'   => 'instagram',
      'label' => 'Instagram',
      'url'   => !empty($headerSettings['header_instagram_url']) ? $headerSettings['header_instagram_url'] : (!empty($footerSettings['footer_instagram_url']) ? $footerSettings['footer_instagram_url'] : null),
      'icon'  => 'instagram',
    ],
    [
      'key'   => 'youtube',
      'label' => 'YouTube',
      'url'   => !empty($footerSettings['footer_youtube_url']) ? $footerSettings['footer_youtube_url'] : null,
      'icon'  => 'youtube',
    ],
  ];

  $activeSocialLinks = array_values(array_filter($socialLinks, fn($item) => !empty($item['url'])));
?>

<?php if(count($activeSocialLinks) > 0): ?>
<div class="page-header__social" style="z-index: 40; pointer-events: auto;">
  <?php $__currentLoopData = $activeSocialLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e($item['url']); ?>" target="_blank" rel="noopener noreferrer" class="page-header__social-link" aria-label="<?php echo e($item['label']); ?>" style="pointer-events: auto; cursor: pointer; position: relative; z-index: 41;">
      <?php if($item['icon'] === 'facebook'): ?>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
          <path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z" />
        </svg>
      <?php elseif($item['icon'] === 'twitter'): ?>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
          <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
        </svg>
      <?php elseif($item['icon'] === 'linkedin'): ?>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
          <path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z" />
        </svg>
      <?php elseif($item['icon'] === 'instagram'): ?>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <rect x="3.5" y="3.5" width="17" height="17" rx="5" />
          <circle cx="12" cy="12" r="4" />
          <circle cx="17.2" cy="6.8" r="1" />
        </svg>
      <?php elseif($item['icon'] === 'youtube'): ?>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
          <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
        </svg>
      <?php endif; ?>
    </a>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/components/frontend/page-header-social.blade.php ENDPATH**/ ?>