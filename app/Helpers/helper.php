<?php 
    function showsp($mangsp, $col = null, $advl = '') {
        $chuoisp = "";
        $colums = ($col) ? $col : "col-3";
        foreach ($mangsp as $value => $item) {
            if ($item['sale'] != 0) { 
                $sale ="
                    <span>"
                        .number_format($item['price'],0,",",".")."
                    </span>"
                    .number_format($item['sale'],0,",",".");
            }
            else { $sale = number_format($item['price']);}
            $chuoisp.= "
            <div class=\"$colums text-center $advl\">
                <div class=\"khungsp\">
                    <div class=\"khungxam nav-item\">
                        <a href=\"".url('/products/detail').'/'.$item['id']."/\" class=\"nav-link\">
                            <img src=\"".url('data').'/'.$item['img']."\" class=\"anhsp nav-link\" alt=\"\">
                        </a>                               
                    </div>                                
                    <p class=\"tt tensp\">".$item['name']."</p>
                    <p class=\"tt giasp\">".$sale."</p>
                    <div class=\"nut_sp\">
                        <a href=\"".url('/muangay/').$item['id']."/\" class=\"btn nutsp\">Mua Ngay</a>
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
            if ($item['sale'] != 0) { 
                $sale ="
                    <span>"
                        .number_format($item['price'],0,",",".")."
                    </span>"
                    .number_format($item['sale'],0,",",".");
            }
            else { $sale = number_format($item['price']);}
            $chuoisp.= "
            <div class=\"$colums text-center $advl\">
                <div class=\"khungsp2\">
                    <div class=\"khungxam position-relative nav-item\">
                        <a href=\"".url('/products/detail/').'/'.$item['id']."/\" class=\"nav-link\">
                            <img src=\"".url('data/').'/'.$item['img']."\" class=\"anhsp nav-link\" alt=\"\">
                        </a>
                        <p class=\"tt vnssp\">
                            <i class=\"fa-solid fa-eye\"></i> ".$item['viewed']."<br>
                            <i class=\"fa-solid fa-cart-flatbed\"></i> ".$item['saled']."
                        </p>                               
                    </div>                                
                    <p class=\"tt tensp\">".$item['name']."</p>
                    <p class=\"tt giasp\">".$sale."</p>
                    <div class=\"nut_sp\">
                        <a href=\"".url('/muangay/').$item['id']."/\" class=\"btn nutsp\">Mua Ngay</a>
                        <button class=\"btn nutsp addcart\" data-idsp=\"".$item['id']."\"><i class=\"fa-solid fa-cart-plus\"></i></button>
                    </div>
                </div>                    
            </div>";
        }
        return $chuoisp;
    }
?>  
    