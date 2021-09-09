<?php
namespace App\Http\Controllers;

use App\Mail\EmailVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class CtrlRequests extends Controller
{
   ################################################################################################
   public function reqRegister(Request $request) {
      # Create a manual validator to prevent returning 422 html error
      $Validator = Validator::make($request->all(), [
         'username'  => ['bail', 'required', 'between:' . config('consts.USERNAME_MINLENGTH') . ',' . config('consts.USERNAME_MAXLENGTH')],
         'email'     => ['bail', 'required', 'email', 'max:' . config('consts.EMAIL_MAXLENGTH'), 'unique:users,email'],
         'password'  => ['bail', 'required', 'min:' . config('consts.PASSWORD_MINLENGTH'), 'max:' . config('consts.PASSWORD_MAXLENGTH')],
         'terms'     => ['bail', 'accepted'],
         'gr_token'  => ['bail', 'required']
      ]);

      # Return error message gracefully
      if ($Validator->fails()) {
         $errors = $Validator->errors();

         if (!empty($errors->first('username'))) {
            return response()->json(['retcode' => config('consts.ERR_WITHMSG_USERNAME'), 'errmsg' => $errors->first('username')]);
         }
         if (!empty($errors->first('email'))) {
            return response()->json(['retcode' => config('consts.ERR_WITHMSG_EMAIL'), 'errmsg' => $errors->first('email')]);
         }
         if (!empty($errors->first('password'))) {
            return response()->json(['retcode' => config('consts.ERR_WITHMSG_PASSWORD'), 'errmsg' => $errors->first('password')]);
         }
         if (!empty($errors->first('terms'))) {
            return response()->json(['retcode' => config('consts.ERR_WITHMSG_TERMS'), 'errmsg' => $errors->first('terms')]);
         }
         if (!empty($errors->first('gr_token'))) {
            return response()->json(['retcode' => config('consts.ERR_WITHMSG'), 'errmsg' => $errors->first('gr_token')]);
         }
      }

      # Retrieve the validated input
      $Validated = $Validator->validated();

      # Check Google reCAPTCHA v3
      if (reCAPTCHAv3Check($Validated['gr_token'], config("consts.GR_ACTION_ACCOUNTREGISTER"), $request) != TRUE) {
         return response()->json(['retcode' => config('consts.ERR_WITHMSG'), 'errmsg' => config('consts.MSG_RECAPTCHA_FAILED')]);
      }

      # Done verifying. Save the user record in the database
      $verification_code = Str::random(25);

      $result = DB::insert("INSERT INTO `users`(`name`, `email`, `pw_hash`, `reg_datetime`, `verification_code`, " .
         "`is_emailverified`, `ipaddrs_obj`, `is_admin`) VALUES(:nam, :eml, :pwh, :rdt, :vfc, :evf, :ipo, :adm);", [
            'nam' => $Validated['username'],
            'eml' => $Validated['email'],
            'pwh' => hash_password($Validated['password']),
            'rdt' => gmdate(config('consts.DB_DATETIME_FMT')),
            'vfc' => $verification_code,
            'evf' => 0,
            'ipo' => json_encode([$request->ip() => ["count" => 1, "lastlogin" => gmdate(config('consts.DB_DATETIME_FMT'))]]),
            'adm' => 0
         ]
      );
      if (empty($result)) return response()->json(['retcode' => config('consts.ERR_UNEXPECTED')]);

      # Send verification email (actually queue and return immediately) (inside, set the "vercode_datetime" column)
      Mail::to($Validated['email'])->queue(new EmailVerify(
         $Validated['username'],
         true,
         $Validated['email'],
         $verification_code
      ));

      laravel_queueworker(); # Process the queue (start the worker daemon and return immediately)

      return response()->json([
         'retcode'   => config('consts.ERR_NOERROR'),
         'msgTitle'  => "Success",
         'msgHtml'   => "<p>Thank you for signing up!</p><p>Check you email inbox for verification instructions.</p>",
         'msgIcon'   => "success"
      ]);
   }


   ################################################################################################
   public function reqSignIn(Request $request) {
      $validated = $request->validate([
         'email'     => ['bail', 'required', 'email', 'max:' . config('consts.EMAIL_MAXLENGTH')],
         'password'  => ['bail', 'required', 'between:' . config('consts.PASSWORD_MINLENGTH') . ',' . config('consts.PASSWORD_MAXLENGTH')],
         'remember'  => ['bail', 'required']
      ]);

      return $validated;

      /*
            # Send a welcome email
            $result = Mail::to($param_email)->send(new Welcome());
      */

      #
      return ['retcode' => 1, 'retdata' => "You have been subscribed to our newsletter."];
   }
}
