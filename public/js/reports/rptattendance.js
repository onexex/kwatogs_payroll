$(document).ready(function() {

    ///SEARCH
    $(document).on('click', '#btn_rptrefresh', function(e) {
        var empSearch=$('#txtLastname').val(); //inputbox//
        var startd=$('#txtDateFrom').val(); //inputbox//
        var endd=$('#txtDateTo').val(); //inputbox//

            axios.get('/task/search',{
                params: {
                    empSearch: empSearch,
                    startd:startd,
                    endd:endd
                }
            })
            .then(function (response) {
                var htmlData = '';
                var i = 1;
                $(response.data.data).each(function(index, row) {
                    htmlData +=
                        "<tr><td >" + i++ + "</td>" +
                        "<td class='text-capitalize'>" + row.lname + ", " + row.fname +"</td>" +
                        "<td class='text-capitalize' >" + row.timein + "</td>" +
                        "<td class='text-capitalize' >" + row.timeout + "</td>" +
                        "<td class='text-capitalize' >" + row.durationtime + "</td>" ;
                        htmlData +="</tr>";
                });
                $("#tbl_rptattendance").empty().append(htmlData);

            })
            .catch(function (error) {
            })
            .then(function () {});
    });


     //PRINT BTN
    $(document).on('click', '#btn_rptprint', function(e){

        var originalContents = document.body.innerHTML;

        var datefrom = $("#txtDateFrom").val();
        var dateto = $("#txtDateTo").val();
        var datedata=$("#txtDateFrom").val() + " To : " + $("#txtDateTo").val();

        var emp = $("#txtLastname").val();
        var empSelect = $("#txtLastname option:selected").text();

        $(".tblattend").removeClass("overflow-auto-settings");

        $(".rptbtnprint").hide();
        $(".rptbtnref").hide();

        $(".rptCaption").html(empSelect);
        $(".rptCaption").removeClass("d-none").addClass("d-block");

        $(".rptDateRange").html(datedata);
        $(".rptDateRange").css("padding", "12px");

        $(".rptTitle").removeClass("d-none").addClass("d-block");
        $(".rptDate").removeClass("d-none").addClass("d-block");

        $("#tbl_rptattendance td").css("padding", "14px");
        $("#tbl_rptattendance td").css("font-size", "14px");
        $(".tblattend").css("font-size", "14px");

        var printContents = document.getElementById('Report_thisPrint').innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        $("txtDateTo").val(dateto);
        $("txtDateFrom").val(datefrom);
        $("txtLastname").val(emp);


    })


});
