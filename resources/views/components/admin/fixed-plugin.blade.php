<div fixed-plugin>
  <a fixed-plugin-button
     class="fixed px-4 py-2 text-xl bg-white shadow-lg cursor-pointer bottom-8 right-8 z-990 rounded-circle text-slate-700">
    <i class="py-2 pointer-events-none fa fa-cog"></i>
  </a>

  <!-- -right-90 in loc de 0 -->
  <div fixed-plugin-card
       class="z-sticky backdrop-blur-2xl backdrop-saturate-200 dark:bg-slate-850/80 shadow-3xl w-90 ease -right-90 fixed top-0 left-auto flex h-full min-w-0 flex-col break-words rounded-none border-0 bg-white/80 bg-clip-border px-2.5 duration-200">

    <div class="px-6 pt-4 pb-0 mb-0 border-b-0 rounded-t-2xl">
      <div class="float-left">
        <h5 class="mt-4 mb-0 dark:text-white">Argon Configurator</h5>
        <p class="dark:text-white dark:opacity-80">See our dashboard options.</p>
      </div>
      <div class="float-right mt-6">
        <button fixed-plugin-close-button
          class="inline-block p-0 mb-4 text-sm font-bold leading-normal text-center uppercase align-middle transition-all ease-in bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:-translate-y-px tracking-tight-rem bg-150 bg-x-25 active:opacity-85 dark:text-white text-slate-700">
          <i class="fa fa-close"></i>
        </button>
      </div>
    </div>

    <hr class="h-px mx-0 my-1 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />

    <div class="flex-auto p-6 pt-0 overflow-auto sm:pt-4">

      <div>
        <h6 class="mb-0 dark:text-white">Sidebar Colors</h6>
      </div>

      <a href="javascript:void(0)">
        <div class="my-2 text-left" sidenav-colors>
          <span class="py-2.2 text-xs rounded-circle h-5.6 mr-1.25 w-5.6 bg-gradient-to-tl from-blue-500 to-violet-500 inline-block cursor-pointer border border-slate-700"
            active-color data-color="blue" onclick="sidebarColor(this)"></span>
          <span class="py-2.2 text-xs rounded-circle h-5.6 mr-1.25 w-5.6 bg-gradient-to-tl from-zinc-800 to-zinc-700 inline-block cursor-pointer border border-white"
            data-color="gray" onclick="sidebarColor(this)"></span>
          <span class="py-2.2 text-xs rounded-circle h-5.6 mr-1.25 w-5.6 bg-gradient-to-tl from-blue-700 to-cyan-500 inline-block cursor-pointer border border-white"
            data-color="cyan" onclick="sidebarColor(this)"></span>
          <span class="py-2.2 text-xs rounded-circle h-5.6 mr-1.25 w-5.6 bg-gradient-to-tl from-emerald-500 to-teal-400 inline-block cursor-pointer border border-white"
            data-color="emerald" onclick="sidebarColor(this)"></span>
          <span class="py-2.2 text-xs rounded-circle h-5.6 mr-1.25 w-5.6 bg-gradient-to-tl from-orange-500 to-yellow-500 inline-block cursor-pointer border border-white"
            data-color="orange" onclick="sidebarColor(this)"></span>
          <span class="py-2.2 text-xs rounded-circle h-5.6 mr-1.25 w-5.6 bg-gradient-to-tl from-red-600 to-orange-600 inline-block cursor-pointer border border-white"
            data-color="red" onclick="sidebarColor(this)"></span>
        </div>
      </a>

      <div class="mt-4">
        <h6 class="mb-0 dark:text-white">Sidenav Type</h6>
        <p class="text-sm dark:text-white dark:opacity-80">Choose between 2 different sidenav types.</p>
      </div>

      <div class="flex">
        <button transparent-style-btn
          class="w-full px-4 py-2.5 font-bold text-white bg-gradient-to-tl from-blue-500 to-violet-500 rounded-lg"
          data-class="bg-transparent" active-style>White</button>

        <button white-style-btn
          class="w-full px-4 py-2.5 ml-2 font-bold text-blue-500 border border-blue-500 rounded-lg"
          data-class="bg-white">Dark</button>
      </div>

      <div class="flex my-4">
        <h6 class="mb-0 dark:text-white">Navbar Fixed</h6>
        <div class="ml-auto">
          <input navbarFixed type="checkbox" class="cursor-pointer" />
        </div>
      </div>

      <hr class="h-px my-6 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

      <div class="flex mt-2 mb-12">
        <h6 class="mb-0 dark:text-white">Light / Dark</h6>
        <div class="ml-auto">
          <input dark-toggle type="checkbox" class="cursor-pointer" />
        </div>
      </div>

    </div>
  </div>
</div>
