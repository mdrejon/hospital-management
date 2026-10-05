  <!-- ===================== Header ===================== -->
  <header class="site-header">
    <!-- Top info bar -->
    <div class="border-b border-gray-100 hidden lg:block py-2">
      <div class="container mx-auto flex justify-between items-center text-sm font-medium text-navy">
        <div class="flex items-center gap-6">
          <a href="{{ route('about') }}" class="hover:text-brand-cyan transition">About</a>
          <a href="{{ route('doctors') }}" class="hover:text-brand-cyan transition">Doctors</a>
          <a href="{{ route('contact') }}" class="hover:text-brand-cyan transition">Contact</a>
          <a href="{{ route('faq') }}" class="hover:text-brand-cyan transition">FAQ</a>
        </div>
        <div class="flex items-center gap-6">
          <a href="tel:{{ $headerSettings['header_phone'] ?? '+880 1234 56789' }}" class="flex items-center gap-2 hover:text-brand-cyan transition">
            <svg class="w-4 h-4 text-brand-cyan" fill="currentColor" viewBox="0 0 24 24">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.489-1.761-1.663-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" />
            </svg>
            {{ $headerSettings['header_phone'] ?? '+880 1234 56789' }}
          </a>
          <a href="mailto:{{ $headerSettings['header_email'] ?? 'support@yourmail.com' }}" class="flex items-center gap-2 hover:text-brand-cyan transition">
            <svg class="w-4 h-4 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            {{ $headerSettings['header_email'] ?? 'support@yourmail.com' }}
          </a>
          <!-- Language Switcher -->
          @if(isset($languages) && count($languages) > 0)
          <div class="flex items-center gap-2 border-l border-gray-300 pl-4">
            @foreach ($languages as $lang)
            <a href="{{ route('language.switch', $lang->code) }}" class="{{ app()->getLocale() === $lang->code ? 'text-brand-cyan font-bold' : 'text-navy hover:text-brand-cyan transition' }} uppercase">{{ $lang->code }}</a>
            @endforeach
          </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Middle bar -->
    <div class="hidden lg:block py-2 bg-white">
      <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="site-logo">
          <img src="{{ !empty($headerSettings['header_logo']) ? asset('storage/' . $headerSettings['header_logo']) : asset('assets/img/logo.png') }}" alt="{{ $headerSettings['header_site_name'] ?? 'Medicare Lab Ltd.' }}" height="42" style="height:95px;width:auto" />
        </a>

        <!-- Info & CTA -->
        <div class="flex items-center gap-8">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-brand-cyan rounded flex items-center justify-center text-white shrink-0">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.489-1.761-1.663-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" />
              </svg>
            </div>
            <div>
              <div class="text-[13px] text-gray-500">Call Us Anytime</div>
              <div class="font-bold text-[15px] text-navy">{{ $headerSettings['header_phone'] ?? '+880123-467-789' }}</div>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-brand-cyan rounded flex items-center justify-center text-white shrink-0">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div>
              <div class="text-[13px] text-gray-500">Opening Time</div>
              <div class="font-bold text-[15px] text-navy">{{ $headerSettings['header_hours'] ?? 'Mon-Sat: 9.00-18.00' }}</div>
            </div>
          </div>

          <!-- <a href="{{ $headerSettings['header_book_btn_url'] ?? route('appointment') }}" class="inline-flex items-center justify-center bg-brand-cyan text-white font-semibold py-[11px] px-8 rounded transition hover:bg-navy text-[15px]">
            {{ $headerSettings['header_book_btn_text'] ?? 'Appointment' }}
          </a> -->
        </div>
      </div>
    </div>
  </header>

  <!-- Main nav row -->
  <div class="site-header__nav">
    <div class="site-header__inner">

      <!-- Mobile logo -->
      <a href="{{ route('home') }}" class="site-logo site-logo--mobile">
        <img src="{{ !empty($headerSettings['header_logo']) ? asset('storage/' . $headerSettings['header_logo']) : asset('assets/img/logo.png') }}" alt="{{ $headerSettings['header_site_name'] ?? 'Medicare Lab Ltd.' }}" height="42" style="height:42px;width:auto" />
      </a>

      <!-- Desktop Nav -->
      <nav class="main-nav">
        <a href="{{ route('home') }}" class="main-nav__link {{ request()->routeIs('home') ? 'is-active' : '' }}">{{ __('frontend.nav.home') }}</a>

        <div class="has-dropdown">
          <a href="{{ route('about') }}" class="main-nav__link {{ request()->routeIs(['about','history','md-message','management','achievements','faq']) ? 'is-active' : '' }}">
            {{ __('frontend.nav.about_us') }}
            <span class="main-nav__caret"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
              </svg></span>
          </a>
          <div class="dropdown-menu">
            <a href="{{ route('about') }}" class="dropdown-menu__link">{{ __('frontend.nav.company_profile') }}</a>
            <a href="{{ route('history') }}" class="dropdown-menu__link">{{ __('frontend.nav.our_history') }}</a>
            <a href="{{ route('md-message') }}" class="dropdown-menu__link">{{ __('frontend.nav.md_message') }}</a>
            <a href="{{ route('management') }}" class="dropdown-menu__link">{{ __('frontend.nav.our_management') }}</a>
            <a href="{{ route('achievements') }}" class="dropdown-menu__link">{{ __('frontend.nav.our_achievement') }}</a>
            <a href="{{ route('faq') }}" class="dropdown-menu__link">{{ __('frontend.nav.faq') }}</a>
          </div>
        </div>

        <a href="{{ route('services') }}" class="main-nav__link {{ request()->routeIs(['services','service-details']) ? 'is-active' : '' }}">{{ __('frontend.nav.our_service') }}</a>

        <a href="{{ route('packages') }}" class="main-nav__link {{ request()->routeIs(['packages','package-details']) ? 'is-active' : '' }}">{{ __('frontend.breadcrumb.packages') }}</a>

        <div class="has-dropdown">
          <a href="{{ route('doctors') }}" class="main-nav__link {{ request()->routeIs(['doctors','doctor-details']) ? 'is-active' : '' }}">
            {{ __('frontend.nav.doctors') }}
            <span class="main-nav__caret"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
              </svg></span>
          </a>
          <div class="dropdown-menu">
            @forelse ($navDoctorSpecializations ?? [] as $spec)
            <a href="{{ route('doctor-details', $spec->slug) }}" class="dropdown-menu__link">{{ $spec->name }}</a>
            @empty
            <a href="{{ route('doctors') }}" class="dropdown-menu__link">{{ __('frontend.nav.doctors_list') }}</a>
            @endforelse
          </div>
        </div>

        <div class="has-dropdown">
          <button type="button" class="main-nav__link {{ request()->routeIs(['gallery','video-gallery']) ? 'is-active' : '' }}">
            {{ __('frontend.nav.gallery') }}
            <span class="main-nav__caret"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
              </svg></span>
          </button>
          <div class="dropdown-menu">
            <a href="{{ route('gallery') }}" class="dropdown-menu__link">Photo Gallery</a>
            <a href="{{ route('video-gallery') }}" class="dropdown-menu__link">Video Gallery</a>
          </div>
        </div>

        <a href="{{ route('blog-list') }}" class="main-nav__link {{ request()->routeIs(['blog-list','blog-details']) ? 'is-active' : '' }}">{{ __('frontend.nav.blog') }}</a>

        <a href="{{ route('contact') }}" class="main-nav__link {{ request()->routeIs('contact') ? 'is-active' : '' }}">{{ __('frontend.nav.contact_us') }}</a>
      </nav>

      <div class="site-header__actions">
        <!-- Inline Search Form (desktop) -->
        <form action="{{ route('search') }}" method="GET" class="hidden lg:flex items-center h-10 shadow-sm rounded">
          <input type="search" name="q" value="{{ request('q') }}" class="h-full border border-gray-200 border-r-0 px-4 py-2 text-[14px] text-gray-700 focus:outline-none w-56 rounded-l placeholder-gray-400" placeholder="search" required />
          <button type="submit" class="w-12 h-full bg-brand-cyan text-white rounded-r flex items-center justify-center hover:bg-navy transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </button>
        </form>

        <!-- Mobile Menu Toggle -->
        <button type="button" class="menu-toggle ml-2" data-menu-toggle aria-label="Open menu">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Collapsible Search Bar (mobile only) -->
    <div class="header-search-bar hidden lg:hidden border-t border-gray-100 bg-white py-4 px-4 absolute w-full left-0 top-full shadow-md z-40">
      <div class="container mx-auto">
        <form action="{{ route('search') }}" method="GET" class="flex items-center gap-2 max-w-xl mx-auto">
          <input type="search" name="q" value="{{ request('q') }}" class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-brand-cyan" placeholder="Search..." required />
          <button type="submit" class="bg-brand-cyan text-white px-6 py-2 rounded hover:bg-navy transition">Search</button>
        </form>
      </div>
    </div>
  </div>

  <!-- ===================== Off-canvas side panel ===================== -->
  <div class="side-panel-overlay" data-panel-overlay></div>

  <aside class="side-panel" data-side-panel>
    <button type="button" class="side-panel__close" data-panel-close aria-label="Close menu">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="m6 6 12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
      </svg>
    </button>

    <a href="{{ route('home') }}" class="site-logo">
      <img src="{{ !empty($headerSettings['header_logo']) ? asset('storage/' . $headerSettings['header_logo']) : asset('assets/img/logo.png') }}" alt="{{ $headerSettings['header_site_name'] ?? 'Medicare Lab Ltd.' }}" height="56" style="height:56px;width:auto" />
    </a>

    <p class="side-panel__desc">
      {{ $headerSettings['header_sidebar_description'] ?? "We are committed to providing compassionate, high-quality healthcare services to our patients and community. Your health is our priority." }}
    </p>

    <nav class="side-panel__nav">
      <a href="{{ route('home') }}" class="side-panel__nav-link">{{ __('frontend.nav.home') }}</a>

      <div>
        <button type="button" class="side-panel__nav-link" data-submenu-toggle>
          {{ __('frontend.nav.about_us') }}
          <span class="side-panel__nav-caret">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
        </button>
        <div class="side-panel__submenu">
          <a href="{{ route('about') }}" class="side-panel__nav-sublink">{{ __('frontend.nav.company_profile') }}</a>
          <a href="{{ route('history') }}" class="side-panel__nav-sublink">{{ __('frontend.nav.our_history') }}</a>
          <a href="{{ route('md-message') }}" class="side-panel__nav-sublink">{{ __('frontend.nav.md_message') }}</a>
          <a href="{{ route('management') }}" class="side-panel__nav-sublink">{{ __('frontend.nav.our_management') }}</a>
          <a href="{{ route('achievements') }}" class="side-panel__nav-sublink">{{ __('frontend.nav.our_achievement') }}</a>
          <a href="{{ route('faq') }}" class="side-panel__nav-sublink">{{ __('frontend.nav.faq') }}</a>
        </div>
      </div>

      <a href="{{ route('services') }}" class="side-panel__nav-link">{{ __('frontend.nav.our_service') }}</a>
      <a href="{{ route('packages') }}" class="side-panel__nav-link">Packages</a>

      <div>
        <button type="button" class="side-panel__nav-link" data-submenu-toggle>
          {{ __('frontend.nav.doctors') }}
          <span class="side-panel__nav-caret">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
        </button>
        <div class="side-panel__submenu">
          @forelse ($navDoctorSpecializations ?? [] as $spec)
          <a href="{{ route('doctor-details', $spec->slug) }}" class="side-panel__nav-sublink">{{ $spec->name }}</a>
          @empty
          <a href="{{ route('doctors') }}" class="side-panel__nav-sublink">{{ __('frontend.nav.doctors_list') }}</a>
          @endforelse
        </div>
      </div>

      <div>
        <button type="button" class="side-panel__nav-link" data-submenu-toggle>
          {{ __('frontend.nav.gallery') }}
          <span class="side-panel__nav-caret">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
        </button>
        <div class="side-panel__submenu">
          <a href="{{ route('gallery') }}" class="side-panel__nav-sublink">Photo Gallery</a>
          <a href="{{ route('video-gallery') }}" class="side-panel__nav-sublink">Video Gallery</a>
        </div>
      </div>

      <a href="{{ route('blog-list') }}" class="side-panel__nav-link">{{ __('frontend.nav.blog') }}</a>
      <a href="{{ route('contact') }}" class="side-panel__nav-link">{{ __('frontend.nav.contact_us') }}</a>
      <a href="{{ route('login') }}" class="side-panel__nav-link" style="color: #2563eb; font-weight: 700;">🔑 Agent Login / Portal</a>
    </nav>

    <h3 class="side-panel__title">{{ __('frontend.nav.contact_us') }}</h3>
    <div class="side-panel__contact-list">
      <div class="side-panel__contact-item">
        <span class="side-panel__check">
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
        {{ $headerSettings['header_address'] ?? '36D Street Brooklyn, New York' }}
      </div>
      <div class="side-panel__contact-item">
        <span class="side-panel__check">
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
        {{ $headerSettings['header_email'] ?? 'info@example.com' }}
      </div>
      <div class="side-panel__contact-item">
        <span class="side-panel__check">
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
        {{ $headerSettings['header_phone'] ?? '+1 (234) 5688 9990' }}
      </div>
    </div>

    <h3 class="side-panel__title">{{ __('frontend.common.language') }}</h3>
    <div class="side-panel__lang-switch">
      @foreach ($languages ?? [] as $lang)
      <a href="{{ route('language.switch', $lang->code) }}" class="side-panel__lang-link {{ app()->getLocale() === $lang->code ? 'is-active' : '' }}">{{ $lang->native_name }}</a>
      @endforeach
    </div>

    <h3 class="side-panel__title">Follow Us</h3>
    <div class="side-panel__social-list">
      <a href="{{ $headerSettings['header_facebook_url'] ?? '#' }}" class="side-panel__social-link" aria-label="Facebook">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
          <path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.35C16.3 4.24 15.4 4.15 14.3 4.15c-2.3 0-3.9 1.4-3.9 4v2.35H8v3h2.4V21h3.1z" />
        </svg>
      </a>
      <a href="{{ $headerSettings['header_twitter_url'] ?? '#' }}" class="side-panel__social-link" aria-label="Twitter">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
          <path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 0 1-1.9.1c.5 1.7 2.1 2.9 4 2.9A8.2 8.2 0 0 1 2 18.6a11.6 11.6 0 0 0 6.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z" />
        </svg>
      </a>
      <a href="{{ $headerSettings['header_linkedin_url'] ?? '#' }}" class="side-panel__social-link" aria-label="LinkedIn">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
          <path d="M6.9 8.4H3.5V20h3.4V8.4zM5.2 3.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM20.5 20h-3.4v-6.1c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.9 1.3-.1.2-.1.6-.1.9V20H9.9s.1-10.6 0-11.6h3.4v1.6c.5-.7 1.3-1.8 3.1-1.8 2.3 0 4 1.5 4 4.6V20z" />
        </svg>
      </a>
      <a href="{{ $headerSettings['header_instagram_url'] ?? '#' }}" class="side-panel__social-link" aria-label="Instagram">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <rect x="3.5" y="3.5" width="17" height="17" rx="5" />
          <circle cx="12" cy="12" r="4" />
          <circle cx="17.2" cy="6.8" r="1" />
        </svg>
      </a>
    </div>
  </aside>