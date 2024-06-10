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

class admin_controller extends Controller {
    private $datarp;

    function login() {
        return view('admin.login');
    }
    function manager(Request $rq, $type='') {
        if ($type != '') {
            if ($type == 'sections') {
                $this->datarp['list'] = Section::get();
                $this->datarp['cat1'] = Catalog_1::get();
                $this->datarp['cat2'] = Catalog_2::get();
                $this->datarp['mng'] = 'sections';
            }
            else if ($type == 'slidebns') {
                $this->datarp['list'] = Banner::get();
                $this->datarp['mng'] = 'slidebns';
            }
            else if ($type == 'products') {
                $this->datarp['mng'] = 'products';
                $this->datarp['list'] = Product::get();
                $this->datarp['cat1'] = Catalog_1::get();
                $this->datarp['cat2'] = Catalog_2::get();
                $this->datarp['grap'] = Product::grap();
                $this->datarp['brands'] = Brand::get();
            }
            else if ($type == 'catalogs') {
                $this->datarp['list1'] = Catalog_1::get();
                $this->datarp['list2'] = Catalog_2::get();
                $this->datarp['mng'] = 'catalogs';
            }
            else if ($type == 'usersmng') {
                $this->datarp['list'] = User::get();
                $this->datarp['mng'] = 'usersmng';
            }
            else if ($type == 'comments') {
                $this->datarp['list'] = Comment::get_list();
                $this->datarp['mng'] = 'comments';
            }
            else if ($type == 'invoices') {
                $this->datarp['list'] = Invoice::get();
                $this->datarp['mng'] = 'invoices';
            }
            else if ($type == 'offers') {
                $this->datarp['list'] = Voucher::get();
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

    function ss_mng (Request $rq, $type='') {
        $data['status'] = false;

        if ($type == 'add') {

        }
        else if ($type == 'fix') {

        }
        else if ($type == 'del') {
            $data['status'] = true;
        }
        return response()->json($data);
    }

    function bn_mng (Request $rq, $type='') {
        $data['status'] = false;

        if ($type == 'add') {

        }
        else if ($type == 'fix') {

        }
        else if ($type == 'del') {
            $data['status'] = true;
        }
        return response()->json($data);
    }

    function pd_mng (Request $rq, $type='') {
        $data['status'] = false;

        if ($type == 'add') {

        }
        else if ($type == 'fix') {

        }
        else if ($type == 'del') {
            $data['status'] = true;
        }
        return response()->json($data);
    }

    function c1_mng (Request $rq, $type='') {
        $data['status'] = false;

        if ($type == 'add') {

        }
        else if ($type == 'fix') {

        }
        else if ($type == 'del') {
            $data['status'] = true;
        }
        return response()->json($data);
    }

    function c2_mng (Request $rq, $type='') {
        $data['status'] = false;

        if ($type == 'add') {

        }
        else if ($type == 'fix') {

        }
        else if ($type == 'del') {
            $data['status'] = true;
        }
        return response()->json($data);
    }

    function us_mng (Request $rq, $type='') {
        $data['status'] = false;

        if ($type == 'add') {

        }
        else if ($type == 'fix') {

        }
        else if ($type == 'del') {
            $data['status'] = true;
        }
        return response()->json($data);
    }

    function cm_mng (Request $rq, $type='') {
        $data['status'] = false;
        if ($type == 'del') {
            $data['status'] = true;
        }
        return response()->json($data);
    }

    function in_mng (Request $rq, $type='') {
        $data['status'] = false;

        if ($type == 'fix') {

        }
        else if ($type == 'del') {
            $data['status'] = true;
        }
        return response()->json($data);
    }

    function cp_mng (Request $rq, $type='') {
        $data['status'] = false;

        if ($type == 'add') {

        }
        else if ($type == 'fix') {

        }
        else if ($type == 'del') {
            $data['status'] = true;
        }
        return response()->json($data);
    }
}
