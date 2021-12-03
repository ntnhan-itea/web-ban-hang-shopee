<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once ("process_admin.php");

    if(!empty($_GET)) {
        if(isset($_GET['action_page']) && $_GET['action_page'] == 'logout_clicked') {

            session_unset();
            session_destroy();
            header('Location: ../user/');
            die();
        }
    }


    if(!empty($_SESSION)) {
        if(isset($_SESSION['check_login_admin']) && $_SESSION['check_login_admin'] !== true) {
            header('Location: ../user/');
            die();
        }

        if(!isset($_SESSION['check_login']) || $_SESSION['check_login'] !== true) {
            header('Location: ../user/');
            die();
        }
    }

    $title_page = "";
    $check_title = '';

    if(isset($_GET['action_page'])) {
        $check_title = $_GET['action_page'];
    }

    switch ($check_title) {

        case 'quan_ly_don_hang';
            $title_page = "Quản lý đơn hàng";
            break;

        case 'quan_ly_san_pham';
            $title_page = "Quản lý sản phẩm";
            break;

        default:
            $title_page = "Trang Chủ Admin";
            break;
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Trang Chủ ADMIN</title> -->
    <title><?=$title_page?></title>

    <!-- Favicon Page -->
    <link rel="icon" href="../../assets/img/favicon/Admin.ico" style="border-radius: 50px;">
    
    <link rel="stylesheet" href="../../assets/css/base.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="stylesheet" href="../../assets/icon/fontawesome-free-5.15.4-web/css/all.min.css">

    <!-- Jquery -->
    <script src="../../assets/js/jquery-3.6.0.min.js"></script>
    <!-- Thu vien Moment xu ly dinh dang ngay thang -->
    <script src="../../assets/js/moment.min.js"></script>
</head>
<body>

    <div id="main_ad">

        <?php 
            imp_header();
        
            imp_container();

            // imp_footer();
        ?>

    </div>

    <!-- Javasript -->
    <script src="../../assets/js/admin.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>
</html>