<div fixed-plugin>
  <!-- Button Trigger -->
  <a fixed-plugin-button
     class="fixed px-4 py-2 text-xl bg-white shadow-lg cursor-pointer bottom-8 right-8 z-990 rounded-circle text-slate-700">
    <i class="py-2 pointer-events-none fa fa-cog"> </i>
  </a>

  <!-- Plugin Card -->
  <div fixed-plugin-card
       class="z-sticky backdrop-blur-2xl backdrop-saturate-200 dark:bg-slate-850/80 shadow-3xl w-90 ease -right-90 fixed top-0 left-auto flex h-full min-w-0 flex-col break-words rounded-none border-0 bg-white/80 bg-clip-border px-2.5 duration-200">

    <!-- Header -->
    <div class="px-6 pt-4 pb-0 mb-0 border-b-0 rounded-t-2xl flex justify-between items-start">
      <div>
        <h5 class="mt-4 mb-0 dark:text-white">Argon Configurator</h5>
        <p class="dark:text-white dark:opacity-80">See our dashboard options.</p>
      </div>
      <button fixed-plugin-close-button
              class="inline-block p-0 mb-4 text-sm font-bold leading-normal text-center uppercase align-middle transition-all ease-in bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:-translate-y-px tracking-tight-rem bg-150 bg-x-25 active:opacity-85 dark:text-white text-slate-700">
        <i class="fa fa-close"></i>
      </button>
    </div>

    <hr class="h-px mx-0 my-1 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />

    <!-- Content -->
    <div class="flex-auto p-6 pt-0 overflow-auto sm:pt-4">

      <!-- Sidebar Colors -->
      <div>
        <h6 class="mb-0 dark:text-white">Sidebar Colors</h6>
      </div>
      <a href="javascript:void(0)">
        <div class="my-2 text-left" sidenav-colors>
          @php
            $sidebarColors = [
              ['color' => 'blue', 'from' => 'blue-500', 'to' => 'violet-500', 'border' => 'border-slate-700'],
              ['color' => 'gray', 'from' => 'zinc-800', 'to' => 'zinc-700', 'border' => 'border-white dark:border-white'],
              ['color' => 'cyan', 'from' => 'blue-700', 'to' => 'cyan-500', 'border' => 'border-white'],
              ['color' => 'emerald', 'from' => 'emerald-500', 'to' => 'teal-400', 'border' => 'border-white'],
              ['color' => 'orange', 'from' => 'orange-500', 'to' => 'yellow-500', 'border' => 'border-white'],
              ['color' => 'red', 'from' => 'red-600', 'to' => 'orange-600', 'border' => 'border-white'],
            ];
          @endphp
          @foreach($sidebarColors as $sc)
            <span class="py-2.2 text-xs rounded-circle h-5.6 w-5.6 ease-in-out relative inline-block cursor-pointer whitespace-nowrap border border-solid {{ $sc['border'] }} text-center align-baseline font-bold uppercase leading-none text-white transition-all duration-200 hover:border-slate-700 bg-gradient-to-tl from-{{ $sc['from'] }} to-{{ $sc['to'] }}"
                  data-color="{{ $sc['color'] }}" onclick="sidebarColor(this)"></span>
          @endforeach
        </div>
      </a>

      <!-- Sidenav Type -->
      <div class="mt-4">
        <h6 class="mb-0 dark:text-white">Sidenav Type</h6>
        <p class="text-sm leading-normal dark:text-white dark:opacity-80">Choose between 2 different sidenav types.</p>
      </div>
      <div class="flex">
        <button transparent-style-btn
                class="inline-block w-full px-4 py-2.5 mb-2 font-bold leading-normal text-center text-white capitalize align-middle transition-all bg-blue-500 border border-transparent rounded-lg cursor-pointer text-sm hover:-translate-y-px active:opacity-85 shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-blue-500 to-violet-500"
                data-class="bg-transparent" active-style>White</button>
        <button white-style-btn
                class="inline-block w-full px-4 py-2.5 mb-2 ml-2 font-bold leading-normal text-center text-blue-500 capitalize align-middle transition-all bg-transparent border border-blue-500 rounded-lg text-sm hover:-translate-y-px active:opacity-85 shadow-md"
                data-class="bg-white">Dark</button>
      </div>
      <p class="block mt-2 text-sm leading-normal dark:text-white dark:opacity-80 xl:hidden">You can change the sidenav type just on desktop view.</p>

      <!-- Navbar Fixed -->
      <div class="flex my-4">
        <h6 class="mb-0 dark:text-white">Navbar Fixed</h6>
        <div class="block pl-0 ml-auto min-h-6">
          <input navbarFixed class="rounded-10 duration-250 ease-in-out after:rounded-circle after:shadow-2xl after:duration-250 checked:after:translate-x-5.3 h-5 relative float-left mt-1 ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-blue-500/95 checked:bg-blue-500/95 checked:bg-none checked:bg-right" type="checkbox" />
        </div>
      </div>

      <hr class="h-px my-6 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent " />

      <!-- Light / Dark Mode -->
      <div class="flex mt-2 mb-12">
        <h6 class="mb-0 dark:text-white">Light / Dark</h6>
        <div class="block pl-0 ml-auto min-h-6">
          <input dark-toggle class="rounded-10 duration-250 ease-in-out after:rounded-circle after:shadow-2xl after:duration-250 checked:after:translate-x-5.3 h-5 relative float-left mt-1 ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-blue-500/95 checked:bg-blue-500/95 checked:bg-none checked:bg-right" type="checkbox" />
        </div>
      </div>
    </div>
  </div>
</div>
