<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\ProfileController;

// Enable full authentication with email verification enabled
Auth::routes(['verify' => true]);

// Serve media files (direct access to media without /storage prefix)
Route::get('/media/{id}/{filename}', function ($id, $filename) {
    $media = Media::findOrFail($id);
    if ($media->file_name !== $filename) {
        abort(404);
    }
    return Response::file($media->getPath());
})->where(['id' => '[0-9]+', 'filename' => '.*'])->name('media.custom');

// Custom resend verification route (because you got that error)
Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->intended('/dashboard');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Verification link sent!');
})->middleware(['auth'])->name('verification.send');

// Routes that require authentication (no need for verified middleware here)
Route::middleware(['auth'])->group(function () {

    Route::get('/', fn() => view('index'))->name('home');

    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('updatePassword');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:super_admin|admin|membre')
        ->name('dashboard');

    // Super admin routes
    Route::prefix('super-admin')->name('superadmin.')->middleware('role:super_admin')->group(function () {
        Route::get('associations', [AssociationController::class, 'index'])->name('associations.index');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin|super_admin')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('associations', AssociationController::class);
        Route::resource('membres', UserController::class);
        Route::resource('meetings', MeetingController::class);
        Route::resource('cotisations', CotisationController::class);
        Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    });

    // Dynamic pages
    Route::get('{routeName}/{name?}', [HomeController::class, 'pageView']);
});
