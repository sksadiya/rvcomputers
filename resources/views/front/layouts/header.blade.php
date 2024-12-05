<style>
  .mobile-header-wrapper-style 
  .mobile-header-wrapper-inner
   .mobile-header-content-area
    .mobile-menu-wrap nav 
    .mobile-menu li.has-children .menu-expand i {
color: #000 !important;
  }
</style>
<header class="header header-container sticky-bar bg-black">
  <div class="container p-3">
    <div class="main-header">
      <div class="header-left justify-content-between">
        <div class="header-logo"><a href="{{ route('welcome') }}"><img alt="Ecom" src="{{ $companySettings['company_logo'] }}"></a></div>
        <div class="header-search">
          <div class="box-header-search bg-white">
            <form class="form-search" method="get" action="{{ route('product.shop')}}">
              <div class="box-category">
                <select class="select-active select2-hidden-accessible" name="category" data-select2-id="1" tabindex="-1"
                  aria-hidden="true">
                  <option class="text-dark">All categories</option>
                  @foreach ($categories as $category)
                  <option class="text-dark" value="{{ $category->slug }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="box-keysearch" style="position: relative;">
                  <input class="form-control font-xs" type="text" name="search" value="" placeholder="Search...">
                  <button type="submit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                      <i class="bx bx-search-alt fs-4"></i> 
                  </button>
              </div>
            </form>
          </div>
        </div>
        <!-- <div class="header-nav text-start"> -->
          <div class="burger-icon burger-icon-white"><span class="burger-icon-top"></span><span
              class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
        <!-- </div> -->
        <div class="header-shop me-5">
        <a class="font-lg icon-list bx bx-user text-white" href="
            @if(auth()->guard('customer')->check())
                {{ route('customer.dashboard') }}
            @elseif(auth()->check() && auth()->user()->hasRole('Super Admin'))
                {{ route('root') }}
            @else
                {{ route('customer.login') }}
            @endif
        ">
        </a>
          <div class="d-inline-block box-dropdown-cart"><span class="font-lg icon-list icon-cart bx bx-cart text-white"><span>Cart</span><span
                class="number-item font-xs">{{ $cartItemCount }}</span></span>
            <div class="dropdown-cart">
            @foreach ($cartItems as $item)
              <div class="item-cart mb-20">
                <div class="cart-image"><img src="{{ $item['product']['image'] }}" alt="Ecom"></div>
                <div class="cart-info"><a class="font-sm-bold color-brand-3" href="{{ route('product.show', $item['product']['slug']) }}">{{ $item['product']['name'] }}</a>
                  <p><span class="color-brand-2 font-sm-bold">{{ $item['quantity'] }} x ₹{{ number_format($item['price'], 2) }}</span></p>
                </div>
              </div>
              @endforeach
              <div class="border-bottom pt-0 mb-15"></div>
              <div class="cart-total">
                <div class="row">
                  <div class="col-6 text-start"><span class="font-md-bold color-brand-3">Total</span></div>
                  <div class="col-6"><span class="font-md-bold color-brand-1">₹ {{ $cartTotalPrice }}</span></div>
                </div>
                <div class="row mt-15">
                  <div class="col-6 text-start"><a class="btn btn-cart w-auto" href="{{ route('cart.index') }}">View cart</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</header>
<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
  <div class="mobile-header-wrapper-inner">
    <div class="mobile-header-content-area">
      <div class="mobile-logo"><a class="d-flex" href="{{ route('welcome') }}"><img alt="Ecom"
            src="{{ $companySettings['company_logo'] }}"></a></div>
      <div class="perfect-scroll">
        <div class="mobile-menu-wrap mobile-header-border">
          <nav class="mt-15">
            <ul class="mobile-menu font-heading text-black">
              <li class=""><i class="bx bx-chevron-right me-2 fs-3 align-middle"></i><a class="active text-black" href="{{ route('welcome') }}">Home</a></li>
              <li class=""><i class="bx bx-chevron-right me-2 fs-3 align-middle"></i><a class="active text-black" href="{{ route('product.shop') }}">Shop</a></li>
              <li class="has-children"><i class="bx bx-chevron-right me-2 fs-3 align-middle"></i><a class=" text-black" href="shop-vendor-list.html">Vendors</a>
                <ul class="sub-menu">
                  <li><a class="text-black" href="shop-vendor-list.html">Vendors Listing</a></li>
                  <li><a class="text-black" href="shop-vendor-single.html">Vendor Single</a></li>
                </ul>
              </li>
              <li><i class="bx bx-chevron-right me-2 fs-3 align-middle"></i><a class="text-black" href="page-contact.html">Contact</a></li>
            </ul>
          </nav>
        </div>
        <div class="mobile-account">
          @if(Auth::guard('customer')->check())
          <div class="mobile-header-top">
            <div class="user-account"><a href="{{ route('customer.dashboard') }}"><img src="{{ Auth::guard('customer')->user()->avatar }}"
                  alt="Ecom"></a>
              <div class="content">
                <h6 class="user-name text-black me-2">Hello<span class="text-black ms-2">{{ Auth::guard('customer')->user()->name }}!</span></h6>
              </div>
            </div>
          </div>
          @endif
          @if(Auth::guard('customer')->check())
          <ul class="mobile-menu">
            <li><i class="bx bx-chevron-right me-2 fs-3 align-middle"></i><a class="text-black" href="{{ route('customer.dashboard') }}">My Account</a></li>
            <li><i class="bx bx-chevron-right me-2 fs-3 align-middle"></i><a class="text-black" href="{{ route('customer.address') }}">Adresses</a></li>
            <li><i class="bx bx-chevron-right me-2 fs-3 align-middle"></i><a class="text-black" href="{{ route('customer.orders') }}">orders</a></li>
            <li><i class="bx bx-chevron-right me-2 fs-3 align-middle"></i><a class="text-black" href="{{ route('customer.settings') }}">Setting</a></li>
            <li><i class="bx bx-chevron-right me-2 fs-3 align-middle"></i><a class="text-black" href="{{ route('customer.logout') }}">Sign out</a></li>
          </ul>
          @endif
        </div>
        <div class="col-md-12 text-center"><span class="text-black fs-5"> &copy; {{ date('Y') }} {{ $companySettings['organization_name'] }} | {!! $companySettings['copyright'] !!}</span></div>
      </div>
    </div>
  </div>
</div>