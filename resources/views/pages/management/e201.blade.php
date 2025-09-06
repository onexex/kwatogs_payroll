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
        <h4 class="text-secondary-800 m-0">Settings / <label class="text-black">e-201 Document</label></h4>
    </div>

    <div class="row pb-2">
        <div class="col-lg-4 col-md-12">
             <form  action='' id="frmFullname" class="mb-2">
                <div class="form-group fs-6 mb-2">
                    <label for="missionobjective" class="mb-1">Employee Name</label>
                     <select class="form-select" id="txtLastname" name="search">
                        <option selected>-</option>
                        @if(count($resultUser)>0)
                            @foreach($resultUser as $resultUsers)
                            <!--CONCAT-->
                            <option value='{{ $resultUsers->empID }}'>{{ $resultUsers->lname . " " . $resultUsers->fname}}</option>
                            @endforeach
                        @else

                        @endif
                    </select>

                    <span class="text-danger small error-text  search_error"></span>
                </div>
            </form>
            <button class=" mb-2 btn btn-details" id="btnAddDocument" title="Add document" data-bs-toggle="modal" data-bs-target="#mdlE201" >e-201 Document</button>
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
                                        <th scope="col">Filename</th>
                                        <th scope="col">Action</th>
                            <tbody id="tblE201" class="text-center">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal Create E201 -->
    <div class="modal fade" id="mdlE201" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header dragable_touch" >
                    <h5 class="modal-title" id="staticBackdropLabel"><label for=""> e-201 Document</label></h5>
                    <button type="button" class="btn-close text-white closereset_update" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="card  mb-3 rounded">
                        <div class="card-body ">
                            <form action="" id="frmE201">
                                <div class="form-floating mb-2">
                                    <input class="form-control" id="txtFilename" name="name" type="text"   />
                                    <label for="missionDesc">File Name <label for="" class="text-danger">*</label></label>
                                    <span class="text-danger small error-text name_error"></span>
                                </div>

                                <div class="form-group mb-2">
                                    <div class="frame">
                                        <input class="form-control" id="txtFile" name="file" type="file" required />
                                        <span class="text-danger small error-text file_error"></span>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary closereset_update" data-bs-dismiss="modal">Close</button> -->
                    <button  id="btnSaveFile" type="button" class="btn btn-details">Save Entries</button>
                </div>
            </div>
        </div>
    </div>
</div>


  <script src="{{ asset('js/settings/e201.js') }}" defer></script>
@endsection
