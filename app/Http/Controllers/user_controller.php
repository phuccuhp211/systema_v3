<?php

namespace App\Http\Controllers;

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
use App\Models\Us;
use App\Models\Voucher;

use DateTime;
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
            $user = us::get_us(session('user_log'));
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
                $res = Product:: get_ao($type,$rq->input('search_data'),$page,$filter,$rq->input('limit'));
                return response()->json(['res' => $res]);
            }
            else {
                $res = Product::get_ao($type,$data,$page,$filter,$limit);
                $rp['prods'] = showsp($res);
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

    function detail_pd($data) {
        $this->datarp['dtpd'] = Product::get_dt($data);
        $this->datarp['dtpd']->brand = Brand::get_br($this->datarp['dtpd']->id_brand);
        $this->datarp['lcmt'] = Comment::get_ct($data);
        $this->datarp['rlpd'] = Product::get_rl($data);

        $rated = Turn_rating::get_rt(null,$data);

        if (session()->has('user_log')) {
            $usrt = Turn_rating::get_rt($this->datarp['header']->id, $data);
            $stars_btn = "";
            if(isset($usrt[0])) {
                $offset = $usrt[0]['stars'];
                $class_btn = "";
                $idsp = $chitiet[0]['id'];

                for ($i=1; $i <= 5; $i++) {
                    if ($i == $offset) $class_btn = "select-star";
                    else $class_btn = "";
                    $stars_btn.= "<div class=\"btn-stars $class_btn\" data-rate=\"$i\" data-idsp=\"$idsp\">$i Sao</div>";
                }
            }
            else {
                for ($i=1; $i <= 5; $i++) {
                    $stars_btn.= "<div class=\"btn-stars\" data-rate=\"$i\" data-idsp=\"$id\">$i Sao</div>";
                }
            }
            $this->datarp['btrt'] = "<div class=\"box-btn-stars\">$stars_btn</div>";
        }
        if (isset($rated[0])) {
            $ss = $rating[0]['stars']/$rating[0]['turns'];
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
                    <h2>$ss trên 5</h2>
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
    
}
