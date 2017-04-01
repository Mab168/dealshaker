$(document).ready(function() {
    $('.add_wishlist').on('click',function(){
        var product_id = $(this).data('product_id');
        $.ajax({
            url : "index.php?route=account/product/add_product_wishlist",
            type : "post",
            dateType:"text",
            data : {
                 'product_id' : product_id
            },
            success : function (result){
                result = $.parseJSON(result);
                if (result.complete == 1)
                {
                    toastr.success("Thêm vào yêu thích thành công!!!", "Thêm thành công", {
                        "timeOut": "3000",
                        "extendedTImeout": "3000"
                    });
                }
                if (result.login == -1)
                {
                    toastr.error("Bạn vui lòng đăng nhập tài khoản!!!", "Chưa đăng nhập", {
                        "timeOut": "3000",
                        "extendedTImeout": "3000"
                    });
                }
            }
        });

        return false;
    })
});

