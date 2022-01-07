<?php

#
# Patho•Log Constants
#

# Main Support email address
define('EMAIL_SUPPORT_ADDRESS',                             env('MAIL_FROM_ADDRESS', 'support@patho-log.com'));
define('EMAIL_SUPPORT_SENDERNAME',                          env('MAIL_FROM_NAME', 'Patho•Log'));

# General app tools
define('DB_DATETIME_FMT',                                   "Y-m-d H:i:s");

# User account
define('USERNAME_MINLENGTH',                                2);
define('USERNAME_MAXLENGTH',                                35);
define('EMAIL_MAXLENGTH',                                   150);
define('PASSWORD_MINLENGTH',                                5);
define('PASSWORD_MAXLENGTH',                                255);
define('VERIFICATIONCODE_LENGTH',                           33);
define('EMAILVERIFICATIONCODE_VALIDITY_MINUTES',            60 * 24 * 3);
define('PASSWORDRESETCODE_VALIDITY_MINUTES',                60 * 24 * 1);

# Cookies
define('COOKIE_AUTOLOGIN',                                  "login_signature");

# Google reCAPTCHA v3
define('GR_ACTION_ACCOUNTREGISTER',                         "AccountRegister");
define('GR_ACTION_RESETPASSWORD',                           "ResetPassword");

# Errors
define('ERR_NOERROR',                                       0);
define('ERR_UNEXPECTED',                                    1);
define('ERR_WITHMSG',                                       2);
define('ERR_WITHMSG_USERNAME',                              3);
define('ERR_WITHMSG_EMAIL',                                 4);
define('ERR_WITHMSG_PASSWORD',                              5);
define('ERR_WITHMSG_TERMS',                                 6);

# Validation Messages
define('MSG_USERNAME_REQUIRED',                             "Please type a user name!");
define('MSG_USERNAME_BETWEEN_FMT',                          "User name must be between %u and %u characters!");
define('MSG_EMAIL_REQUIRED',                                "Please type an e-mail address!");
define('MSG_EMAIL_VALIDEMAILADDR',                          "Please type a valid e-mail address!");
define('MSG_EMAIL_MAXLEN_FMT',                              "E-mail address cannot be longer than %u characters!");
define('MSG_EMAIL_UNIQUE',                                  "This e-mail has already been taken!");
define('MSG_PASSWORD_REQUIRED',                             "Please type a password!");
define('MSG_PASSWORD_MINLEN_FMT',                           "Password must be at least %u characters long!");
define('MSG_PASSWORD_MAXLEN_FMT',                           "Password cannot be longer than %u characters!");
define('MSG_PASSWORDCONFIRM_REQUIRED',                      "Please re-type your password!");
define('MSG_PASSWORDCONFIRM_EQUAL',                         "Passwords do not match!");
define('MSG_TERMSPRIVACY_ACCEPT',                           "Please accept the terms to continue");
define('MSG_RECAPTCHA_FAILED',                              "Google reCAPTCHA verificaiton failed!");

# Paths (these are embedded into code and hard to find if were not here)
define('PATH_USER_PREDEFINEDPICTURES',                      "img/portal/user_pics"); # No "/" at the biginning or end

# Guest account
define('GUEST_USERNAME',                                    "Dr. Guest");

# Steps of Creating a new report
define('S01_TEMPLATE',                                      "template");
define('S02_PATIENT',                                       "patient");
