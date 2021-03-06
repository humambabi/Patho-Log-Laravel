<?php

#
# Patho•Log Constants
#

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
define('MSG_RECAPTCHA_FAILED',                              "Google reCAPTCHA verification failed!");

# Paths (these are embedded into code and hard to find if were not here)
define('PATH_USER_PREDEFINEDPICTURES',                      "img/portal/user_pics"); # No "/" at the biginning or end

# Guest account
define('GUEST_USERNAME',                                    "Dr. Guest");

# Templates' "properties" definitions
define('TEMPLATE_STORAGE_DIRNAME',                          "report_templates");
define('PREVIEW_STORAGE_DIRNAME',                           "report_previews");

define('TEMPLATE_PROPS_FILENAME',                           "props.json");
define('TEMPLATE_PDF_FILENAME',                             "preview.pdf"); // thumbnail (change after adjusting papsmear)
define('TEMPLATE_THUMBNAIL_FILENAME',                       "thumbnail.jpg");

define('TEMPLATE_TEMP_MAXTIMEOUT_DAYS',                     1);
define('TEMPLATE_TEMPPDF_FILENAME',                         "rep_%s.pdf");
define('TEMPLATE_TEMPJPG_FILENAME',                         "rep_%s.jpg");

define('TEMPLATEPROPS_TEMPLATE_NAME',                       "template_name");
define('TEMPLATEPROPS_TEMPLATE_DESC',                       "template_description");
define('TEMPLATEPROPS_PAGE',                                "page");
define('TEMPLATEPROPS_PAGEFORMAT',                          "format");
define('TEMPLATEPROPS_PAGEMARGIN',                          "margin");
define('TEMPLATEPROPS_COMPONENTS',                          "components");
define('TEMPLATEPROPS_STYLE',                               "css");
define('TEMPLATEPROPS_BODY',                                "html");
define('TEMPLATEPROPS_FIELDS',                              "fields");

define('TEMPLATE_USERDATA_TPLID',                           "templateId");
