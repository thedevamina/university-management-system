<?php
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\Admin\FeeController;

use App\Http\Controllers\Admin\TimetableController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return view('dashboards.admin');
    } elseif ($user->isFaculty()) {
        return view('dashboards.faculty');
    } else {
        return view('dashboards.student');
    }
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/admin-test', function () {
    return 'Welcome Admin! You have access.';
})->middleware(['auth', 'role:admin'])->name('admin.test');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('departments', DepartmentController::class);
    Route::resource('faculty', FacultyController::class);
    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);

    Route::resource('fees', FeeController::class)->only(['index','create','store','destroy']);
    Route::patch('fees/{fee}/mark-paid', [FeeController::class, 'markPaid'])->name('fees.markPaid');
    Route::resource('timetables', TimetableController::class);
});
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::resource('enrollments', EnrollmentController::class)->only(['index', 'store', 'destroy']);
     Route::get('results', [ResultController::class, 'myResults'])->name('results');
      Route::get('fees', [FeeController::class, 'myFees'])->name('fees');
});

Route::middleware(['auth', 'role:faculty'])->prefix('faculty')->name('faculty.')->group(function () {
    Route::get('attendance', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store');

    Route::resource('exams', ExamController::class);

    Route::get('results/{exam}', [ResultController::class, 'create'])->name('results.create');
    Route::post('results/{exam}', [ResultController::class, 'store'])->name('results.store');
});
require __DIR__.'/auth.php';
