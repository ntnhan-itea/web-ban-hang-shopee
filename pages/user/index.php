
<!-- 
    Dự án Project Shopee Pha-Kê môn LT Web.
    Ngày khởi tạo: 13/09/2021.
    Author: Nguyen Thanh Nhan
    Student ID: B1805797
-->

<!-- 
    Ngay mai toi uu code phan load page ben duoi
    update: 22:55 18/10/2021
 -->


<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// session_unset();

if(!isset($_SESSION['cart_datas'])) {
    $_SESSION['cart_datas'] = [];
}


require_once("process_user.php");
login_process();

$title_page = 'Shopee Pha Ke';

$index_to_show_data_page = 1;
$index_page_to_get_data = 0;
$limit_get_data_per_page = 5;

$action_page = '';
$action_cart = '';
$action_buy_add = '';
$id_mshh_product_clicked = -1;


if(!empty($_GET)) {
    if(isset($_GET['page'])) {
        $index_to_show_data_page = (int) $_GET['page'];
        $index_page_to_get_data = (int) (($index_to_show_data_page - 1) * $limit_get_data_per_page);
    }

    if(isset($_GET['action_page'])) {
        $action_page = trim($_GET['action_page']);
        $_SESSION['action_page'] = $action_page;
    }

    if(isset($_GET['action_buy_add'])) {
        $action_buy_add = trim($_GET['action_buy_add']);
        $_SESSION['action_buy_add'] = $action_buy_add;
    }
    
    if(isset($_GET['id_product'])) {

        $id_mshh_product_clicked = (int) $_GET['id_product'];
        $_SESSION['id_mshh_product_clicked'] = $id_mshh_product_clicked;
    }
    

    // if(isset($_GET['sort_product'])) {
    //     $sort_product = $_GET['sort_product'];
    // }

    if(isset($_GET['action_cart'])) {
        $action_cart = trim($_GET['action_cart']);
    }

    if(isset($_GET['data_type'])) {
        $_SESSION['data_type'] = (int) $_GET['data_type'];
    }

}

if(!empty($_POST)) {
    if(isset($_POST['add_product_to_cart'])) {

        if( isset($_SESSION['check_login']) && $_SESSION['check_login'] === true ) {
            cart_process();
        } 
        else {
            echo '
                <script>
                    openModal_login();
                </script>
            ';
        }
    } 
}


switch($action_cart) {
    case 'delete':
        if(isset($_SESSION['cart_datas'])) {
            foreach($_SESSION['cart_datas'] as $key => $value) {

                if( (int) $value['MSHH'] == $id_mshh_product_clicked ) {

                    unset($_SESSION['cart_datas'][$key]);
                    $_SESSION['cart_datas'] =  array_values($_SESSION['cart_datas']);
                    break;
                }
            }
        }
        break;
}


switch ($action_page){

    case 'detail_product';
        $title_page = 'Chi tiết sản phẩm';
        break;

    case 'cart';
        $title_page = 'Giỏ hàng';
        break;
    
    case 'imp_purchase';
        $title_page = 'Quản lý đơn hàng';
        break;

    case 'my_account';
        $title_page = 'Thông tin tài khoản';
        break;
        
    case 'logout':
        logout_page();
        break;

    default:
        $title_page = 'Shopee Pha Ke';
        break;
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title_page?></title>

    <!-- Favicon Page -->
    <link rel="icon" href="../../assets/img/favicon/icon_orange.png" style="border-radius: 50px;">
    <!-- CSS icon -->
    <link rel="stylesheet" href="../../assets/icon/fontawesome-free-5.15.4-web/css/all.min.css">
    <!-- External CSS -->
    <link rel="stylesheet" href="../../assets/css/base.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
    <!-- <link rel="stylesheet" href="../../assets/css/admin.css"> -->

    <!-- Jquery -->
    <script src="../../assets/js/jquery-3.6.0.min.js"></script>
</head>

<body onload="lastModified();">

<!-- Start: Main -->
<div id="main">

    <?php 

        if(isset($_SESSION['check_login']) && $_SESSION['check_login'] === true) {
            import_header_logined();
        }else {
            imp_header();
        }

        switch ($action_page) {
            case 'detail_product':
                imp_product_info();
                break;

            case 'cart':
                imp_cart();
                break;

            case 'imp_purchase':
                imp_purchase();
                break;
            
            case 'my_account':
                my_account();
                break;
            
            case 'my_address':
                my_address();
                break;

            default: 
                imp_container($index_to_show_data_page);
                break;
        }

        imp_footer();

        imp_modal();
    ?>
    
</div>
<!-- End: Main -->


<!-- Javascript -->
<script src="../../assets/js/last-update.js"></script>
<script src="../../assets/js/main.js"></script>


</body>
</html>


