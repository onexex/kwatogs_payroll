<?php


use App\Http\Controllers\hmoCtrl;
use App\Http\Controllers\silCtrl;
use App\Http\Controllers\sssCtrl;
use App\Http\Controllers\pageCtrl;
use App\Http\Controllers\roleCtrl;
use App\Http\Controllers\loginCtrl;
use App\Http\Controllers\archiveCtrl;
use App\Http\Controllers\companyCtrl;
use App\Http\Controllers\empStatCtrl;
use App\Http\Controllers\homeDarCtrl;
use App\Http\Controllers\jobleveCtrl;
use App\Http\Controllers\pagibigCtrl;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\agenciesCtrl;
use App\Http\Controllers\earlyoutCtrl;
use App\Http\Controllers\positionCtrl;
use App\Http\Controllers\registerCtrl;
use App\Http\Controllers\workTimeCtrl;
use App\Http\Controllers\leavetypeCtrl;
use App\Http\Controllers\otfillingCtrl;
use App\Http\Controllers\departmentCtrl;
use App\Http\Controllers\philhealthCtrl;
use App\Http\Controllers\empSchedulerCtrl;
use App\Http\Controllers\eovalidationCtrl;
use App\Http\Controllers\relationshipCtrl;
use App\Http\Controllers\holidayLoggerCtrl;
use App\Http\Controllers\obValidationsCtrl;
use App\Http\Controllers\classiticationCtrl;
use App\Http\Controllers\homeAttendanceCtrl;
use App\Http\Controllers\leavevalidationCtrl;
use App\Http\Controllers\liloValidationsCtrl;
use App\Http\Controllers\parentalSettingsCtrl;
use App\Http\Controllers\reportAttendanceCtrl;

Route::get('/auth/login', function () {return view('login.login');});
Route::post('/loginSystem',[loginCtrl::class, 'loginSystem']);
Route::get('/logoutSystem',[loginCtrl::class, 'logoutSystem']);
// Route::get('/', function () {return view('home');});


Route::group(['middleware'=>['AuthCheck']], function(){

    ##

    Route::post('/earlyout/submit',[earlyoutCtrl::class, 'submit']);
    ##

    Route::get('/login/testmoto',[pageCtrl::class, 'test']);


    Route::get('/', function () {return view('home');});
    Route::get('/users/manage',[pageCtrl::class, 'indexUsers']);
    Route::get('/pages/test',[pageCtrl::class, 'alas']);
    //pages
    Route::get('/pages/management/time',[pageCtrl::class, 'officetime']);
    Route::get('/pages/management/companies',[pageCtrl::class, 'companies']);
    Route::get('/pages/management/classification',[pageCtrl::class, 'classification']);
    Route::get('/pages/management/e201',[pageCtrl::class, 'e201']);
    Route::get('/pages/modules/registration',[pageCtrl::class, 'registration']);

    //work time function
    Route::post('/wt/create_update',[workTimeCtrl::class, 'create_update']);
    Route::get('/wt/get',[workTimeCtrl::class, 'wt_get']);
    Route::get('/wt/wt_edit',[workTimeCtrl::class, 'wt_edit']);

    //company
    Route::post('/company/create_update',[companyCtrl::class, 'create_update']);
    Route::get('/company/get_all',[companyCtrl::class, 'get_all']);
    Route::get('/company/get_edit',[companyCtrl::class, 'get_edit']);
    Route::get('/company/delete',[companyCtrl::class, 'delete']);

    //classification
    Route::post('/classification/create_update',[classiticationCtrl::class, 'create_update']);
    Route::get('/classification/get_all',[classiticationCtrl::class, 'get_all']);
    Route::get('/classification/delete',[classiticationCtrl::class, 'delete']);
    Route::get('/classification/edit',[classiticationCtrl::class, 'edit']);

    //payroll
    Route::get('/pages/modules/payroll',[pageCtrl::class, 'payroll']);

    //functions
    Route::post('/function/generateEmpid',[registerCtrl::class, 'generateEmpID']);
    Route::post('/enroll/save',[registerCtrl::class, 'create']);


    // JMC
    //JM 22/09/2022
    Route::get('/pages/management/agencies',[pageCtrl::class, 'agencies']);
    Route::get('/pages/management/positions',[pageCtrl::class, 'positions']);
    Route::get('/pages/management/joblevels',[pageCtrl::class, 'joblevels']);
    Route::get('/pages/management/hmo',[pageCtrl::class, 'hmo']);
    Route::get('/pages/management/employeestatus',[pageCtrl::class, 'employeestatus']);
    Route::get('/pages/management/leavetypes',[pageCtrl::class, 'leavetypes']);
    Route::get('/pages/management/userroles',[pageCtrl::class, 'userroles']);
    Route::get('/pages/management/otfiling',[pageCtrl::class, 'otfiling']);
    Route::get('/pages/management/eo',[pageCtrl::class, 'eo']);
    Route::get('/pages/management/philhealth',[pageCtrl::class, 'philhealth']);
    Route::get('/pages/management/sil',[pageCtrl::class, 'sil']);
    Route::get('/pages/management/parentalsetting',[pageCtrl::class, 'parental']);
    Route::get('/pages/management/shifts',[pageCtrl::class, 'shifts']);
    Route::get('/pages/management/archive',[pageCtrl::class, 'archive']);
    Route::get('/pages/management/E201',[pageCtrl::class, 'E201Mgt']);

    // 28/09/2022 Reports
    Route::get('/pages/report/alas',[pageCtrl::class, 'alasView']);
    Route::get('/pages/reports/attendance',[pageCtrl::class, 'attendanceView']);
    Route::get('/pages/report/dar',[pageCtrl::class, 'darView']);
    Route::get('/pages/report/eo',[pageCtrl::class, 'eoView']);
    Route::get('/pages/report/ob',[pageCtrl::class, 'obView']);
    Route::get('/pages/report/ot',[pageCtrl::class, 'otView']);
    Route::get('/pages/report/leave_credit',[pageCtrl::class, 'leaveView']);

    // Modules
    Route::get('/pages/modules/E201',[pageCtrl::class, 'e201File']);
    Route::get('/pages/modules/memorandum',[pageCtrl::class, 'memorandum']);

    // SHAIRA
    //MANAGEMENT
    Route::get('/pages/management/accessrights',[pageCtrl::class, 'accessrights']);
    Route::get('/pages/management/departments',[pageCtrl::class, 'departments']);
    Route::get('/pages/management/relationship',[pageCtrl::class, 'relationship']);
    Route::get('/pages/management/leavevalidations',[pageCtrl::class, 'leavevalidations']);
    Route::get('/pages/management/holidaylogger',[pageCtrl::class, 'holidaylogger']);
    Route::get('/pages/management/lilovalidations',[pageCtrl::class, 'lilovalidations']);
    Route::get('/pages/management/obvalidations',[pageCtrl::class, 'obvalidations']);
    Route::get('/pages/management/ssscontribution',[pageCtrl::class, 'ssscontribution']);
    Route::get('/pages/management/pagibigcontribution',[pageCtrl::class, 'pagibigcontribution']);
    Route::get('/pages/management/empscheduler',[pageCtrl::class, 'empscheduler']);

    //MODULE
    Route::get('/pages/modules/obtTracker',[pageCtrl::class, 'obtTracker']);
    Route::get('/pages/modules/sendOBT',[pageCtrl::class, 'sendOBT']);
    Route::get('/pages/modules/overtime',[pageCtrl::class, 'overtime']);
    Route::get('/pages/modules/earlyout',[pageCtrl::class, 'earlyout']);
    Route::get('/pages/modules/leaveApplication',[pageCtrl::class, 'leaveApplication']);
    Route::get('/pages/modules/debitAdvise',[pageCtrl::class, 'debitAdvise']);
    Route::get('/pages/modules/checkRegister',[pageCtrl::class, 'checkRegister']);

    //joblevel
    Route::post('/joblevel/create_update',[jobleveCtrl::class, 'create_update']);
    Route::get('/joblevel/get_joblevel',[jobleveCtrl::class, 'get_all']);
    Route::get('/joblevel/edit',[jobleveCtrl::class, 'edit']);

    //postion
    Route::post('/position/create_update',[positionCtrl::class, 'create_update']);
    Route::get('/position/get_position',[positionCtrl::class, 'get_all']);
    Route::get('/position/edit',[positionCtrl::class, 'edit']);

    //department
    Route::post('/department/create_update',[departmentCtrl::class, 'create_update']);
    Route::get('/department/getall',[departmentCtrl::class, 'getall']);
    Route::get('/department/edit',[departmentCtrl::class, 'edit']);

    //relationship
    Route::post('/relationship/create_update',[relationshipCtrl::class, 'create_update']);
    Route::get('/relationship/getall',[relationshipCtrl::class, 'getall']);
    Route::get('/relationship/edit',[relationshipCtrl::class, 'edit']);

    //leavetype
    Route::post('/leavetype/create_update',[leavetypeCtrl::class, 'create_update']);
    Route::get('/leavetype/getall',[leavetypeCtrl::class, 'getall']);
    Route::get('/leavetype/edit',[leavetypeCtrl::class, 'edit']);

    //userrole
    Route::post('/roles/create_update',[roleCtrl::class, 'create_update']);
    Route::get('/roles/getall',[roleCtrl::class, 'getall']);
    Route::get('/roles/edit',[roleCtrl::class, 'edit']);
    Route::post('/roles/search',[roleCtrl::class, 'search']);

     //leave validation
     Route::post('/leaveval/create_update',[leavevalidationCtrl::class, 'create_update']);
     Route::get('/leaveval/getall',[leavevalidationCtrl::class, 'getall']);
     Route::get('/leaveval/edit',[leavevalidationCtrl::class, 'edit']);

    //ot filling
    Route::post('/otfilling/create_update',[otfillingCtrl::class, 'create_update']);
    Route::get('/otfilling/getall',[otfillingCtrl::class, 'getall']);
    Route::get('/otfilling/edit',[otfillingCtrl::class, 'edit']);


    //SHAI
    //Agencies Shai
    Route::post('/agency/create_update',[agenciesCtrl::class, 'create_update']);
    Route::get('/agency/getall',[agenciesCtrl::class, 'getall']);
    Route::get('/agency/edit',[agenciesCtrl::class, 'edit']);

    //Lilo Validation Shai
    Route::post('/lilo/create_update',[liloValidationsCtrl::class, 'create_update']);
    Route::get('/lilo/getall',[liloValidationsCtrl::class, 'getall']);
    Route::get('/lilo/edit',[liloValidationsCtrl::class, 'edit']);

    //OB Validation Shai
    Route::post('/ob/create_update',[obValidationsCtrl::class, 'create_update']);
    Route::get('/ob/getall',[obValidationsCtrl::class, 'getall']);
    Route::get('/ob/edit',[obValidationsCtrl::class, 'edit']);

    // JMC 10/12/22
    Route::post('/classification/create_updateHMO',[hmoCtrl::class, 'create_update']);
    Route::get('/getHMO',[hmoCtrl::class, 'getHMO']);
    Route::get('/getData',[hmoCtrl::class, 'getData']);

    Route::post('/classification/create_updateEmpStat',[empStatCtrl::class, 'create_update']);
    Route::get('/getEmployeeStatus',[empStatCtrl::class, 'getEmployeeStatus']);
    Route::get('/getEmployeeStatusData',[empStatCtrl::class, 'getData']);

    Route::post('/classification/createHolidayLogger',[holidayLoggerCtrl::class, 'create_update']);
    Route::get('/getHL',[holidayLoggerCtrl::class, 'getall']);
    Route::get('/getHLData',[holidayLoggerCtrl::class, 'edit']);

    Route::post('/settings/eo_validation',[eovalidationCtrl::class, 'create_update']);
    Route::get('/getEOValidation',[eovalidationCtrl::class, 'getall']);
    Route::get('/updateEO',[eovalidationCtrl::class, 'edit']);

    Route::post('/settings/SSS',[sssCtrl::class, 'create_update']);
    Route::get('/getSSS',[sssCtrl::class, 'getall']);
    Route::get('/updateSSS',[sssCtrl::class, 'edit']);

    Route::post('/settings/Pagibig',[pagibigCtrl::class, 'create_update']);
    Route::get('/getPagibig',[pagibigCtrl::class, 'getall']);
    Route::get('/updatePagibig',[pagibigCtrl::class, 'edit']);

    Route::post('/settings/Philhealth',[philhealthCtrl::class, 'create_update']);
    Route::get('/getPhilhealth',[philhealthCtrl::class, 'getall']);
    Route::get('/updatePhilhealth',[philhealthCtrl::class, 'edit']);

    //enrolment
    // Route::resource('enrolment', registerCtrl::class);

    Route::post('/sil/create_update',[silCtrl::class, 'create_update']);
    Route::get('/sil/getusers', [silCtrl::class, 'getusers']);
    Route::get('/sil/getall',[silCtrl::class, 'getall']);
    Route::get('/sil/edit',[silCtrl::class, 'edit']);

    //SHAI
    //PARENTAL SETTINGS
    Route::post('/parental/create_update',[parentalSettingsCtrl::class, 'create_update']);
    Route::get('/parental/getall',[parentalSettingsCtrl::class, 'getall']);
    Route::get('/parental/edit',[parentalSettingsCtrl::class, 'edit']);
    Route::get('/parental/delete_record',[parentalSettingsCtrl::class, 'delete_record']);

    //initialize address
    Route::post('/get_province',[registerCtrl::class, 'get_province']);
    Route::get('/get_city',[registerCtrl::class, 'get_city']);
    Route::get('/get_brgy',[registerCtrl::class, 'get_brgy']);

    //EMPLOYEE SCHEDULER SETTINGS
    Route::post('/scheduler/create_update',[empSchedulerCtrl::class, 'create_update']);
    Route::get('/scheduler/getall',[empSchedulerCtrl::class, 'getall']);
    //UPDATE TIME
    Route::get('/scheduler/getall_time',[empSchedulerCtrl::class, 'getall_time']);
    Route::post('/scheduler/update_time',[empSchedulerCtrl::class, 'update_time']);
    Route::get('/scheduler/edit_time',[empSchedulerCtrl::class, 'edit_time']);
    Route::get('/scheduler/getall_time',[empSchedulerCtrl::class, 'getall_time']);
    //UPDATE DATE
    Route::get('/scheduler/edit_date',[empSchedulerCtrl::class, 'edit_date']);
    Route::post('/scheduler/update_date',[empSchedulerCtrl::class, 'update_date']);

    Route::post('/scheduler/search',[empSchedulerCtrl::class, 'search']);

    //HOME DAR
    Route::post('/home/create_dar',[homeDarCtrl::class, 'create_dar']);
    Route::get('/home/getall_dar',[homeDarCtrl::class, 'getall_dar']);
    Route::get('/home/filter_dar',[homeDarCtrl::class, 'filter_dar']);
    Route::get('/home/logs_dar',[homeDarCtrl::class, 'logs_dar']);

    //HOME ATTENDANCE LOG
    Route::post('/home/create_attendance',[homeAttendanceCtrl::class, 'create_attendance']);
    Route::get('/home/mdl_attendance',[homeAttendanceCtrl::class, 'log_attendance']);
    Route::get('/home/getall_attendance',[homeAttendanceCtrl::class, 'getall_attendance']);
    Route::get('/home/filter_attendance',[homeAttendanceCtrl::class, 'filter_attendance']);

    //ARCHIVE MANAGEMENT
    Route::post('/archive/create_update',[archiveCtrl::class, 'create_update']);
    Route::get('/archive/getall',[archiveCtrl::class, 'getall']);
    Route::get('/archive/edit',[archiveCtrl::class, 'edit']);
    Route::post('/archive/search',[archiveCtrl::class, 'search']);

    ///REPORTS
    // Route::post('/ViewReportAttend',[reportAttendanceCtrl::class, 'viewreportattend']);
    Route::get('/task/search',[reportAttendanceCtrl::class,'searchTask']);














});

