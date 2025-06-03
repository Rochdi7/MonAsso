<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AssociationController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\CotisationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Membre\DashboardController;
use App\Http\Controllers\Admin\MembreController;



Auth::routes();

// Routes that require authentication
Route::middleware(['auth'])->group(function () {

    // Main dashboard view for all roles
    Route::get('/', function () {
        return view('index');
    });

    // Dashboard for all roles
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:membre|admin|super_admin')
        ->name('dashboard');

    // Routes only for Super Admin
    Route::middleware(['role:super_admin'])->prefix('super-admin')->name('superadmin.')->group(function () {
        Route::get('associations', [AssociationController::class, 'index'])->name('associations.index');
        // You can add more routes here
    });

    // Routes for Admin and Super Admin
    Route::middleware(['role:admin|super_admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('evenements', EventController::class);
        Route::resource('cotisations', CotisationController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('associations', AssociationController::class);
        Route::resource('membres', MembreController::class);

    });

    // Catch-all for dynamic content pages
    Route::get('{routeName}/{name?}', [HomeController::class, 'pageView']);
});
