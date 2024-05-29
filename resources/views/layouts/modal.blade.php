    @if (!session()->has('user_log'))
        <div class="bg-dndk hide-bg-dndk">
            <div class="dndk">
                <h2 class="text-center m-0">Đăng Nhập</h2>
                <form class="client_login" enctype="multipart/form-data">
                    @csrf
                    <h4 class="sisu-err bg-danger text-center mx-0 my-2 rounded p-1"></h4>
                    <div class="field-add">
                        <label>Tài Khoản :</label>
                        <input type="text" name="acc">
                    </div>
                    <div class="field-add">
                        <label>Mật Khẩu :</label>
                        <input type="password" name="pass">
                    </div>
                    <div class="field-add"><a href="{{ url('/fgpass') }}" class="a-quenmk">Quên mật khẩu ?</a></div>
                    <div class="field-add">
                        <button class="btn btn-success" type="submit">Đăng Nhập</button>
                    </div>
                </form><hr>
                <div class="field-add">
                    <button class="btn btn-info users2">Hoặc Đăng Ký</button>
                </div>
                <div class="field-add" style="margin:0;">
                    <button class="btn btn-danger quaylai-dndk">Quay Lại</button>
                </div>
            </div>
        </div>
        <div class="bg-dndk2 hide-bg-dndk2">
            <div class="dndk2">
                <h2 class="text-center">Đăng Ký</h2>
                <form class="client_regis" enctype="multipart/form-data">
                    @csrf
                    <h4 class="sisu-err bg-danger text-center mx-0 my-2 rounded p-1"></h4>
                    <div class="field-add">
                        <label>Tài Khoản :</label>
                        <input type="text" name="acc">
                    </div>
                    <div class="db-field-add">
                        <div class="field-add">
                            <label>Họ :</label>
                            <input type="text" name="fname">
                        </div>
                        <div class="field-add">
                            <label>Tên :</label>
                            <input type="text" name="lname">
                        </div>        
                    </div>
                    <div class="db-field-add">
                        <div class="field-add">
                            <label>Email :</label>
                            <input type="text" name="email">
                        </div>
                        <div class="field-add">
                            <label>Số điện thoại :</label>
                            <input type="number" name="phone">
                        </div>        
                    </div>
                    <div class="field-add">
                        <label>Địa chỉ :</label>
                        <input type="text" name="addr">
                    </div>
                    <div class="field-add">
                        <label>Mật Khẩu :</label>
                        <input type="password" name="pass1">
                    </div>
                    <div class="field-add">
                        <label>Nhập Lại Mật Khẩu :</label>
                        <input type="password" name="pass2">
                    </div>
                    <div class="field-add">
                        <button class="btn btn-success" type="submit">Đăng Ký</button>
                    </div>
                </form><hr>
                <div class="field-add" style="margin:0;">
                    <button class="btn btn-danger quaylai-dndk2">Quay Lại</button>
                </div>
            </div>
        </div>
    @else
        <div class="bg-dmk hide-bg-dmk">
            <div class="dmk">
                <h2 class="text-center text-white">Đổi Mật Khẩu</h2>
                <form class="client_checkpw" enctype="multipart/form-data">
                    @csrf
                    <h5 class="popup text-center text-white rounded p-2 m-0"></h5>
                    <input type="text" value="{{ $header['user']['id'] }}" hidden name="id">
                    <div class="field-add field-oldpw">
                        <label>Nhập mật khẩu hiện tại:</label>
                        <input type="password" name="oldpw">
                    </div>
                    <div class="field-add field-newpw field-disable">
                        <label>Mật khẩu mới:</label>
                        <input type="password" name="newp1">
                    </div>
                    <div class="field-add field-newpw field-disable">
                        <label>Nhập lại mật khẩu mới:</label>
                        <input type="password" name="newp2">
                    </div>
                    <div class="field-add">
                        <button type="submit" class="btn btn-dark text-white">Xác Nhận</button>
                    </div>
                </form><hr>
                <div class="field-add" style="margin:0;">
                    <button class="btn btn-danger quaylai-dmk">Quay Lại</button>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('login_err'))
        <div class="bg-dndk-err">
            <div class="dndk-err">
                <span>{{ session('login_err') }}</span><hr>
                <button class="btn btn-danger quaylai-dndk">Quay Lại</button>
            </div>
        </div>
        {{ session()->forget('login_err') }}
    @endif

    @if (session()->has('udone2'))
        <div class="bg-dndk-err">
            <div class="dndk-err">
                <span>{{ session('udone2') }}</span><hr>
                <button class="btn btn-danger quaylai-dndk">Quay Lại</button>
            </div>
        </div>
        {{ session()->forget('udone2') }}
    @endif
    
    <div class="ttgh ttgh-hide">
        <div>
            <i class="fa-solid fa-circle-check"></i>
            <h2>Đã thêm vào giỏ hàng</h2>
        </div>
    </div>