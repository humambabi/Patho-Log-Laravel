<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class CtrlPortal extends Controller
{
   /*
   Extra-portal pages
   */

   # (Extra-portal) Registration ##################################################################
   public function Register() {
      # Make sure user is *NOT* authenticated, otherwise, redirect to the dashboard
      # (if user got here while they are authenticated, they must have typed the url manually!)
      if (Auth::check()) return redirect()->route('dashboard');

      # Only if user is not authenticated
      $data['head_title'] = "Register - Patho•Log";
      $data['head_description'] = "Patho•Log - Register";
      $data['page_name'] = "register";
      $data['page_type'] = "extraportal";

      echo view('portal.asset-header', $data);
      echo view('portal.page-extraportal-register');
      echo view('portal.asset-footer', $data);
   }


   # (Extra-portal) Log-in ########################################################################
   public function LogIn() {
      # Make sure user is *NOT* authenticated, otherwise, redirect to the dashboard
      # (if user got here while they are authenticated, they must have typed the url manually!)
      if (Auth::check()) return redirect()->route('dashboard');

      # Only if user is not authenticated
      $data['head_title'] = "Login - Patho•Log";
      $data['head_description'] = "Patho•Log - Login";
      $data['page_name'] = "login";
      $data['page_type'] = "extraportal";

      echo view('portal.asset-header', $data);
      echo view('portal.page-extraportal-login');
      echo view('portal.asset-footer', $data);
   }


   # (Extra-portal) Forgot password ###############################################################
   public function ForgotPW() {
      $data['head_title'] = "Password Reset - Patho•Log";
      $data['head_description'] = "Patho•Log - Password Reset";
      $data['page_name'] = "forgotpw";
      $data['page_type'] = "extraportal";

      echo view('portal.asset-header', $data);
      echo view('portal.page-extraportal-forgotpw');
      echo view('portal.asset-footer', $data);
   }


   /*
   Actual portal pages
   */

   # Dashboard ####################################################################################
   public function Dashboard() {
      # Make sure user is authenticated (Should not be needed as the 'dashboard' route is auth-protected)
      if (empty(Auth::check())) return redirect()->route('login');

      # Only if user is authenticated
      $data['head_title'] = "Dashboard - Patho•Log";
      $data['head_description'] = "Patho•Log - Main dashboard";
      $data['page_name'] = "dashboard";
      $data['page_type'] = "portal";

      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      echo view('portal.page-dashboard');
      echo view('portal.asset-footer', $data);
   }


   # New Report ###################################################################################
   public function NewReport() {
      # Make sure user is authenticated (Should not be needed as the 'dashboard' route is auth-protected)
      if (empty(Auth::check())) return redirect()->route('login');

      # Only if user is authenticated
      $data['head_title'] = "New Report - Patho•Log";
      $data['head_description'] = "Patho•Log - Create a new report";
      $data['page_name'] = "newreport";
      $data['page_type'] = "portal";

      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      echo view('portal.page-newreport');
      echo view('portal.asset-footer', $data);
   }
}
