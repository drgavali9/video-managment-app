<!-- Footer Area start -->
<footer class="footer-area">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <!-- footer single wedget -->
                <div class="col-md-6 col-lg-4">
                    <!-- footer logo -->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="footer-logo">
                                <a href="{{ route('home') }}">
                                    <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                        src="{{ asset('images/logo/logo.png') }}" alt="" />
                                </a>
                            </div>
                        </div>
                        <div class="col-md-7 footer-address">
                            <p>{{ $settings['shop_address'] ?? '' }} {{ $settings['shop_email'] ?? '' }}</p>
                            <div class="footer-icon">
                                @if (!empty($settings['1004_facebook_link']))
                                    <a href="{{ $settings['1004_facebook_link'] }}"><img
                                            onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                            src="{{ asset('images/icon/facebook.svg') }}" alt="facebook"></a>
                                @endif

                                @if (!empty($settings['youtube']))
                                    <a href="{{ $settings['youtube'] }}"><img
                                            onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                            src="{{ asset('images/icon/youtube.svg') }}" alt="youtube"></a>
                                @endif

                                @if (!empty($settings['1004_instagram_link']))
                                    <a href="{{ $settings['1004_instagram_link'] }}"><img
                                            onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                            src="{{ asset('images/icon/instagram.svg') }}" alt="instagram"></a>
                                @endif

                            </div>
                        </div>
                    </div>

                    <!-- footer logo -->
                    <div class="about-footer">
                        <p class=""><strong>{{ __('home.customer-center') }}</strong>&nbsp;
                            &nbsp;{{ __('home.call-or-whatsapp') }}
                            {{ $settings['customer_center_time_from'] ?? '' }} to
                            {{ $settings['customer_center_time_to'] ?? '' }}
                            ({{ $settings['customer_center_days_from'] ?? '' }} -
                            {{ $settings['customer_center_days_to'] ?? '' }})</p>
                        <div class="footer-number">
                            @if (!empty($settings['customer_center_phone'])) <span
                                    class="phone-number"><img
                                        onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                        src="{{ asset('images/icon/phone.svg') }}"
                                        alt=""><span>{{ $settings['customer_center_phone'] ?? '' }}</span></span>
                            @endif
                            @if (!empty($settings['whatsapp_number']))<span><img
                                        onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                        src="{{ asset('images/icon/whatsapp.svg') }}" alt=""><span>
                                        {{ $settings['whatsapp_number'] ?? '' }}</span></span>@endif
                        </div>
                    </div>
                    <!--  Footer Bottom Area start -->
                    <div class="copyright-footer">
                        <p class="copy-text">©<a href="javascript:">{{ __('home.2019-video-managment-app') }}</a>.
                            {{ __('home.all-rights-reserved') }}</p>
                    </div>
                    <!--  Footer Bottom Area End-->
                </div>
                <!-- footer single wedget -->
                <div class="col-md-6 col-lg-2 mt-res-sx-30px mt-res-md-30px">
                    <div class="single-wedge">
                        <h4 class="footer-herading">{{ __('home.account') }}</h4>
                        <div class="footer-links">
                            <ul>
                                <li><a href="{{ route('cart') }}">{{ __('home.cart') }}</a></li>
                                <li><a href="{{ route('profile') }}">{{ __('home.my-account') }}</a></li>
                                <li><a href="{{ url('profile?tab=myorder') }}">{{ __('home.my-order') }}</a></li>
                                <li><a href="{{ route('blogs.index') }}">{{ __('home.blog') }}</a></li>
                                <li><a
                                        href="{{ route('product.recent-view-product') }}">{{ __('home.your-recently-viewed') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- footer single wedget -->
                <div class="col-md-6 col-lg-2 mt-res-md-50px mt-res-sx-30px mt-res-md-30px">
                    <div class="single-wedge">
                        <h4 class="footer-herading">{{ __('home.customer-service') }}</h4>
                        <div class="footer-links">
                            <ul>
                                <li><a href="{{ route('contact_us') }}">{{ __('home.contact-us') }}</a></li>
                                <li><a
                                        href="{{ route('wholesale.index') }}">{{ __('home.wholesale-inquiry') }}</a>
                                </li>
                                <li><a href="{{ route('membership.index') }}">{{ __('home.membership') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- footer single wedget -->
                <div class="col-md-6 col-lg-2 mt-res-md-50px mt-res-sx-30px mt-res-md-30px">
                    <div class="single-wedge">
                        <h4 class="footer-herading">{{ __('home.quick-links') }}</h4>
                        <div class="footer-links">
                            <ul>
                                <li><a href="{{ route('about_us') }}">{{ __('home.about-us') }}</a></li>
                                <li><a href="{{ route('our-press') }}">{{ __('home.our-press') }}</a></li>
                                <li><a href="{{ route('recipe.index') }}">{{ __('home.recipe') }}</a></li>
                                <li><a href="{{ route('privacy-policy') }}">{{ __('home.privacy-policy') }}</a>
                                </li>
                                <li><a href="{{ route('terms-conditions') }}">{{ __('home.term-conditions') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- footer single wedget -->
            </div>
        </div>
    </div>
    <!--  Footer Bottom Area start -->
    {{-- <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <p class="copy-text">Copyright © <a href="https://hasthemes.com/"> HasThemes</a>. All Rights Reserved</p>
                </div>
                <div class="col-md-6 col-lg-8">
                    <img class="payment-img" src="{{ asset('assets/images/icons/payment.png')}}" alt="" />
                </div>
            </div>
        </div>
    </div> --}}
    <!--  Footer Bottom Area End-->
</footer>
<!--  Footer Area End -->
@push('script')
	<script>

	</script>
@endpush
