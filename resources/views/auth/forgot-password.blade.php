{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
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
							<h4> {{__('loginandregistration.forgot-password')}}</h4>
						</a>
					</div>
					<div class="tab-content">
						<div id="forgot-password" class="tab-pane active">
							<div class="login-form-container">
								<div class="login-register-form">
									<form action="{{route('password.email')}}" method="POST">
										@csrf
										<h6>{{__('loginandregistration.forgetpassword-description')}}</h6>
										<input autocomplete="off"  type="text" name="email" onchange="checkuser()" id="email" placeholder="Enter your Email" />
										@error('email')
										<div class="text-danger mb-4" id="email_error">{{ $message }}</div>
										@enderror
										<div class="text-danger cls_usermsg mb-4" id="usermsg"></div>
										<div class="button-box " >

											<button id="reset-password-button" class="reset-password-button"  type="submit"><span>{{__('loginandregistration.reset-password')}}</span></button>

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

    <script>
        function checkuser() {

            $("#email_error").addClass('mb-4');
            $('.cls_usermsg').html('');
            $('#reset-password-button').attr('disabled', true);
			// $('.reset-password-button').addClass('loginhidefield');
            // $('.password1004').addClass('loginhidefield');
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
                        $('#reset-password-button').attr('disabled', false);
                        // $('.reset-password-button').removeClass('loginhidefield');
						// $('.btn_remember').removeClass('loginhidefield');

                    } else {
                        $("#email_error").html('');
                        $('#usermsg').html(results.message)
                        $('#reset-password-button').attr('disabled', true);
                    }
                },
            });
        }

    </script>

@endpush
