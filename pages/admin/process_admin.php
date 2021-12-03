<?php



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once("../database/init_product.php");


// Chinh sua thong tin ca nhan
if (isset($_POST['submit_save_my_info'])) {

    $ho_ten = $chuc_vu = $so_dien_thoai = $dia_chi = '';

    $MSNV = -1;

    if(isset($_SESSION['MSNV'])) {
        $MSNV = (int) $_SESSION['MSNV'];
    }

    if(isset($_POST['frmName']) && !empty($_POST['frmName'])) {
        $ho_ten = trim($_POST['frmName']);
    }

    if(isset($_POST['frmCty']) && !empty($_POST['frmCty'])) {
        $chuc_vu = trim($_POST['frmCty']);
    }

    if(isset($_POST['frmSdt']) && !empty($_POST['frmSdt'])) {
        $so_dien_thoai = trim($_POST['frmSdt']);
    }

    if(isset($_POST['frmDiaChi']) && !empty($_POST['frmDiaChi'])) {
        $dia_chi = trim($_POST['frmDiaChi']);
    }


    $sql_update_information = "
        UPDATE nhanvien SET

        HoTenNV='$ho_ten',

        ChucVu='$chuc_vu',

        SoDienThoai='$so_dien_thoai',

        DiaChi='$dia_chi' 

        where MSNV=$MSNV;

    ";

    if(sql_execute($sql_update_information)) {

        $sql_my_info = "SELECT * from nhanvien as nv where nv.MSNV=".$MSNV.";";

        $data_my_info_temp = sql_query($sql_my_info);

        $_SESSION["data_my_info"] = $data_my_info_temp;

        echo '
            <script>
                alert("Cập nhật thông tin thành công.");
            </script>
        ';

    } else {
        echo '
            <script>
                alert("Cập nhật thông tin thất bại !!");
            </script>
        ';
    }

    echo '
        <script>
            location.href = "index.php?action_page=my_infomation&id="+Math.random();
        </script>
    ';

}




// Header
function imp_header()
{

    $ten_nhan_vien = "Nhân Viên";

    if (isset($_SESSION['HoTenNV'])) {
        $ten_nhan_vien .= ": <b>" . $_SESSION['HoTenNV'] . "</b>";
    }


    echo '

        <div id="header_ad">
            <div class="grid">
                        
                <div class="header-bar">
                    <div class="header-bar__item header-bar__home">
                        <a href="index.php" class="header-bar__link-home">
                            <img src="../../assets/img/favicon/icon_orange.png" alt="logo Home" class="header-bar__img header-bar__logo">
                            <span class="header-bar__name header-bar__home-name">trang chủ</span>
                        </a>
                        <i class="header-bar__icon fas fa-angle-right"></i>
                        <span class="header-bar__name">
                            Kênh người bán
                        </span>
                    </div>


                    <div class="header-bar__item header-bar__user">
                        <img src="../../assets/img/favicon/Admin.ico" alt="default user" class="header-bar__img header-bar_img-user">
                        <!-- <img src="../../assets/img/img-default/default-user.jpg" alt="default user" class="header-bar__img header-bar_img-user"> -->
                        <span class="header-bar__user-name">
                            ' . $ten_nhan_vien . '
                        </span>

                        <div class="header-bar__user-choose">
                            <div class="header-bar__choose-item ">
                                <a href="?action_page=my_infomation" class="header-bar__user-info">Thông tin của tôi</a>
                            </div>
                            <div class="header-bar__choose-item">
                                <a href="?action_page=logout_clicked" class="header-bar__user-logout">Đăng xuất</a>
                                <!-- <a href="../pages/user/logout_page.php" class="header-bar__user-logout">Đăng xuất</a> -->
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    
    ';
}


// Container
function imp_container()
{

    $action_page = '';

    if (isset($_GET['action_page'])) {
        $action_page = $_GET['action_page'];
    }




    echo '
        <!-- Container -->
        <div id="container_ad">
            <div class="grid">
                <div class="grid__row">
    ';
    // Col 2
    imp_category();

    echo '
                    <!-- DISPLAY col-10 -->
                    <div class="grid__col-10">
                        <div class="body-container">
    ';

    switch ($action_page) {

        case 'quan_ly_don_hang':
            imp_purchase();
            // imp_quan_ly_don_hang();
            break;

        case 'quan_ly_san_pham':
            imp_quan_ly_san_pham();
            break;

        case 'my_infomation':
            my_account();
            break;

        default:
            imp_home();
            break;
    }

    // echo "----------------------------NGAN CACH--------------------------------";
    // imp_home();
    // imp_quan_ly_don_hang();
    // imp_quan_ly_san_pham();


    echo '
                        </div>
                    </div>
                    <!-- End: DISPLAY col-10 -->
    ';

    echo '
                </div>    
            </div>    
        </div>    
        <!-- End: Container -->

    ';
}



// Category
function imp_category()
{

    $all_active = $wait_active = $comfirmed_active = $cancel_active = '';
    $action_view = "";

    $all_active_prdct = $add_active_prdct = '';
    $action_product = '';

    if (isset($_GET['action_view'])) {
        $action_view = trim($_GET['action_view']);
    }


    if (isset($_GET['action_product'])) {
        $action_product = trim($_GET['action_product']);
    }


    switch ($action_view) {
        case 'wait_comfirm':
            $wait_active = "active";
            break;

        case 'comfirmed':
            $comfirmed_active = "active";
            break;

        case 'canceled':
            $cancel_active = "active";
            break;

        case 'all':
            $all_active = "active";
            break;
    }


    switch ($action_product) {
        case 'add_product':
            $add_active_prdct = "active";
            break;

        case 'all':
            $all_active_prdct = "active";
            break;
    }



    echo '

        <!-- Danh muc -->
        <div class="grid__col-2">
            <div class="category">

                <div class="category-header">
                    <i class="category-header__icon fas fa-ellipsis-v"></i>
                    <span class="category-header__name">Quản lý đơn hàng</span>
                    <i class="category-header__icon fas fa-angle-up"></i>
                    <!-- <i class="category-header__icon fas fa-angle-down"></i> -->
                </div>

                <ul class="cate-list cate-list__order">
                    <li class="cate-list__item ' . $all_active . '">
                        <a href="?action_page=quan_ly_don_hang&action_view=all&random=' . rand() . '" class="cate-list__item-link">
                            Tất cả
                        </a>
                    </li>
                    <li class="cate-list__item ' . $wait_active . '">
                        <a href="?action_page=quan_ly_don_hang&action_view=wait_comfirm&random=' . rand() . '" class="cate-list__item-link">
                            Chờ xác nhận
                        </a>
                    </li>
                    <li class="cate-list__item ' . $comfirmed_active . '">
                        <a href="?action_page=quan_ly_don_hang&action_view=comfirmed&random=' . rand() . '" class="cate-list__item-link">
                            Đã xác nhận
                        </a>
                    </li>
                    <li class="cate-list__item ' . $cancel_active . '">
                        <a href="?action_page=quan_ly_don_hang&action_view=canceled&random=' . rand() . '" class="cate-list__item-link">
                            Đơn hủy
                        </a>
                    </li>
                </ul>

                <div class="category-header">
                    <i class="category-header__icon fas fa-ellipsis-v"></i>
                    <span class="category-header__name">Quản lý sản phẩm</span>
                    <i class="category-header__icon fas fa-angle-up"></i>
                    <!-- <i class="category-header__icon fas fa-angle-down"></i> -->
                </div>

                <ul class="cate-list cate-list__product">

                    <li class="cate-list__item ' . $all_active_prdct . '">
                        <a href="?action_page=quan_ly_san_pham&action_product=all&id=' . rand() . '" class="cate-list__item-link">
                            Tất cả sản phẩm
                        </a>
                    </li>

                    <li class="cate-list__item ' . $add_active_prdct . '">
                        <a href="?action_page=quan_ly_san_pham&action_product=add_product&id=' . rand() . '" class="cate-list__item-link">
                            Thêm sản phảm
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <!-- End: danh muc -->

    ';
}


// Trang chu
function imp_home()
{

    $sql_data_mshh_empty = "SELECT MSHH from hanghoa where SoLuongHang < 1; ";
    $sql_total_purchase_wait = "SELECT COUNT(SoDonDH) as total_purchase from dathang where TrangThaiDH = 0; ";
    $sql_total_purchase_cancel = "SELECT COUNT(SoDonDH) as total_purchase from dathang where TrangThaiDH = -1; ";
    $sql_total_purchase_comfirmed = "SELECT COUNT(SoDonDH) as total_purchase from dathang where TrangThaiDH = 1; ";

    $data_mshh_empty = sql_query($sql_data_mshh_empty);
    $total_purchase_wait = sql_query($sql_total_purchase_wait);
    $total_purchase_cancel = sql_query($sql_total_purchase_cancel);
    $total_purchase_comfirmed = sql_query($sql_total_purchase_comfirmed);

    $total_mshh_empty = count($data_mshh_empty) > 0 ? count($data_mshh_empty) : 0;
    $total_purchase_wait = (int) $total_purchase_wait[0]['total_purchase'] > 0 ? (int) $total_purchase_wait[0]['total_purchase'] : 0;
    $total_purchase_cancel = (int) $total_purchase_cancel[0]['total_purchase'] > 0 ? (int) $total_purchase_cancel[0]['total_purchase'] : 0;
    $total_purchase_comfirmed = (int) $total_purchase_comfirmed[0]['total_purchase'] > 0 ? (int) $total_purchase_comfirmed[0]['total_purchase'] : 0;



    echo '
    
        <!-- TRANG CHU -->
        <div class="container-home">
            <h1 class="container-home__title">Danh sách lần làm</h1>
            
            <ul class="container-list">
                <li class="container-list__item">
                    <a href="?action_page=quan_ly_don_hang&action_view=wait_comfirm&random="' . rand() . '" class="container-list__link">
                        <p class="container-list__link-item container-list__link-count">' . $total_purchase_wait . '</p>
                        <p class="container-list__link-item container-list__link-label">Chờ xác nhận</p>
                    </a>
                </li>
                <li class="container-list__item">
                    <a href="?action_page=quan_ly_don_hang&action_view=comfirmed&random="' . rand() . '" class="container-list__link">
                        <p class="container-list__link-item container-list__link-count">' . $total_purchase_comfirmed . '</p>
                        <p class="container-list__link-item container-list__link-label">Đã xử lý</p>
                    </a>
                </li>
                <li class="container-list__item">
                    <a href="?action_page=quan_ly_don_hang&action_view=canceled&random="' . rand() . '" class="container-list__link">
                        <p class="container-list__link-item container-list__link-count">' . $total_purchase_cancel . '</p>
                        <p class="container-list__link-item container-list__link-label">Đơn hủy</p>
                    </a>
                </li>
                <li class="container-list__item">
                    <a href="?action_page=quan_ly_san_pham&action_product=empty_product&id=' . rand() . '" class="container-list__link">
                        <p class="container-list__link-item container-list__link-count">' . $total_mshh_empty . '</p>
                        <p class="container-list__link-item container-list__link-label">Sản phẩm hết hàng</p>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End: TRANG CHU -->

    ';
}


// Quan ly don hang
function imp_quan_ly_don_hang()
{

    echo '

        <!-- QUAN LY DON HANG -->
        <div class="container-order">

            <!-- MENU -->
            <div class="container-nav">
                <ul class="container-nav__list">
                    <li class="container-nav__list-item">
                        <a href="#!" class="container-nav__list-link">Tất cả</a>
                    </li>
                    <li class="container-nav__list-item">
                        <a href="#!" class="container-nav__list-link">Chờ xác nhận</a>
                    </li>
                    <li class="container-nav__list-item">
                        <a href="#!" class="container-nav__list-link">Đã xác nhận</a>
                    </li>
                    <li class="container-nav__list-item">
                        <a href="#!" class="container-nav__list-link">Đơn hủy</a>
                    </li>
                </ul>
            </div>
            <!-- End: MENU -->

            <!-- TABLE DISPLAY -->
            <div class="container-detail">
                <table class="container-table">
                    <caption class="container-table__caption">
                        <span class="container-table__caption-count">0</span>
                        Đơn hàng
                    </caption>
                    <tr>
                        <th width="100">Đơn hàng</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá tiền</th>
                        <th>Hình ảnh</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>   

                    <!-- Don hang 1 -->
                    <tr>
                        <td class="container-table__stt" rowspan="3" style="text-align:center;">1</td>
                        <td class="container-table__price">30.000</td>
                        <td>Quan Jean</td>

                        <td class="container-table__img">
                            <img src="../../assets/img//product/iphone-12.png" alt="hinh anh HH" style="height: 50px;">
                        </td>

                        <td class="container-table__price-total" rowspan="3" style="text-align:center;">100.000</td>
                        <td rowspan="3" style="text-align:center;">
                            <button class="container-table__trangthai btn btn--wait">Chờ xác nhận</button>
                        </td>
                    </tr>

                    <tr>
                        <td class="container-table__price">20.000</td>
                        <td>Ao thun</td>
                        <td class="container-table__img"><img src="../../assets/img//product/iphone-12.png" alt="hinh anh HH" style="height: 50px;"></td>

                    </tr>

                    <tr>
                        <td class="container-table__price">50.000</td>
                        <td>Dep lao</td>
                        <td class="container-table__img"><img src="../../assets/img//product/iphone-12.png" alt="hinh anh HH" style="height: 50px;"></td>

                    </tr>
                    <!-- End: don hang 1 -->

                </table>
            </div>
            <!-- End: TABLE DISPLAY -->

        </div>
        <!-- End: QUAN LY DON HANG -->   

    ';
}

// Quan ly don hang 
function imp_purchase()
{

    $check_login_admin = false;

    $action_view = "wait_comfirm";
    $all_active = $wait_active = $comfirmed_active = $cancel_active = '';
    $sql_total_DonHang = '';

    $total_DonHang = 0;
    $data_DonHang = [];

    if (!empty($_SESSION['check_login_admin']) && isset($_SESSION['check_login_admin'])) {
        $check_login_admin = $_SESSION['check_login_admin'];
    }

    if (!empty($_GET['action_view']) && isset($_GET['action_view'])) {
        $action_view = $_GET['action_view'];
    }


    switch ($action_view) {
        case 'wait_comfirm':
            $sql_total_DonHang = "SELECT SoDonDH from dathang WHERE  TrangThaiDH = 0 ";
            $wait_active = "active";
            break;

        case 'comfirmed':
            $sql_total_DonHang = "SELECT SoDonDH from dathang WHERE TrangThaiDH = 1 ";
            $comfirmed_active = "active";
            break;

        case 'canceled':
            $sql_total_DonHang = "SELECT SoDonDH from dathang WHERE  TrangThaiDH = -1 ";
            $cancel_active = "active";
            break;

        default:
            $sql_total_DonHang = "
                SELECT SoDonDH from dathang 
            ";
            $all_active = "active";
            break;
    }

    $sql_total_DonHang .= " ORDER BY SoDonDH ASC;";

    $data_DonHang_temp = [];
    $data_DonHang_temp = sql_query($sql_total_DonHang);

    $total_DonHang = count($data_DonHang_temp);

    if ($total_DonHang > 0) {

        $data_DonHang = $data_DonHang_temp;
    } else {

        $total_DonHang = 0;
        $data_DonHang = [];
    }

    $_SESSION['data_DonHang'] = $data_DonHang;

    echo '
    
      
                            
                            <!-- QUAN LY DON HANG -->
                            <div class="container-order">

                                <!-- MENU -->
                                <div class="container-nav">
                                    <ul class="container-nav__list">
                                        <li class="container-nav__list-item ' . $all_active . '" id="test" onclick="return active_container_nav(this); return false;">
                                            <a href="?action_page=quan_ly_don_hang&action_view=all&random=' . rand() . '" class="container-nav__list-link">Tất cả</a>
                                        </li>
                                        <li class="container-nav__list-item ' . $wait_active . '">
                                            <a href="?action_page=quan_ly_don_hang&action_view=wait_comfirm&random=' . rand() . '" class="container-nav__list-link">Chờ xác nhận</a>
                                        </li>
                                        <li class="container-nav__list-item ' . $comfirmed_active . '">
                                            <a href="?action_page=quan_ly_don_hang&action_view=comfirmed&random=' . rand() . '" class="container-nav__list-link">Đã xác nhận</a>
                                        </li>
                                        <li class="container-nav__list-item ' . $cancel_active . '">
                                            <a href="?action_page=quan_ly_don_hang&action_view=canceled&random=' . rand() . '" class="container-nav__list-link">Đơn hủy</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End: MENU -->

                                <!-- TABLE DISPLAY -->
                                <div class="container-detail">
                                    <table class="container-table">
                                        <caption class="container-table__caption" >
                                            <h1 style="font-size: 3rem;">
                                               <!-- <span class="container-table__caption-count" > ' . $total_DonHang . ' </span> -->
                                                ' . $total_DonHang . ' Đơn hàng
                                            </h1>
                                        </caption>
                                        <tr>
                                            <th width="100">Đơn hàng</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá tiền</th>
                                            <th>Hình ảnh</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                        </tr>   

    ';

    $stt = 0;
    foreach ($data_DonHang as $soDH) {

        if (!empty($soDH)) {

            $stt++;

            $color_stt = "#000";
            if ($stt % 2 == 0) {
                $color_stt = "#999";
            }

            $sql_data_purchase = "
                SELECT * FROM 
                nhanvien as nv join dathang as dh on nv.MSNV = dh.MSNV
                JOIN khachhang as kh on kh.MSKH = dh.MSKH
                JOIN chitietdathang as ctdh on ctdh.SoDonDH = dh.SoDonDH 
                JOIN hanghoa as hh on hh.MSHH = ctdh.MSHH
                JOIN hinhhanghoa as hhh on hhh.MSHH = hh.MSHH 
                JOIN loaihanghoa as lhh on lhh.MaLoaiHang = hh.MaLoaiHang
                where ctdh.SoDonDH = " . (int)$soDH["SoDonDH"] . "
                ORDER BY dh.SoDonDH DESC;
            ";

            $data_details = sql_query($sql_data_purchase);

            $count_product_purchased = count(sql_query($sql_data_purchase));

            if ($count_product_purchased < 1) {

                continue;
            }

            $count_print_colspan = 0;
            $total_price = 0;

            foreach ($data_details as $data) {

                $total_price += ((int)$data['SoLuong'] * (int)$data['Gia'] * (1 - (float)$data['GiamGia']));
            }

            foreach ($data_details as $data) {

                $status = (int) $data['TrangThaiDH'];
                $status_display = '';
                $color_status_purchase = '';

                $MSNV_now = (int) $data['MSNV'];

                if (!empty($_SESSION['MSNV']) && isset($_SESSION['MSNV'])) {
                    $MSNV_now = (int) $_SESSION['MSNV'];
                }

                switch ($status) {
                    case 1:
                        $status_display = "Đã xác nhận";
                        $color_status_purchase = "#28A745";
                        break;

                    case -1:
                        $status_display = "Đã hủy đơn";
                        $color_status_purchase = "#DC3545";
                        break;

                    default:
                        $status_display = "Chờ xác nhận";
                        $color_status_purchase = "#007BFF";
                        break;
                }

                if (!empty($data)) {

                    $ngayDH_format = strtotime($data["NgayDH"]);
                    $ngayDH_format = date("d-m-Y", $ngayDH_format);


                    if ($count_print_colspan == 0) {
                        echo '
                        
                            <!-- Don hang ' . $stt . ' -->
                            <tr>
                                <td class="container-table__stt" rowspan="' . $count_product_purchased . '" style="text-align:center; font-weight: bold; 
                                    color: ' . $color_stt . '"> 
                                    ' . $stt . ' 
                                    <p style="color: var(--primary-color);"><i>(' . $ngayDH_format . ')</i></p>

                        ';
                        if ($check_login_admin) {
                            echo '
                                        <p><i> (MSNV: ' . $data['MSNV'] . ') </i></p>
                                        <p><i> (MSKH: ' . $data['MSKH'] . ') </i></p>
                                        <p><i> (Mã Đơn: ' . $data['SoDonDH'] . ') </i></p>
                                    ';
                        }
                        echo '

                                </td>

                                <td class="container-table__price">' . $data["TenHH"] . '  <b>(x' . $data["SoLuong"] . ')</b> </td>

                                <td style="text-align: center;">
                                    ' . format_money($data["Gia"]) . ' <sup>đ</sup> 
                        ';
                        if ((float)$data["GiamGia"] > 0) {
                            echo '
                                            <p style="color: var(--primary-color);"><i>(-' . round((float)$data["GiamGia"] * 100, 2) . '%)</i></p>
                                        ';
                        }
                        echo '
                                </td>
                
                                <td>
                                    <a href="?action_page=detail_product&id_product=' . $data["MSHH"] . '" style="text-align: center; display: block;">
                                        <img src="../../' . $data["TenHinh"] . '" alt="hinh anh HH" style="height: 50px; box-shadow: 0 0 4px rgba(0, 0, 0, 0.4)">
                                    </a>
                                </td>
                
                                <td class="container-table__price-total" rowspan="' . $count_product_purchased . '" style="text-align:center; color: var(--primary-color)">
                                    ' . format_money($total_price) . ' <sup>đ</sup>
                                </td>

                                <td rowspan="' . $count_product_purchased . '" style="text-align:center;">
                                    <div class="container-table__trangthai-col">
                                        <p class="container-table__trangthai" style="font-weight: bold; color: ' . $color_status_purchase . '">
                                            (' . $status_display . ')
                                        </p> 
                                        <br>
                        ';
                        if ((int) $data['TrangThaiDH'] === 0) {

                            $maxDate = date('Y-m-d', strtotime($data['NgayDH'] . ' + 30 days'));

                            echo '
                                        <button class="container-table__trangthai btn btn--success" value="' . $stt . '" 
                                            onclick="comfirm_purchased(' . (int)$data["SoDonDH"] . ', ' . $MSNV_now . ', \'ngay_giao_hang_' . (int)$data["SoDonDH"] . '\',' . $stt . ');">
                                            XÁC NHẬN
                                        </button>
                                        <br> <br>
                                        <p>
                                            Ngày giao hàng <br>
                                            <input min="' . $data['NgayDH'] . '" max="' . $maxDate . '" 
                                                type="date" 
                                                id="ngay_giao_hang_' . (int)$data["SoDonDH"] . '" 
                                                value="' . $data['NgayGH'] . '">
                                        </p>
                                    ';
                        } else {
                            if ((int) $data['TrangThaiDH'] === 1) {
                                echo '
                                        
                                            <p>
                                                Ngày giao hàng <br>
                                                <input min="' . $data['NgayDH'] . '" type="date" id="ngay_giao_hang_' . (int)$data["SoDonDH"] . '" value="' . $data['NgayGH'] . '" readonly>
                                            </p>
                                        
                                        ';
                            }
                        }
                        echo '
                                    </div>
                                </td>
                            </tr>

                        ';

                        $count_print_colspan += 1;
                    } else {

                        echo '
                        
                            <!-- Don hang ' . $stt . ' -->
                            <tr>
    
                                <td class="container-table__price">' . $data["TenHH"] . '  <b>(x' . $data["SoLuong"] . ')</b> </td>
    
                                <td style="text-align: center;">
                                    ' . format_money($data["Gia"]) . ' <sup>đ</sup> 
                        ';
                        if ((float)$data["GiamGia"] > 0) {
                            echo '
                                           <p style="color: var(--primary-color);"><i>(-' . round((float)$data["GiamGia"] * 100, 2) . '%)</i></p>
                                        ';
                        }
                        echo '
                                </td>
                
                                <td>
                                    <a href="?action_page=detail_product&id_product=' . $data["MSHH"] . '" style="text-align: center; display: block;">
                                        <img src="../../' . $data["TenHinh"] . '" alt="hinh anh HH" style="height: 50px; box-shadow: 0 0 4px rgba(0, 0, 0, 0.4)">
                                    </a>
                                </td>
                
                            </tr>
            
            
                            <!-- End: don hang ' . $stt . ' -->
                        
                        ';
                    }
                }
            }
        }
    }

    echo '

                                    </table>
                                </div>
                                <!-- End: TABLE DISPLAY -->

                            </div>
                            <!-- End: QUAN LY DON HANG -->

 
    
    ';
}


// Quan ly san pham
function imp_quan_ly_san_pham()
{

    $action_product = '';

    if (isset($_GET['action_product'])) {
        $action_product = $_GET['action_product'];
    }

    echo '

        <!-- QUẢN LY SAN PHAM -->
        <div class="container-product">

            <!-- MENU -->
            <div class="container-nav">
                <ul class="container-nav__list">
                    <li class="container-nav__list-item">
                        <a href="?action_page=quan_ly_san_pham&action_product=all&id=797491939" class="container-nav__list-link">Tất cả</a>
                    </li>
                    <li class="container-nav__list-item">
                        <a href="?action_page=quan_ly_san_pham&action_product=add_product&id=969792180" class="container-nav__list-link">Thêm sản phẩm</a>
                    </li>
                    <!-- <li class="container-nav__list-item">
                        <a href="#!" class="container-nav__list-link">Sửa sản phẩm</a>
                    </li>
                    <li class="container-nav__list-item">
                        <a href="#!" class="container-nav__list-link">Xóa sản phẩm</a>
                    </li> -->
                </ul>
            </div>
            <!-- End: MENU -->
    ';


    switch ($action_product) {

        case 'edit_product':
            imp_edit_product();
            break;

        case 'add_product':
            imp_add_product();
            break;

        case 'detail_product':
            imp_detail_product_product();
            break;


        default:
            imp_all_products();
            break;
    }

    // imp_detail_product_product();


    echo '

        </div>
        <!-- End: QUAN LY SAN PHAM -->

    ';
}


// Hien thi san phan
function imp_all_products()
{

    $action_product = '';
    $view_product_empty = '';
    $name_empty = '';

    if (isset($_GET['action_product'])) {

        $action_product = trim($_GET['action_product']);
        if ($action_product == 'empty_product') {

            $view_product_empty = "where SoLuongHang < 1";
            $name_empty = '(Hết hàng)';
        }
    }



    $path_hinh_anh = "../../";

    $sql_all_data_hanghoa = "SELECT * from hanghoa as hh left join hinhhanghoa as hhh on hh.MSHH = hhh.MSHH join loaihanghoa as lhh 
                                on lhh.MaLoaiHang = hh.MaLoaiHang $view_product_empty;";

    $all_data_hanghoa = sql_query($sql_all_data_hanghoa);

    $total_hanghoa = count($all_data_hanghoa) > 0 ? count($all_data_hanghoa) : 0;


    echo '
    
        <!-- TABLE DISPLAY SAN PHAM -->
        <div class="container-product__all">

            <table class="container-table">
                <caption class="container-table__caption">
                    <span class="container-table__caption-count" style="font-size: 3rem;">' . $total_hanghoa . ' Sản phẩm ' . $name_empty . '</span>
                    
                </caption>
                <tr>
                    <th width="100">Mã Hàng <br> (ID)</th>
                    <th>Tên sản phẩm</th>
                    <th>Loại sản phẩm</th>
                    <th>Giá tiền</th>
                    <th>Số lượng</th>
                    <th>hình ảnh</th>
                    <th>Hàng động</th>
                </tr>   
    ';
    $stt = 1;
    foreach ($all_data_hanghoa as $hanghoa) {
        if (!empty($hanghoa)) {

            echo '
                    
                    <!-- SP ' . $stt++ . ' -->
                    <tr>
                        <td class="container-table__id" style="text-align:center;">' . (int)$hanghoa["MSHH"] . '</td>
                        <td class="container-table__name" style="max-width: 365px; overflow:hidden;">' . $hanghoa["TenHH"] . '</td>
                        <td class="container-table__name">' . $hanghoa["TenLoaiHang"] . ' <br> (ID: ' . $hanghoa['MaLoaiHang'] . ')</td>
                        <td class="container-table__price">' . format_money($hanghoa["Gia"]) . ' <sup>đ</sup></td>
                        <td class="container-table__detail" style="text-align:center;">
                        ' . $hanghoa["SoLuongHang"] . '
                        </td>

                        <td class="container-table__img"> 
                            <img src="' . $path_hinh_anh . $hanghoa["TenHinh"] . '" alt="product" style="width: 100%;">
                        </td>

                        <td style="text-align:center;">
                            <!-- <button class="container-table__edit btn" onclick="return edit_product_admin(' . (int)$hanghoa["MSHH"] . ');">Edit</button> -->

                            <button class="container-table__edit btn" 
                                onclick="location.href = \'?action_page=quan_ly_san_pham&action_product=edit_product&mshh=' . (int)$hanghoa["MSHH"] . '&random=\' + Math.random() ">
                                Edit
                            </button>
                            <br> <br>
                            <button class="container-table__delete btn" onclick="return delete_product_admin(' . (int)$hanghoa["MSHH"] . ');">Delete</button>
                        </td>
                    </tr>
                    <!-- End: SP ' . $stt++ . ' -->
                    
                    ';
        }
    }


    echo '

            </table>
        </div>
        <!-- End: TABLE DISPLAY SAN PHAM -->    
    
    ';
}


// chi tiet san pham 
function imp_detail_product_product()
{

    echo '
    
        <!-- Chi tiet San pham  -->
        <div class="container-detail">
            <!-- SP 1 -->
            <div class="container-detail__content">
                <div class="container-detail__item">
                    <div class="container-detail__header">
                        <span class="container-detail__label">San pham 1</span>
                        <!-- <span class="container-detail__trangthai">đang giao</span> -->
                    </div>
                </div>
                <div class="container-detail__item">
                    <a href="#!" class="container-detail__sanpham">
                        <div class="container-detail__sanpham-img">
                            <img src="../../assets/img/product/imacbook.png" alt="san pham" class="container-detail__sanpham-img--img">
                        </div>
                        <div class="container-detail__sanpham-mota">
                            <div class="container-detail__sanpham-name">
                            (SIÊU DÀY) Miếng lót ngồi nâng chiều cao xe oto, nệm đệm ghế ngồi ôtô, gối ôm thú bông
                            </div>
                            <div class="container-detail__sanpham-quantity">
                                x1
                            </div>
                        </div>
                        <div class="container-detail__sanpham-total">
                            VND 155.000
                        </div>
                    </a>
                </div>
            </div>
            <!-- End: SP 1 -->
        </div>
        <!-- End: Chi tiet San pham -->
    
    ';
}

// Them san pham
function imp_add_product()
{

    $sql_get_data_loai_SP = "SELECT * FROM loaihanghoa;";
    $data_loai_hang = sql_query($sql_get_data_loai_SP);


    echo '
    
        <!-- ADD PRODUCT -->
        <div class="container-product__add">
            <div class="product-add__title">thêm sản phẩm</div>

            <form action="upload.php" method="post" enctype="multipart/form-data" runat="server">

                <label for="prd_type">Loại hàng hóa</label> 
                <br>
                <select name="prd_type" id="prd_type">
    ';
    foreach ($data_loai_hang as $loaihang) {
        echo '
                    <option value="' . (int)$loaihang['MaLoaiHang'] . '"> ' . (int)$loaihang['MaLoaiHang'] . ' - ' . $loaihang['TenLoaiHang'] . '</option>
                ';
    }
    echo '
                </select>
                <br><br>

                <label for="prd_name">Tên hàng hóa</label> 
                <br>
                <input type="text" name="prd_name" id="prd_name" required>
                <br><br>

                <label for="prd_detail">Mô tả hàng hóa</label> 
                <br>
                <textarea name="prd_detail" id="prd_detail" rows="4" cols="50" required></textarea>
                <br><br>

                <label for="prd_price">Giá bán (VNĐ)</label> 
                <i id="price_format" style="color: red;"></i>
                <br>
                <input type="number" min="1000" name="prd_price" id="prd_price" required>
                <br><br>

                <label for="prd_count">Số lượng hàng đang có</label> 
                <br>
                <input type="number" min="1" max="1000" name="prd_count" id="prd_count" required>
                <br><br>

                <label for="fileToUpload">Hình ảnh</label> 
                <input type="file" name="fileToUpload" id="fileToUpload" onchange="loadFile(event)" required>
                <img id="output" src="" style="width: 70px;">

                <br><br><br><br>

                <input type="submit" name="submit_add_product" value="Thêm" class="btn btn--success"> 
                <input type="reset" class="btn btn--wait">
            </form>
        </div>
        <!-- End: ADD PRODUCT -->
    
    ';
}


// Them san pham
function imp_edit_product()
{

    $path_img = "../../";

    $mshh = -1;

    if (isset($_GET['mshh'])) {
        $mshh = (int) $_GET['mshh'];
    }

    if ($mshh < 1) {
        alert_js("Không tìm thấy thông tin hàng hóa !!");
        echo '
            <script>location.href="?action_page=quan_ly_san_pham&action_product=all&id=" + Math.random();</script>
        ';
        die();
    }

    $sql_get_data_loai_SP = "SELECT * FROM loaihanghoa;";
    $data_loai_hang = sql_query($sql_get_data_loai_SP);

    $data_hang_hoa = get_data_by_mshh($mshh);

    echo '
    
        <!-- ADD PRODUCT -->
        <div class="container-product__add">
            <div class="product-add__title">Sửa sản phẩm</div>

            <form action="upload.php" method="post" enctype="multipart/form-data" runat="server">

                <label for="prd_type">Loại hàng hóa</label> 
                <br>
                <select name="prd_type" id="prd_type">
    ';
    foreach ($data_loai_hang as $loaihang) {

        if ((int) $loaihang["MaLoaiHang"] === (int) $data_hang_hoa[0]["MaLoaiHang"]) {

            echo '
                        <option value="' . (int)$loaihang['MaLoaiHang'] . '" selected> ' . (int)$loaihang['MaLoaiHang'] . ' - ' . $loaihang['TenLoaiHang'] . '</option>
                    ';
        } else {

            echo '
                        <option value="' . (int)$loaihang['MaLoaiHang'] . '"> ' . (int)$loaihang['MaLoaiHang'] . ' - ' . $loaihang['TenLoaiHang'] . '</option>
                    ';
        }
    }
    echo '
                </select>
                <br><br>

                <label for="prd_name">Tên hàng hóa</label> 
                <br>
                <input type="text" name="prd_name" id="prd_name" value=' . $data_hang_hoa[0]["TenHH"] . ' required>
                <br><br>

                <input type="hidden" name="mshh_to_edit" value="' . $mshh . '">

                <label for="prd_detail">Mô tả hàng hóa</label> 
                <br>
                <textarea name="prd_detail" id="prd_detail" rows="4" cols="50" required>' . $data_hang_hoa[0]["QuyCach"] . '</textarea>
                <br><br>

                <label for="prd_price">Giá bán (VNĐ)</label> 
                <i id="price_format" style="color: red;"></i>
                <br>
                <input type="number" min="1000" name="prd_price" id="prd_price" value="' . (float)$data_hang_hoa[0]["Gia"] . '" required>
                <br><br>

                <label for="prd_count">Số lượng hàng đang có</label> 
                <br>
                <input type="number" min="1" max="1000" name="prd_count" id="prd_count" value="' . $data_hang_hoa[0]["SoLuongHang"] . '" required>
                <br><br>

                <label for="fileToUpload">Hình ảnh</label> 
                <input type="file" name="fileToUpload" id="fileToUpload" onchange="loadFile(event)">

                <img id="output" src="' . $path_img . $data_hang_hoa[0]['TenHinh']  . '" style="width: 70px; border: 1px solid #ccc;">

                <br><br><br><br>

                <input type="submit" name="submit_edit_product" value="Lưu" class="btn btn--success" onclick="return confirm(\'XÁC NHẬN CHỈNH SỬA THÔNG TIN ??\');"> 
            </form>

                <button class="btn btn--danger" onclick="location.href =\'index.php?action_page=quan_ly_san_pham&action_product=all&id=\' + Math.random()" style="margin-top: 24px;">Hủy bỏ</button>
        </div>
        <!-- End: ADD PRODUCT -->
    
    ';
}


// Footer
function imp_footer()
{

    echo '

        <div id="phan-cach"></div>
        <!-- Start: Footer -->
        <footer id="footer">
            <div class="grid">
                <div class="grid__row">
                    <!-- Column 1 -->
                    <div class="grid__col-2-x5">
                        <div class="footer-container">
                            
                            <div class="footer-container__header">CHĂM SÓC KHÁCH HÀNG</div>
        
                            <ul class="footer-container__list">
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Hướng dẫn mua hàng
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Hướng dẫn bán hàng
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Thanh toán
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Shopee Xu
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Vận chuyển
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Trả hàng & Hoàn tiền
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Chăm sóc khách hàng
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Chính sách bảo hành
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Hướng dẫn mua hàng
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Shopee Mall 
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Shopee Blog
                                </a></li>
                            </ul>
                        </div>
        
                    </div>
                    <!-- End: Column 1 -->
        
                    <!-- Column 2 -->
                    <div class="grid__col-2-x5">
                        <div class="footer-container">
                            
                            <div class="footer-container__header">VỀ SHOPEE</div>
        
                            <ul class="footer-container__list">
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Giới Thiệu Về Shopee Việt Nam
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Tuyển Dụng
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Điều Khoản Shopee
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Chính Sách Bảo Mật
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Chính Hãng
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Kênh Người Bán
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Flash Sales
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Chương Trình Tiếp Thị Liên Kết Shopee
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Liên Hệ Với Truyền Thông
                                </a></li>
                            </ul>
                        </div>
        
                    </div>
                    <!-- End: Column 2 -->
        
                    <!-- Column 3 -->
                    <div class="grid__col-2-x5" style="visibility:hidden;">
                        <div class="footer-container" style="display: none;">
                            
                            <div class="footer-container__header">Thanh toán</div>
        
                            <ul class="footer-container__list">
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    <div class="bg-img" style="background-image: url("https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/assets/4bdefde103e8aa245cd17511adde9f89.png"); padding-top: 100%;"></div>
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Hướng dẫn bán hàng
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Thanh toán
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Shopee Xu
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Vận chuyển
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Trả hàng & Hoàn tiền
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Chăm sóc khách hàng
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Chính sách bảo hành
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Hướng dẫn mua hàng
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Shopee Mall 
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    Shopee Blog
                                </a></li>
                            </ul>
                        </div>
        
                    </div>
                    <!-- End: Column 3 -->
        
                    <!-- Column 4 -->
                    <div class="grid__col-2-x5">
                        <div class="footer-container">
                            
                            <div class="footer-container__header">THEO DÕI CHÚNG TÔI TRÊN</div>
        
                            <ul class="footer-container__list">
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    <i class="fab fa-facebook"></i>
                                    Facebook
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    <i class="fab fa-instagram-square"></i>
                                    Instagram
                                </a></li>
                                <li class="footer-container__item"><a href="#!" class="footer-container__link">
                                    <i class="fab fa-linkedin"></i>
                                    LinkedIn
                                </a></li>
                            </ul>
                        </div>
        
                    </div>
                    <!-- End: Column 4 -->
        
                    <!-- Column 5 -->
                    <div class="grid__col-2-x5">
                        <div class="footer-container">
                            
                            <div class="footer-container__header">TẢI ỨNG DỤNG SHOPEE NGAY THÔI</div>
        
                            <div class="download-app">
                                <img src="../../assets/img/img-download/code-QR.png" alt="QR Code Download" class="img-qr">
        
                                <div class="link-app">
                                    <img src="../../assets/img/img-download/app-store.png" alt="Link App Store" class="app-item">
                                    <img src="../../assets/img/img-download/gg-play.png" alt="Link Google play" class="app-item">
                                </div>
                            </div>
                        </div>
        
                    </div>
                    <!-- End: Column 5 -->
                </div>
        
                <hr>
        
                <div class="copy-right">
                    © 2021 Shopee. Tất cả các quyền được bảo lưu.
                </div>
            </div>
        </footer>
        <!-- End: Footer -->
    
    ';
}



// Quan ly tai khoan.
function my_account() {

    $data_my_info = [];
    $ho_ten = $so_dien_thoai = '';
    $ten_cty = '';
    $dia_chi = '';


    // Ma so khach hang
    $MSNV = -1;

    if(isset($_SESSION['MSNV'])) {
        $MSNV = (int) $_SESSION['MSNV'];
    }

    if (!isset($_SESSION["data_my_info"]) || empty($_SESSION["data_my_info"])) {
        
        
        $sql_my_info = "SELECT * from nhanvien as nv where nv.MSNV=".$MSNV.";";

        $data_my_info_temp = sql_query($sql_my_info);

        $_SESSION["data_my_info"] = $data_my_info_temp;

        $data_my_info = $data_my_info_temp;
    
    } 

    if(isset($_SESSION["data_my_info"])) {
        $data_my_info = $_SESSION["data_my_info"];
    }
    
    
    if(!empty( $data_my_info[0]["HoTenNV"])) {
        $ho_ten = trim($data_my_info[0]["HoTenNV"]);
    }
    if(!empty( $data_my_info[0]["SoDienThoai"])) {
        $so_dien_thoai = trim($data_my_info[0]["SoDienThoai"]);
    }
    if(!empty( $data_my_info[0]["DiaChi"])) {
        $dia_chi =  trim($data_my_info[0]["DiaChi"]);
    }
    if(!empty( $data_my_info[0]["ChucVu"])) {
        $ten_cty =  trim($data_my_info[0]["ChucVu"]);
    }



    echo '

                            <!-- Profile -->
                            <div class="container-account" style="
                                padding: 24px;
                            ">
                                <h1 class="container-account__header" style="font-size: 3rem; padding-bottom: 32px;">
                                    Hồ sơ của tôi
                                </h1>

                                <div class="container-profile">
                                    <form action="process_admin.php" method="post" name="frmProfile" >

                                        <label class="frm-label" for="frmName">Họ và Tên</label> <br>
                                        <input class="frm-input frm-input--focus" type="text" name="frmName" id="frmName" value="'.$ho_ten.'">
                                        <br><br>

                                        <label class="frm-label" for="frmCty">Chức vụ</label> <br>
                                        <input class="frm-input frm-input--focus" type="text" name="frmCty" id="frmCty" value="'.$ten_cty.'">
                                        <br><br>

                                        <label for="frmDiaChi" class="frm-label">Địa Chỉ</label>
                                        <input type="text" name="frmDiaChi" id="frmDiaChi" class="frm-input frm-input--focus" value="'.$dia_chi.'">
                                        <br><br>

                                        <label class="frm-label" for="frmSdt">Số điện thoại</label> <br>
                                        <input class="frm-input frm-input--focus" type="text" name="frmSdt" id="frmSdt" value="'.$so_dien_thoai.'">
                                        <br><br>
    ';
    
    echo '

                                        <input type="submit" name="submit_save_my_info" value="Lưu" class="btn btn--primary" 
                                            onclick="return confirm(\'Xác nhận chỉnh sửa thông tin ?\')">
                                    </form>

                                </div>        
                            </div>
                            <!-- End: Profile -->

                

    ';
}



// Fomat Money
function format_money($money)
{

    return number_format($money, 0, ",", ".");
}


// alert js
function alert_js($message)
{
    echo '
        <script>
            alert("' . $message . '");        
        </script>
    ';
}
