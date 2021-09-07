/*
Patho•Log - extra-portal script
*/

"use strict";

// Set jQ's ajax general settings
$.ajaxSetup({
   headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Laravel's CSRF Setup
   },
   type: 'POST',
   datatype: 'JSON',
   timeout: 5000,
   error: function(jqXHR, textStatus, errorThrown) {
      var msgHtml = "<p>Sorry!</p><p>An unknown error occurred!</p>";
      if (jqXHR.status == 0) { // Cannot reach server
         msgHtml = "<p>Cannot communicate with the server right now!</p><p>Please, try again later.</p>";
      }

      var errHtml = "<p><small>Error: " + jqXHR.status;
      if (errorThrown && errorThrown.length) errHtml += " (" + errorThrown + ")";
      errHtml += "</small></p>";

      Swal.fire({title: "Alert!", html: msgHtml + errHtml, icon: "warning"});
   }
});

// When the document is ready...
$(function() {
   var validator = $("#form_register").validate({
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
            grecaptcha.execute('6Ld_EDgcAAAAANjtDs7tfuIeAPiRqJR3WmjvEZEF', {action: GR_ACTION_ACCOUNTREGISTER}).then(function(token) {
               // Submit the user input to the server
               $.ajax({
                  url: "/reqRegister",
                  data: {
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
                  console.log(response);

                  if (response.retcode == ERR_WITHMSG_USERNAME) {
                     validator.showErrors({username: response.errmsg});
                     return;
                  }
                  if (response.retcode == ERR_WITHMSG_EMAIL) {
                     validator.showErrors({email: response.errmsg});
                     return;
                  }
                  if (response.retcode == ERR_WITHMSG_PASSWORD) {
                     validator.showErrors({password: response.errmsg});
                     return;
                  }
                  if (response.retcode == ERR_WITHMSG_TERMS) {
                     validator.showErrors({terms: response.errmsg});
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
                     Swal.fire({title: "Tamam!", html: "<p>" + response.msg + "</p>", icon: "success"});
                  }
               });
            });
         });
      }
   });
});









/*

$(function () {
   "use strict"; // Start of use strict

   $.validator.setDefaults({
      submitHandler: function (form) {
         if ($(form).prop('id') == "form_login") {
            var email = $(form).find("input[name='email']").val().trim();
            var password = $(form).find("input[name='password']").val();
            var remember = $(form).find("input#remember").prop('checked') ? true : false;

            //console.log(email); console.log(password); console.log(remember);

            // Send the user input to the server
            $.ajax({
               url: "/reqLogIn",
               data: {
                  email: email,
                  password: password,
                  remember: remember
               },
               success: function(response) {
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
				      console.log(response);

                  if (response.retcode == ERR_WITHMSG) {
                     $("#validation_alert").html(response.errmsg);
                     $("#validation_alert").removeClass("d-none").addClass("d-block");
      // on any keydown remove this alert
                     return;
                  }

                  if (response.retcode == 0) { // Error
                     //$('#user-email').removeClass("is-valid");
                     //$('#user-email').addClass("is-invalid");
                     //$("#user-email").on("input", function() { $("#user-email").removeClass("is-invalid"); });
                     //swal("Error!", response.retdata, "error");
                     return;
                  }

                  // Success, or already saved
                  //$('#user-email').removeClass("is-invalid");
                  //$('#user-email').addClass("is-valid");
                  //$('#user-email').attr("disabled", true);
                  //$('#submit-button').text("Saved!");
                  //$('#submit-button').attr("disabled", true);
                  //swal("Thank you!", response.retdata, "success");
               } // Received response
            }); // JQ.Ajax()
         } // form#form-login
      } // submitHandler
   }); // validator.setDefaults

   // Login form
   $('#form_login').validate({
      onfocusout: true,
      rules: {
         email: {
            required: true,
            email: true,
            maxlength: EMAIL_MAXLENGTH,

            // Using the normalizer to trim the value of the element before validating it.
            normalizer: function(value) {
               return $.trim(value); // The value of `this` inside the `normalizer` is the corresponding DOMElement. Here it's the `email` element.
            }
         },
         password: {
            required: true,
            minlength: PASSWORD_MINLENGTH,
            maxlength: PASSWORD_MAXLENGTH
         }
      },
      messages: {
         email: {
            required: "Please enter an email address",
            email: "Please enter a vaild email address",
            maxlength: "Email cannot be longer than " + EMAIL_MAXLENGTH + " characters"
         },
         password: {
            required: "Please provide a password",
            minlength: "Your password must be at least " + PASSWORD_MINLENGTH + " characters long",
            maxlength: "Password cannot be longer than " + PASSWORD_MAXLENGTH + " characters"
         }
      },
      errorElement: "span",
      errorPlacement: function (error, element) {
         error.addClass('invalid-feedback');
         element.closest('.input-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
         $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
         $(element).removeClass('is-invalid');
      }
   });
});
*/