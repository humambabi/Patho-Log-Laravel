<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CtrlHome;
use App\Http\Controllers\CtrlPortal;
use App\Http\Controllers\CtrlRequests;

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
Web Pages
*/

# Home-related pages
Route::get('/',                        [CtrlHome::class, "Home"]);
Route::get('/terms-conditions',        [CtrlHome::class, "TermsConditions"]);

# Portal-related pages
Route::get('/login',                   [CtrlPortal::class, "LogIn"]);
Route::get('/register',                [CtrlPortal::class, "Register"]);

Route::get('/dashboard',               [CtrlPortal::class, "Dashboard"]);
Route::get('/newreport',               [CtrlPortal::class, "NewReport"]);
Route::get('/savedreports',            [CtrlPortal::class, "SavedReports"]);
Route::get('/findreports',             [CtrlPortal::class, "FindReports"]);
Route::get('/backup',                  [CtrlPortal::class, "Backup"]);
Route::get('/restore',                 [CtrlPortal::class, "Restore"]);
Route::get('/templates',               [CtrlPortal::class, "Templates"]);
Route::get('/howto',                   [CtrlPortal::class, "HowTo"]);
Route::get('/contactus',               [CtrlPortal::class, "ContactUs"]);
Route::get('/myaccount',               [CtrlPortal::class, "MyAccount"]);


/*
Http requests
*/

# Extra-portal requests
Route::post('reqLogIn',                [CtrlRequests::class, "reqSignIn"]);
Route::post('reqRegister',             [CtrlRequests::class, "reqRegister"]);
