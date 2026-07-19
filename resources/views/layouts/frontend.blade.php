<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'ClinicMaster | Medical & Health Care Services')</title>
  <meta name="description" content="@yield('meta_description', 'ClinicMaster provides compassionate, modern medical and health care services.')" />
  @hasSection('meta_keywords')
  <meta name="keywords" content="@yield('meta_keywords')" />
  @endif
  <meta property="og:title" content="@yield('og_title', 'ClinicMaster | Medical & Health Care Services')" />
  <meta property="og:description" content="@yield('og_description', 'ClinicMaster provides compassionate, modern medical and health care services.')" />
  @hasSection('og_image')
  <meta property="og:image" content="@yield('og_image')" />
  @endif
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
