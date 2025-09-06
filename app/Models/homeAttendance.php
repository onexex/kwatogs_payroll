<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class homeAttendance extends Model
{
    use HasFactory;
    protected $table = 'home_attendance';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'empID',
        'wsched',
        'wsched2',
        'wsFrom',
        'wsTo',
        'timeIn',
        'timeOut',
        'minsLack',
        'minsLack2',
        'dateTimeInput',
        'durationTime',
        'nightD'
    ];
}
