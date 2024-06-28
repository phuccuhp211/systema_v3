<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ajax;

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

    function __construct() {
        if (session()->has('admin_log')) {
            $admin = User::where('account',session('admin_log'))->first();
            $this->datarp['permission'] = $admin->permission;
        }
    }

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
                $this->datarp['list'] = Product::limit(10)->orderby('id','DESC')->get();
                $this->datarp['pagin'] = $this->gen_pagin('pd',ceil(Product::count() / 10));
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
                $this->datarp['list'] = User::limit(10)->orderby('id','DESC')->get();
                $this->datarp['pagin'] = $this->gen_pagin('us',ceil(User::count() / 10));
                $this->datarp['mng'] = 'usersmng';
            }
            else if ($type == 'comments') {
                $this->datarp['list'] = Comment::get_list();
                $this->datarp['mng'] = 'comments';
            }
            else if ($type == 'invoices') {
                $this->datarp['list'] = Invoice::limit(10)->orderby('id','DESC')->get();
                $this->datarp['pagin'] = $this->gen_pagin('in',ceil(Invoice::count() / 10));
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
            $this->datarp['members'] = User::ttus();
            $this->datarp['accesses'] = Access::tttf();
        }
        return view('admin.manager', $this->datarp);
    }

    function ss_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            $data['status'] = true;
            Section::destroy($id);
        } 
        else {
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
                
                $ss['eb_img'] = $eb_img;
                $ss['poster'] = (isset($poster)) ? $poster : '';
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
                    $ss['eb_img'] = $eb_img;
                }
                if (!$rq->has('newposter')) $ss['poster'] = $rq->input('oldposter');
                else {
                    $eb_img = $rq->file('newposter')->getClientOriginalName();
                    Storage::disk('custom')->putFileAs($rq->file('newposter'), $eb_img);
                    $ss['poster'] = $eb_img;
                }

                unset($ss['neweb_img'], $ss['oldeb_img'], $ss['newposter'], $ss['oldposter']);
                Section::where('id', $rq->input('id'))->update($ss);
                $data['status'] = true;
                $data['res'] = "<span>Cập Nhật Thành Công</span>";
            }
        }
        return response()->json($data);
    }

    function bn_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            $data['status'] = true;
            Banner::destroy($id);
        } 
        else {
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
                $banner['img'] = $name;
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
                    $banner['img'] = $name;
                }
                unset($banner['newimg'], $banner['oldimg']);
                Banner::where('id', $rq->input('id'))->update($banner);
                $data['status'] = true;
                $data['res'] = "<span>Cập Nhật Thành Công</span>";
            }
        }
        return response()->json($data);
    }

    function pd_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            $data['status'] = true;
            Product::destroy($id);
        } 
        else if ($type == 'hid') {
            Product::where('id', $rq->input('id'))->update(['hidden' => $rq->input('data')]);
        }
        else {
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
        }
        return response()->json($data);
    }

    function c1_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            $data['status'] = true;
            Catalog_1::destroy($id);
        }
        else {
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
        }
        return response()->json($data);
    }

    function c2_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            $data['status'] = true;
            Catalog_2::destroy($id);
        }
        else {
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
                $c2 = $rq->all();
                if (!$rq->hasFile('newimg')) $c2['img'] = $rq->input('oldimg');
                else {
                    $name = $rq->file('newimg')->getClientOriginalName();
                    Storage::disk('custom')->putFileAs($rq->file('newimg'), $name);
                    $c2['img'] = $name;
                }
                unset($c2['newimg'], $c2['oldimg']);
                Catalog_2::where('id', $rq->input('id'))->update($c2);
                $data['status'] = true;
                $data['res'] = "<span>Cập Nhật Thành Công</span>";
            }
        }
        return response()->json($data);
    }

    function us_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            $data['status'] = true;
            User::destroy($id);
        }
        else if ($type == 'hid') {
            User::where('id',$rq->input('id'))->update([ 'lock' => $rq->input('data') ]);
        }
        else {
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
                $email = User::get_em($rq->input('email'));
                if ($email) $data['res'] .= "<li>Email đã được sử dụng</li>";
                else {
                    $userData = $rq->all();
                    $userData['pass'] = Hash::make($rq->input('pass'));
                    User::create($userData);
                    $data['status'] = true;
                    $data['res'] = "<span>Thêm Thành Công</span>";
                }
            }
            else if ($type == 'fix' && !$validation->fails()) {
                $userData = $rq->all();
                if ($rq->filled('newpass')) $userData['pass'] = Hash::make($rq->input('newpass'));
                else $userData['pass'] = $rq->input('oldpass');
                unset($userData['newpass'], $userData['oldpass']);
                User::where('id', $rq->input('id'))->update($userData);
                $data['status'] = true;
                $data['res'] = "<span>Cập Nhật Thành Công</span>";
            }
            
        }
        return response()->json($data);
    }

    function cm_mng (Request $rq, $type='', $id=null) {
        if ($type == 'detail') {
            $list = Comment::where('id_pd',$rq->input('id'))->get();
            return response()->json($list);
        }
        else if ($type == 'del') {
            Comment::destroy($id);
            return response()->json(['status' => true, 'res' => '']);
        }
    }

    function in_mng (Request $rq, $type='', $id=null) {
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'upd') {
            Invoice::up_stt($rq->input('id'),$rq->input('stt'),$rq->input('pstt'));
        }
        else if ($type == 'del') {
            $datarp['status'] = true;
            Invoice::destroy($id);
        }
        return response()->json($data);
    }

    function cp_mng (Request $rq, $type='', $id=null) {
        $new_rule = [];
        $new_msgs = [];
        $data['status'] = false;
        $data['res'] = '';

        if ($type == 'del') {
            $data['status'] = true;
            Voucher::destroy($id);
        }
        else {
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
                if ((filled($coupon['f_date']) && !filled($coupon['t_date'])) || (!filled($coupon['f_date']) && filled($coupon['t_date']))) {
                    $data['res'] .= "<li>Thời gian bắt đầu và kết thúc khuyến mãi phải được điền đầy đủ hoặc cả hai đều trống</li>";
                }
                else {
                    Voucher::create($coupon);
                    $data['status'] = true;
                    $data['res'] = "<span>Thêm Thành Công</span>";
                }
            }
            else if ($type == 'fix' && !$validation->fails()) {
                $coupon = $rq->all();
                if ((filled($coupon['f_date']) && !filled($coupon['t_date'])) || (!filled($coupon['f_date']) && filled($coupon['t_date']))) {
                    $data['res'] .= "<li>Thời gian bắt đầu và kết thúc khuyến mãi phải được điền đầy đủ hoặc cả hai đều trống</li>";
                }
                else {
                    Voucher::where('id',$rq->input('id'))->update($rq->all());
                    $data['status'] = true;
                    $data['res'] = "<span>Cập Nhật Thành Công</span>";
                }
                    
            }
        }
        return response()->json($data);
    }

    function gen_html($type,$list) {
        $html = '';

        if ($type == 'ss') {
            foreach ($list as $item) {
                $poster = ($item->poster != null) ? "<img src=\"".genurl($item->poster)."\">" : "Chưa Thiết Lập";
                $eb_img = ($item->eb_img != null) ? "<img src=\"".genurl($item->eb_img)."\">" : "Chưa Thiết Lập";
                
                $html .="
                    <tr class=\"record\">
                        <td hidden id=\"hidden-data\" data-fn=\"$item->name\" data-pt=\"$item->poster\" data-ep=\"$item->eb_img\" data-c1=\"$item->id_cata_1\" data-c2=\"$item->id_cata_2\" data-rf=\"$item->reference\" data-or=\"$item->orderby\" data-id=\"$item->index\"></td>
                        <td rowspan=\"2\" class=\"text-center p-0\">$item->id</td>
                        <td rowspan=\"2\" class=\"text-center\">$item->name</td>
                        <td rowspan=\"2\" class=\"text-center\">$poster</td>
                        <td rowspan=\"2\" class=\"text-center\">$eb_img</td>
                        <td class=\"text-center\">$item->id_cata_1</td>
                        <td class=\"text-center\">$item->reference</td>
                        <td rowspan=\"2\" class=\"text-center\">$item->index</td>
                        <td rowspan=\"2\" class=\"text-center\">
                            <button class=\"btn btn-primary btn-mini btn-crud fix suabc\" data-id=\"$item->id\"><i class=\"fa-solid fa-gear\"></i></button>
                            <button class=\"btn btn-danger btn-mini btn-crud del\" data-id=\"$item->id\" data-type=\"ss\"><i class=\"fa-solid fa-trash\"></i></button>
                        </td>
                    </tr>
                    <tr class=\"record\">
                        <td class=\"text-center\">$item->id_cata_2</td>
                        <td class=\"text-center\">$item->orderby</td>
                    </tr>
                ";
            }
        }

        else if ($type == 'bn') {
            foreach ($list as $item) {
                $html .= "
                    <tr class=\"record\">
                        <td hidden id=\"hidden-data\" data-im=\"$item->img\" data-tt=\"$item->tit\" data-ct=\"$item->ctn\"></td>
                        <td class=\"text-center p-0\">$item->id</td>
                        <td class=\"text-center\"><img src=\"".genurl($item->img)."\" alt=\"\"></td>
                        <td class=\"text-center\">$item->tit</td>
                        <td class=\"text-center\">
                            <button class=\"btn btn-primary btn-mini btn-crud fix suabn\" data-id=\"$item->id\" data-type=\"bn\"><i class=\"fa-solid fa-gear\"></i></button>
                            <button class=\"btn btn-danger btn-mini btn-crud del\" data-id=\"$item->id\" data-type=\"bn\"><i class=\"fa-solid fa-trash\"></i></button>
                        </td>
                    </tr>
                "; 
            }
        }

        else if ($type == 'pd') {
            foreach ($list as $item) {
                $button ="";
                if($item->hidden == 0) {
                    $button = "<button class=\"btn btn-warning btn-mini btn-crud hidden hidsp\" data-hid=\"$item->hidden\" data-id=\"$item->id\" data-type=\"pd\"><i class=\"fa-solid fa-eye-slash\"></i></button>";
                } 
                else {
                    $button = "<button class=\"btn btn-success btn-mini btn-crud hidden unhidsp\" data-hid=\"$item->hidden\" data-id=\"$item->id\" data-type=\"pd\"><i class=\"fa-solid fa-eye\"></i></button>";
                }
                $html .= "
                    <tr class=\"record\">
                        <td hidden id=\"hidden-data\" data-fn=\"$item->name\" data-im=\"$item->img\" data-if=\"$item->info\" data-c1=\"$item->id_cata_1\" data-c2=\"$item->id_cata_2\" data-br=\"$item->id_brand \" data-pr=\"$item->price\" data-sl=\"$item->sale\" data-sf=\"$item->f_date\" data-st=\"$item->t_date\"></td>
                        <td rowspan=\"2\" class=\"text-center\">$item->id</td>
                        <td rowspan=\"2\" class=\"text-center\"><img src=\"".genurl($item->img)."\" alt=\"\"></td>
                        <td rowspan=\"2\">$item->name</td>
                        <td rowspan=\"2\" style=\"overflow-hidden\">$item->info</td>
                        <td class=\"text-center\">".gennum($item->price)."</td>
                        <td class=\"text-center\">".gennum($item->sale)."</td>
                        <td rowspan=\"2\" class=\"text-center\">
                            <button class=\"btn btn-primary btn-mini btn-crud fix suasp\" data-id=\"$item->id\" data-type=\"pd\"><i class=\"fa-solid fa-gear\"></i></button>
                            <button class=\"btn btn-danger btn-mini btn-crud del\" data-id=\"$item->id\" data-type=\"pd\"><i class=\"fa-solid fa-trash\"></i></button>
                            $button
                        </td>
                    </tr>
                    <tr class=\"record\">
                        <td colspan=\"2\">Đã bán : $item->saled</td>
                    </tr>
                ";
            }
        }

        else if ($type == 'c1') {
            foreach ($list as $item) {
                $html .= "
                    <tr class=\"record\">
                        <td hidden id=\"hidden-data1\" data-fn=\"$item->name\"></td>
                        <td style=\"text-align: center;\">$item->id</td>
                        <td style=\"text-align: center;\">$item->name</td>
                        <td style=\"text-align: center;\">
                            <button class=\"btn btn-primary btn-mini btn-crud fix suapl\" data-id=\"$item->id\" data-type=\"c1\"><i class=\"fa-solid fa-gear\"></i></button>
                            <button class=\"btn btn-danger btn-mini btn-crud del\" data-id=\"$item->id\" data-type=\"c1\"><i class=\"fa-solid fa-trash\"></i></button>
                        </td>
                    </tr>
                ";
            }
        }

        else if ($type == 'c2') {
            foreach ($list as $item) {
                $img = ($item->img != NULL) ? "<img src=\"".genurl($item->img)."\" alt=\"\">" : '';
                $html .= "
                    <tr class=\"record\">
                        <td hidden id=\"hidden-data2\" data-fn=\"$item->name\" data-c1=\"$item->type\" data-im=\"$item->img\"></td>
                        <td style=\"text-align: center;\">$item->id</td>
                        <td style=\"text-align: center;\">$item->name</td>
                        <td style=\"text-align: center;\">$item->type</td>
                        <td style=\"text-align: center;\">$img</td>
                        <td style=\"text-align: center;\">
                            <button class=\"btn btn-primary btn-mini btn-crud fix suadm\" data-id=\"$item->id\" data-type=\"c2\"><i class=\"fa-solid fa-gear\"></i></button>
                            <button class=\"btn btn-danger btn-mini btn-crud del\" data-id=\"$item->id\" data-type=\"c2\"><i class=\"fa-solid fa-trash\"></i></button>
                        </td>
                    </tr>
                ";
            }
        }

        else if ($type == 'us') {
            foreach ($list as $item) {
                if($item->lock == 0) $button = "<button data-type=\"us\" class=\"btn btn-warning btn-mini btn-crud lock banus\" data-id=\"".$item->id."\"><i class=\"fa-solid fa-ban\"></i></button>";
                else $button = "<button data-type=\"us\" class=\"btn btn-success btn-mini btn-crud lock unbanus\" data-id=\"".$item->id."\"><i class=\"fa-solid fa-check\"></i></button>";

                if ($item->role == 1) {
                    if ($item->permission != NULL) $role = $item->permission;
                    else $role = 'noroot';
                }
                else $role = 'Khách Hàng';
                
                $html .= "
                    <tr class=\"record\">
                        <td  hidden id=\"hidden-data\" data-ac=\"$item->account\" data-fn=\"$item->name\"  data-nb=\"$item->number\" data-em=\"$item->email\" data-ad=\"$item->address\" data-rl=\"$item->role\" data-pm=\"$item->permission\" data-pw=\"$item->pass\"></td>
                        <td class=\"text-center\">$item->id</td>
                        <td id=\"tenus\">".$item->account."</td>
                        <td>$item->name</td>
                        <td id=\"roleus\" class=\"text-center\">$role</td>
                        <td class=\"text-center\">
                            <button data-type=\"us\" class=\"btn btn-primary btn-mini btn-crud fix suaus\" data-id=\"$item->id\">
                                <i class=\"fa-solid fa-gear\"></i>
                            </button>
                            <button data-type=\"us\" class=\"btn btn-danger btn-mini btn-crud del xoaus\" data-id=\"$item->id\">
                                <i class=\"fa-solid fa-trash\"></i>
                            </button>
                            $button
                        </td>
                    </tr>
                ";
            }
        }

        else if ($type == 'cm') {
            foreach ($list as $item) {
                $html .= "
                    <tr class=\"record\">
                        <td>$item->id</td>
                        <td style=\"text-align: left;\">$item->name</td>
                        <td>$item->cmts</td>
                        <td>$item->users</td>
                        <td><button class=\"btn btn-success chitiet chitietbl\" data-id=\"$item->id\">Chi tiết</button></td>
                    </tr>
                ";
            }
        }

        else if ($type == 'in') {
            foreach ($list as $item) {
                $prods = json_decode($item->list, true);
                $rp = is_array($prods) ? count($prods) : 0;
                $coupon = $item->coupon;
                $price = ($item->offers !== null) ?  gennum($item->offers)."<br><span style=\"font-size: 12px; color: red;\">$coupon</span>" : gennum($item->price);

                $html .= "
                    <tr class=\"record\">
                        <td rowspan=\"$rp\" class=\"text-center p-0 id-hd\">$item->id</td>
                        <td rowspan=\"$rp\" class=\"text-start\" style=\"font-size:14px;\">
                            ".$item->name."<br>
                            ".$item->email."<br>
                            0".$item->number."<br>
                            ".$item->address."
                        </td>
                        <td class=\"text-start\">SL: ".$prods[0]->num." | ".$prods[0]->name."</td>
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
                        <tr class=\"record\">
                            <td style=\"text-align: left;\">SL: ".$prods[$i]->num." | ".$prods[$i]->name."</td>
                        </tr>
                    ";
                }
            }
        }

        else if ($type == 'cp') {
            foreach ($list as $item) {
                $price = ($item->type == "number") ? $item->discount." đ" : $item->discount."%";
                $html .= "
                    <tr class=\"record\">
                        <td hidden id=\"hidden-data\" data-fn=\"$item->name\" data-mx=\"$item->amount\" data-rm=\"$item->remaining\" data-fd=\"$item->f_date\" data-td=\"$item->t_date\" data-dc=\"$item->discount\" data-tp=\"$item->type\"></td>
                        <td>$item->id</td>
                        <td>$item->name</td>
                        <td>$item->amount</td>
                        <td>$item->remaining</td>
                        <td>".gendate($item->f_date)."</td>
                        <td>".gendate($item->t_date)."</td>
                        <td>$price</td>
                        <td>
                            <button class=\"btn btn-primary btn-mini btn-crud fix suagg\" data-id=\"$item->id\" data-type=\"cp\"><i class=\"fa-solid fa-gear\"></i></button>
                            <button class=\"btn btn-danger btn-mini btn-crud del\" data-id=\"$item->id\" data-type=\"cp\"><i class=\"fa-solid fa-trash\"></i></button>
                        </td>
                    </tr>
                ";
            }
        }
        return $html;
    }

    function gen_pagin($type,$ttpage,$page = 1) {
        $html= "";
        for ($i = 1; $i <= $ttpage; $i++) {
            if ($i == $page) {
                $html.= "<button data-type=\"$type\" data-page=\"$i\" class=\"button-pagin filter-gr page-records page-act\" >$i</button>";
            }
            else if ($i <= 3 || $i > $ttpage - 3 || ($i >= $page - 1 && $i <= $page + 1)) {
                $html.= "<button data-type=\"$type\" data-page=\"$i\" class=\"button-pagin filter-gr page-records\">$i</button>";
            }
            else if ($i == 4 && $page > 4) {
                $html.= "<button class=\"button-pagin filter-gr deact\">...</button>";
            }
            else if ($i == $ttpage - 3 && $page < $ttpage - 3) {
                $html.= "<button class=\"button-pagin filter-gr deact\">...</button>";
            }
        }
        return $html;
    }

    function check_permission(Request $rq) {
        $data = ['status' => false, 'res' => ''];
        $type = $rq->input('type');
        if ($this->datarp['permission'] == 'Admin') $data['status'] = true;
        else if ($this->datarp['permission'] == 'Seller') {
            if ($type == 'pd' || $type == 'c1' || $type == 'c2' || $type == 'in' || $type == 'cp' || $type == 'br') $data['status'] = true;
            else $data['res'] = 'Bạn không có quyền thực hiện hành động này';
        }
        else if ($this->datarp['permission'] == 'Designer') {
            if ($type == 'ss' || $type == 'bn') $data['status'] = true;
            else $data['res'] = 'Bạn không có quyền thực hiện hành động này';
        }
        return response()->json($data);
    }

    function filter(Request $rq) {
        $data['status'] = true;

        $db = $rq->input('type');
        $page = $rq->input('page');
        $filter = $rq->input('filter');
        $record = $rq->input('records');
        $search = $rq->input('search');
        $order = $rq->input('order');

        if ($db == 'cm') $list = Comment::get_list();
        else {
            $list = Ajax::filter($db,$page,$filter,$record,$search,$order,'list');
            $ttpg = Ajax::filter($db,$page,$filter,$record,$search,$order,'ttpg');
            $data['pagin'] = $this->gen_pagin($db,$ttpg,$page);
        }

        $data['res'] = $this->gen_html($db,$list);    
        return response()->json($data);
    }
}