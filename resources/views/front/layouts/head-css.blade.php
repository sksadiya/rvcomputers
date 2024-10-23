<!-- Bootstrap Css -->
<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<style>
body {
  background-color: #f7f7f9;
}
.icon-cart {
  background-image: none;
}
.header .main-header .header-left .header-shop .icon-cart {
  background-image: none !important;
  font-size: 30px;
}
.header .main-header .header-left .header-shop .bx {
  background-image: none !important;
  font-size: 30px;
}
footer a , li a{
  color: #fff;
}
.footer .menu-footer li a { 
  background: none !important;
}
</style>

@yield('css')