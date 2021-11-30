{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input autocomplete="off" type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email', $request->email)" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}
@extends('layouts.app')
@section('body')
    <!-- login area start -->
    <div class="login-register-area mb-60px mt-53px">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto d-flex justify-content-center">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#forgot-password">
                                <h4> Reset Password</h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="forgot-password" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('password.email') }}" method="POST">
                                            @csrf
                                            <input autocomplete="off" type="hidden" name="token"
                                                value="{{ $request->route('token') }}">

                                            <input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="Email"
                                                value="{{old('email', $request->email)}}" required autofocus />

                                            <input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Password"
                                                required />


                                            <input id="password_confirmation" class="block mt-1 w-full" type="password" placeholder="Confirm password"
                                                name="password_confirmation" required />
											<div class="button-box">
                                            <button  type="submit" >
                                                {{ __('Reset Password') }}
											</button>
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
@endsection
