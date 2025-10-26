<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SSSModel extends Model
{
    use HasFactory;
    protected $table = 'sss';
    protected $primaryKey = 'id ';
    public $timestamps = true;

    protected $fillable = [
        'sssc',
        'from',
        'to',
        'sser',
        'ssee',
        'ssec'
    ];
}
