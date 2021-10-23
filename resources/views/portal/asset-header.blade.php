<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   
   <!-- SEO Meta Tags -->
   <meta name="description" content="{{ $head_description }}" />
   <meta name="author" content="Patho•Log Team" />

   <!-- Website Title -->
   <title>{{ $head_title }}</title>
   <base href="{{ url('/') }}" />
   
   <!-- Favicon -->
   <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" /> <!-- IE -->
   <link rel="icon" type="image/x-icon" href="/favicon.ico" />	<!-- All others -->
   <link rel="apple-touch-icon" sizes="180x180" href="/img/logo/apple-touch-icon.png" />
   <link rel="icon" type="image/png" sizes="32x32" href="/img/logo/favicon-32x32.png" />
   <link rel="icon" type="image/png" sizes="16x16" href="/img/logo/favicon-16x16.png" />
   <link rel="manifest" href="/site.webmanifest" />

   <!-- Styles -->
   <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=swap' />
   {{ print_css("/vendor/fontawesome-free/css/all.min.css") }}
   {{ print_css("/css/portal/adminlte.css") }}
   @php
   for ($iC = 0; $iC < count($add_css); $iC++) {
      echo $add_css[$iC] . "\r\n" . "   "; # Not a '\t' because we are using 3 spaces in this source file!
   }
   @endphp

   <!-- CSRF protection -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <!-- Only one important script -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   
   <!-- Back to front -->
   <script type="text/javascript">
      const PAGE_TYPE = @php echo "\"" . $page_type . "\""; @endphp;
      const PAGE_NAME = @php echo "\"" . $page_name . "\""; @endphp;
      const USERNAME_MINLENGTH = {{ config('consts.USERNAME_MINLENGTH') }};
      const USERNAME_MAXLENGTH = {{ config('consts.USERNAME_MAXLENGTH') }};
      const EMAIL_MAXLENGTH = {{ config('consts.EMAIL_MAXLENGTH') }};
      const PASSWORD_MINLENGTH = {{ config('consts.PASSWORD_MINLENGTH') }};
      const PASSWORD_MAXLENGTH = {{ config('consts.PASSWORD_MAXLENGTH') }};
      const GOOGLERECAPTCHA3_SITEKEY = "{{ env('GOOGLERECAPTCHA3_SITEKEY') }}";
      const GR_ACTION_ACCOUNTREGISTER = "{{ config('consts.GR_ACTION_ACCOUNTREGISTER') }}";
      const GR_ACTION_RESETPASSWORD = "{{ config('consts.GR_ACTION_RESETPASSWORD') }}";
      const ERR_NOERROR = {{ config('consts.ERR_NOERROR') }};
      const ERR_UNEXPECTED = {{ config('consts.ERR_UNEXPECTED') }};
      const ERR_WITHMSG = {{ config('consts.ERR_WITHMSG') }};
      const ERR_WITHMSG_USERNAME = {{ config('consts.ERR_WITHMSG_USERNAME') }};
      const ERR_WITHMSG_EMAIL = {{ config('consts.ERR_WITHMSG_EMAIL') }};
      const ERR_WITHMSG_PASSWORD = {{ config('consts.ERR_WITHMSG_PASSWORD') }};
      const ERR_WITHMSG_TERMS = {{ config('consts.ERR_WITHMSG_TERMS') }};
      const MSG_USERNAME_REQUIRED = "{{ config('consts.MSG_USERNAME_REQUIRED') }}";
      const MSG_USERNAME_BETWEEN = @php echo "\"" . sprintf(config('consts.MSG_USERNAME_BETWEEN_FMT'), config('consts.USERNAME_MINLENGTH'), config('consts.USERNAME_MAXLENGTH')) . "\""; @endphp;
      const MSG_EMAIL_REQUIRED = "{{ config('consts.MSG_EMAIL_REQUIRED') }}";
      const MSG_EMAIL_VALIDEMAILADDR = "{{ config('consts.MSG_EMAIL_VALIDEMAILADDR') }}";
      const MSG_EMAIL_MAXLEN = @php echo "\"" . sprintf(config('consts.MSG_EMAIL_MAXLEN_FMT'), config('consts.EMAIL_MAXLENGTH')) . "\""; @endphp;
      const MSG_PASSWORD_REQUIRED = "{{ config('consts.MSG_PASSWORD_REQUIRED') }}";
      const MSG_PASSWORD_MINLEN = @php echo "\"" . sprintf(config('consts.MSG_PASSWORD_MINLEN_FMT'), config('consts.PASSWORD_MINLENGTH')) . "\""; @endphp;
      const MSG_PASSWORD_MAXLEN = @php echo "\"" . sprintf(config('consts.MSG_PASSWORD_MAXLEN_FMT'), config('consts.PASSWORD_MAXLENGTH')) . "\""; @endphp;
      const MSG_PASSWORDCONFIRM_REQUIRED = "{{ config('consts.MSG_PASSWORDCONFIRM_REQUIRED') }}";
      const MSG_PASSWORDCONFIRM_EQUAL = "{{ config('consts.MSG_PASSWORDCONFIRM_EQUAL') }}";
      const MSG_TERMSPRIVACY_ACCEPT = "{{ config('consts.MSG_TERMSPRIVACY_ACCEPT') }}";
      const SOCIALLOGIN_GOOGLE_CLIENT_ID = "{{ env('SOCIALLOGIN_GOOGLE_CLIENT_ID') }}";
   </script>

   <!-- gtag/g.analytics - same as the comingsoon page -->
   <!-- -->
</head>
@php
   #
   # This code is here because it's common for all pages of the portal section of the app.
   # So, if you changed this behavior, consider updating this code here.
   # Middleware didn't work, because you cannot check Auth before passing the request to its controller,
   # and if you pass it, then you cannot use setcookie().
   #
   $authenticated = false; $cookieexpired = true;

   if (env('APP_ENV', 'production') != 'production') Log::warning("--------------------------------------------------");
   if (Auth::check()) $authenticated = true;
   if (!empty($_COOKIE[config('consts.COOKIE_AUTOLOGIN')])) $cookieexpired = false;

   if (env('APP_ENV', 'production') != 'production') Log::warning("DetectAutoLogin: \$auth:" . ($authenticated ? "yes" : "no") . ", \$expired:" . ($cookieexpired ? "yes" : "no"));

   if ($authenticated && $cookieexpired) {
      if (env('APP_ENV', 'production') != 'production') Log::warning("Setting 'auto_login' cookie, and DB->IPStats...");

      $modUser = \App\Models\User::where('email', Auth::user()['email'])->first();
      if (!empty($modUser)) {
         # Add login statistics in the DB
         $strJSON = add_userlogin_record($modUser->ipaddrs_obj, request()->ip());
         $modUser->update(['ipaddrs_obj' => $strJSON]);

         # Don't set an expiry time (0) -> cookie expire when browser is closed.
         setcookie(config('consts.COOKIE_AUTOLOGIN'), "1");
      }
   }

   #
   # When to update IP counter (in the db):
   # 1. Here with 'setcookie'
   # 2. When login (no need),
   #  Note that user will be logged out in two case:
   #  a. If not using 'remembed me' -> when the browser is closed.
   #  b. if using 'remember me' -> when they manually select 'sign out' from the user menu.
   #  on both cases, 'setcookie' here will be triggered.
   #
@endphp