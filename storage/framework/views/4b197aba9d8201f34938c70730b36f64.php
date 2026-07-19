  <footer class="site-footer">
    <div class="footer-contact">
      <div>
        <h3 class="footer-contact__title">Get in Touch with us</h3>
        <p class="footer-contact__subtitle">Reach out to us for expert support.</p>
      </div>

      <div class="footer-contact__items">
        <div class="footer-contact__item">
          <span class="footer-contact__icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
            </svg>
          </span>
          <div>
            <p class="footer-contact__label">Contact Us</p>
            <p class="footer-contact__value"><?php echo e($footerSettings['footer_phone_1'] ?? '1 123 456 7890'); ?></p>
          </div>
        </div>

        <div class="footer-contact__item">
          <span class="footer-contact__icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4h16v16H4z" stroke="currentColor" stroke-width="1.6"/>
              <path d="m4 6 8 7 8-7" stroke="currentColor" stroke-width="1.6"/>
            </svg>
          </span>
          <div>
            <p class="footer-contact__label">Send us a Mail</p>
            <p class="footer-contact__value"><?php echo e($footerSettings['footer_email_1'] ?? 'sales@smartfreamework.com'); ?></p>
          </div>
        </div>

        <div class="footer-contact__item">
          <span class="footer-contact__icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
              <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
          </span>
          <div>
            <p class="footer-contact__label">Opening Time</p>
            <p class="footer-contact__value"><?php echo e($footerSettings['footer_opening_time'] ?? 'Mon-Thu: 8:00am-5:00pm Fri: 8:00am-1:00pm'); ?></p>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-columns">
      <div class="footer-about">
        <a href="<?php echo e(route('home')); ?>" class="site-logo text-navy">
          <img src="<?php echo e(!empty($footerSettings['footer_logo']) ? asset('storage/' . $footerSettings['footer_logo']) : asset('assets/img/logo.png')); ?>" alt="Sitakund Modern Hospital Ltd." height="70" style="height:70px;width:auto" />
        </a>
        <p class="footer-about__desc">
          <?php echo e($footerSettings['footer_brand_description'] ?? "ClinicMaster Ipsum Dolor Sit Amet, Consectuer Adipiscing Elit, Sed Diam Nonummy Nibh Euismod Tincidunt Ut Laoreet Dolore Agna Aliquam Erat. Wisi Enim Ad Minim Veniam, Quis Tation. Sit Amet, Consec Tetuer. Ipsum Dolor"); ?>

        </p>
      </div>

      <div>
        <h4 class="footer-col__title">Our Services</h4>
        <div class="footer-col__list">
          <?php $__empty_1 = true; $__currentLoopData = ($footerSettings['footer_service_links'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <a href="<?php echo e($link['url']); ?>" class="footer-col__link"><?php echo e($link['label']); ?></a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <a href="<?php echo e(route('services')); ?>" class="footer-col__link">Angioplasty</a>
          <a href="<?php echo e(route('services')); ?>" class="footer-col__link">Cardiology</a>
          <a href="<?php echo e(route('services')); ?>" class="footer-col__link">Dental</a>
          <a href="<?php echo e(route('services')); ?>" class="footer-col__link">Endocrinology</a>
          <a href="<?php echo e(route('services')); ?>" class="footer-col__link">Eye Care</a>
          <?php endif; ?>
        </div>
      </div>

      <div>
        <h4 class="footer-col__title">Our Stores</h4>
        <div class="footer-col__list">
          <?php $__empty_1 = true; $__currentLoopData = ($footerSettings['footer_store_links'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <a href="<?php echo e($link['url']); ?>" class="footer-col__link"><?php echo e($link['label']); ?></a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <a href="<?php echo e(route('contact')); ?>#locations" class="footer-col__link">New York</a>
          <a href="<?php echo e(route('contact')); ?>#locations" class="footer-col__link">London SF</a>
          <a href="<?php echo e(route('contact')); ?>#locations" class="footer-col__link">Edinburgh</a>
          <a href="<?php echo e(route('contact')); ?>#locations" class="footer-col__link">Los Angeles</a>
          <a href="<?php echo e(route('contact')); ?>#locations" class="footer-col__link">Las Vegas</a>
          <?php endif; ?>
        </div>
      </div>

      <div>
        <h4 class="footer-col__title">Useful Links</h4>
        <div class="footer-col__list">
          <?php $__empty_1 = true; $__currentLoopData = ($footerSettings['footer_useful_links'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <a href="<?php echo e($link['url']); ?>" class="footer-col__link"><?php echo e($link['label']); ?></a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <a href="<?php echo e(url('/privacy-policy')); ?>" class="footer-col__link">Privacy Policy</a>
          <a href="<?php echo e(url('/terms-conditions')); ?>" class="footer-col__link">Terms &amp; Conditions</a>
          <a href="<?php echo e(route('contact')); ?>" class="footer-col__link">Contact Us</a>
          <a href="<?php echo e(route('blog-list')); ?>" class="footer-col__link">Latest News</a>
          <?php endif; ?>
        </div>
      </div>

      <div>
        <h4 class="footer-col__title">Quick Links</h4>
        <div class="footer-col__list">
          <?php $__empty_1 = true; $__currentLoopData = ($footerSettings['footer_quick_links'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <a href="<?php echo e($link['url']); ?>" class="footer-col__link"><?php echo e($link['label']); ?></a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <a href="<?php echo e(route('about')); ?>" class="footer-col__link">About Us</a>
          <a href="<?php echo e(route('doctors')); ?>" class="footer-col__link">Team</a>
          <a href="<?php echo e(route('services')); ?>" class="footer-col__link">Services</a>
          <a href="<?php echo e(route('contact')); ?>" class="footer-col__link">Contact Us</a>
          <a href="<?php echo e(route('appointment')); ?>" class="footer-col__link">Appointment</a>
          <?php endif; ?>
        </div>
      </div>
    </div>



    <div class="footer-bottom">
      &copy; <?php echo e(date('Y')); ?> <?php echo e($footerSettings['footer_copyright_text'] ?? 'Smart Freamework Theme. All Rights Reserved.'); ?>

    </div>
  </footer>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/components/frontend/footer.blade.php ENDPATH**/ ?>