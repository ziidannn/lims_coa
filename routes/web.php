<?php

use App\Http\Controllers\CoaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Coa;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('index');

require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'coa'], function () {
    Route::any('/', [CoaController::class, 'index'])->name('coa.index')->middleware('auth');
    Route::get('/data', [CoaController::class, 'data'])->name('coa.data');
    Route::delete('/delete', [CoaController::class, 'delete'])->name('coa.delete');
    Route::any('/add', [CoaController::class, 'add'])->name('coa.add');
    Route::any('/create', [CoaController::class, 'create'])->name('coa.create');
    Route::any('/edit/{id}', [CoaController::class, 'edit'])->name('coa.edit');
});

Route::group(['prefix' => 'list_customer'], function () {
    Route::any('/', [CoaController::class, 'list_customer'])->name('list_customer.index')->middleware('auth');
    Route::any('/list_sample/{id}', [CoaController::class, 'list_sample'])->name('list_customer.list_sample');
    Route::get('/data', [CoaController::class, 'data'])->name('list_customer.data');
    Route::get('/getDataSample/{id}', [CoaController::class, 'getDataSample'])->name('list_customer.getDataSample');
});

// pdf route
Route::get('/resume_pdf/{customerId}/{subjectId}', [PDFController::class, 'showPdf'])->name('showPdf.pdf');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('log-viewers', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->middleware(['can:log-viewers.read']);

Route::group(['prefix' => 'setting','middleware' => ['auth']],function () {
    Route::group(['prefix' => 'manage_account'], function () {
        Route::group(['prefix' => 'users'], function () { //route to manage users
            Route::any('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/data', [UserController::class, 'data'])->name('users.data');
            Route::any('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
            Route::any('/reset_password/{id}', [UserController::class, 'reset_password'])->name('users.reset_password');
            Route::delete('/delete', [UserController::class, 'delete'])->name('users.delete');
        });
        Route::group(['prefix' => 'roles'], function () { //route to manage roles
            Route::any('/', [RoleController::class, 'index'])->name('roles.index');
            Route::get('/data', [RoleController::class, 'data'])->name('roles.data');
            Route::any('/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
            Route::delete('/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');
        });
        Route::group(['prefix' => 'permissions'], function () { //route to manage permissions

         Route::any('/', [PermissionController::class, 'index'])->name('permissions.index');
            Route::get('/data', [PermissionController::class, 'data'])->name('permissions.data');
            Route::get('/view/{id}', [PermissionController::class, 'view'])->name('permissions.view');
            Route::get('/view/{id}/users', [PermissionController::class, 'view_users_data'])->name('permissions.view_users_data');
            Route::get('/view/{id}/roles', [PermissionController::class, 'view_roles_data'])->name('permissions.view_roles_data');
        });
    });
});
