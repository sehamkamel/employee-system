<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;

Route::get('/', function () {
    return redirect()->route('login');
});

// الموظفين: إنشاء طلب إجازة
Route::middleware(['role:employee'])->group(function () {
    Route::get('leave-requests/create', [LeaveRequestController::class, 'create'])->name('leave-requests.create');
    Route::post('leave-requests', [LeaveRequestController::class, 'store'])->name('leave-requests.store');
    Route::delete('leave-requests/{id}', [LeaveRequestController::class, 'destroy'])->name('leave-requests.destroy');
});

// الموظفين + HR: عرض الطلبات
Route::middleware(['role:employee,hr'])->group(function () {
    Route::get('leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
});

// HR: تحديث حالة الإجازة
Route::middleware(['role:hr'])->group(function () {
    Route::patch('/leave-requests/{id}/status/{status}', [LeaveRequestController::class, 'updateStatus'])
        ->name('leave-requests.updateStatus');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('employees', EmployeeController::class);

    // حضور الموظفين
    Route::middleware(['role:employee'])->group(function () {
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
        Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    });

    // عرض الحضور للإدارة والـ HR
    Route::middleware(['role:admin,hr'])->group(function () {
        Route::get('/admin/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    });

    // البروفايل
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
