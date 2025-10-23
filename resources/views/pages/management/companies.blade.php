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

<div class="container-fluid">

    <div class="pb-2">
        <h4 class="text-secondary-800 m-0">Settings / <label class="text-black">Companies</label></h4>
    </div>

    <div class="row pb-2">
        <div class="col-lg-4 col-md-12">
            <button type="button" class="btn btn-details mb-2" id="createCompany"  title="Company" data-bs-toggle="modal" data-bs-target="#mdlCompany" > Companies </button>
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
                                <th scope="col">ID</th>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Color</th>
                                <th scope="col">Action</th>
                            <tbody id="tblCompanies" class="text-center">

                            </tbody>
                       </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal Create Company -->
    <div class="modal fade" id="mdlCompany" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header dragable_touch" >
                    <h5 class="modal-title" id="staticBackdropLabel"><label class="lblActionDesc" for=""> Create Company</label></h5>
                    <button type="button" class="btn-close text-white closereset_update" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="card  mb-3 rounded">
                        <div class="card-body ">
                            <form action="" id="frmCreateCompany">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-1">
                                            <input class="form-control" id="txtCompanyID" name="companyid" type="text"   />
                                            <label for="missionDesc">Company ID <label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text companyid_error"></span>
                                        </div>
                                        <div class="form-floating mb-1">
                                            <input class="form-control" id="txtCompanyName" name="company" type="text"   />
                                            <label for="missionDesc">Company Name <label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text company_error"></span>
                                        </div>
                                        <div class="form-floating mb-1">
                                            <input class="form-control" id="txtCompanyCode" name="code" type="text"   />
                                            <label for="missionDesc">Company Code <label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text code_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-1">
                                            <input class="form-control" id="txtCompanyColor" name="color" type="color"   />
                                            <label for="missionDesc">Color <label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text color_error"></span>
                                        </div>
                                        <div class="form-floating mb-1">
                                            <input class="form-control" id="txtCompanyLogo" name="logo" type="file"   />
                                            <label for="missionDesc">File <label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text color_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button  id="btnSaveCompany" type="button" class="btn btn-details">Save Entries</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/settings/company.js') }}" defer></script>
@endsection
