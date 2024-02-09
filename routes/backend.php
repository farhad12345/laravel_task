<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\PermissionController;
// Route::middleware(['auth','varified'])->group(function(){

// });

Route::middleware(['auth.passport'])->prefix('admin')->name('admin.')->group(function () {
    //Admin Dashboard Route
    Route::get('/dashboard', [AuthController::class, 'AdminDashboard'])->name('dashboard');
    Route::resource('company', CompanyController::class);

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

    Route::resource('users', UserController::class);
    // routes/web.php
    Route::post('/users_update', [UserController::class, 'Update'])->name('users_update');
    Route::get('usersdata', [UserController::class, 'getUsersData'])->name('usersdata');

    Route::get('/users/resumes/{id}/{template_id}', [AdminController::class, 'GetUserResumes'])->name('users.resumes');
    Route::post('/update-experience', [AdminController::class, 'updateExperience'])->name('update.experience');
    Route::post('/create-experience', [AdminController::class, 'createExperience'])->name('create.experience');
    Route::get(
        '/test',
        [UserController::class, 'test']
    )->name('test');

    //Permission Controller
    Route::post('permissions/store', [PermissionController::class, 'store'])->name('permissions.store');

    Route::post('/assign-permissions', [PermissionController::class, 'AssignPermission'])->name('assign-permissions');
    Route::get('get-permissions', [PermissionController::class, 'GetPermissions'])->name('get-permissions');
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::post('/assign-permissions', [PermissionController::class, 'AssignPermission'])->name('assign-permissions');
    Route::get('/get-role-permissions/{roleId}', [PermissionController::class, 'getRolePermissions']);

    //Roles
    Route::resource('roles', RolesController::class);
    Route::get('get-roles', [RolesController::class, 'GetRoles'])->name('get-roles');
    Route::post('roles_update', [RolesController::class, 'update'])->name('roles_update');

    //User Profile
    Route::get('/profile', [UserController::class, 'ProfileView'])->name('profile');
    Route::post('/update-profile', [UserController::class, 'ProfileUpdate'])->name('update-profile');
    //   update-profile

});
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/register', [AuthController::class, 'register'])->name('admin.register');

Route::get('/supperadmin', [AuthController::class, 'AddSupperAdmin']);
