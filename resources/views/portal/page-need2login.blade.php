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