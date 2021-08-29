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
         <form class="d-none d-sm-flex flex-row align-items-center form-inline mr-auto navbar-search">
            <div class="input-group w-100">
               <input type="text" class="form-control bg-light small border border-topbarsearch" placeholder="Search for..."
                     aria-label="Search" aria-describedby="basic-addon2" /> <!-- border-0 -->
               <div class="input-group-append">
                  <button class="btn btn-turquoise" type="button">
                     <i class="fas fa-search fa-sm"></i>
                  </button>
               </div>
            </div>
         </form><!-- /Topbar Search -->
      </ul>

      <!-- Topbar Logo -->
      <ul class="navbar-nav d-sm-none d-flex align-items-center justify-content-center ml-3" style="width: 100%;">
         <a href="{{ url('/') }}/dashboard">
            <img src="/img/logo/twopartslogo_text_black.png" alt="Logo-Text" width="109" height="37" />
         </a>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
         <!-- User icon and menu-->
         <li class="nav-item dropdown user-menu">
            <a class="nav-link d-flex align-items-center" href="#" data-toggle="dropdown">
               <div class="d-none d-md-inline">Alexander Pierce</div>
               <img src="/img/portal/usericon.jpg" class="img-circle elevation-2" alt="User Image" width="37" height="37" style="margin-left: .5rem;">
            </a>

            <div class="dropdown-menu dropdown-menu-right flex-column align-items-center">
               <div class="user-header d-flex flex-column align-items-center justify-content-center mt-3 mb-1">
                  <img src="/img/portal/usericon.jpg" class="img-circle elevation-2" alt="User Image" />
                  <p>Alexander Pierce</p>
               </div>

               <a href="#" class="dropdown-item text-center border-top">My Account</a>
               <a href="#" class="dropdown-item text-center border-top rounded-bottom">Sign Out</a>
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
            <img src="/img/logo/twopartslogo_text_white.png" alt="Logo-Text" width="109" height="37" />
         </div>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
         <!-- SidebarSearch Form -->
         <div class="form-inline mt-2 d-sm-none">
            <div class="input-group" data-widget="sidebar-search">
               <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
               <div class="input-group-append">
                  <button class="btn btn-sidebar">
                     <i class="fas fa-search fa-fw"></i>
                  </button>
               </div>
            </div>
         </div><!-- /SidebarSearch -->

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

               <hr class="my-2" />
               <li class="nav-header">My Database</li>

               <li class="nav-item">
                  <a href="{{ url('/') }}/savedreports" class="nav-link{{ ($page_name == 'savedreports') ? ' active' : '' }}">
                     <i class="nav-icon fas fa-th-list"></i>
                     <p>
                        Saved Reports
                     </p>
                  </a>
               </li>
               
               <li class="nav-item">
                  <a href="{{ url('/') }}/savedreports" class="nav-link{{ ($page_name == 'savedreports') ? ' active' : '' }}">
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

               <hr class="my-2" />
               <li class="nav-header">Tools</li>

               <li class="nav-item">
                  <a href="{{ url('/') }}/savedreports" class="nav-link{{ ($page_name == 'savedreports') ? ' active' : '' }}">
                     <i class="nav-icon fas fa-copy"></i>
                     <p>
                        Templates
                     </p>
                  </a>
               </li>

               <hr class="my-2" />
               <li class="nav-header">Help</li>

               <li class="nav-item">
                  <a href="{{ url('/') }}/savedreports" class="nav-link{{ ($page_name == 'savedreports') ? ' active' : '' }}">
                     <i class="nav-icon fas fa-question-circle"></i>
                     <p>
                        How to...
                     </p>
                  </a>
               </li>

               <li class="nav-item">
                  <a href="{{ url('/') }}/savedreports" class="nav-link{{ ($page_name == 'savedreports') ? ' active' : '' }}">
                     <i class="nav-icon fas fa-envelope-open-text"></i>
                     <p>
                        Contact us
                     </p>
                  </a>
               </li>
            </ul>
         </nav><!-- /.sidebar-menu -->
      </div><!-- /.sidebar -->
   </aside>