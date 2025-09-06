<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empDetail extends Model
{
    use HasFactory;
    protected $table = 'emp_details';
    protected $primaryKey = 'id ';
    public $timestamps = true;   

    protected $fillable = [
        'empID',
        'empISID',
        'empDepID',
        'empCompID',
        'empClassification',
        'empPos',
        'empBasic',
        'empStatus',
        'empAllowance',
        'empHrate',
        'empWday',
        'empJobLevel',
        'empAgencyID',
        'empHMOID',
        'empHMONo',
        'empPicPath',
        'empDateHired',
        'empDateResigned',
        'empDateRegular',
        'empPrevPos',
        'empPrevDep',
        'empPrevWorkStartDate',
        'empPassport',
        'empPassportExpDate',
        'empPassportIssueAuth',
        'empPagibig',
        'empPhilhealth',
        'empSSS',
        'empTIN',
        'empUMID',
        'empPrevDesignation'
    ];



  
}
