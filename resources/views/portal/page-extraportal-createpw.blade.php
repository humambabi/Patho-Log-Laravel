<body class="hold-transition login-page">
<div class="login-box">
   <div class="login-logo">
      <a href="/dashboard">
         <img alt="Patho&bull;Log" src="/img/logo/pl-logo.png" width="200" height="53" class="mb-3" />
      </a>
   </div><!-- /.login-logo -->

   <div class="card elevation-3">
      <div class="card-body login-card-body">
         <h4 class="text-center">Create a new password</h4>
         <p class="login-box-msg">You are only one step away. Now type a new password for your account</p>

         <form id="form_createpw">
         <div class="input-group mb-3">
               <input type="password" name="password" class="form-control" placeholder="Password" maxlength="{{ config('consts.PASSWORD_MAXLENGTH') }}" />
               <div class="input-group-append">
                  <div class="input-group-text">
                     <span class="fas fa-lock"></span>
                  </div>
               </div>
            </div>

            <div class="input-group mb-3">
               <input type="password" name="confirm_password" class="form-control" placeholder="Retype password" maxlength="{{ config('consts.PASSWORD_MAXLENGTH') }}" />
               <div class="input-group-append">
                  <div class="input-group-text">
                     <span class="fas fa-lock"></span>
                  </div>
               </div>
            </div>

            <div class="row mb-3">
               <div class="col-6 mx-auto">
                  <button type="submit" class="btn btn-turquoise btn-block">Set Password</button>
               </div>
            </div>
         </form>

         <p class="mb-1 text-center">
            I don't want to change my password. <a href="/login">Login</a>
         </p>
         <p class="mb-0 text-center">
            I don't have an account yet! <a href="/register">Register</a>
         </p>
      </div><!-- /.login-card-body -->
   </div><!-- /.card -->
</div><!-- /.login-box -->
<!-- </body> is in the footer -->
