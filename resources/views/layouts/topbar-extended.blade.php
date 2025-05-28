<!-- [ Header Topbar ] start -->
<header class="pc-header">
    <div class="container d-flex">
        <div class="m-header">
            <a href="//index" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ URL::asset('build/images/logo-white.svg') }}" alt="logo image" class="logo-lg" />
                <span class="badge bg-brand-color-2 rounded-pill ms-1 theme-version">v1.2.0</span>
            </a>
        </div>
        <div class="header-wrapper"> @include('layouts.topbar-d')</div>
    </div>
</header>
<!-- [ Header ] end -->
