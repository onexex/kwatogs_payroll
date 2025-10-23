$(document).ready(function() {


    $(document).on('click', '#btnLogin', function(e) {

        let axiosConfig = {
            headers: {
                'Content-Type': 'application/json;charset=UTF-8',
                "Access-Control-Allow-Origin": "*",
            }
        };

        var frmdata = $('#frmlogin');
        var formData = new FormData($(frmdata)[0]);
        axios.post('/loginSystem',formData, axiosConfig)
        .then(function (res) {
            //201 res
            if (res.data.status== 201) {
                $.each(res.data.error, function(prefix, val) {
                    $('input[name='+ prefix +']').addClass(" border border-danger") ;
                    $('span.' + prefix + '_error').text(val[0]);
                });
            }
            //200 success
            if (res.data.status== 200) {
                $('span.error-text').text("");
                 $('input.border').removeClass('border border-danger');
                //  dialog.alert({
                //     message: res.data.msg
                // });
                window.location.href="/";
            }

            //202 error
            if (res.data.status== 202) {
                $('span.error-text').text("");
                    $('input.border').removeClass('border border-danger');
                    dialog.alert({
                    message: res.data.msg,
                });
            }
        })
        .catch(function (error) {
            dialog.alert({
                message: error
            });
        })
        .then(function () {});
    });
});

