<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\QAController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\Api\ApiController;
Route::post('/check-cnic',[CaptchaController::class,'checkCnic'])->name('check.cnic');
Route::post('/checkauthorizedlogin', [ApiController::class, 'checkAuthorizedLogin']);
Route::post('/storeauthorizedloginrequest', [ApiController::class, 'storeAuthorizedLoginRequest']);
Route::post('/login', [ApiController::class, 'login']);
Route::post('/add-profile-picture', [ApiController::class, 'addProfilePicture']);
Route::post('/get-properties-by-cnic', [ApiController::class, 'getPropertiesByCnic']);
Route::post('/getuserdetails', [ApiController::class, 'getUserDetails']);
Route::post('/resetpassword', [ApiController::class, 'resetPassword']);
Route::post('/updateuseremail', [ApiController::class, 'updateUserEmail']);
Route::get('gettown/{id}', [ApiController::class, 'getTownById']);

use App\Http\Controllers\Api\OtpController;
Route::post('/generate-otp', [OtpController::class, 'generateOtp']);
Route::post('/verify-otp', [OtpController::class, 'verifyOtp']);