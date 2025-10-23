$(document).ready(function() {
    var formAction=0;
    var CompanyID=0;
    get_company();

    function get_company(){
        axios.get('/company/get_all')
        .then(function (response) {
            var htmlData='';
            var i=1;
            $(response.data.data).each(function(index, row) {
                htmlData += "<tr> <td>" + i++ + "</td>" +
                    "<td  >" + row.comp_code +  "</td>" +
                    "<td >" + row.comp_name +  "</td>" +
                    "<td  >" + row.comp_color +  "</td>" ;

                    htmlData +="<td  >" +  '<button type="button" value='+ row.id +' class="btn btn-details btn-sm" data-toggle="tooltip" data-placement="bottom"  id="btnUpdateCompany" title=" Schedule" data-bs-toggle="modal" data-bs-target="#mdlCompany" > <i class="fa fa-pencil"></i> </button>'   ;
                    htmlData += '<button type="button" value='+ row.id +' class="btn btn-secondary btn-sm ml-1" id="btnUpdatedDelete" > <i class="fa fa-trash"></i> </button>'  + "</td>" ;
                htmlData += "</tr>";
            })
            $("#tblCompanies").empty().append(htmlData);

        })
        .catch(function (error) {
            dialog.alert({
                message: error
            });
        })
        .then(function () {});
    }

    //create Function
    $(document).on('click', '#createCompany', function(e) {
        formAction=1;
        $('span.error-text').text("");
        $('input.border').removeClass('border border-danger');
        $('.lblActionDesc').text('Creating Company');
        $('#frmCreateCompany')[0].reset();
    });

    //edit Function
    $(document).on('click', '#btnUpdateCompany', function(e) {
        formAction=2;
        $('span.error-text').text("");
        $('input.border').removeClass('border border-danger');
        CompanyID=$(this).val();
        $('.lblActionDesc').text('Updating Company');
        axios.get('/company/get_edit',{
            params: {
                CompanyID: CompanyID
              }
          })
        .then(function (response) {
            $(response.data.data).each(function(index, row) {
                $('#txtCompanyID').val(row.comp_id);
                $('#txtCompanyName').val(row.comp_name);
                $('#txtCompanyCode').val(row.comp_code);
                $('#txtCompanyColor').val(row.comp_color);
                // $('#txtCompanyLogo').val(row.wt_timecross);
            })
        })
        .catch(function (error) {
            dialog.alert({
                message: error
            });
        })
        .then(function () {});

    });

    $(document).on('click', '#btnSaveCompany', function(e) {
        var datas = $('#frmCreateCompany');
        var formData = new FormData($(datas)[0]);
        formData.append('formAction', formAction);
        formData.append('CompanyID', CompanyID);
        //create script
            axios.post('/company/create_update',formData)
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
                    $('#frmCreateCompany')[0].reset();
                    get_company();
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

    $(document).on('click', '#btnUpdatedDelete', function(e) {
        var id=$(this).val();

        axios.get('/company/delete',{
            params: {
                id: id
              }
          })
        .then(function (response) {
            dialog.alert({
                message: response.data.msg
            });
            get_company();

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
