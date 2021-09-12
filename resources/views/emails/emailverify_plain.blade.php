Welcome to Patho•Log!


Hi {{ $username }},

Thank you for signing up to Patho•Log.
We hope that you'll find it useful and fun at the same time!

Your account was created successfully! However, there is still one step left.

To verify your email address and activate your account,
please click on the following link (or copy and paste it into your browser's address bar, and press the 'Enter' key):

{{ url('/') . '/emailverification/' . $email . '/' . $ver_code }}

(This link is valid only for a limited period of time)

If you have any difficulties activating your account or signing in, don't hesitate to
contact our support team by sending an email to: {{ config('consts.PATHOLOG_EMAIL_SUPPORT') }}

Thank you, and have a great day!
Patho•Log Team
