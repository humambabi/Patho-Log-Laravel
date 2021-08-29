<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;

class CtrlPortal extends Controller
{
   /*
   Extra-portal pages
   */
   public function LogIn() {
      // if user is already logged in:
      //    if there is a (old url) defined, goto it, else goto dashboard
      // endif
      $data['head_title'] = "Login - Patho•Log";
      $data['head_description'] = "Patho•Log - Login";
      $data['page_name'] = "login";

      echo view('portal.asset-header', $data);
      echo view('portal.page-extraportal-login');
      echo view('portal.asset-footer', $data);
   }


   public function Register() {
      $data['head_title'] = "Register - Patho•Log";
      $data['head_description'] = "Patho•Log - Register";
      $data['page_name'] = "register";

      echo view('portal.asset-header', $data);
      echo view('portal.page-extraportal-register');
      echo view('portal.asset-footer', $data);
   }


   /*
   Actual portal pages
   */
   public function Dashboard() {
      # Make sure user is logged-in
      if (session('bLoggedIn', false) != true) {
         return redirect('/login');
      }

      # Define page properties
      $data['head_title'] = "Dashboard - Patho•Log";
      $data['head_description'] = "Patho•Log - Main dashboard";
      $data['page_name'] = "dashboard";

      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      echo view('portal.page-dashboard');
      echo view('portal.asset-footer', $data);
   }


   public function NewReport() {
      $data['head_title'] = "New Report - Patho•Log";
      $data['head_description'] = "Patho•Log - Create a new report";
      $data['page_name'] = "newreport";

      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      echo view('portal.page-newreport');
      echo view('portal.asset-footer', $data);
   }
}