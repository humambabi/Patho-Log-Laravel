<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CtrlRequests extends Controller
{
   # (This is brought from 'comingsoon' project)
   # Saves the supplied user email to our database
   #
   public function reqSignIn(Request $request) {
      $validated = $request->validate([
         'email'     => ['bail', 'required', 'email', 'max:' . config('constants.EMAIL_MAXLENGTH')],
         'password'  => ['bail', 'required', 'between:' . config('constants.PASSWORD_MINLENGTH') . ',' . config('constants.PASSWORD_MAXLENGTH')],
         'remember'  => ['bail', 'required']
      ]);

      return $validated;

      /*
            $dbrows = DB::select("SELECT * FROM `saved_emails` WHERE `email`=:eml;", ['eml' => $param_email]);
            if (!empty($dbrows)) return ['retcode' => -1, 'retdata' => "Your email is already saved!"];
      
            # Email is good, and new. Insert it
            $result = DB::insert("INSERT INTO `saved_emails`(`email`, `added_on`, `IP`) VALUES(:eml, :dtm, :ipa);",
               ['eml' => $param_email, 'dtm' => gmdate('Y-m-d H:i:s'), 'ipa' => $request->ip()]);
            if (empty($result)) return ['retcode' => 0, 'retdata' => "Could not save the email!"];
      
            # Send a welcome email
            $result = Mail::to($param_email)->send(new Welcome());
      */


      #
      return ['retcode' => 1, 'retdata' => "You have been subscribed to our newsletter."];
   }
}
