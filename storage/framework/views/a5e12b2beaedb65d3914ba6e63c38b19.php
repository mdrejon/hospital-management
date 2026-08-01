
<div class="faq__contact-card">
  <div class="faq__contact-info">
    <span class="faq__contact-icon">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
      </svg>
    </span>
    <div>
      <p class="faq__contact-label"><?php echo e(__('frontend.faq.contact_label')); ?></p>
      <p class="faq__contact-value"><?php echo e($phone); ?></p>
    </div>
  </div>

  <a href="<?php echo e(route('appointment')); ?>" class="faq__contact-btn">
    <?php echo e(__('frontend.faq.contact_btn')); ?>

    <span class="faq__contact-btn-icon">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </span>
  </a>
</div>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\frontend\partials\faq-contact-card.blade.php ENDPATH**/ ?>