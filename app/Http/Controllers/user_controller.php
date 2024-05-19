<?php

namespace App\Http\Controllers;

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

    function index() {
        Access::uphomet();
        $ss = Section::get_ss();
        $arr_ss = [];

        for ($i = 0; $i < count($ss); $i++) {
            $sps = Product::get_sp($ss[$i]['id_cata_1'], $ss[$i]['id_cata_2'], $ss[$i]['reference'], $ss[$i]['orderby']);
            $arr_ss = Arr::add(['title' => $ss[$i], 'products' => $sps ]);

        }

        $this->datarp['banners'] = Banner::get_bn();
        $this->datarp['full_ss'] = $arr_ss;
        $this->datarp['product'] = Product::get_st();
        $this->datarp['casepcs'] = Product::get_ps();

        return view('client.home', $this->datarp);
    }
}
