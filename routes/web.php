<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CtrlHome;
use App\Http\Controllers\CtrlPortal;
use App\Http\Controllers\CtrlRequests;
use App\Http\Controllers\CtrlExtLinks;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*
Web Pages ***************************************
*/

# Home-related pages
Route::get('/',                                       [CtrlHome::class, "Home"]);
Route::get('/terms-conditions',                       [CtrlHome::class, "TermsConditions"]);

# Portal-related pages
Route::get('/login',                                  [CtrlPortal::class, "LogIn"])             ->name("login");
Route::get('/register',                               [CtrlPortal::class, "Register"]);
Route::get('/forgotpw',                               [CtrlPortal::class, "ForgotPW"]);

Route::get('/dashboard',                              [CtrlPortal::class, "Dashboard"])         ->name("dashboard")     ->middleware('auth');
Route::get('/newreport',                              [CtrlPortal::class, "NewReport"])                                 ->middleware('auth');
Route::get('/savedreports',                           [CtrlPortal::class, "SavedReports"]);
Route::get('/findreports',                            [CtrlPortal::class, "FindReports"]);
Route::get('/backup',                                 [CtrlPortal::class, "Backup"]);
Route::get('/restore',                                [CtrlPortal::class, "Restore"]);
Route::get('/templates',                              [CtrlPortal::class, "Templates"]);
Route::get('/howto',                                  [CtrlPortal::class, "HowTo"]);
Route::get('/contactus',                              [CtrlPortal::class, "ContactUs"]);
Route::get('/myaccount',                              [CtrlPortal::class, "MyAccount"]);


/*
Requests ****************************************
*/

# Extra-portal requests
Route::post('reqRegister',                            [CtrlRequests::class, "reqRegister"]);
Route::post('reqLogIn',                               [CtrlRequests::class, "reqSignIn"]);
Route::post('reqSignOut',                             [CtrlRequests::class, "reqSignOut"]);
Route::post('reqForgotPW',                            [CtrlRequests::class, "reqForgotPW"]);
Route::post('reqCreatePW',                            [CtrlRequests::class, "reqCreatePW"]);


/*
External links **********************************
*/

# Email verification
Route::get('/emailverification/{email}/{code}',       [CtrlExtLinks::class, "EmailVerification"]);

# Password reset
Route::get('/emailverification/{email}/{code}',       [CtrlExtLinks::class, "EmailVerification"]);
Route::get('/passwordreset/{email}/{code}',           [CtrlExtLinks::class, "CreatePassword"]);


/*
DEBUG-only **************************************
*/
if (config('app.debug')) {
   # EMail view: EmailVerify
   Route::get('/emailview/EmailVerify/{is_newreg?}', function($is_newreg = true) {
      return new App\Mail\EmailVerify("DemoUserName", $is_newreg, "a@b.com", "000");
   });

   # Email view: PasswordReset
   Route::get('/emailview/PasswordReset', function() {
      return new App\Mail\PasswordReset("DemoUserName", "a@b.com", "000");
   });
}
