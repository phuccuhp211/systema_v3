@extends('layouts.base')

@section('title','Trang Chủ')

@section('ownlib')
    <link rel="stylesheet" href="{{ asset('css/main.css')}}">
    <script type="text/javascript" src="{{ asset('jquery/main.js')}}"></script>
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
                        <img src="{{ genurl($banners[$i]['img']) }}" alt="Image {{ $i }}" class="w-100">
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
    <div class="container pad_1" id="list-sanpham">
        @foreach ($full_ss as $value => $item)
            @php
                $xemthem = '';
                if ($item['title']['id_cata_1'] != '') $xemthem = route('show', ['type' => 'cat1', 'data' => $item['title']['id_cata_1']]);
                else if ($item['title']['id_cata_2'] != '') $xemthem = route('show', ['type' => 'cat2', 'data' => $item['title']['id_cata_2']]);
                else $xemthem = route('show', ['type' => 'all']);
            @endphp
            <div class="ss-sp">
                @if ($item['title']['eb_img'] == "")
                <h2 class="tieude">{{ $item['title']['name'] }}</h2>
                @endif

                @if ($item['title']['eb_img'] != "")
                <h2 class="tieude td-trans">{{ $item['title']['name'] }}</h2>
                @endif

                @if ($item['title']['poster'] != "")
                <div class="ss-poster"><img src="{{ genurl($item['title']['poster']) }}" alt=""></div>
                @endif

                <div class="row">
                    <div>
                        <div class="ebd_img" style="background: url({{ genurl($item['title']['eb_img']) }}) bottom; background-size:cover;">
                            <button class="click-pn click-prev"><i class="fa-solid fa-arrow-left"></i></button>
                            {!! showsp2($item['products'],'col-3','ss-1') !!}
                            <button class="click-pn click-next"><i class="fa-solid fa-arrow-right"></i></button>
                            <a href="{{ $xemthem }}" class="xemthem">Xem Thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach      
        <div class="static-ss">
            <div class="stss-tt" style="display: flex;">
                @foreach ($header['cat1'] as $value => $item)
                    <button class="stss-fttt index-cat" data-type="products/cat1" data="{{ $item['id'] }}">{{ $item['name'] }}</button>
                @endforeach
            </div>
            <div class="stss-ft" style="display: flex;">
                <button class="stss-fttt index-fil" data-type="products/all" data="" data-phanloai="1">Cũ Nhất</button>
                <button class="stss-fttt index-fil" data-type="products/all" data="" data-phanloai="2">Mới Nhất</button>
                <button class="stss-fttt index-fil" data-type="products/all" data="" data-phanloai="3">Giá Từ Thấp -> Cao</button>
                <button class="stss-fttt index-fil" data-type="products/all" data="" data-phanloai="4">Giá Từ Cao -> Thấp</button>
            </div>
            <div class="stss-sp" style="margin: 0;">
                <div class="row stss-list">
                    {!! showsp($product,'col-20pt') !!}
                </div>
                <a href="{{ route('show', ['type' => 'all']) }}" class="view-all stss-va">Xem Tất Cả</a></div>
            </div>
        </div>   
    </div>
@endsection