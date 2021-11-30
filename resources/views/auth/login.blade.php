{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input autocomplete="off"  id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}

@extends('layouts.app')

@section('body')
    <!-- login area start -->
    <input autocomplete="off"  type="hidden" name="_token" id="csrf" value="{{ csrf_token() }}" />
    <div class="login-register-area mb-60px mt-53px">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto d-flex justify-content-center">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="{{ route('login') }}">
                                <h4>{{__('loginandregistration.login')}}</h4>
                            </a>
                            <a href="{{ route('register') }}">
                                <h4>{{__('loginandregistration.register')}}</h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ url('login') }}" method="post">
                                            @csrf
                                            <input autocomplete="off"  type="email" name="email" id="email" onchange="checkuser()"
                                                placeholder="Email address" value="{{ old('email') }}" />
                                            @error('email')
                                                <div id="email_error" class="text-danger mb-4">{{ $message }}</div>
                                            @enderror
                                            <div class="text-danger cls_usermsg mb-4" id="usermsg"></div>

                                            <div class="password1004">
                                                {{-- <i class="fa fa-eye" aria-hidden="true"></i> --}}
                                                <input autocomplete="off"  type="password" name="password" placeholder="Password"
                                                    id="password" />
                                                @error('password')
                                                    <div class="text-danger mb-4">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- <div class="button-box">
												<div class="btn_remember">
                                                <div class="login-toggle-btn ">
                                                    <div class="remeberme">
                                                        <input autocomplete="off"  type="checkbox" />
                                                        <a class="flote-none" href="javascript:void(0)">{{__('loginandregistration.remember-me')}}</a>
                                                    </div>
                                                    <a href="{{ route('password.request') }}">{{__('loginandregistration.forgot-password')}}</a>
                                                </div>
												</div>
                                                <button type="submit" id="loginbutton"><span>{{__('loginandregistration.login')}}</span></button>
                                            </div> --}}

                                            <div class="login-option">
												{{-- <a class="apple" href="{{url('login-apple/Apple')}}">
                                                    <i class="fab fa-apple"></i>
                                                    <h3>{{__('loginandregistration.apple')}}</h3>
                                                </a> --}}
												{{-- <a href="javascript:" > --}}
													@signInWithApple("black",false,"sign-in",0)
												{{-- </a> --}}
                                                <a class="google" href="{{ url('/login/Google') }}" >
                                                    <i class="fab fa-google"></i>
                                                    <h3>{{__('loginandregistration.google')}}</h3>
                                                </a>
                                            </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- <div id="lg2" class="tab-pane">
                            <div class="login-form-container">
                                <div class="login-register-form">

                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- login area end -->
@endsection
@push('scripts')

    <script>
        function checkuser() {

            $("#email_error").addClass('mb-4');
            $('.cls_usermsg').html('');
            $('#loginbutton').attr('disabled', true);
			$('.btn_remember').addClass('loginhidefield');
            $('.password1004').addClass('loginhidefield');
            var CSRF_TOKEN = $('#csrf').val();
            $.ajax({
                type: 'post',
                url: "{{ url('/checkuser') }}",
                data: {
                    _token: CSRF_TOKEN,
                    email: $('#email').val(),
                },
                dataType: 'JSON',
                success: function(results) {
                    if (results.status === true) {
                        $('#loginbutton').attr('disabled', false);
                        $('.password1004').removeClass('loginhidefield');
						$('.btn_remember').removeClass('loginhidefield');

                    } else {
						$('.btn_remember').addClass('loginhidefield');

                        $("#email_error").html('');
                        $("#email_error").removeClass('mb-4');
                        $('#usermsg').html(results.message)
                        $('#loginbutton').attr('disabled', true);
                        $('.password1004').addClass('loginhidefield');
                    }
                },
            });
        }

    </script>

@endpush
