<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;


class CtrlExtLinks extends Controller
{
   # Email verification ###########################################################################
   public function EmailVerification($email, $code) {
      # We have 4 cases, we need to sort them out (in order):
      # - Wrong or missing parameters
      # - Already verified
      # - Expired
      # - New verificaiton ok

      $data['case'] = "error";
      $data['autoredirect'] = false;

      do {
         # (1a) Missing parameters "wrong"
         if (empty($email) || empty($code)) {
            # Most likely will not be encountered due to our routes (parameters are not optional)
            # But it's a good thing to catch this, just in case.
            $data['case'] = "wrong";
            break;
         }

         # Check parameters against saved data in the DB
         $modUser = User::where('email', $email)->where('verification_code', $code)->first();

         # (1b) Wrong parameters "wrong"
         if (empty($modUser)) {
            $data['case'] = "wrong";
            break;
         }

         # (2) Already verified email "already"
         if (!empty($modUser->is_emailverified)) {
            $data['case'] = "already";
            $data['autoredirect'] = true;
            break;
         }

         # Check for activation code expiry
         $expired = TRUE;
         $deadline = strtotime(strval($modUser->vercode_datetime) . " +0000 + " .
            strval(config('consts.EMAILVERIFICATIONCODE_VALIDITY_MINUTES')) . " minutes");
         $remaining = $deadline - time(); # time() is timezone independent (=UTC) (in seconds)
         if ($remaining >= 0) $expired = FALSE; # Not expired yet (when there are positive number of seconds remaining)
         if ($remaining > (config('consts.EMAILVERIFICATIONCODE_VALIDITY_MINUTES') * 60)) { # (convert minutes to seconds)
            # Remaining MUST not exceed the valid period itself - that would be a programming error!
            $data['case'] = "error";
            break;
         }

         # (3) Expired "expired"
         if ($expired) {
            $data['case'] = "expired";
            break;
         }

         # Parameters are valid, email not yet verified, code not expired yet. Set the email as verified in the DB
         $modUser->update(['is_emailverified' => true]);

         # One more check
         $modUser = User::where('email', $email)->where('verification_code', $code)->first();
         if (empty($modUser) || empty($modUser->is_emailverified)) {
            $data['case'] = "wrong";
            break;
         } else {
            # (4) OK, verified "verified"
            $data['case'] = "verified";
            $data['autoredirect'] = true;
         }
      } while (false);

      # (Should not happen unless there is a bug in code)
      if ($data['case'] == "error") Log::warning("CtrlExtLinks | EmailVerification() | \$data['case'] == \"error\"");

      # If user A finished working without signing out (still authenticated, maybe with 'remember me' too), and user B comes
      # and verifies their email. After successful verifying, the page will redirect the user to the dashboard, where user A
      # is still logged in!
      # And always logging-out users is just annoying.
      # So, we are checking the currently verifiying email against the logged-in email, and logging out if necessary.
      $data['signedout'] = false;
      if ($data['case'] == "already" || $data['case'] == "expired" || $data['case'] == "verified") {
         if (Auth::check() && Auth::user()['email'] != $email) { # (Both variables should have come from the db)
            # Sign the current user out
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            Cookie::expire(config('consts.COOKIE_AUTOLOGIN')); # Needs test!
            # Even if removing cookie doesn't work here, we are signing the user out, and when they sign in again
            # the db.ip will be updated and a new cookie will be set.

            $data['signedout'] = true;
         }
      }

      # View the page
      $data['head_title'] = "Email Verification - Patho•Log";
      $data['head_description'] = "Patho•Log - Email Verification";
      $data['page_name'] = "emailverificaiton";
      $data['page_type'] = "extraportal";
      
      echo view('portal.asset-header', $data);
      echo view('portal.page-extraportal-emailverify', $data);
      echo view('portal.asset-footer', $data);
   }


   # Create Password ##############################################################################
   public function CreatePassword($email, $code) {
      # We have 3 cases, we need to sort them out (in order):
      # - Wrong or missing parameters
      # - Expired
      # - Parameters ok (show 'create a new password' form)

      $data['case'] = "error";
      # No 'autoredirect' here!

      do {
         # (1a) Missing parameters "wrong"
         if (empty($email) || empty($code)) {
            # Most likely will not be encountered due to our routes (parameters are not optional)
            # But it's a good thing to catch this, just in case.
            $data['case'] = "wrong";
            break;
         }

         # Check parameters against saved data in the DB
         $modUser = User::where('email', $email)->where('resetpw_code', $code)->first();

         # (1b) Wrong parameters "wrong"
         if (empty($modUser)) {
            $data['case'] = "wrong";
            break;
         }

         # Check for activation code expiry
         $expired = TRUE;
         $deadline = strtotime(strval($modUser->rpwcode_datetime) . " +0000 + " .
            strval(config('consts.PASSWORDRESETCODE_VALIDITY_MINUTES')) . " minutes");
         $remaining = $deadline - time(); # time() is timezone independent (=UTC) (in seconds)
         if ($remaining >= 0) $expired = FALSE; # Not expired yet (when there are positive number of seconds remaining)
         if ($remaining > (config('consts.PASSWORDRESETCODE_VALIDITY_MINUTES') * 60)) { # (convert minutes to seconds)
            # Remaining MUST not exceed the valid period itself - that would be a programming error!
            $data['case'] = "error";
            break;
         }

         # (2) Expired "expired"
         if ($expired) {
            $data['case'] = "expired";
            break;
         }

         # Parameters are valid, code not expired yet. Show the form to create a new password
         $data['case'] = "createnew";
      } while (false);

      # (Should not happen unless there is a bug in code)
      if ($data['case'] == "error") Log::warning("CtrlExtLinks | CreatePassword() | \$data['case'] == \"error\"");

      # View the page
      $data['head_title'] = "Reset Password - Patho•Log"; # This title should be suitable for "wrong" cases too.
      $data['head_description'] = "Patho•Log - Reset Password";
      $data['page_name'] = "createpw";
      $data['page_type'] = "extraportal";

      echo view('portal.asset-header', $data);
      echo view('portal.page-extraportal-createpw', $data);
      echo view('portal.asset-footer', $data);
   }
}
