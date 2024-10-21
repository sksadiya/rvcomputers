<footer class="footer bg-footer-homepage5 ">
      <div class="footer-1 bg-black">
        <div class="container-fluid px-5">
          <div class="row">
            <div class="col-lg-3 width-25 mb-30 text-white">
              <h4 class="mb-30 text-white">Contact</h4>
              <div class="font-md mb-20 "><strong class="font-md-bold">Address:</strong> {!! $companySettings['organization_address'] !!} </div>
              <div class="font-md mb-20 "><strong class="font-md-bold">Phone:</strong> <a href="tel:{{$companySettings['mobile_number']}}">{{$companySettings['mobile_number']}}</a> </div>
              <div class="font-md mb-20 "><strong class="font-md-bold">E-mail:</strong> <a href="mailto:{{ $companySettings['company_email']}}"></a>{{ $companySettings['company_email']}}</div>
              <div class="mt-30">
                @if($companySettings['facebook_url'])
                <a target="_blank" class="icon-socials icon-facebook" href="{{$companySettings['facebook_url']}}"></a> 
                @endif
                @if($companySettings['instagram_url'])
                <a  target="_blank" class="icon-socials icon-instagram" href="{{ $companySettings['instagram_url'] }}"></a>
                @endif
                @if($companySettings['twitter_url'])
                <a  target="_blank" class="icon-socials icon-twitter" href="{{ $companySettings['twitter_url'] }}"></a>
                @endif
                @if($companySettings['linkedin_url'])
                <a target="_blank" class="icon-socials icon-linkedin" href="{{ $companySettings['linkedin_url'] }}"></a>
                @endif
                @if($companySettings['youtube_url'])
                <a target="_blank" class="icon-socials icon-youtube" href="{{ $companySettings['youtube_url'] }}"></a>
                @endif
              </div>
            </div>
            <div class="col-lg-3 width-20 mb-30">
              <h4 class="mb-30 text-white">Categories</h4>
              <ul class="menu-footer p-0">
                @foreach ($categories as $category)
                <li><a href="#" class="text-white"><i class="bx bx-chevron-right me-2"></i>{{ $category->name }}</a></li>
                @endforeach
              </ul>
            </div>
            <div class="col-lg-3 width-16 mb-30">
              <h4 class="mb-30 text-white">Popular products</h4>
              <ul class="menu-footer p-0">
                @foreach ($products as $product)
                <li><a href="#" class="text-white"><i class="bx bx-chevron-right me-2"></i>{{ $product->name }}</a></li>
                @endforeach
              </ul>
            </div>
            <div class="col-lg-3 width-16 mb-30">
              <h4 class="mb-30 text-white">My account</h4>
              <ul class="menu-footer p-0">
                <li><a href="#" class="text-white"><i class="bx bx-chevron-right me-2"></i>Register</a></li>
                <li><a href="#" class="text-white"><i class="bx bx-chevron-right me-2"></i>Login</a></li>
                <li><a href="#" class="text-white"><i class="bx bx-chevron-right me-2"></i>Cart</a></li>
                <li><a href="#" class="text-white"><i class="bx bx-chevron-right me-2"></i>Orders</a></li>
              </ul>
            </div>
            <div class="col-lg-3 width-23">
              <h4 class="mb-30 text-white">App &amp; Payment</h4>
              <div>
                <p class="font-md text-white">Download our Apps and get extra 15% Discount on your first Order&mldr;!</p>
                <div class="mt-20"><a class="mr-10" href="#"><img src="{{ asset('assets/front/assets/imgs/template/appstore.png') }}" alt="Ecom"></a></div>
                <p class="font-md text-white mt-20 mb-10">Secured Payment Gateways</p><img src="{{ asset('assets/front/assets/imgs/template/payment-method.png') }}" alt="Ecom">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-black text-white">
        <div class="container justify-content-center align-items-center">
          <div class="footer-bottom ">
            <div class="row ">
              <div class="col-md-12 text-center"><span class="text-white fs-5"> &copy; {{ date('Y') }} {{ $companySettings['organization_name'] }} | {!! $companySettings['copyright'] !!}</span></div>
            </div>
          </div>
        </div>
      </div>
    </footer>