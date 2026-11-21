<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ asset('logo.jpg') }}">
  <title>@hasSection('title')@yield('title') · @endif{{ __('Pusat Tuisyen Think Bright') }}</title>
  {{-- Apply the saved theme before paint so dark mode does not flash white. --}}
  <script>
    (function () {
      var theme = 'light';
      try { theme = localStorage.getItem('tb-theme') || 'light'; } catch (e) {}
      document.documentElement.setAttribute('data-theme', theme);
    })();
  </script>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/nucleo-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('css/nucleo-svg.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="{{ asset('css/soft-ui-dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/thinkbright.css') }}?v={{ filemtime(public_path('css/thinkbright.css')) }}">
  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
  @stack('styles')
</head>

<body class="g-sidenav-show bg-gray-100">
  @include('layouts.partials.sidebar')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    @include('layouts.partials.topbar')

    <div class="container-fluid py-4">
      @include('layouts.flash-message')
      @yield('body')
    </div>
  </main>

  <script src="{{ asset('js/core/popper.min.js') }}"></script>
  <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
  <script src="{{ asset('js/select2.min.js') }}"></script>
  <script src="{{ asset('js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>
  <script>
    // Light / dark toggle
    document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        try { localStorage.setItem('tb-theme', next); } catch (e) {}
      });
    });
    // Ask before following any link or submitting any form marked data-confirm
    document.addEventListener('click', function (e) {
      var el = e.target.closest('[data-confirm]');
      if (el && el.tagName !== 'FORM' && !confirm(el.getAttribute('data-confirm'))) { e.preventDefault(); }
    });
    document.addEventListener('submit', function (e) {
      var form = e.target;
      if (form.hasAttribute('data-confirm') && !confirm(form.getAttribute('data-confirm'))) { e.preventDefault(); }
    });
    if (navigator.platform.indexOf('Win') > -1 && document.querySelector('#sidenav-scrollbar')) {
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
    }
  </script>
  @yield('scripts')
  @stack('scripts')
</body>

</html>
