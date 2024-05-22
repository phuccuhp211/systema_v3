@extends('layouts.base')

@section('title', $title)

@section('ownlib')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <script type="text/javascript" src="{{ asset('jquery/products.js') }}"></script>
@endsection

@section('content')
    <div class="khungto">
        <div class="container">
            <div class="row">
                <div class="col-3 menu-trai d-none d-lg-block d-md-block">
                    <h2 class="h2-title">Danh Mục</h2>
                    <div class="menu-trai-tong">
                        <div class="menu-khungboc">
                            @foreach ($header['cat1'] as $value => $item)
                            <div class="list-cap1">
                                <a href="{{ url('products/cat1').'/'.$item['id'] }}">{{ ucwords($item['name']) }}</a>
                                @foreach($header['cat2'] as $value2 => $item2)
                                    @if ($item['id'] == $item2['type'])
                                    <button class="show-list-btn">+</button>
                                    <div class="list-cap2">
                                        <ul>
                                            @foreach ($header['cat2'] as $value3 => $item3)
                                                @if ($item['id'] == $item3['type'])
                                                <li><a href="{{ url('products/cat2').'/'.$item['id'] }}">{{ strtoupper($item3['name']) }}</a></li>
                                                @endif
                                            @endforeach

                                        </ul>
                                    </div>
                                    @break
                                    @endif
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-9 ldssp">
                    <div class="row">
                        <div class="col-9">
                            @if (!isset($pgpd))
                                <h2 class="h2-title">Tất cả sản phẩm</h2>
                            @else
                                <h2 class="h2-title">{{ $pgpd }}</h2>
                            @endif
                        </div>
                        
                    </div>
                    <div class="row" id="list-sanpham">
                        {!! showsp($dtpd,'col-3') !!}
                    </div>
                    <div class="row">
                        <div style="display:flex; justify-content: center; margin: 30px 0 0;" id="list-pt">
                            {{ $dtpd->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection