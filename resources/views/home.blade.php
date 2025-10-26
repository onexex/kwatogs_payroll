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

    <!-- Page Heading -->
    <div class=" pb-2 d-sm-flex align-items-center justify-content-between">
        <h4 class=" mb-0">SHIFT MONITORING</h4>
    </div>

    <div class="row ">
        {{-- <div class="col-auto me-auto"></div> --}}
        <div class="col-auto">
            <div class="form-group">
                <div class="col-12 p-0">
                    <input type="date" id="txtDateFrom" name="txtDateFrom" value="{{ date("Y-m-d", strtotime("-10 days")) }}" class=" p-2 rounded border border-1">
                    <input type="date" id="txtDateTo" name="txtDateto" value="{{date('Y-m-d')}}" class=" p-2 rounded border border-1">
                    <button type="button" id="btnLogRef" class="btn d-block float-right mr-1 radius-1 ml-1 text-white" style="background-color: #008080"> <i class="font-weight-bold fa fa-refresh fa-sm fa-fw text-white"></i> </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Row lilo -->
    <div class="card shadow mb-3">
        <h5 class="px-4 pt-4 mb-0">ATTENDANCE LOG</h5>
        <div class="card-body ">
            <div class="row">
                <div class="table-responsive overflow-auto">
                    <table class="table table-hover">
                        <thead class="text-center">

                            <th class="text-dark" scope="col">Date</th>
                            <th class="text-dark" scope="col">Day</th>
                            <th class="text-dark" scope="col">Schedule</th>
                            <th class="text-dark" scope="col">Time In</th>
                            <th class="text-dark" scope="col">Time Out</th>
                            <th class="text-dark" scope="col">Type/Status</th>
                            <th class="text-dark" scope="col">Duration</th>

                        </thead>
                        <tbody id="tblAttendance" class="tbodyAttendance text-center">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class=" px-2">
            <button type="button" id="btnLogMdl" class="btn d-block float-right mr-0 radius-1 text-white" style="background-color: #008080" data-bs-toggle="modal" data-bs-target="#mdlLogin"> Loading ... </button>
             {{-- <button type="button" class="btn d-block float-right mr-0 radius-1 text-black" href="/login/testmoto"><i class="fa-solid fa-building pr-2"> </i>  Classification</button> --}}
        </div>
    </div>

    <!--LOGIN MODAL-->
    <div class="modal fade" id="mdlLogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Login to Cenar</h5>
                </div>
                <div class="modal-body"></div>
                    <h5 class="px-3 pb-3" id=""> You are about to Login, Continue? </h5>
                <div class="modal-footer">
                    <button type="button" id="btnLog" name="btnLog" class="btn px-4 btn-outline-secondary">Yes</button>
                    <button type="button" id="btnLogClose" name="btnLogClose" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

     <!--ALERT MODAL-->
    <div class="modal fade" id="mdlAlert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h4 class="modal-title" id="txtLog">Login</h4> --}}
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" id="frmAlert">
                        <div class="row p-1">

                            <div class="alert alert-danger" role="alert" id="txtAlertMdl">
                            You are successfully Login ..
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('js/home.js') }}"  deffer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>

@endsection
