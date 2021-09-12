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
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=swap" />
   {{ include_css("/vendor/fontawesome-free/css/all.min.css") }}
   {{ include_css("/css/portal/adminlte.css") }}
   @if ($page_type == "extraportal")
      {{ include_css("/css/portal/extraportal-custom.css") }}
   @endif
   @if ($page_type == "portal")
      {{ include_css("/vendor/OverlayScrollbars-1.13.1/css/OverlayScrollbars.min.css") }}
      {{ include_css("/css/portal/custom.css") }}
   @endif

   <!-- CSRF protection -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <!-- Only one important script -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   
   <!-- Back to front -->
   <script type="text/javascript">
      const USERNAME_MINLENGTH = {{ config('consts.USERNAME_MINLENGTH') }};
      const USERNAME_MAXLENGTH = {{ config('consts.USERNAME_MAXLENGTH') }};
      const EMAIL_MAXLENGTH = {{ config('consts.EMAIL_MAXLENGTH') }};
      const PASSWORD_MINLENGTH = {{ config('consts.PASSWORD_MINLENGTH') }};
      const PASSWORD_MAXLENGTH = {{ config('consts.PASSWORD_MAXLENGTH') }};
      const GR_PATHOLOG_SITEKEY = "{{ config('consts.GR_PATHOLOG_SITEKEY') }}";
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
   </script>

   <!-- gtag/g.analytics - same as the comingsoon page -->
   <!-- -->
</head>
