<?php
$heroTitle = $about['about_hero_title'] ?? 'About Us';
$heroImage = !empty($about['about_hero_image']) ? asset('storage/' . $about['about_hero_image']) : asset('assets/img/breadcumb.webp');
$seoTitle = $about['about_seo_title'] ?? ('About Us | ' . config('app.name'));
$seoDesc = $about['about_seo_description'] ?? "Learn about Sitakund Modern Hospital Ltd.'s mission, values, and leadership.";
?>

<?php $__env->startSection('title', $seoTitle); ?>
<?php $__env->startSection('meta_description', $seoDesc); ?>
<?php $__env->startSection('og_title', $seoTitle); ?>
<?php $__env->startSection('og_description', $seoDesc); ?>
<?php if(!empty($about['about_seo_keywords'])): ?>
<?php $__env->startSection('meta_keywords', $about['about_seo_keywords']); ?>
<?php endif; ?>
<?php if(!empty($about['about_seo_og_image'])): ?>
<?php $__env->startSection('og_image', asset('storage/' . $about['about_seo_og_image'])); ?>
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
      <span><?php echo e(__('frontend.breadcrumb.about_us')); ?></span>
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

<!-- ===================== About Us ===================== -->
<?php
$aboutPhoto = !empty($about['about_photo']) ? asset('storage/' . $about['about_photo']) : asset('assets/img/about-image.webp');
$aboutHoursTitle = $about['about_hours_title'] ?? 'Open Hours';
$aboutHours = !empty($about['about_hours']) ? $about['about_hours'] : [
['day' => 'Monday', 'time' => '09:30 - 07:30'],
['day' => 'Tuesday', 'time' => '09:30 - 07:30'],
['day' => 'Wednesday', 'time' => '09:30 - 07:30'],
['day' => 'Thursday', 'time' => '09:30 - 07:30'],
['day' => 'Friday', 'time' => '09:30 - 07:30'],
['day' => 'Saturday', 'time' => '09:30 - 07:30'],
];
$aboutTitle = $about['about_title'] ?? 'World Class Patient Facilities Designed For You';
$aboutDesc = $about['about_desc'] ?? "Experience the future of healthcare. Our state-of-the-art facilities are equipped with the latest technology, ensuring you receive the world's best quality treatment. Here, cutting-edge tools meet unparalleled expertise, providing a comfortable and effective path to optimal health.";
// About-page-only rich description: replaces the shared plain desc here (never on Home)
// when the admin actually typed something — an empty TipTap doc still saves "<p></p>".
$aboutRichDesc = trim(strip_tags($about['about_page_desc'] ?? '')) !== '' ? $about['about_page_desc'] : null;
$aboutFeatures = !empty($about['about_features']) ? $about['about_features'] : [
'Comprehensive Specialties', 'Emergency Services', 'Intensive Care Units (ICUs)', 'Telemedicine Facilities', 'Multidisciplinary Team',
'Research and Development', 'Advanced Imaging Services', 'Rehabilitation Services', 'Patient-Centric Approach', 'Health Information Technology',
];
$aboutFeatureCols = collect($aboutFeatures)->chunk((int) ceil(count($aboutFeatures) / 2));
$aboutPhone = $headerSettings['header_phone'] ?? '1 123 456 7890';
?>
<section class="about">
  <svg class="about__decor" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <pattern id="about-dots" width="10" height="10" patternUnits="userSpaceOnUse">
      <circle cx="2" cy="2" r="2" fill="currentColor" />
    </pattern>
    <rect width="100" height="100" fill="url(#about-dots)" />
  </svg>

  <div class="container mx-auto">
    <div class="about__grid">
      <div class="about__media">
        <div class="about__photo-wrap">
          <img src="<?php echo e($aboutPhoto); ?>" alt="Smiling male doctor with arms crossed" class="about__photo" />


          <div class="about__hours-card">
            <span class="about__hours-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6" />
                <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
              </svg>
            </span>
            <h3 class="about__hours-title"><?php echo e($aboutHoursTitle); ?></h3>
            <div class="about__hours-list">
              <?php $__currentLoopData = $aboutHours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="about__hours-row">
                <span class="about__hours-day"><?php echo e($row['day']); ?></span>
                <span class="about__hours-time"><?php echo e($row['time']); ?></span>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        </div>
      </div>

      <div class="about__content">
        <h2 class="about__title"><?php echo e($aboutTitle); ?></h2>
        <?php if($aboutRichDesc): ?>
        <div class="about__desc about__desc--rich"><?php echo $aboutRichDesc; ?></div>
        <?php else: ?>
        <p class="about__desc">
          <?php echo e($aboutDesc); ?>

        </p>
        <?php endif; ?>

        <div class="about__features">
          <?php $__currentLoopData = $aboutFeatureCols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div>
            <?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="about__feature">
              <span class="about__feature-check">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
              <?php echo e($feature); ?>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="about__cta-row">
          <a href="tel:<?php echo e($aboutPhone); ?>" class="about__contact">
            <span class="about__contact-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6" />
              </svg>
            </span>
            <span class="about__contact-text">
              <span class="about__contact-label">Contact us?</span>
              <span class="about__contact-value"><?php echo e($aboutPhone); ?></span>
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== Mission & Vision ===================== -->
<?php
$mvTitle = $about['about_mv_title'] ?? 'Inspirational Health Our Vision And Mission';
$mvDesc = $about['about_mv_desc'] ?? 'To enhance the health and well-being of our community by providing compassionate, high-quality healthcare services through dedicated professionals and advanced medical practices.';
$mvImage = !empty($about['about_mv_image']) ? asset('storage/' . $about['about_mv_image']) : asset('assets/img/sr-1-2.jpg');
$mvIcons = [
'<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.6" />
  <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.6" />
  <circle cx="12" cy="12" r="1" fill="currentColor" />
</svg>',
'<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
  <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6" />
</svg>',
'<svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M6 3h12l4 6-10 12L2 9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
  <path d="M2 9h20M9 3l-3 6 6 12 6-12-3-6" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round" />
</svg>',
];
$mvCards = !empty($about['about_mv_cards']) ? $about['about_mv_cards'] : [
['title' => 'Mission', 'description' => 'Delivering compassionate, patient-centred care through skilled professionals and dependable, modern medical practices for every member of our community.'],
['title' => 'Vision', 'description' => "To be the region's most trusted healthcare partner, recognised for clinical excellence, innovation, and genuine care for every patient we serve."],
['title' => 'Values', 'description' => 'Integrity, compassion, and accountability guide every decision we make, from the bedside to the boardroom.'],
];
?>
<section class="mission-vision">
  <div class="container mx-auto">
    <div class="mission-vision__grid">
      <div>
        <h2 class="mission-vision__title"><?php echo e($mvTitle); ?></h2>
        <p class="mission-vision__desc">
          <?php echo e($mvDesc); ?>

        </p>

        <div class="mission-vision__list">
          <?php $__currentLoopData = $mvCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="mission-vision__card">
            <span class="mission-vision__icon">
              <?php echo $mvIcons[$i] ?? $mvIcons[0]; ?>

            </span>
            <div>
              <h3 class="mission-vision__card-title"><?php echo e($card['title']); ?></h3>
              <p class="mission-vision__card-desc">
                <?php echo e($card['description']); ?>

              </p>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>

      <div class="mission-vision__media">
        <img src="<?php echo e($mvImage); ?>" alt="Doctor speaking with a patient" class="mission-vision__img" />
      </div>
    </div>
  </div>
</section>

<!-- ===================== Our CEO Message ===================== -->
<?php
$ceoImage = !empty($about['ceo_image']) ? asset('storage/' . $about['ceo_image']) : asset('assets/img/about-image.webp');
$ceoBadgeValue = $about['ceo_badge_value'] ?? '16+';
$ceoBadgeLabel = $about['ceo_badge_label'] ?? 'Years Experienced';
$ceoEyebrow = $about['ceo_eyebrow'] ?? 'Our CEO Message';
$ceoTitle = $about['ceo_title'] ?? 'Meet Dr. Natali Jackson';
$ceoMessage = $about['ceo_message'] ?? "As CEO of Sitakund Modern Hospital Ltd., I'm committed to building a hospital where compassionate care meets clinical excellence. Every decision we make, from staffing to technology, starts with what's best for the patients and families who trust us with their health.";
$ceoFocusLabel = $about['ceo_focus_label'] ?? 'Leadership Focus';
$ceoFocusItems = !empty($about['ceo_focus_items']) ? $about['ceo_focus_items'] : [
'Patient-Centered Care', 'Clinical Innovation', 'Operational Excellence', 'Community Outreach', 'Quality Assurance', 'Strategic Growth',
];
$ceoAwards = !empty($about['ceo_awards']) ? $about['ceo_awards'] : [
['year' => 'Sitakund Modern Hospital Ltd. 2024', 'org' => 'Quality and Accreditation Institute', 'label' => 'Healthcare Leadership Award'],
['year' => 'Sitakund Modern Hospital Ltd. 2023', 'org' => 'National Hospital Federation', 'label' => 'Excellence in Patient Care'],
];
?>
<section class="ceo-message">
  <div class="container mx-auto">
    <div class="ceo-message__grid">
      <div class="ceo-message__media">
        <img src="<?php echo e($ceoImage); ?>" alt="<?php echo e($ceoTitle); ?>" class="ceo-message__img" />
        <div class="ceo-message__badge">
          <span class="ceo-message__badge-value"><?php echo e($ceoBadgeValue); ?></span>
          <span class="ceo-message__badge-label"><?php echo nl2br(e($ceoBadgeLabel)); ?></span>
        </div>
      </div>

      <div>
        <p class="ceo-message__eyebrow">
          <span class="ceo-message__eyebrow-dot"></span>
          <?php echo e($ceoEyebrow); ?>

          <span class="ceo-message__eyebrow-dot"></span>
        </p>
        <h2 class="ceo-message__title"><?php echo e($ceoTitle); ?></h2>
        <p class="ceo-message__desc">
          <?php echo e($ceoMessage); ?>

        </p>

        <p class="ceo-message__focus-label"><?php echo e($ceoFocusLabel); ?></p>
        <div class="ceo-message__checklist">
          <?php $__currentLoopData = $ceoFocusItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <span class="ceo-message__check">
            <span class="ceo-message__check-icon">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
            <?php echo e($item); ?>

          </span>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="ceo-message__awards">
          <?php $__currentLoopData = $ceoAwards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="ceo-message__award">
            <span class="ceo-message__award-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2l2.5 5 5.5.6-4 3.9 1 5.5L12 14.8 7 17l1-5.5-4-3.9L9.5 7 12 2z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round" />
              </svg>
            </span>
            <div>
              <p class="ceo-message__award-year"><?php echo e($award['year']); ?></p>
              <p class="ceo-message__award-org"><?php echo e($award['org']); ?></p>
              <a href="<?php echo e(route('achievements')); ?>" class="ceo-message__award-link"><?php echo e($award['label']); ?></a>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== FAQ ===================== -->
<?php
$aboutFaqTitle = $aboutFaq['title'] ?: 'Frequently Asked Questions';
$aboutFaqDesc = $aboutFaq['description'] ?: 'Answers to the questions our patients ask us most about visiting Sitakund Modern Hospital Ltd..';
$aboutFaqPhoto = $aboutFaq['image'] ?: asset('assets/img/faq.webp');
$aboutFaqPhotoAlt = $aboutFaq['image_alt'] ?: 'Smiling doctor on a call, ready to answer your questions';
$aboutFaqDefaults = [
['question' => 'What insurance plans do you accept?', 'answer' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its. The point of using Lorem Ipsum is that it has a more-or-less normal distribution'],
['question' => 'Do I need a referral to see a specialist?', 'answer' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its. The point of using Lorem Ipsum is that it has a more-or-less normal distribution'],
['question' => 'What should I bring to my first visit?', 'answer' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its. The point of using Lorem Ipsum is that it has a more-or-less normal distribution'],
['question' => 'How can I access my medical records?', 'answer' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its. The point of using Lorem Ipsum is that it has a more-or-less normal distribution'],
];
$aboutFaqCards = (!empty($aboutFaq['items']) && $aboutFaq['items']->isNotEmpty()) ? $aboutFaq['items'] : collect($aboutFaqDefaults);
?>
<section class="faq">
  <img src="<?php echo e(asset('assets/img/faq-bg.png')); ?>" alt="" class="faq__bg" aria-hidden="true" />

  <div class="container relative mx-auto">
    <div class="faq__grid">
      <div class="faq__copy">
        <h2 class="faq__title"><?php echo e($aboutFaqTitle); ?></h2>
        <p class="faq__desc">
          <?php echo e($aboutFaqDesc); ?>

        </p>

        <div class="faq__list">
          <?php $__currentLoopData = $aboutFaqCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faqIndex => $faqCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="faq-item <?php if($faqIndex === 0): ?> is-open <?php endif; ?>">
            <button type="button" class="faq-item__question" data-faq-toggle>
              <?php echo e($faqCard['question'] ?? ''); ?>

              <span class="faq-item__icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </button>
            <div class="faq-item__answer">
              <p><?php echo e($faqCard['answer'] ?? ''); ?></p>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>

      <div class="faq__media">
        <img src="<?php echo e($aboutFaqPhoto); ?>" alt="<?php echo e($aboutFaqPhotoAlt); ?>" class="faq__photo" />

        <?php echo $__env->make('frontend.partials.faq-contact-card', ['phone' => $aboutPhone], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/frontend/about.blade.php ENDPATH**/ ?>