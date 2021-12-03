<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once("../database/init_product.php");


//  Them hang hoa
if(isset($_POST['submit_add_product'])) {

    $img_name = upload_img();
    $check_success = false;

    if(!empty($img_name) && $img_name != null) {
        
        $check_success = add_hang_hoa($img_name);
    }


    if($check_success) {
        echo '
            <script>
                alert("Thêm sản phẩm thành công.");
            </script>
        ';
    } 
    else {
        echo '
            <script>
                alert("Thêm sản phẩm thất bại !!");
            </script>
        ';
    }


    echo '
        <script>
            location.href = "index.php?action_page=quan_ly_san_pham&action_product=all&id=" + Math.random();    
        </script>
    ';


}


// Chinh sua hang hoa
if(isset($_POST['submit_edit_product'])) {

    $mshh = -1;
    if(isset($_POST['mshh_to_edit'])) {

        $mshh = (int) $_POST['mshh_to_edit'];
    }

    $img_name = upload_img();

    $check_success = false;
    $check_success = edit_hang_hoa($mshh, $img_name);


    if($check_success) {
        echo '
            <script>
                alert("Sửa sản phẩm thành công.");
            </script>
        ';
    } 
    else {
        echo '
            <script>
                alert("Sửa sản phẩm thất bại !!");
            </script>
        ';
    }


    echo '
        <script>
            location.href = "index.php?action_page=quan_ly_san_pham&action_product=all&id=" + Math.random();    
        </script>
    ';


}


// Upload hinh anh cua hang hoa
function upload_img() {

    $target_dir = "../../assets/img/product/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $img_name = '';
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit_add_product"])) {
        
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    
        if($check !== false) {
    
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
    
            // echo "File is not an image.";
            echo_error("File is not an image.");
            $uploadOk = 0;
        }
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
    
        // echo "Sorry, file already exists";
        echo_error("Sorry, file already exists.");
        $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
    
        // echo "Sorry, your file is too large.";
        echo_error("Sorry, your file is too large.");
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    
        // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        echo_error("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    
        // echo "Sorry, your file was not uploaded.";
        echo_error("Sorry, your file was not uploaded.");
        // if everything is ok, try to upload file
    } else {
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    
            $file_name = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));

            $img_name = trim($file_name);

            echo_success("The file: \"".$file_name. "\" has been UPLOADED.");
    
    
        } else {
    
            echo "Sorry, there was an error uploading your file.";
            echo_error("Sorry, there was an error uploading your file.");
        }
    }

    return $img_name;

}


function add_hang_hoa($img_name) {

    $loai_san_pham = 4;
    $ten_san_pham = $mo_ta_san_pham = '';
    $gia_ban = $so_luong_ton_kho = -1;
    $path_img_sql = "assets/img/product/";

    $check_success = false;

    if(isset($_POST['prd_type']) && !empty($_POST['prd_type'])) {
        $loai_san_pham = (int) $_POST['prd_type'];
    }

    if(isset($_POST['prd_name']) && !empty($_POST['prd_name'])) {
        $ten_san_pham = trim( $_POST['prd_name'] );
    }

    if(isset($_POST['prd_detail']) && !empty($_POST['prd_detail'])) {
        $mo_ta_san_pham = trim( $_POST['prd_detail'] );
    }

    if(isset($_POST['prd_price']) && !empty($_POST['prd_price'])) {
        $gia_ban = (float) $_POST['prd_price'];
    }

    if(isset($_POST['prd_count']) && !empty($_POST['prd_count'])) {
        $so_luong_ton_kho = (int) $_POST['prd_count'];
    }

    $ten_san_pham = check_cu_phap_valid($ten_san_pham);
    $mo_ta_san_pham = check_cu_phap_valid($mo_ta_san_pham);

    $sql_insert_hang_hoa = "INSERT INTO hanghoa(TenHH, QuyCach, Gia, SoLuongHang, MaLoaiHang) 
                            VALUES ('$ten_san_pham', '$mo_ta_san_pham', $gia_ban, $so_luong_ton_kho, $loai_san_pham) ;";

    if(sql_execute($sql_insert_hang_hoa)) {

        $sql_get_last_mshh = "SELECT MSHH FROM hanghoa ORDER BY MSHH DESC LIMIT 1;";

        $last_mshh = sql_query($sql_get_last_mshh);
        $last_mshh = (int) $last_mshh[0]["MSHH"];

        $ten_hinh_anh = trim($path_img_sql . $img_name);

        if($last_mshh > 0) {
            $sql_insert_hinh_hang_hoa = "INSERT INTO hinhhanghoa(TenHinh, MSHH)  VALUES ('$ten_hinh_anh', $last_mshh) ;";
            if(sql_execute($sql_insert_hinh_hang_hoa)) {

                $check_success = true;
            }
        }

    } 
    else {

        $path_file = "../../assets/img/product/" . $img_name;

        if (file_exists($path_file)) {

            unlink($path_file);
            echo "File Successfully Delete."; 
        }
        else {
        
            echo "File does not exists"; 
        }
    }

    return $check_success;

}


function edit_hang_hoa($mshh, $img_name='') {

    $loai_san_pham = 4;
    $ten_san_pham = $mo_ta_san_pham = '';
    $gia_ban = $so_luong_ton_kho = -1;
    $path_img_sql = "assets/img/product/";

    $mshh = (int) $mshh;
    if($mshh  < 1) {

        return false;
    }

    $check_success = false;

    if(isset($_POST['prd_type']) && !empty($_POST['prd_type'])) {
        $loai_san_pham = (int) $_POST['prd_type'];
    }

    if(isset($_POST['prd_name']) && !empty($_POST['prd_name'])) {
        $ten_san_pham = trim( $_POST['prd_name'] );
    }

    if(isset($_POST['prd_detail']) && !empty($_POST['prd_detail'])) {
        $mo_ta_san_pham = trim( $_POST['prd_detail'] );
    }

    if(isset($_POST['prd_price']) && !empty($_POST['prd_price'])) {
        $gia_ban = (float) $_POST['prd_price'];
    }

    if(isset($_POST['prd_count']) && !empty($_POST['prd_count'])) {
        $so_luong_ton_kho = (int) $_POST['prd_count'];
    }


    $sql_update_hang_hoa = "UPDATE hanghoa SET TenHH='$ten_san_pham', QuyCach='$mo_ta_san_pham', Gia=$gia_ban, SoLuongHang=$so_luong_ton_kho,               
                            MaLoaiHang=$loai_san_pham where MSHH=$mshh;  ";
    
    if(sql_execute($sql_update_hang_hoa)) {

        if($img_name != "" && strlen($img_name) > 3) {

            $ten_hinh = trim($path_img_sql.$img_name);
            $sql_update_hinh_hang_hoa = "UPDATE hinhhanghoa SET TenHinh='$ten_hinh' where MSHH=$mshh ;";
            sql_execute($sql_update_hinh_hang_hoa);
        } 
        else {

            echo '
                <script>
                    alert("Hình ảnh KHÔNG cập nhật !!");
                </script>
            ';
        }

        $check_success = true;
    }

    return $check_success;
}


function echo_error($str) {

    echo "
        <p>
        <b style='color: #DC3545'>$str</b>
        <span><a href='index.php'>Trang chu</a></span>
        </p>
    ";
}

function echo_success($str) {

    echo "
        <p>
        <b style='color: #28A745'>$str</b>
        <span><a href='index.php'>Trang chu</a></span>
        </p>
    ";
}


function check_cu_phap_valid($data) {

    $data = str_replace("'", "\"", $data);

    return trim($data);
}





