@php

$currentRoute = request()->route()->getName();

@endphp
<style>
    .layout-menu .app-brand {
        justify-content: center !important;
        text-align: center !important;
    }

    .layout-menu .app-brand-logo.demo {
        width: 140px !important;
        height: auto !important;
        margin: 0 auto !important;
    }

    .layout-menu .app-brand-logo.demo img {
        width: 100% !important;
        height: auto !important;
        max-width: none !important;
        margin: 0 auto !important;
        display: block !important;
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex flex-column align-items-center" style="padding: 2rem 1rem 1.5rem; min-height: 140px;">
    <a href="{{ route('home') }}" class="app-brand-link d-flex justify-content-center w-100">
        <span class="app-brand-logo demo" style="width: 140px !important; height: auto !important; display: block;">
            <img src="{{ asset('logo.png') }}" 
                 alt="Logo" 
                 style="width: 140px !important; height: auto !important; display: block;" />
        </span>
    </a>
</div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{ Str::contains($currentRoute, 'home') ? 'active' : ''}}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboards</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Account &amp; Info">Account &amp; Info</span>
        </li>
        
        <li class="menu-item {{ Str::contains($currentRoute, 'receipt.index') ? 'active' : ''}}">
            <a href="{{ route('receipt.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Receipt</div>
            </a>
        </li>
        <li class="menu-item {{ Str::contains($currentRoute, 'account_month.index') ? 'active' : ''}}">
            <a href="{{ route('account_month.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Account</div>
            </a>
        </li>
        <li class="menu-item {{ Str::contains($currentRoute, 'student.index') ? 'active' : ''}}">
            <a href="{{ route('student.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Student Details</div>
            </a>
        </li>
        <li class="menu-item {{ Str::contains($currentRoute, 'user.index') ? 'active' : ''}}">
            <a href="{{ route('user.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Teacher Details</div>
            </a>
        </li>
        <li class="menu-item {{ Str::contains($currentRoute, 'school.index') ? 'active' : ''}}">
            <a href="{{ route('school.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>School Setting</div>
            </a>
        </li>
        <li class="menu-item {{ Str::contains($currentRoute, 'bank.index') ? 'active' : ''}}">
            <a href="{{ route('bank.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Bank Setting</div>
            </a>
        </li>
        <li class="menu-item {{ Str::contains($currentRoute, 'bank_account.index') ? 'active' : ''}}">
            <a href="{{ route('bank_account.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Bank Account</div>
            </a>
        </li>
    </ul>
</aside>
<!-- end: sidebar -->