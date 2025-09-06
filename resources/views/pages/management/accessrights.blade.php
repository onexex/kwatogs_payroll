@extends('layout.app')
@section('content')

<!--SHAIRA-->

<div class="container-fluid">
    <div class="mb-2">
        <h4 class="text-gray-800 mb-3">Access Rights</h4>
    </div>

    <div class="row mt-4 mb-2">
        <div class="col-xl-4 col-lg-12">
            {{-- <label class="text-gray-800 mb-2">Search Employee Lastname:</label> --}}
            <div class="form-floating mt-2">
                <input type="email" class="form-control" name="employee" id="txtSearchEmp" placeholder="-">
                <label  class="form-check-label" for="txtEmpLname">Search Employee Lastname</label>
                <span class="text-danger small error-text employee_error"></span>
            </div>
        </div>
    </div>

     <!-- Content Row dar -->
     <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card   mb-4">
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area overflow-auto">
                        <div class="table-responsive fixTableHead">
                            <table class="table table-hover table-scroll sticky">
                                <thead style="background-color: #f1f1f1; ">
                                    <tr>
                                        <th class="text-dark" scope="col">Modules</th>
                                        <th class="text-dark" scope="col">Access</th>
                                    </tr>
                                </thead>
                                <tbody id="tblAccessRights">
                                    <tr>
                                        <td>001</td>
                                        <td>Operations</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
