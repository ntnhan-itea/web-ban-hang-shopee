
<?php
    session_start();
    // $path = getcwd();
    // echo "This Is Your Absolute Path: ";
    // echo $path;

    // echo $_SERVER['HTTP_HOST'].'<br>'; // prints '/home/public_html/'
    // echo $_SERVER['REQUEST_URI'].'<br>'; // prints '/home/public_html/'
    // echo basename(__FILE__).'<br>'; // prints '/home/public_html/'
    // echo dirname(__DIR__).'<br>'; // prints '/home/public_html/'
    // echo dirname(__FILE__).'<br>'; // prints '/home/public_html/images'

    // echo $_SERVER['HTTP_REFERER'];

    // $_SERVER['DOCUMENT_ROOT'];
    // print_r($_SERVER['DOCUMENT_ROOT']);
    // echo $_SERVER['DOCUMENT_ROOT'];

    // define('ROOTPATH', __DIR__);
    // echo ROOTPATH;
    // $a= __DIR__;
    // echo $a;

    // $path_local = __DIR__;
    // $path_server = $_SERVER['DOCUMENT_ROOT'];
    // $result = str_replace($path_server,'locaasdaslhost', $path_local);

    // echo $path_local.'<br>';
    // echo $path_server.'<br>';
    // echo $result.'<br>';
    // define('DS', 'DIRECTORY_SEPARATOR');
    // echo DS;

    // $newarraynama = getAddress().'//////';
    // $newarraynama = rtrim($newarraynama, "/");
    // $newarraynama = rtrim($newarraynama, "\\");
    // echo $newarraynama;

    // function getAddress() {
    //     $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
    //     $filenamepattern = '/'.basename(__FILE__).'/';
    //     return $protocol.'://'.$_SERVER['HTTP_HOST'].preg_replace($filenamepattern,"",$_SERVER['REQUEST_URI']);
    // } 
    
    // $_SESSION['test'] = [];
    // $_SESSION['test'][] = "a";
    // $_SESSION['test'][]= "b";
    // $_SESSION['test'][] = "c";
    // $_SESSION['test'][] = "d";
    // $_SESSION['test'][] = "e";
    // $_SESSION['test'] = [];
    // if(isset($_SESSION['test']) && !empty($_SESSION['test'])) {

    //     echo count($_SESSION['test']);
    // }

    // var_dump( $_SESSION['test']);    
    // echo "sad";

    // if (array_key_exists('17' , $_SESSION['data']))
    // {
    //     echo "Key exists!";
    // }
    // else
    // {
    //     echo "Key does not exist!";
    // }


    

    // if(isset($_GET['name'])){
    //     echo $_GET['name'];
    //     echo "da do";
    // }   
            
    // if(isset($_POST['name'])){
    //     echo $_POST['name'];
    //     echo "da do";
    // }  

    // print_r($_SESSION);
    


    // $sampleArray = $_SESSION['data'];
    // echo "<pre>";
    // print_r($sampleArray);
    // echo "</pre>";

    // echo '<br>-----------------------------------------';
    // usort($sampleArray, function($a, $b) {
    //     // return $a['Gia'] <=> $b['Gia'];
    //     return  $b['Gia'] <=> $a['Gia'] ;
    // });
    // echo "<pre>";
    // print_r($sampleArray);
    // echo "</pre>";

    // $sampleArray = array(
    //     0 => "Geeks", 
    //     1 => "for", 
    //     2 => "Geeks", 
    // );


    // $a[0] = 1;

    // $a[5] = 2;

    // $i = 0;
    // foreach($a as $t) {
    //     $i++;
    //     // echo $t;
    //     echo $i.'<br>';
    // }


        
    // if(isset($_POST)) {

    //     echo "da do";
    //     $post_data =  array();
    //     $post_data = json_decode($_POST['email'],true);
    //     echo $post_data;
    //     echo '<pre>';
    //     print_r($post_data);
    //     echo '</pre>';
    // }

    // $array = json_decode($_POST['array']);
    // print_r($array); //for debugging purposes only

    //  $response = array();
    //  if(isset($array['array'])) 
    //     $response['reply']="Success";
    // else 
    //     $response['reply']="Failure";

    // echo json_encode($response);

    // if(isset($_SESSION['test'])) {
    //     echo json_encode($_SESSION['test']);
    // } else {
    //     echo 1;
    // }

    // $a = [];
    // $a[2] =1;

    // $a[5]=2;
    // print_r($a);
    // $a = array_values($a);
    // print_r($a);

//     $sql = 'sd\'\'\'\'\'';

//     echo check_valid_sql($sql);

    
// function check_valid_sql($sql) {

//     $sql = str_replace("\"","\\\"",$sql);
//     $sql = str_replace("'","\\'",$sql);

//     return $sql;

// }
    // $values = '';
    // $SoDonDH = 1;


    // foreach($_SESSION['cart_datas'] as $dt) {

    //     $values .= "(".$SoDonDH .",". (int)$dt["MSHH"] .", ". (int)$dt["quantity"] .", ".(int)$dt["Gia"].", ".(float)$dt["discount"] ."),";    

    // }
    // $values = rtrim($values, ",");
    // echo $values;


    // if (str_contains('How are you', 'are')) { 
    //     echo 'true';
    // }



   
    require_once ("./pages/database/init_product.php");


    // $sql_total_DonHang = "
    // SELECT SoDonDH from dathang WHERE MSKH = 1;
    // ";

    // $data_DonHang = sql_query($sql_total_DonHang);

    // foreach ($data_DonHang as $soDH) {
    //         // echo "SoDonDH : ".$soDH;
    //         print_r($soDH['SoDonDH']);
        
    //         $sql_data_purchase = "
    //                     SELECT * FROM 
    //                     nhanvien as nv join dathang as dh on nv.MSNV = dh.MSNV
    //                     JOIN khachhang as kh on kh.MSKH = dh.MSKH
    //                     JOIN chitietdathang as ctdh on ctdh.SoDonDH = dh.SoDonDH 
    //                     JOIN hanghoa as hh on hh.MSHH = ctdh.MSHH
    //                     JOIN hinhhanghoa as hhh on hhh.MSHH = hh.MSHH 
    //                     JOIN loaihanghoa as lhh on lhh.MaLoaiHang = hh.MaLoaiHang
    //                     where dh.MSKH = 1 and dh.SoDonDH = ".$soDH."
    //                     ORDER BY dh.SoDonDH ;
    //                 ";
        
    //                 $data_details = sql_query($sql_data_purchase);
        
    //                 foreach ($data_details as $data) {
    //                     echo "<pre>";
    //                     print_r($data['TenHinh']);
    //                     echo "</pre>";
    //                 }

    // }

        // $string = "\"'\\\\\\\\";
        // $string = preg_replace("/[^A-Za-z0-9\-\']/", '', $string); 

        // echo $string;


    // $sql_get_total_mshh_purchased = "SELECT MSHH from chitietdathang where SoDonDH=49;" ;
    // $total_mshh_purchased = sql_query($sql_get_total_mshh_purchased);

    // if(!empty($total_mshh_purchased)) {

    //     foreach($total_mshh_purchased as $mshh_purchased) {

    //         // echo $mshh_purchased["MSHH"]."<br>";
    //         echo "<pre>";
    //         print_r($mshh_purchased);
    //         echo "</pre>";

    //     }

    // }

    
    // $get_date = "SELECT NgayDH from DatHang where SoDonDH=49;" ;
    // $date_sql = sql_query($get_date);

    // // echo "<pre>";
    // // print_r($date_sql);
    // // echo "</pre>";

    // echo $date_sql[0]["NgayDH"];
    // // var_dump($date_sql);


    // $fm = mktime(0,0,0,11,12,2021);
    // $date1 = date("Y-m-d", $fm);
    // $date2 = date("Y-m-d H:i:s");

    // $date_test = strtotime("2021-11-01 10:00:00");

    // echo $date_sql[0]["NgayDH"] < $date1 ? "true": "false";

    // var_dump(date("Y-m-d H:i:s" ,$date_test));

    // // echo $date1;


//         echo var_dump("
//         Hẻm 278, Tầm Vu. (Dô hẻm278 gặp ngã4 rẽ phải, đi thẳg 50m. Gần cây bàng)
// Phường Hưng Lợi
// Quận Ninh Kiều
// Cần Thơ
        
//         ");


//     echo  md5(123);

//     echo var_dump('
      
    
//     Áo thun nam nữ unisex tay lỡ AD67 PHG PT5, áo phông tay lỡ unisex form rộng oversize streetwear
// THÔNG TIN SẢN PHẨM: 
// - Tên sản phẩm: Áo thun tay lỡ form rộng UNISEX
// - Xuất sứ: Việt Nam 
// - Chất liệu: cotton DÀY MỀM MỊN MÁT không xù lông. Form áo rộng chuẩn TAY LỠ UNISEX cực đẹp.
// - Size áo: FREESIZE form rộng
// - Chiều dài áo: 72cm
// - Chiều rộng áo: 55cm
// - Chiều dài tay áo: 20cm
// - Từ 50-65KG (mặc rộng thoải mái) 
// - Từ 66-75KG (mặc rộng vừa).
    
//     ');


  // $filePath = "assets/img/product/Coding.jpg";

  // if (file_exists($filePath)) 
  // {
  //   unlink($filePath);
  //   echo "File Successfully Delete."; 
  // }
  // else
  // {
  //   echo "File does not exists"; 
  // }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
        <button id="lengthQuestion" onclick="test();"> button</button>

        <div id="test"></div>
        <input type="file" accept="image/*" onchange="loadFile(event)">
<img id="output"/>
<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>

</body>
</html>

