<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CtrlPages;

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
Pages
*/

# Home-related pages
Route::get('/',								[CtrlPages::class, "Home"]);
Route::get('/terms-conditions',			[CtrlPages::class, "TermsConditions"]);

# Portal-related pages
Route::get('/login',                   [CtrlPages::class, "LogIn"]);

Route::get('/dashboard',               [CtrlPages::class, "Dashboard"]);
