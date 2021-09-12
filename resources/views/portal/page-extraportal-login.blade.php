<body class="hold-transition login-page">
<div class="login-box">
   <div class="login-logo">
      <a href="/dashboard">
         <img alt="Patho&bull;Log" src="/img/logo/pl-logo.png" width="200" height="53" class="mb-3" />
      </a>
   </div><!-- /.login-logo -->

   <div class="card elevation-3">
      <div class="card-body login-card-body">
         <p class="login-box-msg">Sign in to start your session</p>

         <form id="form_login">
            <div class="input-group mb-3">
               <input type="email" name="email" class="form-control" placeholder="Email" maxlength="{{ config('consts.EMAIL_MAXLENGTH') }}" />
               <div class="input-group-append">
                  <div class="input-group-text">
                     <span class="fas fa-envelope"></span>
                  </div>
               </div>
            </div>

            <div class="input-group mb-3">
               <input type="password" name="password" class="form-control" placeholder="Password" maxlength="{{ config('consts.PASSWORD_MAXLENGTH') }}" />
               <div class="input-group-append">
                  <div class="input-group-text">
                     <span class="fas fa-lock"></span>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-8 d-flex flex-row align-items-center">
                  <div class="input-group mb-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" id="remember" />
                        <label class="custom-control-label" for="remember"><div class="custom-checkbox-label">Remember Me</div></label>
                     </div>
                  </div>
               </div><!-- /.col -->
               <div class="col-4">
                  <button type="submit" class="btn btn-turquoise btn-block">Sign In</button>
               </div><!-- /.col -->
            </div><!-- /.row -->
         </form>

         <div class="social-auth-links text-center mb-3">
            <p class="mt-3">- OR -</p>
            <a href="#" class="btn btn-block btn-primary">
               <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
               <i class="fab fa-google mr-2"></i> Sign in using Google
            </a>
         </div><!-- /.social-auth-links -->

         <p class="mb-1 text-center">
            <a href="/forgotpw">I forgot my password</a>
         </p>
         <p class="mb-0 text-center">
            <a href="/register">Register a new account</a>
         </p>
      </div><!-- /.login-card-body -->
   </div><!-- /.card -->
</div><!-- /.login-box -->
<!-- </body> is in the footer -->
