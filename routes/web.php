<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\Admin\ContributionController;
use App\Http\Controllers\Admin\ExpenseController;

Auth::routes(['verify' => true]);

Route::get('/media/{id}/{filename}', function ($id, $filename) {
    $media = Media::findOrFail($id);
    if ($media->file_name !== $filename) {
        abort(404);
    }
    return Response::file($media->getPath());
})->where(['id' => '[0-9]+', 'filename' => '.*'])->name('media.custom');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->intended('/dashboard');
    }

    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Verification link sent!');
})->middleware(['auth'])->name('verification.send');

Route::get('/user-guide', function () {
    return view('user-guide');
})->name('user-guide')->middleware(['auth']);

Route::middleware(['auth'])->group(function () {

    Route::get('/', fn() => view('index'))->name('home');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('updatePassword');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:superadmin|admin|board|supervisor|member')
        ->name('dashboard');
    Route::get('/statistics', [StatisticsController::class, 'index'])
        ->middleware('role:superadmin|admin|board|supervisor|member')
        ->name('statistics');

    Route::prefix('admin')->name('admin.')->group(function () {

        // Superadmin only routes
        Route::middleware('role:superadmin')->group(function () {
            Route::resource('roles', RoleController::class);
            Route::resource('permissions', PermissionController::class);
            Route::resource('associations', AssociationController::class);
        });

        // Admin + Superadmin + Board routes
        Route::middleware('role:admin|superadmin|board')->group(function () {
            Route::resource('expenses', ExpenseController::class);
            Route::resource('cotisations', CotisationController::class);
            Route::resource('events', EventController::class);
            Route::resource('contributions', ContributionController::class);
            Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');
        });

        // Admin + Superadmin + Board + Supervisor + Member routes
        Route::middleware('role:admin|superadmin|board|supervisor|member')->group(function () {
            // Explicit model binding for membres resource
            Route::resource('membres', UserController::class, [
                'parameters' => [
                    'membres' => 'user:id' // Explicit binding with ID
                ]
            ]);

            Route::resource('meetings', MeetingController::class)->except(['show']);
            Route::get('meetings/{meeting}', [MeetingController::class, 'show'])->name('meetings.show');
            Route::delete('meetings/{meeting}/media/{media}', [MeetingController::class, 'removeMedia'])->name('meetings.removeMedia');
        });
    });

    // Member-specific views
    Route::middleware('role:member')->group(function () {
        Route::get('/my-events', [EventController::class, 'index'])->name('membre.events.index');
        Route::get('/cotisations', [CotisationController::class, 'index'])->name('membre.cotisations.index');
    });

    // CMS fallback
    Route::get('{routeName}/{name?}', [HomeController::class, 'pageView']);
});
Route::get('/test-error', function () {
    abort(500);
});
// === Fallback for 404 Not Found ===
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

