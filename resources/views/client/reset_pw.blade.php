@extends('layouts.base')

@section('title', 'Quên Mật Khẩu')

@section('ownlib')
    <link rel="stylesheet" href="{{ asset('css/rspw.css') }}">
    <script type="text/javascript" src="{{ asset('jquery/rspw.js') }}"></script>
@endsection

@section('content')
    <div class="thongbao hide-tbtt">
        <div class="box-noidung">
            <h2>...Đang Xử Lý...</h2>
        </div>
    </div>

    <div class="container hoantat">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="khung f1">
                    <form action="{{ route('client', ['type' => 'fgpass']) }}" method="POST" enctype="multipart/form-data" id="send-code">
                        <h5 class="popup text-center text-white rounded p-2 m-0"></h5>
                        <h3>Lấy lại mật khẩu</h3>
                        <label for="tendn">Tên đăng nhập:</label>
                        <input type="text" name="tendn">
                        <p>Mã xác nhận sẽ được gửi tới Email đăng ký theo tài khoản của quý khách, vui lòng hãy kiểm tra Email của mình.</p>
                        <button class="btn btn-success">Gửi Mã Xác Nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection