<body class="hold-transition register-page">
<div class="register-box mt-5">
   <div class="register-logo">
      <a href="{{ url('/') }}/default">
         <img alt="Patho&bull;Log" src="/img/logo/pl-logo.png" width="200" height="53" class="mb-3" />
      </a>
   </div><!-- /.register-logo -->

   <div class="card elevation-3 mb-4">
      <div class="card-body register-card-body">
         <p class="login-box-msg">Register a new account</p>
         <form id="form_register">
            <div class="input-group mb-3">
               <input type="text" name="username" class="form-control" placeholder="Name" maxlength="{{ USERNAME_MAXLENGTH }}" />
               <div class="input-group-append">
                  <div class="input-group-text">
                     <span class="fas fa-user"></span>
                  </div>
               </div>
            </div>

            <div class="input-group mb-3">
               <input type="email" name="email" class="form-control" placeholder="Email" maxlength="{{ EMAIL_MAXLENGTH }}" />
               <div class="input-group-append">
                  <div class="input-group-text">
                     <span class="fas fa-envelope"></span>
                  </div>
               </div>
            </div>

            <div class="input-group mb-3">
               <input type="password" name="password" class="form-control" placeholder="Password" maxlength="{{ PASSWORD_MAXLENGTH }}" />
               <div class="input-group-append">
                  <div class="input-group-text">
                     <span class="fas fa-lock"></span>
                  </div>
               </div>
            </div>

            <div class="input-group mb-3">
               <input type="password" name="confirm_password" class="form-control" placeholder="Retype password" maxlength="{{ PASSWORD_MAXLENGTH }}" />
               <div class="input-group-append">
                  <div class="input-group-text">
                     <span class="fas fa-lock"></span>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-8">
                  <div class="input-group mb-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="terms" class="custom-control-input" id="terms" required />
                        <label class="custom-control-label" for="terms">
                           <div class="custom-checkbox-label">
                              I agree to the <a target="_blank" href="{{ url('/') }}/terms-conditions">terms and conditions</a>, and the <a target="_blank" href="{{ url('/') }}/privacy-policy">privacy policy</a>.
                           </div>
                        </label>
                     </div>
                  </div>
               </div><!-- /.col -->

               <div class="col-4" style="margin-top: 6px;">
                  <button type="submit" class="btn btn-turquoise btn-block">Register</button>
               </div><!-- /.col -->
            </div><!-- /.row -->
         </form>

         <div class="social-auth-links text-center mb-3">
            <p class="mt-3">- OR -</p>
            <a href="#" class="btn btn-block btn-primary">
               <i class="fab fa-facebook mr-2"></i> Sign up using Facebook
            </a>

            <div id="loginGoogle" class="mt-1"></div>
            <!--
            <a href="#" class="btn btn-block btn-danger">
               <i class="fab fa-google mr-2"></i> Sign up using Google
            </a>
            -->

         </div><!-- /.social-auth-links -->

         <p class="text-center mb-0">
            <a href="/login" class="text-center">I already have an account</a>
         </p>
      </div><!-- /.register-card-body -->
   </div><!-- /.card -->
</div><!-- /.register-box -->
<!-- </body> is in the footer -->