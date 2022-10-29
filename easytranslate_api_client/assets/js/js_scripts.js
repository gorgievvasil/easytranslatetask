$(document).ready(function() {

    var openedRegister = 0;
    var openedLogin = 0;    
    var apiServer = $('.api-server-url').val();
    
    $('#currency-from').on('change', function (e) {
        let optionSelected = $("option:selected", this);
        let valueSelected = this.value;
        
        if(valueSelected == "select_currency") {
            $('.input-group-text').text("XXX");
        }
        else {
            $('.input-group-text').text(valueSelected);
        }
        
    });    

    $(document).on('click', '.register-span', function() {
        if(openedRegister == 0){
            $('.user-registration-div').css('display', 'block');
            $('.user-login-div').css('display', 'none');            
            openedLogin = 0;
            openedRegister = 1;
        }
        else if(openedRegister == 1) {
            $('.user-registration-div').css('display', 'none');
            openedRegister = 0;
        }
        
    });

    $(document).on('click', '.login-span', function() {
        if(openedLogin == 0){
            $('.user-login-div').css('display', 'block');
            $('.user-registration-div').css('display', 'none');
            openedLogin = 1;
            openedRegister = 0;
        }
        else if(openedLogin == 1) {
            $('.user-login-div').css('display', 'none');
            openedLogin = 0;
        }
        
    });

    $(document).on('click', '.get-rate', function() {
        $('.loader-conversion-wrapper').css('display', 'block');

        var userAuthToken = $('#token').val();
        var src = $('#currency-from').val();
        var trg = $('#currency-to').val();        

        $.ajax({
            type: "GET",
            url: "http://" + apiServer + "/api/conversion/rate",
            dataType: 'json',
            headers: {
                "Authorization": "Bearer " + userAuthToken
            },
            data: {'source_currency': src, 'target_currency': trg},
            success: function(response) {
               
                $('.loader-conversion-wrapper').css('display', 'none');
                
                $('.rate').text("");

                if(response.status == true) {
                    $('.rate').text("1 " + response.source_currency + " = " + response.conversion_rate + " " + response.target_currency);
                }
                else {
                    $('.loader-conversion-wrapper').css('display', 'none');
                    $('.toast-title').text("Failed");
                    $('.toast-body').html('<span>API request to get rate failed!</span>');                
                    $('.toast').toast("show");
                }
                
            },
            error: function (jqXHR, exception) {
                $('.loader-conversion-wrapper').css('display', 'none');
                $('.toast-title').text("Failed");
                $('.toast-body').html('<span>' + jqXHR.responseJSON.message + '</span>');                
                $('.toast').toast("show");
            }
        });       
    });

    $(document).on('click', '#submit-convert-btn', function(e) {
        e.preventDefault();

        $('.loader-conversion-wrapper').css('display', 'block');

        var userAuthToken = $('#token').val();
        var src = $('#currency-from').val();
        var trg = $('#currency-to').val();
        var amount = $("#amount-to-convert").val();

        $.ajax({
            type: "POST",
            url: "http://" + apiServer + "/api/conversion",
            dataType: 'json',
            headers: {
                "Authorization": "Bearer " + userAuthToken
            },
            data: {'source_currency': src, 'target_currency': trg, 'amount': amount},
            success: function(response) {
                
                $('.loader-conversion-wrapper').css('display', 'none');

                if(response.status == true) {
                    $('.converted-result').css('display', 'block');
                    $('.converted-result').html('<span class="conversion-result">' + amount + ' ' + src + ' =  ' + parseFloat(response.converted_amount).toFixed(4) + ' ' + trg + '</span><hr/><span class="conv_rate">1 ' + src + ' = ' + response.conversion_rate + ' ' + trg + "</span>");
                }
                else {
                    $('.loader-conversion-wrapper').css('display', 'none');
                    $('.toast-title').text("Conversion failed");
                    $('.toast-body').html('<span>' + response.message + '</span>');                
                    $('.toast').toast("show");
                    $('.loader-conversion-wrapper').css('display', 'none');
                }
                
            },
            error: function (jqXHR, exception) {
                $('.loader-conversion-wrapper').css('display', 'none');
                $('.toast-title').text("Failed");
                $('.toast-body').html('<span>' + jqXHR.responseJSON.message + '</span>');                
                $('.toast').toast("show");
            }
        });       
    });

    $('.user-form').on('submit', function(e) {
        e.preventDefault();

        $('.loader-user-wrapper').css('display', 'block');

        var formData = $(this).serialize();
        var action = $(this).find('input[name="actionType"]').val();                     

        $.ajax({
            type: "POST",
            url: "http://" + apiServer + "/api/auth/" + action,
            dataType: 'json',            
            data: formData,
            success: function(response) {
                
                $('.loader-user-wrapper').css('display', 'none');

                $('.toast-title').text(response.message);
                if(response.status == true) {
                    $('.toast-body').html('<span>Your token: <b>' + response.token + '</b></span><hr/><span>Save your token on safe place. It is required to send API requests later.</span>');
                    $('#token').val(response.token);
                    document.cookie = "token=" + response.token + "; path=/";
                    setTimeout(function(){
                       window.location.reload();
                    }, 3000);
                }
                else if(response.status == false) {
                    $('.toast-body').html('<span>Unsuccessfully user ' + action + '</span>');
                    $('#token').val("");
                }
                
                $('.toast').toast("show");
                
            },
            error: function (jqXHR, exception) {
                $('.loader-conversion-wrapper').css('display', 'none');
                $('.toast-title').text("Failed");
                $('.toast-body').html('<span>' + jqXHR.responseJSON.message + '</span>');                
                $('.toast').toast("show");
            }
        });       
    });

    $(document).on('click', '.logout-span', function() {
        $('.loader-user-wrapper').css('display', 'block');
        document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        $('.toast-title').text("Logout successful");                
        setTimeout(function(){
           window.location.reload();
        }, 2000);
        $('.toast').toast("show");
    });

});