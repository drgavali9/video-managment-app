@extends('admin.layouts.app')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title mb-0">
                        Setting
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <form class="form form-vertical" id="setting-form" method="POST" action="{{ route('admin.setting.update') }}">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-8">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body setting-rate">
                                    <div class="row">
                                        @foreach ($data as $setting)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label
                                                        class="buyer-tital required">{{ str_replace('_', ' ', $setting->key) }}</label>
                                                    <input autocomplete="off" type="text" class="form-control"
                                                        placeholder="Enter setting" aria-describedby="basic-addon2"
                                                        name="setting-{{ $setting->id }}" value="{{ $setting->value }}">
                                                    <span
                                                        class="text-danger">{{ $errors->first('setting-' . $setting->id) }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit"
                                                class="btn btn-primary btn-print mb-1 mb-md-0 waves-effect waves-light">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer-content')
    <script type="text/javascript">
        $(document).ready(() => {
            $('#setting-form').on('submit', function(event) {
                // adding rules for inputs with class 'comment'
                $('#setting-form').find('input').each(function() {
                    $(this).rules("add", {
                        required: true,
                        // regex: "^[a-zA-Z0-9 ()!%&,./-:+=<>?\"']{0,10000000}$",
                    })
                });

                // prevent default submit action
                event.preventDefault();
            })

            // initialize the validator
            $("#setting-form").validate({
                debug: false,
                errorClass: "text-danger",
                errorElement: "span",
                errorPlacement: function(error, element) {
                    var placement = $(element).data('error');
                    if (placement) {
                        $(placement).parent().append(error)
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    $('[type=submit]').attr('disabled', 'disabled');
                    form.submit();
                },
            });
        });
    </script>
@endsection
