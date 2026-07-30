<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', __('frontend.meta.default_title'))</title>
  <meta name="description" content="@yield('meta_description', __('frontend.meta.default_description'))" />
  @hasSection('meta_keywords')
  <meta name="keywords" content="@yield('meta_keywords')" />
  @endif
  <meta property="og:title" content="@yield('og_title', __('frontend.meta.default_title'))" />
  <meta property="og:description" content="@yield('og_description', __('frontend.meta.default_description'))" />
  @hasSection('og_image')
  <meta property="og:image" content="@yield('og_image')" />
  @endif
  @php
    $faviconPath = !empty($headerSettings['header_favicon']) ? asset('storage/' . $headerSettings['header_favicon']) : asset('favicon.ico');
    $faviconExt  = strtolower(pathinfo($headerSettings['header_favicon'] ?? 'favicon.ico', PATHINFO_EXTENSION));
    $faviconType = ['png' => 'image/png', 'svg' => 'image/svg+xml', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'webp' => 'image/webp'][$faviconExt] ?? 'image/x-icon';
  @endphp
  <link rel="icon" href="{{ $faviconPath }}" type="{{ $faviconType }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/main.css') }}" />
</head>
<body class="font-sans">

  <x-frontend.header />

  <!-- ===================== Main content ===================== -->
  <main>
    @yield('content')
  </main>

  <x-frontend.footer />

  <script src="{{ asset('assets/main.js') }}"></script>
</body>
</html>
