<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'ClinicMaster | Medical & Health Care Services')</title>
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
