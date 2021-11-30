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
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/pages/authentication.css') }}">
    <!-- END: Page CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style.css') }}">
    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->
<!-- BEGIN: Body-->

<body
    class="vertical-layout vertical-menu-modern 1-column  navbar-floating footer-static bg-full-screen-image  menu-collapsed blank-page blank-page"
    data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body login-page">
                <section class="row mx-0 flexbox-container align-items-stretch">
                    <div class="col-xl-8 px-0 col-md-7 mobile-d-none">
                        <div class="h-100 login-bg"
                            style="background-image:url({{ asset('admin/assets/image/NoPath.png') }}); "></div>
                    </div>
                    <div class="col-xl-4 px-0 col-md-5">
                        <div class="card rounded-0 mb-0 px-2 h-100 pb-2 justify-content-center">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                        src="{{ asset('admin/assets/image/logo.png') }}" class="logo">
                                    <h4 class="mb-0 font-large-1">Sign in</h4>
                                    <p class=" mb-0 mt-1 font-weight-light">Please enter your credentials to proceed.
                                    </p>
                                </div>
                            </div>

                            <div class="card-content">
                                <div class="card-body pt-0">

                                    <form action="{{ route('admin.login') }}" method="post">
                                        @csrf
                                        <fieldset class="mb-1 form-group position-relative has-icon-left">
                                            <label for="user-name required">EMAIL ADDRESS</label>
                                            <div class="position-relative">
                                                <input autocomplete="off" type="email" class="form-control" name="email"
                                                    id="email" placeholder="Email address"
                                                    value="{{ old('email') }}" />
                                                @error('email')
                                                    <div id="email_error" class="text-danger mb-4">{{ $message }}
                                                    </div>
                                                @enderror
                                                <div class="text-danger cls_usermsg mb-4" id="usermsg"></div>
                                                <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="mb-1 form-group position-relative has-icon-left">
                                            <label class="d-block required" for="user-password">PASSWORD <a
                                                    href="{{ route('admin.forgot.password.form') }}"
                                                    class="card-link float-right">Forgot Password?</a></label>
                                            <div class="position-relative">
                                                {{-- <i class="fa fa-eye" aria-hidden="true"></i> --}}
                                                <input autocomplete="off" type="password" class="form-control"
                                                    name="password" placeholder="Password" id="password" />
                                                @error('password')
                                                    <div class="text-danger mb-4">{{ $message }}</div>
                                                @enderror
                                                <div class="form-control-position">
                                                    <i class="feather icon-lock"></i>
                                                </div>
                                            </div>

                                        </fieldset>
                                        <div
                                            class="form-group d-flex justify-content-between align-items-center mb-0 mt-2">
                                            <button type="submit" class="btn btn-primary w-100 btn-inline">Sign
                                                in</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('admin/app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->
    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('admin/app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/components.js') }}"></script>
    <!-- END: Theme JS-->
    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->
</body>
<!-- END: Body-->

</html>
