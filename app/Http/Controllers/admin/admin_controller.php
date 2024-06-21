<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Access;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Catalog_1;
use App\Models\Catalog_2;
use App\Models\Comment;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Section;
use App\Models\Turn_rating;
use App\Models\User;
use App\Models\Voucher;

use DateTime;
use DateInterval;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class admin_controller extends Controller {
    private $datarp;
    private $rules = [
        'account' => 'required|min:6',
        'name' => 'required|min:3',
        'l_name' => 'required|min:3',
        'f_name' => 'required|min:3',
        'number' => 'required|min:8|max:11',
        'email' => 'required|email|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',
        'address' => 'required',
        'pass' => 'required|min:6',
        'info' => 'required',
        'id_cata_1' => 'required',
        'id_brand' => 'required',
        'price' => 'required|integer|min:1000',
        'amount' => 'required|integer|min:1',
        'img' => 'required|image|mimes:jpeg,png,jpg,gif,webg|max:8192',
    ];
    private $msgs = [
        'account' => 'Vui lòng nhập tên tài khoản, tối thiểu 6 ký tự',
        'name' => 'Vui lòng nhập tên, tối thiểu 3 ký tự.',
        'l_name' => 'Vui lòng nhập Tên, tối thiểu 3 ký tự',
        'f_name' => 'Vui lòng nhập Họ, tối thiểu 3 ký tự',
        'number' => 'Vui lòng nhập Số điện thoại, tối thiểu 8 số',
        'email' => 'Email là bắt buộc và đúng định dạng.',
        'address' => 'Vui lòng nhập địa chỉ.',
        'pass' => 'Vui lòng nhập mật khẩu, tối thiểu 6 ký tự.',
        'info' => 'Vui lòng nhập mô tả sản phẩm.',
        'id_cata_1' => 'Vui lòng chọn phân loại.',
        'id_brand' => 'Vui lòng chọn thương hiệu.',
        'price' => 'Bắt buộc nhập giá, thấp nhất là 1.000.',
        'amount' => 'Vui lòng nhập số lượng, tối thiểu là 1',
        'img' => 'Vui lòng chọn ảnh'
    ];

    function login() {
        return view('admin.login');
    }
    
    function manager(Request $rq, $type='') {
        if ($type != '') {
            if ($type == 'sections') {
                $this->datarp['list'] = Section::orderby('id','DESC')->get();
                $this->datarp['cat1'] = Catalog_1::get();
                $this->datarp['cat2'] = Catalog_2::get();
                $this->datarp['mng'] = 'sections';
            }
            else if ($type == 'slidebns') {
                $this->datarp['list'] = Banner::orderby('id','DESC')->get();
                $this->datarp['mng'] = 'slidebns';
            }
            else if ($type == 'products') {
                $this->datarp['mng'] = 'products';
                $this->datarp['list'] = Product::orderby('id','DESC')->get();
                $this->datarp['cat1'] = Catalog_1::get();
                $this->datarp['cat2'] = Catalog_2::get();
                $this->datarp['grap'] = Product::grap();
                $this->datarp['brands'] = Brand::get();
            }
            else if ($type == 'catalogs') {
                $this->datarp['list1'] = Catalog_1::orderby('id','DESC')->get();
                $this->datarp['list2'] = Catalog_2::orderby('id','DESC')->get();
                $this->datarp['mng'] = 'catalogs';
            }
            else if ($type == 'usersmng') {
                $this->datarp['list'] = User::orderby('id','DESC')->get();
                $this->datarp['mng'] = 'usersmng';
            }
            else if ($type == 'comments') {
                $this->datarp['list'] = Comment::get_list();
                $this->datarp['mng'] = 'comments';
            }
            else if ($type == 'invoices') {
                $this->datarp['list'] = Invoice::orderby('id','DESC')->get();
                $this->datarp['mng'] = 'invoices';
            }
            else if ($type == 'offers') {
                $this->datarp['list'] = Voucher::orderby('id','DESC')->get();
                $this->datarp['mng'] = 'offers';
            }
        }
        else {
            $this->datarp['mng'] = 'home';
            $this->datarp['revenue'] = Invoice::ttrev();
            $this->datarp['orders'] = Invoice::ttord();
            $this->datarp['members'] = User::count();
            $this->datarp['accesses'] = Access::count();
        }
        return view('admin.manager', $this->datarp);
    }

    function ss_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            Section::destroy($id);
            return redirect()->route('manager', ['type' => 'slidebns']);
        } 
        else {
            if ($rq->ajax()) {
                if (!$rq->has('eb_img') && $type == 'add' || $rq->has('poster') && !$rq->has('eb_img') && $type == 'add') {
                    $new_rule['eb_img'] = 'required|image|mimes:jpeg,png,jpg,gif,webg|max:8192';
                    $new_msgs['eb_img'] = 'Vui lòng chọn ảnh nền cho sections';
                }
                foreach ($this->rules as $key => $rule) {
                    if ($rq->has($key)) {
                        $new_rule[$key] = $rule;
                        $new_msgs[$key] = $this->msgs[$key];
                    }
                }
                unset($new_rule['id_cata_1'],$new_msgs['id_cata_1']);
                $validation = Validator::make($rq->all(), $new_rule, $new_msgs);
                if ($validation->fails()) {
                    $errors = $validation->errors();
                    foreach ($errors->all() as $error) {
                        $data['res'] .= "<li>$error</li>";
                    }
                }
                if ($type == 'add' && !$validation->fails()) {
                    $ss = $rq->all();

                    $eb_img = $rq->file('eb_img')->getClientOriginalName();
                    Storage::disk('custom')->putFileAs($rq->file('eb_img'), $eb_img);

                    if ($rq->has('poster')) {
                        $poster = $rq->file('poster')->getClientOriginalName();
                        Storage::disk('custom')->putFileAs($rq->file('poster'), $poster);
                    }
                    
                    $ss['eb_img'] = asset('data').'/'.$eb_img;
                    $ss['poster'] = (isset($poster)) ? asset('data').'/'.$poster : '';
                    Section::create($ss);
                    $data['status'] = true;
                    $data['res'] = "<span>Thêm Thành Công</span>";
                } 
                else if ($type == 'fix' && !$validation->fails()) {
                    $ss = $rq->all();
                    if (!$rq->has('neweb_img')) $ss['eb_img'] = $rq->input('oldeb_img');
                    else {
                        $eb_img = $rq->file('neweb_img')->getClientOriginalName();
                        Storage::disk('custom')->putFileAs($rq->file('neweb_img'), $eb_img);
                        $ss['eb_img'] = asset('data').'/'.$eb_img;
                    }
                    if (!$rq->has('newposter')) $ss['poster'] = $rq->input('oldposter');
                    else {
                        $eb_img = $rq->file('newposter')->getClientOriginalName();
                        Storage::disk('custom')->putFileAs($rq->file('newposter'), $eb_img);
                        $ss['poster'] = asset('data').'/'.$eb_img;
                    }

                    unset($ss['neweb_img'], $ss['oldeb_img'], $ss['newposter'], $ss['oldposter']);
                    Section::where('id', $rq->input('id'))->update($ss);
                    $data['status'] = true;
                    $data['res'] = "<span>Cập Nhật Thành Công</span>";
                }

                return response()->json($data);
            } 
            else return redirect()->route('manager', ['type' => 'slidebns']);
        }
    }

    function bn_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            Banner::destroy($id);
            return redirect()->route('manager', ['type' => 'slidebns']);
        } 
        else {
            if ($rq->ajax()) {
                if (!$rq->has('img') && $type == 'add') {
                    $new_rule['img'] = 'required|image|mimes:jpeg,png,jpg,gif,webg|max:8192';
                    $new_msgs['img'] = 'Vui lòng chọn ảnh';
                }
                foreach ($this->rules as $key => $rule) {
                    if ($rq->has($key)) {
                        $new_rule[$key] = $rule;
                        $new_msgs[$key] = $this->msgs[$key];
                    }
                }
                $validation = Validator::make($rq->all(), $new_rule, $new_msgs);
                if ($validation->fails()) {
                    $errors = $validation->errors();
                    foreach ($errors->all() as $error) {
                        $data['res'] .= "<li>$error</li>";
                    }
                }
                if ($type == 'add' && !$validation->fails()) {
                    $name = $rq->file('img')->getClientOriginalName();
                    Storage::disk('custom')->putFileAs($rq->file('img'), $name);

                    $banner = $rq->all();
                    $banner['img'] = asset('data').'/'.$name;
                    Banner::create($banner);
                    $data['status'] = true;
                    $data['res'] = "<span>Thêm Thành Công</span>";
                } 
                else if ($type == 'fix' && !$validation->fails()) {
                    $banner = $rq->all();
                    if (!$rq->hasFile('newimg')) $banner['img'] = $rq->input('oldimg');
                    else {
                        $name = $rq->file('newimg')->getClientOriginalName();
                        Storage::disk('custom')->putFileAs($rq->file('newimg'), $name);
                        $banner['img'] = asset('data').'/'.$name;
                    }
                    unset($banner['newimg'], $banner['oldimg']);
                    Banner::where('id', $rq->input('id'))->update($banner);
                    $data['status'] = true;
                    $data['res'] = "<span>Cập Nhật Thành Công</span>";
                }

                return response()->json($data);
            } 
            else return redirect()->route('manager', ['type' => 'slidebns']);
        }
    }

    function pd_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            Product::destroy($id);
            return redirect()->route('manager', ['type' => 'products']);
        } 
        else if ($type == 'fil') {
            $fil = $rq->input('filter');

            $list = Product::a_ajax($fil);

            foreach ($list as $value => $item) {
                $button ="";
                if($item['hidden'] == 0) {
                    $button = "<button class=\"btn btn-warning suaxoa hidden hidsp\" data-idsp=\"".$item['id']."\"><i class=\"fa-solid fa-eye-slash\"></i></button>";
                } 
                else {
                    $button = "<button class=\"btn btn-success suaxoa hidden unhidsp\" data-idsp=\"".$item['id']."\"><i class=\"fa-solid fa-eye\"></i></button>";
                }
                $data['res'] .= "
                    <tr class=\"sanpham\">
                        <td rowspan=\"2\" class=\"text-center\">".$item->id."</td>
                        <td rowspan=\"2\" class=\"text-center\"><img src=\"".genurl($item->img)."\" alt=\"\"></td>
                        <td rowspan=\"2\" id=\"tensp\">".$item->name."</td>
                        <td rowspan=\"2\" id=\"in4sp\" style=\"overflow-hidden\">".$item->info."</td>
                        <td id=\"min4sp\" hidden>".$item->detail."</td>
                        <td id=\"giasp\" class=\"text-center\">".gennum($item->price)."</td>
                        <td id=\"salesp\" class=\"text-center\">".gennum($item->sale)."</td>
                        <td rowspan=\"2\" class=\"text-center\">
                            <button class=\"btn btn-primary suaxoa sua suasp\" data-idsp=\"".$item->id."\"><i class=\"fa-solid fa-gear\"></i></button>
                            <button class=\"btn btn-danger suaxoa xoa xoasp\" data-idsp=\"".$item->id."\"><i class=\"fa-solid fa-trash\"></i></button>
                            $button
                        </td>
                    </tr>
                    <tr class=\"sanpham\">
                        <td colspan=\"2\">Đã bán : ".$item->saled."</td>
                    </tr>
                ";
            }

            return response()->json($data);
        }
        else if ($type == 'hid') {
            Product::where('id', $rq->input('id'))->update(['hidden' => $rq->input('data')]);
        }
        else {
            if ($rq->ajax()) {
                if (!$rq->has('img') && $type == 'add') {
                    $new_rule['img'] = 'required|image|mimes:jpeg,png,jpg,gif,webg|max:8192';
                    $new_msgs['img'] = 'Vui lòng chọn ảnh';
                }
                foreach ($this->rules as $key => $rule) {
                    if ($rq->has($key)) {
                        $new_rule[$key] = $rule;
                        $new_msgs[$key] = $this->msgs[$key];
                    }
                }
                $validation = Validator::make($rq->all(), $new_rule, $new_msgs);
                if ($validation->fails()) {
                    $errors = $validation->errors();
                    foreach ($errors->all() as $error) {
                        $data['res'] .= "<li>$error</li>";
                    }
                }
                if ($type == 'add' && !$validation->fails()) {
                    $name = $rq->file('img')->getClientOriginalName();
                    Storage::disk('custom')->putFileAs($rq->file('img'), $name);

                    $prod = $rq->all();
                    $prod['img'] = $name;
                    Product::create($prod);
                    $data['status'] = true;
                    $data['res'] = "<span>Thêm Thành Công</span>";
                } 
                else if ($type == 'fix' && !$validation->fails()) {
                    $prod = $rq->all();
                    if (!$rq->hasFile('newimg')) $prod['img'] = $rq->input('oldimg');
                    else {
                        $name = $rq->file('newimg')->getClientOriginalName();
                        Storage::disk('custom')->putFileAs($rq->file('newimg'), $name);
                        $prod['img'] = $name;
                    }
                    unset($prod['newimg'], $prod['oldimg']);
                    Product::where('id', $rq->input('id'))->update($prod);
                    $data['status'] = true;
                    $data['res'] = "<span>Cập Nhật Thành Công</span>";
                }
                return response()->json($data);
            } 
            else return redirect()->route('manager', ['type' => 'products']);
        }
    }

    function c1_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            Catalog_1::destroy($id);
            return redirect()->route('manager', ['type' => 'catalogs']);
        }
        else {
            if ($rq->ajax()) {
                foreach ($this->rules as $key => $rule) {
                    if ($rq->has($key)) {
                        $new_rule[$key] = $rule;
                        $new_msgs[$key] = $this->msgs[$key];
                    }
                }
                $validation = Validator::make($rq->all(),$new_rule,$new_msgs);
                if ($validation->fails()) {
                    $errors = $validation->errors();
                    foreach ($errors->all() as $error) {
                        $data['res'] .= "<li>$error</li>";
                    }
                }

                if ($type == 'add' && !$validation->fails()) {
                    Catalog_1::create($rq->all());
                    $data['status'] = true;
                    $data['res'] = "<span>Thêm Thành Công</span>";
                }
                else if ($type == 'fix' && !$validation->fails()) {
                    Catalog_1::where('id',$rq->input('id'))->update($rq->all());
                    $data['status'] = true;
                    $data['res'] = "<span>Cập Nhật Thành Công</span>";
                }
                return response()->json($data);
            }
            else return redirect()->route('manager', ['type' => 'catalogs']);
        }
    }

    function c2_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            Catalog_2::destroy($id);
            return redirect()->route('manager', ['type' => 'catalogs']);
        }
        else {
            if ($rq->ajax()) {
                foreach ($this->rules as $key => $rule) {
                    if ($rq->has($key)) {
                        $new_rule[$key] = $rule;
                        $new_msgs[$key] = $this->msgs[$key];
                    }
                }
                $validation = Validator::make($rq->all(),$new_rule,$new_msgs);
                if ($validation->fails()) {
                    $errors = $validation->errors();
                    foreach ($errors->all() as $error) {
                        $data['res'] .= "<li>$error</li>";
                    }
                }

                if ($type == 'add' && !$validation->fails()) {
                    Catalog_2::create($rq->all());
                    $data['status'] = true;
                    $data['res'] = "<span>Thêm Thành Công</span>";
                }
                else if ($type == 'fix' && !$validation->fails()) {
                    Catalog_2::where('id',$rq->input('id'))->update($rq->all());
                    $data['status'] = true;
                    $data['res'] = "<span>Cập Nhật Thành Công</span>";
                }
                return response()->json($data);
            }
            else return redirect()->route('manager', ['type' => 'catalogs']);
        }
    }

    function us_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            User::destroy($id);
            return redirect()->route('manager', ['type' => 'usersmng']);
        }
        else if ($type == 'fil') {
            $fil = $rq->input('filter');

            $list = User::a_ajax($fil);

            foreach ($list as $value => $item) {
                if($item['ban'] == 1) {
                    $button = "
                        <button class=\"btn btn-warning suaxoa ban banus\" data-idus=\"".$item->id."\">
                            <i class=\"fa-solid fa-ban\"></i>
                        </button>";
                }
                else {
                    $button = "
                        <button class=\"btn btn-success suaxoa ban unbanus\" data-idus=\"".$item->id."\">
                            <i class=\"fa-solid fa-check\"></i>
                        </button>";
                }

                $data['res'] .= "
                    <tr class=\"taikhoan\">
                        <td class=\"text-center\">".$item->id."</td>
                        <td id=\"tenus\">".$item->account."</td>
                        <td>".$item->f_name." ".$item->l_name."</td>
                        <td id=\"sdtus\">".$item['sdt']."</td>
                        <td id=\"emailus\" class=\"text-center\">".$item->email."</td>
                        <td id=\"roleus\" class=\"text-center\">".$item->role."</td>
                        <td class=\"text-center\">
                            <button class=\"btn btn-primary suaxoa sua suaus\" data-idus=\"".$item->id."\">
                                <i class=\"fa-solid fa-gear\"></i>
                            </button>
                            <button class=\"btn btn-danger suaxoa xoa xoaus\" data-idus=\"".$item->id."\">
                                <i class=\"fa-solid fa-trash\"></i>
                            </button>
                            $button
                        </td>
                    </tr>
                ";
            }

            return response()->json($data);
        }
        else if ($type == 'hid') {
            User::where('id',$rq->input('id'))->update([ 'lock' => $rq->input('data') ]);
        }
        else {
            if ($rq->ajax()) {
                foreach ($this->rules as $key => $rule) {
                    if ($rq->has($key)) {
                        $new_rule[$key] = $rule;
                        $new_msgs[$key] = $this->msgs[$key];
                    }
                }
                $validation = Validator::make($rq->all(),$new_rule,$new_msgs);
                if ($validation->fails()) {
                    $errors = $validation->errors();
                    foreach ($errors->all() as $error) {
                        $data['res'] .= "<li>$error</li>";
                    }
                }

                if ($type == 'add' && !$validation->fails()) {
                    $userData = $rq->all();
                    $userData['pass'] = Hash::make($rq->input('pass'));
                    User::create($userData);
                    $data['status'] = true;
                    $data['res'] = "<span>Thêm Thành Công</span>";
                }
                else if ($type == 'fix' && !$validation->fails()) {
                    $userData = $rq->all();
                    if ($rq->input('newpass') != null) $userData['pass'] = $rq->input('oldpass');
                    else $userData['pass'] = Hash::make($rq->input('newpass'));
                    unset($userData['newpass'],$userData['oldpass']);
                    User::where('id', $rq->input('id'))->update($userData);
                    $data['status'] = true;
                    $data['res'] = "<span>Cập Nhật Thành Công</span>";
                }
                return response()->json($data);
            }
            else return redirect()->route('manager', ['type' => 'usersmng']);
        }
    }

    function cm_mng (Request $rq, $type='', $id=null) {
        if ($type == 'detail') {
            $list = Comment::where('id_pd',$rq->input('id'))->get();
            return response()->json($list);
        }
        else if ($type == 'del') {
            Comment::destroy($id);
            return redirect()->route('manager', ['type' => 'comments']);
        }
    }

    function in_mng (Request $rq, $type='', $id=null) {
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'fix') {
            return response()->json($data);
        }
        else if ($type == 'fil') {
            $fil = $rq->input('filter');

            $list = Invoice::a_ajax($fil);

            foreach ($list as $value => $item) {
                $prods = json_decode($item->list, true);
                $rp = is_array($prods) ? count($prods) : 0;
                $coupon = $item['coupon'];
                $price = ($item['offers'] !== null) ?  gennum($item['offers'])."<br><span style=\"font-size: 12px; color: red;\">".$coupon."</span>" : gennum($item['price']);

                $data['res'] .= "
                    <tr class=\"hoadon\">
                        <td rowspan=\"$rp\" class=\"text-center p-0 id-hd\">".$item->id."</td>
                        <td rowspan=\"$rp\" class=\"text-start\" style=\"font-size:14px;\">
                            ".$item->name."<br>
                            ".$item->email."<br>
                            0".$item->number."<br>
                            ".$item->address."
                        </td>
                        <td class=\"text-start\">SL: ".$prods[0]['num']." | ".$prods[0]['name']."</td>
                        <td rowspan=\"$rp\" class=\"text-center p-0\">$price</td>
                        <td rowspan=\"$rp\" class=\"text-center\">
                            <select name=\"trangthai\" class=\"hd-stt form-control mb-1\" id=\"hd-stt\">
                                <option ".(($item->status == 'Đanh chờ xác nhận') ? 'selected' : '')." value=\"Đanh chờ xác nhận\">Đanh chờ xác nhận</option>
                                <option ".(($item->status == 'Chuẩn Bị') ? 'selected' : '')." value=\"Chuẩn Bị\">Chuẩn Bị</option>
                                <option ".(($item->status == 'Đang Giao') ? 'selected' : '')." value=\"Đang Giao\">Đang Giao</option>
                                <option ".(($item->status == 'Hoàn Thành') ? 'selected' : '')." value=\"Hoàn Thành\">Hoàn Thành</option>
                                <option ".(($item->status == 'Hủy') ? 'selected' : '')." value=\"Hủy\">Hủy</option>
                            </select>
                            <select name=\"thanhtoan\" class=\"hd-stt form-control mb-1\" id=\"hd-pstt\">
                                <option ".(($item->p_status == 0) ? 'selected' : '')." value=\"0\">Chưa Thanh Toán</option>
                                <option ".(($item->p_status == 1) ? 'selected' : '')." value=\"1\">Đã Thanh Toán</option>
                            </select>
                            <button class=\"btn btn-success d-block mt-1 mx-auto hd-update\" id=\"hd-update\">Cập Nhật</button>
                        </td>
                    </tr>
                ";
                for ($i = 1; $i < $rp ; ++$i) {
                    $data['res'] .="
                        <tr class=\"hoadon\">
                            <td style=\"text-align: left;\">SL: ".$prods[$i]['num']." | ".$prods[$i]['name']."</td>
                        </tr>
                    ";
                }
            }

            return response()->json($data);
        }
        else if ($type == 'upd') {
            Invoice::up_stt($rq->input('id'),$rq->input('stt'),$rq->input('pstt'));
        }
        else if ($type == 'del') {
            Invoice::destroy($id);
            return redirect()->route('manager', ['type' => 'invoices']);
        }
    }

    function cp_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            Voucher::destroy($id);
            return redirect()->route('manager', ['type' => 'offers']);
        }
        else {
            if ($rq->ajax()) {
                foreach ($this->rules as $key => $rule) {
                    if ($rq->has($key)) {
                        $new_rule[$key] = $rule;
                        $new_msgs[$key] = $this->msgs[$key];
                    }
                }
                $validation = Validator::make($rq->all(),$new_rule,$new_msgs);
                if ($validation->fails()) {
                    $errors = $validation->errors();
                    foreach ($errors->all() as $error) {
                        $data['res'] .= "<li>$error</li>";
                    }
                }

                if ($type == 'add' && !$validation->fails()) {
                    $coupon = $rq->all();
                    $coupon['remaining'] = $coupon['amount'];
                    Voucher::create($coupon);
                    $data['status'] = true;
                    $data['res'] = "<span>Thêm Thành Công</span>";
                }
                else if ($type == 'fix' && !$validation->fails()) {
                    Voucher::where('id',$rq->input('id'))->update($rq->all());
                    $data['status'] = true;
                    $data['res'] = "<span>Cập Nhật Thành Công</span>";
                }
                return response()->json($data);
            }
            else return redirect()->route('manager', ['type' => 'offers']);
        }
    }

}