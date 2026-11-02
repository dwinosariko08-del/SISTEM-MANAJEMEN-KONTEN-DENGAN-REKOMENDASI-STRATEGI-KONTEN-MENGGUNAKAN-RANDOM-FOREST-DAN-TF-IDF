
    <header id="page-topbar">
        <div class="navbar-header">

            <div class="d-flex align-items-left">
                <button type="button"
                    class="btn btn-sm mr-2 d-lg-none px-3 font-size-16 header-item waves-effect"
                    id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <div class="dropdown d-none d-sm-inline-block">
                    

                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item notify-item">Application</a>
                        <a href="#" class="dropdown-item notify-item">Software</a>
                        <a href="#" class="dropdown-item notify-item">EMS System</a>
                        <a href="#" class="dropdown-item notify-item">CRM App</a>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center">

                <!-- Search -->
                <div class="dropdown d-none d-sm-inline-block ml-2">
                    <button type="button"
                        class="btn header-item noti-icon waves-effect"
                        id="page-header-search-dropdown"
                        data-toggle="dropdown">
                        <i class="mdi mdi-magnify"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0">
                        <form class="p-3">
                            <div class="input-group">
                                <input type="text"
                                    class="form-control"
                                    placeholder="Search ...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- Chat Icon -->
<div class="dropdown d-inline-block ml-2">

    <a href="{{ route('chat') }}"
       class="btn header-item noti-icon waves-effect d-flex align-items-center justify-content-center position-relative"
       style="height:40px; width:40px;">

        <i class="mdi mdi-chat" style="font-size:22px;"></i>

        @php
        $unreadCount = \App\Models\Message::where('sender_id','!=',auth()->id())
                        ->whereNull('read_at')
                        ->count();
        @endphp

        @if($unreadCount > 0)
        <span class="badge badge-danger badge-pill"
              style="position:absolute; top:3px; right:3px; font-size:10px;">
            {{ $unreadCount }}
        </span>
        @endif

    </a>

</div>
                <!-- User -->
                <div class="dropdown d-inline-block ml-2">

                    <button type="button"
                        class="btn header-item waves-effect"
                        data-toggle="dropdown">

                        @if(Auth::user()->avatar)
                            <img class="rounded-circle header-profile-user" src="{{ asset('storage/' . Auth::user()->avatar) }}" style="object-fit: cover;">
                        @else
                            <div class="rounded-circle header-profile-user bg-primary text-white d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px; font-weight: bold; font-size: 16px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif

                        <span class="d-none d-sm-inline-block ml-1">

                            {{ Auth::user()->name ?? 'Admin' }}

                        </span>

                        <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>

                    </button>

                    <div class="dropdown-menu dropdown-menu-right">

                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            Profile
                        </a>

                        <a class="dropdown-item" href="#">
                            Settings
                        </a>

                        <div class="dropdown-divider"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item">
                                Log Out
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>
    </header>