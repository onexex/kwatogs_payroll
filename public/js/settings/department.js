$(document).ready(function() {
    var formAction=0;
    var depID=0;
    department_get();

    function department_get(){
        axios.get('/department/getall')
        .then(function (response) {
            var htmlData='';
            $(response.data.data).each(function(index, row) {
                htmlData += "<tr>" +
                            "<td class='text-uppercase'>" + row.dep_name +  "</td>" ;

                htmlData +="<td >" +  '<button type="button" value='+ row.id +' class="btn btn-details btn-sm" data-toggle="tooltip" data-placement="bottom"  id="btnUpdateDepartment" data-bs-toggle="modal" data-bs-target="#mdlDepartment" > <i class="fa fa-pencil"></i> </button></td>' ;
                htmlData += "</tr>";
            })
            $("#tblDepartments").empty().append(htmlData);

        })
        .catch(function (error) {
            dialog.alert({
                message: error
            });
        })
        .then(function () {});
    }

    //create Function
    $(document).on('click', '#btnCreateDept', function(e) {
        formAction=1;
        $('.lblActionDesc').text('Creating Department');
        $('span.error-text').text("");
        $('input.border').removeClass('border border-danger');
        $('#frmDepartment')[0].reset();
    });

    //edit Function
    $(document).on('click', '#btnUpdateDepartment', function(e) {

        formAction=2;
        depID=$(this).val();
        $('.lblActionDesc').text('Updating Department');
        axios.get('/department/edit',{
            params: {
                depID: depID
              }
          })
        .then(function (response) {
            $(response.data.data).each(function(index, row) {
                $('span.error-text').text("");
                $('input.border').removeClass('border border-danger');
                $('#txtDeptName').val(row.dep_name);

            })
        })
        .catch(function (error) {
            dialog.alert({
                message: error
            });
        })
        .then(function () {});

    });

    $(document).on('click', '#btnDepSave', function(e) {
        var datas = $('#frmDepartment');
        var formData = new FormData($(datas)[0]);
        formData.append('formAction', formAction);
        formData.append('depID', depID);
        //create script
            axios.post('/department/create_update',formData)
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
                    $('#frmDepartment')[0].reset();
                    department_get();
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
