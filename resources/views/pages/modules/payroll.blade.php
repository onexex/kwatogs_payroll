@extends('layout.app')
@section('content')

<div class="container-fluid">
    <div class="mb-2">
        <h4 class="text-gray-800 mb-3">Payroll System</h4>
        </div>

     <!-- Content Row dar -->
     <div class="row">
        <div class="col-lg-12 px-4">
            <!-- <div class="card  mb-4" > -->
                <!-- Card Body -->
                <!-- <div class="card-body"> -->
                    <div class="row p-2 border rounded" style="background-color: #ff00000a !important">
                        <div class="col-lg-3 mb-2 col-md-12">
                           <label for="missionTitle" class="fs-6 fw-bold text-danger  ">Payrol Date</label>
                            <div class="form-floating mb-1">
                                <input class="form-control" id="btnPayDate" name="pay_date" type="date" placeholder="Payroll Date" />
                                <label for="missionDesc">Payroll Date<label for="" class="text-danger">*</label></label>
                                <span class="text-danger small error-text pay_date_error"></span>
                            </div>
                            <button type="button" class="btn btn-danger" id="btnGenerate">Generate</button>
                            <button type="button" class="btn btn-secondary" id="btnRelease">Approve for Release</button>

                        </div>

                        <div class="col-lg-3 mb-2 col-md-12">
                            <label for="missionTitle" class="fs-6 fw-bold text-danger  ">Cut-off Dates</label>
                            <div class="form-floating mb-1">
                                <input class="form-control" id="dptFrom" name="date_from" type="date" placeholder="Date From" />
                                <label for="missionDesc">Date From<label for="" class="text-danger">*</label></label>
                                <span class="text-danger small error-text date_from_error"></span>
                            </div>

                            <div class="form-floating mb-1">
                                <input class="form-control" id="dptTo" name="date_to" type="date" placeholder="Date To" />
                                <label for="missionDesc">Date To<label for="" class="text-danger">*</label></label>
                                <span class="text-danger small error-text date_to_error"></span>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-2 col-md-12">
                            <label for="missionTitle" class="fs-6 fw-bold text-danger  ">Print & Display Filter</label>
                            <div class="form-floating mb-1">
                                <input class="form-control" id="selFilter" name="filter" type="date" placeholder="Payroll Filter" />
                                <label for="missionDesc">Payroll Filter<label for="" class="text-danger">*</label></label>
                                <span class="text-danger small error-text filter_error"></span>
                            </div>
                            <button type="button" class="btn btn-danger" id="btnPrint">Print</button>
                            <button type="button" class="btn btn-secondary" id="btnPayroll">Payroll</button>
                            <button type="button" class="btn btn-secondary" id="btnSummary">Summary</button>
                        </div>

                        <div class="col-lg-3 col-md-12">
                            <label for="missionTitle" class="fs-6 fw-bold text-danger  ">Adjustment</label> <br>
                            <button type="button" class="btn btn-secondary"  data-bs-toggle="modal" data-bs-target="#mdlAdjustment" id="btnAdjustment"><i class="fa fa-plus"></i> Adjustment </button>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="table-responsive"> 
                            <table class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th scope="col">Employee Name</th>
                                        <th scope="col">Basic</th>
                                        <th scope="col">AB/TRD</th>
                                        <th scope="col">OT</th>
                                        <th scope="col">Gross Pay</th>
                                        <th scope="col">SSS</th>
                                        <th scope="col">SSS Loan</th>
                                        <th scope="col">PH</th>
                                        <th scope="col">PI</th>
                                        <th scope="col">PI Loan</th>
                                        <th scope="col">Taxable Income</th>
                                        <th scope="col">Tax</th>
                                        <th scope="col">Netpay</th>
                                        <th scope="col">Allowance</th>
                                        <th scope="col">Adjustment</th>
                                        <th scope="col">Adjustment 2</th>
                                        <th scope="col">Pay Receivable</th>
                                    </tr>
                                </thead>
                                <tbody id="lblICE">
                                    
                                </tbody>
                            </table>                                        
                        </div>
                    </div>
{{-- 
                    <div class="row p-2">
                        <div class="col-lg-6">
                            Prepared By: <br>
                            WeDo Payroll Management System <br>
                            Date/Time Printed: <label for=""> October 4,2022 11:12:59 AM</label>
                        </div>
                        <div class="col-lg-6 d-block ">
                            <label class=" float-right" for="">Approved for Release by:</label><br><br><br>
                            <label  class="float-right" for="">Jomod A. Ferrer - General Manage</label>
                        </div>
                    </div> --}}

                <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>

     <!-- modal adjustment -->
     <div class="modal fade" id="mdlAdjustment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
        <div class="modal-dialog modal-xl ">
            <div class="modal-content">
                <div class="modal-header bg-danger  dragable_touch" >
                    <h5 class="modal-title fst-italic text-white" id="staticBackdropLabel"><label for="" class="lblActionDesc"> Adjustment</label></h5>
                    <button type="button" class="btn-close text-white closereset_update" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">                                                  
                    <div class="card  mb-3 rounded">
                        <div class="card-body "> 

                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-floating mb-1">
                                      

                                        <select  class="form-control" name="employee" id="selEmployee"  >      
                                            <option value="0">No</option>                                                                                                         
                                            <option value="1">Yes</option>                                                                                                         
                                        </select>
                                        <label for="missionDesc">Classification Code <label for="" class="text-danger">*</label></label>
                                        <span class="text-danger small error-text employee_error"></span>
                                    </div>
                                </div> 
                                <div class="col-lg-3  col-md-6">
                                    <div class="form-floating mb-1">
                                        <input class="form-control" id="txtAmount" name="amount" type="text"   />
                                        <label for="missionDesc">Classification Code <label for="" class="text-danger">*</label></label>
                                        <span class="text-danger small error-text amount_error"></span>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3">
                                    <button type="button" class="btn btn-secondary"  id="btnSaveAdjustment"><i class="fa fa-plus"></i> Save </button>
                                </div>

                               
                            </div>
                            <div class="row pt-3">
                                <div class="table-responsive"> 
                                    <table class="table table-hover ">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Employee</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Acion</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblAdjustment">
                                            
                                        </tbody>
                                    </table>                                        
                                </div>
                            </div>
                        </div>                                      
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary closereset_update" data-bs-dismiss="modal">Close</button> -->
                    <button  id="btnSaveClassification" type="button" class="btn btn-secondary ">Save Entries</button>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection    