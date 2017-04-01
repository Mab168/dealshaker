$(function () {
	$('#comment_product').on('submit',function(){
		$(this).ajaxSubmit({
	        type : 'POST',
	        
	        beforeSubmit : function(arr, $form, options) {
	        	if ($('#comment_product textarea').val() == "")
	        	{
	        		$('#comment_product textarea').css({'border':'1px solid red'});
	        		$('#comment_product textarea').focus();
	        		return false;
	        	}
	        },
	        success : function(result) {
	        	result = $.parseJSON(result); 
	        	if (result.complete)
	        	{
	        		location.reload(true);   
	        	}
	             
	        }
	    });
	    return false;
	});
	
})