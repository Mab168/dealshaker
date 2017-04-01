$(function () {
	$('#load_panigation_ajax').on('click',function(){
		var start = parseInt($('#start_query').val());
		$('#start_query').val(parseInt($('#start_query').val())+4)
		$('#load_panigation_ajax').hide();
		$('.cbp-l-loadMore-loadingText').show();
		$.ajax({
            url : "index.php?route=account/dashboard/load_product",
            type : "post",
            dateType:"html",
            data : {
                 'start' : start
                
            },
            success : function (result){
            	$('#load_panigation_ajax').show();
            	$('.cbp-l-loadMore-loadingText').hide();
                $('.product_append').append(result);
            }
        });
        return false;
	});
})