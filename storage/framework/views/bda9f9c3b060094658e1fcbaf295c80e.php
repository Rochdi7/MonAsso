<!DOCTYPE html>
<html lang="en">

<head>
    <title>MonAsso — Your Association's Digital Headquarters</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="MonAsso: The all-in-one SaaS platform to manage members, meetings, events, and finances for associations.">
    <meta name="author" content="MonAsso">

    <!-- [Favicon] icon -->
    <link rel="icon" href="<?php echo e(URL::asset('build/images/favicon.svg')); ?>" type="image/x-icon" />
    <!-- [Page specific CSS] start -->
    <link href="<?php echo e(URL::asset('build/css/plugins/animate.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(URL::asset('build/css/plugins/swiper-bundle.css')); ?>" rel="stylesheet">
    <!-- [Page specific CSS] end -->
    <!-- [Google Font : Public Sans] icon -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/fonts/phosphor/duotone/style.css')); ?>" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/fonts/tabler-icons.min.css')); ?>">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/fonts/feather.css')); ?>">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/fonts/fontawesome.css')); ?>">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/fonts/material.css')); ?>">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/style.css')); ?>" id="main-style-link">
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/style-preset.css')); ?>">
    <script src="<?php echo e(URL::asset('build//js/tech-stack.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/landing.css')); ?>">
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light"
    class="landing-page">
    <!-- [ Main Content ] start -->
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Header ] start -->
    <header id="home">
        <!-- [ Nav ] start -->
        <?php echo $__env->make('layouts.component-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- [ Nav ] end -->

        <!-- [ Home ] start -->
        <!-- [ Home ] start -->
        <div class="container-fluid">
            <div class="bg-dark mx-sm-3 home-section home-section-2">
                <img src="<?php echo e(URL::asset('build/images/landing/img-header-bg.svg')); ?>" alt="background shape"
                    class="img-fluid img-header-bg">
                <div class="swiper language-slides-hero">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="row align-items-center justify-content-center text-center">
                                <div class="col-sm-12 header-content">
                                    <span class="header-badge text-white">
                                        <i class="ph-duotone ph-medal text-warning me-2"></i>
                                        Empower Your Association with Our SaaS Solution
                                    </span>
                                    <div class="row justify-content-center text-center">
                                        <div class="col-xl-7 col-lg-8 col-md-9 col-sm-10 col-11">
                                            <h1 class="my-3 wow animate__fadeInUp text-white" data-wow-delay="0.4s">
                                                Manage Your Association Effortlessly with MonAsso</h1>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center text-center">
                                        <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-8 col-sm-10 col-11">
                                            <p class="f-16 mb-3 wow animate__fadeInUp" data-wow-delay="0.6s">
                                                A complete solution for managing memberships, events, donations, and
                                                more—all in one platform. Simplify your association's operations today.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="wow animate__fadeInUp" data-wow-delay="0.8s">
                                        <!-- Replace Live Preview button with Sign Up button -->
                                        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary me-3">
                                            Sign Up Now <i class="ph-duotone ph-arrow-square-out"></i>
                                        </a>

                                        <a href="#why" class="btn btn-outline-light" target="_blank">
                                            Learn More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-sm-10">
                                <div class="img-header-main">
                                    <img src="<?php echo e(asset('assets/images/dashboard.PNG')); ?>" alt="img"
                                        class="img-fluid">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- [ Home ] end -->
    </header>
    <!-- [ Header ] End -->

    <!-- [ Features ] start -->
    <section id="features" class="bg-white product-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xl-10">
                    <h2 class="wow animate__fadeInUp section-title mb-0" data-wow-delay="0.2s">Key Features</h2>
                </div>
                <div class="col-md-8 col-xl-6">
                    <p class="text-opacity-75 mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp" data-wow-delay="0.4s">
                        MonAsso empowers your nonprofit with role-based dashboards, document sharing, and full
                        association management—designed for teams of all sizes.
                    </p>
                </div>
            </div>
            <div class="row justify-content-center product-cards-block">
                <div class="col-xl-10">
                    <div class="row justify-content-center text-center gy-sm-4 gy-3">
                        <?php
                            $features = [
                                ['icon' => 'ph-buildings', 'label' => 'Association Management'],
                                ['icon' => 'ph-users-three', 'label' => 'Member & Role Control'],
                                ['icon' => 'ph-receipt', 'label' => 'Cotisations Tracking'],
                                ['icon' => 'ph-calendar-check', 'label' => 'Events & Meetings'],
                                ['icon' => 'ph-wallet', 'label' => 'Contributions & Expenses'],
                                ['icon' => 'ph-lock-key', 'label' => 'Permission System'],
                                ['icon' => 'ph-chart-line-up', 'label' => 'Analytics Dashboard'],
                                ['icon' => 'ph-users-four', 'label' => 'Role-Based Dashboards'],
                                ['icon' => 'ph-user-gear', 'label' => 'Admin & Board Tools'],
                                ['icon' => 'ph-user-focus', 'label' => 'Supervisor Area'],
                                ['icon' => 'ph-user', 'label' => 'Member Zone'],
                                ['icon' => 'ph-files', 'label' => 'Document Sharing'],
                            ];
                        ?>

                        <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-xl-2 col-md-3 col-6">
                                <div class="card wow animate__fadeInUp h-100" data-wow-delay="0.<?php echo e(5 + $i); ?>s">
                                    <div
                                        class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                        <i class="ph-duotone <?php echo e($feature['icon']); ?> text-primary f-36 mb-2"></i>
                                        <h6 class="mb-0 feature-title"><?php echo e($feature['label']); ?></h6>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>
            </div>
        </div>

        <style>
            .product-cards-block .card {
                min-height: 160px;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
                padding: 0.75rem;
            }

            .feature-title {
                font-size: 0.875rem;
                line-height: 1.2rem;
                margin-top: 0.5rem;
                min-height: 2.4rem;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            @media (max-width: 768px) {
                .feature-title {
                    min-height: auto;
                    font-size: 0.82rem;
                    line-height: 1.1rem;
                }
            }
        </style>
    </section>

    <!-- [ Features ] end -->

    <!-- [ Pricing ] start -->
    <section id="pricing" class="bg-dark">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-8 col-xl-6">
                    <h2 class="text-white wow animate__fadeInUp section-title" data-wow-delay="0.2s">Simple,
                        Transparent Pricing</h2>
                    <p class="text-white text-opacity-75 mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp"
                        data-wow-delay="0.4s">
                        Choose the plan that's right for your association. All plans come with a 14-day free trial. No
                        credit card required.
                    </p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <!-- Free Plan -->
                <div class="col-md-6 col-xl-4">
                    <div class="price-card wow animate__fadeInUp" data-wow-delay="0.4s">
                        <h3 class="h4 f-w-400 mb-0 text-white text-opacity-75">Free Trial</h3>
                        <span class="price text-white">Coming Soon</span>
                        <ul class="list-unstyled text-start text-white text-opacity-50">
                            <li class="my-2"><i class="me-1 ti ti-check text-success"></i> 14-day Free Access</li>
                            <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Limited Feature Access
                            </li>
                            <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Up to 25 members</li>
                            <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Community Support</li>
                        </ul>
                        <div class="d-grid">
                            <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-light">Start Your Trial</a>
                        </div>
                    </div>
                </div>

                <!-- Pro Plan -->
                <div class="col-md-6 col-xl-4">
                    <div class="price-card wow animate__fadeInUp" data-wow-delay="0.2s">
                        <div class="price-label text-white bg-primary">Popular</div>
                        <h3 class="h4 f-w-400 mb-0 text-white text-opacity-75">Pro Plan</h3>
                        <span class="price text-white">Coming Soon</span>
                        <ul class="list-unstyled text-start text-white text-opacity-50">
                            <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Full Feature Access</li>
                            <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Unlimited Members &
                                Events</li>
                            <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Advanced Statistics &
                                Reporting</li>
                            <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Email Support</li>
                        </ul>
                        <div class="d-grid">
                            <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Choose Pro</a>
                        </div>
                    </div>
                </div>

                <!-- Enterprise Plan -->
                <div class="col-md-6 col-xl-4">
                    <div class="price-card wow animate__fadeInUp" data-wow-delay="0.6s">
                        <h3 class="h4 f-w-400 mb-0 text-white text-opacity-75">Enterprise</h3>
                        <span class="price text-white">Coming Soon</span>
                        <ul class="list-unstyled text-start text-white text-opacity-50">
                            <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Everything in Pro, plus:
                            </li>
                            <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Custom Integrations & API
                                Access</li>
                            <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Dedicated Account Manager
                            </li>
                            <li class="my-2"><i class="me-1 ti ti-check text-success"></i> Priority Onboarding &
                                Support</li>
                        </ul>
                        <div class="d-grid">
                            <a href="#contact" class="btn btn-outline-light">Contact Sales</a>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- [ Pricing ] end -->

    <!-- [ Why ] start -->
    <section class="bg-white feature-section" id="why">
        <div class="container title mb-0">
            <div class="row justify-content-center text-center wow animate__fadeInUp" data-wow-delay="0.2s">
                <div class="col-md-8 col-xl-6">
                    <h2 class="mb-0 wow animate__fadeInUp section-title" data-wow-delay="0.1s">Why Choose Us?</h2>
                    <p class="mt-lg-4 mt-2 mb-4 mb-md-5 wow animate__fadeInUp" data-wow-delay="0.2s">
                        MonAsso is the go-to platform for modern associations. We combine simplicity, power, and
                        purpose—so your team can focus on making impact, not managing chaos.
                    </p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row g-3">
                <!-- Feature 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-none wow animate__fadeInUp mb-0" data-wow-delay="0.1s">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="avtar bg-light-primary flex-shrink-0">
                                    <i class="ph-duotone ph-target f-24"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>Tailored for Associations</h5>
                                    <p class="mb-0">Every module is designed to match real-world needs of nonprofit
                                        organizations, from member tracking to event planning.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-none wow animate__fadeInUp mb-0" data-wow-delay="0.2s">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="avtar bg-light-primary flex-shrink-0">
                                    <i class="ph-duotone ph-shield-check f-24"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>Secure & Scalable</h5>
                                    <p class="mb-0">Your data is protected with strong encryption and hosted
                                        securely—ready to support you as your team grows.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-none wow animate__fadeInUp mb-0" data-wow-delay="0.3s">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="avtar bg-light-primary flex-shrink-0">
                                    <i class="ph-duotone ph-package f-24"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>One Platform. All Tools.</h5>
                                    <p class="mb-0">No more switching between apps. Handle members, meetings,
                                        documents, and finances from one powerful dashboard.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- [ Why ] end -->

    <!-- [ Contact / CTA ] start -->
    <section id="contact" class="bg-white pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-dark counter-block mb-0 wow animate__fadeInUp" data-wow-delay="0.7s">
                        <img src="<?php echo e(URL::asset('build/images/landing/img-counter-bg.svg')); ?>" alt="img"
                            class="img-fluid img-counter-bg">
                        <div class="card-body p-4 p-md-5">
                            <div class="row align-items-center">
                                <div class="col-lg-8 my-3 text-center text-lg-start">
                                    <span class="h1 text-white mb-3 d-block">Your Association, Digitized.</span>
                                    <p class="mb-0 text-white text-opacity-75">
                                        Say goodbye to spreadsheets and manual tracking. Join MonAsso and manage
                                        members, meetings, and finances—all in one place.
                                    </p>
                                </div>
                                <div class="col-lg-4 my-3 text-center text-lg-end">
                                    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Create Your Account</a>
                                    <p class="text-white text-opacity-50 mt-3 mb-0">
                                        Need help? <a class="link-light"
                                            href="mailto:support@assocmanage.com">support@assocmanage.com</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- [ Contact / CTA ] end -->
    <!-- [ footer apps ] start -->
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-md-4 wow animate__fadeInUp" data-wow-delay="0.2s">
                        <img src="<?php echo e(asset('assets/images/logo/monasso.png')); ?>" alt="image"
                            class="img-fluid mb-3">

                        <p class="mb-0 mt-3">The all-in-one digital headquarters for modern associations. Built to
                            empower your mission and simplify your management processes.</p>
                    </div>
                    <div class="col-md-8">
                        <div class="row gy-4">
                            <div class="col-sm-4 wow animate__fadeInUp" data-wow-delay="0.6s">
                                <h5 class="mb-sm-4 mb-2">Quick Links</h5>
                                <ul class="list-unstyled footer-link mb-0">
                                    <li><a href="#home">Home</a></li>
                                    <li><a href="#features">Features</a></li>
                                    <li><a href="#pricing">Pricing</a></li>
                                    <li><a href="#contact">Contact</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-4 wow animate__fadeInUp" data-wow-delay="0.8s">
                                <h5 class="mb-sm-4 mb-2">Get Started</h5>
                                <ul class="list-unstyled footer-link mb-0">
                                    <li><a href="<?php echo e(route('login')); ?>" target="_blank">Login</a></li>
                                    <li><a href="<?php echo e(route('register')); ?>" target="_blank">Register</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-4 wow animate__fadeInUp" data-wow-delay="1s">
                                <h5 class="mb-sm-4 mb-2">Follow Us</h5>
                                <ul class="list-inline footer-sos-link mb-0">
                                    <li class="list-inline-item wow animate__fadeInUp" data-wow-delay="0.4s">
                                        <a href="https://twitter.com"><i
                                                class="ph-duotone ph-twitter-logo f-20"></i></a>
                                    </li>
                                    <li class="list-inline-item wow animate__fadeInUp" data-wow-delay="0.5s">
                                        <a href="https://facebook.com"><i
                                                class="ph-duotone ph-facebook-logo f-20"></i></a>
                                    </li>
                                    <li class="list-inline-item wow animate__fadeInUp" data-wow-delay="0.6s">
                                        <a href="https://linkedin.com"><i
                                                class="ph-duotone ph-linkedin-logo f-20"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col my-1 wow animate__fadeInUp" data-wow-delay="0.4s">
                        <p class="m-0">© <?php echo e(date('Y')); ?> MonAsso. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- [ footer apps ] End -->

    <!-- Required Js -->
    <script src="<?php echo e(URL::asset('build/js/plugins/popper.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/plugins/simplebar.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/plugins/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/plugins/feather.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/icon/custom-font.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/script.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/theme.js')); ?>"></script>
    <!-- [Page Specific JS] start -->
    <script src="<?php echo e(URL::asset('build/js/plugins/wow.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/plugins/swiper-bundle.js')); ?>"></script>
    <script>
        // scroll-behavior is required for smooth scroll from anchor links
        document.documentElement.style.scrollBehavior = 'smooth';

        layout_change('light');
        layout_sidebar_change('false');
        change_box_container('false');
        layout_caption_change('true');
        layout_rtl_change('false');
        preset_change("preset-1");

        // Start [ Menu hide/show on scroll ]
        let ost = 0;
        document.addEventListener('scroll', function() {
            let cOst = document.documentElement.scrollTop;
            if (cOst == 0) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
            } else if (cOst > ost) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
                document.querySelector('.navbar').classList.remove('default');
            } else {
                document.querySelector('.navbar').classList.add('default');
                document.querySelector('.navbar').classList.remove('top-nav-collapse');
            }
            ost = cOst;
        });
        // End [ Menu hide/show on scroll ]
        var wow = new WOW({
            animateClass: 'animate__animated'
        });
        wow.init();

        // slider start
        const price_Swiper = new Swiper('.price-slides', {
            loop: true,
            slidesPerView: '1',
            centeredSlides: true,
            spaceBetween: 20,
            navigation: {
                prevEl: '.customPrev-btn',
                nextEl: '.customNext-btn'
            },
        });

        const why_Swiper = new Swiper('.why-slides', {
            loop: true,
            slidesPerView: '3.5',
            centeredSlides: true,
            spaceBetween: 20,
            autoplay: {
                delay: 2500,
            },
            navigation: {
                prevEl: '.slidePrev-btn',
                nextEl: '.slideNext-btn'
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.2,
                    spaceBetween: 10,
                },
                592: {
                    slidesPerView: 1.8,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 2.5,
                    spaceBetween: 20,
                },
                1200: {
                    slidesPerView: '3.5',
                    spaceBetween: 20,
                },
            },
        });
        const swiper = new Swiper(".comminuties-slides", {
            loop: true,
            centeredSlides: false,
            autoplay: {
                delay: 2000,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                1200: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
            },
        });
        const langugae_swiper = new Swiper(".language-slides", {
            slidesPerView: 8,
            spaceBetween: 20,
            loop: true,
            speed: 1000,
            direction: 'horizontal',
            centeredSlides: true,
            autoplay: {
                delay: 2000,
            },
            breakpoints: {
                0: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                520: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                720: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
                900: {
                    slidesPerView: 5,
                    spaceBetween: 10,
                },
                1100: {
                    slidesPerView: 6,
                    spaceBetween: 10,
                },
                1280: {
                    slidesPerView: 7,
                    spaceBetween: 20,
                },
                1400: {
                    slidesPerView: 8,
                    spaceBetween: 20,
                },
            },
        });

        const langugae_swiper_hero = new Swiper(".language-slides-hero", {
            slidesPerView: 8,
            speed: 1000,
            slidesPerView: 1,
            autoplay: {
                delay: 4000, // slowing down the hero slider for better readability
            },
            thumbs: {
                swiper: langugae_swiper,
            },
        });
    </script>
    <!-- [Page Specific JS] end -->
</body>

</html>
<?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views/index.blade.php ENDPATH**/ ?>