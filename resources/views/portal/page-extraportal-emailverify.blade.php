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
         @elseif ($case == "already")
            <div class="row">
               <div class="col-12 d-flex justify-content-center text-success display-3"><i class="far fa-check-circle"></i></div>
            </div>

            <h3 class="mt-2 text-center">Already Verified!</h3>
            <br/>
            <p class="text-center">
               Your email is <strong>already verified!</strong> You don't need to do this more than once.
            </p>
            <p class="text-center">
               You can <a href="/login">log-in</a> using your email and password.
            </p>

            @if ($signedout)
            <div class="alert alert-default-primary" role="alert">
               <h5>
                  <i class="fas fa-info-circle bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"></i>
                  &nbsp;You need to log-in to continue
               </h5>
               <small>
                  Because an already logged-in account was found, but it's different than the account which is currently verifiying email!
               </small>
            </div>
            @endif

            <p class="text-center">
               You will be redirected shortly.<br/>
               Thank you!
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
               Please <a href="/login">log-in</a>, go to your profile page, and click on the &quot;re-send activation email&quot; button.
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

            @if ($signedout)
            <div class="alert alert-default-primary" role="alert">
               <h5>
                  <i class="fas fa-info-circle bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"></i>
                  &nbsp;You need to log-in to continue
               </h5>
               <small>
                  Because an already logged-in account was found, but it's different than the account which is currently verifiying email!
               </small>
            </div>
            @endif

            <p class="text-center mb-0">
               <a href="/dashboard">Return to Patho&bull;Log</a>
            </p>
         @elseif ($case == "verified")
            <div class="row">
               <div class="col-12 d-flex justify-content-center text-success display-3"><i class="far fa-check-circle"></i></div>
            </div>

            <h3 class="mt-2 text-center">Thank you!</h3>
            <br/>
            <p class="text-center">
               Your email is now <strong>verified!</strong>
            </p>
            <p class="text-center">
               You can <a href="/login">log-in</a> using your email and password.
            </p>

            @if ($signedout)
            <div class="alert alert-default-primary" role="alert">
               <h5>
                  <i class="fas fa-info-circle bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"></i>
                  &nbsp;You need to log-in to continue
               </h5>
               <small>
                  Because an already logged-in account was found, but it's different than the account which is currently verifiying email!
               </small>
            </div>
            @endif
            
            <p class="text-center">
               You will be redirected shortly.<br/>
            </p>
         @endif
      </div><!-- /.login-card-body -->
   </div><!-- /.card -->
</div><!-- /.login-box -->

@if ($autoredirect)
<script type='text/javascript'>
   $(function() {
      setTimeout(function() { location.href = "/login"; }, 13 * 1000);
   });
</script>
@endif
<!-- </body> is in the footer -->
