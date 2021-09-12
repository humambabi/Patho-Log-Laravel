<body class="hold-transition login-page">
<div class="login-box">
   <div class="login-logo">
      <a href="/dashboard">
         <img alt="Patho&bull;Log" src="/img/logo/pl-logo.png" width="200" height="53" class="mb-3" />
      </a>
   </div><!-- /.login-logo -->

   <div class="card elevation-3">
      <div class="card-body login-card-body">
         <h3 class="text-center">Did you forgot your password?</h3>
         <p class="login-box-msg">If you forgot your password or cannot log-in anymore, you can request to reset your password.</p>
         <p class="text-center"><strong>
            Type your email address (that you have signed-up with) in the field below:
         </strong></p>

         <form id="form_forgotpw">
            <div class="input-group mb-3">
               <input type="email" name="email" class="form-control" placeholder="Email" maxlength="{{ config('consts.EMAIL_MAXLENGTH') }}" />
               <div class="input-group-append">
                  <div class="input-group-text">
                     <span class="fas fa-envelope"></span>
                  </div>
               </div>
            </div>

            <div class="row mb-3">
               <div class="col-8 mx-auto">
                  <button type="submit" class="btn btn-turquoise btn-block">Request a new password</button>
               </div>
            </div>
         </form>

         <p class="mb-1 text-center">
            I don't want to reset my password. <a href="/login">Login</a>
         </p>
         <p class="mb-0 text-center">
            I don't have an account yet! <a href="/register">Register</a>
         </p>
      </div><!-- /.login-card-body -->
   </div><!-- /.card -->
</div><!-- /.login-box -->

@if ($currently_signed_in)
<script type='text/javascript'>
   $(function() {
      setTimeout(function() {
         Swal.fire({
            title: "Attention!",
            html: "<p>You will be <strong>signed-out</strong> if you reset your password.</p><p>Do you want to continue?</p>",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes",
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            focusCancel: true,
            customClass: {
               confirmButton: 'btn btn-success mx-1',
               cancelButton: 'btn btn-danger mx-1'
            },
            buttonsStyling: false
         }).then(function(result) {
            if (result.isDismissed) location.href = "/login";
         });
      }, 150);
   });
</script>
@endif
<!-- </body> is in the footer -->
