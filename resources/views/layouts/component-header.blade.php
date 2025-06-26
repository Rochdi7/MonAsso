<!-- [ Nav ] start -->
<nav class="navbar navbar-expand-md navbar-light default">
    <div class="container">
        <a class="navbar-brand" href="{{ url('index') }}">
            <img src="{{ asset('assets/images/logo/monasso.png') }}" alt="logo" class="logo-lg landing-logo" />
        </a>
        <button class="navbar-toggler rounded" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <div class="navbar-nav ms-auto mt-lg-0 mt-2 mb-2 mb-lg-0 align-items-start">
                <a class="nav-link px-1" href="{{ url('index') }}">Home</a>
                <a class="nav-link px-1" href="{{ url('features') }}">Features</a>
                <a class="nav-link px-1" href="{{ url('pricing') }}">Pricing</a>
                <a class="nav-link px-1" href="{{ url('contact') }}">Contact</a>
            </div>
            <ul class="navbar-nav mb-2 mb-lg-0 align-items-start">
                <li class="dropdown px-1 me-2 mb-2 mb-md-0">
                    <a class="btn btn-icon btn-outline-dark border border-secondary border-opacity-25 dropdown-toggle arrow-none me-0 rounded"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ph-duotone ph-sun-dim text-warning"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
                            <i class="ph-duotone ph-moon"></i>
                            <span>Dark Mode</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
                            <i class="ph-duotone ph-sun-dim"></i>
                            <span>Light Mode</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change_default()">
                            <i class="ph-duotone ph-cpu"></i>
                            <span>Default Mode</span>
                        </a>
                    </div>
                </li>
                @auth
                    <!-- User is authenticated -->
                    <li class="nav-item">
                        <a href="{{ url('dashboard') }}" class="btn btn-primary">Dashboard <i class="ph-duotone ph-arrow-square-out"></i></a>
                    </li>
                @else
                    <!-- User is not authenticated -->
                    <li class="nav-item">
                        <a href="{{ url('signup') }}" class="btn btn-primary">Sign Up <i class="ph-duotone ph-arrow-square-out"></i></a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<!-- [ Nav ] end -->
