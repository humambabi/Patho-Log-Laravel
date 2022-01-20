<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CtrlHome;
use App\Http\Controllers\CtrlPortal;
use App\Http\Controllers\CtrlRequests;
use App\Http\Controllers\CtrlExtLinks;
use App\Http\Controllers\CtrlResources;


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
- Search for route names using "route('xxx')
*/

# Home-related pages
Route::get('/',                                       [CtrlHome::class, "Home"]);
Route::get('/terms-conditions',                       [CtrlHome::class, "TermsConditions"]);

# Portal-related pages
Route::get('/login',                                  [CtrlPortal::class, "LogIn"])             ->name("login");
Route::get('/register',                               [CtrlPortal::class, "Register"]);
Route::get('/forgotpw',                               [CtrlPortal::class, "ForgotPW"]);

Route::get('/default',                                [CtrlPortal::class, "Default"]);
Route::get('/dashboard',                              [CtrlPortal::class, "Dashboard"])         ->name("dashboard");
Route::get('/newreport',                              [CtrlPortal::class, "NewReport"])         ->name("newreport");
Route::get('/savedreports',                           [CtrlPortal::class, "SavedReports"]);
Route::get('/backup',                                 [CtrlPortal::class, "Backup"]);
Route::get('/restore',                                [CtrlPortal::class, "Restore"]);
Route::get('/templates',                              [CtrlPortal::class, "Templates"]);
Route::get('/howto',                                  [CtrlPortal::class, "HowTo"]);
Route::get('/contact',                                [CtrlPortal::class, "Contact"]);
Route::get('/myaccount',                              [CtrlPortal::class, "MyAccount"]);



/*
Requests ****************************************
*/

# Extra-portal requests
Route::post('reqRegister',                            [CtrlRequests::class, "reqRegister"]);
Route::post('reqLogIn',                               [CtrlRequests::class, "reqSignIn"]);
Route::post('reqSignOut',                             [CtrlRequests::class, "reqSignOut"]);
Route::post('reqForgotPW',                            [CtrlRequests::class, "reqForgotPW"]);
Route::post('reqNewPW',                               [CtrlRequests::class, "reqNewPW"]);

# Social requests (could be portal or extra-portal)
Route::post('reqSocialRegLogIn',                      [CtrlRequests::class, "reqSocialRegisterOrSignIn"]);

# Template-related requests
Route::post('reqTplStepFields',                       [CtrlRequests::class, "reqTplStepFields"]);
Route::post('reqTplGetPreview',                       [CtrlRequests::class, "reqTplGetPreview"]);



/*
Resources ***************************************
*/

# Template-related resources
Route::get('resTemplateThumbnail/{tplID}',            [CtrlResources::class, "TemplateThumbnail"]);
Route::get('resReportPreview/{imgId}',                [CtrlResources::class, "ReportPreview"]);


/*
External links **********************************
*/

# Email verification
Route::get('/emailverification/{email}/{code}',       [CtrlExtLinks::class, "EmailVerification"]);

# Password reset
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
