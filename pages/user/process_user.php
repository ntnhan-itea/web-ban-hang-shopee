
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once("../database/init_product.php");


if(isset($_POST['delete_dia_chi_kh']) && !empty($_POST['delete_dia_chi_kh'])) {
    delete_dia_chi_kh();
}

if(isset($_POST['add_new_addresses']) && !empty($_POST['add_new_addresses'])) {
    process_add_new_address();
}


if(isset($_POST['update_address']) && !empty($_POST['update_address'])) {
    process_update_addresses();
}


// Chinh sua thong tin ca nhan
if (isset($_POST['submit_save_my_info'])) {

    $ho_ten = $ten_cty = $so_dien_thoai = $so_fax = '';

    $MSKH = -1;

    if(isset($_SESSION['MSKH'])) {
        $MSKH = (int) $_SESSION['MSKH'];
    }

    if(isset($_POST['frmName']) && !empty($_POST['frmName'])) {
        $ho_ten = trim($_POST['frmName']);
    }

    if(isset($_POST['frmCty']) && !empty($_POST['frmCty'])) {
        $ten_cty = trim($_POST['frmCty']);
    }

    if(isset($_POST['frmSdt']) && !empty($_POST['frmSdt'])) {
        $so_dien_thoai = trim($_POST['frmSdt']);
    }

    if(isset($_POST['frmFax']) && !empty($_POST['frmFax'])) {
        $so_fax = trim($_POST['frmFax']);
    }


    $sql_update_information = "
        UPDATE khachhang SET

        HoTenKH='$ho_ten',

        TenCongTy='$ten_cty',

        SoDienThoai='$so_dien_thoai',

        SoFax='$so_fax' 

        where MSKH=$MSKH;

    ";

    if(sql_execute($sql_update_information)) {

        $sql_my_info = "SELECT * from khachhang as kh left join diachikh as dc on kh.MSKH = dc.MSKH where kh.MSKH=".$MSKH.";";

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
            location.href = "index.php?action_page=my_account&id="+Math.random();
        </script>
    ';

}




// Login Process
function login_process() {
    
    if(!isset($_SESSION['check_login'])) {
        login_page();
    } 
    else if(isset($_SESSION['check_login']) && $_SESSION['check_login'] == true) {
    
        if(isset($_SESSION['check_login_admin']) && $_SESSION['check_login_admin'] == true) {
            header('Location: ../admin/');
            die();
        }
    } 
    
}


// Log out page
function logout_page() {
    
    session_unset();
    session_destroy();
 
    header('Location: index.php');
    die();
}

// Login page
function login_page() {

    $username = $password ='';

    if(isset($_POST['btn_login_clicked'])) {

        if(isset($_POST['username'])) {
            $username = trim($_POST['username']);
        }
        if(isset($_POST['password'])) {
            $password = trim($_POST['password']);
        }

        if(!empty($username) && !empty($password)) {

            $sql_user = "
                SELECT * FROM
                account_user as au left join khachhang as kh on au.MSKH = kh.MSKH join diachikh as dc on dc.MSKH = kh.MSKH
                where au.username='$username' and au.password='$password' ;
            ";
            
            // $sql_user = "SELECT * FROM account_user where username='".$username."' and password='".$password."';";

            $data_user = sql_query($sql_user);

            if(!empty($data_user) && $data_user != null ) {

                $_SESSION['check_login'] = true;
                $_SESSION['check_login_admin'] = false;

                $_SESSION['data_my_info'] = $data_user;

                $_SESSION['username'] = $data_user[0]['username'];
                $_SESSION['MSKH'] = (int) $data_user[0]['MSKH'];
                // $_SESSION['HoTenKH'] = $data_user[0]['HoTenKH'];
                
                return true;
            } 
            else {
                echo '
                    <script>
                        alert("Sai tài khoản hoặc mật khẩu ! (Fail)");
                    </script>
                ';
            }
            
        }

    } else {

        if(isset($_POST['btn_login_clicked_admin'])) {

            if(isset($_POST['username'])) {
                $username = trim($_POST['username']);
            }
            if(isset($_POST['password'])) {
                $password = trim($_POST['password']);
            }
    
            if(!empty($username) && !empty($password)) {
    
                $sql_user = "
                    SELECT * FROM 
                    account_admin as aa join nhanvien as nv on aa.MSNV = nv.MSNV
                    where username='$username' and password='$password' ;
                ";
                
                // $sql_user = "SELECT * FROM account_admin where username='".$username."' and password='".$password."';";

                $data_user = sql_query($sql_user);
    
                if(!empty($data_user) && $data_user != null ) {
    
                    $_SESSION['check_login'] = true;
                    $_SESSION['check_login_admin'] = true;
    
                    $_SESSION['username'] = $data_user[0]['username'];
                    $_SESSION['HoTenNV'] = $data_user[0]['HoTenNV'];
                    $_SESSION['MSNV'] = (int) $data_user[0]['MSNV'];

                    header("Location: ../admin/");
                    die();
                    
                    // return true;
                }
                else {
                    echo '
                        <script>
                            alert("Sai tài khoản hoặc mật khẩu ! (Fail)");
                        </script>
                    ';
                }
            }
            
        }

    }

    // return false;

}


// Register account
function register_account() {

    $username = $password = $repeatPwd ='';

    if(isset($_POST['submit_register_form'])) {

        if(isset($_POST['username'])) {
            $username = trim($_POST['username']);
        }
        if(isset($_POST['password'])) {
            $password = trim($_POST['password']);
        }
        if(isset($_POST['repeatPwd'])) {
            $repeatPwd = trim($_POST['repeatPwd']);
        }

        if(!empty($username) && !empty($password) && !empty($password)) {

            $sql_create_khach_hang = "INSERT INTO khachhang values();";

            if(sql_execute($sql_create_khach_hang)) {

                $sql_get_end_khach_hang = "SELECT MSKH FROM khachhang ORDER BY MSKH DESC LIMIT 1;" ;
                $MSKH = sql_query($sql_get_end_khach_hang);
                $MSKH = (int) $MSKH[0]['MSKH'];
    
                if( $MSKH < 1) {
                    die();
                } 
                else {
                    
                    $sql_create_account = "INSERT INTO account_user(`username`, `password`, `MSKH`) values ('$username', '$password', $MSKH);";

                    if(sql_execute($sql_create_account)) {

                        echo '
                            <script>
                                alert("Tạo tài khoản thành công.");
                            </script>
                        ';

                    } else {

                        $sql_delete_mskh_recent_created = "DELETE FROM khachhang where MSKH=$MSKH;";
                        sql_execute($sql_delete_mskh_recent_created);

                        echo '
                            <script>
                                alert("Tạo tài khoản thất bại.");
                            </script>
                        ';
                    }

                }
            }

    
            // if($username === 'user' && $password === '123') {
    
            //     $_SESSION['check_login'] = true;
            //     $_SESSION['check_login_admin'] = false;
    
            //     return true;
            // }
        }


    } else {

        if(isset($_POST['submit_register_form_admin'])) {

            if(isset($_POST['username'])) {
                $username = $_POST['username'];
            }
            if(isset($_POST['password'])) {
                $password = $_POST['password'];
            }
            if(isset($_POST['repeatPwd'])) {
                $repeatPwd = $_POST['repeatPwd'];
            }
    
            if(!empty($username) && !empty($password)) {
        
                if($username === 'admin' && $password === '123') {
        
                    $_SESSION['check_login'] = true;
                    $_SESSION['check_login_admin'] = true;
        
                    header('Location: ../admin/');
                    die();
                    return true;
                } 
                
            }
    
        }

    }

    return false;


}


// Xu ly them vao gio hang
function cart_process() {

    $data = [];
    $cart_quantity = $quantity = '';
    $index_in_data_array = -1;
    $discount = 0.36;
    
    if(!empty($_POST) && isset($_POST['add_product_to_cart'])) {

        if(isset($_POST['quantity'])) {
            $quantity = (int) $_POST['quantity'];
        }

        if(isset($_POST['discount']) && !empty($_POST['discount'])) {
            $discount = (float) $_POST['discount'];
        }

        if(isset($_POST['id_mshh_product_clicked'])) {

            $id_mshh_product_clicked = (int) $_POST['id_mshh_product_clicked'];
            $data = $_SESSION['data'];

            foreach ($data as $key => $val) {
                if( (int)$val["MSHH"] === $id_mshh_product_clicked) {
                    
                    $index_in_data_array = (int) $key;
                    break;
                }
            }

            if($id_mshh_product_clicked < 0) {
                
                $_SESSION['data'] = get_data_by_mshh($id_mshh_product_clicked);
                $data = $_SESSION['data'];

                if(!empty($data)) {
                    $index_in_data_array = 0;
                }
            }

            
            if($index_in_data_array > -1) {

                $mshh_temp = $data[$index_in_data_array]['MSHH'];

                foreach( $_SESSION['cart_datas'] as $data_cart) {
                    if( (int)$data_cart['MSHH'] === (int)$mshh_temp) {

                        header("Location: index.php?action_page=detail_product&id_product=".$id_mshh_product_clicked."");
                        die();
                    }
                }

                $cart_data_temp = $data[$index_in_data_array];
                $cart_data_temp['quantity'] = $quantity;
                $cart_data_temp['discount'] = $discount;

                $_SESSION['cart_datas'][] = $cart_data_temp;

                $cart_quantity = count($_SESSION['cart_datas']);
                $_SESSION['cart_quantity'] = (int) $cart_quantity;

            }
        }
    }

    // if(!empty($_SESSION)) {
    //     if(isset($_SESSION['cart_datas']) && !empty($_SESSION['cart_datas'])) {
    //         $cart_quantity = count($_SESSION['cart_datas']);

    //         $_SESSION['cart_quantity'] = (int) $cart_quantity;
    //     }
    // }

    header("Location: index.php?action_page=detail_product&id_product=".$id_mshh_product_clicked."");
    die();

}

// Hien thi gio hang
function imp_cart() {

    $cart_datas = [];
    $path_localhost = '../../';

    if(!empty($_SESSION)) {

        if(isset($_SESSION['cart_datas']) && !empty($_SESSION['cart_datas'])) {
            $cart_datas = $_SESSION['cart_datas'];
        }
    }

    if(!empty($cart_datas)) {

        echo '
        <div id="container">
            <div class="grid">
                <div class="grid__row">
                    <div class="grid__full-width">
                        <form id="frm_buy_product" style="min-height: 200px;">
                        
        ';


        $stt = -1;
        foreach($cart_datas as $data) {
            
            $mshh_data_temp = $data['MSHH'];
            if(!empty($data)) {
                $stt++;
            }

            if($stt === 0) {
                echo '
                        <div class="container-detail cart">
                            <div class="container-detail__content"> 
                                <div class="container-detail__item">
                                    <div>
                                        <label for="check_box_all" class="container-detail__label">Chọn tất cả</label>
                                        <input type="checkbox" class="buy_product_choose" name="checkAll" id="check_box_all" onclick="select_all_product_in_cart();" value="-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                ';
            }

            echo '
                        <!-- San pham '.($stt+1).' -->
                        <div class="container-detail cart">
                            <div class="container-detail__content"> 
                                <div class="container-detail__item">
                                    <div class="container-detail__header">
                                        <span class="container-detail__label">Sản phẩm '.($stt+1).' </span>
                                        <!-- <input type="checkbox" name="buy_product_choose" class="buy_product_choose" value="'.$data['Gia'].'"> -->

                                        <input type="checkbox" name="buy_product_choose'.$stt.'" class="buy_product_choose" value="'.$stt.'">
                                        
                                        <label for="" class="clss_display_none"> MSHH:
                                            <input type="number" name="mshh_data_temp'.$mshh_data_temp.'" value="'.$mshh_data_temp.'" readonly>
                                        </label>

                                        <!-- <span class="container-detail__trangthai">đang giao</span> -->
                                    </div>
                                </div>
                                <div class="container-detail__item">
                                    <div class="container-detail__sanpham">
                                        <a href="?action_page=detail_product&id_product='.$mshh_data_temp.'" class="container-detail__sanpham-img">
                                            <img src="'.$path_localhost.$data['TenHinh'].'" alt="san-pham-img" class="container-detail__sanpham-img--img">
                                        </a>
                                        <div class="container-detail__sanpham-mota">
                                            <div class="container-detail__sanpham-name">
                                                '.$data['TenHH'].'
                                            </div>
                                            <div class="container-detail__sanpham-quantity">
                                                <!-- x1 -->
                                                <span> ('.number_format($data['Gia'],0,",",".").' <sup>VNĐ</sup>)</span>

                                                
                                                <label for="" class="clss_display_none"> Gia:
                                                    <input type="number" id="product_price'.$stt.'" value="'.$data['Gia'].'" readonly>
                                                </label>

                                                <label style="color: var(--primary-color);">Chọn số lượng: </label>

                                                <input 
                                                    type="number" id="product_quantity'.$stt.'" class="frm-input container-detail__input"
                                                    value="'.$data['quantity'].'" min="1" max="'.(int)$data['SoLuongHang'].'" 
                                                    onchange="check_valid_quantity_and_update_total_price(this);"
                                                >

                                                <label>
                                                    Còn lại <span style="color: var(--primary-color)"> '.$data['SoLuongHang'].' </span> sản phẩm
                                                </label>
                                            </div>
                                        </div>

                                        <div class="container-detail__sanpham-total">
                                        
                                            <span style="color: var(--primary-color);">
                                                <span id="product_total_price_item'.$stt.'">
                                                    '.number_format($data['Gia'] * $data['quantity'],0,",",".").'</span> <sup>đ</sup>
                                            </span>

                                            
                                            <label for="" class="clss_display_none"> Total / SP:
                                                <input type="number" id="product_total_price_item_hiden'.$stt.'" 
                                                    value="'.$data['Gia'] *  $data['quantity'].'" readonly>
                                            </label>
                                            
                                            <button class="btn btn--danger" style="margin-left: 16px;" value="'.$mshh_data_temp.'" onclick="return delete_product('.$stt.',this)">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- End: San pham '.($stt+1).' -->
            ';
        }

        echo '

            </form>

            <div class="container_my_address">
        ';
        
                my_address_in_cart();

        echo '
            </div>

            <!-- Bottom mua hang -->
            <div class="container-buy">
                <div class="container-buy__item">
                    <span class="container-buy__label">Tổng thanh toán (<span class="container-buy__label total_product">0</span> Sản phẩm):</span>

                    <!-- <span class="container-buy__total">VNĐ 0</span> -->
                    <!-- <span class="container-buy__total">VNĐ <span class="container-buy__total total_price">0</span> </span> -->

                    <span class="container-buy__total total_price">0 VND</span>

                    <label for="" class="clss_display_none"> Tong tien hang:
                        <input type="number" id="total_price" value="0">
                    </label>

                    <a href="#!">
                        <button class="btn btn--primary" onclick="return buy_product(cart_datas_buy);">Mua Hàng</button>
                    </a>
                </div>
            </div>
            <!-- End: Bottom mua hang -->
            
                </div>
            </div>
            </div>
        </div> 
        
        ';



        echo '
            <script>

                let cart_datas = [];
                let cart_datas_buy = [];

                if('.json_encode($cart_datas, JSON_HEX_TAG).'.length > 0) {
                
                    cart_datas = '.json_encode($cart_datas, JSON_HEX_TAG).';
                }

                console.log(cart_datas);
                
                total_price();

                function total_price() {

                    const checkboxes = document.querySelectorAll(".buy_product_choose");
                    const total_price = document.getElementById("total_price");
                    const frm_buy_product = document.getElementById("frm_buy_product");
                    const total_price_display = document.querySelector(".container-buy__total.total_price");
                    const total_product_display = document.querySelector(".container-buy__label.total_product");

                    let count_product_selected = 0;
                    let total = 0;

                    frm_buy_product.addEventListener("change", function() {

                        total = 0;
                        count_product_selected = 0;
                        cart_datas_buy = [];

                        for(checkbox of checkboxes) {
                            if(checkbox.checked == true) {
                                
                                cbxValue = parseInt(checkbox.value);
                                
                                if(cbxValue < 0 ) {
                                    continue;
                                }

                                cart_datas_buy.push(cart_datas[cbxValue]);

                                total += ( parseInt(cart_datas[cbxValue]["Gia"]) * parseInt(cart_datas[cbxValue]["quantity"]) );

                                count_product_selected += 1;

                            }
                        }

                        total_price.value = total;
                        total = total.toLocaleString("it-IT", {style : "currency", currency : "VND"});
                        total_price_display.innerHTML = total;
                        total_product_display.innerHTML = count_product_selected;

                    });
            
                }
            
            </script>
        ';

        // echo "<pre>";
        // print_r($cart_datas);
        // echo "</pre>";
    }

}

 
// Phan header khi chua LOGIN
function imp_header() {

    echo '

        <!-- Start: header -->
        <header id="header">
            <!-- grid: khoi tao max width 1200px -->
            <div class="grid">

                <!-- Phan header dang nhap, dang ky -->
                <nav class="navbar">
                    <ul class="list list-left">
                        <li class="item border-right-navbar-header">
                            <a href="#" class="icon-link">Download App</a>

                            <!-- Download app -->
                            <div class="download-app">
                                <img src="../../assets/img/img-download/code-QR.png" alt="QR Code Download" class="img-qr">

                                <div class="link-app">
                                    <img src="../../assets/img/img-download/app-store.png" alt="Link App Store" class="app-item">
                                    <img src="../../assets/img/img-download/gg-play.png" alt="Link Google play" class="app-item">
                                </div>
                            </div>
                        </li>
                        <li class="item">Ket noi</li>
                        <li class="item">
                            <a href="#" class="icon-link"><i class="icon-header fab fa-facebook"></i></a>
                            <a href="#" class="icon-link"><i class="icon-header fab fa-instagram"></i></a>
                        </li>
                    </ul>

                    <ul class="list list-right">
                        <li class="item">
                            <a href="#" class="item-link">
                                <i class="icon-header far fa-bell"></i>
                                Thong bao
                            </a>
                        </li>
                        <li class="item">
                            <a href="#" class="item-link">
                                <i class="icon-header far fa-question-circle"></i>
                                Ho tro
                            </a>
                        </li>

                        <!-- Dang nhap - Dang ky -->
                        <li class="item border-right-navbar-header">
                            <a href="#!" class="item-link" onclick="openModal_register()">Dang ky</a>
                        </li>
                        <li class="item">
                            <a href="#!" class="item-link" onclick="openModal_login()">Dang nhap</a>
                        </li>

                        <!-- User login -->
                        <!-- <li class="item navbar-user">
                            <img src="./assets/img/default-user.jpg" alt="avatar" class="user-avatar">
                            <span class="user-name">Nguyen Thanh Nhan</span>

                            <ul class="user-menu">
                                <li class="user-menu-item"><a href="#">Tài khoản của tôi</a></li>
                                <li class="user-menu-item"><a href="#">Đơn mua</a></li>
                                <li class="user-menu-item"><a href="#">Đăng xuất</a></li>
                            </ul>
                        </li> -->
                    </ul>
                </nav>
                <!-- End: Phan header dang nhap, dang ky -->

                <!-- Start: header search -->
                <div class="container">
                    <div class="img container-item">
                        <!-- <img src="./assets/img/y-nghia-logo-shopee.jpg" alt="Anh logo shopee" class="img-logo"> -->
                        <div class="container-img-logo">
                            <a href="?data_type=0" class="container-link-home">
                                <svg class="img-logo" viewBox="0 0 192 65" class="shopee-svg-icon header-with-search__shopee-logo icon-shopee-logo"><g fill-rule="evenodd">
                                    <path fill="#fff" d="M35.6717403 44.953764c-.3333497 2.7510509-2.0003116 4.9543414-4.5823845 6.0575984-1.4379707.6145919-3.36871.9463856-4.896954.8421628-2.3840266-.0911143-4.6237865-.6708937-6.6883352-1.7307424-.7375522-.3788551-1.8370513-1.1352759-2.6813095-1.8437757-.213839-.1790053-.239235-.2937577-.0977428-.4944671.0764015-.1151823.2172535-.3229831.5286218-.7791994.45158-.6616533.5079208-.7446018.5587128-.8221779.14448-.2217688.3792333-.2411091.6107855-.0588804.0243289.0189105.0243289.0189105.0426824.0333083.0379873.0294402.0379873.0294402.1276204.0990653.0907002.0706996.14448.1123887.166248.1287205 2.2265285 1.7438508 4.8196989 2.7495466 7.4376251 2.8501162 3.6423042-.0496401 6.2615109-1.6873341 6.7308041-4.2020035.5160305-2.7675977-1.6565047-5.1582742-5.9070334-6.4908212-1.329344-.4166762-4.6895175-1.7616869-5.3090528-2.1250697-2.9094471-1.7071043-4.2697358-3.9430584-4.0763845-6.7048539.296216-3.8283059 3.8501677-6.6835796 8.340785-6.702705 2.0082079-.004083 4.0121475.4132378 5.937338 1.2244562.6816382.2873109 1.8987274.9496089 2.3189359 1.2633517.2420093.1777159.2898136.384872.1510957.60836-.0774686.12958-.2055158.3350171-.4754821.7632974l-.0029878.0047276c-.3553311.5640922-.3664286.5817134-.447952.7136572-.140852.2144625-.3064598.2344475-.5604202.0732783-2.0600669-1.3839063-4.3437898-2.0801572-6.8554368-2.130442-3.126914.061889-5.4706057 1.9228561-5.6246892 4.4579402-.0409751 2.2896772 1.676352 3.9613243 5.3858811 5.2358503 7.529819 2.4196871 10.4113092 5.25648 9.869029 9.7292478M26.3725216 5.42669372c4.9022893 0 8.8982174 4.65220288 9.0851664 10.47578358H17.2875686c.186949-5.8235807 4.1828771-10.47578358 9.084953-10.47578358m25.370857 11.57065968c0-.6047069-.4870064-1.0948761-1.0875481-1.0948761h-11.77736c-.28896-7.68927544-5.7774923-13.82058185-12.5059489-13.82058185-6.7282432 0-12.2167755 6.13130641-12.5057355 13.82058185l-11.79421958.0002149c-.59136492.0107446-1.06748731.4968309-1.06748731 1.0946612 0 .0285807.00106706.0569465.00320118.0848825H.99995732l1.6812605 37.0613963c.00021341.1031483.00405483.2071562.01173767.3118087.00170729.0236381.003628.0470614.00554871.0704847l.00362801.0782207.00405483.004083c.25545428 2.5789222 2.12707837 4.6560709 4.67201764 4.7519129l.00576212.0055872h37.4122078c.0177132.0002149.0354264.0004298.0531396.0004298.0177132 0 .0354264-.0002149.0531396-.0004298h.0796027l.0017073-.0015043c2.589329-.0706995 4.6867431-2.1768587 4.9082648-4.787585l.0012805-.0012893.0017073-.0350275c.0021341-.0275062.0040548-.0547975.0057621-.0823037.0040548-.065757.0068292-.1312992.0078963-.1964115l1.8344904-37.207738h-.0012805c.001067-.0186956.0014939-.0376062.0014939-.0565167M176.465457 41.1518926c.720839-2.3512494 2.900423-3.9186779 5.443734-3.9186779 2.427686 0 4.739107 1.6486899 5.537598 3.9141989l.054826.1556978h-11.082664l.046506-.1512188zm13.50267 3.4063683c.014933.0006399.014933.0006399.036906.0008531.021973-.0002132.021973-.0002132.044372-.0008531.53055-.0243144.950595-.4766911.950595-1.0271786 0-.0266606-.000853-.0496953-.00256-.0865936.000427-.0068251.000427-.020262.000427-.0635588 0-5.1926268-4.070748-9.4007319-9.09145-9.4007319-5.020488 0-9.091235 4.2081051-9.091235 9.4007319 0 .3871116.022399.7731567.067838 1.1568557l.00256.0204753.01408.1013102c.250022 1.8683731 1.047233 3.5831812 2.306302 4.9708108-.00064-.0006399.00064.0006399.007253.0078915 1.396026 1.536289 3.291455 2.5833031 5.393601 2.9748936l.02752.0053321v-.0027727l.13653.0228215c.070186.0119439.144211.0236746.243409.039031 2.766879.332724 5.221231-.0661182 7.299484-1.1127057.511777-.2578611.971928-.5423827 1.37064-.8429007.128211-.0968312.243622-.1904632.34346-.2781231.051412-.0452164.092372-.083181.114131-.1051493.468898-.4830897.498124-.6543572.215249-1.0954297-.31146-.4956734-.586228-.9179769-.821744-1.2675504-.082345-.1224254-.154023-.2267215-.214396-.3133151-.033279-.0475624-.033279-.0475624-.054399-.0776356-.008319-.0117306-.008319-.0117306-.013866-.0191956l-.00256-.0038391c-.256208-.3188605-.431565-.3480805-.715933-.0970445-.030292.0268739-.131624.1051493-.14997.1245582-1.999321 1.775381-4.729508 2.3465571-7.455854 1.7760208-.507724-.1362888-.982595-.3094759-1.419919-.5184948-1.708127-.8565509-2.918343-2.3826022-3.267563-4.1490253l-.02752-.1394881h13.754612zM154.831964 41.1518926c.720831-2.3512494 2.900389-3.9186779 5.44367-3.9186779 2.427657 0 4.739052 1.6486899 5.537747 3.9141989l.054612.1556978h-11.082534l.046505-.1512188zm13.502512 3.4063683c.015146.0006399.015146.0006399.037118.0008531.02176-.0002132.02176-.0002132.044159-.0008531.530543-.0243144.950584-.4766911.950584-1.0271786 0-.0266606-.000854-.0496953-.00256-.0865936.000426-.0068251.000426-.020262.000426-.0635588 0-5.1926268-4.070699-9.4007319-9.091342-9.4007319-5.020217 0-9.091343 4.2081051-9.091343 9.4007319 0 .3871116.022826.7731567.068051 1.1568557l.00256.0204753.01408.1013102c.250019 1.8683731 1.04722 3.5831812 2.306274 4.9708108-.00064-.0006399.00064.0006399.007254.0078915 1.396009 1.536289 3.291417 2.5833031 5.393538 2.9748936l.027519.0053321v-.0027727l.136529.0228215c.070184.0119439.144209.0236746.243619.039031 2.766847.332724 5.22117-.0661182 7.299185-1.1127057.511771-.2578611.971917-.5423827 1.370624-.8429007.128209-.0968312.243619-.1904632.343456-.2781231.051412-.0452164.09237-.083181.11413-.1051493.468892-.4830897.498118-.6543572.215246-1.0954297-.311457-.4956734-.586221-.9179769-.821734-1.2675504-.082344-.1224254-.154022-.2267215-.21418-.3133151-.033492-.0475624-.033492-.0475624-.054612-.0776356-.008319-.0117306-.008319-.0117306-.013866-.0191956l-.002346-.0038391c-.256419-.3188605-.431774-.3480805-.716138-.0970445-.030292.0268739-.131623.1051493-.149969.1245582-1.999084 1.775381-4.729452 2.3465571-7.455767 1.7760208-.507717-.1362888-.982582-.3094759-1.419902-.5184948-1.708107-.8565509-2.918095-2.3826022-3.267311-4.1490253l-.027733-.1394881h13.754451zM138.32144123 49.7357905c-3.38129629 0-6.14681004-2.6808521-6.23169343-6.04042014v-.31621743c.08401943-3.35418649 2.85039714-6.03546919 6.23169343-6.03546919 3.44242097 0 6.23320537 2.7740599 6.23320537 6.1960534 0 3.42199346-2.7907844 6.19605336-6.23320537 6.19605336m.00172791-15.67913203c-2.21776751 0-4.33682838.7553485-6.03989586 2.140764l-.19352548.1573553V34.6208558c0-.4623792-.0993546-.56419733-.56740117-.56419733h-2.17651376c-.47409424 0-.56761716.09428403-.56761716.56419733v27.6400724c0 .4539841.10583425.5641973.56761716.5641973h2.17651376c.46351081 0 .56740117-.1078454.56740117-.5641973V50.734168l.19352548.1573553c1.70328347 1.3856307 3.82234434 2.1409792 6.03989586 2.1409792 5.27140956 0 9.54473746-4.2479474 9.54473746-9.48802964 0-5.239867-4.2733279-9.48781439-9.54473746-9.48781439M115.907646 49.5240292c-3.449458 0-6.245805-2.7496948-6.245805-6.1425854 0-3.3928907 2.79656-6.1427988 6.245805-6.1427988 3.448821 0 6.24538 2.7499081 6.24538 6.1427988 0 3.3926772-2.796346 6.1425854-6.24538 6.1425854m.001914-15.5438312c-5.28187 0-9.563025 4.2112903-9.563025 9.4059406 0 5.1944369 4.281155 9.4059406 9.563025 9.4059406 5.281657 0 9.562387-4.2115037 9.562387-9.4059406 0-5.1946503-4.280517-9.4059406-9.562387-9.4059406M94.5919049 34.1890939c-1.9281307 0-3.7938902.6198995-5.3417715 1.7656047l-.188189.1393105V23.2574169c0-.4254677-.1395825-.5643476-.5649971-.5643476h-2.2782698c-.4600414 0-.5652122.1100273-.5652122.5643476v29.2834155c0 .443339.1135587.5647782.5652122.5647782h2.2782698c.4226187 0 .5649971-.1457701.5649971-.5647782v-9.5648406c.023658-3.011002 2.4931278-5.4412923 5.5299605-5.4412923 3.0445753 0 5.516841 2.4421328 5.5297454 5.4630394v9.5430935c0 .4844647.0806524.5645628.5652122.5645628h2.2726775c.481764 0 .565212-.0824666.565212-.5645628v-9.5710848c-.018066-4.8280677-4.0440197-8.7806537-8.9328471-8.7806537M62.8459442 47.7938061l-.0053397.0081519c-.3248668.4921188-.4609221.6991347-.5369593.8179812-.2560916.3812097-.224267.551113.1668119.8816949.91266.7358184 2.0858968 1.508535 2.8774525 1.8955369 2.2023021 1.076912 4.5810275 1.646045 7.1017886 1.6975309 1.6283921.0821628 3.6734936-.3050536 5.1963734-.9842376 2.7569891-1.2298679 4.5131066-3.6269626 4.8208863-6.5794607.4985136-4.7841067-2.6143125-7.7747902-10.6321784-10.1849709l-.0021359-.0006435c-3.7356476-1.2047686-5.4904836-2.8064071-5.4911243-5.0426086.1099976-2.4715346 2.4015793-4.3179454 5.4932602-4.4331449 2.4904317.0062212 4.6923065.6675996 6.8557356 2.0598624.4562232.2767364.666607.2256796.9733188-.172263.035242-.0587797.1332787-.2012238.543367-.790093l.0012815-.0019308c.3829626-.5500403.5089793-.7336731.5403767-.7879478.258441-.4863266.2214903-.6738208-.244985-1.0046173-.459427-.3290803-1.7535544-1.0024722-2.4936356-1.2978721-2.0583439-.8211991-4.1863175-1.2199998-6.3042524-1.1788111-4.8198184.1046878-8.578747 3.2393171-8.8265087 7.3515337-.1572005 2.9703036 1.350301 5.3588174 4.5000778 7.124567.8829712.4661613 4.1115618 1.6865902 5.6184225 2.1278667 4.2847814 1.2547527 6.5186944 3.5630343 6.0571315 6.2864205-.4192725 2.4743234-3.0117991 4.1199394-6.6498372 4.2325647-2.6382344-.0549182-5.2963324-1.0217793-7.6043603-2.7562084-.0115337-.0083664-.0700567-.0519149-.1779185-.1323615-.1516472-.1130543-.1516472-.1130543-.1742875-.1300017-.4705335-.3247898-.7473431-.2977598-1.0346184.1302162-.0346012.0529875-.3919333.5963776-.5681431.8632459"></path></g>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="search container-item" style="visibility:hidden;">
                        <div class="search-bar">
                            <input type="text" name="" placeholder="Search something" autocomplete="on">

                            <button>
                                <i class="fas fa-search icon-button-search"></i>
                            </button>
                        </div>

                        <div class="search-item">
                            <a href="#" class="item">Banh trung thu</a>
                            <a href="#" class="item">Ao khoac</a>
                            <a href="#" class="item">Vay</a>
                            <a href="#" class="item">Quan</a>
                            <a href="#" class="item">Tay nghe</a>
                            <a href="#" class="item">Bong tay trang</a>
                            <a href="#" class="item">Tui xach nu</a>
                            <a href="#" class="item">Chan vay</a>
                        </div>
                    </div>

                    <!-- Gio hang -->
                    <!-- <div class="cart container-item">
                        <i class="fas fa-cart-arrow-down icon-cart"></i>
                        <span class="cart-quantity" id="cart-quantity"> 3</span>
                    </div> -->
                </div>
                <!-- End: header search -->

            </div>
        </header>
        <!-- End: Header -->
    
    ';

}

// Phan header khi da LOGIN
function import_header_logined() {

    $HoTenKH = '';
    $cart_quantity = 0;
    
    $path_localhost ='../../';
    $path_user_img = $path_localhost."assets/img/img-default/default-user.jpg";
    // $path_product_img = $path_localhost."assets/img/img-default/default-img.jpg";

    if(!empty($_SESSION)) {

        if(isset($_SESSION['data_my_info'])) {
            $HoTenKH = $_SESSION['data_my_info'][0]["HoTenKH"];
        }

        if(isset($_SESSION['cart_datas'])) {
            $cart_quantity = (int) count($_SESSION['cart_datas']);
        }
    }


    echo '
        <!-- Start: header -->
        <header id="header">
            <!-- grid: khoi tao max width 1200px -->
            <div class="grid">
        
                <!-- Phan header dang nhap, dang ky -->
                <nav class="navbar">
                    <ul class="list list-left">
                        <li class="item">Chào mừng bạn đến với Shopee PHA KE</li>
                    </ul>
        
                    <ul class="list list-right">
                        <li class="item">
                            <a href="#" class="item-link">
                                <i class="icon-header far fa-bell"></i>
                                Thong bao
                            </a>
                        </li>
                        <li class="item">
                            <a href="#" class="item-link">
                                <i class="icon-header far fa-question-circle"></i>
                                Ho tro
                            </a>
                        </li>
        
                        <!-- User login -->
                        <li class="item navbar-user">
                            <img src="'.$path_user_img.'" alt="avatar" class="user-avatar">
                            <span class="user-name">'.$HoTenKH.'</span>
        
                            <ul class="user-menu">
                                <li class="user-menu-item"><a href="?action_page=my_account&id='.rand().'">Tài khoản của tôi</a></li>
                                <li class="user-menu-item"><a href="?action_page=imp_purchase&id='.rand().'">Đơn mua</a></li>
                                <li class="user-menu-item"><a href="?action_page=logout">Đăng xuất</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- End: Phan header dang nhap, dang ky -->
        
                <!-- Start: header search -->
                <div class="container">
                    <div class="img container-item">
                        <!-- <img src="../../assets/img/y-nghia-logo-shopee.jpg" alt="Anh logo shopee" class="img-logo"> -->
                        <div class="container-img-logo">
                            <a href="?data_type=0" class="container-link-home">
                                <svg class="img-logo" viewBox="0 0 192 65" class="shopee-svg-icon header-with-search__shopee-logo icon-shopee-logo"><g fill-rule="evenodd">
                                    <path fill="#fff" d="M35.6717403 44.953764c-.3333497 2.7510509-2.0003116 4.9543414-4.5823845 6.0575984-1.4379707.6145919-3.36871.9463856-4.896954.8421628-2.3840266-.0911143-4.6237865-.6708937-6.6883352-1.7307424-.7375522-.3788551-1.8370513-1.1352759-2.6813095-1.8437757-.213839-.1790053-.239235-.2937577-.0977428-.4944671.0764015-.1151823.2172535-.3229831.5286218-.7791994.45158-.6616533.5079208-.7446018.5587128-.8221779.14448-.2217688.3792333-.2411091.6107855-.0588804.0243289.0189105.0243289.0189105.0426824.0333083.0379873.0294402.0379873.0294402.1276204.0990653.0907002.0706996.14448.1123887.166248.1287205 2.2265285 1.7438508 4.8196989 2.7495466 7.4376251 2.8501162 3.6423042-.0496401 6.2615109-1.6873341 6.7308041-4.2020035.5160305-2.7675977-1.6565047-5.1582742-5.9070334-6.4908212-1.329344-.4166762-4.6895175-1.7616869-5.3090528-2.1250697-2.9094471-1.7071043-4.2697358-3.9430584-4.0763845-6.7048539.296216-3.8283059 3.8501677-6.6835796 8.340785-6.702705 2.0082079-.004083 4.0121475.4132378 5.937338 1.2244562.6816382.2873109 1.8987274.9496089 2.3189359 1.2633517.2420093.1777159.2898136.384872.1510957.60836-.0774686.12958-.2055158.3350171-.4754821.7632974l-.0029878.0047276c-.3553311.5640922-.3664286.5817134-.447952.7136572-.140852.2144625-.3064598.2344475-.5604202.0732783-2.0600669-1.3839063-4.3437898-2.0801572-6.8554368-2.130442-3.126914.061889-5.4706057 1.9228561-5.6246892 4.4579402-.0409751 2.2896772 1.676352 3.9613243 5.3858811 5.2358503 7.529819 2.4196871 10.4113092 5.25648 9.869029 9.7292478M26.3725216 5.42669372c4.9022893 0 8.8982174 4.65220288 9.0851664 10.47578358H17.2875686c.186949-5.8235807 4.1828771-10.47578358 9.084953-10.47578358m25.370857 11.57065968c0-.6047069-.4870064-1.0948761-1.0875481-1.0948761h-11.77736c-.28896-7.68927544-5.7774923-13.82058185-12.5059489-13.82058185-6.7282432 0-12.2167755 6.13130641-12.5057355 13.82058185l-11.79421958.0002149c-.59136492.0107446-1.06748731.4968309-1.06748731 1.0946612 0 .0285807.00106706.0569465.00320118.0848825H.99995732l1.6812605 37.0613963c.00021341.1031483.00405483.2071562.01173767.3118087.00170729.0236381.003628.0470614.00554871.0704847l.00362801.0782207.00405483.004083c.25545428 2.5789222 2.12707837 4.6560709 4.67201764 4.7519129l.00576212.0055872h37.4122078c.0177132.0002149.0354264.0004298.0531396.0004298.0177132 0 .0354264-.0002149.0531396-.0004298h.0796027l.0017073-.0015043c2.589329-.0706995 4.6867431-2.1768587 4.9082648-4.787585l.0012805-.0012893.0017073-.0350275c.0021341-.0275062.0040548-.0547975.0057621-.0823037.0040548-.065757.0068292-.1312992.0078963-.1964115l1.8344904-37.207738h-.0012805c.001067-.0186956.0014939-.0376062.0014939-.0565167M176.465457 41.1518926c.720839-2.3512494 2.900423-3.9186779 5.443734-3.9186779 2.427686 0 4.739107 1.6486899 5.537598 3.9141989l.054826.1556978h-11.082664l.046506-.1512188zm13.50267 3.4063683c.014933.0006399.014933.0006399.036906.0008531.021973-.0002132.021973-.0002132.044372-.0008531.53055-.0243144.950595-.4766911.950595-1.0271786 0-.0266606-.000853-.0496953-.00256-.0865936.000427-.0068251.000427-.020262.000427-.0635588 0-5.1926268-4.070748-9.4007319-9.09145-9.4007319-5.020488 0-9.091235 4.2081051-9.091235 9.4007319 0 .3871116.022399.7731567.067838 1.1568557l.00256.0204753.01408.1013102c.250022 1.8683731 1.047233 3.5831812 2.306302 4.9708108-.00064-.0006399.00064.0006399.007253.0078915 1.396026 1.536289 3.291455 2.5833031 5.393601 2.9748936l.02752.0053321v-.0027727l.13653.0228215c.070186.0119439.144211.0236746.243409.039031 2.766879.332724 5.221231-.0661182 7.299484-1.1127057.511777-.2578611.971928-.5423827 1.37064-.8429007.128211-.0968312.243622-.1904632.34346-.2781231.051412-.0452164.092372-.083181.114131-.1051493.468898-.4830897.498124-.6543572.215249-1.0954297-.31146-.4956734-.586228-.9179769-.821744-1.2675504-.082345-.1224254-.154023-.2267215-.214396-.3133151-.033279-.0475624-.033279-.0475624-.054399-.0776356-.008319-.0117306-.008319-.0117306-.013866-.0191956l-.00256-.0038391c-.256208-.3188605-.431565-.3480805-.715933-.0970445-.030292.0268739-.131624.1051493-.14997.1245582-1.999321 1.775381-4.729508 2.3465571-7.455854 1.7760208-.507724-.1362888-.982595-.3094759-1.419919-.5184948-1.708127-.8565509-2.918343-2.3826022-3.267563-4.1490253l-.02752-.1394881h13.754612zM154.831964 41.1518926c.720831-2.3512494 2.900389-3.9186779 5.44367-3.9186779 2.427657 0 4.739052 1.6486899 5.537747 3.9141989l.054612.1556978h-11.082534l.046505-.1512188zm13.502512 3.4063683c.015146.0006399.015146.0006399.037118.0008531.02176-.0002132.02176-.0002132.044159-.0008531.530543-.0243144.950584-.4766911.950584-1.0271786 0-.0266606-.000854-.0496953-.00256-.0865936.000426-.0068251.000426-.020262.000426-.0635588 0-5.1926268-4.070699-9.4007319-9.091342-9.4007319-5.020217 0-9.091343 4.2081051-9.091343 9.4007319 0 .3871116.022826.7731567.068051 1.1568557l.00256.0204753.01408.1013102c.250019 1.8683731 1.04722 3.5831812 2.306274 4.9708108-.00064-.0006399.00064.0006399.007254.0078915 1.396009 1.536289 3.291417 2.5833031 5.393538 2.9748936l.027519.0053321v-.0027727l.136529.0228215c.070184.0119439.144209.0236746.243619.039031 2.766847.332724 5.22117-.0661182 7.299185-1.1127057.511771-.2578611.971917-.5423827 1.370624-.8429007.128209-.0968312.243619-.1904632.343456-.2781231.051412-.0452164.09237-.083181.11413-.1051493.468892-.4830897.498118-.6543572.215246-1.0954297-.311457-.4956734-.586221-.9179769-.821734-1.2675504-.082344-.1224254-.154022-.2267215-.21418-.3133151-.033492-.0475624-.033492-.0475624-.054612-.0776356-.008319-.0117306-.008319-.0117306-.013866-.0191956l-.002346-.0038391c-.256419-.3188605-.431774-.3480805-.716138-.0970445-.030292.0268739-.131623.1051493-.149969.1245582-1.999084 1.775381-4.729452 2.3465571-7.455767 1.7760208-.507717-.1362888-.982582-.3094759-1.419902-.5184948-1.708107-.8565509-2.918095-2.3826022-3.267311-4.1490253l-.027733-.1394881h13.754451zM138.32144123 49.7357905c-3.38129629 0-6.14681004-2.6808521-6.23169343-6.04042014v-.31621743c.08401943-3.35418649 2.85039714-6.03546919 6.23169343-6.03546919 3.44242097 0 6.23320537 2.7740599 6.23320537 6.1960534 0 3.42199346-2.7907844 6.19605336-6.23320537 6.19605336m.00172791-15.67913203c-2.21776751 0-4.33682838.7553485-6.03989586 2.140764l-.19352548.1573553V34.6208558c0-.4623792-.0993546-.56419733-.56740117-.56419733h-2.17651376c-.47409424 0-.56761716.09428403-.56761716.56419733v27.6400724c0 .4539841.10583425.5641973.56761716.5641973h2.17651376c.46351081 0 .56740117-.1078454.56740117-.5641973V50.734168l.19352548.1573553c1.70328347 1.3856307 3.82234434 2.1409792 6.03989586 2.1409792 5.27140956 0 9.54473746-4.2479474 9.54473746-9.48802964 0-5.239867-4.2733279-9.48781439-9.54473746-9.48781439M115.907646 49.5240292c-3.449458 0-6.245805-2.7496948-6.245805-6.1425854 0-3.3928907 2.79656-6.1427988 6.245805-6.1427988 3.448821 0 6.24538 2.7499081 6.24538 6.1427988 0 3.3926772-2.796346 6.1425854-6.24538 6.1425854m.001914-15.5438312c-5.28187 0-9.563025 4.2112903-9.563025 9.4059406 0 5.1944369 4.281155 9.4059406 9.563025 9.4059406 5.281657 0 9.562387-4.2115037 9.562387-9.4059406 0-5.1946503-4.280517-9.4059406-9.562387-9.4059406M94.5919049 34.1890939c-1.9281307 0-3.7938902.6198995-5.3417715 1.7656047l-.188189.1393105V23.2574169c0-.4254677-.1395825-.5643476-.5649971-.5643476h-2.2782698c-.4600414 0-.5652122.1100273-.5652122.5643476v29.2834155c0 .443339.1135587.5647782.5652122.5647782h2.2782698c.4226187 0 .5649971-.1457701.5649971-.5647782v-9.5648406c.023658-3.011002 2.4931278-5.4412923 5.5299605-5.4412923 3.0445753 0 5.516841 2.4421328 5.5297454 5.4630394v9.5430935c0 .4844647.0806524.5645628.5652122.5645628h2.2726775c.481764 0 .565212-.0824666.565212-.5645628v-9.5710848c-.018066-4.8280677-4.0440197-8.7806537-8.9328471-8.7806537M62.8459442 47.7938061l-.0053397.0081519c-.3248668.4921188-.4609221.6991347-.5369593.8179812-.2560916.3812097-.224267.551113.1668119.8816949.91266.7358184 2.0858968 1.508535 2.8774525 1.8955369 2.2023021 1.076912 4.5810275 1.646045 7.1017886 1.6975309 1.6283921.0821628 3.6734936-.3050536 5.1963734-.9842376 2.7569891-1.2298679 4.5131066-3.6269626 4.8208863-6.5794607.4985136-4.7841067-2.6143125-7.7747902-10.6321784-10.1849709l-.0021359-.0006435c-3.7356476-1.2047686-5.4904836-2.8064071-5.4911243-5.0426086.1099976-2.4715346 2.4015793-4.3179454 5.4932602-4.4331449 2.4904317.0062212 4.6923065.6675996 6.8557356 2.0598624.4562232.2767364.666607.2256796.9733188-.172263.035242-.0587797.1332787-.2012238.543367-.790093l.0012815-.0019308c.3829626-.5500403.5089793-.7336731.5403767-.7879478.258441-.4863266.2214903-.6738208-.244985-1.0046173-.459427-.3290803-1.7535544-1.0024722-2.4936356-1.2978721-2.0583439-.8211991-4.1863175-1.2199998-6.3042524-1.1788111-4.8198184.1046878-8.578747 3.2393171-8.8265087 7.3515337-.1572005 2.9703036 1.350301 5.3588174 4.5000778 7.124567.8829712.4661613 4.1115618 1.6865902 5.6184225 2.1278667 4.2847814 1.2547527 6.5186944 3.5630343 6.0571315 6.2864205-.4192725 2.4743234-3.0117991 4.1199394-6.6498372 4.2325647-2.6382344-.0549182-5.2963324-1.0217793-7.6043603-2.7562084-.0115337-.0083664-.0700567-.0519149-.1779185-.1323615-.1516472-.1130543-.1516472-.1130543-.1742875-.1300017-.4705335-.3247898-.7473431-.2977598-1.0346184.1302162-.0346012.0529875-.3919333.5963776-.5681431.8632459"></path></g>
                                </svg>
                            </a>
                        </div>
                    </div>
        
                    <div class="search container-item" style="visibility:hidden;">
                        <div class="search-bar">
                            <input type="text" name="" placeholder="Search something" autocomplete="on">
        
                            <button>
                                <i class="fas fa-search icon-button-search"></i>
                            </button>
                        </div>
        
                        <div class="search-item">
                            <a href="#" class="item">Banh trung thu</a>
                            <a href="#" class="item">Ao khoac</a>
                            <a href="#" class="item">Vay</a>
                            <a href="#" class="item">Quan</a>
                            <a href="#" class="item">Tay nghe</a>
                            <a href="#" class="item">Bong tay trang</a>
                            <a href="#" class="item">Tui xach nu</a>
                            <a href="#" class="item">Chan vay</a>
                        </div>
                    </div>
        
                    <a href="?action_page=cart">
                        <div class="cart container-item">
                            <i class="fas fa-cart-arrow-down icon-cart"></i>
                            <span class="cart-quantity" id="cart-quantity">'.$cart_quantity.'</span>
                        </div>
                    </a>
                </div>
                <!-- End: header search -->
        
            </div>
        </header>
        <!-- End: Header -->    
    ';
}

// Phan container (Body)
function imp_container($index_to_show_data_page) {

    echo '

        <div id="container">
            <div class="grid">
                <div class="grid__row container__content">
                    
                    <!-- Danh muc -->
    ';
                    imp_category();
    echo '
                    <!-- End: Danh muc -->

                    <!-- set layout San pham -->
                    <div class="grid__col-10">
                    
                        <!-- Sort Bar -->
    ';
                        imp_sort_bar($index_to_show_data_page);
    echo '
                        <!-- End: Sort Barr -->

                        <!-- Show San pham -->
                        <div class="home-product">
                            <div class="grid__row">
    ';
                                show_product();
    echo '
                            </div>
                        </div>
                        <!-- End: Show San pham -->

                        <!-- Phan so trang -->
                        <div class="page-control">
                            <div class="page-change">
                                <button class="page-change__btn-move"><i class="page-change__icon fas fa-chevron-left"></i></button>
        ';
                                    phan_trang();
    echo '
                                <button class="page-change__btn-move"><i class="page-change__icon fas fa-chevron-right"></i></button>
                            </div>
                        </div>
                        <!-- End: Phan so trang -->

                    </div>
                    <!-- End: set layout San pham -->

                </div>
            </div>
        </div>

    ';

}

// Quan ly don hang 
function imp_purchase() {

    $MSKH = -1;
    $MSNV = 1;
    $check_login_admin = false;

    $action_view = "wait_comfirm";
    $all_active = $wait_active = $comfirmed_active = $cancel_active = '';
    $sql_total_DonHang = ''; 

    $total_DonHang = 0;
    $data_DonHang = [];


    if(!empty($_SESSION['MSKH']) && isset($_SESSION['MSKH'])) {
        $MSKH = (int) $_SESSION['MSKH'];
    }

    if(!empty($_SESSION['MSNV']) && isset($_SESSION['MSNV'])) {
        $MSNV = (int) $_SESSION['MSNV'];
    }

    if(!empty($_SESSION['check_login_admin']) && isset($_SESSION['check_login_admin'])) {
        $check_login_admin = $_SESSION['check_login_admin'];
    }

    if(!empty($_GET['action_view']) && isset($_GET['action_view'])) {
        $action_view = $_GET['action_view'];
    }


    switch ($action_view) {
        case 'wait_comfirm':
            $sql_total_DonHang = "SELECT SoDonDH from dathang WHERE MSKH = ".$MSKH." and TrangThaiDH = 0 ";
            $wait_active = "active";
            break;
        
        case 'comfirmed':
            $sql_total_DonHang = "SELECT SoDonDH from dathang WHERE MSKH = ".$MSKH." and TrangThaiDH = 1 ";
            $comfirmed_active = "active";
            break;
        
        case 'canceled':
            $sql_total_DonHang = "SELECT SoDonDH from dathang WHERE MSKH = ".$MSKH." and TrangThaiDH = -1 ";
            $cancel_active = "active";
            break;

        default:
            $sql_total_DonHang = "
                SELECT SoDonDH from dathang WHERE MSKH=".$MSKH."
            ";
            $all_active = "active";
            break;
    }
    
    $sql_total_DonHang .= " ORDER BY SoDonDH DESC;";


    $data_DonHang_temp = sql_query($sql_total_DonHang);
    $total_DonHang = count($data_DonHang_temp);
    
    if($total_DonHang > 0) {

        $data_DonHang = $data_DonHang_temp;

    } else {
        
        $total_DonHang = 0;
        $data_DonHang = [];
    }
    
    $_SESSION['data_DonHang'] = $data_DonHang;

    echo '
    
        <div id="container_ad">
            <div class="grid">
                <div class="grid__row">

                    <!-- Danh muc -->
                    <div class="grid__col-2">
                        <div class="category">
                            <div class="category-header">
                                <i class="category-header__icon fas fa-ellipsis-v"></i>
                                <span class="category-header__name">Quản lý đơn hàng</span>

                                <!-- <i class="category-header__icon fas fa-angle-up"></i> -->
                                <!-- <i class="category-header__icon fas fa-angle-down"></i> -->
                            </div>

                            <ul class="cate-list cate-list__order">
                                <li class="cate-list__item '.$all_active.'">
                                    <a href="?action_page=imp_purchase&action_view=all&random='.rand().'" class="cate-list__item-link">
                                        Tất cả
                                    </a>
                                </li>
                                <li class="cate-list__item '.$wait_active.'">
                                    <a href="?action_page=imp_purchase&action_view=wait_comfirm&random='.rand().'" class="cate-list__item-link">
                                        Chờ xác nhận
                                    </a>
                                </li>
                                <li class="cate-list__item '.$comfirmed_active.'">
                                    <a href="?action_page=imp_purchase&action_view=comfirmed&random='.rand().'" class="cate-list__item-link">
                                        Đã xác nhận
                                    </a>
                                </li>
                                <li class="cate-list__item '.$cancel_active.'">
                                    <a href="?action_page=imp_purchase&action_view=canceled&random='.rand().'" class="cate-list__item-link">
                                        Đơn hủy
                                    </a>
                                </li>
                            </ul>

                            <div class="category-header">
                                <i class="category-header__icon fas fa-ellipsis-v"></i>
                                <span class="category-header__name">Tài khoản của tôi</span>

                                <!-- <i class="category-header__icon fas fa-angle-up"></i> -->
                                <!-- <i class="category-header__icon fas fa-angle-down"></i> -->
                            </div>

                            <ul class="cate-list cate-list__product">
                                <li class="cate-list__item">
                                    <a href="?action_page=my_account&random='.rand().'" class="cate-list__item-link">
                                        Thông tin tài khoản
                                    </a>
                                </li>
                                
                                <li class="cate-list__item">
                                    <a href="?action_page=my_address&random='.rand().'" class="cate-list__item-link">
                                        Địa chỉ
                                    </a>
                                </li>

                             
                            </ul>
                        </div>
                    </div>
                    <!-- End: danh muc -->

                    <!-- DISPLAY -->
                    <div class="grid__col-10">
                        <div class="body-container">
                            
                            <!-- QUAN LY DON HANG -->
                            <div class="container-order">

                                <!-- MENU -->
                                <!-- <div class="container-nav">
                                    <ul class="container-nav__list">
                                        <li class="container-nav__list-item" onclick="active_container_nav(this)">
                                            <a href="?action_page=imp_purchase&action_view=all&random='.rand().'" class="container-nav__list-link">Tất cả</a>
                                        </li>
                                        <li class="container-nav__list-item">
                                            <a href="?action_page=imp_purchase&action_view=wait_comfirm&random='.rand().'" class="container-nav__list-link">Chờ xác nhận</a>
                                        </li>
                                        <li class="container-nav__list-item">
                                            <a href="?action_page=imp_purchase&action_view=comfirmed&random='.rand().'" class="container-nav__list-link">Đã xác nhận</a>
                                        </li>
                                        <li class="container-nav__list-item">
                                            <a href="?action_page=imp_purchase&action_view=canceled&random='.rand().'" class="container-nav__list-link">Đơn hủy</a>
                                        </li>
                                    </ul>
                                </div> -->
                                <!-- End: MENU -->

                                <!-- MENU -->
                                <div class="container-nav">
                                    <ul class="container-nav__list">
                                        <li class="container-nav__list-item '.$all_active.'" id="test" onclick="return active_container_nav(this); return false;">
                                            <a href="?action_page=imp_purchase&action_view=all&random='.rand().'" class="container-nav__list-link">Tất cả</a>
                                        </li>
                                        <li class="container-nav__list-item '.$wait_active.'">
                                            <a href="?action_page=imp_purchase&action_view=wait_comfirm&random='.rand().'" class="container-nav__list-link">Chờ xác nhận</a>
                                        </li>
                                        <li class="container-nav__list-item '.$comfirmed_active.'">
                                            <a href="?action_page=imp_purchase&action_view=comfirmed&random='.rand().'" class="container-nav__list-link">Đã xác nhận</a>
                                        </li>
                                        <li class="container-nav__list-item '.$cancel_active.'">
                                            <a href="?action_page=imp_purchase&action_view=canceled&random='.rand().'" class="container-nav__list-link">Đơn hủy</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End: MENU -->

                                <!-- TABLE DISPLAY -->
                                <div class="container-detail">
                                    <table class="container-table">
                                        <caption class="container-table__caption" >
                                            <h1 style="font-size: 3rem;">
                                               <!-- <span class="container-table__caption-count" > '.$total_DonHang.' </span> -->
                                                '.$total_DonHang.' Đơn hàng
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

        if(!empty($soDH)) {

            $stt++;

            $color_stt = "#000";
            if($stt % 2 == 0 ) {
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
                where dh.MSKH = ".$MSKH." and ctdh.SoDonDH = ".(int)$soDH["SoDonDH"]."
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
                $total_price += ( (int)$data['SoLuong'] * (int)$data['Gia'] * (1 - (float)$data['GiamGia']) );
            }

            foreach($data_details as $data) {

                $status = (int) $data['TrangThaiDH'];
                $status_displaty = '';

                switch ($status) {
                    case 1: 
                        $status_displaty = "Đã xác nhận";
                        break;

                    case -1: 
                        $status_displaty = "Đã hủy đơn";
                        break;

                    default: 
                        $status_displaty = "Chờ xác nhận";
                        break;

                }

                if(!empty($data)) {

                    $ngayDH_format = strtotime($data["NgayDH"]);
                    $ngayDH_format = date("d-m-Y", $ngayDH_format);

                    $ngayGH_format = strtotime($data["NgayGH"]);
                    $ngayGH_format = date("d-m-Y", $ngayGH_format);


                    if($count_print_colspan == 0) {
                        echo '
                        
                            <!-- Don hang '.$stt.' -->
                            <tr>
                                <td class="container-table__stt" rowspan="'.$count_product_purchased.'" style="text-align:center; font-weight: bold; 
                                    color: '.$color_stt.'"> 
                                    '.$stt.' 
                                    <p style="color: var(--primary-color);"><i>('.$ngayDH_format.')</i></p>

                        ';
                                if($check_login_admin) {
                                    echo '
                                        <p><i> (MSNV: '.$MSNV.') </i></p>
                                        <p><i> (MSKH: '.$MSKH.') </i></p>
                                    ';
                                }
                        echo '

                                </td>

                                <td class="container-table__price">'.$data["TenHH"].'  <b>(x'.$data["SoLuong"].')</b> </td>

                                <td style="text-align: center;">
                                    '.format_money($data["Gia"]).' <sup>đ</sup> 
                        ';
                                    if((float)$data["GiamGia"] > 0) {
                                        echo '
                                            <p style="color: var(--primary-color);"><i>(-'.round((float)$data["GiamGia"] * 100, 2).'%)</i></p>
                                        ';
                                    }
                        echo '
                                </td>
                
                                <td>
                                    <a href="?action_page=detail_product&id_product='.$data["MSHH"].'" style="text-align: center; display: block;">
                                        <img src="../../'.$data["TenHinh"].'" alt="hinh anh HH" style="height: 50px; box-shadow: 0 0 4px rgba(0, 0, 0, 0.4)">
                                    </a>
                                </td>
                
                                <td class="container-table__price-total" rowspan="'.$count_product_purchased.'" style="text-align:center; color: var(--primary-color)">
                                    '.format_money($total_price).' <sup>đ</sup>
                                </td>

                                <td rowspan="'.$count_product_purchased.'" style="text-align:center;">
                                    <div class="container-table__trangthai-col">
                                        <button class="container-table__trangthai btn btn--disabled">'.$status_displaty.'</button>
                        ';
                                if((int) $data['TrangThaiDH'] === 0) {
                                    echo '
                                        <button class="container-table__trangthai btn btn--danger" value="'.$stt.'" 
                                            onclick="cancel_purchased('.(int)$data["SoDonDH"].', '.(int)$MSKH.', this);">
                                            Hủy Đơn
                                        </button>
                                    ';
                                }
                                else {
                                    if((int) $data['TrangThaiDH'] === 1) {
                                        echo '
                                            <p style="color: var(--primary-color);">
                                                Ngày GH<br>
                                                <i>('.$ngayGH_format.')</i>
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
                        
                            <!-- Don hang '.$stt.' -->
                            <tr>
    
                                <td class="container-table__price">'.$data["TenHH"].'  <b>(x'.$data["SoLuong"].')</b> </td>
    
                                <td style="text-align: center;">
                                    '.format_money($data["Gia"]).' <sup>đ</sup> 
                        ';
                                    if((float)$data["GiamGia"] > 0) {
                                        echo '
                                           <p style="color: var(--primary-color);"><i>(-'.round((float)$data["GiamGia"] * 100, 2).'%)</i></p>
                                        ';
                                    }
                        echo '
                                </td>
                
                                <td>
                                    <a href="?action_page=detail_product&id_product='.$data["MSHH"].'" style="text-align: center; display: block;">
                                        <img src="../../'.$data["TenHinh"].'" alt="hinh anh HH" style="height: 50px; box-shadow: 0 0 4px rgba(0, 0, 0, 0.4)">
                                    </a>
                                </td>
                
                            </tr>
            
            
                            <!-- End: don hang '.$stt.' -->
                        
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

                        </div>
                    </div>
                    <!-- End: DISPLAY -->

                </div>
            </div>
        </div>
    
    ';

}


// Quan ly tai khoan.
function my_account() {

    $data_my_info = [];
    $ma_so = $ho_ten = $so_dien_thoai = '';
    // $ma_dia_chi_s = $dia_chi_s = [];
    $ten_cty = $so_fax = '';
    $chuc_vu = '';

    // Ma so khach hang
    $MSKH = -1;

    if(isset($_SESSION['MSKH'])) {
        $MSKH = (int) $_SESSION['MSKH'];
    }


    if (!isset($_SESSION["data_my_info"]) || empty($_SESSION["data_my_info"])) {
        
        
        $sql_my_info = "SELECT * from khachhang as kh left join diachikh as dc on kh.MSKH = dc.MSKH where kh.MSKH=".$MSKH.";";

        $data_my_info_temp = sql_query($sql_my_info);

        $_SESSION["data_my_info"] = $data_my_info_temp;

        $data_my_info = $data_my_info_temp;
    
    } 

    if(isset($_SESSION["data_my_info"])) {
        $data_my_info = $_SESSION["data_my_info"];
    }
    

    
    if(!empty( $data_my_info[0]["HoTenKH"])) {
        $ho_ten = trim($data_my_info[0]["HoTenKH"]);
    }
    if(!empty( $data_my_info[0]["SoDienThoai"])) {
        $so_dien_thoai = trim($data_my_info[0]["SoDienThoai"]);
    }
    if(!empty( $data_my_info[0]["DiaChi"])) {
        $dia_chi =  trim($data_my_info[0]["DiaChi"]);
    }
    if(!empty( $data_my_info[0]["TenCongTy"])) {
        $ten_cty =  trim($data_my_info[0]["TenCongTy"]);
    }
    if(!empty( $data_my_info[0]["SoFax"])) {
        $so_fax = trim($data_my_info[0]["SoFax"]);
    }


    echo '
    
        <div id="container_ad">
            <div class="grid">
                <div class="grid__row">

                    <!-- Danh muc -->
                    <div class="grid__col-2">
                        <div class="category">
                            <div class="category-header">
                                <i class="category-header__icon fas fa-ellipsis-v"></i>
                                <span class="category-header__name">Quản lý đơn hàng</span>

                                <!-- <i class="category-header__icon fas fa-angle-up"></i> -->
                                <!-- <i class="category-header__icon fas fa-angle-down"></i> -->
                            </div>

                            <ul class="cate-list cate-list__order">
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=all&random='.rand().'" class="cate-list__item-link">
                                        Tất cả
                                    </a>
                                </li>
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=wait_comfirm&random='.rand().'" class="cate-list__item-link">
                                        Chờ xác nhận
                                    </a>
                                </li>
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=comfirmed&random='.rand().'" class="cate-list__item-link">
                                        Đã xác nhận
                                    </a>
                                </li>
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=canceled&random='.rand().'" class="cate-list__item-link">
                                        Đơn hủy
                                    </a>
                                </li>
                            </ul>

                            <div class="category-header">
                                <i class="category-header__icon fas fa-ellipsis-v"></i>
                                <span class="category-header__name">Tài khoản của tôi</span>

                                <!-- <i class="category-header__icon fas fa-angle-up"></i> -->
                                <!-- <i class="category-header__icon fas fa-angle-down"></i> -->
                            </div>

                            <ul class="cate-list cate-list__product">
                                <li class="cate-list__item active">
                                    <a href="?action_page=my_account&random='.rand().'" class="cate-list__item-link">
                                        Thông tin tài khoản
                                    </a>
                                </li>

                                <li class="cate-list__item">
                                    <a href="?action_page=my_address&random='.rand().'" class="cate-list__item-link">
                                        Địa chỉ
                                    </a>
                                </li>

                            
                            </ul>
                        </div>
                    </div>
                    <!-- End: danh muc -->

                    <!-- DISPLAY -->
                    <div class="grid__col-10">

                        <div class="body-container">
                            <!-- Profile -->
                            <div class="container-account">
                                <div class="container-account__header">Hồ sơ của tôi</div>

                                <div class="container-profile">
                                    <form action="process_user.php" method="post" name="frmProfile" >

                                        <label class="frm-label" for="frmName">Họ và Tên</label> <br>
                                        <input class="frm-input frm-input--focus" type="text" name="frmName" id="frmName" value="'.$ho_ten.'">
                                        <br><br>

                                        <label class="frm-label" for="frmCty">Tên công ty</label> <br>
                                        <input class="frm-input frm-input--focus" type="text" name="frmCty" id="frmCty" value="'.$ten_cty.'">
                                        <br><br>

                                        <label class="frm-label" for="frmSdt">Số điện thoại</label> <br>
                                        <input class="frm-input frm-input--focus" type="text" name="frmSdt" id="frmSdt" value="'.$so_dien_thoai.'">
                                        <br><br>

                                        <label for="frmDiaChi" class="frm-label">Địa Chỉ</label>
                                        <select name="frmDiaChi" id="frmDiaChi" class="frm-input frm-input--focus" readonly>
    ';
                                foreach ($data_my_info as $data) {
                                    if(!empty($data)) {
                                        echo '
                                            <option value="'.(int)$data["MaDC"].'">'.$data["DiaChi"].'</option>
                                        ';
                                    }
                                } 
    echo '
                                        </select>
                                        <br><br>

                                        <label class="frm-label" for="frmFax">Số Fax</label> <br>
                                        <input class="frm-input frm-input--focus" type="text" name="frmFax" id="frmFax" value="'.$so_fax.'">
                                        <br><br>

                                        <input type="submit" name="submit_save_my_info" value="Lưu" class="btn btn--primary" 
                                            onclick="return confirm(\'Xác nhận chỉnh sửa thông tin ?\')">
                                    </form>

                                </div>        
                            </div>
                            <!-- End: Profile -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
                

    ';
}

// Quan ly dia chi dat hang.
function my_address() {

    $action_address = '';

    if(isset($_GET['action_address'])) {
        $action_address = trim( $_GET['action_address'] );
    }

    switch ($action_address) {

        case 'add_new_address':
            add_new_address();
            break;

        case 'edit_address':
            update_addresses();
            break;

        default:
            show_add_address();
            break;
    }

    
    // add_new_addresses();


}

// hien thi tat ca dia chi
function show_add_address() {

    $data_my_info = [];

    // Ma so khach hang
    $MSKH = -1;

    if(isset($_SESSION['MSKH'])) {
        $MSKH = (int) $_SESSION['MSKH'];
    }

    $total_address = 0;

    if (!isset($_SESSION["data_my_info"])) {
        
        $sql_my_info = "SELECT * from khachhang as kh left join diachikh as dc on kh.MSKH = dc.MSKH where kh.MSKH=".$MSKH.";";
        $data_my_info_temp = sql_query($sql_my_info);

        $_SESSION["data_my_info"] = $data_my_info_temp;
        // $data_my_info = $data_my_info_temp;
    } 

    if(isset($_SESSION["data_my_info"])) {

        $data_my_info = $_SESSION["data_my_info"];
        $total_address = count($data_my_info) > 0 ? count($data_my_info) : 0 ;
    }

    echo '
    
        <div id="container_ad">
            <div class="grid">
                <div class="grid__row">

                    <!-- Danh muc -->
                    <div class="grid__col-2">
                        <div class="category">
                            <div class="category-header">
                                <i class="category-header__icon fas fa-ellipsis-v"></i>
                                <span class="category-header__name">Quản lý đơn hàng</span>

                                <!-- <i class="category-header__icon fas fa-angle-up"></i> -->
                                <!-- <i class="category-header__icon fas fa-angle-down"></i> -->
                            </div>

                            <ul class="cate-list cate-list__order">
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=all&random='.rand().'" class="cate-list__item-link">
                                        Tất cả
                                    </a>
                                </li>
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=wait_comfirm&random='.rand().'" class="cate-list__item-link">
                                        Chờ xác nhận
                                    </a>
                                </li>
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=comfirmed&random='.rand().'" class="cate-list__item-link">
                                        Đã xác nhận
                                    </a>
                                </li>
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=canceled&random='.rand().'" class="cate-list__item-link">
                                        Đơn hủy
                                    </a>
                                </li>
                            </ul>

                            <div class="category-header">
                                <i class="category-header__icon fas fa-ellipsis-v"></i>
                                <span class="category-header__name">Tài khoản của tôi</span>

                                <!-- <i class="category-header__icon fas fa-angle-up"></i> -->
                                <!-- <i class="category-header__icon fas fa-angle-down"></i> -->
                            </div>

                            <ul class="cate-list cate-list__product">
                                <li class="cate-list__item">
                                    <a href="?action_page=my_account&random='.rand().'" class="cate-list__item-link">
                                        Thông tin tài khoản
                                    </a>
                                </li>

                                <li class="cate-list__item active">
                                    <a href="?action_page=my_address&random='.rand().'" class="cate-list__item-link">
                                        Địa chỉ
                                    </a>
                                </li>

                            
                            </ul>
                        </div>
                    </div>
                    <!-- End: danh muc -->

                    <!-- DISPLAY -->
                    <div class="grid__col-10">

                        <div class="body-container">
                            <!-- Profile -->
                            <div class="container-account">
                                <div class="container-account__header">Địa chỉ nhận hàng</div>

                                <div class="container-profile">
                                    <form action="" name="frmProfile">

                                        <label for="frmDiaChi" class="frm-label">Địa Chỉ</label>

    ';
                        // echo '<pre>';
                        // print_r($data_my_info);
                        // echo '</pre>';

                        foreach ($data_my_info as $data) {

                            if(!empty($data)) {
                                echo '
                                        <br><br>
                                        <textarea cols="70" rows="5" value="test" readonly="true" style="font-size: 1.6rem;">'.$data["DiaChi"].'</textarea>

                                        <!-- <button class="btn">Thiết lập mặc định</button> -->

                                        <a href="?action_page=my_address&action_address=edit_address&MaDC='.$data["MaDC"].'&random='.rand().'" class="btn btn--wait" value="'.$data["MaDC"].'" style="padding: 9px 28px;"> Edit </a>

                                        <button class="btn btn--danger" value="'.$data['MaDC'].'" onclick="return delete_dia_chi_kh(this, '.$total_address.',    '.$MSKH.')">Delete</button>

                                        <br><br>
                                ';
                            }
                        } 
    echo '

                                        <!-- <input type="submit" value="Lưu" class="btn btn--primary"> -->
                                        <a href="?action_page=my_address&action_address=add_new_address&random='.rand().'" class="btn btn--wait" style="padding: 12px;">+Thêm địa chỉ mới </a>

                                    </form>

                                </div>        
                            </div>
                            <!-- End: Profile -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
                

    ';
    
}


// Them dia chi dat hang
function update_addresses() {

    // Ma so khach hang
    $MSKH = -1;

    if(isset($_SESSION['MSKH'])) {
        $MSKH = (int) $_SESSION['MSKH'];
    }

    $ma_dc_edit = -1;
    $address_text = '';

    $data_my_info = [];

    if (!isset($_SESSION["data_my_info"])) {
        
        $sql_my_info = "SELECT * from khachhang as kh left join diachikh as dc on kh.MSKH = dc.MSKH where kh.MSKH=".$MSKH.";";
        $data_my_info_temp = sql_query($sql_my_info);
        $_SESSION["data_my_info"] = $data_my_info_temp;
    
    } 

    if(isset($_SESSION["data_my_info"])) {
        $data_my_info = $_SESSION["data_my_info"];
    }

    if(isset($_GET['MaDC'])) {
        $ma_dc_edit = (int) $_GET['MaDC'];
    }

    foreach($data_my_info as $key => $val) {

        if( (int)$val['MaDC'] === $ma_dc_edit) {

            $address_text = $val['DiaChi'];
        }

    }


    
    echo '
    
        <div id="container_ad">
            <div class="grid">
                <div class="grid__row">

                    <!-- Danh muc -->
                    <div class="grid__col-2">
                        <div class="category">
                            <div class="category-header">
                                <i class="category-header__icon fas fa-ellipsis-v"></i>
                                <span class="category-header__name">Quản lý đơn hàng</span>

                                <!-- <i class="category-header__icon fas fa-angle-up"></i> -->
                                <!-- <i class="category-header__icon fas fa-angle-down"></i> -->
                            </div>

                            <ul class="cate-list cate-list__order">
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=all&random='.rand().'" class="cate-list__item-link">
                                        Tất cả
                                    </a>
                                </li>
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=wait_comfirm&random='.rand().'" class="cate-list__item-link">
                                        Chờ xác nhận
                                    </a>
                                </li>
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=comfirmed&random='.rand().'" class="cate-list__item-link">
                                        Đã xác nhận
                                    </a>
                                </li>
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=canceled&random='.rand().'" class="cate-list__item-link">
                                        Đơn hủy
                                    </a>
                                </li>
                            </ul>

                            <div class="category-header">
                                <i class="category-header__icon fas fa-ellipsis-v"></i>
                                <span class="category-header__name">Tài khoản của tôi</span>

                                <!-- <i class="category-header__icon fas fa-angle-up"></i> -->
                                <!-- <i class="category-header__icon fas fa-angle-down"></i> -->
                            </div>

                            <ul class="cate-list cate-list__product">
                                <li class="cate-list__item">
                                    <a href="?action_page=my_account&random='.rand().'" class="cate-list__item-link">
                                        Thông tin tài khoản
                                    </a>
                                </li>

                                <li class="cate-list__item active">
                                    <a href="?action_page=my_address&random='.rand().'" class="cate-list__item-link">
                                        Địa chỉ
                                    </a>
                                </li>

                            
                            </ul>
                        </div>
                    </div>
                    <!-- End: danh muc -->

                    <!-- DISPLAY -->
                    <div class="grid__col-10">

                        <div class="body-container">
                            <!-- Profile -->
                            <div class="container-account">
                                <div class="container-account__header">Cập nhật địa chỉ nhận hàng</div>

                                <div class="container-profile">
                                    <form>

                                        <label for="frmDiaChi" class="frm-label">Cập nhật địa Chỉ</label>
                                        <br><br>

                                        <textarea name="add_new_address_text" id="update_address_text" cols="50" rows="10" style="font-size: 1.6rem;padding: 24px;">'.trim($address_text).'</textarea>
                                        <br><br>

                                        <button type="submit" class="btn btn--success" onclick="return update_address('.$MSKH.' ,'.$ma_dc_edit.')">Lưu</button>

                                    </form>
                                </div>        
                            </div>
                            <!-- End: Profile -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
                

    ';
}


// process cap nhat dia chi dat hang
function process_update_addresses() {

    $MSKH  = -1;
    $MaDC  = -1;

    $address_text = '';
    $check_success = false;
    
    if(isset($_POST['MSKH']) && !empty($_POST['MSKH'])) {
        $MSKH = (int) $_POST['MSKH'];
    }

    if(isset($_POST['address_text']) && !empty($_POST['address_text'])) {
        $address_text = trim($_POST['address_text']);
    }

    if(isset($_POST['MaDC']) && !empty($_POST['MaDC'])) {
        $MaDC = (int) $_POST['MaDC'];
    }



    if ($MSKH > 0 && $MaDC > 0 && !empty($address_text)) {

        // $sql_update_address = "INSERT INTO diachikh(DiaChi, MSKH) values('".$address_text."', ".$MSKH.") ;" ;
        $sql_update_address = "UPDATE diachikh SET DiaChi='".$address_text."' where MaDC=".$MaDC.";" ;

        if(sql_execute($sql_update_address)) {

            $sql_my_info = "SELECT * from khachhang as kh left join diachikh as dc on kh.MSKH = dc.MSKH where kh.MSKH=".$MSKH.";";
            $data_my_info_temp = sql_query($sql_my_info);
            $_SESSION["data_my_info"] = $data_my_info_temp;

            $check_success = true;

        } else {
            $check_success = false;
        }
    }

    if($check_success) {
        echo "update_address_success";
    } else {
        echo "update_address_fail";
    }


}


// Them dia chi dat hang
function add_new_address() {

    $MSKH = -1;

    if(isset($_SESSION['MSKH'])) {
        $MSKH = (int) $_SESSION['MSKH'];
    }

    
    echo '
    
        <div id="container_ad">
            <div class="grid">
                <div class="grid__row">

                    <!-- Danh muc -->
                    <div class="grid__col-2">
                        <div class="category">
                            <div class="category-header">
                                <i class="category-header__icon fas fa-ellipsis-v"></i>
                                <span class="category-header__name">Quản lý đơn hàng</span>

                                <!-- <i class="category-header__icon fas fa-angle-up"></i> -->
                                <!-- <i class="category-header__icon fas fa-angle-down"></i> -->
                            </div>

                            <ul class="cate-list cate-list__order">
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=all&random='.rand().'" class="cate-list__item-link">
                                        Tất cả
                                    </a>
                                </li>
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=wait_comfirm&random='.rand().'" class="cate-list__item-link">
                                        Chờ xác nhận
                                    </a>
                                </li>
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=comfirmed&random='.rand().'" class="cate-list__item-link">
                                        Đã xác nhận
                                    </a>
                                </li>
                                <li class="cate-list__item">
                                    <a href="?action_page=imp_purchase&action_view=canceled&random='.rand().'" class="cate-list__item-link">
                                        Đơn hủy
                                    </a>
                                </li>
                            </ul>

                            <div class="category-header">
                                <i class="category-header__icon fas fa-ellipsis-v"></i>
                                <span class="category-header__name">Tài khoản của tôi</span>

                                <!-- <i class="category-header__icon fas fa-angle-up"></i> -->
                                <!-- <i class="category-header__icon fas fa-angle-down"></i> -->
                            </div>

                            <ul class="cate-list cate-list__product">
                                <li class="cate-list__item">
                                    <a href="?action_page=my_account&random='.rand().'" class="cate-list__item-link">
                                        Thông tin tài khoản
                                    </a>
                                </li>

                                <li class="cate-list__item active">
                                    <a href="?action_page=my_address&random='.rand().'" class="cate-list__item-link">
                                        Địa chỉ
                                    </a>
                                </li>

                            
                            </ul>
                        </div>
                    </div>
                    <!-- End: danh muc -->

                    <!-- DISPLAY -->
                    <div class="grid__col-10">

                        <div class="body-container">
                            <!-- Profile -->
                            <div class="container-account">
                                <div class="container-account__header">Thêm địa chỉ nhận hàng</div>

                                <div class="container-profile">
                                    <form>

                                        <label for="frmDiaChi" class="frm-label">Nhập địa Chỉ</label>
                                        <br><br>

                                        <textarea name="add_new_address_text" id="add_new_address_text" cols="70" rows="10" style="font-size: 1.6rem; 
                                            padding: 24px;"></textarea>
                                        <br><br>

                                        <button type="submit" class="btn btn--success" onclick="return add_new_addresses('.$MSKH.')">Lưu</button>
                                        <button type="reset" class="btn btn--wait" onclick="return update_addresses('.$MSKH.')">Reset</button>

                                    </form>
                                </div>        
                            </div>
                            <!-- End: Profile -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
                

    ';
}

//  process add new address
function process_add_new_address() {

    $MSKH  = -1 ;
    $address_text = '';
    $check_success = false;
    
    if(isset($_POST['MSKH']) && !empty($_POST['MSKH'])) {
        $MSKH = (int) $_POST['MSKH'];
    }

    if(isset($_POST['address_text']) && !empty($_POST['address_text'])) {
        $address_text = trim($_POST['address_text']);
    }

    if ($MSKH > 0 && !empty($address_text)) {

        $sql_add_address = "INSERT INTO diachikh(DiaChi, MSKH) values('".$address_text."', ".$MSKH.") ;" ;

        if(sql_execute($sql_add_address)) {

            $sql_my_info = "SELECT * from khachhang as kh left join diachikh as dc on kh.MSKH = dc.MSKH where kh.MSKH=".$MSKH.";";
            $data_my_info_temp = sql_query($sql_my_info);
            $_SESSION["data_my_info"] = $data_my_info_temp;

            $check_success = true;

        } else {
            $check_success = false;
        }
    }

    if($check_success) {
        echo "add_address_success";
    } else {
        echo "add_address_fail";
    }
    

}


// Xóa đị chỉ người dùng > 1
function delete_dia_chi_kh() {

    $MaDC = $MSKH = -1;
    $check_success = false;

    if(isset($_POST['MSKH']) && !empty($_POST['MSKH'])) {
        $MSKH = (int) $_POST['MSKH'];
    }

    if(isset($_POST['MaDC']) && !empty($_POST['MaDC'])) {
        $MaDC = (int) $_POST['MaDC'];
    }


    if($MSKH > 0 && $MaDC > 0) {

        $sql_delete_maDC = "DELETE FROM diachikh where MaDC=".$MaDC.";" ;

        if(sql_execute($sql_delete_maDC)) {
            
            $sql_my_info = "SELECT * from khachhang as kh left join diachikh as dc on kh.MSKH = dc.MSKH where kh.MSKH=".$MSKH.";";
            $data_my_info_temp = sql_query($sql_my_info);
            $_SESSION["data_my_info"] = $data_my_info_temp;

            $check_success = true;

        } else {
            $check_success = false;
        }

    }
 
    if($check_success) {
        echo "delete_success";
    } else {
        echo "delete_fail";
    }

}


// Hien thi dia chi dat hang trong gi hang
function my_address_in_cart() {

    $data_my_info = [];
    $ho_ten = $so_dien_thoai = '';
    // $ma_so = '';
    // $ma_dia_chi_s = $dia_chi_s = [];
    // $ten_cty = $so_fax = '';
    // $chuc_vu = '';

    // Ma so khach hang
    $MSKH = -1;

    if(isset($_SESSION['MSKH'])) {
        $MSKH = (int) $_SESSION['MSKH'];
    }

    if (!isset($_SESSION["data_my_info"])) {
        
        $sql_my_info = "SELECT * from khachhang as kh left join diachikh as dc on kh.MSKH = dc.MSKH where kh.MSKH=$MSKH;  ";
        $data_my_info_temp = sql_query($sql_my_info);
        $_SESSION["data_my_info"] = $data_my_info_temp;
    
    } 

    if(isset($_SESSION["data_my_info"])) {
        $data_my_info = $_SESSION["data_my_info"];
    }
    
    // if(!empty($data_my_info)) {

    //     $ho_ten = $data_my_info[0]["HoTenKH"];
    //     $so_dien_thoai = $data_my_info[0]["SoDienThoai"];
    // }

    if(!empty($data_my_info[0]["HoTenKH"])) { 
        $ho_ten = $data_my_info[0]["HoTenKH"];
    }
    if(!empty($data_my_info[0]["SoDienThoai"])) { 
        $so_dien_thoai = $data_my_info[0]["SoDienThoai"];
    }


    echo '
    
        <div id="container_ad">
            <div class="grid">
                <div class="grid__row">

                    <!-- DISPLAY -->
                    <div class="grid__col-10">

                        <div class="body-container">
                            <!-- Profile -->
                            <div class="container-account">
                                <div class="container-account__header">Địa chỉ nhận hàng</div>

                                <div class="container-profile">
                                    <form action="" name="frmProfile">
                                        <label class="frm-label" for="frmName">Họ và Tên</label> <br>
                                        <input class="frm-input frm-input--focus" type="text" name="frmName" id="frmName" value="'.$ho_ten.'" readonly>
                                        <br><br>


                                        <label class="frm-label" for="frmSdt">Số điện thoại</label> <br>
                                        <input class="frm-input frm-input--focus" type="text" name="frmSdt" id="frmSdt" value="'.$so_dien_thoai.'" readonly>
                                        <br><br>

                                        <label for="frmDiaChi" class="frm-label">Địa Chỉ</label>
                                        <select name="frmDiaChi" id="frmDiaChi" class="frm-input frm-input--focus" readonly>
    ';
                                foreach ($data_my_info as $data) {
                                    if(!empty($data)) {
                                        echo '
                                            <option value="'.(int)$data["MaDC"].'">'.$data["DiaChi"].'</option>
                                        ';
                                    }
                                } 
    echo '
                                        </select>

                                    </form>
                                </div>        
                            </div>
                            <!-- End: Profile -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
                

    ';

}


// Sort_bar
function imp_sort_bar($index_to_show_data_page) {

    $end_page = '...';
    $data_type = 0;


    if(!empty($_SESSION['total_page'])) {
        if(isset($_SESSION['total_page'])) {
            $end_page = (int) $_SESSION['total_page'];
        }
    }

    if(!empty($_SESSION['data_type'])) {
        if(isset($_SESSION['data_type'])) {
            $data_type = (int) $_SESSION['data_type'];
        }
    }

    echo '
                
        <!-- San pham Header -->
        <div class="sort-bar">
            <div class="sort-bar__item home-filter__option">
                <span class="home-filter__label">Sắp xếp theo</span>
                <!-- <button class="home-filter__btn btn">Phổ biến</button>
                <button class="home-filter__btn btn btn--primary">Mới nhất</button>
                <button class="home-filter__btn btn">Bán chạy</button> -->
                
                <div class="home-filter__btn select-input">
                    <span class="select-input__label">Giá</span>
                    <i class="select-input__icon fas fa-angle-down"></i>

                    <div class="select-input__sort-price">
                        <a href="?data_type='.$data_type.'&sort_product=ASC"><p class="sort-price__item sort-price__a-z">Giá: Thấp đến Cao</p></a>
                        <a href="?data_type='.$data_type.'&sort_product=DESC"><p class="sort-price__item sort-price__z-a">Giá: Cao đến Thấp</p></a>
                    </div>
                </div>
            </div>

            <div class="sort-bar__item home-filter__page">
                <div class="home-filter__page-item home-filter__num-page">
                    <!-- <span class="home-filter__now-page">1</span> -->
                    <span class="home-filter__now-page">'.$index_to_show_data_page.'</span>
                    /
                    <!-- <span class="home-filter__end-page">14</span> -->
                    <span class="home-filter__end-page">'.$end_page.'></span>
                </div>

                <div class="home-filter__page-item home-filter__page-control">
                    <button class="btn-back btn-control">
                        <i class="btn-control__icon fas fa-angle-left"></i>
                    </button>

                    <button class="btn-next btn-control">
                        <i class="btn-control__icon fas fa-angle-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- End: San pham Header -->
    
    ';
}

// Chi tiet san pham
function imp_product_info() {
    
    $path_localhost = '../../';

    $data = [];
    $path_TenHinh = $TenHH = '';

    $Gia = $SoLuongHang= $MSHH = -1;
    $id_mshh_product_clicked = -1;
    $index_in_data_array = -1;
    $quy_cach = '';

    $check_login = false;

    if(!empty($_SESSION)) {

        if( isset($_SESSION['id_mshh_product_clicked']) && isset($_SESSION['data']) ) {

            $id_mshh_product_clicked = (int) $_SESSION['id_mshh_product_clicked'];
            $data = $_SESSION['data'];
            // print_arr($data);

            foreach ($data as $key => $val) {
                if( (int)$val["MSHH"] === $id_mshh_product_clicked) {
                    
                    $index_in_data_array = (int) $key;
                    break;
                }
            }

            if($index_in_data_array < 0) {
                
                $data = get_data_by_mshh($id_mshh_product_clicked);
                if(!empty($data)) {
                    $index_in_data_array = 0;
                }
            }
            // print_arr($data);
            // echo "id_mshh_product_clicked: ".$id_mshh_product_clicked;

        }

        if(isset($_SESSION['check_login']) && $_SESSION['check_login'] === true) {
            $check_login = true;
        }
    }

    if(!empty($data)) {

        $TenHH = !empty($data[$index_in_data_array]['TenHH']) ? $data[$index_in_data_array]['TenHH'] : 'Unknow';

        $Gia = !empty($data[$index_in_data_array]['Gia']) ? (int) $data[$index_in_data_array]['Gia'] : 0;

        $SoLuongHang = !empty($data[$index_in_data_array]['SoLuongHang']) ? (int) $data[$index_in_data_array]['SoLuongHang'] : -1 ;

        $MSHH = !empty($data[$index_in_data_array]['MSHH']) ? (int) $data[$index_in_data_array]['MSHH'] : -1 ;

        // $path_TenHinh = $path_localhost.$data[$index_in_data_array]['TenHinh'];
        $path_TenHinh = !empty($data[$index_in_data_array]['TenHinh']) ? $path_localhost.$data[$index_in_data_array]['TenHinh'] : $path_localhost ;

        $quy_cach = !empty($data[$index_in_data_array]['QuyCach']) ? trim($data[$index_in_data_array]['QuyCach']) : "";

    }



    echo '

        <div id="container">
            <div class="grid">
                <div class="grid__row" >
                    <div class="grid__full-width">

                        <form action="" method="post">
                            
                            <div class="product-detial">

                                <div class="product-detail__item" style="width: 450px; height: 450px; padding: 5px;">
                                    <div class="product-detail__img" style="background-image: url(\''.$path_TenHinh.'\')"></div>
                                </div>

                                <div class="product-detail__item product-detail__item--right">
                                    <div class="product-detail__item--item product-detail__name">
                                        <!-- Xốp dán tường giả gạch 3D - Khổ lớn 70x77cm -->
                                        '.$TenHH.'
                                    </div>

                                    <div class="product-detail__item--item product-detail__price">
                                        <!-- VND 8.000 -->
                                        <sup>VNĐ</sup>
                                        <span class="product-detail__price product-detail__price-value">
                                            '.number_format($Gia,0,",",".").'
                                        </span>
                                    </div>

                                    <div class="product-detail__item--item product-detail__quantity">
                                        <span class="product-detail__quantity-lable">
                                            Số lượng
                                        </span>
                                        <!-- <button class="product-detail__quantity-less">-</button> -->

                                        <input type="number" name="quantity" class="product-detail__quantity-input frm-input" 
                                        value="1" min="1" max="'.(int)$SoLuongHang.'">
                                        
                                        <label for="" class="clss_display_none"> MSHH: 
                                            <input  type="text" name="id_mshh_product_clicked" value="'.$MSHH.'" readonly>
                                        </label>

                                        <!-- <button class="product-detail__quantity-than">+</button> -->
                                        <span class="product-detail__quantity-have">
                                            '.(int)$SoLuongHang.' sản phẩm sẵn có
                                        </span>
                                    </div>

                                    <div class="product-detail__item--item product-detail__buy">
                        
                                        <button type="submit" name="add_product_to_cart" class="product-detail__buy-cart btn" onclick="return check_login('.$check_login.');">Thêm vào giỏ hàng</button>
                                        <!-- <button class="product-detail__buy-buy btn" onclick="return false;">Mua ngay</button> -->
                                    </div>

                                </div>
                            </div>

                        </form>

                        <div class="product_mo_ta">

                            <h1>THÔNG TIN SẢN PHẨM</h1>
                            <br>
                            <hr> <br><br> 

                            <div style="word-wrap: break-word;">
                                <pre class="product_mo_ta_pre">'.$quy_cach.'</pre>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    ';

}


// Footer
function imp_footer() {

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

// Hien thi san pham
function show_product() {

    $limit_get_total_product = 50;
    $path_localhost = '../../';

    $index_to_show_data_page = 1;
    $index_page_to_get_data = 0;

    // So san pham hien thi tren 1 trang.
    $limit_get_data_per_page = 10;

    $get_data_base_on_type = 0;


    if(!empty($_GET)) {
        if(isset($_GET['page'])) {
            $index_to_show_data_page = (int) $_GET['page'];
            $index_page_to_get_data = (int) (($index_to_show_data_page - 1) * $limit_get_data_per_page);
        }

        if(isset($_GET['sort_product']) && !empty($_GET['sort_product'])) {
            $sap_xep_temp = trim($_GET['sort_product']);

            switch ($sap_xep_temp) {
                case 'DESC':
                    $_SESSION['sort_product'] = "DESC";
                    break;

                default:
                    $_SESSION['sort_product'] = "ASC";
                    break;
            }
        }
    }

    if(isset($_SESSION['data_type'])) {
        $get_data_base_on_type = (int) $_SESSION['data_type'];
    }



    $sap_xep = "ASC";

    if( isset($_SESSION['sort_product']) && !empty($_SESSION['sort_product']) ) {
        $sap_xep = $_SESSION['sort_product'];
    }

    
    get_data($index_page_to_get_data, $limit_get_data_per_page, $sap_xep, $get_data_base_on_type);


    if(!empty($_SESSION)) {
        if(isset($_SESSION['total_all_product'])) {

            $number_product_of_page = (int) $_SESSION['total_all_product'];
            $_SESSION['total_page'] = ceil($number_product_of_page / $limit_get_data_per_page);
        }
    }

    if(!empty($_SESSION)) {
        if(isset($_SESSION['data'])) {

            $data = $_SESSION['data'];
            $total_product = count($data);

            for($i = 0; $i < $total_product; $i++) {
                // echo count($_SESSION['data']);

                $random_star = rand(1, 5);
                $mshh_temp = (int) $data[$i]["MSHH"];

                $sql_total_bought = "SELECT sum(ct.SoLuong) as total_soLuong from chitietdathang as ct JOIN dathang as dh on ct.SoDonDH = dh.SoDonDH where dh.TrangThaiDH != -1 and ct.MSHH =".$mshh_temp." ;";
                $total_soLuong_da_ban = sql_query($sql_total_bought);

                if(!empty($total_soLuong_da_ban)) {
                    $total_soLuong_da_ban = (int) $total_soLuong_da_ban[0]["total_soLuong"];
                }
                

                echo '
                    <!-- San pham col-1 -->
                    <div class="grid__col-2-x5">
                        <a class="home-product__item" href="?action_page=detail_product&id_product='.$data[$i]["MSHH"].'"> 
                            <!-- product-item -->
                            <div class="home-product__header">
                                <!-- <div class="product-img" style="background-image: url("'.$path_localhost.'assets/img/product-shopee.jpg");"></div> -->
                    
                                <img src="'.$path_localhost.''.$data[$i]["TenHinh"].'" alt="product-shopee" class="product-img">
                                <!-- <img src="'.$path_localhost.'assets/img/product/demo.jpg" alt="product-shopee" class="product-img"> -->
                                <!-- <img src="'.$path_localhost.'assets/img/product/iphone-12.png" alt="product-shopee" class="product-img"> -->
                                <img src="'.$path_localhost.'assets/img/product/khuyen-mai.png" alt="product-shopee" class="product-img" style="position: absolute;inset: 0; height: calc(100% - 4px);">
                            </div>
                    
                            <div class="home-product__body">
                                <div class="home-product__body-item product-info">
                                    <p class="product-info__name"> '.$data[$i]["TenHH"].' </p>
                                </div>
            
                                <div class="home-product__body-item product-ticket">
                                    <div class="product-ticket__item" style="color: rgb(255, 0, 32);">#ShopXuHuong</div>
                                    <div class="product-ticket__item" style="color: rgb(255, 0, 32);">Mua Kèm Deal Sốc</div>
                                    <!-- <div class="product-ticket__item" style="color: rgb(255, 0, 32);">Mua Kèm Deal Sốc</div> -->
                                </div>
            
                                <div class="home-product__body-item product-price">
                                    <!-- <span class="product-price-item product-price__old">&#8363;24.800</span> -->
                                    <span class="product-price-item product-price__new">&#8363;'.number_format($data[$i]["Gia"],0,",",".").'</span>
                                </div>
            
                                <div class="home-product__body-item product-action">
                                    <div class=" product-action__like">
                                        <i class="product-action__icon far fa-heart"></i>
                                        <!-- <i class="product-action__icon-liked fas fa-heart"></i> -->
                                    </div>
            
                                    <div class="product-action__rating">

                ';

                            for($y = 1; $y <= 5; $y++) {
                                if($y <= $random_star) {
                                    echo '
                                        <i class="product-action__rating-icon gold fas fa-star"></i>
                                    ';
                                } else {
                                    echo '
                                        <i class="product-action__rating-icon fas fa-star"></i>
                                    ';
                                }
                            }


                echo '
                                    </div>

                                    <div class="product-action__sold">
                                        Đã bán '.$total_soLuong_da_ban.'
                                    </div>
                                </div>
            
                                <div class="home-product__body-item product-place">
                                    <span class="product-place__item product-place__company">Yame</span>
                                    <span class="product-place__item product-place__contry">Hà Nội</span>
                                </div>
            
                                <div class="home-product__body-item product-favor">
                                    <i class="product-favor__item product-favor__icon fas fa-check"></i>
                                    <span class="product-favor__item product-favor__text">Yêu thích</span>
                                </div>
            
                                <div class="home-product__body-item product-discount">
                                    <span class="product-discount__item product-discount__present">36%</span>
                                    <span class="product-discount__item product-discount__label">GIẢM</span>
                                </div>
                            </div>
            
                        </a>
                    </div>
                    <!-- End: San pham col-1 -->
                ';
            }
        }
    }
}

// Phan trang
function phan_trang() {

    $total_page = 1;
    $index_to_show_data_page = 1;

    if(!empty($_GET)) {
        if(isset($_GET['page'])) {
            $index_to_show_data_page = (int) $_GET['page'];
        }
    }

    if(!empty($_SESSION['total_page'])) {
        if(isset($_SESSION['total_page'])) {
           $total_page = (int)$_SESSION['total_page'];
        }
    }

    for($i = 1; $i <= $total_page; $i++) {
        if ($i == $index_to_show_data_page) {
            echo ' <a href="?page='.$i.'"><button class="page-change__btn btn--active">'.$i.'</button></a> ';
        } else {
            echo ' <a href="?page='.$i.'"><button class="page-change__btn">'.$i.'</button></a> ';
        }
    }

}

// Layout Danh muc Category
function imp_category() {

    // $choose_loaiHangHoa = 'all';
    $datas_loaiHangHoa = [];
    $data_type = 0;

    if(!isset($_SESSION['loai_hang_hoa']) || count($_SESSION['loai_hang_hoa']) < 1) {
        
        $sql_loaihanghoa = "SELECT * from loaihanghoa;";
        $datas_loaiHangHoa_temp = sql_query($sql_loaihanghoa);

        if(!empty($datas_loaiHangHoa_temp)) {
            $_SESSION['loai_hang_hoa'] = $datas_loaiHangHoa_temp;
            $datas_loaiHangHoa = $datas_loaiHangHoa_temp;
        }

    } else {

        $datas_loaiHangHoa = $_SESSION["loai_hang_hoa"];
    }

    if(isset($_SESSION['data_type'])) {
        $data_type = (int) $_SESSION['data_type'];
    }


    echo '

        <!-- set layout Danh Muc -->
        <div class="grid__col-2">
            <!-- Danh muc -->
            <nav class="category">
                <h3 class="category__heading">
                    <i class="category__heading-icon fas fa-list"></i>
                    Danh Mục
                </h3>

                <ul class="category-list">
                    <li class="category-item" id="data_type_0" >
                        <a href="?name=all&data_type=0" class="category-item__link">Tất cả</a>
                    </li>
    ';

    foreach ($datas_loaiHangHoa as $data) {
        if(!empty($data)) {

                echo '
                    <li class="category-item" id="data_type_'.(int)$data["MaLoaiHang"].'">
                        <a href="?name='.trim($data['TenLoaiHang']).'&data_type='.(int)$data["MaLoaiHang"].'" class="category-item__link">'.$data['TenLoaiHang'].'</a>
                    </li>
                ';
        }
    }            

    echo '
                </ul>
            </nav>
            <!-- End: Danh muc -->
        </div>
        <!-- End: set layout Danh Muc -->

    ';

    echo '

        <script>
            var index_data_type = parseInt( '.$data_type.' );

            var id_data_type_active = $("#data_type_" + index_data_type)[0];

            // console.log(id_data_type_active);

            id_data_type_active.classList.add("category-item--active");
        </script>
    
    ';

}


// Form modal (login and register)
function imp_modal() {

    echo '

        <!---------- Modal layout --------------------------------------------------------------------->
        <div class="modal">
            <!-- <div class="overlay"></div> -->

            <div class="body">
                <!-- Login and Register form-->
                <div class="auth-form auth-form__login animation-zoom">

                    <div class="auth-form__close" onclick="closeModal()">
                        <i class="auth-form__close-icon fas fa-times"></i>
                    </div>


                    <!-- login -->
                    <form action="" method="post" name="login_form">
                        <div class="auth-form__container auth-form__container--login">

                            <div class="auth-form__header">
                                <h3 class="auth-form__heading">Đăng nhập </h3>
                                <span class="auth-form__switch-btn btn-login">Đăng ký</span>
                            </div>

                            <div class="auth-form__form">

                                <div class="auth-form__group">
                                    <input type="text" name="username" class="auth-form__input" placeholder="User name" autofocus="autofocus" required>
                                </div>

                                <div class="auth-form__group">
                                    <input type="password" name="password" class="auth-form__input" placeholder="Password" required>
                                </div>

                                <div class="auth-form__role auth-form__group" style="display: flex; justify-content: center;">
                                    <input type="checkbox" id="check_login_admin" value="abc" style="margin: 0 12px;" onclick="fct_check_login_admin();">
                                    <label for="check_login_admin">Đăng nhâp với tư cách nhân viên</label>
                                </div>

                            </div>

                            <!-- <div class="auth-form__help">
                                <a href="#" class="auth-form__link auth-form__forgot-link">Quên mật khẩu</a>
                                <a href="#" class="auth-form__link auth-form__help-link">Trợ giúp ?</a>
                            </div> -->

                            <div class="auth-form__control">
                                <button class="btn btn--auth-form__control-back" onclick="return false;">TRỞ LẠI</button>
                                <button type="submit" id="btn_submit_login" name="btn_login_clicked" class="btn btn--primary auth-form__control-submit">ĐĂNG NHẬP</button>
                            </div>

                        </div>
                    </form>
                    <!-- end: login -->


                    <!-- register -->
                    <form name="register_form" action="process_register.php" method="post" onsubmit="return check_valid_info_register()">

                        <div class="auth-form__container auth-form__container--register">

                            <div class="auth-form__header">
                                <h3 class="auth-form__heading">Đăng ký</h3>
                                <span class="auth-form__switch-btn btn-register">Đăng nhập</span>
                            </div>

                            <div class="auth-form__form">

                                <div class="auth-form__group">
                                    <input type="text" id="username_register" name="username" class="auth-form__input" placeholder="User name" autofocus required>
                                </div>

                                <div class="auth-form__group">
                                    <input type="password" id="password_register" name="password" class="auth-form__input" placeholder="Password" required>
                                </div>

                                <div class="auth-form__group">
                                    <input type="password" id="repeatPwd_register" name="repeatPwd" class="auth-form__input" placeholder="Repeat password" required>
                                </div>

                                <div class="auth-form__role auth-form__group" style="display: flex; justify-content: center;">
                                    <input type="checkbox" id="check_register_admin" value="abc" style="margin: 0 12px;"
                                        onclick="fct_check_register_admin();">
                                    <label for="check_register_admin">Đăng ký tài khoản nhân viên</label>
                                </div>

                            </div>

                            <div class="auth-form__outside">
                                <p class="auth-form__policy-text">
                                    Bằng việc đăng ký, bạn đồng ý với Shopee về
                                    <a href="" class="auth-form__text-link">Điều khoản dịch vụ</a>
                                    &
                                    <a href="" class="auth-form__text-link">Chính sách bảo mật</a>
                                </p>
                            </div>

                            <div class="auth-form__control">
                                <button class="btn btn--auth-form__control-back" onclick="return false;">TRỞ LẠI</button>
                                <button type="submit" id="btn_submit_register" name="submit_register_form" class="btn btn--primary auth-form__control-submit">ĐĂNG KÝ</button>
                            </div>
                        </div>

                    </form>
                    <!-- end: register -->


                    <div class="auth-form__social">
                        <a href="#!" class="btn btn--with-icon btn--with-icon_facebook">
                            <i class="auth-form__social-icon fab fa-facebook"></i>
                            <span class="auth-form__social-text">Kết nối với Facebook</span>
                        </a>
                        <a href="#!" class="btn btn--with-icon btn--with-icon_google">
                            <i class="auth-form__social-icon fab fa-google"></i>
                            <span class="auth-form__social-text">Kết nối với Google</span>
                        </a>
                    </div>

                </div>
                <!-- End: Login and Register form -->

            </div>
            
        </div>
        <!----------End: Modal layout ----------------------------------------------------------------->

    
    ';

}


// Sap xep giam dan
function sort_z_to_a($arr) {
    usort($arr, function($a, $b) {
        // return $a['Gia'] <=> $b['Gia'];
        return  $b['Gia'] <=> $a['Gia'] ;
    });

    return $arr;
}


// Sap xep tang dan
function sort_a_to_z($arr) {
    usort($arr, function($a, $b) {
        return $a['Gia'] <=> $b['Gia'];
        // return  $b['Gia'] <=> $a['Gia'] ;
    });

    return $arr;
}


// Fomat Money
function format_money($money) {

    return number_format($money, 0, ",", ".");

}


// print array
function print_arr($arr) {

    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}