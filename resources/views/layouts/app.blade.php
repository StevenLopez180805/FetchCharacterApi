<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Characters')</title>
    @vite('resources/css/characters/charactersList.css')
    @vite('resources/css/preload.css')
    @stack('styles')
</head>
<body class="min-vh-100" data-bs-theme="dark">
    <div id="preload">
        <div class="circle-loader"></div>
    </div>
    <main class="container-fluid min-vh-100 d-flex flex-column">
        <h1 class="text-center my-2">@yield('subTitle', 'Characters')</h1>
        @yield('content')
    </main>
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column align-items-center">
                @include('modals._detailsModal')
            </div>
          </div>
        </div>
    </div>
    @yield('modals')
    @stack('scripts')
</body>
</html>
