@php

$currentRoute = request()->route()->getName();

@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('logosmall.png') }}" alt="Logo" style="width:100%;" />
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">Data</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
        <li class="menu-item {{ Str::contains($currentRoute, 'home') ? 'active' : ''}}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboards</div>
            </a>
        </li>
        @endif
        @if(Auth::user()->role_id != 4)
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Daily &amp; Cleaning">Daily &amp; Cleaning</span>
        </li>
        @php
            $reportRoute2 = ['daily_cleaning_closing','worker_kpi'];
            $isReportActive2 = collect($reportRoute2)->contains(fn($e) => Str::contains($currentRoute, $e));
        @endphp

        @if(Auth::user()->role_id != 6 && Auth::user()->role_id != 3)
        <li class="menu-item {{ $isReportActive2 ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div>Reports</div>
            </a>

            <ul class="menu-sub">
                @foreach ($reportRoute2 as $ruc)
                    <li class="menu-item {{ Str::contains($currentRoute, $ruc) ? 'active' : '' }}">
                        <a href="{{ route($ruc . '.index') }}" class="menu-link">
                            <div>{{ ucwords(str_replace('_', ' ', $ruc)) }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        @endif
        <li class="menu-item {{ Str::contains($currentRoute, 'daily_cleaning.index') ? 'active' : ''}}">
            <a href="{{ route('daily_cleaning.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Daily Cleaning</div>
            </a>
        </li>
        <li class="menu-item {{ Str::contains($currentRoute, 'extra.index') ? 'active' : ''}}">
            <a href="{{ route('extra.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Cleaning Tool</div>
            </a>
        </li>
        <li class="menu-item {{ Str::contains($currentRoute, 'expense.index') ? 'active' : ''}}">
            <a href="{{ route('expense.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Expenses</div>
            </a>
        </li>
        <li class="menu-item {{ Str::contains($currentRoute, 'customer.index') ? 'active' : ''}}">
            <a href="{{ route('customer.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Customer</div>
            </a>
        </li>
        @if(Auth::user()->role_id !=6)
        @php
            $userRoutes2 = ['driver', 'cleaner'];
            $isUserActive2 = collect($userRoutes2)->contains(fn($r) => Str::contains($currentRoute, $r));
        @endphp

        <li class="menu-item {{ $isUserActive2 ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div>Users</div>
            </a>

            <ul class="menu-sub">
                @foreach ($userRoutes2 as $role2)
                    <li class="menu-item {{ Str::contains($currentRoute, $role2) ? 'active' : '' }}">
                        <a href="{{ route($role2 . '.index') }}" class="menu-link">
                            <div>{{ ucfirst($role2) }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        @endif
        @endif

        @if(Auth::user()->role_id !=6)
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Daily &amp; Activity">Daily &amp; Activity</span>
        </li>
        @php
            $reportRoute = ['sales_report', 'worker_report'];
            $isReportActive = collect($reportRoute)->contains(fn($r) => Str::contains($currentRoute, $r));
        @endphp

        @if(Auth::user()->role_id != 4 && Auth::user()->role_id != 3)
        <li class="menu-item {{ $isReportActive ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div>Reports</div>
            </a>

            <ul class="menu-sub">
                @foreach ($reportRoute as $rec)
                    <li class="menu-item {{ Str::contains($currentRoute, $rec) ? 'active' : '' }}">
                        <a href="{{ route($rec . '.index') }}" class="menu-link">
                            <div>{{ ucwords(str_replace('_', ' ', $rec)) }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        @endif

        <li class="menu-item {{ Str::contains($currentRoute, 'daily_activity.index') ? 'active' : ''}}">
            <a href="{{ route('daily_activity.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Daily Activity ZP</div>
            </a>
        </li>

         @if(Auth::user()->role_id != 4 && Auth::user()->role_id != 3)
        <li class="menu-item {{ Str::contains($currentRoute, 'kod.index') ? 'active' : ''}}">
            <a href="{{ route('kod.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-copy"></i>
                <div>Kod Kerja</div>
            </a>
        </li>
        @endif
        @php
            $userRoutes = ['leader', 'operator'];
            $isUserActive = collect($userRoutes)->contains(fn($r) => Str::contains($currentRoute, $r));
        @endphp

        @if(Auth::user()->role_id != 4)
        <li class="menu-item {{ $isUserActive ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div>Users</div>
            </a>

            <ul class="menu-sub">
                @foreach ($userRoutes as $role)
                    <li class="menu-item {{ Str::contains($currentRoute, $role) ? 'active' : '' }}">
                        <a href="{{ route($role . '.index') }}" class="menu-link">
                            <div>{{ ucfirst($role) }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        @endif
        @endif

        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Master Setting">Master Setting</span>
        </li>

        @php
            $userRoutes3 = ['admin', 'supervisor'];
            $isUserActive3 = collect($userRoutes3)->contains(fn($r) => Str::contains($currentRoute, $r));
        @endphp

        <li class="menu-item {{ $isUserActive3 ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div>Users</div>
            </a>

            <ul class="menu-sub">
                @foreach ($userRoutes3 as $role3)
                    <li class="menu-item {{ Str::contains($currentRoute, $role3) ? 'active' : '' }}">
                        <a href="{{ route($role3 . '.index') }}" class="menu-link">
                            <div>{{ ucfirst($role3) }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="menu-item {{ Str::contains($currentRoute, 'holiday.index') ? 'active' : ''}}">
            <a href="{{ route('holiday.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Public Holiday</div>
            </a>
        </li>
        @endif
    </ul>
</aside>
<!-- end: sidebar -->