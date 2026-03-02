@php
    $user = auth()->user();
    $role = 'admin';
    if ($user->isWaliKelas()) {
        $role = 'wali-kelas';
    } elseif ($user->isSiswa()) {
        $role = 'siswa';
    }
@endphp

<style>
.sidebar-scroll {
    overflow-y: auto;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE */
}
.sidebar-scroll::-webkit-scrollbar {
    display: none; /* Chrome, Safari */
}
</style>

<aside id="sidenav-main"
    class="fixed top-0 bottom-0
           xl:left-0 xl:ml-6
           mt-6 mb-6
           w-64 h-screen rounded-2xl
           bg-white dark:bg-slate-850
           shadow-xl z-990 flex flex-col">

    {{-- LOGO --}}
    <div class="h-19 shrink-0">
        <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden"></i>
        <a class="block px-8 py-6 text-sm whitespace-nowrap dark:text-white text-slate-700"
           href="{{ route($role . '.dashboard') }}">
            <img src="{{ asset('assets/img/logo-ct-dark.png') }}"
                 class="inline h-full max-h-8 dark:hidden">
            <img src="{{ asset('assets/img/logo-ct.png') }}"
                 class="hidden h-full max-h-8 dark:inline">
            <span class="ml-1 font-bold">SIKADIS SYSTEM</span>
        </a>
    </div>

    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:via-white">

    {{-- ================= MENU (SCROLLABLE) ================= --}}
    <div class="flex-1 sidebar-scroll">
        <ul class="flex flex-col pl-0 mb-0">

            {{-- DASHBOARD --}}
            <li class="mt-0.5 w-full">
                <a href="{{ route($role . '.dashboard') }}"
                   class="py-2.7 {{ request()->routeIs($role.'.dashboard') ? 'bg-blue-500/13 font-semibold' : '' }}
                          dark:text-white text-sm my-0 mx-2 flex items-center rounded-lg px-4">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center">
                        <i class="text-blue-500 ni ni-tv-2"></i>
                    </div>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- 2. MASTER DATA (Admin Only) --}}
            @if($user->isAdmin())
            <li class="w-full mt-4">
                <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">Master Data</h6>
            </li>
            
            <li class="mt-0.5 w-full">
                <div x-data="{ open: {{ request()->routeIs('admin.sekolah.*', 'admin.tahun-ajar.*', 'admin.kelas.*', 'admin.rombongan-belajar.*') ? 'true' : 'false' }} }">
                    <a @click="open = !open" href="javascript:void(0)" class="py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors justify-between">
                        <div class="flex items-center">
                            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                <i class="relative top-0 text-sm leading-normal text-orange-500 ni ni-archive-2"></i>
                            </div>
                            <span class="ml-1 duration-300 opacity-100 ease">Basis Data</span>
                        </div>
                        <i class="fas fa-chevron-down text-[10px] transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </a>
                    <ul x-show="open" class="flex flex-col pl-4 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.sekolah.index') }}" 
                               class="text-xs py-2 px-3 block rounded-lg transition-all duration-200 
                                      {{ request()->routeIs('admin.sekolah.*') 
                                         ? 'bg-blue-50 text-blue-600 font-bold dark:bg-blue-500/10 dark:text-blue-400' 
                                         : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 hover:bg-slate-50 dark:hover:text-white dark:hover:bg-slate-800' }}">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.sekolah.*') ? 'bg-blue-600 dark:bg-blue-400' : 'bg-slate-400 opacity-50' }}"></span>
                                    <span>Sekolah</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tahun-ajar.index') }}" 
                               class="text-xs py-2 px-3 block rounded-lg transition-all duration-200 
                                      {{ request()->routeIs('admin.tahun-ajar.*') 
                                         ? 'bg-blue-50 text-blue-600 font-bold dark:bg-blue-500/10 dark:text-blue-400' 
                                         : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 hover:bg-slate-50 dark:hover:text-white dark:hover:bg-slate-800' }}">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.tahun-ajar.*') ? 'bg-blue-600 dark:bg-blue-400' : 'bg-slate-400 opacity-50' }}"></span>
                                    <span>Tahun Ajaran</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.kelas.index') }}" 
                               class="text-xs py-2 px-3 block rounded-lg transition-all duration-200 
                                      {{ request()->routeIs('admin.kelas.*') 
                                         ? 'bg-blue-50 text-blue-600 font-bold dark:bg-blue-500/10 dark:text-blue-400' 
                                         : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 hover:bg-slate-50 dark:hover:text-white dark:hover:bg-slate-800' }}">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.kelas.*') ? 'bg-blue-600 dark:bg-blue-400' : 'bg-slate-400 opacity-50' }}"></span>
                                    <span>Kelas</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.rombongan-belajar.index') }}" 
                               class="text-xs py-2 px-3 block rounded-lg transition-all duration-200 
                                      {{ request()->routeIs('admin.rombongan-belajar.*') 
                                         ? 'bg-blue-50 text-blue-600 font-bold dark:bg-blue-500/10 dark:text-blue-400' 
                                         : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 hover:bg-slate-50 dark:hover:text-white dark:hover:bg-slate-800' }}">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.rombongan-belajar.*') ? 'bg-blue-600 dark:bg-blue-400' : 'bg-slate-400 opacity-50' }}"></span>
                                    <span>Rombongan Belajar</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            {{-- 3. DATA AKADEMIK --}}
            @if($user->isAdmin() || $user->isWaliKelas())
            <li class="w-full mt-4">
                <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">Data Akademik</h6>
            </li>

            @if($user->isAdmin())
            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ request()->routeIs('admin.wali-kelas.*') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }} dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors" 
                   href="{{ route('admin.wali-kelas.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-single-02"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 ease">Wali Kelas</span>
                </a>
            </li>
            @endif

            <li class="mt-0.5 w-full">
                @php 
                    $pdRoute = $user->isAdmin() ? 'admin.peserta-didik.index' : 'admin.peserta-didik.index'; 
                    // Adjusted since both roles use admin.peserta-didik.index currently
                @endphp
                <a class="py-2.7 {{ request()->routeIs('admin.peserta-didik.*') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }} dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors" 
                   href="{{ route('admin.peserta-didik.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-emerald-500 ni ni-hat-3"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 ease">Peserta Didik</span>
                </a>
            </li>
            @endif

            {{-- 4. PRESENSI (CORE) --}}
            <li class="w-full mt-4">
                <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">Layanan Presensi</h6>
            </li>

            @if($user->isAdmin() || $user->isWaliKelas())
            <li class="mt-0.5 w-full">
                <a href="{{ route('admin.presensi.index') }}" class="py-2.7 {{ request()->routeIs('admin.presensi.index') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }} dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-success ni ni-check-bold"></i>
                    </div>
                    <span class="ml-1">Presensi Harian</span>
                </a>
            </li>
            @endif

            @if($user->isSiswa())
            <li class="mt-0.5 w-full">
                <a href="{{ route('siswa.presensi.index') }}" class="py-2.7 {{ request()->routeIs('siswa.presensi.*') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }} dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-camera-compact"></i>
                    </div>
                    <span class="ml-1">Menu Presensi</span>
                </a>
            </li>
            @endif

            <li class="mt-0.5 w-full">
                @php
                    $izinRoute = 'admin.presensi.approval';
                    if($user->isSiswa()) $izinRoute = 'siswa.izin.index';
                    if($user->isWaliKelas()) $izinRoute = 'wali-kelas.izin.index';
                @endphp
                <a href="{{ route($izinRoute) }}" 
                   class="py-2.7 {{ request()->routeIs('*.izin.*', 'admin.presensi.approval') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }} dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-warning ni ni-email-83"></i>
                    </div>
                    <span class="ml-1">Izin & Sakit</span>
                </a>
            </li>

            {{-- 5. LAPORAN --}}
            @if($user->isAdmin() || $user->isWaliKelas())
            <li class="w-full mt-4">
                <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">Laporan & Rekap</h6>
            </li>
            
            <li class="mt-0.5 w-full">
                <div x-data="{ open: {{ request()->routeIs('admin.laporan.*', 'wali-kelas.laporan.*') ? 'true' : 'false' }} }">
                    <a @click="open = !open" href="javascript:void(0)" class="py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors justify-between">
                        <div class="flex items-center">
                            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                <i class="relative top-0 text-sm leading-normal text-red-500 ni ni-chart-bar-32"></i>
                            </div>
                            <span class="ml-1">Rekapitulasi</span>
                        </div>
                        <i class="fas fa-chevron-down text-[10px] transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </a>
                    <ul x-show="open" class="flex flex-col pl-12 mt-1 space-y-1">
                        <li><a href="#" class="text-xs py-2 block text-slate-500 dark:text-white/60">Rekap Rombel</a></li>
                        @if($user->isAdmin())
                        <li><a href="#" class="text-xs py-2 block text-slate-500 dark:text-white/60">Rekap Per Siswa</a></li>
                        <li><a href="#" class="text-xs py-2 block text-slate-500 dark:text-white/60">Rekap Sekolah</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 6. MANAJEMEN PENGGUNA (Admin Only) --}}
            @if($user->isAdmin())
            <li class="w-full mt-4">
                <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">Administrasi</h6>
            </li>
            <li class="mt-0.5 w-full">
                <a href="{{ route('admin.users.index') }}" class="py-2.7 {{ request()->routeIs('admin.users.*') ? 'bg-blue-500/13 font-semibold text-slate-700' : '' }} dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-slate-700 ni ni-settings"></i>
                    </div>
                    <span class="ml-1">Manajemen User</span>
                </a>
            </li>
            @endif

            {{-- SISTEM --}}
            <li class="w-full mt-4">
                <h6 class="pl-6 ml-2 text-xs font-bold uppercase opacity-60">Sistem & Akun</h6>
            </li>

            <li class="mt-0.5 w-full">
                @php
                    $profileRoute = $role . '.profile.edit';
                    if($role == 'admin' && !Route::has('admin.profile.edit'))
                        $profileRoute = 'wali-kelas.profile.edit';
                @endphp
                <a href="{{ route($profileRoute) }}"
                   class="py-2.7 dark:text-white text-sm my-0 mx-2 flex items-center rounded-lg px-4">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center">
                        <i class="text-info ni ni-circle-08"></i>
                    </div>
                    <span>Profil & Password</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full py-2.7 dark:text-white text-sm my-0 mx-2 flex items-center rounded-lg px-4 group">
                        <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg
                                    group-hover:bg-red-50 transition">
                            <i class="text-red-600 ni ni-button-power"></i>
                        </div>
                        <span class="group-hover:text-red-600 transition">
                            Keluar Aplikasi
                        </span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

</aside>