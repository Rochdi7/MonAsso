<!doctype html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Layout Extended | Light Able Laravel 11 Admin & Dashboard Template</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Light Able admin and dashboard template offer a variety of UI elements and pages, ensuring your admin panel is both fast and effective." />
    <meta name="author" content="phoenixcoded" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ URL::asset('build/images/favicon.svg') }}" type="image/x-icon">

    @yield('css')

    @include('layouts.head-css')
</head>
<!-- [Head] end -->

<!-- [Body] Start -->

<body class="layout-extended" data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true"
    data-pc-direction="ltr" data-pc-theme="light">
    @include('layouts.loader')
    @include('layouts.topbar-extended')

    <div class="pc-tab-wrapper">
        <div class="pc-tabs">
            <div class="container">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pc-tab-1-tab" data-bs-toggle="tab"
                            data-bs-target="#pc-tab-1-tab-pane" type="button" role="tab"
                            aria-controls="pc-tab-1-tab-pane" aria-selected="true">Navigation</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pc-tab-2-tab" data-bs-toggle="tab"
                            data-bs-target="#pc-tab-2-tab-pane" type="button" role="tab"
                            aria-controls="pc-tab-2-tab-pane" aria-selected="false">Widget</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pc-tab-3-tab" data-bs-toggle="tab"
                            data-bs-target="#pc-tab-3-tab-pane" type="button" role="tab"
                            aria-controls="pc-tab-3-tab-pane" aria-selected="false">Application</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pc-tab-4-tab" data-bs-toggle="tab"
                            data-bs-target="#pc-tab-4-tab-pane" type="button" role="tab"
                            aria-controls="pc-tab-4-tab-pane" aria-selected="false">UI
                            Components</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pc-tab-content">
            <div class="container">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="pc-tab-1-tab-pane" role="tabpanel"
                        aria-labelledby="pc-tab-1-tab" tabindex="0">
                        @include('layouts.submenu-list')
                    </div>
                    <div class="tab-pane fade" id="pc-tab-2-tab-pane" role="tabpanel" aria-labelledby="pc-tab-2-tab"
                        tabindex="0">
                        @include('layouts.submenu-list')
                    </div>
                    <div class="tab-pane fade" id="pc-tab-3-tab-pane" role="tabpanel" aria-labelledby="pc-tab-3-tab"
                        tabindex="0">
                        @include('layouts.submenu-list')
                    </div>
                    <div class="tab-pane fade" id="pc-tab-4-tab-pane" role="tabpanel" aria-labelledby="pc-tab-4-tab"
                        tabindex="0">
                        @include('layouts.submenu-list')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/index">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Layout</a></li>
                                <li class="breadcrumb-item" aria-current="page">Layout Extended</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Layout Extended</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Hello card</h5>
                        </div>
                        <div class="card-body">
                            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna
                                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                aliquip ex ea commodo consequat. Duis
                                aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                pariatur. Excepteur sint occaecat
                                cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                            </p>
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->

    @include('layouts.footer')
    @include('layouts.customizer')
    @include('layouts.footerjs')

    <script>
        change_box_container('true');
    </script>
</body>
<!-- [Body] end -->

</html>
