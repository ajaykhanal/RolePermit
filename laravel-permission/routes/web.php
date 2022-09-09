<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/user-profile', function () {
    return view('admin.users.profile');
})->middleware(['auth','role:user'])->name('user_profile');

Route::post('update-profile/{id}',[IndexController::class,'update_profile_data'])->name('update_profile_data')->middleware(['auth','role:user']);
Route::get('change-password',[IndexController::class,'change_password'])->name('change_password')->middleware(['auth','role:user']);
Route::post('update_password',[IndexController::class,'update_password'])->name('update_password');
Route::get('create-post',[PostController::class,'create_post'])->name('create_post')->middleware(['auth','role:writer']);
Route::post('post-data',[PostController::class,'post_data'])->name('post_data');
Route::get('all-posts',[PostController::class,'index'])->name('all_posts')->middleware(['auth','role:user|admin']);

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::resource('/roles', RoleController::class);
    Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::resource('/permissions', PermissionController::class);
    Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
    Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');

    Route::resource('/posts', PostController::class);
    Route::post('/posts/{post}/roles', [PostController::class, 'assignRole'])->name('posts.roles');
    Route::delete('/posts/{post}/roles/{role}', [PostController::class, 'removeRole'])->name('posts.roles.remove');
});

require __DIR__ . '/auth.php';
