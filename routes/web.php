<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AssociationController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\CotisationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MeetingController;

Auth::routes();

// Serve media files (remove /storage from URLs)
Route::get('/media/{id}/{filename}', function ($id, $filename) {
    $media = Media::findOrFail($id);
    if ($media->file_name !== $filename) {
        abort(404);
    }
    return Response::file($media->getPath());
})->where(['id' => '[0-9]+', 'filename' => '.*'])->name('media.custom');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    Route::get('/', fn() => view('index'));

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('role:super_admin|admin|membre')
    ->name('dashboard');

    // Super Admin-only routes
    Route::middleware('role:super_admin')->prefix('super-admin')->name('superadmin.')->group(function () {
        Route::get('associations', [AssociationController::class, 'index'])->name('associations.index');
    });

    // Admin & Super Admin routes
    Route::middleware('role:admin|super_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('associations', AssociationController::class);
        Route::resource('membres', UserController::class);
        Route::resource('meetings', MeetingController::class);
        Route::resource('cotisations', CotisationController::class); // ✅ Moved here
    });

    // Catch-all fallback route
    Route::get('{routeName}/{name?}', [HomeController::class, 'pageView']);
});

