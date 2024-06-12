@extends('layouts.base')

@section('title', 'Giỏ Hàng')

@section('ownlib')
    <link rel="stylesheet" href="{{ asset('css/main.css')}}">
    <script type="text/javascript" src="{{ asset('jquery/main.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <script type="text/javascript" src="{{ asset('jquery/cart.js') }}"></script>
@endsection

@section('content')
    <div class="container" style="margin: 30px auto; min-height: 50vh;">
        <div class="row">
            <table id="listcart">
                <tr id="theader" name="theader">
                    <th>STT</th>
                    <th>IMG</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Số Lượng</th>
                    <th>Thành Tiền</th>
                    <th>Xóa</th>
                </tr>
                @if (isset(session('cart')['list'][0]))
                    @foreach (session('cart')['list'] as $value => $item)
                    <tr class="sanpham" name="sanpham" id="sanpham">
                        <td hidden id="id">{{ $item['id'] }}</td>
                        <td style="width : 50px;" class="text-center" id="keysp">{{ $value+1 }}</td>
                        <td style="width : 150px;" class="text-center"><img src="{{ $item['img'] }}"></td>
                        <td style="width : auto;">{{ $item['name'] }}</td>
                        <td style="width : 150px;" name="giasp" id="giasp">{{ gennum($item['pfn']) }}</td>
                        <td style="width : 80px;" class="text-center">
                            <input type="number" min="1" value="{{ $item['num'] }}" name="slsp">
                        </td>
                        <td style="width : 150px;" id="thanhtien">{{ gennum($item['sum']) }}</td>
                        <td style="width : 70px;" class="text-center"><button class="btn btn-danger xoasp" name="xoasp" data-key="{{ $value }}"><i class="fa-solid fa-trash"></i></i></button></td>
                    </tr>
                    @endforeach
                    <tr id="sanpham">
                        <td colspan="5" style="color: red; font-weight: bold; text-align : center;">Tổng tiền :</td>
                        <td colspan="2" style="color: red; font-weight: bold;" id="ttfn">
                            {{ gennum(session('cart')['total']) }}
                        </td>
                    </tr>
                @else
                    <tr id="emptycart"><th colspan="7">Bạn không có sản phẩm nào trong giỏ hàng</th></tr>
                @endif
            </table>
        </div>
        @if (isset(session('cart')['list'][0]))
            <div class="row" id="sanpham" style="margin: 15px 0 0;">
                <div class="col-4 offset-4">
                    <a href="{{ route('pay') }}" class="w-100 btn btn-success">Bắt Đầu Thanh Toán</a>
                </div>
            </div>
            <div class="row" style="margin: 15px 0 0;">
                <div class="col-4 offset-4">
                    <button class="w-100 btn btn-danger delallcart">Xóa Giỏ Hàng</button>
                </div>
            </div>
        @endif
    </div>
@endsection