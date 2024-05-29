@extends('layouts.base')

@section('title', 'Tải Khoản')

@section('ownlib')
    <link rel="stylesheet" href="{{ asset('css/config.css') }}">
    <script type="text/javascript" src="{{ asset('jquery/config.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <h2>Quản Lý Tài Khoản</h2>
        <div class="row">
            <div class="col-12 position-relative">
                <button class="btn-config cf-acc btn-hidden">&#8592; Thiết Lập Tài Khoản</button>
                <button class="btn-config his-mh" style="float: right;">Lịch Sử Mua Hàng &#8594;</button>
            </div>
        </div>
        <hr>
    </div>
    
    <div class="container">
        <div class="cf-slide">
            <div class="cf-trans box-qltk">
                <div class="row">
                    <div class="col-12 text-center">
                        @if ($header['user']['img'] != '')
                        <img class="user-avt" src="{{ $header['user']['img'] }}" alt="">
                        @else
                        <img class="user-avt" src="{{ asset('/data').'/avatar.png' }}" alt="">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div hidden class="cf-id">{{ $header['user']['id'] }}</div>
                    <div hidden class="old-fn">{{ $header['user']['f_name'] }}</div>
                    <div hidden class="old-ln">{{ $header['user']['l_name'] }}</div>
                    <div hidden class="old-pn">{{ $header['user']['number'] }}</div>
                    <div hidden class="old-em">{{ $header['user']['email'] }}</div>
                    <div hidden class="old-ad">{{ $header['user']['address'] }}</div>

                    <div class="w-100"><h5 class="popup text-center text-white rounded p-2 m-0"></h5></div>
    
                    <div class="mt-4">
                        <div style="display: flex;background: #e0e0e0;padding: 30px 15px;border-radius: 10px;">
                            <div class="col-6">
                                <div class="box-cf">
                                    <label>Tên Tài Khoản :</label>
                                    <input type="text" class="cf_all cf_user" disabled value="{{ $header['user']['account'] }}">
                                </div>
                                <div class="box-cf">
                                    <label>Họ</label>
                                    <input type="text" class="cf_all cf_fn" value="{{ $header['user']['f_name'] }}">
                                </div>
                                <div class="box-cf">
                                    <label>Tên </label>
                                    <input type="text" class="cf_all cf_ln" value="{{ $header['user']['l_name'] }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="box-cf">
                                    <label>Số Điện Thoại :</label>
                                    <input type="number" class="cf_all cf_pn" value="{{ $header['user']['number'] }}">
                                </div>
                                <div class="box-cf">
                                    <label>Email :</label>
                                    <input type="text" class="cf_all cf_em" value="{{ $header['user']['email'] }}">
                                </div>
                                <div class="box-cf">
                                    <label>Địa Chỉ :</label>
                                    <input type="text" class="cf_all cf_ad" value="{{ $header['user']['address'] }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="offset-4 col-4">
                        <button class="btn btn-primary cf-button mb-2 cf-dmk">Đổi Mật Khẩu</button>
                    </div>
                    <div class="offset-4 col-4">
                        <button class="btn btn-success cf-button cf-update disabled">Cập Nhật</button>
                    </div>
                </div>
            </div>
            <div class="cf-trans box-lsmh">
                <div class="row">
                    <div class="col-12">    
                    @if (!isset($list_ins[0]))
                        <h4 class="bg-danger text-white p-2 rounded text-center m-0">Không có đơn mua hàng</h4>
                    @else
                        @foreach ($list_ins as $value => $item)
                            @php $list = json_decode($item['list_pd'],true) @endphp
                            <table class="mb-5">
                                <tr>
                                    <th style="width: 15%;">Mã Hóa Đơn</th>
                                    <th style="width: 15%;">Ngày Lập Hóa Đơn</th>
                                    <th style="width: 15%;">Ngày Xác Nhận</th>
                                    <th style="width: 25%;">Tổng Tiền</th>
                                    <th style="width: 15%;">Trạng Thái</th>
                                    <th style="width: 15%;">PTTT</th>
                                </tr>
                                <tr>
                                    <td class="text-center">{{ $item['in_num'] }}</td>
                                    <td class="text-center">{{ $item['created'] }}</td>
                                    <td class="text-center">{{ $item['submited'] }}</td>
                                    <td class="text-center text-danger">{{ $item['price'] }}</td>
                                    <td class="text-center">{{ $item['status'] }}</td>
                                    <td class="text-center">{{ $item['method'] }}</td>
                                </tr>
                                <tr class="h-list-sp">
                                    <td colspan="6">Danh Sách Sản Phẩm</td>
                                </tr>
                                <tr class="h-list-sp">
                                    <td colspan="3">Tên Sản Phẩm</td>
                                    <td>Đơn Giá</td>
                                    <td>Số Lượng</td>
                                    <td>Thành Tiền</td>
                                </tr>
                                @foreach ($list as $value2 => $item2) { ?>
                                    <tr class="list-sp">
                                        <td colspan="3">{{ $item2['name'] }}</td>
                                        <td>
                                        @if ($item2['sale'] != 0)
                                            {{ number_format($item2['sale'],0,'','.') }}
                                        @else
                                            {{ number_format($item2['price'],0,'','.') }}
                                        @endif
                                        </td>
                                        <td>{{ $item2['quantity'] }}</td>
                                        <td class="text-danger">{{ number_format($item2['total'],0,'','.') }}</td>
                                    </tr>
                                @endforeach
                            </table>  
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection