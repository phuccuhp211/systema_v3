    <div class="full-menu">
        <nav class="navbar navbar-expand-md menu-chinh">
            <div class="container" style="display: unset;">
                <div class="row">
                    <div class="col-3">
                        <a href="{{ url('') }}" class="navbar-brand menu-logo-chinh"><img src="{{ asset('data/LOGO2.png') }}" alt=""></a>
                        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#menu-top">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="col-6 col-search">
                        <form action="{{ route('show', ['type' => 'search']) }}" method="POST" enctype="multipart/form-data" class="form-inline menu-khungtk">
                            @csrf
                            <input class="form-control search-box" name="data" type="text" placeholder="Tìm Kiếm..." data-type="sanpham/timkiem">
                            <button type="submit" class="btn btn-success menu-nuttk"><i class="fa fa-search"></i></button>
                        </form>
                        <div class="search-result">
                        </div>
                    </div>
                    <div class="col-3">
                        <ul class="navbar-nav menu-ghdndk">
                            <li class="nav-item">
                                <a href="{{ route('cart') }}" class="nav-link menu-chinh-li giohang">
                                    <i class="fa fa-shopping-cart"></i> Giỏ Hàng
                                </a>
                                <div class="popup-cart off-pocart" data-user="{{ (session()->has('user_log')) ? 'yes' : '' }}" data-cart="{{ (session()->has('cart')) ? (!empty(session('cart')['list']) ? 'yes' : '' ) : '' }}">
                                    <span>Có Sản Phẩm Trong Giỏ Hàng</span>
                                </div>
                            </li>
                            @if (!session()->has('user_log'))
                                <li class="nav-item">
                                    <button class="nav-link menu-chinh-li users">
                                        <i class="fas fa-user icon_setting"></i> Đăng Nhập
                                    </button>
                                </li>
                            @endif              
                        </ul>
                    </div>
                </div>
            </div>
            @if (session()->has('user_log'))
                <span class="span-popup">Xin chào<strong>
                    {{ $header['user']['name'] }}</strong>,
                    <a href="{{ route('config') }}" class="fa-solid fa-gear"></a> | 
                    <a href="{{ route('client', ['type' => 'logout']) }}" class="fa-solid fa-right-from-bracket"></a>
                </span>
                <span hidden id="ufn">{{ $header['user']['name'] }}</span>
                <span hidden id="uid">{{ $header['user']['id'] }}</span>
            @endif  
        </nav>
        <div class="menu-thucap">
            <nav class="navbar second-menu">
                <div class="container" style="display: unset;">
                    <div class="row">
                        <div class="col-12">
                            <div class="menu-chinh-li" id="show-dmsp">Danh Mục Sản Phẩm <i class="fa-solid fa-bars" style="font-size: 22px;"></i></div>
                            <a class="menu-chinh-li" href="{{ url('/baohanh/') }}">Bảo Hành</a>
                            <a class="menu-chinh-li" href="{{ url('/vanchuyen/') }}">Vận Chuyển</a>
                            <a class="menu-chinh-li" href="{{ url('/lienhe/') }}">Liên Hệ</a>
                            <a class="menu-chinh-li" href="{{ url('/hotro/') }}">Hỗ Trợ</a>
                            <a class="menu-chinh-li" href="{{ url('/invoice_check') }}">Tra Cứu Hóa Đơn</a>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="row" style="position: relative;">
                    <div class="col-12">
                        <div class="menu-cap2">
                            <li class="li-mnmn"><a href="{{ url('products/all').'/' }}" class="a-mnc2">Tất cả sản phẩm</a></li>
                            @foreach ($header['cat1'] as $value => $item)
                                <div class="thirt-menu">
                                    <li class="li-mnmn"><hr>
                                        <a href="{{ url('/products/cat1').'/'.$item['id'].'/' }}" class="a-mnc2">{{ $item['name'] }}</a>
                                    </li>
                                    @foreach ($header['cat2'] as $value2 => $item2)
                                        @if ($item['id'] == $item2['type'])
                                            <div class="menu-cap3">
                                                @foreach ($header['cat2'] as $value3 => $item3)
                                                    @if ($item['id'] == $item3['type'])
                                                        <li class="li-mnmn">
                                                            <a href="{{ url('/products/cat2').'/'.$item3['id'].'/' }}" class="a-mnc3">
                                                                {{ $item3['name'] }}
                                                            </a><hr>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>