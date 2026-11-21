@php
  /*
   * Sidebar menu. Each item: label, icon, route (or children), pattern (routeIs patterns
   * for the active state), admin (true = admins only, false = teachers only, null = everyone),
   * badge (optional count). Items whose route is not defined are skipped.
   */
  $user = auth()->user();
  $pendingLeave = ($user->isAdmin() && \Illuminate\Support\Facades\Schema::hasTable('leave_applications'))
      ? \App\Models\LeaveApplication::where('status', 'pending')->count()
      : 0;

  $menu = [
    ['label' => 'Dashboard', 'icon' => 'fa-house', 'route' => 'dashboard', 'pattern' => ['dashboard']],

    // Teacher menu
    ['label' => 'My 1-to-1 Classes', 'icon' => 'fa-chalkboard-user', 'route' => 'my_classes.index', 'pattern' => ['my_classes.*'], 'admin' => false],
    ['label' => 'Daycare Timetable', 'icon' => 'fa-calendar-week', 'route' => 'timetable.view', 'pattern' => ['timetable.view'], 'admin' => false],
    ['label' => 'My Leave', 'icon' => 'fa-plane-departure', 'route' => 'my_leave.index', 'pattern' => ['my_leave.*'], 'admin' => false],

    // Admin menu
    ['label' => 'Daycare', 'icon' => 'fa-child-reaching', 'admin' => true, 'children' => [
      ['label' => 'Timetable', 'route' => 'timetable.index', 'pattern' => ['timetable.*']],
      ['label' => 'Enrolments', 'route' => 'enrolment.index', 'pattern' => ['enrolment.*']],
    ]],
    ['label' => '1-to-1 Classes', 'icon' => 'fa-chalkboard-user', 'route' => 'one_to_one.index', 'pattern' => ['one_to_one.*'], 'admin' => true],
    ['label' => 'Billing', 'icon' => 'fa-money-bill', 'admin' => true, 'children' => [
      ['label' => 'Monthly Account', 'route' => 'account_month.index', 'pattern' => ['account_month.*']],
      ['label' => 'Receipt', 'route' => 'receipt.index', 'pattern' => ['receipt.*']],
    ]],
    ['label' => 'Bank Account', 'icon' => 'fa-building-columns', 'route' => 'bank_account.index', 'pattern' => ['bank_account.*'], 'admin' => true],
    ['label' => 'Leave Applications', 'icon' => 'fa-plane-departure', 'route' => 'leave.index', 'pattern' => ['leave.*'], 'admin' => true, 'badge' => $pendingLeave],
    ['label' => 'Salary', 'icon' => 'fa-sack-dollar', 'route' => 'salary.index', 'pattern' => ['salary.*'], 'admin' => true],
    ['label' => 'User Setting', 'icon' => 'fa-users', 'admin' => true, 'children' => [
      ['label' => 'Teachers', 'route' => 'user.index', 'pattern' => ['user.index', 'user.create', 'user.edit']],
      ['label' => 'Students', 'route' => 'student.index', 'pattern' => ['student.*']],
    ]],
    ['label' => 'Master Setting', 'icon' => 'fa-gear', 'admin' => true, 'children' => [
      ['label' => 'School Setting', 'route' => 'school.index', 'pattern' => ['school.*']],
      ['label' => 'Bank Setting', 'route' => 'bank.index', 'pattern' => ['bank.*']],
      ['label' => 'Fee Setting', 'route' => 'fee_setting.edit', 'pattern' => ['fee_setting.*']],
    ]],
  ];

  $visible = function ($item) use ($user) {
      $admin = $item['admin'] ?? null;
      if ($admin === true && ! $user->isAdmin()) return false;
      if ($admin === false && $user->isAdmin()) return false;
      return true;
  };
@endphp

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0 text-center d-block" href="{{ route('dashboard') }}">
      <img src="{{ asset('logo.png') }}" class="navbar-brand-img h-100 full_height" alt="Think Bright">
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      @foreach ($menu as $i => $item)
        @continue(! $visible($item))

        @if (isset($item['children']))
          @php
            $children = array_values(array_filter($item['children'], fn ($c) => \Illuminate\Support\Facades\Route::has($c['route'])));
            $open = collect($children)->contains(fn ($c) => request()->routeIs(...$c['pattern']));
          @endphp
          @continue(empty($children))
          <li class="nav-item">
            <a class="nav-link {{ $open ? 'active' : '' }}" data-bs-toggle="collapse" href="#menu-{{ $i }}" role="button" aria-expanded="{{ $open ? 'true' : 'false' }}" aria-controls="menu-{{ $i }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid {{ $item['icon'] }} text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">{{ __($item['label']) }}</span>

            </a>
            <div class="collapse {{ $open ? 'show' : '' }}" id="menu-{{ $i }}">
              <ul class="nav ms-4 ps-3 tb-submenu">
                @foreach ($children as $child)
                  <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs(...$child['pattern']) ? 'active fw-bold' : '' }}" href="{{ route($child['route']) }}">
                      <span class="sidenav-normal">{{ __($child['label']) }}</span>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </li>
        @else
          @continue(! \Illuminate\Support\Facades\Route::has($item['route']))
          @php $active = request()->routeIs(...$item['pattern']); @endphp
          <li class="nav-item">
            <a class="nav-link {{ $active ? 'active' : '' }}" href="{{ route($item['route']) }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid {{ $item['icon'] }} text-dark"></i>
              </div>
              <span class="nav-link-text ms-1">{{ __($item['label']) }}</span>
              @if (! empty($item['badge']))
                <span class="badge bg-gradient-danger ms-auto">{{ $item['badge'] }}</span>
              @endif
            </a>
          </li>
        @endif
      @endforeach
    </ul>
  </div>
</aside>
