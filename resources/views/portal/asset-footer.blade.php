@if ($page_type == "portal")
   <footer class="main-footer">
      <div class="row">
         <div class="col-12 text-center mb-1 col-md-6 text-md-left mb-md-0">
            <strong>Copyright &copy; 2014-{{ date('Y') }} <a href="{{ url('/') }}"><span style="color: #00bfd8">Patho<span style="color: #bf60d8">&bull;</span>Log</span></a>.</strong> All rights reserved.
         </div>
         <div class="col-12 text-center mt-1 col-md-6 text-md-right mt-md-0">
            <a href="#">Terms and Conditions</a> &bull; <a href="#">Privacy Policy</a>
         </div>
      </div>
   </footer>
</div><!-- ./wrapper -->
@endif

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
{{ include_jscript("/vendor/jquery-validation-1.19.3/dist/jquery.validate.min.js") }}

@if ($page_type == "portal")
   {{ include_jscript("/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js") }}
@endif

{{ include_jscript("/js/portal/adminlte.js") }}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js" integrity="sha256-dOvlmZEDY4iFbZBwD8WWLNMbYhevyx6lzTpfVdo0asA=" crossorigin="anonymous"></script>

@if (in_array($page_name, ["register", "forgotpw"]))
   <script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLERECAPTCHA3_SITEKEY') }}"></script>
@endif

@guest
   @if (in_array($page_name, ["register", "login"]) || $page_type == "portal")
      <script src="https://accounts.google.com/gsi/client" async defer></script>
      {{ include_jscript("/js/portal/social-login.js") }}
   @endif
@endguest

@if ($page_type == "extraportal")
   {{ include_jscript("/js/portal/extraportal-scripts.js") }}
@endif
@if ($page_type == "portal")
   {{ include_jscript("/js/portal/portal-main.js") }}
@endif
</body>
</html>