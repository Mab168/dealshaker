$(function() {
	$('.remove_product').on('click',function(){
		var product_id = $(this).data('id');
		$.ajax({
            url : "index.php?route=account/card/remove_product",
            type : "get",
            dateType:"text",
            data : {
                 'product_id' : product_id
            },
            success : function (result){
                $('.item_product_'+product_id+'').hide();
            }
        });
	});

	$('.add_to_card').on('click',function(){
		var product_id = $(this).data('id');
		$.ajax({
            url : "index.php?route=account/card/add_to_card",
            type : "get",
            dateType:"text",
            data : {
                 'product_id' : product_id
            },
            success : function (result){
              toastr.success("Sản phẩm đã được thêm vào giỏ hàng của bạn!!!", "Thêm giỏ hàng thành công", {
                        "timeOut": "3000",
                        "extendedTImeout": "3000"
                    });  
            }
        });
	});


	$('.number_item').on('keyup',function(){
		var product_id = $(this).data('id');
		var number_product = $(this).val();
		$.ajax({
            url : "index.php?route=account/card/update_card",
            type : "get",
            dateType:"text",
            data : {
                'product_id' : product_id,
                'number_product' : number_product
            },
            success : function (result){
               setTimeout(function(){  location.reload(true); }, 1000);
            }
        });
	});
	
	
})