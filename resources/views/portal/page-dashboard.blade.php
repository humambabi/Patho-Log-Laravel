<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper">
   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
         <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>

         <!-- Topbar Search -->
         <form class="d-none d-sm-inline-block form-inline mr-auto navbar-search">
            <div class="input-group">
               <input type="text" class="form-control bg-light small border border-topbarsearch" placeholder="Search for..."
                     aria-label="Search" aria-describedby="basic-addon2" /> <!-- border-0 -->
               <div class="input-group-append">
                  <button class="btn btn-turquoise" type="button">
                     <i class="fas fa-search fa-sm"></i>
                  </button>
               </div>
            </div>
         </form>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
         <!-- User icon and menu-->
         <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" href="#" data-toggle="dropdown">
               <div class="d-none d-md-inline">Alexander Pierce</div>
               <img src="/img/portal/usericon.jpg" class="img-circle elevation-2" alt="User Image" width="37" height="37" style="margin-left: .5rem;">
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
               <span class="dropdown-item dropdown-header">15 Notifications</span>
               <div class="dropdown-divider"></div>
               <a href="#" class="dropdown-item">
                  <i class="fas fa-envelope mr-2"></i> 4 new messages
                  <span class="float-right text-muted text-sm">3 mins</span>
               </a>
               <div class="dropdown-divider"></div>
               <a href="#" class="dropdown-item">
                  <i class="fas fa-file mr-2"></i> 3 new reports
                  <span class="float-right text-muted text-sm">2 days</span>
               </a>
               <div class="dropdown-divider"></div>
               <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
         </li>
      </ul>
   </nav><!-- /.navbar -->


   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a class="brand-link d-flex align-items-center justify-content-center" href="{{ url('/') }}/dashboard">
         <div class="sidebar-brand-icon">
            <img src="/img/logo/twopartslogo_icon.png" alt="Logo-Icon" width="37" height="37" class="img-circle elevation-3" />
         </div>
         <div class="sidebar-brand-text">
            <img src="/img/logo/twopartslogo_text.png" alt="Logo-Text" width="109" height="37" />
         </div>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
         <!-- Sidebar Menu -->
         <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
               <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

               <li class="nav-item">
                  <a href="{{ url('/') }}/dashboard" class="nav-link{{ ($page_name == 'dashboard') ? ' active' : '' }}">
                     <i class="nav-icon fas fa-tachometer-alt"></i>
                     <p>
                        Dashboard
                     </p>
                  </a>
               </li>

               <li class="nav-item">
                  <a href="{{ url('/') }}/newreport" class="nav-link{{ ($page_name == 'newreport') ? ' active' : '' }}">
                     <i class="nav-icon fas fa-edit"></i>
                     <p>
                        New Report
                     </p>
                  </a>
               </li>

               <li class="nav-header">My Database</li>

               <li class="nav-item">
                  <a href="{{ url('/') }}/newreport" class="nav-link{{ ($page_name == 'newreport') ? ' active' : '' }}">
                     <i class="nav-icon fas fa-th-list"></i>
                     <p>
                        Saved Reports
                     </p>
                  </a>
               </li>
               
               <li class="nav-item">
                  <a href="{{ url('/') }}/newreport" class="nav-link{{ ($page_name == 'newreport') ? ' active' : '' }}">
                     <i class="nav-icon fas fa-search"></i>
                     <p>
                        Find Reports
                     </p>
                  </a>
               </li>

               <li class="nav-item">
                  <a href="#" class="nav-link">
                     <i class="nav-icon fas fa-database"></i>
                     <p>
                        Maintainance
                        <i class="right fas fa-angle-left"></i>
                     </p>
                  </a>

                  <ul class="nav nav-treeview">
                     <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Backup</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="pages/charts/flot.html" class="nav-link">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Restore</p>
                        </a>
                     </li>
                  </ul>
               </li>

               <li class="nav-header">Tools</li>

               <li class="nav-item">
                  <a href="{{ url('/') }}/newreport" class="nav-link{{ ($page_name == 'newreport') ? ' active' : '' }}">
                     <i class="nav-icon fas fa-copy"></i>
                     <p>
                        Templates
                     </p>
                  </a>
               </li>





        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Blank Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Blank Page</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Title</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          Start creating your amazing application!
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div><!-- ./wrapper -->
<!-- body is closed in footer -->