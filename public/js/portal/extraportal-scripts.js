/*
Patho•Log - extra-portal script
*/

'use strict';

// Set jQ's ajax general settings
$.ajaxSetup({
   headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Laravel's CSRF Setup
   },
   type: 'POST',
   datatype: 'JSON',
   /*timeout: 5000,*/
   error: function(jqXHR, textStatus, errorThrown) {
      var msgHtml = "<p>Sorry!</p><p>An unknown error occurred!</p>";
      var errHtml = "<p><small>Error: " + jqXHR.status + ((errorThrown && errorThrown.length) ? " (" + errorThrown + ")" : "") + "</small></p>";
      
      if (jqXHR.status == 0) { // Cannot reach server
         msgHtml = "<p>Cannot communicate with the server right now!</p><p>Please, try again later.</p>";
      }
      if (jqXHR.status == 419) { // CSRF token mismatch
         msgHtml = "<p>Sorry, your session has expired!</p><p>The page will be refreshed now.</p>";
         errHtml = "";
      }

      Swal.fire(
         {title: "Alert!", html: msgHtml + errHtml, icon: "warning"}
      )
      .then(function() {
         if (jqXHR.status == 419) location.reload(true); // Reload from server. (false => may be from cache)
      });
   }
});

// When the document is ready...
$(function() {
   // "Register" form /////////////////////////////////////////////////////////////////////////////
   var validatorRegister = $("#form_register").validate({
      rules: {
         username: {
            required: true, minlength: USERNAME_MINLENGTH, maxlength: USERNAME_MAXLENGTH,

            normalizer: function(value) { // Using the normalizer to trim the value of the element before validating it.
               return $.trim(value); // The value of `this` inside the `normalizer` is the corresponding DOMElement.
            }
         },
         email: {
            required: true, email: true, maxlength: EMAIL_MAXLENGTH,

            normalizer: function(value) { // Using the normalizer to trim the value of the element before validating it.
               return $.trim(value); // The value of `this` inside the `normalizer` is the corresponding DOMElement.
            }
         },
         password: { required: true, minlength: PASSWORD_MINLENGTH, maxlength: PASSWORD_MAXLENGTH },
         confirm_password: { required: true, equalTo: "input[name=password]"},
         terms: { required: true }
      },
      messages: {
         username: {required: MSG_USERNAME_REQUIRED, minlength: MSG_USERNAME_BETWEEN, maxlength: MSG_USERNAME_BETWEEN},
         email: {required: MSG_EMAIL_REQUIRED, email: MSG_EMAIL_VALIDEMAILADDR, maxlength: MSG_EMAIL_MAXLEN},
         password: {required: MSG_PASSWORD_REQUIRED, minlength: MSG_PASSWORD_MINLEN, maxlength: MSG_PASSWORD_MAXLEN},
         confirm_password: {required: MSG_PASSWORDCONFIRM_REQUIRED, equalTo: MSG_PASSWORDCONFIRM_EQUAL},
         terms: MSG_TERMSPRIVACY_ACCEPT
      },
      errorElement: 'em',
      errorPlacement: function (error, element) {
         error.addClass('invalid-feedback');
         element.closest('.input-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
         $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
         $(element).removeClass('is-invalid');
      },
      submitHandler: function (form) {
         var username = $(form).find("input[name='username']").val().trim();
         var email = $(form).find("input[name='email']").val().trim();
         var password = $(form).find("input[name='password']").val();
         var conf_password = $(form).find("input[name=confirm_password]").val();
         var terms = $(form).find("input#terms").prop('checked') ? true : false;

         //console.log(username); console.log(email); console.log(password); console.log(conf_password); console.log(terms);

         if (conf_password != password) {
            Swal.fire({title: 'Alert!', text: 'Double check your passwords, they mismatch!', icon: 'warning'});
            return;
         }
         
         // Execute reCAPTCHA v3 directly before sending data to the server (2 mins validity)
         grecaptcha.ready(function() {
            grecaptcha.execute(GR_PATHOLOG_SITEKEY, {action: GR_ACTION_ACCOUNTREGISTER}).then(function(token) {
               // Submit the user input to the server
               $.ajax({
                  url: "/reqRegister",
                  data: {
                     _token: $('meta[name="csrf-token"]').attr('content'), // Laravel's CSRF Setup
                     username: username,
                     email: email,
                     password: password,
                     terms: terms,
                     gr_token: token
                  }
               })
               .done(function (response) {
                  if (!(typeof(response) === "object")) {
                     console.log(response);
                     Swal.fire({
                        title: "Error!",
                        html: "<p>Sorry!</p><p>An unknown server error occurred!</p><p>Please, try again later.</p>",
                        icon: "error"
                     });
                     return;
                  }

                  // It's a JSON
                  //console.log(response);

                  if (response.retcode == ERR_WITHMSG_USERNAME) {
                     validatorRegister.showErrors({username: response.errmsg});
                     return;
                  }
                  if (response.retcode == ERR_WITHMSG_EMAIL) {
                     validatorRegister.showErrors({email: response.errmsg});
                     return;
                  }
                  if (response.retcode == ERR_WITHMSG_PASSWORD) {
                     validatorRegister.showErrors({password: response.errmsg});
                     return;
                  }
                  if (response.retcode == ERR_WITHMSG_TERMS) {
                     validatorRegister.showErrors({terms: response.errmsg});
                     return;
                  }
                  if (response.retcode == ERR_WITHMSG) { // General & reCAPTCHA
                     Swal.fire({title: "Alert!", html: "<p>" + response.errmsg + "</p>", icon: "warning"});
                     return;
                  }
                  if (response.retcode == ERR_UNEXPECTED) { // Code bug!
                     Swal.fire({title: "Alert!", html: "<p>Sorry! Unexpected error ocurred!</p><p>Try again later.</p>", icon: "warning"});
                     return;
                  }

                  if (response.retcode == ERR_NOERROR) {
                     Swal.fire(
                        {title: response.msgTitle, html: response.msgHtml, icon: response.msgIcon}
                     )
                     .then(function() {
                        location.href = "/login";
                     });
                  }
               }); // ajax.done
            }); // grecaptcha.execute
         }); // grecaptcha.ready
      } // submitHandler
   }); // validatorRegister


   // "Login" form ////////////////////////////////////////////////////////////////////////////////
   var validatorLogin = $("#form_login").validate({
      rules: {
         email: {
            required: true, email: true, maxlength: EMAIL_MAXLENGTH,

            normalizer: function(value) { // Using the normalizer to trim the value of the element before validating it.
               return $.trim(value); // The value of `this` inside the `normalizer` is the corresponding DOMElement.
            }
         },
         password: { required: true, minlength: PASSWORD_MINLENGTH, maxlength: PASSWORD_MAXLENGTH }
      },
      messages: {
         email: {required: MSG_EMAIL_REQUIRED, email: MSG_EMAIL_VALIDEMAILADDR, maxlength: MSG_EMAIL_MAXLEN},
         password: {required: MSG_PASSWORD_REQUIRED, minlength: MSG_PASSWORD_MINLEN, maxlength: MSG_PASSWORD_MAXLEN}
      },
      errorElement: 'em',
      errorPlacement: function (error, element) {
         error.addClass('invalid-feedback');
         element.closest('.input-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
         $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
         $(element).removeClass('is-invalid');
      },
      submitHandler: function (form) {
         var email = $(form).find("input[name='email']").val().trim();
         var password = $(form).find("input[name='password']").val();
         var remember = $(form).find("input#remember").prop('checked') ? 1 : 0;

         //console.log(email); console.log(password); console.log(remember);

         // Submit the user input to the server (No need for Google reCAPTCHA here)
         $.ajax({
            url: "/reqLogIn",
            data: {
               _token: $('meta[name="csrf-token"]').attr('content'), // Laravel's CSRF Setup
               email: email,
               password: password,
               remember: remember
            }
         })
         .done(function (response) {
            if (!(typeof(response) === "object")) {
               console.log(response);
               Swal.fire({
                  title: "Error!",
                  html: "<p>Sorry!</p><p>An unknown server error occurred!</p><p>Please, try again later.</p>",
                  icon: "error"
               });
               return;
            }

            // It's a JSON
            //console.log(response);

            if (response.retcode == ERR_WITHMSG_EMAIL) {
               validatorLogin.showErrors({email: response.errmsg});
               return;
            }
            if (response.retcode == ERR_WITHMSG_PASSWORD) {
               validatorLogin.showErrors({password: response.errmsg});
               return;
            }
            if (response.retcode == ERR_WITHMSG) { // General & Bad credentials
               Swal.fire({title: "Alert!", html: "<p>" + response.errmsg + "</p>", icon: "warning"});
               return;
            }

            if (response.retcode == ERR_NOERROR) location.href = "/dashboard";
         }); // ajax.done
      } // submitHandler
   }); // validatorLogin


   // "ForgotPW" form /////////////////////////////////////////////////////////////////////////////
   var validatorForgotPW = $("#form_forgotpw").validate({
      rules: {
         email: {
            required: true, email: true, maxlength: EMAIL_MAXLENGTH,

            normalizer: function(value) { // Using the normalizer to trim the value of the element before validating it.
               return $.trim(value); // The value of `this` inside the `normalizer` is the corresponding DOMElement.
            }
         }
      },
      messages: {
         email: {required: MSG_EMAIL_REQUIRED, email: MSG_EMAIL_VALIDEMAILADDR, maxlength: MSG_EMAIL_MAXLEN}
      },
      errorElement: 'em',
      errorPlacement: function (error, element) {
         error.addClass('invalid-feedback');
         element.closest('.input-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
         $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
         $(element).removeClass('is-invalid');
      },
      submitHandler: function (form) {
         var email = $(form).find("input[name='email']").val().trim();

         //console.log(email);

         // Execute reCAPTCHA v3 directly before sending data to the server (2 mins validity)
         grecaptcha.ready(function() {
            grecaptcha.execute(GR_PATHOLOG_SITEKEY, {action: GR_ACTION_RESETPASSWORD}).then(function(token) {
               // Submit the user input to the server
               $.ajax({
                  url: "/reqForgotPW",
                  data: {
                     _token: $('meta[name="csrf-token"]').attr('content'), // Laravel's CSRF Setup
                     email: email,
                     gr_token: token
                  }
               })
               .done(function (response) {
                  if (!(typeof(response) === "object")) {
                     console.log(response);
                     Swal.fire({
                        title: "Error!",
                        html: "<p>Sorry!</p><p>An unknown server error occurred!</p><p>Please, try again later.</p>",
                        icon: "error"
                     });
                     return;
                  }

                  // It's a JSON
                  //console.log(response);

                  if (response.retcode == ERR_WITHMSG_EMAIL) {
                     validatorForgotPW.showErrors({email: response.errmsg});
                     return;
                  }
                  if (response.retcode == ERR_WITHMSG) { // General & reCAPTCHA
                     Swal.fire({title: "Alert!", html: "<p>" + response.errmsg + "</p>", icon: "warning"});
                     return;
                  }
                  if (response.retcode == ERR_UNEXPECTED) {
                     Swal.fire({title: "Alert!", html: "<p>Sorry! Unexpected error ocurred!</p><p>Try again later.</p>", icon: "warning"});
                     return;
                  }

                  if (response.retcode == ERR_NOERROR) {
                     Swal.fire(
                        {title: response.msgTitle, html: response.msgHtml, icon: response.msgIcon}
                     )
                     .then(function() {
                        location.href = "/login";
                     });
                  }
               }); // ajax.done
            }); // grecaptcha.execute
         }); // grecaptcha.ready
      } // submitHandler
   }); // validatorForgotPW


   // "Create new password" form /////////////////////////////////////////////////////////////////////////////
   var validatorNewPW = $("#form_createpw").validate({
         rules: {
            password: { required: true, minlength: PASSWORD_MINLENGTH, maxlength: PASSWORD_MAXLENGTH },
            confirm_password: { required: true, equalTo: "input[name=password]"}
         },
         messages: {
            password: {required: MSG_PASSWORD_REQUIRED, minlength: MSG_PASSWORD_MINLEN, maxlength: MSG_PASSWORD_MAXLEN},
            confirm_password: {required: MSG_PASSWORDCONFIRM_REQUIRED, equalTo: MSG_PASSWORDCONFIRM_EQUAL}
         },
         errorElement: 'em',
         errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.input-group').append(error);
         },
         highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
         },
         unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
         },
         submitHandler: function (form) {
            var password = $(form).find("input[name='password']").val();
            var conf_password = $(form).find("input[name=confirm_password]").val();
   
            //console.log(password); console.log(conf_password);
   
            if (conf_password != password) {
               Swal.fire({title: 'Alert!', text: 'Double check your passwords, they mismatch!', icon: 'warning'});
               return;
            }
/*
            // Submit the user input to the server (No need for Google reCAPTCHA here)
            $.ajax({
               url: "/reqRegister",
                     data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // Laravel's CSRF Setup
                        username: username,
                        email: email,
                        password: password,
                        terms: terms,
                        gr_token: token
                     }
                  })
                  .done(function (response) {
                     if (!(typeof(response) === "object")) {
                        console.log(response);
                        Swal.fire({
                           title: "Error!",
                           html: "<p>Sorry!</p><p>An unknown server error occurred!</p><p>Please, try again later.</p>",
                           icon: "error"
                        });
                        return;
                     }
   
                     // It's a JSON
                     //console.log(response);
   
                     if (response.retcode == ERR_WITHMSG_USERNAME) {
                        validatorRegister.showErrors({username: response.errmsg});
                        return;
                     }
                     if (response.retcode == ERR_WITHMSG_EMAIL) {
                        validatorRegister.showErrors({email: response.errmsg});
                        return;
                     }
                     if (response.retcode == ERR_WITHMSG_PASSWORD) {
                        validatorRegister.showErrors({password: response.errmsg});
                        return;
                     }
                     if (response.retcode == ERR_WITHMSG_TERMS) {
                        validatorRegister.showErrors({terms: response.errmsg});
                        return;
                     }
                     if (response.retcode == ERR_WITHMSG) { // General & reCAPTCHA
                        Swal.fire({title: "Alert!", html: "<p>" + response.errmsg + "</p>", icon: "warning"});
                        return;
                     }
                     if (response.retcode == ERR_UNEXPECTED) {
                        Swal.fire({title: "Alert!", html: "<p>Sorry! Unexpected error ocurred!</p><p>Try again later.</p>", icon: "warning"});
                        return;
                     }
   
                     if (response.retcode == ERR_NOERROR) {
                        Swal.fire(
                           {title: response.msgTitle, html: response.msgHtml, icon: response.msgIcon}
                        )
                        .then(function() {
                           location.href = "/login";
                        });
                     }
                  }); // ajax.done
               }); // grecaptcha.execute
            }); // grecaptcha.ready
*/
         } // submitHandler
      }); // validatorRegister
}); // jQ's document.ready
