
$(document).ready(function() {

//To add new input file field dynamically, on click of "Add More Files" button below function will be executed
    $('.add_append_img').click(function() {
	    window.KCFinder = {
	        callBack: function(url) { 
	            $('.img_append').append('<div class="item_image_ap"><img src="'+url+'" class="images_appen" /> <input type="hidden" class="images_appen_affter" name="image[]" value="'+url+'"/><i class="fa fa-times-circle"></i></div>')
	            remove_appen();
	            window.KCFinder = null;
	            $.fancybox.close();
	        }
	    };    	 
    });

    function remove_appen(){
    	$('.item_image_ap i').click(function(){
	    	$(this).parent('.item_image_ap').remove();
	    });
    }
    

    validator = $("#form_submit_sanpham_add").validate({

        submitHandler: function(form) {
        	$('.errot_noidung').hide();
        	$('.errot_mota').hide();
        	$('.error-images').hide();
            if (tinyMCE.get('tinymce4_mota_add').getContent() == "")
            {
                $('.errot_mota').show();
                
                return false;
            }
            if (tinyMCE.get('tinymce4_noidung_add').getContent() == "")
            {
                $('.errot_noidung').show();
               
                return false;
            }
            
            if ($('.images_appen_affter').val() == undefined )
            {
            	$('.error-images').show();
            	return false;
            }
                 
            add_product();  
            return false;  
           
        }
    });  

    validators = $("#form_submit_sanpham_edit").validate({

        submitHandler: function(form) {
        	$('.errot_noidung').hide();
        	$('.errot_mota').hide();
        	$('.error-images').hide();
            if (tinyMCE.get('tinymce4_mota_edit').getContent() == "")
            {
                $('.errot_mota').show();
                
                return false;
            }
            if (tinyMCE.get('tinymce4_noidung_edit').getContent() == "")
            {
                $('.errot_noidung').show();
               
                return false;
            }
            
            if ($('.images_appen_affter').val() == undefined )
            {
            	$('.error-images').show();
            	return false;
            }
            
            edit_product();  
            return false;  
           
        }
    });  

    $('.edit_product').on('click',function(){
    	$('.item_image_ap').remove();

    	var product_id = $(this).data('id');
    	$('.edit_product_from').attr('data-id',product_id);
     	$.ajax({
            url : "index.php?route=account/shop/get_product_id",
            type : "post",
            dateType:"json",
            data : {
                 'product_id' : product_id
            },
            success : function (result){

            	result = $.parseJSON(result); 
                $('.edit_product_from #input_tieude').val(result.name_product);
                $('.edit_product_from #input_giasp_gdg').val(result.price_gdg);
                $('.edit_product_from #input_giasp_btc').val(result.price_btc);
                $('.edit_product_from #input_danhmuc').val(result.category);
                tinyMCE.get('tinymce4_mota_edit').setContent(result.descript_ngan);
                tinyMCE.get('tinymce4_noidung_edit').setContent(result.description);
                $.each(result.images, function(i, item) {
                	$('.img_append').append('<div class="item_image_ap"><img src="'+item+'" class="images_appen" /> <input type="hidden" class="images_appen_affter" name="image[]" value="'+item+'"/><i class="fa fa-times-circle"></i></div>');
	            	remove_appen();
				    $('.nav-tabs a[href="#tab_16_3"]').tab('show');
				});
            }
        });
     	return false;
    });

    $('.delete_product').on('click',function(){
    	
    	var product_id = $(this).data('id');
    	alertify.confirm('<p class="text-center" style="font-size:18px !important;color: black;text-transform: uppercase;height: 20px">Bạn có chắc chắn xóa ?</p>', function (e) {
        if (e) {
        	$.ajax({
	            url : "index.php?route=account/shop/delete_product",
	            type : "post",
	            dateType:"json",
	            data : {
	                 'product_id' : product_id
	            },
	            success : function (result){
	            	result = $.parseJSON(result); 
            
		            if (result.complete == 1){
		                var html = '<div class="col-md-12">';
					    html += '<p class="text-center" style="font-size:19px;color: black;text-transform: uppercase;height: 20px">Xóa sản phẩm thành công!</p>';
					  
					    alertify.alert(html, function(){
					        location.reload(true); 
					    });
		            }
	            }
	        });


        	} else {
                // user clicked "cancel"
            }
        });
        return false;
     	
     	return false;
    });


});

function add_product(){
	$('#form_submit_sanpham_add').ajaxSubmit({
        type : 'POST',
        data : { 'descript_ngan': tinyMCE.get('tinymce4_mota_add').getContent(),'description' : tinyMCE.get('tinymce4_noidung_add').getContent()},
        beforeSubmit : function(arr, $form, options) {

        },
        success : function(result) {
        result = $.parseJSON(result); 
            
            if (result.complete == 1){
                var html = '<div class="col-md-12">';
			    html += '<p class="text-center" style="font-size:19px;color: black;text-transform: uppercase;height: 20px">Thêm sản phẩm thành công!</p>';
			  
			    alertify.alert(html, function(){
			        location.reload(true); 
			    });
            }
           
        }
    });
}

function edit_product(){
	$('#form_submit_sanpham_edit').ajaxSubmit({
        type : 'POST',
        data : {'product_id' : $('#form_submit_sanpham_edit').data('id'),'descript_ngan': tinyMCE.get('tinymce4_mota_edit').getContent(),'description' : tinyMCE.get('tinymce4_noidung_edit').getContent()},
        beforeSubmit : function(arr, $form, options) {

        },
        success : function(result) {
        result = $.parseJSON(result); 
            if (result.complete == 1){
                var html = '<div class="col-md-12">';
			    html += '<p class="text-center" style="font-size:19px;color: black;text-transform: uppercase;height: 20px">Sửa sản phẩm thành công!</p>';
			    alertify.alert(html, function(){
			        location.reload(true); 
			    });
            }
        }
    });
}


String.prototype.reverse = function () {
        return this.split("").reverse().join("");
    }
function reformatText(input) {    
    var x = input.value;
    x = x.replace(/,/g, ""); // Strip out all commas
    x = x.reverse();
    x = x.replace(/.../g, function (e) {
        return e + ",";
    }); // Insert new commas
    x = x.reverse();
    x = x.replace(/^,/, ""); // Remove leading comma
    input.value = x;
}