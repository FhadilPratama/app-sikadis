<aside sidenav-main sidenav-color="blue" class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 
         -translate-x-full bg-white border-0 shadow-xl dark:bg-slate-850 max-w-64 ease-nav-brand z-990 
         xl:ml-6 rounded-2xl xl:translate-x-0">

  <!-- Logo -->
  <div class="h-19 relative">
    <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times 
              dark:text-white text-slate-400 xl:hidden" sidenav-close></i>

    <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700" href="#">
      <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="inline h-full max-w-full dark:hidden max-h-8" />
      <img src="{{ asset('assets/img/logo-ct.png') }}" class="hidden h-full max-w-full dark:inline max-h-8" />
      <span class="ml-1 font-semibold">SIKADIS</span>
    </a>
  </div>

  <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

  <!-- Menu -->
  <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
    <ul class="flex flex-col pl-0 mb-0">

      <!-- Dashboard -->
      <li class="mt-0.5 w-full">
        <a href="{{ route('admin.dashboard') }}" class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors dark:text-white dark:opacity-80
                  {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }}">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
            <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-tv-2"></i>
          </div>
          <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Dashboard</span>
        </a>
      </li>

      <!-- Sekolah -->
      <li class="mt-0.5 w-full">
        <a href="{{ route('admin.sekolah.index') }}" class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors dark:text-white dark:opacity-80
                  {{ request()->routeIs('admin.sekolah.*') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }}">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
            <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-building"></i>
          </div>
          <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Sekolah</span>
        </a>
      </li>

      <!-- Tahun Ajaran -->
      <li class="mt-0.5 w-full">
        <a href="{{ route('admin.tahun-ajar.index') }}" class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors
            dark:text-white dark:opacity-80
            {{ request()->routeIs('admin.tahun-ajar.*')
            ? 'bg-blue-500/13 font-semibold text-slate-700'
            : '' }}">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
            <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-calendar-grid-58"></i>
          </div>
          <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">
            Tahun Ajaran
          </span>
        </a>
      </li>

      <!-- Kelas -->
      <li class="mt-0.5 w-full">
        <a href="{{ route('admin.kelas.index') }}" class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors
            dark:text-white dark:opacity-80
            {{ request()->routeIs('admin.kelas.*') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }}">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
            <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-collection"></i>
          </div>
          <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">
            Kelas
          </span>
        </a>
      </li>

    </ul>
  </div>
</aside>
