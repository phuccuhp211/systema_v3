<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();

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

class user_controller extends Controller {
    private $header;
    private $datarp;

    function __construct() {
        $this->header = $this->header();
        $this->datarp['header'] = $this->header;
    }

    function header() {
        $cat_1 = Catalog_1::full_cat();
        $cat_2 = Catalog_2::full_cat();
        if(session()->has('user_log')) {
            $user = user::get_us(session('user_log'));
            return [
                'cat1' => $cat_1,
                'cat2' => $cat_2,
                'user' => $user
            ];
        }
        return [
            'cat1' => $cat_1,
            'cat2' => $cat_2
        ];
    }

    function genfil($data_type = null, $data = null) {
        $options = [
            '1' => 'Cũ Nhất',
            '2' => 'Mới Nhất',
            '3' => 'Giá Tăng Dần',
            '4' => 'Giá Giảm Dần'
        ];

        $op_gen = '';
        foreach ($options as $key => $value) {
            $op_gen .= "<option value=\"$key\">$value</option>";
        }

        $dataAttr = isset($data) ? "data=\"$data\"" : '';

        $bl = "<div class=\"col-3 phan-boloc\">
            <select id=\"filter\" class=\"form-select boloc-act\" data-type=\"products/$data_type\" $dataAttr>
                $op_gen
            </select>
        </div>";
        return $bl;
    }

    function pagin($type=null, $data=null, $pg_count=null, $pg_cr, $filter=null) {
        $lpt= "";
        $filter = ($filter) ? "type=\"$filter\"" : '';
        $data = ($data) ? "data=\"$data\"" : '';
        for ($i = 1; $i <= $pg_count; $i++) {
            if ($i == $pg_cr) {
                $lpt.= "<button class=\"a-pt a-move act\" data-type=\"products/$type\" page=\"$i\" $data $filter>$i</button>";
            }
            else if ($i <= 3 || $i > $pg_count - 3 || ($i >= $pg_cr - 1 && $i <= $pg_cr + 1)) {
                $lpt.= "<button class=\"a-pt a-move\" data-type=\"products/$type\" page=\"$i\" $data $filter>$i</button>";
            }
            else if ($i == 4 && $pg_cr > 4) {
                $lpt.= "<button class=\"a-pt deact\">...</button>";
            }
            else if ($i == $pg_count - 3 && $pg_cr < $pg_count - 3) {
                $lpt.= "<button class=\"a-pt deact\">...</button>";
            }
        }
        return $lpt;
    }

    function index() {
        Access::uphomet();
        $ss = Section::get_ss();
        $arr_ss = [];

        for ($i = 0; $i < count($ss); $i++) {
            $sps = Product::get_sp($ss[$i]['id_cata_1'], $ss[$i]['id_cata_2'], $ss[$i]['reference'], $ss[$i]['orderby']);
            $arr_ss[] = ['title' => $ss[$i], 'products' => $sps ];

        }

        $this->datarp['banners'] = Banner::get_bn();
        $this->datarp['full_ss'] = $arr_ss;
        $this->datarp['product'] = Product::get_st();
        $this->datarp['casepcs'] = Product::get_ps();

        return view('client.home', $this->datarp);
    }

    function products(Request $rq, $type=null, $data=null, $page=1) {
        Access::uphomef();

        $data = ($rq->input('data')) ?? $data;
        $page = ($rq->input('page')) ?? $page;
        $limit = ($rq->input('limit')) ?? 16;
        $filter = ($rq->input('filter')) ??  null;

        if ($type == 'all') $this->datarp['title'] = 'Tất Cả Sản Phẩm';
        else if ($type == 'search') $this->datarp['title'] = $this->datarp['pgpd'] = 'Tìm kiếm: '.$rq->input('search_data');
        else if ($type == 'cat1') $this->datarp['title'] = $this->datarp['pgpd'] = 'Phân loại: '.Catalog_1::get_dedi($data);
        else if ($type == 'cat2') $this->datarp['title'] = $this->datarp['pgpd'] = 'Danh Mục: '.Catalog_2::get_dedi($data);

        if ($rq->ajax()) {
            if ($rq->input('search_data')) {
                $res = Product::get_ao($type,$rq->input('search_data'),$page,$filter,$rq->input('limit'));
                return response()->json(['res' => $res]);
            }
            else {
                $res = Product::get_ao($type,$data,$page,$filter,$limit);
                $col = ($rq->input('showsp')) ? $rq->input('showsp') : null;
                $rp['prods'] = showsp($res, $col);
                $rp['pagin'] = $this->pagin($type,$data,Product::pagin($type,$data),$page,$filter);
                return response()->json(['res' => $rp]);
            }
        }
        else {
            $this->datarp['dtpd'] = Product::get_ao($type,$data,$page,$filter,$limit);
            $this->datarp['pagi'] = $this->pagin($type,$data,Product::pagin($type,$data),$page,$filter);
            $this->datarp['filter'] = $this->genfil($type,$data);
            return view('client.product', $this->datarp);
        }
    }

    function detail($data) {
        Access::uphomef();
        $this->datarp['dtpd'] = Product::get_dt($data);
        $this->datarp['dtpd']->brand = Brand::get_br($this->datarp['dtpd']->id_brand);
        $this->datarp['lcmt'] = Comment::get_ct($data);
        $this->datarp['rlpd'] = Product::get_rl($data);

        $rated = Rating::get_rt($data);
        $idsp = $this->datarp['dtpd']['id'];

        if (session()->has('user_log')) {
            $usrt = Turn_rating::get_rt($this->datarp['header']['user']['id'],$data);
            $stars_btn = "";
            if($usrt) {
                $offset = $usrt->stars;
                $class_btn = "";

                for ($i=1; $i <= 5; $i++) {
                    if ($i == $offset) $class_btn = "select-star";
                    else $class_btn = "";
                    $stars_btn.= "<div class=\"btn-stars $class_btn\" data-rate=\"$i\" data-idsp=\"$idsp\">$i Sao</div>";
                }
            }
            else {
                for ($i=1; $i <= 5; $i++) {
                    $stars_btn.= "<div class=\"btn-stars\" data-rate=\"$i\" data-idsp=\"$idsp\">$i Sao</div>";
                }
            }
            $this->datarp['btrt'] = "<div class=\"box-btn-stars\">$stars_btn</div>";
        }
        if ($rated) {
            $ss = $rated->stars/$rated->turns;
            $list_stars = "";
            $num_star = floor($ss);
            $class_star = "color-star";

            for ($i=1; $i <= 5; $i++) {
                if ($i > $num_star) $class_star = "";
                $list_stars.= "
                <i class=\"fa-regular fa-star $class_star\"></i>
                ";
            }

            $sps = "
                <div class=\"sum-stars\">
                    <h4>$ss trên 5 ($rated->turns Lượt)</h4>
                    <h5>$list_stars</h5>        
                </div>
            ";
            $this->datarp['pds'] = $sps;
        }
        else {
            $sps = "
                <div class=\"sum-stars\">
                    <h5 style=\"color: #ee4d2d;\">Sản phẩm chưa được đánh giá</h5>        
                </div>
            ";
            $this->datarp['pds'] = $sps;
        }

        return view('client.detail', $this->datarp);
    }

    function config() {
        Access::uphomef();
        if (isset($this->datarp['header']['user'])) {
            $this->datarp['list_ins'] = Invoice::get_list($this->datarp['header']['user']['number']);
            return view('client.config', $this->datarp);
        }
        else {
            return redirect()->route('home');
        }
    }

    function cart() {
        Access::uphomef();
        return view('client.cart', $this->datarp);
    }

    function pay() {
        Access::uphomef();
        if (!session()->has('cart') || session('cart')['list'] == null) return redirect()->route('home');
        else return view('client.pay', $this->datarp);
    }

    function comment(Request $rq) {
        $cmt = $rq->input('cmt');
        $idp = $rq->input('idp');
        $uid = $rq->input('uid');
        $date = $rq->input('date');
        Comment::add_cmt($cmt, $idp, $uid, $date);
    }

    function rate(Request $rq) {
        $id = $rq->input('idsp');
        $rt = $rq->input('rate');
        $us = $this->datarp['header']['user']['id'];

        Turn_rating::rate($id,$us,$rt);
    }

    function dord() {
        Access::uphomef();
        return view('client.complete_order', $this->datarp);
    }

    function inv_check(Request $rq) {
        Access::uphomef();
        if ($rq->input('in_num')) {
            $invoice = Invoice::get_inv($rq->input('in_num'));
            $data['status'] = false;

            if(!$invoice) $data['res'] = 'Mã hóa đơn không đúng!';
            else {
                $created = new DateTime($invoice->created);

                if ($invoice->submited != null) {
                    $submited = new DateTime($invoice->submited);
                    $warranty = clone $submited;
                    $warranty->add(new DateInterval('P3Y'));

                    $content_w = "
                        <h5>Đơn hàng được bảo hành từ : 
                            <strong style=\"color:red;\">".$submited->format('d/m/Y')."</strong> đến 
                            <strong style=\"color:red;\">".$warranty->format('d/m/Y')."</strong>
                        </h5>";

                    $submited = $submited->format('d/m/Y');
                }
                else {
                    $submited = "Đang chờ xác nhận";
                    $content_w = "<h5>Đơn hàng đang chờ được xác nhận bởi quản trị viên</h5>";
                }

                $html = "";
                $list = json_decode($invoice->list,true);

                foreach ($list as $value => $item) {
                    $html .= "
                        <tr> 
                            <td style=\"font-size: 16px; padding: 5px 0;text-align: center;\">".($value+1)."</td>
                            <td style=\"font-size: 16px; padding: 5px 0 5px 10px;\">".$item['name']."</td>
                            <td style=\"font-size: 16px; padding: 5px 0;text-align: center;\">".$item['num']."</td>
                            <td style=\"font-size: 16px; padding: 5px; text-align: right;\">".gennum( $item['pfn'] )."</td>
                            <td style=\"font-size: 16px; padding: 5px; text-align: right;\">".gennum( $item['sum'] )."</td>
                        </tr>
                    ";
                }

                if ($invoice->offers != null) {
                    $final = "
                        <tr>
                            <td colspan=\"3\" class=\"tc-dssp\"><strong>Tạm Tính :</strong></td>
                            <td colspan=\"2\" class=\"tc-dssp\"><strong>".gennum( $invoice->price )."</strong></td>
                        </tr>
                        <tr>
                            <td colspan=\"3\" class=\"tc-dssp\"><strong>Giá Giảm :</strong></td>
                            <td colspan=\"2\" class=\"tc-dssp\"><strong>".gennum( $invoice->price-$invoice->offers )."</strong></td>
                        </tr>
                        <tr>
                            <td colspan=\"3\" class=\"tc-dssp\"><strong>Tổng Cộng :</strong></td>
                            <td colspan=\"2\" class=\"tc-dssp\"><strong>".gennum( $invoice->offers )."</strong></td>
                        </tr>
                    ";
                }
                else {
                    $final = "
                        <tr>
                            <td colspan=\"3\" class=\"tc-dssp\"><strong>Tổng Cộng :</strong></td>
                            <td colspan=\"2\" class=\"tc-dssp\"><strong>".gennum( $invoice->price )."</strong></td>
                        </tr>
                    ";
                }

                $data['res'] = "
                    <div class=\"col-8 offset-2 cthd\">
                        <h2>Thông Tin Hóa Đơn</h2>
                        <div class=\"tt-ngmua\">
                            <table style=\"margin: 0 0 20px; font-size: 18px;\">
                                <tr>
                                    <td style=\"padding: 5px 0;width: 50%; border-bottom: 1px solid gray\" colspan=\"2\">
                                        Mã Hóa Đơn : <strong style=\"color: #6246a8;\">".$invoice->in_num."</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style=\"padding: 5px 0;width:50%;\">Ngày Tạo Đơn : 
                                        <strong style=\"color: #6246a8;\">".$created->format('d/m/Y')."</strong>
                                    </td>
                                    <td style=\"padding: 5px 0;\">Ngày Xác Nhận Đơn : 
                                        <strong style=\"color: #6246a8;\">$submited</strong>
                                    </td>
                                </tr>
                            </table>
                            <table class=\"tt-user\">
                                <tr>
                                    <td class=\"ttct-user\">Tên Người mua :</td>
                                    <td><strong>".$invoice->name."</strong></td>
                                </tr>
                                <tr>
                                    <td class=\"ttct-user\">Số Điện Thoại :</td>
                                    <td><strong>".$invoice->number."</strong></td>
                                </tr>
                                <tr>
                                    <td class=\"ttct-user\">Email : </td>
                                    <td><strong>".$invoice->email."</strong></td>
                                </tr>
                                <tr>
                                    <td class=\"ttct-user\">Địa Chỉ :</td>
                                    <td><strong>".$invoice->address."</strong></td>
                                </tr>
                            </table>
                        </div>
                        <table class=\"dssp\">
                            <tr>
                                <th style=\"width: 8%;\">STT</th>
                                <th style=\"width: 50%;\">Tên Hàng Hóa, Dịch Vụ</th>
                                <th style=\"width: 8%;\">SL</th>
                                <th style=\"width: 17%;\">Đơn Giá</th>
                                <th style=\"width: 17%;\">Thành Tiền</th>
                            </tr>
                            $html
                            <tr>
                                <td style=\"font-size: 16px; padding: 5px 0;text-align: center;\">X</td>
                                <td style=\"font-size: 16px; padding: 5px 0 5px 10px\">Phí vận chuyển</td>
                                <td style=\"font-size: 16px; padding: 5px 0;text-align: center;\">X</td>
                                <td style=\"font-size: 16px; padding: 5px; text-align:right;\">".$invoice->shipfee."</td>
                                <td style=\"font-size: 16px; padding: 5px; text-align:right;\">".$invoice->shipfee."</td>
                            </tr>
                            $final
                        </table>
                        $content_w
                        <h6>Lưu ý : Bảo hành áp dụng cho toàn bộ sản phẩm có trong đơn hàng, khi đi bảo hành, quý khách vui lòng mang theo hộp (hoặc bao bì) của sản phẩm và kèm theo hóa đơn.</h6>
                    </div>
                ";

                $data['status'] = true;
            }
            return response()->json($data);
        }
        return view('client.invoice_check', $this->datarp);
    }

    function rspw() {
        Access::uphomef();
        return view('client.reset_pw', $this->datarp);
    }
}