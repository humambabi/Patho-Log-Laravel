<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\EmailVerify;
use App\Mail\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
      if (reCAPTCHAv3Check($Validated['gr_token'], config("consts.GR_ACTION_ACCOUNTREGISTER"), $request->ip()) != TRUE) {
         return response()->json(['retcode' => config('consts.ERR_WITHMSG'), 'errmsg' => config('consts.MSG_RECAPTCHA_FAILED')]);
      }

      # Done verifying. Save the user record in the database
      $verification_code = Str::random(25);

      $modUser = User::create([
         'name'               => $Validated['username'],
         'email'              => $Validated['email'],
         'password'           => Hash::make($Validated['password']),
         'reg_datetime'       => gmdate(config('consts.DB_DATETIME_FMT')),
         'verification_code'  => $verification_code,
         'vercode_datetime'   => gmdate(config('consts.DB_DATETIME_FMT')),
         'ipaddrs_obj'        => json_encode([$request->ip() => ["count" => 1, "lastlogin" => gmdate(config('consts.DB_DATETIME_FMT'))]])
      ]);
      if (empty($modUser)) return response()->json(['retcode' => config('consts.ERR_UNEXPECTED')]);

      # Send verification email (actually queue and return immediately)
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
      # Create a manual validator to prevent returning 422 html error
      $Validator = Validator::make($request->all(), [
         'email'     => ['bail', 'required', 'email', 'max:' . config('consts.EMAIL_MAXLENGTH')],
         'password'  => ['bail', 'required', 'min:' . config('consts.PASSWORD_MINLENGTH'), 'max:' . config('consts.PASSWORD_MAXLENGTH')],
         'remember'  => ['nullable', 'boolean']
      ]);

      # Return error message gracefully
      if ($Validator->fails()) {
         $errors = $Validator->errors();

         if (!empty($errors->first('email'))) {
            return response()->json(['retcode' => config('consts.ERR_WITHMSG_EMAIL'), 'errmsg' => $errors->first('email')]);
         }
         if (!empty($errors->first('password'))) {
            return response()->json(['retcode' => config('consts.ERR_WITHMSG_PASSWORD'), 'errmsg' => $errors->first('password')]);
         }
         if (!empty($errors->first('remember'))) {
            return response()->json(['retcode' => config('consts.ERR_WITHMSG'), 'errmsg' => $errors->first('remember')]);
         }
      }

      # Retrieve the validated input
      $Validated = $Validator->validated();

      if (Auth::attempt(['email' => $Validated['email'], 'password' => $Validated['password']], $Validated['remember'])) {
         # Authenticated
         $request->session()->regenerate();
         return response()->json(['retcode' => config('consts.ERR_NOERROR')]);
      } else {
         # Bad credentials
         return response()->json(['retcode' => config('consts.ERR_WITHMSG'), 'errmsg' => "Wrong email or password!"]);
      }
   }


   ################################################################################################
   public function reqSignOut(Request $request) {
      # This request has no data, not even a CSRF Token (it's disabled)

      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();

      # No need to return anything, but just in case it's needed for debugging.
      return response()->json(['retcode' => config('consts.ERR_NOERROR')]);
   }


   ################################################################################################
   public function reqForgotPW(Request $request) {
      # Create a manual validator to prevent returning 422 html error
      $Validator = Validator::make($request->all(), [
         'email'     => ['bail', 'required', 'email', 'max:' . config('consts.EMAIL_MAXLENGTH')],
         'gr_token'  => ['bail', 'required']
      ]);

      # Return error message gracefully
      if ($Validator->fails()) {
         $errors = $Validator->errors();

         if (!empty($errors->first('email'))) {
            return response()->json(['retcode' => config('consts.ERR_WITHMSG_EMAIL'), 'errmsg' => $errors->first('email')]);
         }
         if (!empty($errors->first('gr_token'))) {
            return response()->json(['retcode' => config('consts.ERR_WITHMSG'), 'errmsg' => $errors->first('gr_token')]);
         }
      }

      # Retrieve the validated input
      $Validated = $Validator->validated();

      # Check Google reCAPTCHA v3
      if (reCAPTCHAv3Check($Validated['gr_token'], config("consts.GR_ACTION_RESETPASSWORD"), $request->ip()) != TRUE) {
         return response()->json(['retcode' => config('consts.ERR_WITHMSG'), 'errmsg' => config('consts.MSG_RECAPTCHA_FAILED')]);
      }

      # Check that the given email address exists in our DB
      $modUser = User::where('email', $Validated['email'])->first();
		if (!empty($modUser)) {
         # Create a code for password reset
         $resetpw_code = Str::random(25);

         # Update the DB
         $modUser->update(['resetpw_code' => $resetpw_code, 'rpwcode_datetime' => gmdate(config('consts.DB_DATETIME_FMT'))]);

         # Send reset password email (queue and return immediately)
         Mail::to($Validated['email'])->queue(new PasswordReset(
            strval($dbrow[0]->name),
            $Validated['email'],
            $resetpw_code
         ));

         laravel_queueworker(); # Process the queue (start the worker daemon and return immediately)
      }

      # Always sign-out the user (a related message was already shown to the user)
      Auth::logout();
      $request->session()->invalidate();
      # No need here to regenerate the CSRF token

      return response()->json([
         'retcode'   => config('consts.ERR_NOERROR'),
         'msgTitle'  => "Your request was submitted",
         'msgHtml'   => "<p>Check the inbox (of the email address you entered) for instructions on the next step to reset your password.</p>",
         'msgIcon'   => "success"
      ]);
   }
}
