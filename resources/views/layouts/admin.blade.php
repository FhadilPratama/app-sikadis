<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}" />
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" />

  <title>@yield('title', 'Admin Dashboard')</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <!-- Nucleo -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

  <!-- Argon CSS -->
  <link href="{{ asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />
</head>

<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 bg-gray-50 text-slate-500">

  <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>

  @include('components.admin.sidebar')

  <main class="relative h-full max-h-screen transition-all duration-200 xl:ml-68 rounded-xl">

    @include('components.admin.navbar')

    @yield('content')

  </main>

  {{-- FIXED PLUGIN --}}
  @include('components.admin.fixed-plugin')

  <!-- CORE JS (❌ TANPA ASYNC) -->
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/argon-dashboard-tailwind.js?v=1.0.1') }}"></script>

</body>
</html>
