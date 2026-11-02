<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->role === 'lapangan' ? route('assets.index') : route('leader.contents.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Menu -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    {{-- LAPANGAN --}}
                    @if(auth()->user()->role === 'lapangan')
                        <x-nav-link :href="route('assets.index')" :active="request()->routeIs('assets.*')">
                            Assets
                        </x-nav-link>

                        <x-nav-link :href="route('assets.create')" :active="request()->routeIs('assets.create')">
                            Upload Asset
                        </x-nav-link>
                    @endif

                    {{-- LEADER & EDITOR --}}
                    @if(in_array(auth()->user()->role, ['leader','editor']))
                        <x-nav-link :href="route('leader.contents.index')" :active="request()->routeIs('contents.*')">
                            Content Plan
                        </x-nav-link>

                        <x-nav-link :href="route('assets.index')" :active="request()->routeIs('assets.*')">
                            Assets
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <!-- RIGHT -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-700">
                            <div>{{ Auth::user()->name }}</div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- HAMBURGER -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 text-gray-400 hover:text-gray-500">
                    ☰
                </button>
            </div>
        </div>
    </div>
</nav>
