<nav x-data="{ open: false }" class="bg-slate-900/90 backdrop-blur-md border-b border-white/10 sticky top-0 z-50 transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="group flex items-center gap-3">
                        <div class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 shadow-lg group-hover:shadow-indigo-500/50 transition-all duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-white tracking-tight leading-none group-hover:text-indigo-400 transition-colors">HM Company</span>
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-medium">Inventory System</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center gap-6">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'border-indigo-500 text-white font-bold' : 'border-transparent text-slate-300 hover:text-white hover:border-slate-300' }}">
                        {{ __('Dashboard') }}
                    </a>

                    @if(in_array(Auth::user()->role, ['admin', 'head']))
                    <a href="{{ route('users.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('users.*') ? 'border-indigo-500 text-white font-bold' : 'border-transparent text-slate-300 hover:text-white hover:border-slate-300' }}">
                        {{ __('Manajemen Pengguna') }}
                    </a>
                    @endif

                    <!-- Dropdown: Aset & Perawatan -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out gap-1 focus:outline-none {{ request()->routeIs('tools.*') || request()->routeIs('categories.*') || request()->routeIs('maintenances.*') ? 'border-indigo-500 text-white font-bold' : 'border-transparent text-slate-300 hover:text-white hover:border-slate-300' }}">
                                    <div>Aset & Perawatan</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Inventaris</div>
                                <x-dropdown-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                                    {{ __('Kategori Aset') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('tools.index')" :active="request()->routeIs('tools.index')">
                                    {{ __('Daftar Aset') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('tools.trash')" :active="request()->routeIs('tools.trash')">
                                    {{ __('Item Terhapus') }}
                                </x-dropdown-link>

                                <div class="border-t border-slate-100 my-1"></div>
                                
                                <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Perawatan</div>
                                <x-dropdown-link :href="route('maintenance-types.index')" :active="request()->routeIs('maintenance-types.*')">
                                    {{ __('Jenis Perawatan') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('maintenances.index')" :active="request()->routeIs('maintenances.*')">
                                    {{ __('Riwayat Perawatan') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Dropdown: Sirkulasi & Pengadaan -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out gap-1 focus:outline-none {{ request()->routeIs('borrowers.*') || request()->routeIs('borrowings.*') || request()->routeIs('purchases.*') || request()->routeIs('vendors.*') ? 'border-indigo-500 text-white font-bold' : 'border-transparent text-slate-300 hover:text-white hover:border-slate-300' }}">
                                    <div>Sirkulasi & Pengadaan</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Sirkulasi</div>
                                <x-dropdown-link :href="route('borrowers.index')" :active="request()->routeIs('borrowers.*')">
                                    {{ __('Data Anggota') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('borrowings.index')" :active="request()->routeIs('borrowings.*')">
                                    {{ __('Transaksi Peminjaman') }}
                                </x-dropdown-link>

                                <div class="border-t border-slate-100 my-1"></div>

                                <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Pengadaan</div>
                                <x-dropdown-link :href="route('vendors.index')" :active="request()->routeIs('vendors.*')">
                                    {{ __('Data Supplier') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('purchases.request')" :active="request()->routeIs('purchases.request')">
                                    {{ __('Pengajuan Pengadaan') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('purchases.transaction')" :active="request()->routeIs('purchases.transaction')">
                                    {{ __('Transaksi Pengadaan') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('purchases.history')" :active="request()->routeIs('purchases.history')">
                                    {{ __('Riwayat Pengadaan') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-slate-300 hover:text-white focus:outline-none transition ease-in-out duration-150 gap-2">
                            <div class="text-right hidden md:block">
                                <div class="text-sm font-bold">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] text-slate-400 bg-slate-800 px-2 py-0.5 rounded-full inline-block uppercase tracking-wider">{{ Auth::user()->role }}</div>
                            </div>
                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold ring-2 ring-slate-800 shadow-md">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-200 hover:bg-slate-800 focus:outline-none focus:bg-slate-800 focus:text-slate-200 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-900 border-t border-slate-800/50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(in_array(Auth::user()->role, ['admin', 'head']))
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                {{ __('Manajemen Pengguna') }}
            </x-responsive-nav-link>
            @endif

            <div class="border-t border-slate-800 my-2"></div>
            <div class="px-4 py-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Aset & Maintenance</div>

            <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                {{ __('Kategori Aset') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tools.index')" :active="request()->routeIs('tools.index')">
                {{ __('Daftar Aset') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('maintenance-types.index')" :active="request()->routeIs('maintenance-types.*')">
                {{ __('Jenis Perawatan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('maintenances.index')" :active="request()->routeIs('maintenances.*')">
                {{ __('Riwayat Perawatan') }}
            </x-responsive-nav-link>

             <div class="border-t border-slate-800 my-2"></div>
            <div class="px-4 py-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Sirkulasi & Pengadaan</div>

            <x-responsive-nav-link :href="route('borrowers.index')" :active="request()->routeIs('borrowers.*')">
                {{ __('Data Anggota') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('borrowings.index')" :active="request()->routeIs('borrowings.*')">
                {{ __('Transaksi Peminjaman') }}
            </x-responsive-nav-link>
             <x-responsive-nav-link :href="route('vendors.index')" :active="request()->routeIs('vendors.*')">
                {{ __('Data Supplier') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('purchases.request')" :active="request()->routeIs('purchases.request')">
                {{ __('Pengajuan Pengadaan') }}
            </x-responsive-nav-link>

        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-800">
            <div class="px-4 flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-slate-700 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-base text-slate-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>