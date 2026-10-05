  <!-- ===================== Header ===================== -->
  <header class="site-header">
    <!-- Top info bar (original) -->
    <div class="top-header">
      <div class="top-header__inner">
        <div class="top-header__left">
          <span   class="top-header__item">

            <span class="top-header__value"><?php echo e($headerSettings['header_tagline'] ?? 'Need professional medical & health Care?'); ?></span>
          </span>
          <span class="top-header__item">
            <span class="top-header__icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="1.6"/>
              </svg>
            </span>
            <span class="top-header__value">Call : <?php echo e($headerSettings['header_phone'] ?? '+1 (234) 5688 9990'); ?></span>
          </span>


        </div>

        <div class="top-header__right">
          <span class="top-header__item">
            <span class="top-header__icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
                <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </span>
            <span class="top-header__value"><?php echo e($headerSettings['header_hours'] ?? 'Mon - Fri: 8:00 am - 7:00 pm'); ?></span>
          </span>
          <div class="top-header__socials">
            <a href="<?php echo e($headerSettings['header_facebook_url'] ?? '#'); ?>" class="top-header__social-link" aria-label="Facebook">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
            </a>
            <a href="<?php echo e($headerSettings['header_twitter_url'] ?? '#'); ?>" class="top-header__social-link" aria-label="Twitter">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 0 1-1.9.1c.5 1.7 2.1 2.9 4 2.9A8.2 8.2 0 0 1 2 18.6a11.6 11.6 0 0 0 6.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z"/></svg>
            </a>
            <a href="<?php echo e($headerSettings['header_linkedin_url'] ?? '#'); ?>" class="top-header__social-link" aria-label="LinkedIn">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Top info bar (new 5-icon style) -->
    <div class="top-info-bar">
      <div class="top-info-bar__inner">
        <span class="top-info-bar__item">
            <a href="<?php echo e(route('home')); ?>" class="site-logo text-navy">
            <img src="<?php echo e(!empty($headerSettings['header_logo']) ? asset('storage/' . $headerSettings['header_logo']) : asset('assets/img/logo.png')); ?>" alt="<?php echo e($headerSettings['header_site_name'] ?? 'Sitakund Modern Hospital Ltd.'); ?>" height="60" style="height:60px;width:auto" />
          </a>
        </span>
        <a href="mailto:<?php echo e($headerSettings['header_email'] ?? 'info@example.com'); ?>" class="top-info-bar__item">
          <span class="top-info-bar__icon">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
              <path d="M3.5 6.5 12 13l8.5-6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9 3.5h6M8 1.5h8" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
            </svg>
          </span>
          <span class="top-info-bar__text">
            <span class="top-info-bar__label">Email Supports</span>
            <span class="top-info-bar__value"><?php echo e($headerSettings['header_email'] ?? 'info@example.com'); ?></span>
          </span>
        </a>


        <span class="top-info-bar__item">
          <span class="top-info-bar__icon">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m4 3 2.2 2.2M20 3l-2.2 2.2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              <circle cx="12" cy="13.5" r="8" stroke="currentColor" stroke-width="1.5"/>
              <path d="M12 9.3v4.2l3 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9.5 3.2h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </span>
          <span class="top-info-bar__text">
            <span class="top-info-bar__label">Supports</span>
            <span class="top-info-bar__value"><?php echo e($headerSettings['header_support_text'] ?? '24x7 Supports'); ?></span>
          </span>
        </span>

        <div class="top-info-bar__item top-info-bar__search">
          <form action="<?php echo e(route('search')); ?>" method="GET" class="header-search" role="search">
            <input type="search" name="q" value="<?php echo e(request('q')); ?>" class="header-search__input" placeholder="Search here..." aria-label="Search" required />
            <button type="submit" class="header-search__submit" aria-label="Search">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                <path d="m20 20-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
            </button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <!-- Main nav (own stacking context, sibling of <header> so it can stay sticky for the full page) -->
  <div class="site-header__nav">
    <div class="site-header__inner">

      <a href="<?php echo e(route('home')); ?>" class="site-logo site-logo--mobile">
        <img src="<?php echo e(!empty($headerSettings['header_logo']) ? asset('storage/' . $headerSettings['header_logo']) : asset('assets/img/logo.png')); ?>" alt="<?php echo e($headerSettings['header_site_name'] ?? 'Sitakund Modern Hospital Ltd.'); ?>" height="42" style="height:42px;width:auto" />
      </a>

      <nav class="main-nav">
        <a href="<?php echo e(route('home')); ?>" class="main-nav__link <?php echo e(request()->routeIs('home') ? 'is-active' : ''); ?>">Home</a>

        <div class="has-dropdown">
          <button type="button" class="main-nav__link <?php echo e(request()->routeIs(['about','history','md-message','management','achievements','faq']) ? 'is-active' : ''); ?>">
            About Us
            <span class="main-nav__caret">+</span>
          </button>
          <div class="dropdown-menu">
            <a href="<?php echo e(route('about')); ?>" class="dropdown-menu__link">Company Profile</a>
            <a href="<?php echo e(route('history')); ?>" class="dropdown-menu__link">Our History</a>
            <a href="<?php echo e(route('md-message')); ?>" class="dropdown-menu__link">Message From MD/CEO</a>
            <a href="<?php echo e(route('management')); ?>" class="dropdown-menu__link">Our Management</a>
            <a href="<?php echo e(route('achievements')); ?>" class="dropdown-menu__link">Our Achievement</a>
            <a href="<?php echo e(route('faq')); ?>" class="dropdown-menu__link">FAQ</a>
          </div>
        </div>

        <div class="has-dropdown">
          <button type="button" class="main-nav__link <?php echo e(request()->routeIs(['services','service-details']) ? 'is-active' : ''); ?>">
            Our Service
            <span class="main-nav__caret">+</span>
          </button>
          <div class="dropdown-menu">
            <a href="<?php echo e(route('services')); ?>" class="dropdown-menu__link">Service List</a>
          </div>
        </div>

        <div class="has-dropdown">
          <button type="button" class="main-nav__link <?php echo e(request()->routeIs(['doctors','doctor-details']) ? 'is-active' : ''); ?>">
            Doctor's
            <span class="main-nav__caret">+</span>
          </button>
          <div class="dropdown-menu">
            <a href="<?php echo e(route('doctors')); ?>" class="dropdown-menu__link">Doctor's List</a>
          </div>
        </div>

        <a href="<?php echo e(route('gallery')); ?>" class="main-nav__link <?php echo e(request()->routeIs('gallery') ? 'is-active' : ''); ?>">Gallery</a>
        <a href="<?php echo e(route('blog-list')); ?>" class="main-nav__link <?php echo e(request()->routeIs(['blog-list','blog-details']) ? 'is-active' : ''); ?>">Blog</a>
        <a href="<?php echo e(route('contact')); ?>" class="main-nav__link <?php echo e(request()->routeIs('contact') ? 'is-active' : ''); ?>">Contact Us</a>
      </nav>

      <div class="site-header__actions">
        <a href="<?php echo e($headerSettings['header_book_btn_url'] ?? route('appointment')); ?>" class="btn-appointment"><?php echo e($headerSettings['header_book_btn_text'] ?? 'Appointment'); ?></a>
        <button type="button" class="menu-toggle" data-menu-toggle aria-label="Open menu">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- ===================== Off-canvas side panel ===================== -->
  <div class="side-panel-overlay" data-panel-overlay></div>

  <aside class="side-panel" data-side-panel>
    <button type="button" class="side-panel__close" data-panel-close aria-label="Close menu">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="m6 6 12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </button>

    <a href="<?php echo e(route('home')); ?>" class="site-logo">
      <img src="<?php echo e(!empty($headerSettings['header_logo']) ? asset('storage/' . $headerSettings['header_logo']) : asset('assets/img/logo.png')); ?>" alt="<?php echo e($headerSettings['header_site_name'] ?? 'Sitakund Modern Hospital Ltd.'); ?>" height="56" style="height:56px;width:auto" />
    </a>

    <p class="side-panel__desc">
      <?php echo e($headerSettings['header_sidebar_description'] ?? "ClinicMaster Ipsum Dolor Sit Amet, Consectetuer Adipiscing Elit, Sed Diam Nonummy Nibh Euismod Tincidunt Ut Laoreet Dolore Agna Aliquam Erat. Wisi Enim Ad Minim Veniam, Quis Tation."); ?>

    </p>

    <nav class="side-panel__nav">
      <a href="<?php echo e(route('home')); ?>" class="side-panel__nav-link">Home</a>

      <div>
        <button type="button" class="side-panel__nav-link" data-submenu-toggle>
          About Us
          <span class="side-panel__nav-caret">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </button>
        <div class="side-panel__submenu">
          <a href="<?php echo e(route('about')); ?>" class="side-panel__nav-sublink">Company Profile</a>
          <a href="<?php echo e(route('history')); ?>" class="side-panel__nav-sublink">Our History</a>
          <a href="<?php echo e(route('md-message')); ?>" class="side-panel__nav-sublink">Message From MD/CEO</a>
          <a href="<?php echo e(route('management')); ?>" class="side-panel__nav-sublink">Our Management</a>
          <a href="<?php echo e(route('achievements')); ?>" class="side-panel__nav-sublink">Our Achievement</a>
          <a href="<?php echo e(route('faq')); ?>" class="side-panel__nav-sublink">FAQ</a>
        </div>
      </div>

      <div>
        <button type="button" class="side-panel__nav-link" data-submenu-toggle>
          Our Service
          <span class="side-panel__nav-caret">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </button>
        <div class="side-panel__submenu">
          <a href="<?php echo e(route('services')); ?>" class="side-panel__nav-sublink">Service List</a>
        </div>
      </div>

      <div>
        <button type="button" class="side-panel__nav-link" data-submenu-toggle>
          Doctor's
          <span class="side-panel__nav-caret">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </button>
        <div class="side-panel__submenu">
          <a href="<?php echo e(route('doctors')); ?>" class="side-panel__nav-sublink">Doctor's List</a>
        </div>
      </div>

      <a href="<?php echo e(route('gallery')); ?>" class="side-panel__nav-link">Gallery</a>
      <a href="<?php echo e(route('blog-list')); ?>" class="side-panel__nav-link">Blog</a>
      <a href="<?php echo e(route('contact')); ?>" class="side-panel__nav-link">Contact Us</a>
    </nav>

    <h3 class="side-panel__title">Contact Us</h3>
    <div class="side-panel__contact-list">
      <div class="side-panel__contact-item">
        <span class="side-panel__check">
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
        <?php echo e($headerSettings['header_address'] ?? '36D Street Brooklyn, New York'); ?>

      </div>
      <div class="side-panel__contact-item">
        <span class="side-panel__check">
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
        <?php echo e($headerSettings['header_email'] ?? 'info@example.com'); ?>

      </div>
      <div class="side-panel__contact-item">
        <span class="side-panel__check">
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
        <?php echo e($headerSettings['header_phone'] ?? '+1 (234) 5688 9990'); ?>

      </div>
    </div>

    <h3 class="side-panel__title">Follow Us</h3>
    <div class="side-panel__social-list">
      <a href="<?php echo e($headerSettings['header_facebook_url'] ?? '#'); ?>" class="side-panel__social-link" aria-label="Facebook">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z"/></svg>
      </a>
      <a href="<?php echo e($headerSettings['header_twitter_url'] ?? '#'); ?>" class="side-panel__social-link" aria-label="Twitter">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 0 1-1.9.1c.5 1.7 2.1 2.9 4 2.9A8.2 8.2 0 0 1 2 18.6a11.6 11.6 0 0 0 6.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z"/></svg>
      </a>
      <a href="<?php echo e($headerSettings['header_linkedin_url'] ?? '#'); ?>" class="side-panel__social-link" aria-label="LinkedIn">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z"/></svg>
      </a>
      <a href="<?php echo e($headerSettings['header_instagram_url'] ?? '#'); ?>" class="side-panel__social-link" aria-label="Instagram">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></svg>
      </a>
    </div>
  </aside>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views\components\frontend\header.blade.php ENDPATH**/ ?>