$(document).ready(function() {
    var formAction=0;
    var classID=0;
    get_classification();

    function get_classification(){
        axios.get('/classification/get_all')
        .then(function (response) {
            var htmlData='';
            var i=1;
            $(response.data.data).each(function(index, row) {
                htmlData += "<tr> <td>" + i++ + "</td>" +
                    "<td class='text-uppercase'>" + row.class_code +  "</td>" +
                    "<td class='text-uppercase'>" + row.class_desc +  "</td>" ;

                    htmlData +="<td  >" +  '<button type="button" value='+ row.id +' class="btn btn-details btn-sm" data-toggle="tooltip" data-placement="bottom"  id="btnUpdateClassification" title=" Schedule" data-bs-toggle="modal" data-bs-target="#mdlClassification" > <i class="fa fa-pencil"></i> </button>'   ;
                    htmlData += '<button type="button" value='+ row.id +' class="btn btn-secondary btn-sm ml-1" id="btnDeleteClassification" > <i class="fa fa-trash"></i> </button>'  + "</td>" ;
                htmlData += "</tr>";
            })
            $("#tblClasification").empty().append(htmlData);

        })
        .catch(function (error) {
            dialog.alert({
                message: error
            });
        })
        .then(function () {});
    }

    $(document).on('click', '#btnCreateClassification', function(e) {
        formAction=1;
        $('.lblActionDesc').text('Creating Classification');
        $('#frmCreateClassification')[0].reset();
        $('span.error-text').text("");
        $('input.border').removeClass('border border-danger');
    });

    $(document).on('click', '#btnUpdateClassification', function(e) {
        formAction=2;
        classID=$(this).val();
        $('span.error-text').text("");
        $('input.border').removeClass('border border-danger');
        $('.lblActionDesc').text('Updating Classification');
        // $('#frmCreateClassification')[0].reset();
        axios.get('/classification/edit',{
            params: {
                classID: classID
              }
          })
        .then(function (response) {
            $(response.data.data).each(function(index, row) {
                $('#txtClassificationCode').val(row.class_code);
                $('#txtClassificationDesc').val(row.class_desc);
            })
        })
        .catch(function (error) {
            dialog.alert({
                message: error
            });
        })
        .then(function () {});
    });

    $(document).on('click', '#btnSaveClassification', function(e) {
        var datas = $('#frmCreateClassification');
        var formData = new FormData($(datas)[0]);
        formData.append('formAction', formAction);
        formData.append('classID', classID);
        //create script
            axios.post('/classification/create_update',formData)
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
                    $('#frmCreateClassification')[0].reset();
                    get_classification();
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
    $(document).on('click', '#btnDeleteClassification', function(e) {
        var id=$(this).val();

        axios.get('/classification/delete',{
            params: {
                id: id
              }
          })
        .then(function (response) {
            dialog.alert({
                message: response.data.msg
            });
            get_classification();

        })
        .catch(function (error) {
            dialog.alert({
                message: error
            });
        })
        .then(function () {

        });

     });


});






