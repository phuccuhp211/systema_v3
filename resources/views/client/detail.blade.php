@extends('layouts.base')

@section('title', $dtpd->name)

@section('ownlib')
    <link rel="stylesheet" href="{{ asset('css/main.css')}}">
    <script type="text/javascript" src="{{ asset('jquery/main.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <script type="text/javascript" src="{{ asset('jquery/detail.js') }}"></script>
@endsection

@section('content')
    <div class="sp-tt" id="sp-tt">
        <div class="container">
            <div class="row phan-tt-tren">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="khunganh-sp">
                        <img src="{{ $dtpd['img'] }}" class="anh-sp" alt="">
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="khungtt-sp">
                        <h2 class="ten-sp">{{ $dtpd['name'] }}</h2>
                        <ul class="tt-sp">
                            <li>Bảo hành: 36 Tháng</li>
                            <li>Xuất xứ: Chính hãng</li>
                            <li>Thương hiệu: {{ $dtpd['brand'] }}</li>
                        </ul>
                        <span class="mieuta-sp">Đã Bán : {{ $dtpd['saled'] }}</span><br>
                        <span class="mieuta-sp">{{ $dtpd['info'] }}</span>
                        <div class="gia-mua-sp">
                            @if ($dtpd['sale'] == 0)
                                <h2 class="gia-sp">Giá : {{ number_format($dtpd['price'],0,'','.') }}</h2>
                            @else
                                <h2 class="gia-sp">Giá : {{ number_format($dtpd['sale'],0,'','.') }}</h2>
                            @endif
                            <div style="margin: 15px 0;">
                                <label for="">Số Lượng : </label><input type="number" min="1" value="1" class="ctsp-sl">
                            </div>
                            <a href="{{ route('cart.buy', ['id' => $dtpd['id']]) }}" class="nut-muasp buy">Mua Ngay</a>
                            <button class="nut-muasp add addcart" id="uidsp" style="margin: 15px 0 0;" data-idsp="{{ $dtpd['id'] }}">Thêm Giỏ Hàng</button>
                        </div>
                    </div>  
                </div>
            </div>
            @if ($dtpd['detail'] && $dtpd['detail'] != '')
            <div class="row phan-tt-duoi">
                <div class="col-12 khungttct-sp">
                    <h2>THÔNG TIN CHI TIẾT</h2>
                    <div class="ttct-sp">
                        {!! $dtpd['html'] !!}
                        <button class="more-less">Xem thêm</button>                         
                    </div>      
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="binhluan">
        <div class="container"><hr>
            <div class="row">
                <div class="col-12">
                    <div class="title-cmt">
                        <h4>ĐÁNH GIÁ SẢN PHẨM</h3>
                    </div>
                </div>
                @if (!session()->has('user_log'))
                <div class="col-8 text-center">
                    <button class="ycdn-cmt">Vui lòng đăng nhập để Bình luận & Đánh giá</button>
                </div>
                @else
                <div class="col-8">
                    <form class="send-cmt">
                        <input type="text" id="noidung-cmt"></input>
                        <button type="submit">Gửi</button>
                    </form>
                </div>
                @endif
                <div class="col-4">
                    <div class="box-stars">
                        @if (isset($btrt))
                            {!! $btrt !!}
                        @endif
                        @if (isset($pds))
                            {!! $pds !!}
                        @endif
                    </div>
                </div>                    
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="list-cmt">
                    @if (isset($lcmt[0]))
                        @foreach ($lcmt as $value => $item)
                        <div class="box-cmt">
                            <div class="avatar">
                                @if ($item['img'] != '')
                                <div class="avt-img"><img src="{{ $item['img'] }}" alt=""></div>
                                @else
                                <h5 class="avt-text">{{ substr($item['l_name'], 0, 1) }}</h5>
                                @endif
                            </div>
                            <div class="user-cmt">
                                <p class="uname-cmt">{{ $item['f_name']." ".$item['l_name'] }}</p>
                                <p class="date-cmt">{{ date("d-m-Y", strtotime($item['date'])) }}</p>
                            </div>
                            <div class="content-cmt">
                                <p>{{ $item['content'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    @endif
                    </div>
                </div>  
            </div><hr>
        </div>
    </div>

    <div class="pad_1">
        <div class="container">
            <h2 class="tieude">SẢN PHẨM LIÊN QUAN</h2>
            <div class="row" id="list-sanpham">
                {!! showsp($rlpd,'col-20pt') !!}
            </div>              
        </div>
    </div>
@endsection