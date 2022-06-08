   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
         <div class="container-fluid">
            <div class="row mb-2 mt-3">
               <div class="col-sm-12">
                  <h1 class="m-0 text-center">{{ $page_title }}</h1>
               </div><!-- /.col -->
            </div><!-- /.row -->
         </div><!-- /.container-fluid -->
      </section><!-- /.content-header -->



      <style type="text/css">
         .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
         }
         .alert a {
             color: unset;
         }
      </style>
      <section class="content">
         <div class="container-fluid">
            <div class="alert alert-danger" role="alert">
               <strong>Dear users and visitors:</strong><br/><br/>
               The site is currently under testing and construction. If you find it useful, have an idea to improve it,
               or simply just want to say hi, you are always welcome to drop an email at:
               <a href="mailto:support@patho-log.com">support@patho-log.com</a><br/>
               Your donations are most appreciated, and will be dedicated to speeding up development.<br/><br/>
               Thank you very much ❤️
            </div>
         </div>
      </section>
        
        
        

      <!-- Main content -->
      <section class="content">
         <div class="container-fluid">
            <div class="row">
               <div class="col-lg-12">

                  <!-- Default box -->
                  <div class="card">
                     <div class="card-body text-center">
                        <br />
                        <h5>You need to sign-in to use this feature!</h5>
                        <br /><br />
                        <a class="btn btn-turquoise px-2 py-1 text-white font-weight-bold btn-nav-turquoise" href="{{ url('/') }}/login">Sign-in</a>
                        <br />
                        <br />
                     </div>
                  </div><!-- /.card -->

               </div><!-- /.col-md-6 -->
            </div><!-- /.row -->
         </div><!-- /.container-fluid -->
      </section><!-- /.content -->
   </div><!-- /.content-wrapper -->