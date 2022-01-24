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
use Illuminate\Support\Facades\Storage;         # Needed for reqTplStepFields() request
use Illuminate\Support\Facades\Validator;


class CtrlRequests extends Controller
{
   ################################################################################################
   public function reqRegister(Request $request) {
      # Create a manual validator to prevent returning 422 html error
      $Validator = Validator::make($request->all(), [
         'username'  => ['bail', 'required', 'between:' . USERNAME_MINLENGTH . ',' . USERNAME_MAXLENGTH],
         'email'     => ['bail', 'required', 'email', 'max:' . EMAIL_MAXLENGTH, 'unique:users,email'],
         'password'  => ['bail', 'required', 'min:' . PASSWORD_MINLENGTH, 'max:' . PASSWORD_MAXLENGTH],
         'terms'     => ['bail', 'accepted'],
         'gr_token'  => ['bail', 'required']
      ]);

      # Return error message gracefully
      if ($Validator->fails()) {
         $errors = $Validator->errors();

         if (!empty($errors->first('username'))) {
            return response()->json(['retcode' => ERR_WITHMSG_USERNAME, 'errmsg' => $errors->first('username')]);
         }
         if (!empty($errors->first('email'))) {
            return response()->json(['retcode' => ERR_WITHMSG_EMAIL, 'errmsg' => $errors->first('email')]);
         }
         if (!empty($errors->first('password'))) {
            return response()->json(['retcode' => ERR_WITHMSG_PASSWORD, 'errmsg' => $errors->first('password')]);
         }
         if (!empty($errors->first('terms'))) {
            return response()->json(['retcode' => ERR_WITHMSG_TERMS, 'errmsg' => $errors->first('terms')]);
         }
         if (!empty($errors->first('gr_token'))) {
            return response()->json(['retcode' => ERR_WITHMSG, 'errmsg' => $errors->first('gr_token')]);
         }
      }

      # Retrieve the validated input
      $Validated = $Validator->validated();

      # Check Google reCAPTCHA v3
      if (reCAPTCHAv3Check($Validated['gr_token'], GR_ACTION_ACCOUNTREGISTER, $request->ip()) != TRUE) {
         return response()->json(['retcode' => ERR_WITHMSG, 'errmsg' => MSG_RECAPTCHA_FAILED]);
      }

      #
      # On any change to the way of user authentication, change reqSocialRegisterOrSignIn too.
      #

      # Done verifying. Save the user record in the database
      $verification_code = Str::random(VERIFICATIONCODE_LENGTH);

      $modUser = User::create([
         'name'               => $Validated['username'],
         'email'              => $Validated['email'],
         'password'           => Hash::make($Validated['password']),
         'reg_datetime'       => gmdate(DB_DATETIME_FMT),
         'verification_code'  => $verification_code,
         'vercode_datetime'   => gmdate(DB_DATETIME_FMT),
         'ipaddrs_obj'        => add_userlogin_record("", $request->ip()),
         'picture'            => create_random_userpicurl()
      ]);
      if (empty($modUser)) return response()->json(['retcode' => ERR_UNEXPECTED]);

      # Send verification email (actually queue and return immediately)
      Mail::to($Validated['email'])->queue(new EmailVerify(
         $Validated['username'],
         true,
         $Validated['email'],
         $verification_code
      ));

      laravel_queueworker(); # Process the queue (start the worker daemon and return immediately)

      return response()->json([
         'retcode'   => ERR_NOERROR,
         'msgTitle'  => "Success",
         'msgHtml'   => "<p>Thank you for signing up!</p><p>Check you email inbox for verification instructions.</p>",
         'msgIcon'   => "success"
      ]);
   }


   ################################################################################################
   public function reqSignIn(Request $request) {
      # Create a manual validator to prevent returning 422 html error
      $Validator = Validator::make($request->all(), [
         'email'     => ['bail', 'required', 'email', 'max:' . EMAIL_MAXLENGTH],
         'password'  => ['bail', 'required', 'min:' . PASSWORD_MINLENGTH, 'max:' . PASSWORD_MAXLENGTH],
         'remember'  => ['nullable', 'boolean']
      ]);

      # Return error message gracefully
      if ($Validator->fails()) {
         $errors = $Validator->errors();

         if (!empty($errors->first('email'))) {
            return response()->json(['retcode' => ERR_WITHMSG_EMAIL, 'errmsg' => $errors->first('email')]);
         }
         if (!empty($errors->first('password'))) {
            return response()->json(['retcode' => ERR_WITHMSG_PASSWORD, 'errmsg' => $errors->first('password')]);
         }
         if (!empty($errors->first('remember'))) {
            return response()->json(['retcode' => ERR_WITHMSG, 'errmsg' => $errors->first('remember')]);
         }
      }

      # Retrieve the validated input
      $Validated = $Validator->validated();

      #
      # On any change to the way of user authentication, change reqSocialRegisterOrSignIn too.
      #

      if (Auth::attempt(['email' => $Validated['email'], 'password' => $Validated['password']], $Validated['remember'])) {
         # Authenticated
         $request->session()->regenerate();

         # Add login statistics in the DB
         # this will not conflict with the code in asset-header view, as long as we also set the cookie
         # (the code in asset-header view will not update the db.ip as long as the cookie is correct)
         $modUser = User::where('email', Auth::user()['email'])->first();
         if (!empty($modUser)) {
            $strJSON = add_userlogin_record($modUser->ipaddrs_obj, $request->ip());
            $modUser->update(['ipaddrs_obj' => $strJSON]);
         }
         # Updating db.ip here in login is important, it serves user authentication conflict.
         # See notes in CtrlExtLinks | EmailVerification()

         # Don't set an expiry time (0) -> cookie expire when browser is closed.
         setcookie(COOKIE_AUTOLOGIN, "1");

         # Done
         return response()->json(['retcode' => ERR_NOERROR]);
      } else {
         # Bad credentials
         return response()->json(['retcode' => ERR_WITHMSG, 'errmsg' => "Wrong email or password!"]);
      }
   }


   ################################################################################################
   public function reqSignOut(Request $request) {
      # This request has no data, not even a CSRF Token (it's disabled)

      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      
      # Remove any cookies that was set (which are related to the user)
      return response()->json(['retcode' => ERR_NOERROR])
                       ->withoutCookie(COOKIE_AUTOLOGIN);
   }


   ################################################################################################
   public function reqForgotPW(Request $request) {
      # Create a manual validator to prevent returning 422 html error
      $Validator = Validator::make($request->all(), [
         'email'     => ['bail', 'required', 'email', 'max:' . EMAIL_MAXLENGTH],
         'gr_token'  => ['bail', 'required']
      ]);

      # Return error message gracefully
      if ($Validator->fails()) {
         $errors = $Validator->errors();

         if (!empty($errors->first('email'))) {
            return response()->json(['retcode' => ERR_WITHMSG_EMAIL, 'errmsg' => $errors->first('email')]);
         }
         if (!empty($errors->first('gr_token'))) {
            return response()->json(['retcode' => ERR_WITHMSG, 'errmsg' => $errors->first('gr_token')]);
         }
      }

      # Retrieve the validated input
      $Validated = $Validator->validated();

      # Check Google reCAPTCHA v3
      if (reCAPTCHAv3Check($Validated['gr_token'], GR_ACTION_RESETPASSWORD, $request->ip()) != TRUE) {
         return response()->json(['retcode' => ERR_WITHMSG, 'errmsg' => MSG_RECAPTCHA_FAILED]);
      }

      # Check that the given email address exists in our DB
      $modUser = User::where('email', $Validated['email'])->first();
      if (!empty($modUser)) {
         # Create a code for password reset
         $resetpw_code = Str::random(VERIFICATIONCODE_LENGTH);

         # Update the DB
         $modUser->update(['resetpw_code' => $resetpw_code, 'rpwcode_datetime' => gmdate(DB_DATETIME_FMT)]);

         # Send reset password email (queue and return immediately)
         Mail::to($Validated['email'])->queue(new PasswordReset(
            strval($modUser->name),
            $Validated['email'],
            $resetpw_code
         ));

         laravel_queueworker(); # Process the queue (start the worker daemon and return immediately)
      }

      # Always sign-out the user (a related message was already shown to the user)
      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();

      return response()->json([
         'retcode'   => ERR_NOERROR,
         'msgTitle'  => "Your request was submitted",
         'msgHtml'   => "<p>Check the inbox (of the email address you entered) for instructions on the next step to reset your password.</p>",
         'msgIcon'   => "success"
      ])->withoutCookie(COOKIE_AUTOLOGIN); # Remove cookies (see reqSignOut)
   }


   ################################################################################################
   public function reqNewPW(Request $request) {
      # Create a manual validator to prevent returning 422 html error
      $Validator = Validator::make($request->all(), [
         'email'     => ['bail', 'required', 'email', 'max:' . EMAIL_MAXLENGTH],
         'code'      => ['bail', 'required', 'size:' . VERIFICATIONCODE_LENGTH],
         'password'  => ['bail', 'required', 'min:' . PASSWORD_MINLENGTH, 'max:' . PASSWORD_MAXLENGTH]
      ]);

      # Return error message gracefully
      if ($Validator->fails()) {
         $errors = $Validator->errors();

         # We don't have UI elements for 'email' or 'code'. Error message will be shown as a popup messages.
         if (!empty($errors->first('email')) || !empty($errors->first('code'))) {
            return response()->json(['retcode' => ERR_WITHMSG, 'errmsg' => "Invalid data received!"]);
         }
         if (!empty($errors->first('password'))) {
            return response()->json(['retcode' => ERR_WITHMSG_PASSWORD, 'errmsg' => $errors->first('password')]);
         }
      }

      # Retrieve the validated input
      $Validated = $Validator->validated();

      # Last check that the field are actually in the DB
      $modUser = User::where('email', $Validated['email'])->where('resetpw_code', $Validated['code'])->first();
		if (empty($modUser)) {
         return response()->json(['retcode' => ERR_WITHMSG, 'errmsg' => "Invalid data received!"]);
      }

      # Done verifying. Update the user's password in the database, and
      # REMOVE THE RESETPW_CODE from the user's model (to invalidate further password change using the same link in the email!)
      $modUser->update(['password' => Hash::make($Validated['password']), 'resetpw_code' => null]);
      # Leave the 'rpwcode_datetime' field with the date to indicate that the password was changed and its request's LAST datetime.

      # Always sign-out the user (password was changed)
      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();

      # Done
      return response()->json([
         'retcode'   => ERR_NOERROR,
         'msgTitle'  => "Success",
         'msgHtml'   => "<p>Your password was updated!</p><p>Now you can use the new password to login.</p>",
         'msgIcon'   => "success"
      ])->withoutCookie(COOKIE_AUTOLOGIN); # Remove cookies (see reqSignOut)
   }


   ################################################################################################
   public function reqSocialRegisterOrSignIn(Request $request) {
      # Expected parameters by the Ajax request:
      # socialType           (string):["google", ]
      # socialResponse       (special data, depends on socialType)

      # This procedure uses the same way of user authentication as reqRegister and reqLogin do.
      # Always refer to them on any change!

      do {
         if ($request->input('socialType') == "google") {
            # socialResponse: (JWK- or PEM- encoded object) {clientId, credential, select_by}

            # Specify the CLIENT_ID of the app that accesses the backend
            $ggl_client = new \Google_Client(['client_id' => env('SOCIALLOGIN_GOOGLE_CLIENT_ID')]);
            if (empty($ggl_client)) break; # To return an error message

            $ggl_payload = $ggl_client->verifyIdToken($request->input('socialResponse.credential'));
            if (empty($ggl_payload)) break; # To return an error message

            # Client info has been verified (aud, iss, exp), and the data in $ggl_payload is valid
            // fields that matters:
            // email: "homam1984@gmail.com"
            // email_verified: true
            // name: "Humam Babi"
            // picture: "https://lh3.googleusercontent.com/a-/AOh14GjYZK68lc63xgBj_8Kxfnwehh-WDYF-b1XitDE=s96-c"
            // sub: "108786054780036589311" ($userid = $payload['sub'];)

            $existingUser = User::where('email', $ggl_payload['email'])->first();
            if (empty($existingUser)) {
               # Add this user (register), AND login after that
               $newUser = new User;
               $newUser->name = $ggl_payload['name'];
               $newUser->email = $ggl_payload['email'];
               $newUser->password = ''; # Empty password, pay attention!
               $newUser->reg_datetime = gmdate(DB_DATETIME_FMT);
               $newUser->google_id = $ggl_payload['sub'];
               $newUser->verification_code = ''; # No verification code, attention!
               $newUser->vercode_datetime = gmdate(DB_DATETIME_FMT); # Not needed, but it must be in a valid format
               $newUser->is_emailverified = $ggl_payload['email_verified'] ? true : false; # Not sure if this is important or its impact!
               $newUser->ipaddrs_obj = add_userlogin_record("", $request->ip());
               $newUser->picture = $ggl_payload['picture']; # A Google-provided URL
               $newUser->save();

               # Sign-in (always remember the user)
               Auth::loginUsingId($newUser->id, $remember = true);
               $request->session()->regenerate();

               # Add login statistics in the DB
               # this will not conflict with the code in asset-header view, as long as we also set the cookie
               # (the code in asset-header view will not update the db.ip as long as the cookie is correct)
               $strJSON = add_userlogin_record($newUser->ipaddrs_obj, $request->ip());
               $newUser->update(['ipaddrs_obj' => $strJSON]);
               
               # Updating db.ip here in login is important, it serves user authentication conflict.
               # See notes in CtrlExtLinks | EmailVerification()

               # Don't set an expiry time (0) -> cookie expire when browser is closed.
               setcookie(COOKIE_AUTOLOGIN, "1");

               # Done
               return response()->json(['retcode' => ERR_NOERROR]);
            } else {
               # User exists. Just login
               Auth::loginUsingId($existingUser->id, $remember = true);
               $request->session()->regenerate();

               # Add login statistics in the DB
               # this will not conflict with the code in asset-header view, as long as we also set the cookie
               # (the code in asset-header view will not update the db.ip as long as the cookie is correct)
               $strJSON = add_userlogin_record($existingUser->ipaddrs_obj, $request->ip());
               $existingUser->update(['ipaddrs_obj' => $strJSON]);
               
               # Updating db.ip here in login is important, it serves user authentication conflict.
               # See notes in CtrlExtLinks | EmailVerification()

               # Don't set an expiry time (0) -> cookie expire when browser is closed.
               setcookie(COOKIE_AUTOLOGIN, "1");

               # Done
               return response()->json(['retcode' => ERR_NOERROR]);
            }
         } # 'socialType' == "google"
      } while (FALSE);

      # Not a valid social type has been passed, or any other error happened
      return response()->json(['retcode' => ERR_WITHMSG, 'errmsg' => "Invalid data received!"]);
   }


   ################################################################################################
   public function reqTplStepFields(Request $request) {
      # Create a manual validator to prevent returning 422 html error
      $Validator = Validator::make($request->all(), [
         'tpl_id'  => ['bail', 'required', 'max:50'],
         'stp_name'  => ['bail', 'required', 'max:50']
      ]);
      
      # Return error message gracefully
      if ($Validator->fails()) {
         $errors = $Validator->errors();

         if (!empty($errors->first('tpl_id'))) {
            return response()->json(['retcode' => ERR_UNEXPECTED, 'errmsg' => $errors->first('tpl_id')]);
         }
         if (!empty($errors->first('stp_name'))) {
            return response()->json(['retcode' => ERR_UNEXPECTED, 'errmsg' => $errors->first('stp_name')]);
         }
      }

      # Check and load the template properties script
      # (Should be here to handle bad parameter passed to the Ajax request)
      $Validated = $Validator->validated();
      $tplDir = TEMPLATE_STORAGE_DIRNAME . "/" . $Validated["tpl_id"] . "/";
      if (Storage::disk('local')->missing($tplDir . TEMPLATE_PROPS_FILENAME)) {
         return response()->json(['retcode' => ERR_UNEXPECTED, 'errmsg' => $errors->first('tpl_id')]);
      }
      $tpl_props = json_decode(Storage::disk('local')->get($tplDir . TEMPLATE_PROPS_FILENAME), true);
      $stepFields = get_template_step_fields($tpl_props[TEMPLATEPROPS_FIELDS], $Validated["stp_name"]);
      if (count($stepFields) < 1) { # Error: Step name is invalid!
         return response()->json(['retcode' => ERR_UNEXPECTED, 'errmsg' => $errors->first('stp_name')]);
      }

      $html = create_templatestep_html($stepFields);
      $actFields = [
         ["id" => "patient_name",   "type" => "TEXTBOX", "tplField" => "CONST_PATIENTNAME"],
         ["id" => "gender_male",    "type" => "OPTION",  "tplField" => "CONST_PATIENTGENDER"],
         ["id" => "gender_female",  "type" => "OPTION",  "tplField" => "CONST_PATIENTGENDER"]
      ];
      return response()->json(['retcode' => ERR_NOERROR, 'stepHtml' => $html, 'actFields' => $actFields]);
   }


   ################################################################################################
   public function reqTplGetPreview(Request $request) {
      # Create a manual validator to prevent returning 422 html error
      $Validator = Validator::make($request->all(), [
         'userData'  => ['nullable']
      ]);

      # Return error message gracefully
      if ($Validator->fails()) {
         $errors = $Validator->errors();

         if (!empty($errors->first('userData'))) {
            return response()->json(['retcode' => ERR_UNEXPECTED, 'errmsg' => $errors->first('userData')]);
         }
      }

      $userData = $Validator->validated()['userData'];

      # Another kind of validation: Check JSON members
      if (empty($userData[TEMPLATE_USERDATA_TPLID])) {
         return response()->json(['retcode' => ERR_UNEXPECTED, 'errmsg' => "Bad data received!"]);
      }

      $imgId = $request->session()->getId();
      template_create_preview($userData, $imgId); # This call should create a new report preview pdf & jpg, and clean up the folder

      // Adding a 'ts' parameter after the image 'src' attribute prevents the browser from loading the same
      // image from its cache (given that the new src is the same as the old one!)
      return response()->json([
         'retcode' => ERR_NOERROR,
         'pvwImg' => '<img alt="Report Preview" src="/resReportPreview/' . $imgId . '?ts=' . time() . '" />'
      ]);
   }
}
