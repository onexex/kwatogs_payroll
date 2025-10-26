<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpDetail extends Model
{
    use HasFactory;

    protected $table = 'emp_details';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'empID', 'empISID', 'empDepID', 'empCompID', 'empClassification', 'empPos',
        'empBasic', 'empStatus', 'empAllowance', 'empHrate', 'empWday', 'empJobLevel',
        'empAgencyID', 'empHMOID', 'empHMONo', 'empPicPath', 'empDateHired',
        'empDateResigned', 'empDateRegular', 'empPrevPos', 'empPrevDep',
        'empPrevWorkStartDate', 'empPassport', 'empPassportExpDate', 'empPassportIssueAuth',
        'empPagibig', 'empPhilhealth', 'empSSS', 'empTIN', 'empUMID', 'empPrevDesignation'
    ];

    protected $casts = [
        'empBasic' => 'float',
        'empAllowance' => 'float',
        'empHrate' => 'float',
        'empWday' => 'integer',
        'empDateHired' => 'date',
        'empDateResigned' => 'date',
        'empDateRegular' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'empID', 'empID');
    }

    public function getSalaryInfo()
    {
        return [
            'classification' => $this->empClassification,
            'status' => $this->empStatus,
            'basic' => $this->empBasic,
            'allowance' => $this->empAllowance,
            'hourly_rate' => $this->empHrate,
            'work_days' => $this->empWday,
        ];
    }
}
