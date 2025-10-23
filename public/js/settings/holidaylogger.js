// JMC
$(document).ready(function() {

    var formaction = 0;
    var updateID = '';
    get_hl();

    $(document).on("click", "#btnCreateHoliday", function (e) {
        formaction = 1;
        $('#frmHoliday')[0].reset();
    });

    $(document).on("click", "#btnSaveHoliday", function (e) {

        var datas = $('#frmHoliday');
        var type  = $("#selTypeHoliday option:selected").val();
        var formData = new FormData($(datas)[0]);
        formData.append('formAction', formaction);
        formData.append('type', type);
        formData.append('updateID', updateID);

        axios.post('/classification/createHolidayLogger',formData)
        .then(function(response){
            var status = response.data.status;

            if(status == 201)
            {
                get_hl();
                $.each(response.data.error, function(prefix, val) {
                    $('input[name='+ prefix +']').addClass(" border border-danger") ;
                    $('span.' + prefix + '_error').text(val[0]);
                });
            }
            if(status == 200)
            {
                get_hl();
                $('span.error-text').text("");
                $('input.border').removeClass('border border-danger');
                $('#frmHoliday')[0].reset();
                dialog.alert({
                    message: response.data.msg
                });
            }
            if(status == 202)
            {
                get_hl();
                $('span.error-text').text("");
                $('input.border').removeClass('border border-danger');
                dialog.alert({
                    message: response.data.msg
                });
            }
        })
        .catch(function(error){
            dialog.alert({
                message: error
            });
        })
        .then(function(response){})

    });

    function get_hl(){

        axios.get('/getHL')
        .then(function(response){

            var resultData = response.data.data;
            var status = response.data.status;
            var content;

            if(status = 200)
            {
                $(resultData).each(function(index, item){

                    content += "<tr>" +
                        "<td>" + item.date + "</td>" +
                        "<td>" + item.description + "</td>" +
                        "<td>" + "<button type='button' class='btn btn-details' value=" + item.id + " data-bs-toggle='modal' data-bs-target='#mdlHoliday' id='btnUpdateHL'> <i class='fa-solid fa-pencil'></i> </button> "
                    content += "</tr>";

                })
                $("#tblHolidaysLog").empty().append(content);
            }
            else
            {
                dialog.alert({
                    message: "Something went wrong!"
                });
            }
        })
        .catch(function(error){
            dialog.alert({
                message: error
            });
        })
        .then(function(response){})

    }

    $(document).on("click", "#btnUpdateHL", function (e) {

        formaction = 2;
        $(".lblActionDesc").html("Update Holiday Logger");
        var id = $(this).val();
        updateID = id;

        axios.get('/getHLData',{
            params: {
                id: id,
                updateID: updateID
              }
          })
        .then(function(response){
             var resultData = response.data.data;
             var status = response.data.status;

             if(status == 200){
                get_hl();
                $(resultData).each(function(index, item){
                    $('#txtDate').val(item.date);
                    $('#txtDescription').val(item.description);
                    $('#selTypeHoliday').val(item.type);
                });
                $('#btnSaveHoliday').val(id);

             }

        })
        .catch(function(error){
            dialog.alert({
                message: error
            })
        })
        .then(function(response){})
    });

})
