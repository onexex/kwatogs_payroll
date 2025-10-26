@extends('layout.app')
@section('content')

    <style>
        body {
            /* background-color: rgb(168, 165, 165); */
            /* color: #000000f5; */
        }

        .gi label {
            font-weight: 600;
            font-size: 12px;
        }
    </style>
    <div class="container-fluid" style="">

        <div class="row">
            <div class="col-xl-12 ">
                <div class="p-3">
                    <h4 class="text-secondary-800">Settings / <label class="text-black">Employee Registration</label></h4>
                </div>

                <div class="row">
                    <div class="nav-align-top">
                        <div class="row">
                            <ul class="nav nav-pills list-inline px-4" role="tablist">
                                <li class="nav-item pr-2">
                                    <button id="home-tab"
                                        class="nav-link active text-secondary list-inline-item shadow-sm " type="button"
                                        role="tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                                        aria-controls="home-tab-pane" aria-selected="true" style="width:2.5in">
                                        <i class="tf-icons bx bx-user"></i> General Information
                                    </button>
                                </li>
                                <li class="nav-item pr-2">
                                    <button aria-selected="false" id="profile-tab"
                                        class="nav-link text-secondary list-inline-item shadow-sm" type="button"
                                        role="tab" data-bs-toggle="tab" data-bs-target="#educational-tab-pane"
                                        aria-controls="educational-tab-pane" aria-selected="false" style="width:2.5in">
                                        <i class="tf-icons bx bx-user"></i> Educational Background
                                    </button>
                                </li>
                                <li class="nav-item pr-2">
                                    <button id="contact-tab" class="nav-link text-secondary list-inline-item shadow-sm"
                                        type="button" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#employment-tab-pane" aria-controls="employment-tab-pane"
                                        aria-selected="false" style="width:2.5in">
                                        <i class="tf-icons bx bx-user"></i> Employment Information
                                    </button>
                                </li>
                                <li class="nav-item pr-2">
                                    <button id="contact-tab" class="nav-link text-secondary list-inline-item shadow-sm"
                                        type="button" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#complaince-tab-pane" aria-controls="complaince-tab-pane"
                                        aria-selected="false" style="width:2.5in">
                                        <i class="tf-icons bx bx-user"></i> Complaince Documents
                                    </button>
                                </li>
                                <li class="nav-item pr-2">
                                    <button id="contact-tab" class="nav-link text-secondary list-inline-item shadow-sm"
                                        type="button" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#profile-tab-pane" aria-controls="profile-tab-pane"
                                        aria-selected="false" style="width:2.5in">
                                        <i class="tf-icons bx bx-user"></i> Profile Picture
                                    </button>
                                </li>

                            </ul>
                        </div>

                        <form id="frmEnrolment">
                            <div class="tab-content px-2 pt-3" id="myTabContent">
                                <div class="tab-content px-2 pt-3">
                                    <!-- General Information -->
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                        aria-labelledby="home-tab" tabindex="0">
                                        <div class="gi">
                                            <div class="card shadow mb-4">
                                                <h5 class="px-4 pt-4 mb-0">GENERAL INFORMATION</h5>
                                                <div class="card-body">
                                                    <div class="row px-3">
                                                        <div class="col-lg-4">
                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0 small">FIRST NAME<label
                                                                        for=""
                                                                        class="text-danger small mb-0">*</label></label>
                                                                <input class="form-control" id="txtfname" name="firstname"
                                                                    type="text" placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text firstname_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">MIDDLE NAME<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtMiddleName"
                                                                    name="middlename" type="text" placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text middlename_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">LAST NAME<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtLastName"
                                                                    name="lastname" type="text" placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text lastname_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">SUFFIX</label>
                                                                <input class="form-control" id="txtSuffix" name="suffix"
                                                                    type="text" placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text suffix_error"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 ">
                                                            <div class="form-group mb-2 fs-6">
                                                                <label for="missionobjective" class="mb-0">GENDER<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <select class="form-control" name="gender"
                                                                    id="selGender">
                                                                    <option value="0">Female</option>
                                                                    <option value="1">Male</option>
                                                                </select>

                                                                <span
                                                                    class="text-danger small error-text cross_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">CITIZENSHIP<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtCitizenship"
                                                                    name="citizenship" type="text" placeholder="" />

                                                                <span
                                                                    class="text-danger small error-text citizenship_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">RELIGION<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtReligion"
                                                                    name="religion" type="text" placeholder="" />

                                                                <span
                                                                    class="text-danger small error-text religion_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">HOME PHONE
                                                                    NUMBER<label for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtHomePhone"
                                                                    name="homephone" type="number" placeholder="" />

                                                                <span
                                                                    class="text-danger small error-text homephone_error"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">DATE OF
                                                                    BIRTH<label for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtDOB"
                                                                    name="birthdate" type="date"
                                                                    placeholder="Date of birth" />

                                                                <span
                                                                    class="text-danger small error-text birthdate_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2 fs-6">
                                                                <label for="missionobjective" class="mb-0">CIVIL
                                                                    STATUS<label for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <select class="form-control" name="status"
                                                                    id="selCivilStatus">
                                                                    <option value="0">Single</option>
                                                                    <option value="1">Married</option>
                                                                    <option value="2">Divorced</option>
                                                                    <option value="3">Widowed</option>
                                                                </select>

                                                                <span
                                                                    class="text-danger small error-text status_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">MOBILE
                                                                    NUMBER<label for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtMobileNumber"
                                                                    name="mobile" type="number" placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text mobile_error"></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="missionDesc" class="mb-0">EMAIL
                                                                    ADDRESS<label for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtEmailAddress"
                                                                    name="email" type="email" placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text email_error"></span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card shadow mb-4">
                                                <h5 class="p-4 mb-0">COMPLETE MAILING ADDRESS</h5>
                                                <div class="card-body">
                                                    <div class="row px-3">
                                                        <div class="col-lg-4 ">
                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">PROVINCE<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <select class="form-control" name="province"
                                                                    id="txtProvince" placeholder="province">
                                                                </select>
                                                                <span
                                                                    class="text-danger small error-text province_error"></span>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">CITY<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <select class="form-control" name="city"
                                                                    id="txtCity" placeholder="City">
                                                                </select>
                                                                <span
                                                                    class="text-danger small error-text city_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 ">
                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">BARANGAY<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <select class="form-control" name="barangay"
                                                                    id="txtBrgy" placeholder="City">
                                                                </select>
                                                                <span
                                                                    class="text-danger small error-text barangay_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">STREET
                                                                    NO/SUB<label for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtStreet" name="street"
                                                                    type="text" placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text street_error"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 ">
                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">ZIP CODE<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtZipCode"
                                                                    name="zipcode" type="text" placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text zipcode_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">COUNTRY<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtCountry"
                                                                    name="country" type="text" value="Philippines"
                                                                    placeholder="Country" />
                                                                <span
                                                                    class="text-danger small error-text country_error"></span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Educational Backgroumd -->
                                    <div class="tab-pane fade" id="educational-tab-pane" role="tabpanel"
                                        aria-labelledby="educational-tab" tabindex="0">
                                        <div class="gi">
                                            <div class="card shadow mb-4">
                                                <h5 class="px-4 pt-4 mb-0">EDUCATIONAL BACKGROUND</h5>
                                                <div class="card-body">
                                                    <div class="row px-3">
                                                        <div class="table-responsive text-nowrap">
                                                            <table class="table">
                                                                <thead class="text-center text-nowrap">
                                                                    <tr>
                                                                        <td></td>
                                                                        <td>NAME OF SCHOOL</td>
                                                                        <td>YEAR STARTED</td>
                                                                        <td>YEAR GRADUATED</td>
                                                                        <td>SCHOOL ADDRESS</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="p-1">
                                                                    <tr>
                                                                        <td> PRIMARY </td>
                                                                        <td>
                                                                            <div class="form-group mb-1">
                                                                                <input class="form-control"
                                                                                    id="txtPrimarySchool"
                                                                                    name="primary_school"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-1">
                                                                                <input class="form-control"
                                                                                    id="txtPrimaryStarted"
                                                                                    name="primary_year_started"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-1">
                                                                                <input class="form-control"
                                                                                    id="txtPrimaryGraduated"
                                                                                    name="primary_year_graduated"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-1">
                                                                                <input class="form-control"
                                                                                    id="txtPrimaryAddress"
                                                                                    name="primary_school_address"
                                                                                    type="text" />
                                                                                <span
                                                                                    class="text-danger small error-text street_error"></span>
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class=" align-self-center"> SECONDARY </td>
                                                                        <td>
                                                                            <div class="form-group mb-1">
                                                                                <input class="form-control"
                                                                                    id="txtSecondarySchool"
                                                                                    name="secondary_school"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-1">
                                                                                <input class="form-control"
                                                                                    id="txtSecondaryStarted"
                                                                                    name="secondary_year_started"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-1">
                                                                                <input class="form-control"
                                                                                    id="txtSecondaryGraduated"
                                                                                    name="secondary_year_graduated"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-1">
                                                                                <input class="form-control"
                                                                                    id="txtSecondaryAddress"
                                                                                    name="secondary_school_address"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td> TERTIARY </td>
                                                                        <td>
                                                                            <div class="form-group mb-1">
                                                                                <input class="form-control"
                                                                                    id="txtTeriarySchool"
                                                                                    name="teriary_school"
                                                                                    type="text" />
                                                                                <span
                                                                                    class="text-danger small error-text street_error"></span>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-1">
                                                                                <input class="form-control"
                                                                                    id="txtTeriaryStarted"
                                                                                    name="tertiary_year_started"
                                                                                    type="text" />

                                                                                <span
                                                                                    class="text-danger small error-text street_error"></span>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-1">
                                                                                <input class="form-control"
                                                                                    id="txtTeriaryGraduated"
                                                                                    name="teriary_year_graduated"
                                                                                    type="text" />
                                                                                <span
                                                                                    class="text-danger small error-text street_error"></span>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-1">
                                                                                <input class="form-control"
                                                                                    id="txtTeriaryAddress"
                                                                                    name="teriary_school_address"
                                                                                    type="text" />
                                                                                <span
                                                                                    class="text-danger small error-text street_error"></span>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Employment Information -->
                                    <div class="tab-pane fade" id="employment-tab-pane" role="tabpanel"
                                        aria-labelledby="employment-tab" tabindex="0">
                                        <div class="gi">
                                        <div class="card shadow mb-4">
                                            <h5 class="px-4 pt-4 mb-0">EMPLOYMENT INFORMATION</h5>
                                            <div class="card-body">
                                                <div class="row px-3">
                                                    <div class="col-lg-3">
                                                        <div class="form-group mb-2">
                                                            <label for="missionDesc" class="mb-0">EMPLOYEE NO.<label
                                                                    for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <input class="form-control" id="txtEmployeeNo"
                                                                name="employee_number" type="text" placeholder=""
                                                                readonly />
                                                            <span
                                                                class="text-danger small error-text employee_number_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2 fs-6">
                                                            <label for="missionobjective"
                                                                class="text-muted mb-0">COMPANY<label for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <select class="form-control" name="company" id="selCompany"
                                                                placeholder="Company">
                                                                @if (count($companyData) > 0)
                                                                    @foreach ($companyData as $companyDatas)
                                                                        <option value='{{ $companyDatas->comp_id }}'>
                                                                            {{ $companyDatas->comp_name }}</option>
                                                                    @endforeach
                                                                @else
                                                                @endif
                                                            </select>
                                                            <span
                                                                class="text-danger small error-text companyt_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2 fs-6">
                                                            <label for="missionobjective"
                                                                class="text-muted mb-0">DEPARTMENT<label for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <select class="form-control" name="department"
                                                                id="selDepartment" placeholder="Department">
                                                                @if (count($departmentData) > 0)
                                                                    @foreach ($departmentData as $departmentDatas)
                                                                        <option value='{{ $departmentDatas->id }}'>
                                                                            {{ $departmentDatas->dep_name }}</option>
                                                                    @endforeach
                                                                @else
                                                                @endif
                                                            </select>
                                                            <span
                                                                class="text-danger small error-text department_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2 fs-6">
                                                            <label for="missionobjective"
                                                                class="text-muted mb-0">POSITION<label for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <select class="form-control" name="position" id="selPosition"
                                                                placeholder="position">
                                                                @if (count($positionData) > 0)
                                                                    @foreach ($positionData as $positionDatas)
                                                                        <option value='{{ $positionDatas->id }}'>
                                                                            {{ $positionDatas->pos_desc }}</option>
                                                                    @endforeach
                                                                @else
                                                                @endif
                                                            </select>

                                                            <span
                                                                class="text-danger small error-text position_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2 fs-6">
                                                            <label for="missionobjective"
                                                                class="text-muted mb-0">CLASSIFICATION<label
                                                                    for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <select class="form-control" name="classification"
                                                                id="selClassification" placeholder="Classification">
                                                                @if (count($employeeClassification) > 0)
                                                                    @foreach ($employeeClassification as $employeeClassifications)
                                                                        <option
                                                                            value='{{ $employeeClassifications->class_code }}'>
                                                                            {{ $employeeClassifications->class_desc }}
                                                                        </option>
                                                                    @endforeach
                                                                @else
                                                                @endif
                                                            </select>
                                                            <span
                                                                class="text-danger small error-text classification_error"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group mb-2 fs-6">
                                                            <label for="missionobjective"
                                                                class="text-muted mb-0">IMMEDIATE SUPERIOR<label
                                                                    for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <select class="form-control" name="immediate"
                                                                id="selImmediate" placeholder="Immediate">
                                                                @if (count($immediateData) > 0)
                                                                    @foreach ($immediateData as $immediateDatas)
                                                                        <option value='{{ $immediateDatas->empID }}'>
                                                                            {{ $immediateDatas->fname . ' ' . $immediateDatas->lname }}
                                                                        </option>
                                                                    @endforeach
                                                                @else
                                                                @endif
                                                            </select>
                                                            <span
                                                                class="text-danger small error-text classification_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2 fs-6">
                                                            <label for="missionobjective"
                                                                class="text-muted mb-0">STATUS<label for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <select class="form-control" name="status" id="selStatus"
                                                                placeholder="Status">
                                                                <option value="1">Employed</option>
                                                                <option value="0">Resigned</option>

                                                            </select>
                                                            <span class="text-danger small error-text status_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2 fs-6">
                                                            <label for="missionobjective" class="text-muted mb-0">PREVIOUS
                                                                POSITION<label for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <input type="text" class="form-control"
                                                                name="previous_position" id="selPreviousPosition"
                                                                placeholder="" />
                                                            <span
                                                                class="text-danger small error-text previous_position_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2 fs-6">
                                                            <label for="missionobjective" class="text-muted mb-0">START
                                                                DATE<label for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <input type="date" class="form-control" name="start_date"
                                                                id="selStartdate" placeholder="Status" />
                                                            <span
                                                                class="text-danger small error-text previous_position_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2 fs-6">
                                                            <label for="missionobjective" class="text-muted mb-0">JOB
                                                                LEVEL<label for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <select class="form-control" name="job_level"
                                                                id="selJobLevel">
                                                                @if (count($joblevelData) > 0)
                                                                    @foreach ($joblevelData as $joblevelDatas)
                                                                        <option value='{{ $joblevelDatas->id }}'>
                                                                            {{ $joblevelDatas->job_desc }}</option>
                                                                    @endforeach
                                                                @else
                                                                @endif
                                                            </select>
                                                            <span
                                                                class="text-danger small error-text job_level_error"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group mb-2 fs-6">
                                                            <label for="missionobjective"
                                                                class="text-muted mb-0">AGENCY<label for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <select class="form-control" name="agency" id="selAgency">
                                                                @if (count($agencyData) > 0)
                                                                    @foreach ($agencyData as $agencyDatas)
                                                                        <option value='{{ $agencyDatas->id }}'>
                                                                            {{ $agencyDatas->ag_name }}</option>
                                                                    @endforeach
                                                                @else
                                                                @endif
                                                            </select>
                                                            <span class="text-danger small error-text agency_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2 fs-6">
                                                            <label for="missionobjective" class="text-muted mb-0">HMO
                                                                PROVIDER<label for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <select class="form-control" name="hmo" id="selHMO">
                                                                @if (count($hmoData) > 0)
                                                                    @foreach ($hmoData as $hmoDatas)
                                                                        <option value='{{ $hmoDatas->idNo }}'>
                                                                            {{ $hmoDatas->hmoName }}</option>
                                                                    @endforeach
                                                                @else
                                                                @endif
                                                            </select>

                                                            <span class="text-danger small error-text hmo_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2 fs-6">
                                                            <label for="missionobjective" class="text-muted mb-0">HMO
                                                                NUMBER<label for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <input type="text" class="form-control" name="hmo_number"
                                                                id="selHMONo" placeholder="" />
                                                            <span
                                                                class="text-danger small error-text hmo_number_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="missionDesc" class="mb-0">DATE HIRED<label
                                                                    for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <input class="form-control" id="txtDateHired"
                                                                name="date_hired" type="date"
                                                                placeholder="Date hires" />
                                                            <span
                                                                class="text-danger small error-text date_hired_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="missionDesc" class="mb-0">DATE RESIGNED<label
                                                                    for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <input class="form-control" id="txtDateResigned"
                                                                name="date_resingned" type="date"
                                                                placeholder="Date Resigned" />
                                                            <span
                                                                class="text-danger small error-text date_resingned_error"></span>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-3 mb-2">
                                                        <div class="form-group mb-2">
                                                            <label for="missionDesc" class="mb-0">DATE REGULAR<label
                                                                    for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <input class="form-control" id="txtDateResigned"
                                                                name="date_regularization" type="date"
                                                                placeholder="Date Regularization" />
                                                            <span
                                                                class="text-danger small error-text date_regularization_error"></span>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-2 fs-6">
                                                                    <label for="missionobjective"
                                                                        class="text-muted mb-0">BASIC SALARY<label
                                                                            for=""
                                                                            class="text-danger mb-0">*</label></label>
                                                                    <input type="text" class="form-control"
                                                                        name="basic" id="txtBasic"
                                                                        placeholder="Basic Salary" value="0" />
                                                                    <span
                                                                        class="text-danger small error-text basic_error"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-2">
                                                                    <label for="missionDesc"
                                                                        class="mb-0">ALLOWANCE<label for=""
                                                                            class="text-danger mb-0">*</label></label>
                                                                    <input class="form-control" id="txtAllowance"
                                                                        name="allowance" type="text"
                                                                        placeholder="Allowance" value  ="0" />
                                                                    <span
                                                                        class="text-danger small error-text allowance_error"></span>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6 g-0">
                                                                <div class="form-group mb-2">
                                                                    <label for="missionDesc" class="mb-0">HOURLY
                                                                        RATE<label for=""
                                                                            class="text-danger mb-0">*</label></label>
                                                                    <input class="form-control" id="txtHourlyRate"
                                                                        name="hourly_rate" type="text"
                                                                        placeholder="" />
                                                                    <span
                                                                        class="text-danger small error-text hourly_rate_error"></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-2 fs-6">
                                                                    <label for="missionobjective"
                                                                        class="text-muted mb-0">WORK DAYS <label
                                                                            for=""
                                                                            class="text-danger mb-0">*</label></label>
                                                                    <select class="form-control" name="no_work_days"
                                                                        id="selWorkDays">
                                                                        <option value="4">4 Days</option>
                                                                        <option value="5">5 Days</option>
                                                                    </select>
                                                                    <span
                                                                        class="text-danger small error-text no_work_days_error"></span>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="missionDesc" class="mb-0">PREVIOUS
                                                                DEPARTMENT<label for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <input class="form-control" id="txtPreviousDepartment"
                                                                name="previous_department" type="text"
                                                                placeholder="" />
                                                            <span
                                                                class="text-danger small error-text previous_department_error"></span>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="missionDesc" class="mb-0">PREVIOUS
                                                                DESIGNATION<label for=""
                                                                    class="text-danger mb-0">*</label></label>
                                                            <input class="form-control" id="txtPreviousDesignation"
                                                                name="previous_designation" type="text"
                                                                placeholder="" />
                                                            <span
                                                                class="text-danger small error-text previous_designation_error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Complaince Documents-->
                                    <div class="tab-pane fade" id="complaince-tab-pane" role="tabpanel"
                                        aria-labelledby="complaince-tab" tabindex="0">
                                        <div class="gi">
                                            <div class="card shadow mb-4">
                                                <h5 class="px-4 pt-4 mb-0">COMPLAINCE DATA</h5>
                                                <div class="card-body">
                                                    <div class="row px-3">
                                                        <div class="col-lg-5">
                                                            <div class="form-group mb-2 fs-6">
                                                                <label for="missionobjective" class="mb-0">PASSPORT
                                                                    NUMBER<label for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input type="text" class="form-control"
                                                                    name="passport_no" id="txtPassportNo"
                                                                    placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text passport_no_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">PASSPORT EXPIRY
                                                                    DATE<label for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtPassportExpDate"
                                                                    name="passport_exp_date" type="date"
                                                                    placeholder="" />

                                                                <span
                                                                    class="text-danger small error-text passport_exp_date_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">PASSPORT ISSUING
                                                                    AUTHORITY<label for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtIssuingAuth"
                                                                    name="issuing_authority" type="text"
                                                                    placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text issuing_authority_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">PAG-IBIG NO.<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtPagibig"
                                                                    name="pagibig" type="text" placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text pagibig_error"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-5">
                                                            <div class="form-group mb-2 fs-6">
                                                                <label for="missionobjective"
                                                                    class="mb-0">PHIL-HEALTH<label for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input type="text" class="form-control"
                                                                    name="philhealth" id="txtPhilhealth"
                                                                    placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text philhealth_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">SSS NO<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtSSS" name="sss"
                                                                    type="text" placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text sss_error"></span>
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label for="missionDesc" class="mb-0">TIN NO<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtTIN" name="tin"
                                                                    type="text" placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text tin_error"></span>
                                                            </div>

                                                            <div class="form-group mb-3">
                                                                <label for="missionDesc" class="mb-0">UMID<label
                                                                        for=""
                                                                        class="text-danger mb-0">*</label></label>
                                                                <input class="form-control" id="txtUMIDNo" name="umid"
                                                                    type="text" placeholder="" />
                                                                <span
                                                                    class="text-danger small error-text umid_error"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Profile Picture-->
                                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel"
                                        aria-labelledby="profile-tab" tabindex="0">
                                        <div class="row">
                                            {{-- <div class="container"> --}}

                                            <div class="card shadow">
                                                <h5 class="px-4 pt-4 mb-0">PROFILE PICTURE</h5>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-5">
                                                            <div class="frame pb-4 px-3">
                                                                <input class="form-control" id="formFileLg"
                                                                    name="path" type="file" />
                                                            </div>
                                                            <button id="btnSaveAll" type="button"
                                                                class="btn btn-details text-white">Save ALL</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- </div> --}}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
        <script src="{{ asset('js/modules/enrollment.js') }}" defer></script>

    </div>

@endsection
