<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrivingLicense extends Model
{
    use HasFactory, SoftDeletes;
    const DRIVING_LICENSE_KIND = [
        1 => 'A1',
        2 => 'A2',
        3 => 'A3',
        4 => 'A4',
        5 => 'B1 số tự động',
        5 => 'B1',
        6 => 'B2',
        7 => 'C',
        8 => 'D',
        9 => 'E',
        10 => 'FB2',
        11 => 'FC',
        12 => 'FD',
        13 => 'FE',
    ];
    protected $fillable = [ 'user_id', 'supplier_id', 'driving_licenses_code', 'driving_licenses_kind', 'start_date', 'end_date', 'issued_by', 'status'];
}
