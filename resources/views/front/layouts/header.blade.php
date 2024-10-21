<header class="header header-container sticky-bar bg-black">
  <div class="container p-3">
    <div class="main-header">
      <div class="header-left justify-content-between">
        <div class="header-logo"><a href="index.html"><img alt="Ecom" src="{{ $companySettings['company_logo'] }}"></a></div>
        <div class="header-search">
          <div class="box-header-search bg-white">
            <form class="form-search" method="post" action="#">
              <div class="box-category">
                <select class="select-active select2-hidden-accessible" data-select2-id="1" tabindex="-1"
                  aria-hidden="true">
                  <option class="text-dark">All categories</option>
                  @foreach ($categories as $category)
                  <option class="text-dark" value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="box-keysearch">
                <input class="form-control font-xs" type="text" value="" placeholder="Search for items">
              </div>
            </form>
          </div>
        </div>
        <!-- <div class="header-nav text-start"> -->
          <div class="burger-icon burger-icon-white"><span class="burger-icon-top"></span><span
              class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
        <!-- </div> -->
        <div class="header-shop me-5">
          <div class="d-inline-block box-dropdown-cart"><span
              class="font-lg icon-list icon-account bx bx-user text-white"><span>Account</span></span>
            <div class="dropdown-account">
              <ul>
                <li><a href="page-account.html">My Account</a></li>
                <li><a href="page-account.html">Order Tracking</a></li>
                <li><a href="page-account.html">My Orders</a></li>
                <li><a href="page-account.html">My Wishlist</a></li>
                <li><a href="page-account.html">Setting</a></li>
                <li><a href="page-login.html">Sign out</a></li>
              </ul>
            </div>
          </div>
          <div class="d-inline-block box-dropdown-cart"><span class="font-lg icon-list icon-cart bx bx-cart text-white"><span>Cart</span><span
                class="number-item font-xs">2</span></span>
            <div class="dropdown-cart">
              <div class="item-cart mb-20">
                <div class="cart-image"><img src="assets/imgs/page/homepage1/imgsp5.png" alt="Ecom"></div>
                <div class="cart-info"><a class="font-sm-bold color-brand-3" href="shop-single-product.html">2022 Apple
                    iMac with Retina 5K Display 8GB RAM, 256GB SSD</a>
                  <p><span class="color-brand-2 font-sm-bold">1 x $2856.4</span></p>
                </div>
              </div>
              <div class="item-cart mb-20">
                <div class="cart-image"><img src="assets/imgs/page/homepage1/imgsp4.png" alt="Ecom"></div>
                <div class="cart-info"><a class="font-sm-bold color-brand-3" href="shop-single-product-2.html">2022
                    Apple iMac with Retina 5K Display 8GB RAM, 256GB SSD</a>
                  <p><span class="color-brand-2 font-sm-bold">1 x $2856.4</span></p>
                </div>
              </div>
              <div class="border-bottom pt-0 mb-15"></div>
              <div class="cart-total">
                <div class="row">
                  <div class="col-6 text-start"><span class="font-md-bold color-brand-3">Total</span></div>
                  <div class="col-6"><span class="font-md-bold color-brand-1">$2586.3</span></div>
                </div>
                <div class="row mt-15">
                  <div class="col-6 text-start"><a class="btn btn-cart w-auto" href="shop-cart.html">View cart</a></div>
                  <div class="col-6"><a class="btn btn-buy w-auto" href="shop-checkout.html">Checkout</a></div>
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
      <div class="mobile-logo"><a class="d-flex" href="index.html"><img alt="Ecom"
            src="assets/imgs/template/logo.svg"></a></div>
      <div class="perfect-scroll">
        <div class="mobile-menu-wrap mobile-header-border">
          <nav class="mt-15">
            <ul class="mobile-menu font-heading">
              <li class="has-children"><a class="active" href="index.html">Home</a>
                <ul class="sub-menu">
                  <li><a href="index.html">Homepage - 1</a></li>
                  <li><a href="index-2.html">Homepage - 2</a></li>
                  <li><a href="index-3.html">Homepage - 3</a></li>
                  <li><a href="index-4.html">Homepage - 4</a></li>
                  <li><a href="index-5.html">Homepage - 5</a></li>
                  <li><a href="index-6.html">Homepage - 6</a></li>
                  <li><a href="index-7.html">Homepage - 7</a></li>
                  <li><a href="index-8.html">Homepage - 8</a></li>
                  <li><a href="index-9.html">Homepage - 9</a></li>
                  <li><a href="index-10.html">Homepage - 10</a></li>
                </ul>
              </li>
              <li class="has-children"><a href="shop-grid.html">Shop</a>
                <ul class="sub-menu">
                  <li><a href="shop-grid.html">Shop Grid</a></li>
                  <li><a href="shop-grid-2.html">Shop Grid 2</a></li>
                  <li><a href="shop-list.html">Shop List</a></li>
                  <li><a href="shop-list-2.html">Shop List 2</a></li>
                  <li><a href="shop-fullwidth.html">Shop Fullwidth</a></li>
                  <li><a href="shop-single-product.html">Single Product</a></li>
                  <li><a href="shop-single-product-2.html">Single Product 2</a></li>
                  <li><a href="shop-single-product-3.html">Single Product 3</a></li>
                  <li><a href="shop-single-product-4.html">Single Product 4</a></li>
                  <li><a href="shop-cart.html">Shop Cart</a></li>
                  <li><a href="shop-checkout.html">Shop Checkout</a></li>
                  <li><a href="shop-compare.html">Shop Compare</a></li>
                  <li><a href="shop-wishlist.html">Shop Wishlist</a></li>
                </ul>
              </li>
              <li class="has-children"><a href="shop-vendor-list.html">Vendors</a>
                <ul class="sub-menu">
                  <li><a href="shop-vendor-list.html">Vendors Listing</a></li>
                  <li><a href="shop-vendor-single.html">Vendor Single</a></li>
                </ul>
              </li>
              <li class="has-children"><a href="#">Pages</a>
                <ul class="sub-menu">
                  <li><a href="page-about-us.html">About Us</a></li>
                  <li><a href="page-contact.html">Contact Us</a></li>
                  <li><a href="page-careers.html">Careers</a></li>
                  <li><a href="page-term.html">Term and Condition</a></li>
                  <li><a href="page-register.html">Register</a></li>
                  <li><a href="page-login.html">Login</a></li>
                  <li><a href="page-404.html">Error 404</a></li>
                </ul>
              </li>
              <li class="has-children"><a href="blog.html">Blog</a>
                <ul class="sub-menu">
                  <li><a href="blog.html">Blog Grid</a></li>
                  <li><a href="blog-2.html">Blog Grid 2</a></li>
                  <li><a href="blog-list.html">Blog List</a></li>
                  <li><a href="blog-big.html">Blog Big</a></li>
                  <li><a href="blog-single.html">Blog Single - Left sidebar</a></li>
                  <li><a href="blog-single-2.html">Blog Single - Right sidebar</a></li>
                  <li><a href="blog-single-3.html">Blog Single - No sidebar</a></li>
                </ul>
              </li>
              <li><a href="page-contact.html">Contact</a></li>
            </ul>
          </nav>
        </div>
        <div class="mobile-account">
          <div class="mobile-header-top">
            <div class="user-account"><a href="page-account.html"><img src="assets/imgs/template/ava_1.png"
                  alt="Ecom"></a>
              <div class="content">
                <h6 class="user-name">Hello<span class="text-brand"> Steven !</span></h6>
                <p class="font-xs text-muted">You have 3 new messages</p>
              </div>
            </div>
          </div>
          <ul class="mobile-menu">
            <li><a href="page-account.html">My Account</a></li>
            <li><a href="page-account.html">Order Tracking</a></li>
            <li><a href="page-account.html">My Orders</a></li>
            <li><a href="page-account.html">My Wishlist</a></li>
            <li><a href="page-account.html">Setting</a></li>
            <li><a href="page-login.html">Sign out</a></li>
          </ul>
        </div>
        <div class="mobile-banner">
          <div class="bg-5 block-iphone"><span class="color-brand-3 font-sm-lh32">Starting from $899</span>
            <h3 class="font-xl mb-10">iPhone 12 Pro 128Gb</h3>
            <p class="font-base color-brand-3 mb-10">Special Sale</p><a class="btn btn-arrow"
              href="shop-grid.html">learn more</a>
          </div>
        </div>
        <div class="site-copyright color-gray-400 mt-30">Copyright 2022 &copy; Ecom - Marketplace Template.<br>Designed
          by<a href="http://alithemes.com" target="_blank">&nbsp; AliThemes</a></div>
      </div>
    </div>
  </div>
</div>