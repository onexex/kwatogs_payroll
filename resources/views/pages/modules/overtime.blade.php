@extends('layout.app')
@section('content')

<!--SHAIRA-->
<div class="container-fluid">

    <div class="mb-2">
        <h4 class=" mb-0 text-gray-800">Overtime Filing System</h4>
        <button class=" mt-3 btn text-white" style="background-color: #008080" name="btnCreateOTModal" id="btnCreateOTModal" data-bs-toggle="modal" data-bs-target="#mdlOvertime"> <i class="fa fa-plus"></i> Overtime Filing Form</button>
    </div>

    <!-- Page Heading -->
    {{-- <div class="d-sm-">
        <h4 class=" mb-0 text-gray-800">Official Business Trip Tracker</h4>
        <button class=" mt-3 btn btn-danger radius-1 btn-sm" name="department" id="btnCreateDept" data-bs-toggle="modal" data-bs-target="#mdlDepartment"> <i class="fa fa-plus"></i> Official Business Trip Form</button>

        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report </a> -->
    </div> --}}

    <div class="row">
        <div class="col-auto me-auto"></div>
        <div class="col-auto">
            <!-- <h5 class=" mb-0 text-danger">Filter:</h5>    -->
            <input type="date" id="txtDateFromTop" class=" p-2 rounded border border-1">
            <input type="date" id="txtDateToTop" class=" p-2 rounded border border-1">
        </div>
    </div>
       <!-- Content Row lilo -->
    <div class="row mt-2">
        <div class="col-xl-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-secondary">Overtime History</h6>
                    <button class="btn radius-1" name="btnRefreshTbl" id="btnRefreshTbl"><i class="font-weight-bold fa fa-refresh fa-sm fa-fw" style="color: #008080"></i></button>
                     {{--<i class="font-weight-bold fa fa-refresh fa-sm fa-fw text-danger"></i> --}}
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <div class="table-responsive border-0">
                            <table class="table table-hover table-border-none  ">
                                <thead>
                                    <tr>
                                        <th class="text-dark" scope="col">No</th>
                                        <th class="text-dark" scope="col">FilingDateTime</th>
                                        <th class="text-dark" scope="col">TimeIn</th>
                                        <th class="text-dark" scope="col">TimeOut</th>
                                        <th class="text-dark" scope="col">Purpose</th>
                                        <th class="text-dark" scope="col">Duration</th>
                                        <th class="text-dark" scope="col">Status</th>
                                        <th class="text-dark" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tblOvertime">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

      <!-- Modal OVERTIME Form-->
      <div class="modal fade" id="mdlOvertime" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header dragable_touch" >
                    <h5 class="modal-title" id="staticBackdropLabel"><label for="" class="" id="lblTitleOBT"> Overtime Filing Form</label></h5>
                    <button type="button" class="btn-close text-white closereset_update" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3 rounded">
                        <div class="card-body ">

                            <form action="" id="frmOvertimeForm">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12 ">
                                                <div class="form-group mb-1">
                                                    <label class="form-check-label mb-0" for="txtPersonnel">Personnel Name <label for="" class="text-danger mb-0">*</label></label>
                                                    <input class="form-control" id="txtPersonnel" name="personnel" type="text" placeholder="-" readonly/>

                                                    <span class="text-danger small error-text personnel_error"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group mb-1">
                                                    <label class="form-check-label mb-0" for="txtCompany">Company Name <label for="" class="text-danger mb-0">*</label></label>
                                                    <input class="form-control" id="txtCompany" name="company" type="text" placeholder="-" readonly/>

                                                    <span class="text-danger small error-text company_error"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group mb-1">
                                                    <label class="form-check-label mb-0" for="txtDepartment">Department<label for="" class="text-danger mb-0">*</label></label>
                                                    <input class="form-control" id="txtDepartment" name="department" type="text" placeholder="-" readonly/>

                                                    <span class="text-danger small error-text department_error"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group mb-1">
                                                    <label class="form-check-label mb-0" for="txtDesignation">Designation<label for="" class="text-danger mb-0">*</label></label>
                                                    <input class="form-control" id="txtDesignation" name="designation" type="text" placeholder="-" readonly/>

                                                    <span class="text-danger small error-text designation_error"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group mb-1">
                                                    <label class="form-check-label mb-0" for="txtPurposeRem"> Purpose <label for="" class="text-danger mb-0"></label></label>
                                                    <textarea class="form-control" id="txtPurposeRem" name="purpose" rows="4" placeholder="-" style="height: 100px"></textarea>
                                                    <span class="text-danger small error-text purpose_error"></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-check-label mb-0" for="txtFilingDate">Filing Date<label for="" class="text-danger mb-0">*</label></label>
                                                    <input class="form-control" id="txtFilingDate" name="dateFil" type="date" placeholder="-" readonly/>

                                                    <span class="text-danger small error-text dateFil_error"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-check-label mb-0" for="txtFilingTime">filing Time<label for="" class="text-danger mb-0">*</label></label>
                                                    <input class="form-control" id="txtFilingTime" name="timeFil" type="time" placeholder="-" readonly/>

                                                    <span class="text-danger small error-text timeFil_error"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-check-label mb-0" for="txtOTDateFrom">OT Date From<label for="" class="text-danger mb-0">*</label></label>
                                                    <input class="form-control" id="txtOTDateFrom" name="dateFrom" type="date" placeholder="-"/>

                                                    <span class="text-danger small error-text dateFrom_error"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-check-label mb-0" for="txtOTTimeFrom">OT Time From<label for="" class="text-danger mb-0">*</label></label>
                                                    <input class="form-control" id="txtOTTimeFrom" name="timeFrom" type="time" placeholder="-"/>

                                                    <span class="text-danger small error-text timeFrom_error"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-check-label mb-0" for="txtOTDateTo">OT Date To<label for="" class="text-danger mb-0">*</label></label>
                                                    <input class="form-control" id="txtOTDateTo" name="dateTo" type="date" placeholder="-"/>

                                                    <span class="text-danger small error-text dateTo_error"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-check-label mb-0" for="txtOTTimeTo">OT Time To<label for="" class="text-danger mb-0">*</label></label>
                                                    <input class="form-control" id="txtOTTimeTo" name="timeTo" type="time" placeholder="-"/>

                                                    <span class="text-danger small error-text timeTo_error"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary closereset_update" data-bs-dismiss="modal">Close</button> -->
                    <button  id="btnSaveOT" type="button" class="btn text-white" style="background-color: #008080">Submit</button>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection
