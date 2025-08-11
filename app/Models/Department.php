<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // ✅ أضيفي الحقول اللي عايزة تحفظيها
    protected $fillable = ['name', 'description'];

    public function jobTitles()
    {
        return $this->hasMany(JobTitle::class);
    }

// Department.php
public function employees()
{
    return $this->hasMany(Employee::class, 'department', 'name');
}


}

