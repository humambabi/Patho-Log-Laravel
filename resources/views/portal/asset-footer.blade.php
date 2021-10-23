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
@php
   for ($iC = 0; $iC < count($add_js); $iC++) {
      echo $add_js[$iC] . "\r\n";
   }
@endphp
</body>
</html>