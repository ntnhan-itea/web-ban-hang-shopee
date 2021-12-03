

// ---------- VARIABLE ----------------------------------------------//


// var of class category
const category_items = document.querySelectorAll("#container .category-list .category-item");
let category_item_active = document.querySelector("#container .category-list .category-item.category-item--active");


// set active for category item
if(category_items != null) {

    for(const category_item of category_items) {
        category_item.addEventListener("click", function() {
            category_item_active.classList.remove("category-item--active");
            category_item.classList.add("category-item--active");
            category_item_active = category_item;
        })
    }
}


// var of class Sort-bar
const clss_home_filter_btns = document.querySelectorAll(".sort-bar .home-filter__btn.btn");
let btn_primary = document.querySelector(".sort-bar .home-filter__btn.btn.btn--primary")

const clss_sort_aZ = document.querySelector(".sort-bar .sort-price__a-z");
const clss_sort_Za = document.querySelector(".sort-bar .sort-price__z-a");

if(clss_sort_aZ != null)
    clss_sort_aZ.addEventListener("click", sortPrice_az);
if(clss_sort_Za != null)
    clss_sort_Za.addEventListener("click", sortPrice_az);


// set btn--primary cho cac sort-bar btn-control
if(clss_home_filter_btns != null) {

    for(const btn of clss_home_filter_btns) {
        btn.addEventListener("click", function() {
    
            btn_primary.classList.remove("btn--primary");
            this.classList.add("btn--primary");
            btn_primary = btn;
        })
    }
}


// var of Home Product
const likeElements = document.querySelectorAll("#container .home-product .product-action__icon");

// Action Like
if(likeElements != null) {

    for(const like of likeElements) {
    
        like.addEventListener("click", function() {
            if(this.classList.contains("far")) {
        
                this.classList.remove("far");
                this.classList.add("fas");
        
            } else {
        
                this.classList.remove("fas");
                this.classList.add("far");
        
            }
        })
    }
}



// // var of Page Control
// const btnControls = document.querySelectorAll("#container .page-control .page-change__btn");
// let btn_crl_active = document.querySelector("#container .page-control .page-change__btn.btn--active")

// // Action Num page
// for(const btn of btnControls) {
//     btn.addEventListener("click", function() {
//         btn_crl_active.classList.remove('btn--active');
//         btn.classList.add('btn--active');
//         btn_crl_active = btn;
//     })
// }



// Var of modal login and register


// VAR OF MODAL ---------------
const modal = document.querySelector(".modal");
// const auth_form_container = document.querySelector
const form_login = document.querySelector(".modal .auth-form__container--login");
const form_register = document.querySelector(".modal .auth-form__container--register");
const btn_change_forms = document.querySelectorAll(".modal .auth-form__switch-btn");
const inputs_login = document.querySelectorAll(".modal .auth-form__container--login .auth-form__input");
const inputs_register = document.querySelectorAll(".modal .auth-form__container--register .auth-form__input");
const btn_submit_login = document.querySelector(".modal .auth-form__container--login .auth-form__control-submit");
const btn_submit_register = document.querySelector(".modal .auth-form__container--register .auth-form__control-submit");

if(btn_change_forms != null) {

    for (const btn of btn_change_forms) {
        btn.addEventListener("click", function() {
            if(this.classList.contains("btn-login")) {
                openModal_register();
            }
            else {
                openModal_login();
            }
        })
    }
}

if(inputs_login != null) {

    for (const input of inputs_login) {
        input.addEventListener('keypress', function(event) {
            if(event.key === 'Enter') {
                btn_submit_login.click();
            }
        })
    }
}


if(inputs_register != null) {
    
    for (const input of inputs_register) {
        input.addEventListener('keypress', function(event) {
            if(event.key === 'Enter') {
                btn_submit_register.click();
            }
        })
    }
}


// Close Modal when click out-side form
window.onclick = function(event) {
    if(event.target == modal) {
        closeModal();
    }
}
// Close Modal when press ESC key
window.addEventListener("keydown", function(event) {
    if(event.key === 'Escape') {
        closeModal();
    }
})


// ------End: VARIABLE ---------------------------------------------//



// Event close Modal
function closeModal() {
    modal.style.display = "none";
}
// Event open Modal
function openModal_register() {
    modal.style.display = "flex";
    form_register.style.display = "block";
    form_login.style.display = "none";

}
function openModal_login() {
    modal.style.display = "flex";
    form_login.style.display = "block";
    form_register.style.display = "none";
}

// Event close Modal when click outside form
function closeModal_outSide() {
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
}


// Xu ly buttons control on Sort-bar
function sortPrice_az() {
    var txt_price = document.querySelector(".sort-bar .select-input__label");

    txt_price.innerHTML = this.innerText;
    txt_price.style.color = "rgb(238, 77, 45)";
}

// Check status login
function check_login(check_login) {
        
    if(!check_login) {
        openModal_login();
        return false;
    }

    return true;
}


// Check login with rols is admin
function fct_check_login_admin() {
    
    const btn_submit_login = document.getElementById("btn_submit_login");
    const check_login_admin =  document.getElementById("check_login_admin");
    
    if(btn_submit_login != null && check_login_admin != null) {

        if(check_login_admin.checked == true) {

            btn_submit_login.setAttribute("name", "btn_login_clicked_admin");
            // thep.innerHTML = thep.getAttribute("name");
        } else {

            btn_submit_login.setAttribute("name", "btn_login_clicked");
        }

    }

}


// Check register with rols is admin
function fct_check_register_admin() {
    
    const btn_submit_register = document.getElementById("btn_submit_register");
    const check_register_admin =  document.getElementById("check_register_admin");
    
    if(btn_submit_register != null && check_register_admin != null) {

        if(check_register_admin.checked == true) {

            btn_submit_register.setAttribute("name", "submit_register_form_admin");
            // thep.innerHTML = thep.getAttribute("name");
        } else {

            btn_submit_register.setAttribute("name", "submit_register_form");
        }

    }


}


// Check valid data input to register 
function check_valid_info_register() {

    const username_register = document.getElementById("username_register");
    const password_register = document.getElementById("password_register");
    const repeatPwd_register = document.getElementById("repeatPwd_register");

    const usernameRegex = /^[a-zA-Z0-9]+$/i;

    if(username_register != null && password_register != null && repeatPwd_register != null) {

        if (username_register.value.length > 0 && username_register.value[0].match(/^[a-zA-Z]+$/i) == null) {
            alert("Tên đăng nhâp phải bắt đầu bằng một ký tự !!");
            username_register.focus();
            return false;
        }

        if (hasWhiteSpace(username_register.value)) {
            alert("Tên đăng nhập không được chứa khoảng trắng");
            username_register.focus();
            return false;
        }

        if(username_register.value.match(usernameRegex) == null) {
            alert("Tên đăng nhập: Chỉ cho phép các ký tự A-Z, a-z, 0-9 và không chứa khoảng trắng.");
            username_register.focus();
            return false;
        }

        if(password_register.value.match(usernameRegex) == null) {
            alert("Mật khẩu: Chỉ cho phép các ký tự A-Z, a-z, 0-9 và không chứa khoảng trắng.");
            password_register.focus();
            return false;
        }

        // if (hasWhiteSpace(password_register.value)) {
        //     alert("Mật khẩu không được chứa khoảng trắng");
        //     password_register.focus();
        //     return false;
        // }

        if ( repeatPwd_register.value.trim() !== password_register.value.trim() ) {

            alert("Mật khẩu không trùng nhau");
            repeatPwd_register.focus();
            return false;
        }


        return true;

    }

    return false;

}



// Buy Product from cart
function buy_product($data) {

    const ho_ten_dat_hang = document.getElementById("frmName");
    const sdt_dat_hang = document.getElementById("frmSdt");
    const dia_chi_dat_hang = document.getElementById("frmDiaChi");

    if( ho_ten_dat_hang.value.trim().length < 5 || sdt_dat_hang.value.trim().length < 5 || parseInt(dia_chi_dat_hang.value) < 1 ) {
        
        alert("Địa chỉ nhận hàng lỗi hoặc rỗng !!");
        return false;
    }



    // console.log("da do");
    if($data.length < 1) {
        alert("Chưa chọn sản phẩm !");
        return false;
    }
    else {

        if (confirm("(Kiểm tra kỹ thông tin trước khi đặt hàng)\r\n\nXÁC NHẬN ĐẶT HÀNG ?")) {

            $.post('buy_product_process.php', 
            {   
                action_page: "purchase",
                data: $data
            }, 
            function(data, status)
            {
                // console.log(status);
                if (data.includes('buy_success')) {
                    
                    alert( "Đặt hàng thành công. ("+status+")" );
                    // location.reload();
                    location.href = "?action_page=imp_purchase&action_view=wait_comfirm&random=" + Math.random();
                    return true;

                } else {
                    alert("Đặt hàng thất bại !!");
                }
            });
        }
        
    }

    return false;
}


// Check valid quantity product in cart to buy.
function check_valid_quantity_and_update_total_price(data_product_quantity) {

    // Check valid quantity
    let quantity_valid = parseInt(data_product_quantity.value);

    if( ! Number.isInteger( quantity_valid ) ) 
        data_product_quantity.value = data_product_quantity.min;
    else 
        if(quantity_valid > parseInt(data_product_quantity.max)) 
            data_product_quantity.value = data_product_quantity.max;
    else 
        if(quantity_valid < parseInt(data_product_quantity.min))
            data_product_quantity.value = data_product_quantity.min;


    let id = parseInt( (data_product_quantity.id).slice(16) );

    cart_datas[id]["quantity"] = parseInt( data_product_quantity.value );

    // console.log(cart_datas);

    const product_total_price_item  = document.getElementById("product_total_price_item" + id);
    const product_total_price_item_hiden  = document.getElementById("product_total_price_item_hiden" + id);
    const product_price  = document.getElementById("product_price" + id);

    let total = parseInt(data_product_quantity.value) * parseInt(product_price.value);

    product_total_price_item.innerHTML = "" + total.toLocaleString("it-IT");
    product_total_price_item_hiden.value = total;

   
    
}


// Select all product in cart
function select_all_product_in_cart() {

    const checkAll = document.getElementById("check_box_all");
    const checkboxes = document.querySelectorAll(".buy_product_choose");
    
    let stt = false;
    if(checkAll.checked === true) {
        stt = true;
    }

    for(let checkbox of checkboxes){
        checkbox.checked = stt;
    }
}


// Delete product in cart
function delete_product(index ,data) {
    id_mshh = parseInt( data.value );
    index = parseInt (index);

    if( confirm("Xác nhận xóa sản phẩm ? (Sản phẩm "+ (index + 1) +")") ) {
        // console.log(cart_datas[id]["MSHH"]);

        document.location.href = "?action_page=cart&action_cart=delete&id_product=" + id_mshh;
    }

    return false;
}


// Delete Dia chi khach hang
function delete_dia_chi_kh($this, $total_address, $mskh) {

    let ma_DC = parseInt( $this.value ) > 0 ? parseInt( $this.value) : -1;
    let total_address = parseInt($total_address) < 1 ? 0 : parseInt($total_address);
    let mskh = parseInt($mskh) > 0 ? parseInt($mskh) : -1;

    if(total_address < 2 || mskh < 1) {
        alert("Không được xóa địa chỉ cuối cùng !!");
        return false;
    }

    if(confirm("Xác nhận xóa địa chỉ ?")) {

        console.log(ma_DC + '_' + total_address);

        $.post("../../pages/user/process_user.php", 
        {
            delete_dia_chi_kh: "yes",
            MaDC: ma_DC,
            MSKH: mskh
        },
        function(data) {

            console.log(data);

            if (data.includes('delete_success')) {
            
                alert("Xóa địa chỉ thành công.");
                location.reload();
            } else {
    
                alert("Xóa địa chỉ thất bại !!");
                return false;
            }
        });

    }

    return false;


}

// Them dia chi Khach hang
function add_new_addresses($mskh) {

    console.log($("#add_new_address_text").val().trim());

    let mskh = parseInt($mskh) > 0 ? parseInt($mskh) : -1;
    let address_new = $("#add_new_address_text").val().trim();

    if(address_new.length < 5 || address_new.length > 250) {
        alert("Ít nhẩt 5 ký tự hoặc nhiều nhất 250 ký tự !!");
        return false;
    }

    if(mskh < 1) {
        alert("Không tìm thấy mã khách hàng !!");
        return false;
    }


    if(confirm("Xác nhận thêm địa chỉ ?")) {

        $.post("../../pages/user/process_user.php", 
        {
            add_new_addresses: "yes",
            MSKH: mskh,
            address_text: address_new
        },
        function(data) {

            console.log(data);

            if (data.includes('add_address_success')) {
            
                alert("Thêm địa chỉ thành công.");
                location.href = "?action_page=my_address&random=" + Math.random();
            } else {
    
                alert("Thêm địa chỉ thất bại !!");
                return false;
            }
        });

    }

    return false;

}


// Cap nhat dia chi Khach hang
function update_address($mskh, $ma_dia_chi) {

    let ma_dia_chi = parseInt($ma_dia_chi) > 0 ? parseInt( $ma_dia_chi) : -1 ; 
    let ma_so_kh = parseInt($mskh) > 0 ? parseInt( $mskh) : -1 ; 
    let address_update = $("#update_address_text").val().trim();

    
    console.log($("#update_address_text").val().trim());


    if(address_update.length < 5 || address_update.length > 250) {

        alert("Ít nhẩt 5 ký tự hoặc nhiều nhất 250 ký tự !!");
        return false;
    }

    if(ma_so_kh < 1) {

        alert("Không tìm thấy mã khách hàng !!");
        return false;
    }


    if(confirm("Xác nhận cập nhật địa chỉ ?")) {

        $.post("../../pages/user/process_user.php", 
        {
            update_address: "yes",
            MSKH: ma_so_kh,
            MaDC: ma_dia_chi,
            address_text: address_update
        },
        function(data) {

            console.log(data);

            if (data.includes('update_address_success')) {
            
                alert("Cập nhật địa chỉ thành công.");
                location.href = "?action_page=my_address&random=" + Math.random();
            } else {
    
                alert("Cập nhật địa chỉ thất bại !!");
                return false;
            }
        });

    }

    return false;

}


// Huy don hang
function cancel_purchased(soDonDH, maSoKH, item) {

    let _stt_Don_Hang = parseInt(item.value);
    let _soDonDH = parseInt(soDonDH);
    let _maSoKH = parseInt(maSoKH);

    if(confirm("Xác nhận HỦY đơn hàng? " + "( Đơn hàng: " + _stt_Don_Hang + " )")) {
        $.post("../../pages/user/buy_product_process.php", 
        {
            action_page: "delete_purchased",
            soDonDH: _soDonDH,
            maSoKH: _maSoKH
        },
        function(data) {
            console.log(data);
            if (data.includes('cancel_successed')) {
            
                alert("Hủy đơn hành thành công.");
                location.reload();
            } else {
    
                alert("Hủy đơn hàng thất bại ");
                return false;
            }
        });
    }

}





// const id = $("#test")[0];
// // const id = $(".container-nav__list-item")[0];
// // const id = document.getElementById("test");
// // id.classList.add("abc");
// console.log(id);
// // Actiove nav list Thong tin don hang
// function active_container_nav($this) {

//     id.classList.add("active");
//     console.log(id);
//     return false;

// }

// var of Page Control
const nav_don_hangs = $(".container-nav__list-item");
let nav_don_hangs_active = $(".container-nav__list-item.active");

// Action Num page
if(nav_don_hangs != null) {
    
    for(const nav of nav_don_hangs) {
        nav.addEventListener("click", function() {
            nav_don_hangs_active.classList.remove('active');
            nav.classList.add('active');
            nav_don_hangs_active = nav;
        })
    }
}



// Tim khoang trang
function hasWhiteSpace($string) {
    return /\s/g.test($string);
}


// Thong bao

function thongBao() {
    // alert("Trang web này có một số hình ảnh được import Online.\r\n \r\nĐể trang web hoạt động tốt , \r\nHãy đảm bảo rằng máy tính của bạn được kết nối Internet !!");
}



