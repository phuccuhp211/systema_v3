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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

require base_path('src/Exception.php');
require base_path('src/PHPMailer.php');
require base_path('src/SMTP.php');

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
        if(session()->has('udone')) {
            $user = us::get_us(session('udone'));
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

    function genfil($loai_data=null, $dulieu=null) {
        $bl = "";
        $base_url = url();
        if (isset($dulieu)) {
            $bl.= "
                <div class=\"col-3 phan-boloc\">
                    <div class=\"dropdown\">
                        <button class=\"boloc dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">Bộ Lọc</button>
                        <ul class=\"dropdown-menu\">
                            <li>
                                <button class=\"dropdown-item boloc-act\" data-type=\"$loai_data\" data=\"$dulieu\" data-phanloai=\"1\">Mới Nhất</button>
                            </li>
                            <li>
                                <button class=\"dropdown-item boloc-act\" data-type=\"$loai_data\" data=\"$dulieu\" data-phanloai=\"2\">Cũ Nhất</button>
                            </li>
                            <li>
                                <button class=\"dropdown-item boloc-act\" data-type=\"$loai_data\" data=\"$dulieu\" data-phanloai=\"3\">Giá Từ Thấp -> Cao</button>
                            </li>
                            <li>
                                <button class=\"dropdown-item boloc-act\" data-type=\"$loai_data\" data=\"$dulieu\" data-phanloai=\"4\">Giá Từ Cao -> Thấp</button>
                            </li>
                        </ul>
                    </div>
                </div>
            ";
            return $bl;
        }
        else {
            $bl.= "
                <div class=\"col-3 phan-boloc\">
                    <div class=\"dropdown\">
                        <button class=\"boloc dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">Bộ Lọc</button>
                        <ul class=\"dropdown-menu\">
                            <li>
                                <button class=\"dropdown-item boloc-act\" data-type=\"$loai_data\" data-phanloai=\"1\">Mới Nhất</button>
                            </li>
                            <li>
                                <button class=\"dropdown-item boloc-act\" data-type=\"$loai_data\" data-phanloai=\"2\">Cũ Nhất</button>
                            </li>
                            <li>
                                <button class=\"dropdown-item boloc-act\" data-type=\"$loai_data\" data-phanloai=\"3\">Giá Từ Thấp -> Cao</button>
                            </li>
                            <li>
                                <button class=\"dropdown-item boloc-act\" data-type=\"$loai_data\" data-phanloai=\"4\">Giá Từ Cao -> Thấp</button>
                            </li>
                        </ul>
                    </div>
                </div>
            ";
            return $bl;
        }
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

    function products(Request $request, $page, $data=null) {
        Access::uphomef();
        if ($page == 'all') {
            $this->datarp['dtpd'] = Product::get_ao();
            $this->datarp['title'] = 'Tất Cả Sản Phẩm';
            $this->datarp['filter'] = $this->genfil('products/all');
            return view('client.product', $this->datarp);
        }
        else if ($page == 'detail') {
            $this->datarp['dtpd'] = Product::get_dt($data);
            $this->datarp['dtpd']->brand = Brand::get_br($this->datarp['dtpd']->id_brand);
            $this->datarp['lcmt'] = Comment::get_ct($data);
            $this->datarp['rlpd'] = Product::get_rl($data);

            $rated = Turn_rating::get_rt(null,$data);

            if (session()->has('udone')) {
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
        else if ($page == 'search') {
            $this->datarp['dtpd'] = Product::get_ao('search',$data,false);
            $this->datarp['title'] = 'Tìm kiếm: '.$data;
            $this->datarp['pgpd'] = 'Tìm kiếm: '.$data;
            $this->datarp['filter'] = $this->genfil('products/search', $data);
            return view('client.product', $this->datarp);
        }
        else if ($page == 'cat1') {
            $this->datarp['dtpd'] = Product::get_ao('cat1',$data);
            $this->datarp['title'] = 'Phân loại: '.Catalog_1::get_dedi($data);
            $this->datarp['pgpd'] = 'Phân loại: '.Catalog_1::get_dedi($data);
            $this->datarp['filter'] = $this->genfil('products/cat1', $data);
            return view('client.product', $this->datarp);
        }
        else if ($page == 'cat2') {
            $this->datarp['dtpd'] = Product::get_ao('cat2',$data);
            $this->datarp['title'] = 'Danh Mục: '.Catalog_2::get_dedi($data);
            $this->datarp['pgpd'] = 'Danh Mục: '.Catalog_2::get_dedi($data);
            $this->datarp['filter'] = $this->genfil('products/cat2', $data);
            return view('client.product', $this->datarp);
        }
    }

    function ajax_hl(Request $request, $page, $check=null) {
        if ($page == 'search') {
            if ($check) {
                return redirect()->route('products.najax', ['page' => 'search', 'data' => $request->input('search_data')]);
            }
            else {
                $res = Product:: get_ao('search',$request->input('tksp'),true,$request->input('limit'));
                return response()->json(['sanpham' => $res]);
            }
                
        }
    }
}
