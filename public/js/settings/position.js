$(document).ready(function() {
    var formAction=0;
    var posID=0;
    getPos();
    function getPos(){
        axios.get('/position/get_position')
        .then(function (response) {
            var htmlData='';
            var i=1;
            $(response.data.data).each(function(index, row) {
                htmlData += "<tr> " +
                    "<td class='text-uppercase'>" + row.pos_desc +  "</td>" +
                    "<td class='text-uppercase'>" + row.pos_jl_desc +  "</td>" ;

                htmlData +="<td class='text-uppercase'>" +  '<button type="button" value='+ row.id +' class="btn btn-details" data-toggle="tooltip" data-placement="bottom"  id="btnUpdatePosition" title=" Schedule" data-bs-toggle="modal" data-bs-target="#mdlPosition" > <i class="fa fa-pencil"></i> </button>'  + "</td>" ;
                htmlData += "</tr>";
            })
            $("#tblPositions").empty().append(htmlData);

        })
        .catch(function (error) {
            dialog.alert({
                message: error
            });
        })
        .then(function () {});
    }

    //create Function
    $(document).on('click', '#btnAddPosition', function(e) {
        formAction=1;
        $('.lblActionDesc').text('Creating Worktime');
        $('#frmPosition')[0].reset();
        $('span.error-text').text("");
        $('input.border').removeClass('border border-danger');
    });

    //edit Function
    $(document).on('click', '#btnUpdatePosition', function(e) {
        $('span.error-text').text("");
        $('input.border').removeClass('border border-danger');
        formAction=2;
        posID=$(this).val();
        $('.lblActionDesc').text('Updating Worktime');
        axios.get('/position/edit',{
            params: {
                posID: posID
              }
          })
        .then(function (response) {
            $(response.data.data).each(function(index, row) {
                $('#txtPosition').val(row.pos_desc);
                $('#selJobLevel').val(row.pos_jl);
            })
        })
        .catch(function (error) {
            dialog.alert({
                message: error
            });
        })
        .then(function () {});

    });

    $(document).on('click', '#btnSavePosition', function(e) {
        var datas = $('#frmPosition');
        var formData = new FormData($(datas)[0]);
        formData.append('formAction', formAction);
        formData.append('jobdesc', $('#selJobLevel option:selected').text());
        formData.append('posID', posID);
        //create script
            axios.post('/position/create_update',formData)
            .then(function (response) {
                //error response
                if (response.data.status == 201) {
                    $.each(response.data.error, function(prefix, val) {
                        $('input[name='+ prefix +']').addClass(" border border-danger") ;
                        $('span.' + prefix + '_error').text(val[0]);
                    });
                }
                //success respose
                if(response.data.status == 200){
                    $('span.error-text').text("");
                    $('input.border').removeClass('border border-danger');
                    $('#frmPosition')[0].reset();
                    getPos();
                    dialog.alert({
                        message: response.data.msg
                    });
                }
                 //success respose
                 if(response.data.status == 202){
                    $('span.error-text').text("");
                    $('input.border').removeClass('border border-danger');
                    dialog.alert({
                        message: response.data.msg
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
