<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Controllers
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RoleController;

use App\Http\Controllers\System\ConfigurationController;
use App\Http\Controllers\System\ActivityLogController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);


// verification Protected routes
Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);
    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
    
    // Users
    Route::get('/userList', [UserController::class, 'userList']);
    Route::get('/userGetById/{id}', [UserController::class, 'userGetById']);
    Route::put('/userUpdate/{id}', [UserController::class, 'userUpdate']);
    Route::delete('/userDelete/{id}', [UserController::class, 'userDelete']);
    Route::get('/userProfileView/{id}', [UserController::class, 'userProfileView']);

    // Profile
    Route::post('/userProfileCreate', [ProfileController::class, 'userProfileCreate']);
    Route::get('/userProfileGetById/{id}', [ProfileController::class, 'userProfileGetById']);
    Route::put('/userProfileUpdate/{id}', [ProfileController::class, 'userProfileUpdate']);
    Route::delete('/userProfileDelete/{id}', [ProfileController::class, 'userProfileDelete']);
    
    //Profile Settings
    Route::post('/profileSettingPhotoUpdate', [ProfileController::class, 'profileSettingPhotoUpdate']);
    Route::post('/profileSettingPasswordUpdate', [ProfileController::class,'profileSettingPasswordUpdate']);
    
    //Roles
    Route::get('/roleList', [RoleController::class, 'roleList']);
    Route::get('/roleGetById/{id}', [RoleController::class, 'roleGetById']);
    Route::post('/roleCreate', [RoleController::class, 'roleCreate']);
    Route::put('/roleUpdate/{id}', [RoleController::class, 'roleUpdate']);
    Route::delete('/roleDelete/{id}', [RoleController::class, 'roleDelete']);

    //Configuration
    Route::get('/config', [ConfigurationController::class, 'config']);
    Route::put('/configUpdate', [ConfigurationController::class, 'configUpdate']);
    Route::get('/logList', [ActivityLogController::class, 'logList']);
});

