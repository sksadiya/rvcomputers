<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('translation.Menu')</li>
                <li>
                    <a href="{{ route('root') }}" class="waves-effect">
                        <i class="bx bx-list-ul"></i>
                        <span key="t-yajra-datatable">Dashboard</span>
                    </a>
                </li>
                <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-list-ul"></i>
                                <span>Product</span>
                            </a>
                            <ul class="sub-menu mm-collapse" aria-expanded="false">
                                <li><a href="{{ route('category.index') }}">Category</a></li>
                                <li><a href="{{ route('brand.index') }}">Brand</a></li>
                                <li><a href="{{ route('color.index') }}">Color</a></li>
                                <li><a href="{{ route('tax.index') }}">Tax Group</a></li>
                                <li><a href="{{ route('coupon.index') }}">Coupons</a></li>
                            </ul>
                        </li>
                        <li class="menu-title" key="t-apps">ADDRESS</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-map"></i>
                        <span>Address</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false">
                        <li><a href="{{ route('country.index') }}">Country</a></li>
                        <li><a href="{{ route('state.index') }}">State</a></li>
                        <li><a href="{{ route('city.index')}}">City</a></li>
                    </ul>
                </li>
                <li class="menu-title" key="t-apps">MEDIA</li>
                <li>
                    <a href="{{ route('media.index')}}" class="waves-effect">
                        <i class="bx bx-envelope"></i>
                        <span>Media</span>
                    </a>
                </li>
                
                <li class="menu-title" key="t-apps">SETTINGS</li>
                <li>
                    <a href="{{ route('mail.index')}}" class="waves-effect">
                        <i class="bx bx-envelope"></i>
                        <span>Mail</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.index')}}" class="waves-effect">
                        <i class="bx bx-store"></i>
                        <span>Company</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->