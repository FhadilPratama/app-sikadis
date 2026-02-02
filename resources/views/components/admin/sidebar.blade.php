<aside sidenav-main sidenav-color="blue"
  class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 -translate-x-full bg-white border-0 shadow-xl dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:translate-x-0">
  <div class="h-19">
    <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden"
      sidenav-close></i>

    <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700" href="#">
      <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="inline h-full max-w-full dark:hidden max-h-8" />
      <img src="{{ asset('assets/img/logo-ct.png') }}" class="hidden h-full max-w-full dark:inline max-h-8" />
      <span class="ml-1 font-semibold">Argon Dashboard 2</span>
    </a>
  </div>

  <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

  <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow">
    <ul class="flex flex-col pl-0 mb-0">
      <li class="mt-0.5 w-full">
        <a class="py-2.7 bg-blue-500/13 text-sm my-0 mx-2 flex items-center rounded-lg px-4 font-semibold text-slate-700"
          href="#">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg">
            <i class="text-sm text-blue-500 ni ni-tv-2"></i>
          </div>
          <span>Dashboard</span>
        </a>
      </li>
    </ul>
  </div>
</aside>