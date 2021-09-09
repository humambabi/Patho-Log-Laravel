<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class CtrlExtLinks extends Controller
{
   # Email verification ###########################################################################
   public function EmailVerification($email, $code) {
      // also if already logged in
      /*
      $data['head_title'] = "Register - Patho•Log";
      $data['head_description'] = "Patho•Log - Register";
      $data['page_name'] = "register";

      echo view('portal.asset-header', $data);
      echo view('portal.page-extraportal-register');
      echo view('portal.asset-footer', $data);
      */



      echo "Email: $email" . PHP_EOL;
      echo "Code: $code";
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