<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; # Needed for NewReport() to get available templates


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
         /* SweetAlert is needed for sign-in errors */
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>',
         '<script src="https://www.google.com/recaptcha/api.js?render=' . config('app.GreCAPTCHAv3_SiteKey') . '"></script>',
         '<script src="https://accounts.google.com/gsi/client" async defer></script>',
         return_jscript("/js/portal/social-login.js"),
         return_jscript("/js/portal/extraportal-scripts.js")
      ];

      echo view('portal.asset-header', $data);
      echo view('portal.extraportal-register');
      echo view('portal.asset-footer', $data);
   }


   # (Extra-portal) Log-in ########################################################################
   public function LogIn() {
      # Make sure user is *NOT* authenticated, otherwise, redirect to the dashboard
      # (if user got here while they are authenticated, they must have typed the url manually!)
      if (Auth::check()) return redirect()->route('dashboard');

      # Only if user is not authenticated
      $data['head_title'] = "Login | Patho•Log";
      $data['head_description'] = "Patho•Log - Login to the system";
      $data['page_name'] = "login";
      $data['page_type'] = "extraportal";

      $data['add_css'] = [
         return_css("/css/portal/extraportal-custom.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/jquery-validation-1.19.3/dist/jquery.validate.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         /* SweetAlert is needed for sign-in errors */
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>',
         '<script src="https://accounts.google.com/gsi/client" async defer></script>',
         return_jscript("/js/portal/social-login.js"),
         return_jscript("/js/portal/extraportal-scripts.js")
      ];

      echo view('portal.asset-header', $data);
      echo view('portal.extraportal-login');
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
         /* SweetAlert is needed for sign-in errors */
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>',
         '<script src="https://www.google.com/recaptcha/api.js?render=' . config('app.GreCAPTCHAv3_SiteKey') . '"></script>',
         return_jscript("/js/portal/extraportal-scripts.js")
      ];

      echo view('portal.asset-header', $data);
      echo view('portal.extraportal-forgotpw');
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
      # If the user is logged-in (authenticated), show the actual page contents,
      # otherwise, show "You need to log-in" interface.

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
         /* SweetAlert is needed for sign-in errors */
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>'
      ];
      if (!Auth::check()) {
         array_push($data['add_js'], '<script src="https://accounts.google.com/gsi/client" async defer></script>');
         array_push($data['add_js'], return_jscript("/js/portal/social-login.js"));
      }
      array_push($data['add_js'], return_jscript("/js/portal/portal-main.js"));

   
      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      if (empty(Auth::check())) {
         $data['page_title'] = "Dashboard";
         echo view('portal.page-need2login', $data);
      } else {
         echo view('portal.page-dashboard');
      }
      echo view('portal.asset-footer', $data);
   }


   # New Report ###################################################################################
   public function NewReport() {
      # *CAN* be loaded even if the user is not logged-in
      $data['head_title'] = "New Report - " . config('app.name');
      $data['head_description'] = config('app.name') . " - Create a new report";
      $data['page_name'] = "newreport";
      $data['page_type'] = "portal";

      # Decide which css & js to load
      $data['add_css'] = [
         return_css("/vendor/OverlayScrollbars-1.13.1/css/OverlayScrollbars.min.css"),
         return_css("/css/portal/custom.css"),
         return_css("/css/portal/newreport.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         /* SweetAlert is needed for sign-in errors */
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>',
         '<script src="/vendor/lazysizes/lazysizes.min.js" async=""></script>'
      ];
      if (!Auth::check()) {
         array_push($data['add_js'], '<script src="https://accounts.google.com/gsi/client" async defer></script>');
         array_push($data['add_js'], return_jscript("/js/portal/social-login.js"));
      }
      array_push($data['add_js'], return_jscript("/js/portal/portal-main.js"));
      array_push($data['add_js'], return_jscript("/js/portal/newreport.js"));

      # Create an html list of available templates
      $tplFolders = Storage::disk('local')->directories(TEMPLATE_STORAGE_DIRNAME);
      if (count($tplFolders) < 1) {
         # No templates was found (error)
         $data['templates_html'] = '<p><strong>No Templates Found!</strong></p>';
      } else {
         $data['templates_html'] = '';
         foreach ($tplFolders as $tplFolder) {
            $tpl_props = json_decode(Storage::disk('local')->get($tplFolder . '/' . TEMPLATE_PROPS_FILENAME), true);
            $tpl_title = $tpl_props[TEMPLATEPROPS_TEMPLATE_NAME];
            $tpl_desc = $tpl_props[TEMPLATEPROPS_TEMPLATE_DESC];
            $tpl_id = substr($tplFolder, -3); # IMPORTANT: Assuming folders' name length is 3!
            $tpl_imgpath = "/resTemplateThumbnail" . "/" . $tpl_id;

            # Note: <img> (loader.gif)'s width has been set to "90" instead of "auto" to workaround Firefox browser bug!
            $html =  '<div class="tplitem-container" id="' . $tpl_id . '">' .
                        '<div class="tplitem-backribbon"></div>' .
                           '<div class="tplitem-previmg">' .
                              '<img alt="' . $tpl_title . '" src="/img/portal/templates/tpl_loader.gif" width="90" height="100%" class="lazyload" data-src="' . $tpl_imgpath . '"/>' .
                           '</div>' .
                           '<div class="tplitem-ctl">' .
                              '<div class="tplitem-ctl-desc">' .
                                 '<div class="tplitem-ctl-desc-title">' . $tpl_title . '</div>' .
                              '<div class="tplitem-ctl-desc-text">' . $tpl_desc . '</div>' .
                           '</div>' .
                           '<div class="tplitem-ctl-btn">' .
                              '<button type="button" class="btn btn-turquoise btn-block">Select</button>' .
                           '</div>' .
                        '</div>' .
                     '</div>';

            $data['templates_html'] .= $html;
         }
      }

      # View the needed step
      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      echo view('portal.page-newreport', $data);
      echo view('portal.asset-footer', $data);
   }


   # Saved Reports ################################################################################
   public function SavedReports() {
      # If the user is logged-in (authenticated), show the actual page contents,
      # otherwise, show "You need to log-in" interface.

      $data['head_title'] = "Saved reports - " . config('app.name');
      $data['head_description'] = config('app.name') . " - Saved Reports";
      $data['page_name'] = "savedreports";
      $data['page_type'] = "portal";
      $data['add_css'] = [
         return_css("/vendor/OverlayScrollbars-1.13.1/css/OverlayScrollbars.min.css"),
         return_css("/css/portal/custom.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         /* SweetAlert is needed for sign-in errors */
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>'
      ];
      if (!Auth::check()) {
         array_push($data['add_js'], '<script src="https://accounts.google.com/gsi/client" async defer></script>');
         array_push($data['add_js'], return_jscript("/js/portal/social-login.js"));
      }
      array_push($data['add_js'], return_jscript("/js/portal/portal-main.js"));

   
      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      if (empty(Auth::check())) {
         $data['page_title'] = "Saved Reports";
         echo view('portal.page-need2login', $data);
      } else {
         echo view('portal.page-savedreports');
      }
      echo view('portal.asset-footer', $data);
   }


   # Maintainance - Backup ########################################################################
   public function Backup() {
      # If the user is logged-in (authenticated), show the actual page contents,
      # otherwise, show "You need to log-in" interface.

      $data['head_title'] = "Backup reports - " . config('app.name');
      $data['head_description'] = config('app.name') . " - Backup Reports";
      $data['page_name'] = "backup";
      $data['page_type'] = "portal";
      $data['add_css'] = [
         return_css("/vendor/OverlayScrollbars-1.13.1/css/OverlayScrollbars.min.css"),
         return_css("/css/portal/custom.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         /* SweetAlert is needed for sign-in errors */
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>'
      ];
      if (!Auth::check()) {
         array_push($data['add_js'], '<script src="https://accounts.google.com/gsi/client" async defer></script>');
         array_push($data['add_js'], return_jscript("/js/portal/social-login.js"));
      }
      array_push($data['add_js'], return_jscript("/js/portal/portal-main.js"));

   
      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      if (empty(Auth::check())) {
         $data['page_title'] = "Backup Reports";
         echo view('portal.page-need2login', $data);
      } else {
         echo view('portal.page-backup');
      }
      echo view('portal.asset-footer', $data);
   }


   # Maintainance - Restore #######################################################################
   public function Restore() {
      # If the user is logged-in (authenticated), show the actual page contents,
      # otherwise, show "You need to log-in" interface.

      $data['head_title'] = "Restore reports - " . config('app.name');
      $data['head_description'] = config('app.name') . " - Restore Reports";
      $data['page_name'] = "restore";
      $data['page_type'] = "portal";
      $data['add_css'] = [
         return_css("/vendor/OverlayScrollbars-1.13.1/css/OverlayScrollbars.min.css"),
         return_css("/css/portal/custom.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         /* SweetAlert is needed for sign-in errors */
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>'
      ];
      if (!Auth::check()) {
         array_push($data['add_js'], '<script src="https://accounts.google.com/gsi/client" async defer></script>');
         array_push($data['add_js'], return_jscript("/js/portal/social-login.js"));
      }
      array_push($data['add_js'], return_jscript("/js/portal/portal-main.js"));

   
      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      if (empty(Auth::check())) {
         $data['page_title'] = "Restore Reports";
         echo view('portal.page-need2login', $data);
      } else {
         echo view('portal.page-restore');
      }
      echo view('portal.asset-footer', $data);
   }


   # Templates ####################################################################################
   public function Templates() {
      # If the user is logged-in (authenticated), show the actual page contents,
      # otherwise, show "You need to log-in" interface.

      $data['head_title'] = "Templates - " . config('app.name');
      $data['head_description'] = config('app.name') . " - Templates";
      $data['page_name'] = "templates";
      $data['page_type'] = "portal";
      $data['add_css'] = [
         return_css("/vendor/OverlayScrollbars-1.13.1/css/OverlayScrollbars.min.css"),
         return_css("/css/portal/custom.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         /* SweetAlert is needed for sign-in errors */
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>'
      ];
      if (!Auth::check()) {
         array_push($data['add_js'], '<script src="https://accounts.google.com/gsi/client" async defer></script>');
         array_push($data['add_js'], return_jscript("/js/portal/social-login.js"));
      }
      array_push($data['add_js'], return_jscript("/js/portal/portal-main.js"));

   
      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      if (empty(Auth::check())) {
         $data['page_title'] = "Templates";
         echo view('portal.page-need2login', $data);
      } else {
         echo view('portal.page-templates');
      }
      echo view('portal.asset-footer', $data);
   }


   # How To #######################################################################################
   public function HowTo() {
      # Always shown (signed-in or guest visitors)

      $data['head_title'] = "How To - " . config('app.name');
      $data['head_description'] = config('app.name') . " - How To";
      $data['page_name'] = "howto";
      $data['page_type'] = "portal";
      $data['add_css'] = [
         return_css("/vendor/OverlayScrollbars-1.13.1/css/OverlayScrollbars.min.css"),
         return_css("/css/portal/custom.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         /* SweetAlert is needed for sign-in errors */
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>'
      ];
      if (!Auth::check()) { # Show the social login plugin even if login is not mandatory
         array_push($data['add_js'], '<script src="https://accounts.google.com/gsi/client" async defer></script>');
         array_push($data['add_js'], return_jscript("/js/portal/social-login.js"));
      }
      array_push($data['add_js'], return_jscript("/js/portal/portal-main.js"));

   
      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      echo view('portal.page-howto');
      echo view('portal.asset-footer', $data);
   }


   # HowTo ########################################################################################
   public function Contact() {
      # Always shown (signed-in or guest visitors)

      $data['head_title'] = "Contact us - " . config('app.name');
      $data['head_description'] = config('app.name') . " - Contact us";
      $data['page_name'] = "contact";
      $data['page_type'] = "portal";
      $data['add_css'] = [
         return_css("/vendor/OverlayScrollbars-1.13.1/css/OverlayScrollbars.min.css"),
         return_css("/css/portal/custom.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         /* SweetAlert is needed for sign-in errors */
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>'
      ];
      if (!Auth::check()) { # Show the social login plugin even if login is not mandatory
         array_push($data['add_js'], '<script src="https://accounts.google.com/gsi/client" async defer></script>');
         array_push($data['add_js'], return_jscript("/js/portal/social-login.js"));
      }
      array_push($data['add_js'], return_jscript("/js/portal/portal-main.js"));

   
      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      echo view('portal.page-contact');
      echo view('portal.asset-footer', $data);
   }


   # My Account ###################################################################################
   public function MyAccount() {
      # If the user is logged-in (authenticated), show the actual page contents,
      # otherwise, show "You need to log-in" interface (user must have goten here manually!).

      $data['head_title'] = "My Account - " . config('app.name');
      $data['head_description'] = config('app.name') . " - My Account";
      $data['page_name'] = "myaccount";
      $data['page_type'] = "portal";
      $data['add_css'] = [
         return_css("/vendor/OverlayScrollbars-1.13.1/css/OverlayScrollbars.min.css"),
         return_css("/css/portal/custom.css")
      ];
      $data['add_js'] = [
         return_jscript("/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js"),
         return_jscript("/js/portal/adminlte.js"),
         /* SweetAlert is needed for sign-in errors */
         '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>'
      ];
      if (!Auth::check()) {
         array_push($data['add_js'], '<script src="https://accounts.google.com/gsi/client" async defer></script>');
         array_push($data['add_js'], return_jscript("/js/portal/social-login.js"));
      }
      array_push($data['add_js'], return_jscript("/js/portal/portal-main.js"));

   
      echo view('portal.asset-header', $data);
      echo view('portal.asset-pagenavs', $data);
      if (empty(Auth::check())) {
         $data['page_title'] = "My Account";
         echo view('portal.page-need2login', $data);
      } else {
         echo view('portal.page-myaccount');
      }
      echo view('portal.asset-footer', $data);
   }
}
