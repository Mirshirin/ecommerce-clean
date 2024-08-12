<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\OrderReportController;
use App\Http\Controllers\Admin\UserPermissionController;



Route::get('/login', function () {
    return redirect('/admin/dashboard');
});
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');



Route::resource('users',UserController::class);
Route::resource('permissions',PermissionController::class);
Route::resource('roles',RoleController::class);
Route::resource('products',ProductController::class);
Route::resource( 'orders',OrderController::class);
Route::resource('categories',CategoryController::class);


//user mangement
Route::get('/change-password', [UserController::class, 'changePassword'])->name('change-password');
Route::patch('/update-password', [UserController::class, 'updatePassword'])->name('update-password');

// //permission and role user 
Route::get('/users/{id}/permissions',[UserPermissionController::class,'createUserPermission'])->name('users.permissions')->middleware('can:staff-user-permission');
Route::post('/users/{id}/permissions',[UserPermissionController::class,'storeUserPermission'])->name('users.permissions.store')->middleware('can:staff-user-permission');


Route::get('/search',[SearchController::class,'search'])->name('search');
//all-orders

Route::get('/delivered/{id}',[OrderController::class,'delivered'])->name('delivered');
Route::get('/print-pdf/{id}',[OrderReportController::class,'printPdf'])->name('print-pdf');