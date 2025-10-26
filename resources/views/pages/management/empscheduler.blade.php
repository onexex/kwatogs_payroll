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
        <h4 class="text-secondary-800 m-0">Settings / <label class="text-black">Scheduling Module</label></h4>
    </div>

    <div class="row pb-2">
        <div class="col-lg-4 col-md-12">
            <button class=" mb-2 btn btn-details" name="btnCreateModal" id="btnCreateModal" data-bs-toggle="modal" data-bs-target="#mdlEmpScheduler">Add Schedule</button>

            <form  action='' id="frmSearch" class="mb-2">
                <div class="input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Search..."
                        aria-label="Search..."
                        aria-describedby="basic-addon-search31"
                        name="searchEmp"
                        id="txtSearchEmp"
                    />
                </div>
            </form>
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
                                <th class="text-dark" scope="col">Name</th>
                                <th class="text-dark" scope="col">From</th>
                                <th class="text-dark" scope="col">To</th>
                                <th class="text-dark" scope="col">Action</th>
                            </thead>
                            <tbody id="tblEmpScheduler" class="text-center">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
     </div>

    <!-- Modal Employee Schedule -->
    <div class="modal fade" id="mdlEmpScheduler" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header dragable_touch" >
                    <h5 class="modal-title" id="staticBackdropLabel"><label for="" class="" id="lblTitleSched"> Employee Schedulling</label></h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close" id="closeEmpSched"></button>
                </div>
                <div class="modal-body">
                    <div class="card rounded p-2">
                        <div class="card-body">

                            <form action="" id="frmEmpScheduler">

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 px-2">
                                        <div class="form-group fs-6 mb-2">
                                            <label for="missionobjective" class="mb-1">Employee Name<label for="" class="text-danger mb-0">*</label></label>
                                            <select class="form-select text-capitalize" id="selEmployee" name="employee">
                                                <option selected></option>
                                                @if(count($resultES)>0)
                                                    @foreach($resultES as $resultESs)
                                                                                                        <!--CONCAT-->
                                                    <option value='{{ $resultESs->empID }}'>{{ $resultESs->lname . ", " . $resultESs->fname}}</option>
                                                    @endforeach
                                                @else

                                                @endif
                                            </select>

                                            <span class="text-danger small error-text employee_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label for="missionDesc" class="mb-0">Effectivity From<label for="" class="text-danger mb-0">*</label></label>
                                            <input class="form-control" id="txtDateFrom" name="dateFrom" type="date" placeholder=""   />
                                            <span class="text-danger small error-text dateFrom_error"></span>
                                        </div>

                                        {{-- <div class="form-floating">
                                            <input class="form-control" id="txtDateFrom" name="dateFrom" type="date" placeholder="-"/>
                                            <label class="form-check-label" for="txtDateFrom">Efffectivity From<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text dateFrom_error"></span>
                                        </div> --}}
                                    </div>

                                    <div class="col-lg-6 col-md-12 mb-2">
                                        <div class="form-group mb-2">
                                            <label for="missionDesc" class="mb-0">Effectivity To<label for="" class="text-danger mb-0">*</label></label>
                                            <input class="form-control" id="txtDateto" name="dateTo" type="date" placeholder=""   />
                                            <span class="text-danger small error-text dateTo_error"></span>
                                        </div>

                                        {{-- <div class="form-floating">
                                            <input class="form-control" id="txtDateto" name="dateTo" type="date" placeholder="-"/>
                                            <label class="form-check-label" for="missionDesc">Effectivity To<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text dateTo_error"></span>
                                        </div> --}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group fs-6 mb-1">
                                            <label for="missionobjective" class="mb-1">Monday<label for="" class="text-danger mb-0">*</label></label>
                                            <select class="form-select" id="selMon" name="monday">
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <!--CONCAT and DATE FORMAT-->
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                @endif
                                            </select>
                                           <span class="text-danger small error-text monday_error"></span>
                                        </div>

                                        {{-- <div class="form-floating">
                                            <select class="form-select" id="selMon" name="monday">
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <!--CONCAT and DATE FORMAT-->
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                @endif
                                            </select>
                                            <label  class="form-check-label" for="selMon" class="text-muted">Monday<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text monday_error"></span>
                                        </div> --}}
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group fs-6 mb-1">
                                            <label for="missionobjective" class="mb-1">Tuesday<label for="" class="text-danger mb-0">*</label></label>
                                            <select class="form-select" id="selTues" name="tuesday">
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <!--CONCAT and DATE FORMAT-->
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                @endif
                                            </select>
                                                <span class="text-danger small error-text tuesday_error"></span>
                                        </div>

                                        {{-- <div class="form-floating">
                                            <select class="form-select" id="selTues" name="tuesday">
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <!--CONCAT and DATE FORMAT-->
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                @endif
                                            </select>
                                            <label  class="form-check-label" for="selTues" class="text-muted">Tuesday<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text tuesday_error"></span>
                                        </div> --}}
                                    </div>
                                {{-- </div> --}}

                                {{-- <div class="row"> --}}
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group fs-6 mb-1">
                                            <label for="missionobjective" class="mb-1">Wednesday<label for="" class="text-danger mb-0">*</label></label>
                                            <select class="form-select" id="selWed" name="wednesday">
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <!--CONCAT and DATE FORMAT-->
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                            @endif
                                            </select>
                                                <span class="text-danger small error-text wednesday_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group fs-6 mb-1">
                                            <label for="missionobjective" class="mb-1">Thursday<label for="" class="text-danger mb-0">*</label></label>
                                            <select class="form-select" id="selThur" name="thursday">
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <!--CONCAT and DATE FORMAT-->
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                @endif
                                            </select>
                                                <span class="text-danger small error-text thursday_error"></span>
                                        </div>

                                        {{--
                                        <div class="form-floating">

                                            <select class="form-select" id="selThur" name="thursday">
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else

                                                @endif
                                            </select>

                                            <label  class="form-check-label" for="selThur" class="text-muted">Thursday<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text thursday_error"></span>
                                        </div> --}}
                                    </div>
                                {{-- </div> --}}

                                {{-- <div class="row"> --}}
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group fs-6 mb-1">
                                            <label for="missionobjective" class="mb-1">Friday<label for="" class="text-danger mb-0">*</label></label>
                                            <select class="form-select" id="selFri" name="friday">
                                                {{-- <option selected></option> --}}
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <!--CONCAT and DATE FORMAT-->
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else

                                            @endif
                                            </select>
                                                <span class="text-danger small error-text friday_error"></span>
                                        </div>


                                        {{-- <div class="form-floating">
                                            <select class="form-select" id="selFri" name="friday">
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else

                                            @endif
                                            </select>

                                            <label  class="form-check-label" for="selFri" class="text-muted">Friday<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text friday_error"></span>
                                        </div> --}}
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                         <div class="form-group fs-6 mb-1">
                                            <label for="missionobjective" class="mb-1">Saturday<label for="" class="text-danger mb-0">*</label></label>
                                            <select class="form-select" id="selSat" name="saturday">
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else

                                                @endif
                                            </select>
                                                <span class="text-danger small error-text saturday_error"></span>
                                        </div>

                                        {{-- <div class="form-floating">
                                            <select class="form-select" id="selSat" name="saturday">
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else

                                                @endif
                                            </select>

                                            <label  class="form-check-label" for="selSat" class="text-muted">Saturday<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text saturday_error"></span>
                                        </div> --}}
                                    </div>
                                {{-- </div> --}}

                                {{-- <div class="row"> --}}
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group fs-6 mb-1">
                                            <label for="missionobjective" class="mb-1">Sunday<label for="" class="text-danger mb-0">*</label></label>
                                            <select class="form-select" id="selSun" name="sunday">
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else

                                                @endif
                                            </select>
                                                <span class="text-danger small error-text sunday_error"></span>
                                        </div>

                                        {{-- <div class="form-floating">

                                            <select class="form-select" id="selSun" name="sunday">
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0)
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else

                                                @endif
                                            </select>

                                            <label  class="form-check-label" for="selSun" class="text-muted">Sunday<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text sunday_error"></span>
                                        </div> --}}
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary closereset_update" data-bs-dismiss="modal">Close</button> -->
                    <button  id="btnSaveScheduler" type="button" class="btn btn-details">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Employee Schedule -->
    <div class="modal fade" id="mdlViewModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header dragable_touch" >
                    <h5 class="modal-title" id="staticBackdropLabel"><label for="" class="" id="lblTitleViewMdl">Employee Schedule Time</label></h5>
                    <button type="button" class="btn-close text-white closereset_update" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="frmScheduler">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        {{-- <div class="chart-area"> --}}
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-dark" scope="col">Day</th>
                                                            <th class="text-dark" scope="col">Time</th>
                                                            <th class="text-dark" scope="col">Update</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tblScheduler">

                                                    </tbody>
                                                </table>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary closereset_update" data-bs-dismiss="modal">Close</button> -->
                    {{-- <button  id="btnDeptModal" type="button" class="btn btn-secondary ">Submit</button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Update Time-->
    <div class="modal fade" id="mdlUpdateTime" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header dragable_touch" >
                    <h5 class="modal-title" id="staticBackdropLabel"><label for="" class="" id="lblTitleViewUpdate">Update Time</label></h5>
                    <button type="button" class="btn-close text-white closereset_update" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3 rounded">
                        <div class="card-body ">

                            <form action="" id="frmUpdateTime">

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 mb-2">
                                        <div class="form-floating">
                                            <select class="form-select" id="selWTime" name="wtime">
                                                <option selected></option>

                                                {{-- <option value="0">Rest Day</option> --}}
                                                @if(count($resultSched)>0)
                                                    @foreach($resultSched as $resultScheds)
                                                        @if ($resultScheds->id==0 )
                                                            <option value='{{ $resultScheds->id }}'>{{ $resultScheds->wt_timefrom . " " . $resultScheds->wt_timeto}}</option>
                                                        @else
                                                            <!--CONCAT and DATE FORMAT-->
                                                            <option value='{{ $resultScheds->id }}'>{{ date("h:i A",strtotime($resultScheds->wt_timefrom)) . " - " . date("h:i A",strtotime($resultScheds->wt_timeto))}}</option>
                                                        @endif
                                                    @endforeach
                                                @else

                                                @endif
                                            </select>
                                            <label  class="form-check-label" for="selTime" class="text-muted">Time<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text wtime_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary closereset_update" data-bs-dismiss="modal">Close</button> -->
                    <button  id="btnUpdateTime" type="button" class="btn btn-details">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Effectivity-->
    <div class="modal fade" id="mdlUpdateEffect" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header dragable_touch" >
                    <h5 class="modal-title" id="staticBackdropLabel"><label for="" class="" id="lblTitleUpdateEffect">Update Effectivity Date</label></h5>
                    <button type="button" class="btn-close text-white closereset_update" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card  mb-3 rounded">
                        <div class="card-body ">

                            <form action="" id="frmUpdateDate">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 mb-2">
                                        <div class="form-floating">
                                            <input class="form-control" id="txtDateFromU" name="dateFromU" type="date" placeholder="-"/>
                                            <label class="form-check-label" for="txtDateFromU">Date From<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text dateFromU_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 mb-2">
                                        <div class="form-floating">
                                            <input class="form-control" id="txtDatetoU" name="dateToU" type="date" placeholder="-"/>
                                            <label class="form-check-label" for="txtDatetoU">Date To<label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text dateToU_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary closereset_update" data-bs-dismiss="modal">Close</button> -->
                    <button  id="btnUpdateEffect" type="button" class="btn btn-details">Update</button>
                </div>
            </div>
        </div>
    </div>


</div>

<script src="{{ asset('js/settings/empScheduler.js') }}"  deffer></script>

@endsection

