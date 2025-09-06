$(document).ready(function() {
var empSID= "0";
var dateID="";
var IDinserted= "0";
// getall();
// getalltime()

//create_update
$(document).on('click', '#btnSaveScheduler', function() {
    var datas = $('#frmEmpScheduler');
    var formData = new FormData($(datas)[0]);
    formData.append('empSID', empSID);
    formData.append('IDinserted', IDinserted);

    axios.post('/scheduler/create_update', formData)
        .then(function(response) {
            console.log(formData)

            var statusU=response.data.stat;
            var errorDataU = response.data.error;



            if(statusU=='201'){
                $.each(errorDataU, function(prefix, val) {
                    // $('span.' + prefix + '_error').text(val[0]);
                     $('span.' + prefix + '_error').text("This field is required!");
                     $('#' + prefix ).addClass('border border-danger');
                });

                dialog.alert({
                    // title: "Message",
                    message: "Some fields are required!",
                    animation: "slide"
                });

            }else if(statusU==200){
                // getall();
                // $("#frmOBVal")[0].reset()
                $('span.error-text').text("");
                $('select.border').removeClass('border border-danger');
                $('input.border').removeClass('border border-danger');

                // $("#txtSearchEmp").trigger('keyup');

                // $('#frmOBVal').modal('toggle');

                dialog.alert({
                    message:response.data.msg
                })
            }else if(statusU==199){
                $('span.error-text').text("");
                $('select.border').removeClass('border border-danger');
                $('input.border').removeClass('border border-danger');

                dialog.alert({
                    message: response.data.msg,
                });
            }
        })
        .catch(function(error) {
            dialog.alert({
                message: error
            });
        })
        .then(function() {});
})

//get
function getall(){
    axios.get('/scheduler/getall')
    .then(function (response) {
        var htmlData='';
        // var i=1;
        $(response.data.data).each(function(index, row) {
            htmlData += "<tr>"+

            // "<td>" + i++ + "</td>" +
            "<td>" + row.lname + ", " + row.fname + "</td>" +
            "<td>" + row.dFrom + "</td>" +
            "<td>" + row.dTo + "</td>" ,

            htmlData +="<td >" +  '<button type="button" value='+ row.id +' class="btn btn-details btn-sm radius-1 mx-1" id="btnViewModel" data-bs-toggle="modal" data-bs-target="#mdlViewModel"> <i class="fa-regular fa-clock"></i> </button>'   ;
            htmlData += '<button type="button" value='+ row.id +' class="btn btn-details btn-sm radius-1 mx-1" id="btnUpdateModal" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#mdlUpdateEffect"> <i class="fa-regular fa-calendar"></i> </button>'  + "</td>" ;
            htmlData += "</tr>";
        })
        $("#tblEmpScheduler").empty().append(htmlData);

    })
    .catch(function (error) {
        dialog.alert({
            message: error
        });
    })
    .then(function () {});
}

//getmodaltime
//  function getalltime(){
$(document).on('click', '#btnViewModel', function() {
    empSID = $(this).val();

    axios.get('/scheduler/getall_time', {
            params: {
                empSID: empSID
            }
        })
        .then(function(response) {
            console.log(response.data.dataT)
            var htmlData = '';

            $(response.data.dataT).each(function(index, row) {

                htmlData += "<tr>" +
                        "<td>" + row.days + "</td>" +
                        // "<td>" + row.wtID + "</td>" ,
                        "<td class='" + 'cel' + row.ids + "'>" + row.wt_timefrom + " - " + row.wt_timeto + "</td>";
                htmlData +="<td > <button type='button' value='"+ row.ids +"' class='btn btn-details btn-sm radius-1 mx-1' id='btnUpdateView' > <i class='fa-solid fa-pen'></i> </td>"   ;

                htmlData += "</tr>";
            })

        $("#tblScheduler").empty().append(htmlData);

        })
        .catch(function (error) {
            dialog.alert({
                message: error
            });
        })
        .then(function () {});
})


///edit time
$(document).on('click', '#btnUpdateView', function(e) {
    var id =$(this).val();
    empSID=id;

    $("#mdlUpdateTime").modal('show');



    $('span.error-text').text("");
    $('input.border').removeClass('border border-danger');

    axios.get('/scheduler/edit_time',{
        params: {
            empSID: empSID
            }
        })
    .then(function (response) {

        $(response.data.data).each(function(index, row) {
            $('#selWTime').val(row.wtID);
            $("#btnUpdateView").val(row.id);
        })
    })
    .catch(function (error) {
        dialog.alert({
            message: error
        });
    })
    .then(function () {});

});

//UPDATE SCHED TIME
$(document).on('click', '#btnUpdateTime', function() {
    var datas = $('#frmUpdateTime');
    var formData = new FormData($(datas)[0]);
    formData.append('empSID', empSID);

    var selTimeText = $("#selWTime option:selected").text();

    axios.post('/scheduler/update_time', formData)
        .then(function(response) {
            var statusU=response.data.stat;
            var errorDataU = response.data.error;

            if(statusU=='201'){
                $.each(errorDataU, function(prefix, val) {
                     $('span.' + prefix + '_error').text("This field is required!");
                     $('#' + prefix ).addClass('border border-danger');
                });
                dialog.alert({
                    // title: "Message",
                    message: "Some fields are required!",
                    animation: "slide"
                });

            }else if(statusU==200){
                // getall();
                // getalltime()
                // $("#frmOBVal")[0].reset()
                $('span.error-text').text("");
                $('select.border').removeClass('border border-danger');
                $('input.border').removeClass('border border-danger');

                $("#txtSearchEmp").trigger('keyup');


                // $('#frmOBVal').modal('toggle');
                 $(".cel" + empSID).text(selTimeText);
                dialog.alert({
                    message: "Successfully Updated!",
                })
            }else if(statusU==202){
                $('span.error-text').text("");
                $('select.border').removeClass('border border-danger');
                $('input.border').removeClass('border border-danger');

                dialog.alert({
                    message: "Error!",
                });
            }
            // alert(empSID);
            console.log(response);
        })
        .catch(function(error) {
            dialog.alert({
                message: error
            });
        })
        .then(function() {});
})

  //edit date
  $(document).on('click', '#btnUpdateModal', function(e) {
    empSID=$(this).val();

    $('span.error-text').text("");
    $('input.border').removeClass('border border-danger');

    axios.get('/scheduler/edit_date',{
        params: {
            empSID: empSID
            }
        })
    .then(function (response) {

        $(response.data.data).each(function(index, row) {
            $('#txtDateFromU').val(row.dFrom);
            $('#txtDatetoU').val(row.dTo);
            $("#btnUpdateModal").val(row.id);
        })
    })
    .catch(function (error) {
        dialog.alert({
            message: error
        });
    })
    .then(function () {});

});

//updatedate
$(document).on('click', '#btnUpdateEffect', function() {
    var id = empSID;


    var dataA = $('#frmUpdateDate');
    var formData = new FormData($(dataA)[0]);
    formData.append('id', id);

    axios.post('/scheduler/update_date', formData)
        .then(function(response) {

            var statusU=response.data.stat;
            var errorDataU = response.data.error;

            // console.log(response.data.msg);
            //  return;

            if(statusU=='201'){
                //show error on input kung walang laman
                $.each(errorDataU, function(prefix, val) {
                     $('span.' + prefix + '_error').text("This field is required!");
                     $('#' + prefix ).addClass('border border-danger');

                });

            }else if(statusU==200){
                //created msg
                // alert(response.data.msg);
                // getalltime()
                // getall();
                $('select.border').removeClass('border border-danger');
                $('input.border').removeClass('border border-danger');

                $("#txtSearchEmp").trigger('keyup');

                dialog.alert({
                    message: "Data successfully updated!",
                    animation: "slide"
                });

           }else if(statusU==199){
                $('span.error-text').text("");
                $('select.border').removeClass('border border-danger');
                $('input.border').removeClass('border border-danger');

                dialog.alert({
                    message: response.data.msg,
                    animation: "slide"
                });
            }
            else{
                dialog.alert({
                    message: "Error!"
                });
            }

        })
        .catch(function(error) {
            alert(error);
        })
        .then(function() {});
})

//search
$(document).on('keyup', '#txtSearchEmp', function(e) {
    var htmlData='';
    if($(this).val()===""){
         $("#tblEmpScheduler").empty();
        return;
    }
    var datas = $('#frmSearch');
    var formData = new FormData($(datas)[0]);
        axios.post('/scheduler/search',formData)
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

                $(response.data.data).each(function(index, row) {
                    htmlData += "<tr>"+

                    "<td class='text-capitalize'>" + row.lname + ", " + row.fname + "</td>" +
                    "<td>" + row.dFrom + "</td>" +
                    "<td>" + row.dTo + "</td>" ,

                    htmlData +="<td >" +  '<button type="button" value='+ row.id +' class="btn btn-details btn-sm radius-1 mx-1" id="btnViewModel" data-bs-toggle="modal" data-bs-target="#mdlViewModel"> <i class="fa-regular fa-clock"></i> </button>'   ;
                    htmlData += '<button type="button" value='+ row.id +' class="btn btn-details btn-sm radius-1 mx-1" id="btnUpdateModal" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#mdlUpdateEffect"> <i class="fa-regular fa-calendar"></i> </button>'  + "</td>" ;
                    htmlData += "</tr>";
                })
                $("#tblEmpScheduler").empty().append(htmlData);
            }

            if(response.data.status == 199){
                $('span.error-text').text("");
                $('input.border').removeClass('border border-danger');
                    htmlData += "<tr>" +
                                "<td class='text-lowercase'> Result not found</td>" +
                                "<td class='text-lowercase'> </td>" ;
                     htmlData += "</tr>";

                $("#tblEmpScheduler").empty().append(htmlData);

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

$(document).on('click', '#closeEmpSched', function() {
    $('span.error-text').text("");
    $('select.border').removeClass('border border-danger');
    $('input.border').removeClass('border border-danger');
    $("#frmEmpScheduler")[0].reset()
})


})
