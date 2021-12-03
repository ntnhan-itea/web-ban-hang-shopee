  
  
<!-- Start: Main -->
<!-- <div id="main">
    <?php
        // require_once('header_logined.php');

        // require_once('content.php');

        // require_once('footer.php');
        require_once("process_user.php");

    ?>
</div> -->
<!-- End: Main -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
<body>

    <?php import_header_logined(); 
    
    
    // imp_purchase();
    ?>    
    
    <div id="container_ad">
        <div class="grid">
            <div class="grid__row">
                <div class="grid__col-10">
                    <div class="container-info">
                        <!-- Profile -->
                        <div class="container-account">
                            <div class="container-account__header">Hồ sơ của tôi</div>

                            <div class="container-profile">
                                <form action="" name="frmProfile">
                                    <label class="frm-label" for="frmName">Họ và Tên</label> <br>
                                    <input class="frm-input frm-input--focus" type="text" name="frmName" id="frmName">
                                    <br><br>

                                    <label class="frm-label" for="frmCty">Tên công ty</label> <br>
                                    <input class="frm-input frm-input--focus" type="text" name="frmCty" id="frmCty">
                                    <br><br>

                                    <label class="frm-label" for="frmSdt">Số điện thoại</label> <br>
                                    <input class="frm-input frm-input--focus" type="text" name="frmSdt" id="frmSdt">
                                    <br><br>

                                    <label class="frm-label" for="frmFax">Số Fax</label> <br>
                                    <input class="frm-input frm-input--focus" type="text" name="frmFax" id="frmFax">
                                    <br><br>

                                    <input type="submit" value="Lưu" class="btn btn--primary">
                                </form>

                                <div class="container-profile__img">
                                    <div class="container-profile__img-item">
                                        <img src="../../assets/img/img-default/default-user.jpg" alt="User Image" class="container-profile__img--img">
                                    </div>
                                    <input type="file" class="container-profile__img--input" accept=".jpg,.jpeg,.png">
                                </div>
                            </div>        
                        </div>
                        <!-- End: Profile -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php imp_footer(); ?>

    <!-- Javascript -->
    <script src="../../assets/js/last-update.js"></script>
    <script src="../../assets/js/main.js"></script>

</body>
</html>

