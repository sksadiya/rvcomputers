<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('root') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/images/logo.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="17">
                    </span>
                </a>

                <a href="{{ route('root') }}" class="logo logo-light">
                    <span class="logo-sm d-none">
                    <img class="rounded-circle avatar-sm" alt="200x200" src="{{ URL::asset('assets/images/users/user-dummy-img.jpg') }}" data-holder-rendered="true">
                    </span>
                        @if(Auth::user()->avatar)
                        <span class="logo-lg">
                            <img class="rounded-circle avatar-sm" alt="Default Avatar" src="{{ Auth::user()->avatar }}" data-holder-rendered="true">
                        </span>
                        @else 
                        <span class="logo-lg">
                            <img class="rounded-circle avatar-sm" alt="Default Avatar" src="{{ asset('assets/images/users/user-dummy-img.jpg') }}" data-holder-rendered="true">
                        </span>
                        @endif
                </a>

            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

           <!-- App Search-->
           <!-- <form class="app-search d-none d-lg-block">
            <div class="position-relative">
                <input type="text" class="form-control" placeholder="@lang('translation.Search')">
                <span class="bx bx-search-alt"></span>
            </div>
        </form> -->
       
        <div class="dropdown dropdown-mega d-none d-lg-block ms-2">
            <button  class="btn header-item waves-effect " >
              <a href="{{ route('welcome')}}" class="text-muted"> <span key="t-megamenu">Home</span></a> 
            </button>
        </div>
    </div>

    <div class="d-flex">

        <div class="dropdown d-inline-block d-lg-none ms-2">
            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-magnify"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                aria-labelledby="page-header-search-dropdown">

                <form class="p-3">
                    <div class="form-group m-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="@lang('translation.Search')" aria-label="Search input">

                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if(Auth::user()->avatar)
                <img class="rounded-circle header-profile-user" src="{{ Auth::user()->avatar }}"
                    alt="Header Avatar">
                    @else
                    <img class="rounded-circle header-profile-user" src="{{ URL::asset('assets/images/users/user-dummy-img.jpg') }}"
                    alt="Header Avatar">
                    @endif
                <span class="d-none d-xl-inline-block ms-1" key="t-henry"></span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a class="dropdown-item" href="{{ route('admin.profile')}}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">@lang('translation.Profile')</span></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}" ><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">@lang('translation.Logout')</span></a>
            </div>
        </div>
    </div>
</div>
</header>

