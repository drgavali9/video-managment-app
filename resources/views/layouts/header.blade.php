<!-- Header Start -->
{{-- {{ Auth::user() }} --}}

<header class="main-header">
    <!-- Header Top Start -->

    <!-- Header Top End -->
    <!-- Header Buttom Start -->
    <input autocomplete="off" type="hidden" name="_token" id="csrf" value="{{ csrf_token() }}" />
    <div class="header-navigation sticky-nav">
        <div class="container">
            <div class="row">
                <!-- Logo Start -->
                <div class="col-md-1 col-sm-2">
                    <div class="logo">
                        <a href="{{ route('home') }}"><img
                                onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                src="{{ asset('images/logo/logo.png') }}" alt="logo.jpg" /></a>
                    </div>
                </div>
                <!-- Logo End -->
                <!-- Navigation Start -->
                <div class="col-md-11 col-sm-10">
                    <!--Main Navigation Start -->
                    <div class="main-navigation d-none d-lg-block">
                        <ul>
                            <li class="menu-dropdown">
                                <a href="{{ route('product.list') }}">{{ __('home.all-categories') }}</a>
                                <ul class="sub-menu">
                                    @foreach ($headercategories as $category)
                                        {{-- @if (empty($category->category_id)) --}}
                                        <li class="menu-dropdown position-static">
                                            <a href="{{ route('category.index', $category->slug) }}">{{ $category->title_trans }}<i
                                                    class="ion-ios-arrow-down"></i></a>

                                            @if (!empty($category->childrenRecursive))
                                                @include('frontend.partials.categories', ['categories' =>
                                                $category->childrenRecursive, 'position' => 2])
                                            @endif
                                        </li>
                                        {{-- @endif --}}
                                    @endforeach
                                    <a id="headerloadMore"
                                        href="{{ route('product.list') }}">{{ __('home.view-more') }}</a>
                                </ul>

                            </li>
                            @foreach ($recentCategories as $recentcategory)
                                <li class="menu-dropdown">
                                    <a
                                        href="{{ route('category.index', $recentcategory->slug) }}">{{ $recentcategory->title_trans }}</a>
                                </li>
                            @endforeach

                            <li><a href="{{ route('about_us') }}">{{ __('home.about-us') }}</a></li>
                        </ul>
                    </div>
                    <!--Main Navigation End -->
                    <!--Header Bottom Account Start -->
                    <div class="header_account_area">
                        <!--Seach Area Start -->
                        <div id="custom-search-input">

                            <div class="input-group">
                                <input autocomplete="off" type="text" name="search" id="search"
                                    class="search-query form-control"
                                    value="{{ request()->get('search') ?? null }}" />
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" id="btn_search">
                                        <span><i class="fa fa-search" aria-hidden="true"></i></span>
                                    </button>
                                </span>
                            </div>
                            </form>
                        </div>
                        <!--Seach Area End -->

                        <div class="cart-info d-flex">
                            <div class="mini-cart-warp">
                                <a href="javascript:" class="count-cart"
                                    content="{{ $headercart != null ? count($headercart->cartdetails) : '0' }}"></a>
                                <div class="mini-cart-content">
                                    <ul id="header_cart">
                                        @if (!empty($headercart))
                                            @if (count($headercart->cartdetails) > 0)
                                                @foreach ($headercart->cartdetails as $cartdetail)
                                                    <li class="single-shopping-cart" id="row_{{ $cartdetail->id }}">
                                                        <div class="shopping-cart-img">
                                                            <a
                                                                href="{{ route('product.show', $cartdetail->product->slug) }}">
                                                                <img alt=""
                                                                    src="{{ $cartdetail->product->image_url }}"
                                                                    onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'" /></a>
                                                            <span
                                                                class="product-quantity">{{ $cartdetail->quantity }}x</span>
                                                        </div>
                                                        <div class="shopping-cart-title">
                                                            <h4><a
                                                                    href="{{ route('product.show', $cartdetail->product->slug) }}">{{ $cartdetail->product->title_trans }}</a>
                                                            </h4>
                                                            <span>{{ config('constants.currency') }}
                                                                {{ $cartdetail->product->price }}</span>
                                                            <div class="shopping-cart-delete">
                                                                <a href="javascript:"
                                                                    onclick="deleteHeaderCartProduct({{ $cartdetail->id }})"><i
                                                                        class="ion-android-cancel"></i></a>
                                                            </div>
                                                        </div>
                                                    </li>

                                                @endforeach
                                            @else
                                                <h6 class="emtycart">{{ __('home.no-cart-item') }}</h6>
                                            @endif
                                        @endif
                                    </ul>
                                    <div id="header_cart_amount">
                                        @if (!empty($headercart))
                                            @if (count($headercart->cartdetails) > 0)
                                                <div class="shopping-cart-total">
                                                    <h4>{{ __('home.subtotal') }} : <span
                                                            id="subtotal">{{ config('constants.currency') }}
                                                            {{ $headercart->sub_total }}</span></h4>
                                                    <h4>{{ __('home.shipping') }} : <span
                                                            id="deliveryfee">{{ config('constants.currency') }}
                                                            {{ $headercart->delivery_fee }}</span></h4>

                                                    <h4>{{ __('home.taxes') }} : <span
                                                            id="taxcharges">{{ config('constants.currency') }}
                                                            {{ $headercart->tax_charges_value }} </span></h4>
                                                    <h4>{{ __('home.convenience-fee') }} : <span
                                                            id="conveniencefee">{{ config('constants.currency') }}
                                                            {{ $headercart->convenience_fee_value }}</span></h4>
                                                    <h4 class="shop-total">{{ __('home.total') }} : <span
                                                            id="ordertotal">{{ config('constants.currency') }}
                                                            {{ $headercart->order_total }}</span></h4>
                                                </div>
                                                <div class="shopping-cart-btn text-center">
                                                    <a class="default-btn"
                                                        href="{{ route('cart') }}">{{ __('home.checkout') }}</a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="no_cart_item header_no_cart_item col-md-12" id="header_no_cart_item">
                                        @if (empty($headercart))
                                            <h6 class="emtycart">{{ __('home.no-cart-item') }}</h6>
                                        @endif
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!--Cart info End -->
                        <!-- profile  -->
                        @auth
                            <div class="profile">
                                <a href="{{ route('profile') }}">
                                    <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                        src="{{ asset('images/icon/Profile.svg') }}" alt="profile">
                                </a>
                            </div>
                        @endauth
                        @guest
                            <div class="profile">
                                <a href="{{ route('login') }}">
                                    <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                        src="{{ asset('images/icon/Profile.svg') }}" alt="profile">
                                </a>
                            </div>
                        @endguest
                        <!-- south-korea -->
                        <div class="south-korea">
                            @if (session()->get('locale') == 'en')
                                <a href="{{ route('language.change', 'kr') }}">
                                    <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                        src="{{ asset('images/icon/kr.svg') }}"
                                        style="height: 25px ;width: 30px;margin:2px" alt="korea">
                                </a>
                            @elseif (session()->get('locale') == 'kr')
                                <a href="{{ route('language.change', 'en') }}">
                                    <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                        src="{{ asset('images/icon/us.svg') }}"
                                        style="height: 25px ;width: 30px;margin:2px" alt="English">
                                </a>
                            @else
                                <a href="{{ route('language.change', 'kr') }}">
                                    <img onerror="this.onerror=null;this.src='{{ url(config('imagepath.default.image')) }}'"
                                        src="{{ asset('images/icon/kr.svg') }}"
                                        style="height: 25px ;width: 30px;margin:2px" alt="korea">
                                </a>
                            @endif
                        </div>
                        <!--Contact info Start -->

                        <!-- <div class="contact-link">
                            <div class="phone">
                                <p>Call us:</p>
                                <a href="tel:(+800)345678">(+800)345678</a>
                            </div>
                        </div> -->
                        <!--Contact info End -->

                    </div>
                </div>
            </div>
            <!-- mobile menu -->
            <div class="mobile-menu-area">
                <div class="mobile-menu">
                    <nav id="mobile-menu-active">
                        <ul class="menu-overflow">
                            <li>
                                <a href="{{ route('product.list') }}">ALL CATEGORIES</a>
                                <ul>
                                    @foreach ($headercategories as $category)
                                        <li>
                                            <a
                                                href="{{ route('category.index', $category->slug) }}">{{ $category->title }}</a>

                                            @if (!empty($category->childrenRecursive))
                                                @include('frontend.partials.mobilecategory', ['categories' =>
                                                $category->childrenRecursive, 'position' => 2])
                                            @endif
                                        </li>
                                    @endforeach

                                    {{-- <li>
                                        <a href="lifestyle.html">Lifestyle</a>
                                        <ul>
                                            <li><a href="#">PRE-ORDER</a></li>
                                            <li><a href="#">New Arrivalsa</a></li>
                                            <li><a href="#">Back In Stock</a></li>
                                            <li><a href="#">Korean Red Ginseng</a></li>
                                            <li><a href="#">Promotion</a></li>
                                        </ul>
                                    </li> --}}
                                </ul>
                            </li>
                            @foreach ($recentCategories as $recentcategory)
                                <li>
                                    <a
                                        href="{{ route('category.index', $recentcategory->slug) }}">{{ $recentcategory->title }}</a>
                                </li>
                            @endforeach
                            {{-- <li><a href="{{route('promotion')}}">Promotion</a></li>
                            <li><a href="{{route('shinsun_fresh')}}">ShinSun Fresh</a></li>
                            <li><a href="{{route('k_beauty')}}">K-Beauty</a></li>
                            <li><a href="lifestyle.html">Lifestyle</a></li> --}}
                            <li><a href="{{ route('about_us') }}">About US</a></li>
                            @auth
                                <li>
                                    <a href="{{ route('profile') }}">Profile
                                    </a>
                                </li>
                            @endauth
                            @guest
                                <li>
                                    <a href="{{ route('login') }}">Profile
                                    </a>
                                </li>
                            @endguest
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- mobile menu end-->
        </div>
    </div>
    <!--Header Bottom Account End -->
</header>
<!-- Header End -->


@push('scripts')
    <script>
        function deleteHeaderCartProduct(id) {
            swal({
                title: "Delete?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function(e) {
                    if (e.value === true) {
                        var CSRF_TOKEN = $('#csrf').val();
                        $.ajax({
                            type: 'delete',
                            url: "{{ url('cart/remove') }}/" + id,
                            data: {
                                _token: CSRF_TOKEN
                            },
                            dataType: 'JSON',
                            success: function(results) {
                                if (results.success === true) {
                                    toastr["success"](results.message);
                                    $('#row_' + id).remove();
                                    $('#subtotal').html(results.cart.sub_total);
                                    $('#deliveryfee').html(results.cart.delivery_fee);
                                    $('#taxcharges').html(results.cart.tax_charges_value);
                                    $('#conveniencefee').html(results.convenience_fee_value)
                                    $('#ordertotal').html(results.cart.order_total);

                                    $(".count-cart").attr('content', results.cart.cartdetails.length);

                                    if (results.cart.cartdetails.length <= 0) {
                                        $('#header_no_cart_item').removeClass('hide');

                                        $('#header_cart_amount').html('');
                                        $('#header_no_cart_item').html(
                                            '<h6 class="emtycart">{{__("home.no-cart-item")}}</h6>');
                                    }

                                } else {
                                    toastr["error"](results.message);
                                }
                            }
                        });
                    } else {
                        e.dismiss;
                    }
                },
                function(dismiss) {
                    return false;
                })
        }

		function cartPlusMinusbutton()
		{
			var CartPlusMinus = $('.cart-plus-minus');
                CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
                CartPlusMinus.append('<div class="inc qtybutton">+</div>');
                $(".qtybutton").on("click", function() {
                    $('#maxproduct').html('');
                    var $button = $(this);
                    var oldValue = $button.parent().find("input").val();
                    if ($button.text() === "+") {
                        var oldNewVal = parseFloat(oldValue) + 1;
                        if (oldNewVal > $button.parent().find("input").attr('max')) {
                            // swal("Error!", "No more stock available.", "error");
                            $('#maxproduct').html('No more stock available.')
                            return false;
                        }
                        var newVal = oldNewVal;
                    } else {
                        // Don't allow decrementing below zero
                        if (oldValue > 1) {
                            var newVal = parseFloat(oldValue) - 1;
                        } else {
                            newVal = 1;
                        }
                    }
                    $button.parent().find("input").val(newVal);
                });
		}

        $('#btn_search').click(function() {
            var searchdata = $('#search').val()
            var url = '';
            url = '{{ url('allproducts/list') }}?search=' + searchdata +
                '&categories_id={{ request()->get('categories_id') }}&brands_id={{ request()->get('brands_id') }}&price={{ request()->get('price') }}&order={{ request()->get('order') }}';
            location.href = url;
        })

        function Addtocart(product_id, item_total, qty, point) {
            var CSRF_TOKEN = $('#csrf').val();
            var curProductDiv = $("#addtocart_" + product_id);
            var curProductObj = null;
            $.ajax({
                type: 'post',
                url: "{{ url('/cart') }}",
                data: {
                    _token: CSRF_TOKEN,
                    'product_id': product_id,
                    'quantity': qty,
                    'item_total': item_total,
                    'point': point
                },
                dataType: 'JSON',
                success: function(results) {

                    if (results.status == true) {
                        toastr["success"](results.message);
                        let cart = results.cart;
                        $('#header_no_cart_item').addClass('hide');

                        $("#header_cart").html('');
                        $('#header_cart_amount').html('');
                        $(".count-cart").attr('content', results.cart.cartdetails.length);
                        $.each(cart.cartdetails, function(key, value) {
                            if (value.product.id === product_id) {
                                curProductObj = value.product;
                            }
                            var slug = value.product.slug;
                            var producturl = '/products/' + slug;

                            $('#header_cart').append('<li class="single-shopping-cart" id="row_' + value
                                .id + '">\
                                                 	<div class="shopping-cart-img">\
                                                	 <a href="' + producturl + '"> <img alt="" src="' + value.product
                                .image_url + '"  onerror="this.onerror=null;this.src=\'/assets/images/no-image-icon.png\'" /></a>\
                                                            <span class="product-quantity">' + value.quantity + 'x</span>\
                                                                </div>\
                                                                <div class="shopping-cart-title">\
                                                                    <h4>\
                                                					<a href="' + producturl + '">' + value.product.title_trans + '</a>\
                                                                    </h4>\
                                                                    <span>{{ config("constants.currency") }}' + value
                                .product
                                .price +
                                '</span>\
                                                                    <div class="shopping-cart-delete">\
                                                                        <a href="javascript:" onclick="deleteHeaderCartProduct(' +
                                value
                                .id + ')"><i class="ion-android-cancel"></i></a>\
                                                					</div>\
                                                                </div>\
                                                            </li>\
                                                		');
                        });
                        $('#header_cart_amount').html('<div class="shopping-cart-total">\
                                                    <h4>{{__("home.subtotal")}} : <span id="subtotal">{{ config("constants.currency") }}\
                                                            ' + cart.sub_total + '</span></h4>\
                                                    <h4>{{__("home.shipping")}} : <span\
                                                            id="deliveryfee">{{ config("constants.currency") }}\
                                                            ' + cart.delivery_fee + '</span></h4>\
                                                    <h4>{{__("home.taxes")}} : <span id="taxcharges">{{ config("constants.currency") }}\
                                                            ' + cart.tax_charges_amount + '</span></h4>\
                        							<h4>{{__("home.convenience-fee")}} : <span id="taxcharges">{{ config("constants.currency") }}\
                                                            ' + cart.convenience_fee_amount + '</span></h4>\
                                                    <h4 class="shop-total">{{__("home.total")}} : <span\
                                                            id="ordertotal">{{ config("constants.currency") }}\
                                                            ' + cart.order_total + '</span></h4>\
                                                </div>\
                                                <div class="shopping-cart-btn text-center">\
                                                    <a class="default-btn" href="/cart">{{__("home.checkout")}}</a>\
                                                </div>\
                                                ');

                        if ($(curProductDiv).parents('.list-product').find('.pricing-meta').length > 0 && $(curProductDiv).parents('.list-product').find('.cart-plus-minus').length === 0) {
                            $(curProductDiv).parent().after('<div class="product-quantity-card">' +
                                '<div class="product-quantity">' +
                                '<div class="cart-plus-minus" onclick="changequantity(' + cart.id + ',' +
                                product_id + ',' + curProductObj.price + ',' + curProductObj.point + ')">' +
                                '<input autocomplete="off"\ class="cart-plus-minus-box input-qty" type="text" max="' +
                                curProductObj.available_quantity + '" disabled id="qtybutton_' + product_id +
                                '" name="qtybutton" value="1" />' +
                                '</div>' +
                                '<a class="fa fa-shopping-bag" style="font-size: 25px; color: #168a7c;" href="javascript:"></a>' +
                                '</div></div>');
                            $(curProductDiv).hide();
							cartPlusMinusbutton()
                        }
                    } else {
                        toastr.error(results.message);
                    }
                }
            });
        }

    </script>

@endpush
