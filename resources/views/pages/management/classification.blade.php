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
        <h4 class="text-secondary-800 m-0">Settings / <label class="text-black">Employment Classification </label></h4>
    </div>

    <div class="row pb-2">
        <div class="col-lg-4 col-md-12">
            <button type="button" class="btn btn-details mb-2" id="btnCreateClassification" title="Create Classification" data-bs-toggle="modal" data-bs-target="#mdlClassification" > Classification </button>
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
                                <th scope="col">#</th>
                                <th scope="col">Classification Code</th>
                                <th scope="col">Classification Description</th>
                                <th scope="col">Action</th>
                            <tbody id="tblClasification" class="text-center">

                            </tbody>
                       </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal Work Time -->
    <div class="modal fade" id="mdlClassification" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
        <div class="modal-dialog   modal-md ">
            <div class="modal-content">
                <div class="modal-header dragable_touch" >
                    <h5 class="modal-title" id="staticBackdropLabel"><label for="" class="lblActionDesc"> Classification</label></h5>
                    <button type="button" class="btn-close text-white closereset_update" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="card  mb-3 rounded">
                        <div class="card-body ">
                            <form action="" id="frmCreateClassification">
                                <div class="form-floating mb-1">
                                    <input class="form-control" id="txtClassificationCode" name="code" type="text"   />
                                    <label for="missionDesc">Classification Code <label for="" class="text-danger">*</label></label>
                                    <span class="text-danger small error-text code_error"></span>
                                </div>

                                <div class="form-floating mb-1">
                                    <input class="form-control" id="txtClassificationDesc" name="description" type="text"    />
                                    <label for="missionDesc">Classification Description<label for="" class="text-danger">*</label></label>
                                    <span class="text-danger small error-text description_error"></span>
                                </div>


                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary closereset_update" data-bs-dismiss="modal">Close</button> -->
                    <button  id="btnSaveClassification" type="button" class="btn btn-details">Save Entries</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/settings/classification.js') }}" defer></script>


</div>
@endsection
