<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class philhealthModel extends Model
{
    use HasFactory;
    protected $table = 'philhealth';
    protected $primaryKey = 'id ';
    public $timestamps = true;

    protected $fillable = [
        'phsb',
        'salaryFrom',
        'salaryTo',
        'phee',
        'pher',
    ];
}
