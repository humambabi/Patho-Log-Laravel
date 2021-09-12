<body class="hold-transition login-page">
<div class="login-box">
   <div class="login-logo">
      <a href="/dashboard">
         <img alt="Patho&bull;Log" src="/img/logo/pl-logo.png" width="200" height="53" class="mb-3" />
      </a>
   </div><!-- /.login-logo -->

   <div class="card elevation-3">
      <div class="card-body login-card-body">
         @if ($case == "error")
            <div class="row">
               <div class="col-12 d-flex justify-content-center text-danger display-3"><i class="fas fa-times"></i></div>
            </div>

            <h3 class="mt-2 text-center">Sorry!</h3>
            <br/>
            <p class="text-center">An <strong>unexpected error</strong> has occurred!</p>
            <p class="text-center">
               Please, send us an email and let us know what happened:&nbsp;
               <a href="mailto:{{ config('consts.PATHOLOG_EMAIL_SUPPORT') }}">{{ config('consts.PATHOLOG_EMAIL_SUPPORT') }}</a>.
            </p>
            <p class="text-center mb-0">
               <a href="/dashboard">Return to Patho&bull;Log</a>
            </p>
         @elseif ($case == "wrong")
            <div class="row">
               <div class="col-12 d-flex justify-content-center text-warning display-3"><i class="fas fa-exclamation"></i></div>
            </div>

            <h3 class="mt-2 text-center">Sorry!</h3>
            <br/>
            <p class="text-center">
               It seems that you have <strong>followed an invalid link!</strong>
            </p>
            <p class="text-center">
               If you need help, please, leave us an email at:&nbsp;
               <a href="mailto:{{ config('consts.PATHOLOG_EMAIL_SUPPORT') }}">{{ config('consts.PATHOLOG_EMAIL_SUPPORT') }}</a>.
            </p>
            <p class="text-center mb-0">
               <a href="/dashboard">Return to Patho&bull;Log</a>
            </p>
         @elseif ($case == "expired")
            <div class="row">
               <div class="col-12 d-flex justify-content-center text-warning display-3"><i class="far fa-clock"></i></div>
            </div>

            <h3 class="mt-2 text-center">Sorry!</h3>
            <br/>
            <p class="text-center">
               Your link <strong>has expired!</strong>
            </p>
            <p class="text-center">
               Please, click on the following link to request a new reset of your password.
            </p>
            <p class="text-center">
               <a href="/forgotpw">Reset my password</a>
            </p>
            <p class="mb-1 text-sm">Make sure that you:</p>
            <ol class="text-sm">
               <li>Click on the link in your email <strong>within the valid period</strong>, and</li>
               <li>Open the <strong>new</strong> email rather than the <strong>old</strong> one.</li>
            </ol>
            <p class="text-center">
               If you need help, please, leave us an email at:&nbsp;
               <a href="mailto:{{ config('consts.PATHOLOG_EMAIL_SUPPORT') }}">{{ config('consts.PATHOLOG_EMAIL_SUPPORT') }}</a>.
            </p>
            <p class="text-center mb-0">
               <a href="/dashboard">Return to Patho&bull;Log</a>
            </p>
         @elseif ($case == "createnew")
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
         @endif
      </div><!-- /.login-card-body -->
   </div><!-- /.card -->
</div><!-- /.login-box -->
<!-- </body> is in the footer -->
