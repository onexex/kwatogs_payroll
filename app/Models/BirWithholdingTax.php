<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirWithholdingTax extends Model
{
    use HasFactory;

    protected $fillable = [
        'compensation_from',
        'compensation_to',
        'fixed_tax',
        'excess_over',
        'percent_over',
        'effective_year',
    ];
}
