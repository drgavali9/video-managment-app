@extends('layouts.app')

@section('body')
    <!-- login area start -->
    <div class="login-register-area mb-60px mt-53px">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto d-flex justify-content-center">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a href="{{ route('login') }}">
                                <h4>{{__('loginandregistration.login')}}</h4>
                            </a>
                            <a class="active" href="{{ route('register') }}">
                                <h4>{{__('loginandregistration.register')}}</h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form method="POST" action="{{ route('register') }}" id="registration_form">
                                            @csrf
                                            <input autocomplete="off"  type="text" name="first_name" id="first_name"
                                                class="@error('first_name') is-invalid @enderror"
                                                placeholder="First Name" value="{{old('first_name') ?? null}}" />

                                            @error('first_name')
                                                <div class="alert alert-danger  mb-4">{{ $message }}</div>
                                            @enderror

                                            <input autocomplete="off"  type="text" name="last_name" id="last_name"
                                                class="@error('last_name') is-invalid @enderror" placeholder="Last Name" value="{{old('last_name') ?? null}}" />

                                            @error('last_name')
                                                <div class="alert alert-danger mb-4">{{ $message }}</div>
                                            @enderror

                                            <div>
												<select class="@error('phone_code') is-invalid @enderror form-control"
												name="phone_code" id="phone_code">
												@if (!empty($countries))
													<option value=""> {{__('loginandregistration.select-phone-code')}}</option>
													@foreach ($countries as $country)
														<option value="{{ $country->country_code }}">
															{{ $country->country_code }}</option>
													@endforeach
												@else
													<option>{{__('loginandregistration.no-country-code-avalable')}}</option>
												@endif
											</select>
                                                <input autocomplete="off"  type="text" name="phone" id="phone" value="{{old('phone') ?? null}}"
                                                    class="@error('phone') is-invalid @enderror" placeholder="Mobile No" />
                                            </div>

                                            @error('phone')
                                                <div class="alert alert-danger ">{{ $message }}</div>
                                            @enderror
                                            @error('phone_code')
                                                <div class="alert alert-danger mb-4">{{ $message }}</div>
                                            @enderror

                                            <input autocomplete="off"  type="email" name="email" id="email"
                                                class="@error('email') is-invalid @enderror" placeholder="Email address" />

                                            @error('email')
                                                <div class="alert alert-danger mb-4">{{ $message }}</div>
                                            @enderror
                                            <div class="password1004 mt-3">
                                                {{-- <i class="fa fa-eye" aria-hidden="true"></i> --}}
                                                <input autocomplete="off"  type="password" name="password" id="password"
                                                    class="@error('password') is-invalid @enderror"
                                                    placeholder="Password" />
                                                @error('password')
                                                    <div class="alert alert-danger mb-4">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mt-3 otp_div hide">
                                                <input autocomplete="off"  type="text" placeholder="Verify Otp" id="verify_otp">
                                            </div>
                                            <div class="mt-3">
                                                <div id="recaptcha-container"></div>
                                            </div>
                                            <div class="button-box">
                                                <div class="login-toggle-btn">
                                                    <div class="remeberme">
                                                        <input autocomplete="off"  type="checkbox" name="subscribe_to_our_newsletter" />
                                                        <a class="flote-none" href="javascript:void(0)">{{__('loginandregistration.subscribe-to-our')}}</a>
                                                    </div>

                                                </div>
                                                <p>{{__('loginandregistration.description')}} <a href="{{route('privacy-policy')}}"  style="color: #023b39"><strong>{{__('loginandregistration.privacy-policy')}}</strong></a> .</p>
                                                <button type="button" id="sendotp_btn" class="sendotp_btn"><span>Send
                                                        Otp</span></button>
                                                <button type="button" class="mt-3 otp_div hide"
                                                    id="register_btn"><span>{{__('loginandregistration.register')}}</span></button>
                                                <div class="login-option">
                                                    {{-- <a class="apple">
                                                        <i class="fab fa-apple"></i>
                                                        <h3>{{__('loginandregistration.apple')}}</h3>
                                                    </a> --}}
													@signInWithApple("black",false,"sign-in",0)
                                                    <a class="google" href="{{ url('/login/Google') }}">
                                                        <i class="fab fa-google"></i>
                                                        <h3>{{__('loginandregistration.google')}}</h3>
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login area end -->
@endsection

@push('scripts')
    {{-- firebase --}}
    {{-- <script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-app.js"></script>
		<script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-analytics.js"></script> --}}
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            var firebaseConfig = {

                apiKey: "{{config('constants.message_credentials.MESSAGE_APIKEY')}}",
                authDomain: "{{config('constants.message_credentials.MESSAGE_AUTHDOMAIN')}}",
                projectId: "{{config('constants.message_credentials.MESSAGE_PROJECTID')}}",
                storageBucket: "{{config('constants.message_credentials.MESSAGE_STORAGEBUKET')}}",
                messagingSenderId: "{{config('constants.message_credentials.MESSAGE_MESSING_SENDER_ID')}}",
                appId: "{{config('constants.message_credentials.MESSAGE_APPID')}}",
                measurementId: "{{config('constants.message_credentials.MESSAGE_MEASURMENTID')}}",
            };

            firebase.initializeApp(firebaseConfig);

            $(".verifydiv").hide();
            setTimeout(() => {
                render();
            }, 200);
        });

        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }

        $('#sendotp_btn').click(function() {
            var code = $('#phone_code').val();
            var phone = $('#phone').val();
            if (phone.length < 10) {
                toastr.error('Mobile Number must be 10 digit number.')
            } else {
                phone = code.concat(phone);

                firebase.auth().signInWithPhoneNumber(phone, window.recaptchaVerifier)
                    .then(function(confirmationResult) {

                        window.confirmationResult = confirmationResult;
                        coderesult = confirmationResult;
                        $('.sendotp_btn').addClass("hide");
                        $(".otp_div").removeClass("hide");
                        toastr.success('otp send successfully.')
                    })
                    .catch(function(error) {
                        $("#error").text(error.message);
                        $("#error").show();
                        setTimeout(function() {
                            $('#error').fadeOut('slow');
                        }, 10000);
                    });
            }
        })

        $('#register_btn').click(function() {
            var code = $("#verify_otp").val();
            coderesult.confirm(code).then(function(result) {
                var user = result.user;
                $("#registration_form").submit();
            }).catch(function(error) {
                toastr.error(error.message);
            });
        });
    </script>
@endpush
