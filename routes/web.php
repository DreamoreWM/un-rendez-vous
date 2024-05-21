<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeCalendarController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SalonController;
use App\Http\Livewire\EmployeeCalendar;
use App\Models\Review;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PrestationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SalonSettingsController;
use App\Http\Controllers\PhotoPresController;
use App\Http\Controllers\EmployeeScheduleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('/', DashboardController::class);

// Route pour la redirection vers Google
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');

// Route pour le callback de Google
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');


Route::resource('/dashboard', DashboardController::class);

Route::get('/confidentiality', function () {
    return view('confidentiality');
})->name('confidentiality');

Route::middleware(['auth', 'can:user'])->group(function () {
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/employee-slots/{employeeId}', 'EmployeeController@getSlotsForEmployee');
    Route::resource('/prestations', PrestationController::class);
    Route::resource('/employees', EmployeeController::class);
    Route::resource('/users', UsersController::class);
    Route::get('/employees/{employee}/slots', [SlotController::class, 'index'])->name('employees.slots.index');
    Route::get('/salon/settings', [SalonController::class, 'edit'])->name('salon.edit');
    Route::put('/salon/settings', [SalonController::class, 'update'])->name('salon.update');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/events', [CalendarController::class, 'event'])->name('calendar.event');
    Route::get('/employees/{employee}/schedule', [EmployeeScheduleController::class, 'edit'])->name('employees.schedule.edit');
    Route::post('/employees/{employee}/schedule', [EmployeeScheduleController::class, 'store'])->name('employees.schedule.store');
    Route::post('/calendar', [CalendarController::class, 'assign'])->name('calendar.assign');
    Route::post('/calendar/delete', [CalendarController::class, 'delete']);
    Route::resource('/absences',AbsenceController::class);
    Route::resource('/reviews', ReviewController::class);
    Route::resource('/photos', PhotoPresController::class);
});

require __DIR__.'/auth.php';
