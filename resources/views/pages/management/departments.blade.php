@extends('layout.app')
@section('content')

<style>
    .table thead th {
        position:sticky !important;
        top: 0;
        background-color: #f8f9fa;
        z-index: 10;
    }
</style>


<!--SHAIRA-->

<div class="container-fluid">

    <div class="pb-2">
        <h4 class="text-secondary-800 m-0">Settings / <label class="text-black">Department </label></h4>
    </div>

    <div class="row pb-2">
        <div class="col-lg-4 col-md-12">
            <button type="button" class="btn btn-details mb-2" name="department" id="btnCreateDept" data-bs-toggle="modal" data-bs-target="#mdlDepartment"> Department </button>
        </div>
    </div>

    <!-- Content Row dar -->
    <div class="row px-2">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive overflow-auto-settings">
                        <table class="table table-hover">
                            <thead class="text-center">
                                <th class="text-dark" scope="col">Department Name</th>
                                <th class="text-dark" scope="col">Action</th>
                            <tbody id="tblDepartments" class="text-center">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Department -->
    <div class="modal fade" id="mdlDepartment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header dragable_touch" >
                    <h5 class="modal-title lblActionDesc" id="staticBackdropLabel"><label for="" class="" id="lblTitleDept"> Department</label></h5>
                    <button type="button" class="btn-close text-white closereset_update" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3 rounded">
                        <div class="card-body ">

                            <form action="" id="frmDepartment">
                                <div class="row">
                                    <div class="col-lg-12 mb-1">
                                        <div class="form-floating">
                                            <input class="form-control" id="txtDeptName" name="department" type="text" placeholder="-"/>
                                            <label class="form-check-label" for="missionDesc">Department Name <label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text department_error"></span>
                                        </div>
                                    </div>

                                    <!-- <div class="col-xl-6 col-lg-12">
                                        <div class="form-floating mb-2 fs-6">
                                            <select  class="form-control" name="company" id="selCompany">
                                                <option value="0">WeDo BPO Inc.</option>
                                            </select>
                                            <label  class="form-check-label" for="missionobjective" class="text-muted">Company<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text company_error"></span>
                                        </div>
                                    </div> -->
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary closereset_update" data-bs-dismiss="modal">Close</button> -->
                    <button  id="btnDepSave" type="button" class="btn btn-details">Save Entries</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('js/settings/department.js') }}"  deffer></script>

@endsection

