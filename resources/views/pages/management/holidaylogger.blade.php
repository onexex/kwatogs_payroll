@extends('layout.app')
@section('content')

<!--SHAIRA-->

<div class="container-fluid">
    <div class="mb-2">
        <h4 class="text-gray-800 mb-3">Holiday Logger</h4>
        <button class=" mt-3 btn btn-details radius-1" name="btnCreateHoliday" id="btnCreateHoliday" data-bs-toggle="modal" data-bs-target="#mdlHoliday"> <i class="fa fa-plus"></i> Holiday</button>
    </div>

     <!-- Content Row dar -->
     <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card mb-4">
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area overflow-auto">
                        <div class="table-responsive fixTableHead">
                            <table class="table table-hover table-scroll sticky">
                                <thead style="background-color: #f1f1f1; ">
                                    <tr>
                                        <th class="text-dark" scope="col">Date</th>
                                        <th class="text-dark" scope="col">Type</th>
                                        <th class="text-dark" scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody id="tblHolidaysLog">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Holiday Logger -->
    <div class="modal fade" id="mdlHoliday" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header dragable_touch" >
                    <h5 class="modal-title" id="staticBackdropLabel"><label for="" class="" id="lblTitleHoliday"> Holiday Logger</label></h5>
                    <button type="button" class="btn-close text-white closereset_update" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="card rounded">
                        <div class="card-body ">

                            <form action="" id="frmHoliday">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <div class="form-floating mb-2">
                                            <input class="form-control" id="txtDate" name="date" type="date" placeholder="-"/>
                                            <label class="form-check-label" for="missionDesc">Date <label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text date_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <div class="form-floating mb-2">
                                            <input class="form-control" id="txtDescription" name="description" type="text" placeholder="-"/>
                                            <label class="form-check-label" for="txtDescription">Description <label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text description_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-12">
                                        <div class="form-floating mb-2 fs-6">
                                            <select  class="form-control" name="type" id="selTypeHoliday"  >
                                                <option value="0">Regular Holiday</option>
                                                <option value="1">Special Holiday</option>
                                            </select>
                                            <label  class="form-check-label" for="selTypeHoliday" class="text-muted">Type<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text type_error"></span>
                                        </div>
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary closereset_update" data-bs-dismiss="modal">Close</button> -->
                    <button  id="btnSaveHoliday" type="button" class="btn btn-details">Create</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('js/settings/holidaylogger.js') }}"  deffer></script>

@endsection

