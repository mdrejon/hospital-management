<?php
$heroTitle = $contact['contact_hero_title'] ?? 'Contact Us';
$heroImage = !empty($contact['contact_hero_image']) ? asset('storage/' . $contact['contact_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $contact['contact_seo_title'] ?? ('Contact Us | ' . config('app.name'));
$seoDesc = $contact['contact_seo_description'] ?? "Get in touch with Sitakund Modern Hospital Ltd.. We're happy to help you schedule an appointment or answer your questions.";
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>
<?php if(!empty($contact['contact_seo_keywords'])): ?>
<?php $__env->startSection('meta_keywords', $contact['contact_seo_keywords']); ?>
<?php endif; ?>
<?php if(!empty($contact['contact_seo_og_image'])): ?>
<?php $__env->startSection('og_image', asset('storage/' . $contact['contact_seo_og_image'])); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>

<!-- ===================== Breadcrumb / Page header ===================== -->
<section class="page-header">
  <div class="page-header__media">
    <img src="<?php echo e($heroImage); ?>" alt="Team of Sitakund Modern Hospital Ltd. doctors" class="page-header__bg" />
    <span class="page-header__overlay"></span>
  </div>

  <span class="page-header__badge">24/7 Emergency Service</span>

  <?php if (isset($component)) { $__componentOriginalf541cdfc2c462e982d1ee013ac35e2c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf541cdfc2c462e982d1ee013ac35e2c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.page-header-social','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.page-header-social'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf541cdfc2c462e982d1ee013ac35e2c5)): ?>
<?php $attributes = $__attributesOriginalf541cdfc2c462e982d1ee013ac35e2c5; ?>
<?php unset($__attributesOriginalf541cdfc2c462e982d1ee013ac35e2c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf541cdfc2c462e982d1ee013ac35e2c5)): ?>
<?php $component = $__componentOriginalf541cdfc2c462e982d1ee013ac35e2c5; ?>
<?php unset($__componentOriginalf541cdfc2c462e982d1ee013ac35e2c5); ?>
<?php endif; ?>

  <div class="page-header__inner">
    <h1 class="page-header__title"><?php echo e($heroTitle); ?></h1>
    <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
      <a href="<?php echo e(route('home')); ?>"><?php echo e(__('frontend.nav.home')); ?></a>
      <span class="page-header__breadcrumb-sep">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="m7 6 5 6-5 6M13 6l5 6-5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span>
      <span><?php echo e(__('frontend.nav.contact_us')); ?></span>
    </nav>
  </div>

  <a href="tel:<?php echo e(preg_replace('/[^0-9+]/', '', $headerSettings['header_phone'] ?? '11234567890')); ?>" class="page-header__call">
    <span class="page-header__call-icon">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6" />
      </svg>
    </span>
    <span class="page-header__call-text"><?php echo e($headerSettings['header_phone'] ?? '1 123 456 7890'); ?></span>
  </a>
</section>

<!-- ===================== Contact / Appointment ===================== -->
<section class="contact">
  <div class="container mx-auto">
    <div class="contact__grid">
      <div>
        <h2 class="contact__title"><?php echo e($contact['contact_title'] ?? 'Connect With Us For Your Healthcare Needs'); ?></h2>
        <p class="contact__desc">
          <?php echo e($contact['contact_desc'] ?? "Reach out for support, feedback, or to schedule an appointment. Fill out the form, and we'll promptly assist you and confirm your visit with our healthcare professionals."); ?>

        </p>

        <div class="contact__talk-row">
          <div class="contact__talk">
            <span class="contact__talk-text"><?php echo e($contact['contact_talk_text'] ?? 'Talk to over 215 doctor'); ?></span>
          </div>
          <a href="<?php echo e(!empty($footerSettings['footer_whatsapp_number']) ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $footerSettings['footer_whatsapp_number']) : '#'); ?>" target="_blank" rel="noopener noreferrer" class="contact__talk-arrow" aria-label="WhatsApp">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7 17 17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </a>
        </div>

        <p class="contact__rating">
          <span class="contact__stars" aria-hidden="true">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2l-6.1 3.4 1.4-6.8L2.2 9.1l6.9-.8L12 2z" />
            </svg>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2l-6.1 3.4 1.4-6.8L2.2 9.1l6.9-.8L12 2z" />
            </svg>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2l-6.1 3.4 1.4-6.8L2.2 9.1l6.9-.8L12 2z" />
            </svg>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2l-6.1 3.4 1.4-6.8L2.2 9.1l6.9-.8L12 2z" />
            </svg>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.2l-6.1 3.4 1.4-6.8L2.2 9.1l6.9-.8L12 2z" />
            </svg>
          </span>
          <strong>(<?php echo e($contact['contact_rating_score'] ?? '4.8'); ?>)</strong> <?php echo e($contact['contact_rating_text'] ?? '12k ratings on google'); ?>

        </p>

        <div class="contact__cards">
          <div class="contact-info-card">
            <span class="contact-info-card__icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21s7-6.1 7-11.5A7 7 0 0 0 5 9.5C5 14.9 12 21 12 21z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                <circle cx="12" cy="9.5" r="2.4" stroke="currentColor" stroke-width="1.6" />
              </svg>
            </span>
            <div>
              <h3 class="contact-info-card__title"><?php echo e(__('frontend.footer.address')); ?></h3>
              <p class="contact-info-card__text"><?php echo e(trim(($footerSettings['footer_address_line1'] ?? '234 Oak Drive') . ', ' . ($footerSettings['footer_address_line2'] ?? 'Villagetown, USA'), ', ')); ?></p>
            </div>
          </div>

          <div class="contact-info-card">
            <span class="contact-info-card__icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6" />
              </svg>
            </span>
            <div>
              <h3 class="contact-info-card__title"><?php echo e(__('frontend.footer.contact_us')); ?></h3>
              <p class="contact-info-card__text"><?php echo e($footerSettings['footer_phone_1'] ?? '1 123 456 7890'); ?></p>
            </div>
          </div>

          <div class="contact-info-card">
            <span class="contact-info-card__icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 4h16v16H4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                <path d="m4 6 8 7 8-7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
            <div>
              <h3 class="contact-info-card__title"><?php echo e(__('frontend.footer.send_mail')); ?></h3>
              <p class="contact-info-card__text"><?php echo e($footerSettings['footer_email_1'] ?? 'sales@smartfreamework.com'); ?></p>
            </div>
          </div>

          <div class="contact-info-card">
            <span class="contact-info-card__icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6" />
                <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
              </svg>
            </span>
            <div>
              <h3 class="contact-info-card__title"><?php echo e(__('frontend.footer.opening_time')); ?></h3>
              <p class="contact-info-card__text"><?php echo e($footerSettings['footer_opening_time'] ?? 'Mon-Thu: 8:00am-5:00pm Fri: 8:00am-1:00pm'); ?></p>
            </div>
          </div>
        </div>
      </div>

      <div class="contact__form-card">
        <h2 class="contact__form-title"><?php echo e($contact['contact_form_title'] ?? 'Make An Appointment Apply For Treatments'); ?></h2>

        <?php if(session('success')): ?>
        <p class="contact__form-note" style="color: #16a34a;"><?php echo e(session('success')); ?></p>
        <?php endif; ?>
        <?php if($errors->any()): ?>
        <p class="contact__form-note" style="color: #dc2626;"><?php echo e($errors->first()); ?></p>
        <?php endif; ?>

        <form class="contact__form" action="<?php echo e(route('contact.submit')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <input type="text" name="first_name" value="<?php echo e(old('first_name')); ?>" class="contact__field" placeholder="<?php echo e(__('frontend.contact_page.first_name')); ?>" required />
          <input type="text" name="last_name" value="<?php echo e(old('last_name')); ?>" class="contact__field" placeholder="<?php echo e(__('frontend.contact_page.last_name')); ?>" />
          <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="contact__field" placeholder="<?php echo e(__('frontend.contact_page.email')); ?>" required />
          <input type="tel" name="phone" value="<?php echo e(old('phone')); ?>" class="contact__field" placeholder="<?php echo e(__('frontend.contact_page.phone')); ?>" />
          <textarea name="message" class="contact__field contact__field--full" rows="6" placeholder="<?php echo e(__('frontend.contact_page.message')); ?>"><?php echo e(old('message')); ?></textarea>
          <button type="submit" class="contact__submit">
            <?php echo e($contact['contact_form_btn_text'] ?? 'Appointment'); ?>

            <span class="contact__submit-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ===================== Location Map ===================== -->
<section class="locations" id="locations">
  <div class="locations__map">
    <a href="<?php echo e($contact['contact_map_open_url'] ?? 'https://www.google.com/maps?q=123+Health+Way+Goodland+United+States'); ?>" target="_blank" rel="noopener" class="locations__open">
      Open in Maps
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M14 4h6v6M20 4l-9 9M9 5H5a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h13a1 1 0 0 0 1-1v-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </a>
    <iframe src="<?php echo e($contact['contact_map_embed'] ?? 'https://maps.google.com/maps?q=Jaipur&t=&z=11&ie=UTF8&iwloc=&output=embed'); ?>" loading="lazy" title="Hospital location map" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/frontend/contact.blade.php ENDPATH**/ ?>