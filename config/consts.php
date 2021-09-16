<?php

#
# Patho•Log Constants
#

return [
   # Main Support email address
   'PATHOLOG_EMAIL_SUPPORT'                        => "support@patho-log.com",
   'PATHOLOG_EMAIL_SENDERNAME'                     => "Patho•Log",

   # General app tools
   'DB_DATETIME_FMT'                               => "Y-m-d H:i:s",
   
   # User account
   'USERNAME_MINLENGTH'                            => 2,
   'USERNAME_MAXLENGTH'                            => 35,
   'EMAIL_MAXLENGTH'                               => 150,
   'PASSWORD_MINLENGTH'                            => 5,
   'PASSWORD_MAXLENGTH'                            => 255,
   'VERIFICATIONCODE_LENGTH'                       => 33,
   'EMAILVERIFICATIONCODE_VALIDITY_MINUTES'        => 60 * 24 * 3,
   'PASSWORDRESETCODE_VALIDITY_MINUTES'            => 60 * 24 * 1,

   # Cookies
   'COOKIE_AUTOLOGIN'                              => "auto_login",

   # Google reCAPTCHA v3
   'GR_PATHOLOG_SITEKEY'                           => "6Ld_EDgcAAAAANjtDs7tfuIeAPiRqJR3WmjvEZEF",
   'GR_PATHOLOG_SECRETKEY'                         => "6Ld_EDgcAAAAAMSU6x-hd5UQqBknkE64S_wjSIFA",
   'GR_ACTION_ACCOUNTREGISTER'                     => "AccountRegister",
   'GR_ACTION_RESETPASSWORD'                       => "ResetPassword",

   # Errors
   'ERR_NOERROR'                                   => 0,
   'ERR_UNEXPECTED'                                => 1,
   'ERR_WITHMSG'                                   => 2,
   'ERR_WITHMSG_USERNAME'                          => 3,
   'ERR_WITHMSG_EMAIL'                             => 4,
   'ERR_WITHMSG_PASSWORD'                          => 5,
   'ERR_WITHMSG_TERMS'                             => 6,

   # Validation Messages
   'MSG_USERNAME_REQUIRED'                         => "Please type a user name!",
   'MSG_USERNAME_BETWEEN_FMT'                      => "User name must be between %u and %u characters!",
   'MSG_EMAIL_REQUIRED'                            => "Please type an e-mail address!",
   'MSG_EMAIL_VALIDEMAILADDR'                      => "Please type a valid e-mail address!",
   'MSG_EMAIL_MAXLEN_FMT'                          => "E-mail address cannot be longer than %u characters!",
   'MSG_EMAIL_UNIQUE'                              => "This e-mail has already been taken!",
   'MSG_PASSWORD_REQUIRED'                         => "Please type a password!",
   'MSG_PASSWORD_MINLEN_FMT'                       => "Password must be at least %u characters long!",
   'MSG_PASSWORD_MAXLEN_FMT'                       => "Password cannot be longer than %u characters!",
   'MSG_PASSWORDCONFIRM_REQUIRED'                  => "Please re-type your password!",
   'MSG_PASSWORDCONFIRM_EQUAL'                     => "Passwords do not match!",
   'MSG_TERMSPRIVACY_ACCEPT'                       => "Please accept the terms to continue",
   'MSG_RECAPTCHA_FAILED'                          => "Google reCAPTCHA verificaiton failed!"
];
