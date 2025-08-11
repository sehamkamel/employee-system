<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'department',
        'job_title',
        'hired_at',
        'salary',
        'address',
    ];
    
    protected $casts = [
        'hired_at' => 'datetime',
    ];

    /**
     * Relationship with the User model
     */
   public function leaveRequests()
{
    return $this->hasMany(LeaveRequest::class);
}


    public function user()
    {
      return $this->belongsTo(User::class);
    }


        /**
     * Relationship with the Department model
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department');
    }


    /**
     * Relationship with the Attendance model
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

       protected static function boot()
    {
        parent::boot();

        static::deleting(function ($employee) {
            if ($employee->user) {
                $employee->user->delete();
            }
        });
    }
}

