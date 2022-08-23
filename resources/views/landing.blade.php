<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ config('app.name', 'AyuboHealth') }} | We care about you</title>

    <!-- Favicons -->
    <link href="{{ asset('img/favicon.svg') }}" rel="icon">

    <!-- Thumbnail -->

    <meta property="og:title" content="{{ config('app.name', 'AyuboHealth') }} | We care about you">
    <!-- <meta property="og:description" content=""> -->
    <meta property="og:image" content="{{ asset('img/thumbail.jpg') }}">
    <meta property="og:url" content="https://ayubohealth.com/">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link href="{{ asset('landing-page/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing-page/boxicons/css/boxicons.min.css') }}" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('landing-page/homeStyles.css') }}" rel="stylesheet">
    <style>
    #hero {
        width: 100%;
        height: 90vh;
        background: url("{{ asset('img/home/hero-bg.jpg') }}") top center;
        background-size: cover;
        position: relative;
        margin-bottom: -200px;
    }

    .about .video-box {
        background: url("{{ asset('img/home/about.jpg') }}") center center no-repeat;
        background-size: cover;
        min-height: 500px;
    }

    .margin-zero {
        margin: 0 !important;
    }

    .info {
        justify-content: center !important;
        display: flex !important;
    }

    .info-department {
        display: flex !important;
        flex-direction: column !important;
        align-items: baseline !important;
    }

    .address,
    .email,
    .phone {
        margin-top: 20px !important;
    }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">

            <!-- <h1 class="logo mr-auto"><a href="index.html">AyuboHealth</a></h1> -->
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="" class="logo mr-auto"><img src="{{ asset('img/logo-s.svg') }}" alt="" class="img-fluid"></a>

            <nav class="nav-menu d-none d-lg-block">
                <ul>
                    <li class="active"><a href="">Home</a></li>
                    <!-- <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li> -->
                    <li><a href="#contact">Contact</a></li>
                    <!-- <li><a href="{{route('hospital.login', ['hospital' => 'asiri'])}}">Asiri</a></li>
                    <li><a href="{{route('hospital.login', ['hospital' => 'hemas'])}}">Hemas</a></li> -->
                </ul>
            </nav><!-- .nav-menu -->

            <!-- <a href="#appointment" class="appointment-btn scrollto">Make an Appointment</a> -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container">
            <h1>Welcome to AyuboHealth</h1>
            <h2>We are a team of talented professionals helping to connect the dots in the healthcare environment.</h2>
            <!-- <a href="#about" class="btn-get-started scrollto">Get Started</a> -->
        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= Why Us Section ======= -->
        <section id="why-us" class="why-us">
            <div class="container">

                <div class="row">
                    <div class="col-lg-4 d-flex align-items-stretch">
                        <div class="content">
                            <h3>What is AyuboHealth?</h3>
                            <p>
                                It is a cloud based Health Care System for Small and Medium sized hospitals. It comes
                                with a number of modules where you can manage Labs, OPD, Channelling and Pharmacy.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="icon-boxes d-flex flex-column justify-content-center">
                            <div class="row">
                                <div class="col-xl-4 d-flex align-items-stretch">
                                    <div class="icon-box mt-4 mt-xl-0">
                                        <i class="bx bx-receipt"></i>
                                        <h4>OPD Management</h4>
                                        <p>OPD management with invoicing has never been so easy.</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 d-flex align-items-stretch">
                                    <div class="icon-box mt-4 mt-xl-0">
                                        <i class="bx bx-calendar-plus"></i>
                                        <h4>Channelling Management</h4>
                                        <p>Making appointments, Managing Channeling sessions and doctors are now handled
                                            by AyuboHealth.</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 d-flex align-items-stretch">
                                    <div class="icon-box mt-4 mt-xl-0">
                                        <i class="bx bx-book"></i>
                                        <h4>Lab Management</h4>
                                        <p>Lab tests are critical and very important. Our system is capable of handling
                                            lab reports accurately.</p>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End .content-->
                    </div>
                </div>

            </div>
        </section><!-- End Why Us Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container">

                <div class="section-title">
                    <h2>Contact</h2>
                    <p>Please get in touch with us, we will get back to you in no time.</p>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="info">
                            <div class="info-department">
                                <!-- <div class="address  margin-zero">
                                    <div class="d-flex justify-content-center">
                                        <div>
                                            <i class="icofont-google-map"></i>
                                            <h4>Location:</h4>
                                            <p>Extrogene Software (Pvt) Ltd. 18/1, Sri Nagavihara Road, Pita Kotte, Sri
                                                Lanka
                                            </p>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="email  margin-zero">
                                    <div class="d-flex justify-content-center">
                                        <div>
                                            <i class="icofont-envelope"></i>
                                            <h4>Email:</h4>
                                            <p>support@ayubohealth.lk</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="phone  margin-zero">
                                    <div class="d-flex justify-content-center">
                                        <div>
                                            <i class="icofont-phone"></i>
                                            <h4>Call:</h4>
                                            <p><a style="color: #4b7dab;" href="tel:+94713462146">071 346 2146</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row justify-content-center">
                    <h3 class="footer-quote">Your Health is Our Priority</h3>
                </div>
            </div>
        </div>

        <div class="container d-md-flex py-4">

            <div class="text-center w-100 justify-content-center">
                <div class="copyright">
                    &copy; Copyright <strong><span>AyuboHealth</span></strong>. All Rights Reserved
                </div>
                <!-- <div class="credits">
                    Powered by <a href="https://extrogene.com/">Extrogene</a>
                </div> -->
            </div>
            <!-- <div class="social-links text-center text-md-right pt-3 pt-md-0">
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
            </div> -->
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <!-- <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a> -->

    <!-- JS Files -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"
        integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ=="
        crossorigin="anonymous"></script>
    <!-- Template Main JS File -->
    <script>
    !(function($) {
        "use strict";

        // Preloader
        $(window).on("load", function() {
            if ($("#preloader").length) {
                $("#preloader")
                    .delay(100)
                    .fadeOut("slow", function() {
                        $(this).remove();
                    });
            }
        });


        // Smooth scroll for the navigation menu and links with .scrollto classes
        var scrolltoOffset = $("#header").outerHeight() - 1;
        $(document).on("click", ".nav-menu a, .mobile-nav a, .scrollto", function(
            e
        ) {
            if (
                location.pathname.replace(/^\//, "") ==
                this.pathname.replace(/^\//, "") &&
                location.hostname == this.hostname
            ) {
                var target = $(this.hash);
                if (target.length) {
                    e.preventDefault();

                    var scrollto = target.offset().top - scrolltoOffset;

                    if ($(this).attr("href") == "#header") {
                        scrollto = 0;
                    }

                    $("html, body").animate({
                            scrollTop: scrollto,
                        },
                        1500,
                        "easeInOutExpo"
                    );

                    if ($(this).parents(".nav-menu, .mobile-nav").length) {
                        $(".nav-menu .active, .mobile-nav .active").removeClass("active");
                        $(this).closest("li").addClass("active");
                    }

                    if ($("body").hasClass("mobile-nav-active")) {
                        $("body").removeClass("mobile-nav-active");
                        $(".mobile-nav-toggle i").toggleClass(
                            "icofont-navigation-menu icofont-close"
                        );
                        $(".mobile-nav-overly").fadeOut();
                    }
                    return false;
                }
            }
        });

        // Activate smooth scroll on page load with hash links in the url
        $(document).ready(function() {
            if (window.location.hash) {
                var initial_nav = window.location.hash;
                if ($(initial_nav).length) {
                    var scrollto = $(initial_nav).offset().top - scrolltoOffset;
                    $("html, body").animate({
                            scrollTop: scrollto,
                        },
                        1500,
                        "easeInOutExpo"
                    );
                }
            }
        });

        // Navigation active state on scroll
        var nav_sections = $("section");
        var main_nav = $(".nav-menu, .mobile-nav");

        $(window).on("scroll", function() {
            var cur_pos = $(this).scrollTop() + 200;

            nav_sections.each(function() {
                var top = $(this).offset().top,
                    bottom = top + $(this).outerHeight();

                if (cur_pos >= top && cur_pos <= bottom) {
                    if (cur_pos <= bottom) {
                        main_nav.find("li").removeClass("active");
                    }
                    main_nav
                        .find('a[href="#' + $(this).attr("id") + '"]')
                        .parent("li")
                        .addClass("active");
                }
                if (cur_pos < 300) {
                    $(
                        ".nav-menu ul:first li:first, .mobile-nav ul:first li:first"
                    ).addClass("active");
                }
            });
        });

        // Mobile Navigation
        // if ($(".nav-menu").length) {
        //     var $mobile_nav = $(".nav-menu").clone().prop({
        //         class: "mobile-nav d-lg-none",
        //     });
        //     $("body").append($mobile_nav);
        //     $("body").prepend(
        //         '<button type="button" class="mobile-nav-toggle d-lg-none"><i class="icofont-navigation-menu"></i></button>'
        //     );
        //     $("body").append('<div class="mobile-nav-overly"></div>');

        //     $(document).on("click", ".mobile-nav-toggle", function(e) {
        //         $("body").toggleClass("mobile-nav-active");
        //         $(".mobile-nav-toggle i").toggleClass(
        //             "icofont-navigation-menu icofont-close"
        //         );
        //         $(".mobile-nav-overly").toggle();
        //     });

        //     $(document).on("click", ".mobile-nav .drop-down > a", function(e) {
        //         e.preventDefault();
        //         $(this).next().slideToggle(300);
        //         $(this).parent().toggleClass("active");
        //     });

        //     $(document).click(function(e) {
        //         var container = $(".mobile-nav, .mobile-nav-toggle");
        //         if (!container.is(e.target) && container.has(e.target).length === 0) {
        //             if ($("body").hasClass("mobile-nav-active")) {
        //                 $("body").removeClass("mobile-nav-active");
        //                 $(".mobile-nav-toggle i").toggleClass(
        //                     "icofont-navigation-menu icofont-close"
        //                 );
        //                 $(".mobile-nav-overly").fadeOut();
        //             }
        //         }
        //     });
        // } else if ($(".mobile-nav, .mobile-nav-toggle").length) {
        //     $(".mobile-nav, .mobile-nav-toggle").hide();
        // }
        // Toggle .header-scrolled class to #header when page is scrolled
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $("#header").addClass("header-scrolled");
                $("#topbar").addClass("topbar-scrolled");
            } else {
                $("#header").removeClass("header-scrolled");
                $("#topbar").removeClass("topbar-scrolled");
            }
        });

        if ($(window).scrollTop() > 100) {
            $("#header").addClass("header-scrolled");
            $("#topbar").addClass("topbar-scrolled");
        }
    })(jQuery);
    </script>

</body>

</html>