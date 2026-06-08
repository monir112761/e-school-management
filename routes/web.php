<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\SchoolController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Teacher\ResultController as TeacherResultController;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\ResultController as StudentResultController;
use App\Http\Controllers\Student\AdmitCardController as StudentAdmitCardController;
use App\Http\Controllers\Student\FeeController as StudentFeeController;
use App\Http\Controllers\Guardian\DashboardController as GuardianDashboard;
use App\Http\Controllers\Guardian\ChildResultController as ChildResultController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    
    // Redirect to appropriate dashboard based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        return match($user->role) {
            'super_admin' => redirect()->route('super-admin.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            'guardian' => redirect()->route('guardian.dashboard'),
            default => abort(403, 'Invalid role'),
        };
    })->name('dashboard');

    // Super Admin Routes
    Route::middleware('role:super_admin')->prefix('super-admin')->name('super-admin.')->group(function () {
        Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('dashboard');
        
        Route::resource('schools', SchoolController::class);
    });

    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        
        // Academic Management
        Route::resource('classes', ClassController::class);
        Route::resource('subjects', SubjectController::class);
        
        // Student Management
        Route::resource('students', StudentController::class);
        
        // Attendance
        Route::resource('attendance', AttendanceController::class, ['only' => ['index', 'create', 'store']]);
        
        // Exam Management
        Route::resource('exams', ExamController::class);
        
        // Results
        Route::resource('results', ResultController::class, ['only' => ['index', 'create', 'store']]);
        
        // Fee Management
        Route::resource('fees', FeeController::class);
        Route::get('/fees-payments', [FeeController::class, 'payments'])->name('fees.payments');
    });

    // Teacher Routes
    Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [TeacherDashboard::class, 'index'])->name('dashboard');
        
        // Attendance Management
        Route::resource('attendance', TeacherAttendanceController::class, ['only' => ['index', 'create', 'store']]);
        
        // Result Management
        Route::resource('results', TeacherResultController::class, ['only' => ['index', 'create', 'store']]);
    });

    // Student Routes
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');
        
        // Results
        Route::resource('results', StudentResultController::class, ['only' => ['index', 'show']]);
        
        // Admit Cards
        Route::resource('admit-cards', StudentAdmitCardController::class, ['only' => ['index']]);
        Route::get('admit-cards/{admitCard}/download', [StudentAdmitCardController::class, 'download'])->name('admit-cards.download');
        
        // Fee Status
        Route::resource('fees', StudentFeeController::class, ['only' => ['index']]);
    });

    // Guardian Routes
    Route::middleware('role:guardian')->prefix('guardian')->name('guardian.')->group(function () {
        Route::get('/dashboard', [GuardianDashboard::class, 'index'])->name('dashboard');
        
        // Child Results
        Route::get('/children/results/{childId?}', [ChildResultController::class, 'index'])->name('children.results');
    });
});

// Authentication routes (minimal custom login)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => __('The provided credentials do not match our records.'),
        ])->onlyInput('email');
    });
});

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');
//require __DIR__.'/auth.php';
