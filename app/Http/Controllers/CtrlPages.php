<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;

class CtrlPages extends Controller
{
	#
	# Main: Show the landing (home) page
	#
	public function Home() {
		return view('home');
	}
}
