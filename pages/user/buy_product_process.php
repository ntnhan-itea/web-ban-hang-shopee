
<?php

require_once ("../database/sql_query.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action_page = '';

if(!empty($_POST)) {

    if(isset($_POST["action_page"])) {
        $action_page = $_POST["action_page"];
    }

}


switch($action_page) {

    case "purchase":
        purchase();
        break;

    case "delete_purchased":
        cancel_purchased();
        break;
}


// Xu ly mua hang
function purchase() {

    if(!empty($_POST['data']) && isset($_POST['data'])) {
    
        $data = [];
        $data = $_POST['data'];

        if(empty($data)) {
            echo "Đặt hàng thất bại <br>";
            die();
        }


        $check_success = false;
        
        $NgayDH = date("Y-m-d");
        $NgayGH = date("Y-m-d", strtotime($NgayDH. ' + 2 days'));
        
        $MSKH = -1;
        $MSNV = 1;
        $SoDonDH = -1;

        if(!empty($_SESSION['MSNV']) && isset($_SESSION['MSNV'])) {
            $MSNV = $_SESSION['MSNV'];
        }

        if(!empty($_SESSION['MSKH']) && isset($_SESSION['MSKH'])) {
            $MSKH = $_SESSION['MSKH'];
        }

        
        $sql_insert = "INSERT INTO DatHang(MSKH, MSNV, NgayDH, NgayGH, TrangThaiDH) values ($MSKH, $MSNV, '$NgayDH', '$NgayGH', 0)";

        if(sql_execute($sql_insert)) {
            
            $sql_get_last_id = "SELECT SoDonDH FROM DatHang ORDER BY SoDonDH DESC LIMIT 1";
            $SoDonDH_temp = sql_query($sql_get_last_id);
            $SoDonDH = (int) $SoDonDH_temp[0]['SoDonDH'];

            // echo "So don cuoi: ".$SoDonDH;

            $values = '';

            if( $SoDonDH > 0) {

                foreach($data as $dt) {

                    $values .= "(".$SoDonDH .",". (int)$dt["MSHH"] .", ". (int)$dt["quantity"] .", ".(int)$dt["Gia"].", ".(float)$dt["discount"]."),";  
                }

                $values = rtrim($values, ",");
                // echo $values;

                $sql_insert_chi_tiet = "INSERT INTO chitietdathang (SoDonDH, MSHH, SoLuong, GiaDatHang, GiamGia) values " . trim($values) ;

                if (sql_execute($sql_insert_chi_tiet)) {

                    foreach($data as $dt) { 
                        
                        $mshh_purchased = (int) $dt["MSHH"];

                        $sql_get_so_luong_old = "SELECT SoLuongHang from HangHoa where MSHH=".$mshh_purchased.";";

                        $data_soLuongHang = sql_query($sql_get_so_luong_old);

                        if(!empty($data_soLuongHang)) {

                            $SoLuongHang_old = (int) $data_soLuongHang[0]['SoLuongHang'];
                            $SoLuongHang_purchased = (int) $dt["quantity"];

                            $soLuongConLai = $SoLuongHang_old - $SoLuongHang_purchased;

                            $sql_set_so_luong_new = "UPDATE HangHoa set SoLuongHang=".$soLuongConLai." where MSHH=".$mshh_purchased.";";

                            sql_execute($sql_set_so_luong_new);
                        }
                        
                    }

                    $check_success = true;

                }

            }

        }


        if(!$check_success) {

            if($SoDonDH > 0) {

                $sql_delete = "DELETE FROM dathang where SoDonDH = ".$SoDonDH;
                sql_execute($sql_delete);
            }

            echo "Đặt hàng thất bại <br>";
            return false;

        } else {

            if (isset($_SESSION["cart_datas"])) {
                
                foreach($data as $dt) { 
    
                    $mshh = (int) $dt['MSHH'];
                    
                    foreach($_SESSION['cart_datas'] as $key => $value) {

                        if( (int) $value['MSHH'] === $mshh ) {
        
                            unset($_SESSION['cart_datas'][$key]);
                            $_SESSION['cart_datas'] =  array_values($_SESSION['cart_datas']);
                            break;
                        }
                    }
                }
            }

            echo "Đặt hàng thành công (buy_success). <br>";
            return true;
        }

    } else {
        
        echo "Đặt hàng thất bại";
        return false;
    }

}


// Xu ly XOA don hang
function cancel_purchased() {

    if(!empty($_POST['soDonDH']) && isset($_POST['soDonDH']) && 
        !empty($_POST['maSoKH']) && isset($_POST['maSoKH'])) {

        $soDonDH = (int) $_POST['soDonDH'];
        $maSoKH = (int) $_POST['maSoKH'];

        $check_success = false;

        if ($soDonDH > 0 && $maSoKH > 0) {

            $sql_cancel_purchased = "UPDATE DatHang set TrangThaiDH = -1 where SoDonDH = ".$soDonDH." and MSKH = ".$maSoKH.";";

            if(sql_execute($sql_cancel_purchased)) {

                $sql_get_total_mshh_purchased = "SELECT MSHH from chitietdathang where SoDonDH=".$soDonDH.";" ;
                $data_total_mshh_purchased = sql_query($sql_get_total_mshh_purchased);

                if(!empty($data_total_mshh_purchased)) {

                    foreach($data_total_mshh_purchased as $data_mshh_purchased) {

                        $mshh_purchased = (int) $data_mshh_purchased["MSHH"];
                        
                        $sql_get_so_luong_purchased = "SELECT SoLuong from chitietdathang where SoDonDH=".$soDonDH." and MSHH=".$mshh_purchased.";" ;
                        $sql_get_so_luong_HangHoa =  "SELECT SoLuongHang from hanghoa where MSHH=".$mshh_purchased.";" ;

                        $data_soluong_purchased = sql_query($sql_get_so_luong_purchased);
                        $data_soluong_HangHoa = sql_query($sql_get_so_luong_HangHoa);

                        $soluong_purchased = (int) $data_soluong_purchased[0]["SoLuong"];
                        $soluong_HangHoa = (int) $data_soluong_HangHoa[0]["SoLuongHang"];

                        $set_soluong_HangHoa_new = $soluong_HangHoa + $soluong_purchased;

                        $sql_call_back_so_luong = "UPDATE HangHoa set SoLuongHang=".$set_soluong_HangHoa_new." where MSHH=".$mshh_purchased.";";
                        sql_execute($sql_call_back_so_luong);
                    }

                }

                $check_success = true;
            }

        }

        if($check_success) {

            echo "cancel_successed!";
        }
        else {

            echo "cancel_fail";
        }

    }

}





// if(!empty($_POST['data']) && isset($_POST['data'])) {
    
//     $data = [];
//     $data = $_POST['data'];
//     $total_products_buy = count($data);

//     $check_success = false;
    
//     $NgayDH = date("Y-m-d");
//     $NgayGH = date("Y-m-d", strtotime($NgayDH. ' + 2 days'));
    
//     $MSNV = $MSKH = 1;
//     $SoDonDH = -1;

//     if(!empty($_SESSION['MSNV']) && isset($_SESSION['MSNV'])) {
//         $MSNV = $_SESSION['MSNV'];
//     }

//     if(!empty($_SESSION['MSKH']) && isset($_SESSION['MSKH'])) {
//         $MSKH = $_SESSION['MSKH'];
//     }

    
//     $sql_insert = "INSERT INTO DatHang(MSKH, MSNV, NgayDH, NgayGH, TrangThaiDH) values ($MSKH, $MSNV, '$NgayDH', '$NgayGH', 0)";

//     if(sql_execute($sql_insert)) {
        
//         $sql_get_last_id = "SELECT SoDonDH FROM DatHang ORDER BY SoDonDH DESC LIMIT 1";
//         $SoDonDH_temp = sql_query($sql_get_last_id);
//         $SoDonDH = (int) $SoDonDH_temp[0]['SoDonDH'];

//         // echo "So don cuoi: ".$SoDonDH;

//         $values = '';
//         if( $SoDonDH > 0) {

//             foreach($data as $dt) {

//                 $values .= "(".$SoDonDH .",". (int)$dt["MSHH"] .", ". (int)$dt["quantity"] .", ".(int)$dt["Gia"].", ".(float)$dt["discount"]."),";  
//             }

//             $values = rtrim($values, ",");
//             // echo $values;

//             $sql_insert_chi_tiet = "INSERT INTO chitietdathang (SoDonDH, MSHH, SoLuong, GiaDatHang, GiamGia) values " . trim($values) ;

//             if (sql_execute($sql_insert_chi_tiet)) {
//                 $check_success = true;
//                 // die();
//             }

//         }

//     }


//     if(!$check_success) {
//         if($SoDonDH > 0) {

//             $sql_delete = "DELETE FROM dathang where SoDonDH = ".$SoDonDH;
//             sql_execute($sql_delete);
//         }

//         echo "Đặt hàng thất bại <br>";

//     } else {

//         echo "Đặt hàng thành công (buy_success). <br>";
        
//         // foreach($data as $key) { 
            
//         // }
//     }

//     // print_r($data);
//     // echo "Đặt hàng thành công.";


// } else {
    
//     echo "Đặt hàng thất bại";
// }


