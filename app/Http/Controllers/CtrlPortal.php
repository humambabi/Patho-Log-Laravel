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
      
      $data['add_css'] = [
         return_css("/css/portal/extraportal-custom.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/jquery-validation-1.19.3/dist/jquery.validate.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>',
         '<script src="https://www.google.com/recaptcha/api.js?render=' . env('GOOGLERECAPTCHA3_SITEKEY') . '"></script>',
         '<script src="https://accounts.google.com/gsi/client" async defer></script>',
         return_jscript("/js/portal/social-login.js"),
         return_jscript("/js/portal/extraportal-scripts.js")
      ];

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

      $data['add_css'] = [
         return_css("/css/portal/extraportal-custom.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/jquery-validation-1.19.3/dist/jquery.validate.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>',
         '<script src="https://accounts.google.com/gsi/client" async defer></script>',
         return_jscript("/js/portal/social-login.js"),
         return_jscript("/js/portal/extraportal-scripts.js")
      ];

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
      $data['add_css'] = [
         return_css("/css/portal/extraportal-custom.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/jquery-validation-1.19.3/dist/jquery.validate.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>',
         '<script src="https://www.google.com/recaptcha/api.js?render=' . env('GOOGLERECAPTCHA3_SITEKEY') . '"></script>',
         return_jscript("/js/portal/extraportal-scripts.js")
      ];

      echo view('portal.asset-header', $data);
      echo view('portal.page-extraportal-forgotpw');
      echo view('portal.asset-footer', $data);
   }


   /*
   Actual portal pages
   */

   # Default (according to user auth) #############################################################
   public function Default() {
      # Decide on showing 'dashboard' or 'new report', according to whether the user is logged-in or they are a guest user
      if (empty(Auth::check())) {
         # Guest
         return redirect()->route('newreport');
      } else {
         # Logged-in user
         return redirect()->route('dashboard');
      }
   }

      
   # Dashboard ####################################################################################
   public function Dashboard() {
      # Make sure user is *AUTHENTICATED*, otherwise, redirect to the newreport page
      # (if user got here while they are not authenticated, they must have typed the url manually!)
      if (!Auth::check()) return redirect()->route('newreport');

      # Can be loaded even if the user is not logged-in
      $data['head_title'] = "Dashboard - " . config('app.name');
      $data['head_description'] = config('app.name') . " - Main dashboard";
      $data['page_name'] = "dashboard";
      $data['page_type'] = "portal";
      $data['add_css'] = [
         return_css("/vendor/OverlayScrollbars-1.13.1/css/OverlayScrollbars.min.css"),
         return_css("/css/portal/custom.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>'
      ];
      if (!Auth::check()) {
         array_push($data['add_js'], '<script src="https://accounts.google.com/gsi/client" async defer></script>');
         array_push($data['add_js'], return_jscript("/js/portal/social-login.js"));
      }
      array_push($data['add_js'], return_jscript("/js/portal/portal-main.js"));

      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      echo view('portal.page-dashboard');
      echo view('portal.asset-footer', $data);
   }


   # New Report ###################################################################################
   public function NewReport() {
      # *CAN* be loaded even if the user is not logged-in
      $data['head_title'] = "New Report - " . config('app.name');
      $data['head_description'] = config('app.name') . " - Create a new report";
      $data['page_name'] = "newreport";
      $data['page_type'] = "portal";

      $data['add_css'] = [
         return_css("/vendor/OverlayScrollbars-1.13.1/css/OverlayScrollbars.min.css"),
         return_css("/css/portal/custom.css"),
         return_css("/css/portal/newreport.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>'
      ];
      if (!Auth::check()) {
         array_push($data['add_js'], '<script src="https://accounts.google.com/gsi/client" async defer></script>');
         array_push($data['add_js'], return_jscript("/js/portal/social-login.js"));
      }
      array_push($data['add_js'], return_jscript("/js/portal/portal-main.js"));
      array_push($data['add_js'], return_jscript("/js/portal/newreport.js"));

      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      echo view('portal.page-newreport');
      echo view('portal.asset-footer', $data);
   }
}
