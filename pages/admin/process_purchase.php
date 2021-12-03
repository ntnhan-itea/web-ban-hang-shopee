<?php



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once("../database/init_product.php");

$action_page = '';

// Xac mhan don hang
if(isset($_POST['action_page'])) {

    $action_page = $_POST['action_page'];
}


switch ($action_page) {

    case 'comfirm_purchase':
        comfirm_purchase();
        break;

    case 'delete_product_CSDL':
        delete_product_CSDL();
        break;
}



// Xac nhan don hang
function comfirm_purchase() {

    $check_success = false;

    if( !empty($_POST['soDonDH']) && isset($_POST['soDonDH']) && 
        !empty($_POST['maSoNV']) && isset($_POST['maSoNV']) &&
        !empty($_POST['ngay_giao_hang']) && isset($_POST['ngay_giao_hang']) ) {

        $soDonDH = (int) $_POST['soDonDH'];
        $maSoNV = (int) $_POST['maSoNV'];
        $ngay_giao_hang = trim($_POST['ngay_giao_hang']);


        if ($soDonDH > 0 && $maSoNV > 0) {

            $sql_cancel_purchased = "UPDATE dathang set TrangThaiDH = 1, NgayGH='$ngay_giao_hang', MSNV=$maSoNV where SoDonDH =$soDonDH; ";


            if(sql_execute($sql_cancel_purchased)) {

                $check_success = true;
            }

        }

        
    }

    if($check_success) {

        echo "comfirm_successed!";
    }
    else {

        echo "comfirm_fail";
    }
    
}


// Xoa san pham khoi CSDL
function delete_product_CSDL() {

    $ma_hang_hoa = -1;
    $check_success = false;

    if(isset($_POST['MSHH'])) {
        $ma_hang_hoa = (int) $_POST['MSHH'];
    }

    // $sql_delete_hinh_hang_hoa = "DELETE from hinhhanghoa where MSHH=".$ma_hang_hoa.";" ;

    // $sql_get_call_back_hinh_hang_hoa ="SELECT * from hinhhanghoa where MSHH=".$ma_hang_hoa.";" ;

    // $sql_delete_hang_hoa = "DELETE from hanghoa where MSHH=".$ma_hang_hoa.";" ;

    // $sql_get_data_path_hinh_anh = "SELECT TenHinh from hinhhanghoa where MSHH=$ma_hang_hoa;";
    // $data_path_hinh_anh = sql_query($sql_get_data_path_hinh_anh);

    if($ma_hang_hoa > 0) {

        $sql_delete_hinh_hang_hoa = "DELETE from hinhhanghoa where MSHH=".$ma_hang_hoa.";" ;

        $sql_get_call_back_hinh_hang_hoa ="SELECT * from hinhhanghoa where MSHH=".$ma_hang_hoa.";" ;
        $data_call_back_hinh_hang_hoa = sql_query($sql_get_call_back_hinh_hang_hoa);

        $sql_delete_hang_hoa = "DELETE from hanghoa where MSHH=".$ma_hang_hoa.";" ;

        $sql_get_data_path_hinh_anh = "SELECT TenHinh from hinhhanghoa where MSHH=$ma_hang_hoa;";
        $data_path_hinh_anh = sql_query($sql_get_data_path_hinh_anh);

        if(sql_execute($sql_delete_hinh_hang_hoa)) {

            if(sql_execute($sql_delete_hang_hoa)) {

                foreach($data_path_hinh_anh as $path_hinh_anh) {
    
                    $path_file = "../../" . $path_hinh_anh["TenHinh"];

                    if (file_exists($path_file)) {

                        unlink($path_file);
                        echo "File Successfully Delete."; 
                    }
                    else {
                    
                        echo "File does not exists"; 
                    }
                }

                $check_success = true;
            }
            else {

                foreach($data_call_back_hinh_hang_hoa as $call_back_hinh_hang_hoa) {

                    if(!empty($call_back_hinh_hang_hoa)) {

                        $ma_hinh = (int) $call_back_hinh_hang_hoa["MaHinh"];
                        $ten_hinh = trim($call_back_hinh_hang_hoa["TenHinh"]);
                        $mshh = (int) $call_back_hinh_hang_hoa["MSHH"];

                        $sql_call_back_hinh_hang_hoa = "INSERT INTO hinhhanghoa (MaHinh, TenHinh, MSHH) VALUES ($ma_hinh, '$ten_hinh', $mshh)";
                        sql_execute($sql_call_back_hinh_hang_hoa);
                    }
                }
            }

        }

    }

    // if( ($ma_hang_hoa > 0) && sql_execute($sql_delete_hinh_hang_hoa) &&  sql_execute($sql_delete_hang_hoa) ) {

    //     foreach($data_path_hinh_anh as $path_hinh_anh) {
            
    //         $path_file = "../../" . $path_hinh_anh["TenHinh"];

    //         if (file_exists($path_file)) {

    //             unlink($path_file);
    //             echo "File Successfully Delete."; 
    //         }
    //         else {
            
    //             echo "File does not exists"; 
    //         }
    //     }

    //     $check_success = true;
    // }

    if($check_success) {

        echo "Delete_successful";
    } 
    else {

        echo "Delete_fail";
    }


}
