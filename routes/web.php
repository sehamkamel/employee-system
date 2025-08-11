<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;

Route::get('/', function () {
    return redirect()->route('login');
});

// بعد تسجيل الدخول فقط
Route::middleware(['auth'])->group(function () {

    // متاح للجميع بعد تسجيل الدخول
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ====== صلاحيات Admin و HR فقط ======
    Route::middleware(['role:admin,hr'])->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::resource('departments', DepartmentController::class);

        // عرض كل الحضور
        Route::get('/admin/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    });

    // ====== صلاحيات Employee فقط ======
    Route::middleware(['role:employee'])->group(function () {
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
        Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    });

    // ====== البروفايل للجميع ======
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



