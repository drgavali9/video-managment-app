<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Video Managment App</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/app-assets/images/ico/favicon.ico') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400&display=swap"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/themes/semi-dark-layout.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/pages/dashboard-ecommerce.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/pages/card-analytics.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/jodit.css') }}" />
    <!-- END: Page CSS-->

    <!--Datatable CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css/plugins/file-uploaders/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/components.css') }}">
    {{-- <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/vendors/css/tables/datatable/extensions/rowReorder.dataTables.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <!-- END: Datatable CSS-->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/pages/data-list-view.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style.css') }}">
    <!-- END: Custom CSS-->

    <!-- BEGIN: Other CSS-->
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">

    @stack('stylesheets')
    <!-- END: Other CSS-->
    <style>
        .required:after {
            content: " *";
            color: red;
        }

        /* textarea.select2-search__field {
            display: none;
        } */

        .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
            position: absolute;
            will-change: transform;
            top: 0px;
            left: 0px;
            transform: translate3d(0px, 38px, 0px);
        }

        /*
        .top-serch.mr-2 {
            width: 60%;
            float: left;
        }

        .filter {
            width: 40%;
            float: left;
        } */

    </style>

</head>
<!-- END: Head-->
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static   menu-collapsed"
    data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="container">
                <div class="navbar-container content">
                    <div class="navbar-collapse" id="navbar-mobile">
                        <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                            <ul class="nav navbar-nav">
                                <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                        class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                            class="ficon feather icon-menu"></i></a></li>
                            </ul>
                            <a class="navbar-brand" href="#">
                                <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                    src="{{ asset('admin/assets/image/logo-optimize.png') }}" class="logo">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->
    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="#">
                        <div class="brand-text">
                            <div class="brand-img">
                                {{-- <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                    src="{{ auth()->user()->profile_image }}"> --}}
                            </div>
                            <h2 class="mb-0">
                                {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}<span>Admin</span>
                            </h2>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- <div class="shadow-bottom"></div> -->
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                {{-- <li class="nav-item {{ request()->is('admin/dashboard*') ? 'active' : null }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <div class="menu-icon">
                            <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                src="{{ asset('admin/assets/image/dashboard_1.png') }}" class="icon-active">
                            <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                src="{{ asset('admin/assets/image/dashboard.png') }}" class="icon-hover">
                        </div>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li> --}}
                <li class="nav-item {{ request()->is('admin/videos*') ? 'active' : null }}"><a
                        href="{{ route('admin.videos.index') }}">
                        <div class="menu-icon">
                            <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                src="{{ asset('admin/assets/image/banner_1.png') }}" class="icon-active">
                            <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                src="{{ asset('admin/assets/image/banner.png') }}" class="icon-hover">
                        </div>
                        <span class="menu-title">Video</span>
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt nav-icon" aria-hidden="true"></i>
                            <p>Logout</p>
                        </a>
                    </form>
                </li>
                <!-- <li class="nav-item "><a href="auth-login.html"><i class="feather icon-power"></i><span class="menu-title"> Logout</span></a> -->
                <!-- </li> -->
            </ul>
        </div>
    </div>
    <!-- <div class="content"> -->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            @if (session()->has('message') || $errors->any())
                <div class="alert alert-{{ $errors->any() ? 'danger' : 'success' }} alert-dismissible fade show">
                    <strong>{{ ucfirst($errors->any() ? 'error' : 'success') }}</strong>
                    {{ $errors->any() ? $errors->first() : session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

    {{-- MAIN CONTENT --}}
    @yield('content')

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light py-2"> </footer>
    <!-- END: Footer-->

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('admin/app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('admin/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"> </script>
    <script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"> </script>
    <script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"> </script>
    {{-- <script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/dataTables.rowReorder.min.js') }}"> </script> --}}
    <script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/select2/select2.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <!-- END: Page Vendor JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('admin/app-assets/vendors/js/moment/2.29.1/moment.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"> </script>
    <script src="{{ asset('admin/app-assets/vendors/js/jquery-nice-select/1.1.0/jquery.nice-select.js') }}"> </script>
    <script src="{{ asset('admin/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jodit.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/components.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('admin/assets/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@10.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Other JS-->
    @stack('scripts')
    {{-- Footer CONTENT --}}
    <script>
        // let BASE_URL = '{{ url('admin') }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.validator.addMethod("regex", function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "Please check your input."
        );

        $.validator.addMethod("specialcharactersremove", function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || !re.test(value);
            },
            "Please check special characters are not allow."
        );

        $.validator.addMethod('latCoord', function(value, element) {
            return this.optional(element) ||
                value.length >= 4 && /^(?=.)-?((8[0-5]?)|([0-7]?[0-9]))?(?:\.[0-9]{1,20})?$/.test(
                    value);
        }, 'Your Latitude format has error.');

        $.validator.addMethod('longCoord', function(value, element) {
            return this.optional(element) ||
                value.length >= 4 &&
                /^(?=.)-?((0?[8-9][0-9])|180|([0-1]?[0-7]?[0-9]))?(?:\.[0-9]{1,20})?$/.test(value);
        }, 'Your Longitude format has error.');

        jQuery.extend(jQuery.validator.messages, {
            required: "This field is required.",
            remote: "Please fix this field.",
            email: "Please enter a valid email address.",
            url: "Please enter a valid URL.",
            date: "Please enter a valid date.",
            dateISO: "Please enter a valid date (ISO).",
            number: "Please enter a valid number.",
            digits: "Please enter only digits.",
            creditcard: "Please enter a valid credit card number.",
            equalTo: "Please enter the same value again.",
            accept: "Please enter a value with a valid extension.",
            maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
            minlength: jQuery.validator.format("Please enter at least {0} characters."),
            rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
            range: jQuery.validator.format("Please enter a value between {0} and {1}."),
            max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
            min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
        });
    </script>
    @yield('footer-content')
    <!-- END: Other JS-->
</body>
<!-- END: Body-->

</html>
