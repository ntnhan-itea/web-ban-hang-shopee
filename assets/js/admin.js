
const frm_price = document.getElementById("prd_price");
const price_format = document.getElementById("price_format");


// Format Number
const numberFormat = new Intl.NumberFormat('it-IT', {
    style: 'currency',
    currency: 'VND',
});

if(frm_price != null) {

    frm_price.addEventListener("input", function() {
        price_format.innerHTML = numberFormat.format(frm_price.value);
    });
}


// Xac nhan don hang ADMIN 
function comfirm_purchased($soDonDH, $maSoNV, $id_ngay_giao_hang, $stt_don) {

    let stt_Don_Hang = parseInt($stt_don);
    let _soDonDH = parseInt($soDonDH);
    let maNV = parseInt($maSoNV);
    let ngay_giao = document.getElementById($id_ngay_giao_hang).value.trim();

    console.log(ngay_giao);

    if(ngay_giao == '') {
        alert('Chưa chọn ngày giao hàng !!');
        return false;
    }

    if(confirm("Xác nhận đơn hàng? " + "( Đơn hàng: " + stt_Don_Hang + " - ID: "+ _soDonDH +" )")) {
        $.post("../../pages/admin/process_purchase.php", 
        {
            action_page: "comfirm_purchase",
            soDonDH: _soDonDH,
            maSoNV: maNV,
            ngay_giao_hang: ngay_giao
        },
        function(data) {
            console.log(data);
            if (data.includes('comfirm_successed')) {
            
                alert("Xác nhận đơn hành thành công.");
                location.href = "index.php?action_page=quan_ly_don_hang&action_view=wait_comfirm&id="+Math.random();
            } else {
    
                alert("Xác nhận đơn hàng thất bại ");
                return false;
            }
        });
    }

}


// Sua san pham 
function edit_product_admin($mshh) {

    let mshh = parseInt($mshh) > 0 ? parseInt($mshh) : -1;

    if(confirm("Chỉnh sửa hàng hóa ? (ID: "+mshh+")")) {
        

    }

    return false;

}

// Xoa san pham khoi CSDL
function delete_product_admin($mshh) {

    let _mshh = parseInt($mshh) > 0 ? parseInt($mshh) : -1;

    if(confirm("Xóa hàng hóa khỏi CSDL ? (ID: "+_mshh+") \n\rDỮ LIỆU SẼ BIẾN MẤT VĨNH VIỄN !!")) {

        if(confirm("XÓA HÀNG HÓA CÓ THỂ XẢY RA LỖI TRONG HỆ THỐNG !! \n\rVẪN TIẾP TỤC XÓA ??")) {

            $.post('../../pages/admin/process_purchase.php', 
    
                {   
                    action_page: "delete_product_CSDL",
                    MSHH: _mshh
                }, 
    
                function(data, status)
                {
                    // console.log(status);
                    if (data.includes('Delete_successful')) {
                        
                        alert( "Xóa sản phẩm thành công. ("+status+")" );
                        location.href = "index.php?action_page=quan_ly_san_pham&action_product=all&id=" + Math.random();
                        return true;
    
                    } else {
    
                        alert("Xóa sản phẩm thất bại !!");
                    }
                }
            );
        }

    }

    return false;

}


// Xem truoc hinh anh
var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};




