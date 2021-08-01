<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Mail;

class CtrlRequests extends Controller
{
	# (This is brought from 'comingsoon' project)
	# Saves the supplied user email to our database
	#
	public function AddEmail(Request $request) {
		# Check parameters
		if ($request->missing('useremail')) return "Email address was not received!";

		$param_email = $request->input('useremail');
		if (strcmp(filter_var($param_email, FILTER_SANITIZE_EMAIL), $param_email) != 0) {
			return ['retcode' => 0, 'retdata' => "Invalid email address!"];
		}

		$dbrows = DB::select("SELECT * FROM `saved_emails` WHERE `email`=:eml;", ['eml' => $param_email]);
		if (!empty($dbrows)) return ['retcode' => -1, 'retdata' => "Your email is already saved!"];

		# Email is good, and new. Insert it
		$result = DB::insert("INSERT INTO `saved_emails`(`email`, `added_on`, `IP`) VALUES(:eml, :dtm, :ipa);",
			['eml' => $param_email, 'dtm' => gmdate('Y-m-d H:i:s'), 'ipa' => $request->ip()]);
		if (empty($result)) return ['retcode' => 0, 'retdata' => "Could not save the email!"];

		# Send a welcome email
		$result = Mail::to($param_email)->send(new Welcome());
		
		# Return a good message to the client
		return ['retcode' => 1, 'retdata' => "You have been subscribed to our newsletter."];
	}
}
