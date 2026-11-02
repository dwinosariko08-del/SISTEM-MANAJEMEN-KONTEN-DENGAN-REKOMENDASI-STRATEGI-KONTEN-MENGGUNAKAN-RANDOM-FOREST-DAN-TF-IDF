<!DOCTYPE html>
<html lang="en">

  {{-- 1. HEAD --}}
  @include('layouts.leader.head')

  <body>
    <div id="layout-wrapper">

        {{-- 2. SIDEBAR --}}
        @include('layouts.leader.sidebar')

        {{-- 3. NAVBAR --}}
        @include('layouts.leader.navbar')

        <div class="main-content">
          <div class="page-content">
            <div class="container-fluid" style="padding-top: 30px;">
                @include('layouts.alerts')
                @yield('content')
            </div>
          </div>

          {{-- 4. FOOTER --}}

        </div> {{-- Penutup main-content --}}

    </div> {{-- Penutup layout-wrapper --}}

    {{-- 5. SCRIPTS --}}
    @include('layouts.leader.scripts')

  </body>
</html>