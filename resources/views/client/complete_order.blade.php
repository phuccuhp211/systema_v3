@extends('layouts.base')

@section('title', 'Hoàn Tất Thanh Toán')

@section('ownlib')
    <link rel="stylesheet" href="{{ asset('css/doneorder.css') }}">
    <script type="text/javascript" src="{{ asset('jquery/doneorder.js') }}"></script>
@endsection

@section('content')
    <div class="container hoantat">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="khung">
                    <h3 class="text-center">Đặt Hàng Thành Công</h3>
                    <h6>Cảm ơn Quý khách hàng vì đã tin tưởng và lựa chọn sản phẩm của cửa hàng chúng tôi. Đơn hàng của quý khách sẽ sớm được chuẩn bị nhanh nhất và sẽ được giao tới tận nơi. Chúc Quý khách hàng sẽ có được những trải nghiệm tuyệt vời nhất cùng với sản phẩm.</h6>
                    <h6>Thông tin hóa đơn sẽ được gửi tới Email của Quý Khách.</h6>
                    <h6>Quý khách vui lòng chú ý đến điện thoại và Email của mình.</h6>
                    <h6>Mọi thắc mắc xin vui lòng liên hệ: 1900 999 457.</h6>
                    <a class="text-center" href="{{ route('home') }}">Tiếp tục mua hàng</a>
                </div>
            </div>
        </div>
    </div>
@endsection