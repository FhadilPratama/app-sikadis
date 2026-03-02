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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Nucleo -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

  <!-- Argon CSS -->
  <link href="{{ asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />

  <!-- sidebar Styling -->
  <link href="{{ asset('css/components/admin/sidebar.css') }}" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('css/admin/sekolah/index.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/pesertaDidik/index.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/pesertaDidik/edit.css') }}">


  <!-- Alpine JS -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 bg-gray-50
             flex flex-col min-h-screen">

  {{-- Header background --}}
  <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>

  {{-- Sidebar --}}
  @include('components.admin.sidebar')

  {{-- Main content --}}
  <main class="relative flex-1 transition-all duration-200 xl:ml-68 rounded-xl flex flex-col">

    {{-- Navbar --}}
    @include('components.admin.navbar')

    {{-- Content --}}
    <div class="flex-1 px-6 py-6">
      @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="w-full mt-6 py-6">
      @include('components.admin.footer')
    </footer>

  </main>

  {{-- Fixed plugin --}}
  @include('components.admin.fixed-plugin')

  <!-- CORE JS -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/argon-dashboard-tailwind.js?v=1.0.1') }}"></script>

  @stack('scripts')
</body>

</html> 