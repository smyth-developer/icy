<?php

use App\Livewire\Notes;

use App\Livewire\Back\Management\Location\Locations;
use App\Livewire\Back\Management\Season\Seasons;
use App\Livewire\Back\Management\Program\Programs;
use App\Livewire\Back\Management\Subject\Subjects; 
use App\Livewire\Back\Management\Course\Courses;
use App\Livewire\Back\Management\curriculum\Curricula;

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'preventBackHistory'])
    ->name('dashboard');

Route::middleware(['auth', 'preventBackHistory'])->group(function () {

    Route::prefix('management')->name('management.')->group(function () {

        Route::get('notes', Notes::class)->name('notes');

        Route::get('locations', Locations::class)->name('locations');

        Route::get('seasons', Seasons::class)->name('seasons');

        Route::get('programs', Programs::class)->name('programs');

        Route::get('subjects', Subjects::class)->name('subjects');

        Route::get('courses', Courses::class)->name('courses');

        Route::get('curricula', Curricula::class)->name('curricula');

    });

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
