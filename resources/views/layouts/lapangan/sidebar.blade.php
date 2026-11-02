<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

      <div class="navbar-brand-box d-flex justify-content-center">
    <a href="#" class="logo d-flex align-items-center justify-content-center text-center">
        <img src="{{ asset('auth/images/logo.png') }}" 
             alt="Logo Media Informatika" 
             height="35" 
             class="me-2">
        <span style="font-size: 14px; font-weight: 600; letter-spacing: 0.5px;">Media Informatika</span>
    </a>
</div>

        <!-- Sidebar Menu -->
        <div id="sidebar-menu">

            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title">Menu</li>

                <!-- Dashboard -->
                <li class="{{ request()->routeIs('dashboard') ? 'mm-active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="waves-effect {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="mdi mdi-home-analytics"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
              <li>
                    <a href="{{ route('assets.index') }}" class="waves-effect">
                        <i class="mdi mdi-file-video"></i>
                        <span>Assets</span>
                    </a>
                </li>
            
                <li class="menu-title">More</li>


<li>
                    <a href="{{ route('profile.edit') }}" class="waves-effect">
                        <i class="mdi mdi-account"></i>
                        <span>Profile</span>
                    </a>
                </li>

  <li>
                    <a href="{{ route('assets.index') }}" class="waves-effect">
                        <i class="mdi mdi-settings"></i>
                        <span>Settings</span>
                    </a>
                </li>


               <li>
    <a href="#"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
         <i class="mdi mdi-logout"></i>
                        <span>Log Out</span>
    </a>

    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
        @csrf
    </form>
</li>
            </ul>

        </div>
        <!-- Sidebar Menu End -->

    </div>

</div>
<!-- Left Sidebar End -->



        