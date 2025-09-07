<?php

use App\Livewire\Settings\Profile;


// Settings
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Settings\Notification;
use App\Livewire\Back\Access\Role\Roles;

// Access
use App\Livewire\Settings\AuthenticationLogs;

// Finance
use App\Livewire\Back\Personnel\Employee\Staff;
use App\Livewire\Back\Finance\Bank\AccountsBank;

// Personnel
use App\Livewire\Back\Management\Course\Courses;
use App\Livewire\Back\Management\Season\Seasons;
//use App\Livewire\Back\Personnel\Registration\StaffsRegistration;
//use App\Livewire\Back\Personnel\Registration\StudentsRegistration;

// Management
use App\Livewire\Back\Personnel\Student\Students;
use App\Livewire\Back\Management\Program\Programs;
use App\Livewire\Back\Management\Subject\Subjects;
use App\Livewire\Back\Management\Syllabus\Syllabi;

use App\Livewire\Back\Access\Permission\Permissions;
use App\Livewire\Back\Management\Location\Locations;
use App\Livewire\Back\Finance\Tuition\TuitionsHistory;
use App\Livewire\Back\Finance\Tuition\TuitionsPayment;
use App\Livewire\Back\Management\Curriculum\Curricula;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'preventBackHistory'])
    ->name('dashboard');

Route::prefix('admin')->middleware(['auth', 'preventBackHistory'])->name('admin.')->group(function () {

    Route::prefix('management')->name('management.')->group(function () {

        Route::get('locations', Locations::class)->name('locations');

        Route::get('seasons', Seasons::class)->name('seasons');

        Route::get('programs', Programs::class)->name('programs');

        Route::get('subjects', Subjects::class)->name('subjects');

        Route::get('courses', Courses::class)->name('courses');

        Route::get('syllabi', Syllabi::class)->name('syllabi');

        Route::get('curricula', Curricula::class)->name('curricula');
    });

    Route::prefix('access')->name('access.')->group(function () {

        Route::get('roles', Roles::class)->name('roles');

        Route::get('permissions', Permissions::class)->name('permissions');
    });

    Route::prefix('personnel')->name('personnel.')->group(function () {

        Route::get('staff', Staff::class)->name('staff');

        //Route::get('staff-registration', StaffsRegistration::class)->name('staff-registration');

        Route::get('students', Students::class)->name('students');

        //Route::get('student-registration', StudentsRegistration::class)->name('student-registration');
    });

    Route::prefix('finance')->name('finance.')->group(function () {

        Route::get('bank-accounts', AccountsBank::class)->name('bank-accounts');

        Route::get('tuition-history', TuitionsHistory::class)->name('tuition-history');

        Route::get('tuitions-payment', TuitionsPayment::class)->name('tuitions-payment');

    });

    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('settings/notification', Notification::class)->name('settings.notification');
    Route::get('settings/authentication-logs', AuthenticationLogs::class)->name('settings.authentication-logs');
});

require __DIR__ . '/auth.php';
