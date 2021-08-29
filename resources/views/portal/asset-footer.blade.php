@if ($page_name != "login") {{-- Check header and 2 positions below too --}}
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
@if (config('app.debug') == false)
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@else
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

@if ($page_name != "login") {{-- Check header, up and below too --}}
<script type="text/javascript" src="/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js"></script>
@else
   @if (config('app.debug') == false)
   <script src="/vendor/jquery-validation-1.19.3/dist/jquery.validate.min.js"></script>
   @else
   <script src="/vendor/jquery-validation-1.19.3/dist/jquery.validate.js"></script>
   @endif
@endif

@if (config('app.debug') == false)
<script src="/js/portal/adminlte.min.js"></script>
@else
<script src="/js/portal/adminlte.js"></script>
@endif

@if ($page_name != "login") {{-- Check header and 2 positions up too --}}
<script src="/js/portal/demo.js"></script>
@else
<script src="/js/portal/extraportal-scripts.js"></script> <!-- Custom scripts -->
@endif
</body>
</html>