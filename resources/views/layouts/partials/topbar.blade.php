@php
  $user = auth()->user();
  $unread = $user->unreadNotifications()->latest()->take(5)->get();
  $unreadCount = $user->unreadNotifications()->count();
  $locales = \App\Http\Middleware\SetLocale::LOCALES;
@endphp

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl tb-topbar" id="navbarBlur" navbar-scroll="true">
  <div class="container-fluid py-1 px-3">
    <div>
      <h6 class="font-weight-bolder mb-0">@yield('title', __('Pusat Tuisyen Think Bright'))</h6>
    </div>

    <ul class="navbar-nav ms-auto flex-row align-items-center gap-3">
      {{-- Mobile sidebar toggle --}}
      <li class="nav-item d-xl-none d-flex align-items-center">
        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav" aria-label="{{ __('Menu') }}">
          <div class="sidenav-toggler-inner">
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
          </div>
        </a>
      </li>

      {{-- Notifications --}}
      <li class="nav-item dropdown d-flex align-items-center">
        <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('Notifications') }}">
          <i class="fa-solid fa-bell fa-lg"></i>
          @if ($unreadCount)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger tb-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
          @endif
        </a>
        <ul class="dropdown-menu dropdown-menu-end px-2 py-2 me-sm-n2 tb-notif-menu" aria-labelledby="notifDropdown">
          <li class="d-flex justify-content-between align-items-center px-2 pb-2">
            <span class="text-sm font-weight-bold">{{ __('Notifications') }}</span>
            @if ($unreadCount)
              <form method="POST" action="{{ route('notifications.read_all') }}">
                @csrf
                <button type="submit" class="btn btn-link btn-sm p-0 m-0 text-xs">{{ __('Mark all read') }}</button>
              </form>
            @endif
          </li>
          @forelse ($unread as $n)
            <li>
              <a class="dropdown-item border-radius-md py-2" href="{{ route('notifications.open', $n->id) }}">
                <div class="d-flex flex-column">
                  <span class="text-sm">{{ $n->data['message'] ?? __('Notification') }}</span>
                  <span class="text-xs text-secondary"><i class="fa-regular fa-clock me-1"></i>{{ $n->created_at->diffForHumans() }}</span>
                </div>
              </a>
            </li>
          @empty
            <li class="px-2 py-2 text-sm text-secondary">{{ __('No new notifications') }}</li>
          @endforelse
          <li><hr class="dropdown-divider my-1"></li>
          <li><a class="dropdown-item border-radius-md text-center text-sm" href="{{ route('notifications.index') }}">{{ __('View all') }}</a></li>
        </ul>
      </li>

      {{-- Language --}}
      <li class="nav-item dropdown d-flex align-items-center">
        <a href="javascript:;" class="nav-link text-body p-0" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('Language') }}">
          <i class="fa-solid fa-globe fa-lg"></i>
          <span class="d-none d-md-inline text-sm ms-1">{{ $locales[app()->getLocale()] ?? 'English' }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end px-2 py-2" aria-labelledby="langDropdown">
          @foreach ($locales as $code => $label)
            <li>
              <a class="dropdown-item border-radius-md {{ app()->getLocale() === $code ? 'active' : '' }}" href="{{ route('locale.switch', $code) }}">{{ $label }}</a>
            </li>
          @endforeach
        </ul>
      </li>

      {{-- Light / dark --}}
      <li class="nav-item d-flex align-items-center">
        <button type="button" class="btn btn-link nav-link text-body p-0 m-0" data-theme-toggle aria-label="{{ __('Toggle light/dark mode') }}">
          <i class="fa-solid fa-moon fa-lg tb-icon-dark"></i>
          <i class="fa-solid fa-sun fa-lg tb-icon-light"></i>
        </button>
      </li>

      {{-- User --}}
      <li class="nav-item dropdown d-flex align-items-center">
        <a href="javascript:;" class="nav-link text-body p-0 d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="avatar avatar-sm bg-gradient-primary rounded-circle me-2">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
          <span class="d-none d-md-inline text-sm font-weight-bold">{{ $user->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end px-2 py-2" aria-labelledby="userDropdown">
          <li class="px-2 pb-2 text-xs text-secondary">{{ $user->username }} · {{ __(ucfirst($user->role ?? 'user')) }}</li>
          <li><a class="dropdown-item border-radius-md" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user me-2"></i>{{ __('Profile') }}</a></li>
          <li><a class="dropdown-item border-radius-md" href="{{ route('user.change_password') }}"><i class="fa-solid fa-lock me-2"></i>{{ __('Change Password') }}</a></li>
          <li><hr class="dropdown-divider my-1"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item border-radius-md text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>{{ __('Log Out') }}</button>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
