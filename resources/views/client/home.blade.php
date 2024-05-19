@extends('layouts.base')

@section('title','Trang Chủ')

@section('ownlib')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script type="text/javascript" src="{{ asset('jquery/index.js') }}"></script>
@endsection

@section('content')
    <div class="banner">
        <div class="container">
            <div id="carousel-id" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    @for ($i = 0; $i < count($banners); $i++) 
                        <li data-bs-target="#carousel-id" data-bs-slide-to="{{$i}}" class="{{ ($i == 0) ? 'active' : ''}}"></li>
                    @endfor
                </ol>
                <div class="carousel-inner">
                    @for ($i = 0; $i < count($banners); $i++)
                    <div class="carousel-item {{ ($i == 0) ? 'active' : ''}}">
                        <img src="{{ $banners[$i]['img'] }}" alt="Image {{ $i }}" class="w-100">
                        <div class="carousel-caption">
                            @if ($banners[$i]['title'] != "")
                                <h3>{{ $banners[$i]['title'] }}</h3>
                            @endif
                            @if ($banners[$i]['text'] != "")
                                <p>{{ $banners[$i]['text'] }}</p>
                            @endif
                        </div>
                    </div>
                    @endfor
                </div>     
                <a class="carousel-control-prev" href="#carousel-id" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-id" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        </div>
    </div>
    <div class="poster">    
        <div class="container">
            <h1>Sản phẩm được quan tâm nhất </h1>
            <div class="row">
                @foreach($casepcs as $value => $item)
                <div class=" col-lg-6 poster_item">
                    <div class="khung-poster" style="background: url({{ url('/data/rd/').mt_rand(1,4).'.jpg' }}) bottom; background-size: cover ;">
                        <div class="bg-poster">
                            <img src="{{ $item['img'] }}" class="anh-poster" alt="">
                        </div>
                        
                        <div class="chu-poster">
                            {!! $item['html'] !!}
                            <a href="{{ url('/sanpham/chitiet/').$item['id'] }}" class="btn btn-outline-light">Xem thêm &raquo;</a>
                        </div>
                    </div>                    
                </div>
                @endforeach
            </div>               
        </div>
    </div>
    <div class="container pad_1" id="list-sanpham">
        @foreach ($full_ss as $value => $item)
            <div class="ss-sp">
                @if ($item['title']['eb_img'] == "")
                <h2 class="tieude">{{ $item['title']['name'] }}</h2>
                @endif

                @if ($item['title']['eb_img'] != "")
                <h2 class="tieude td-trans">{{ $item['title']['name'] }}</h2>
                @endif

                @if ($item['title']['poster'] != "")
                <div class="ss-poster"><img src="{{ $item['title']['poster'] }}" alt=""></div>
                @endif

                @if ($item['title']['eb_img'] == "")
                <div class="row">
                    <div>
                        <div class="ebd_img">
                            <button class="click-pn click-prev"><i class="fa-solid fa-arrow-left"></i></button>
                            {!! showsp2($item['products'],'col-20pt') !!}
                            <button class="click-pn click-next"><i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div>
                        <div class="ebd_img" style="background: url( {{ $item['tieude']['ebd_img'] }} ) bottom; background-size:cover;">
                            <button class="click-pn click-prev"><i class="fa-solid fa-arrow-left"></i></button>
                            {!! showsp2($item['products'],'col-3','ss-1') !!}
                            <button class="click-pn click-next"><i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @endforeach      
        <div class="static-ss">
            <div class="stss-tt" style="display: flex;">
                @foreach ($header['cat1'] as $value => $item)
                    <button class="stss-fttt index-cat" data-type="sanpham/danhmuc" data="{{ $item['id'] }}">{{ $item['name'] }}</button>
                @endforeach
            </div>
            <div class="stss-ft" style="display: flex;">
                <button class="stss-fttt index-fil" data-type="sanpham/tatca" data="" data-phanloai="1">Mới Nhất</button>
                <button class="stss-fttt index-fil" data-type="sanpham/tatca" data="" data-phanloai="2">Cũ Nhất</button>
                <button class="stss-fttt index-fil" data-type="sanpham/tatca" data="" data-phanloai="3">Giá Từ Thấp -> Cao</button>
                <button class="stss-fttt index-fil" data-type="sanpham/tatca" data="" data-phanloai="4">Giá Từ Cao -> Thấp</button>
            </div>
            <div class="stss-sp" style="margin: 0;">
                <div class="row stss-list">
                    {!! showsp($product,'col-20pt') !!}
                </div>
                <a href="{{ url('/sanpham/tatca') }}" class="view-all stss-va">Xem Tất Cả</a></div>
            </div>
        </div>   
    </div>
@endsection