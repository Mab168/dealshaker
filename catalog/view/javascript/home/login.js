$(function() {
    $('#fom_login_ajax').on('submit', function() {

        $(this).ajaxSubmit({
            type : 'POST',
            beforeSubmit : function(arr, $form, options) {

            },
            success : function(result) {
            result = $.parseJSON(result); 
                
                if (result.warning != ""){
                    $('.error-login-form').html(result.warning);
                }
                if (result.warning == null)
                {
                    location.reload(true); 
                }
             }
        });
        
        return false;
    });
})