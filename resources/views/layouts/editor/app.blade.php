<!DOCTYPE html>
<html lang="en">

  {{-- 1. HEAD --}}
  @include('layouts.editor.head')

  <body>
    <div id="layout-wrapper">

        {{-- 2. SIDEBAR --}}
        @include('layouts.editor.sidebar')

        {{-- 3. NAVBAR --}}
        @include('layouts.editor.navbar')

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
    @include('layouts.editor.scripts')

    @yield('scripts')
  </body>
</html>