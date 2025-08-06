<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department_id',
    ];

    /**
     * علاقة كل مسمى وظيفي بقسم واحد
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
