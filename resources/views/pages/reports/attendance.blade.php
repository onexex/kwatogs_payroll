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
        <h4 class="text-secondary-800 m-0">Report / <label class="text-black">Attendance Viewer</label></h4>
    </div>

    <form  action='' id="frmSearch" class="">
        <div class="row pb-2   d-flex flex-wrap justify-content-between">
            <div class="col-lg-4 col-md-12">
                <div class="form-group fs-6 mb-2">
                    <label for="missionobjective" class="mb-1">Employee Name</label>
                    <select class="form-select text-capitalize" id="txtLastname" name="search">
                        <option class="" selected value="All">All</option>
                        @if(count($resultEmp)>0)
                            @foreach($resultEmp as $resultEmp)
                            <!--CONCAT-->
                            <option value='{{ $resultEmp->empID }}'>{{ $resultEmp->lname . ", " . $resultEmp->fname}}</option>
                            @endforeach
                        @else

                        @endif
                    </select>

                    <span class="text-danger small error-text  search_error"></span>
                </div>
            </div>

            <div class="col-auto">
                <div class="form-group mt-4 mb-0">
                    <div class="col-12 p-0 ">
                        <input type="date" id="txtDateFrom" name="txtDateFrom" value="{{ date("Y-m-d", strtotime("-7 days")) }}" class=" p-2 rounded border border-1 rptdatefrom">
                        <input type="date" id="txtDateTo" name="txtDateto" value="{{date('Y-m-d')}}" class=" p-2 rounded border border-1 rptdateto">

                        <button type="button" id="btn_rptprint" class="btn d-block float-right mr-1 radius-1 ml-1 text-white rptbtnprint" style="background-color: #008080"><i class="fa-solid fa-print fa-sm fa-fw text-white"></i> </button>
                        <button type="button" id="btn_rptrefresh" class="btn d-block float-right radius-1 ml-1 text-white rptbtnref" style="background-color: #008080"> <i class="font-weight-bold fa fa-refresh fa-sm fa-fw text-white"></i> </button>

                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- Content Row dar -->
    <div class="row px-2">
        <div class="card shadow">
            <div class="card-body" id="Report_thisPrint">
                    <label for="" class="d-none rptTitle fw-bold"> Report / <label class="text-black">Attendance Viewer</label></label>
                    <label for="" class="d-none rptDate"> Report Date: <label for="" class="rptDateRange"></label></label>
                    <label for="" class="d-none rptCaption"> </label>

                <div class="row">
                    <div class="table-responsive  overflow-auto-settings tblattend">
                        <table class="table table-hover ">
                            <thead class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Time-in</th>
                                <th scope="col">Time-out</th>
                                <th scope="col">Duration</th>
                            <tbody id="tbl_rptattendance" name="tbl_rptattendance" class="text-center">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


  <script src="{{ asset('js/reports/rptattendance.js') }}" defer></script>
@endsection
