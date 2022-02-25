<body style="font-family: sans-serif; background-color: #f7f7f7;">
   <br/><br/>
   <table width="85%" cellpadding="0" cellspacing="0" style="border: 0; margin: auto; background-color: #fff;">
      <tr><td style="text-align: center;">
         <br/><br/>
         <a href="{{ url('/') }}">
            <img src="{{ $message->embed(__DIR__ . '/../../../public/img/emails/pl-logo.jpg') }}" alt="Patho•Log Logo" width="200" height="53" />
         </a>
      </td></tr>
      <tr><td style="text-align: center;">
         <h3 style="margin-top: 17px; color: #999;"><em>Welcome to Patho&bull;Log!</em></h3>
      </td></tr>
      <tr><td style="padding: 0 21px;">
         <br/>
         <p style="font-weight: bold;">Hi {{ $username }},</p>

         @if ($is_newreg)
         <p>
            Thank you for signing up to Patho&bull;Log. We hope that you'll find it useful and fun at the same time!<br/>
            Your account was created successfully! However, there is still one step left.
         </p>
         @endif
         <p>Please, click the button below to verify your email address and activate your account:</p>
      </td></tr>
      <tr><td style="text-align: center;">
         <br/><br/>
         <a href="{{ url('/') . '/emailverification/' . $email . '/' . $ver_code }}" style="border: 1px solid #e5c1f0; border-radius: 5px; padding: 9px 13px; text-decoration: none; background-color: #faf3fc; color: #9d2db9; font-weight: bold;">
            Activate my account
         </a><br/>
         <br/><br/>
      </td></tr>
      <tr><td style="text-align: center;">
         <small><strong>(This link is valid only for a limited period of time)</strong></small>
         <br/><br/>
      </td></tr>
      <tr><td style="padding: 0 21px;">
         <p>
            If you have any difficulties activating your account or signing in, don't hesitate to&nbsp;
            <a href="mailto:{{ config('mail.from.address') }}">contact our support</a>.
         </p>
         <p>Thank you, and have a great day!</p>
         <br/>
      </td></tr>
   </table>

   <table width="85%" cellpadding="0" cellspacing="0" style="border: 0; margin: auto;">
      <tr><td style="text-align: center;">
         <div style="width: 45%; height: 1px; border-top: 1px solid #ddd; margin: 25px auto 15px auto;"></div>
      </td></tr>
      <tr><td style="text-align: center;">
         <div style="font-size: 11px;">
            Patho&bull;Log &copy; {{ date('Y') }} - <a href="mailto:{{ config('mail.from.address') }}">Contact us</a>.
         </div>
         <br/><br/>
      </td></tr>
   </table>
</body>

{{--
   - Quote (from Laravel's official docs): "Inline attachments will not be rendered when a mailable is previewed in your browser."
   - include all means of contact in your footer (also social network links..ect)
--}}