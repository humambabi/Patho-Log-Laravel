Welcome to Patho•Log!


Hi {{ $username }},

We have received a request to reset your password.
If it was not you who requested this reset, please ignore this email or delete it.

To reset your password, please click on the following link,
(or copy and paste it into your browser's address bar, and press the 'Enter' key)
You will be redirected to Patho•Log website to create a new password:

{{ url('/') . '/passwordreset/' . $email . '/' . $pwr_code }}

(This link is valid only for a limited period of time)

If you have any difficulties signing in, don't hesitate to
contact our support team by sending an email to: {{ config('mail.from.address') }}

Thank you, and have a great day!
Patho•Log Team
