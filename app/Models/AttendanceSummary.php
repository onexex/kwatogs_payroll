<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSummary extends Model
{
    use HasFactory;

    protected $table = 'attendance_summaries';

    protected $fillable = [
        'employee_id',
        'attendance_date',
        'total_hours',
        'mins_late',
        'mins_undertime',
        'mins_night_diff',
        'status',
        'remarks',
        'over_break_minutes',
        'outpass_minutes'
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id','empID');
    }

    //   public function homeAttendances()
    // {
    //     return $this->hasMany(HomeAttendance::class, 'employee_id', 'employee_id')
    //                 ->whereColumn('home_attendances.attendance_date', 'attendance_date');
    // }

    public function homeAttendances()
{
    return $this->hasMany(HomeAttendance::class, 'employee_id', 'employee_id')
        ->orderBy('time_in', 'asc');
}
    protected $casts = [
        'attendance_date' => 'date', // ← This makes it a Carbon instance
    ];
}
