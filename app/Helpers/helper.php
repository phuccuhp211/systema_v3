<?php 
    function showsp($mangsp, $col = null, $advl = '') {
        $chuoisp = "";
        $colums = ($col) ? $col : "col-3";
        foreach ($mangsp as $value => $item) {
            if ($item['sale'] != 0) $sale ="<span>".gennum($item['price'])."</span>".gennum($item['sale']);
            else { $sale = gennum($item['price']);}
            $chuoisp.= "
            <div class=\"$colums text-center $advl\">
                <div class=\"khungsp\">
                    <div class=\"khungxam nav-item\">
                        <a href=\"".genurl($item['id'],'detail')."\" class=\"nav-link\">
                            <img src=\"".genurl($item['img'],'data')."\" class=\"anhsp nav-link\" alt=\"\">
                        </a>                               
                    </div>                                
                    <p class=\"tt tensp\">".$item['name']."</p>
                    <p class=\"tt giasp\">".$sale."</p>
                    <div class=\"nut_sp\">
                        <a href=\"".genurl($item['id'],'cart/buy')."\" class=\"btn nutsp\">Mua Ngay</a>
                        <button class=\"btn nutsp addcart\" data-idsp=\"".$item['id']."\"><i class=\"fa-solid fa-cart-plus\"></i></button>
                    </div>
                </div>                    
            </div>";
        }
        return $chuoisp;
    }
    function showsp2($mangsp, $col = null, $advl = '') {
        $chuoisp = "";
        $colums = ($col) ? $col : "col-3";
        foreach ($mangsp as $value => $item) {
            if ($item['sale'] != 0) $sale ="<span>".gennum($item['price'])."</span>".gennum($item['sale']);
            else { $sale = gennum($item['price']);}
            $chuoisp.= "
            <div class=\"$colums text-center $advl\">
                <div class=\"khungsp2\">
                    <div class=\"khungxam position-relative nav-item\">
                        <a href=\"".genurl($item['id'],'detail')."\" class=\"nav-link\">
                            <img src=\"".genurl($item['img'],'data')."\" class=\"anhsp nav-link\" alt=\"\">
                        </a>
                        <p class=\"tt vnssp\">
                            <i class=\"fa-solid fa-eye\"></i> ".$item['viewed']."<br>
                            <i class=\"fa-solid fa-cart-flatbed\"></i> ".$item['saled']."
                        </p>                               
                    </div>                                
                    <p class=\"tt tensp\">".$item['name']."</p>
                    <p class=\"tt giasp\">".$sale."</p>
                    <div class=\"nut_sp\">
                        <a href=\"".genurl($item['id'],'cart/buy')."\" class=\"btn nutsp\">Mua Ngay</a>
                        <button class=\"btn nutsp addcart\" data-idsp=\"".$item['id']."\"><i class=\"fa-solid fa-cart-plus\"></i></button>
                    </div>
                </div>                    
            </div>";
        }
        return $chuoisp;
    }
    function gennum($number) {
        return Number::format($number, locale: 'vi');
    }
    function genurl($url,$type='data') {
        return asset("$type/$url");
    }

    function dumpdt($data) {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
?>  
    