<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once("../database/init_product.php");


// Xu ly dang ky tai khoan
if(isset($_POST['submit_register_form']) || isset($_POST['submit_register_form_admin'])) {

    register_account();
    // header('Location: index.php');
    echo '
        <script>
            location.href = "index.php";
        </script>
    ';

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

        if(!empty($username) && !empty($password) && !empty($repeatPwd)) {

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

                    // password with endcode MD5
                    // $sql_create_account = "INSERT INTO account_user(`username`, `password`, `MSKH`) values ('$username', MD5('$password'), $MSKH);";

                    if(sql_execute($sql_create_account)) {

                        echo '
                            <script>
                                alert("Tạo tài khoản thành công. (Successfully)");
                            </script>
                        ';

                    } else {

                        $sql_delete_mskh_recent_created = "DELETE FROM khachhang where MSKH=$MSKH;";
                        sql_execute($sql_delete_mskh_recent_created);

                        echo '
                            <script>
                                alert("Tạo tài khoản thất bại. (Fail)");
                            </script>
                        ';
                    }

                }
            }

        }


    } 
    
    else {

        if(isset($_POST['submit_register_form_admin'])) {

            if(isset($_POST['username'])) {
                $username = trim($_POST['username']);
            }
            if(isset($_POST['password'])) {
                $password = trim($_POST['password']);
            }
            if(isset($_POST['repeatPwd'])) {
                $repeatPwd = trim($_POST['repeatPwd']);
            }
    
            if(!empty($username) && !empty($password) && !empty($repeatPwd)) {
    
                $sql_create_nhan_vien = "INSERT INTO nhanvien values();";
    
                if(sql_execute($sql_create_nhan_vien)) {
    
                    $sql_get_end_nhan_vien = "SELECT MSNV FROM nhanvien ORDER BY MSNV DESC LIMIT 1;" ;
                    $MSNV = sql_query($sql_get_end_nhan_vien);
                    $MSNV = (int) $MSNV[0]['MSNV'];
        
                    if( $MSNV < 1) {
                        die();
                    } 
                    else {
                        
                        $sql_create_account = "INSERT INTO account_admin(`username`, `password`, `MSNV`) values ('$username', '$password', $MSNV);";
    
                        if(sql_execute($sql_create_account)) {
    
                            echo '
                                <script>
                                    alert("Tạo tài khoản nhân viên thành công. (Successfully)");
                                </script>
                            ';
    
                        } else {
    
                            $sql_delete_mskh_recent_created = "DELETE FROM nhanvien where MSNV=$MSNV;";
                            sql_execute($sql_delete_mskh_recent_created);
    
                            echo '
                                <script>
                                    alert("Tạo tài khoản nhân viên thất bại. (Fail)");
                                </script>
                            ';
                        }
    
                    }
                }
    
            }
    
        }

    }
}
