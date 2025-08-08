<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'status',
    ];

    public function employee()
    {
       return $this->belongsTo(\App\Models\Employee::class, 'employee_id');
    }
}
