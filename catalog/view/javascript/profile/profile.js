$( document ).ready(function() {

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result).show().css({'width': '100%','height':'200px'});
                
                 $('#old_img').hide();
            }

            reader.readAsDataURL(input.files[0]);
        }else{
            $('#blah').hide();
        }
    }
    $("#file").on('change' , function (env) {

         
        
        var fileExtension = [ 'jpg', 'png', 'gif'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            if($("#file").val())
            {
                  
               $('.error-file').show(); 
           }
           else
           {
                $('.error-file').hide(); 
           }
            $('#comfim-pd').resetForm();
        }else
        {
            readURL(this);
            $('.error-file').hide();
            $('#old_img').hide();
        }
    });



    $('#update_profile').on('submit', function(){
        if ($('#email').val() == "") {
            $('#email').addClass('has-error');
            return false;
        }

        if ($('#telephone').val() == "") {
            $('#telephone').addClass('has-error');
            return false;
        }

        if ($('#address_cus').val() == "") {
            $('#address_cus').addClass('has-error');
            return false;
        }

        if ($('#wallet').val() == "") {
            $('#wallet').addClass('has-error');
            return false;
        }

        if ($('#username_gdg').val() == "") {
            $('#username_gdg').addClass('has-error');
            return false;
        }
        if ($('#file').attr('src') == ""){
            $('.error-file').hide();
            return false;
        }
        $('#update_profile').ajaxSubmit({
            type : 'POST',
            beforeSubmit : function(arr, $form, options) { 
               
            },
            success : function(result){
                var html = '<div class="col-md-12">';
                html += '<p class="text-center" style="font-size:19px;color: black;text-transform: uppercase;height: 20px">Cập nhập thông tin thành công!</p>';
              
                alertify.alert(html, function(){
                    location.reload(true); 
                });
            }
        })

        return false;
    });

});
