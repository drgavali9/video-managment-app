@extends('admin.layouts.app')
@section('content')

    <div class="content-body">
        @if (request()->id !== null)
            <form id="bannerForm" action="{{ route('admin.banners.update', request()->id) }}" method="post"
                accept-charset="utf-8" enctype="multipart/form-data">
            @else
                <form id="bannerForm" action="{{ route('admin.banners.store') }}" method="post" accept-charset="utf-8"
                    enctype="multipart/form-data">
        @endif
        @csrf
        <section class="user">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="page-header align-items-center d-flex justify-content-between">
                        <div class="page-tital">
                            <div class="align-items-center d-flex">
                                <a href="{{ route('admin.banners.index') }}" class="back-to"><i
                                        class="feather icon-arrow-left"></i></a>
                                <h1>Header Banner</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="buyer-tital mb-1 required">Website Banner </div>
                                    <span class="buyer-tital mb-1"> Min 1600 x 440 Pixel | Max 5MB</span>
                                </div>

                                <div class="upload-img add-banner-img header-banner" id="header-banner-img-1"
                                    style="{{ isset($data) ? 'background-size:cover;' : '' }} background-image: url({{ isset($data) && $data->web_image ? $data->web_image : asset('assets/image/add-banner-web.jpg') }});">
                                    <input autocomplete="off" type="file" name="web_image" id="header-banner-1"
                                        data-error="#error-header-banner-1" />
                                </div>
                                <span id="error-header-banner-1"
                                    class="text-danger">{{ $errors->first('web_image') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="buyer-tital mb-1 required">App Banner </div>
                                    <span class="buyer-tital mb-1"> Min 984 x 450 Pixel | Max 4MB</span>
                                </div>
                                <div class="upload-img add-banner-img header-banner" id="header-banner-img-2"
                                    style="{{ isset($data) ? 'background-size:cover;' : '' }} background-image: url({{ isset($data) && $data->app_image ? $data->app_image : asset('assets/image/add-banner-mobile.jpg') }});">
                                    <input autocomplete="off" type="file" name="app_image" id="header-banner-2"
                                        data-error="#error-header-banner-2" />
                                </div>
                                <span id="error-header-banner-2"
                                    class="text-danger">{{ $errors->first('app_image') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body mt-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label class="buyer-tital required">Banner Title En</label>
                                                    <label class="buyer-tital">30 letters</label>
                                                </div>
                                                <input autocomplete="off" type="text" class="form-control" name="title"
                                                    placeholder="Title English"
                                                    value="{{ old('title', $data->title ?? null) }}">
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label class="buyer-tital required">Banner Title Kr</label>
                                                    <label class="buyer-tital">30 letters</label>
                                                </div>
                                                <input autocomplete="off" type="text" class="form-control" name="title_kr"
                                                    placeholder="Title Korean"
                                                    value="{{ old('title_kr', $data->title_kr ?? null) }}">
                                                <span class="text-danger">{{ $errors->first('title_kr') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label class="buyer-tital">Sub - Banner Title</label>
                                                    <label class="buyer-tital">50 letters</label>
                                                </div>
                                                <input autocomplete="off" type="text" class="form-control"
                                                    name="sub_title" placeholder="Sub Title English"
                                                    value="{{ old('sub_title', $data->sub_title ?? null) }}">
                                                <span class="text-danger">{{ $errors->first('sub_title') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label class="buyer-tital">Sub - Banner Title</label>
                                                    <label class="buyer-tital">50 letters</label>
                                                </div>
                                                <input autocomplete="off" type="text" class="form-control"
                                                    name="sub_title_kr" placeholder="Sub Title Korena"
                                                    value="{{ old('sub_title_kr', $data->sub_title_kr ?? null) }}">
                                                <span class="text-danger">{{ $errors->first('sub_title_kr') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="buyer-tital">Button link</label>
                                                <input autocomplete="off" type="url" class="form-control" name="link"
                                                    placeholder="link" value="{{ old('link', $data->link ?? null) }}">
                                                <span class="text-danger">{{ $errors->first('link') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="d-flex">
                                                <div class="form-group mr-1">
                                                    <label class="buyer-tital d-block required">Web site</label>
                                                    <div
                                                        class="custom-control custom-switch custom-switch-success custom-control-inline">
                                                        <input autocomplete="off" type="checkbox"
                                                            class="custom-control-input" id="customSwitch1"
                                                            name="web_status" value="1"
                                                            {{ old('web_status', $data->web_status ?? null) == 1 ? 'checked="checked"' : '' }}>
                                                        <span
                                                            class="text-danger">{{ $errors->first('web_status') }}</span>
                                                        <label class="custom-control-label" for="customSwitch1">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="buyer-tital d-block required">App</label>
                                                    <div
                                                        class="custom-control custom-switch custom-switch-success custom-control-inline">
                                                        <input autocomplete="off" type="checkbox"
                                                            class="custom-control-input" id="customSwitch2"
                                                            name="app_status" value="1"
                                                            {{ old('app_status', $data->app_status ?? null) == 1 ? 'checked="checked"' : '' }}>
                                                        <span
                                                            class="text-danger">{{ $errors->first('app_status') }}</span>
                                                        <label class="custom-control-label" for="customSwitch2">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
        </section>
        </form>
    </div>

@endsection
@section('footer-content')
    <script type="text/javascript">
        $(document).ready(() => {
            const frame = [];
            const file = [];
            const reader = [];
            $.each([1, 2], function(index, value) {
                frame[index] = document.getElementById('header-banner-img-' + value);
                file[index] = document.getElementById('header-banner-' + value);
                reader[index] = new FileReader();
                reader[index].addEventListener("load", function() {
                    frame[index].style.backgroundImage = `url(${ reader[index].result })`;
                    frame[index].style.backgroundSize = `cover`;
                }, false);
                file[index].addEventListener('change', function() {
                    const image = file[index].files[0];
                    if (image) reader[index].readAsDataURL(image);
                }, false);
            });

            $("#bannerForm").validate({
                debug: false,
                errorClass: "text-danger",
                errorElement: "span",
                rules: {
                    web_image: {
                        required: function() {
                            let id = "{{ request()->id }}";
                            if (id == "") {
                                return true;
                            } else {
                                return false;
                            }
                        },
                    },
                    app_image: {
                        required: function() {
                            let id = "{{ request()->id }}";
                            if (id == "") {
                                return true;
                            } else {
                                return false;
                            }
                        },
                    },
                    title: {
                        required: true,
                        minlength: 3,
                        maxlength: 30,
                        specialcharactersremove: "[\"$&'*+,-./:;<=>?@^_`{|}~]+",
                },
                title_kr: {
                    required: true,
                    minlength: 1,
                    maxlength: 30,
                    specialcharactersremove: "[\"$&'*+,-./:;<=>?@^_`{|}~]+",
                    },
                    sub_title: {
                        minlength: 3,
                        maxlength: 50,
                        specialcharactersremove: "[\"$&'*+,-./:;<=>?@^_`{|}~]+",
                },
                sub_title_kr: {
                    minlength: 1,
                    maxlength: 50,
                    specialcharactersremove: "[\"$&'*+,-./:;<=>?@^_`{|}~]+",
                    },
                    link: {
                        url: true,
                    },
                },
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
