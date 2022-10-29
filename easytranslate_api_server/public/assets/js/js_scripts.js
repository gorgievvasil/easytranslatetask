$(document).ready(function(){
    $(document).on('click', '.get-rate', function() {

        setInterval(blink_text, 250);
        $('.rate').text("Getting rate...");

        var userAuthToken = $('#token').val();
        var src = $('#currency-from').val();
        var trg = $('#currency-to').val();

        $.ajax({
            type: "GET",
            url: "/api/conversion/rate",
            dataType: 'json',
            headers: {
                "Authorization": "Bearer " + userAuthToken
            },
            data: {'source_currency': src, 'target_currency': trg},
            success: function(response) {
                clearInterval(blink_text);                
                if(response.status == true) {
                    $('.rate').text("1 " + response.source_currency + " = " + response.conversion_rate + " " + response.target_currency);
                }
                else {
                    $('.rate').text("Conversion failed. " + response.message);
                }
            }
        });
    });

    function blink_text() {
        $('.blink').fadeOut(250);
        $('.blink').fadeIn(250);
    }
});