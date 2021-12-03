<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("sql_query.php");

// get_data();
// count_all_data_hangHoa();


// Lay du lieu hang hoa theo vi tri tung trang (page)
function get_data(int $index=0, int $limit=50, $sap_xep = 'ASC', $maLoaiHang = 0) {

    $condition_type = "where lo.MaLoaiHang=";

    if($maLoaiHang > 0) {
        $condition_type .= (int) $maLoaiHang;
    }
    else {
        $condition_type = "";
    }
    
    $sql = "SELECT * FROM hanghoa as ha JOIN hinhhanghoa as hi on ha.MSHH = hi.MSHH JOIN loaihanghoa as lo on lo.MaLoaiHang = ha.MaLoaiHang $condition_type ORDER BY ha.Gia $sap_xep LIMIT $index, $limit ;";

    $data = sql_query($sql);
    $_SESSION['data'] = $data;

    $sql_count = "SELECT * FROM hanghoa as ha JOIN hinhhanghoa as hi on ha.MSHH = hi.MSHH JOIN loaihanghoa as lo on lo.MaLoaiHang = ha.MaLoaiHang 
    $condition_type ;";
    $data_count = sql_query($sql_count);
    $_SESSION['total_all_product'] = count($data_count);

}


// Lay du lieu hang hoa theo Ma Loai Hang Hoa 
// function get_data_by_maLoaiHangHoa(int $index=0, int $limit=50, $sap_xep = 'ASC', $maLoaiHang = 0) {

//     $condition_type = "where lo.MaLoaiHang=";

//     if($maLoaiHang > 0) {
//         $condition_type .= (int) $maLoaiHang;
//     }
//     else {
//         $condition_type = "";
//     }
    
//     $sql = "SELECT * FROM hanghoa as ha JOIN hinhhanghoa as hi on ha.MSHH = hi.MSHH JOIN loaihanghoa as lo on lo.MaLoaiHang = ha.MaLoaiHang $condition_type ORDER BY ha.Gia $sap_xep LIMIT $index, $limit";

//     $data = sql_query($sql);
//     $_SESSION['data'] = $data;
// }


// Lay du lieu hang hoa theo MSHH 
function get_data_by_mshh($mshh) {
    
    $mshh = (int)$mshh;

    $sql = "SELECT * FROM hanghoa as ha 
            left JOIN hinhhanghoa as hi on ha.MSHH = hi.MSHH 
            left JOIN loaihanghoa as lo on lo.MaLoaiHang = ha.MaLoaiHang 
            where ha.mshh=".$mshh.
    ";";
    
    $data = sql_query($sql);

    return $data;
}



// function count_all_data_hangHoa($limit = 50) {
//     $sql = "SELECT * FROM hanghoa as ha JOIN hinhhanghoa as hi on ha.MSHH = hi.MSHH JOIN loaihanghoa as lo on lo.MaLoaiHang = ha.MaLoaiHang limit $limit";
//     $data = sql_query($sql);
//     $_SESSION['total_all_product'] = count($data);
// }

function show_session() {
    if(isset($_SESSION)) {
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
    }
    else {
        echo "Khong ton tai SESSION";
    }
}


// if(!isset($_SESSION['data'])) {
//     $sql = "SELECT * FROM hanghoa as ha JOIN hinhhanghoa as hi on ha.MSHH = hi.MSHH LIMIT 1";
//     $data = sql_query($sql);
//     $_SESSION['data'] = $data;
// }


// echo '<pre>'; print_r($_SESSION['data']);echo '</pre>';
// test(12);
// function test($a=1, $b=2) {
//     echo $a.'<br>';
//     echo $b;
// }