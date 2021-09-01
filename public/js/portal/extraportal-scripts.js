/*
Patho•Log - extra-portal script
*/

$.ajaxSetup({
   headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Laravel's CSRF Setup
   },
   type: 'post',
   datatype: 'json',
   timeout: 5000,
   error: function(jqXHR, textStatus, errorThrown) {
      var msgHtml = "<p>Cannot communicate with the server right now!</p><p>Please, try again later.</p>";
      if (jqXHR.status == 422) { // Laravel's "Unprocessable Entity" (validation error)
         msgHtml = "<p>Invalid data received!</p>";
      }
      
      var errHtml = "<p><small>Error: " + jqXHR.status;
      if (errorThrown && errorThrown.length) errHtml += " (" + errorThrown + ")</small></p>";

      Swal.fire({title: "Alert!", html: msgHtml + errHtml, icon: "warning"});
   }
});


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
                  //$('#user-email').removeClass("is-invalid");
                  //$('#user-email').removeClass("is-valid");
                  //swal("Error!", response, "error");
                  return;
                  }

                  // It's a JSON
				      console.log(response);

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

         if ($(form).prop('id') == "form_register") {
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
                        //console.log(response);
                        Swal.fire({title: "Alert!", html: "<p>" + response + "</p><p>Please, try again later.</p>", icon: "error"});
                        return;
                     }

                     // It's a JSON
                     console.log(response);

                     if (response.retcode == 0) { // Error
                        //$('#user-email').removeClass("is-valid");
                        //$('#user-email').addClass("is-invalid");
                        //$("#user-email").on("input", function() { $("#user-email").removeClass("is-invalid"); });
                        //swal("Error!", response.retdata, "error");
                        return;
                     }
                  });
               }); // gr.execute()
            }); // gr.ready()
         } // form#form_register
      } // submitHandler
   }); // validator.setDefaults

   // Login form
   $('#form_login').validate({
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


   // Register form
   $('#form_register').validate({
      rules: {
         username: {
            required: true,
            minlength: USERNAME_MINLENGTH,
            maxlength: USERNAME_MAXLENGTH,

            // Using the normalizer to trim the value of the element before validating it.
            normalizer: function(value) {
               return $.trim(value); // The value of `this` inside the `normalizer` is the corresponding DOMElement.
            }
         },
         email: {
            required: true,
            email: true,
            maxlength: EMAIL_MAXLENGTH,

            // Using the normalizer to trim the value of the element before validating it.
            normalizer: function(value) {
               return $.trim(value); // The value of `this` inside the `normalizer` is the corresponding DOMElement.
            }
         },
         password: {
            required: true,
            minlength: PASSWORD_MINLENGTH,
            maxlength: PASSWORD_MAXLENGTH
         },
         confirm_password: {
            required: true,
            equalTo: "input[name=password]"
         },
         terms: {
            required: true
         }
      },
      messages: {
         username: {
            required: "Please enter an user name",
            minlength: "User name must be at least " + USERNAME_MINLENGTH + " characters long",
            maxlength: "User name cannot be longer than " + USERNAME_MAXLENGTH + " characters"
         },
         email: {
            required: "Please enter an email address",
            email: "Please enter a vaild email address",
            maxlength: "Email cannot be longer than " + EMAIL_MAXLENGTH + " characters"
         },
         password: {
            required: "Please provide a password",
            minlength: "Your password must be at least " + PASSWORD_MINLENGTH + " characters long",
            maxlength: "Password cannot be longer than " + PASSWORD_MAXLENGTH + " characters"
         },
         confirm_password: {
            required: "Please re-type your password",
            equalTo: "Passwords mismatch!"
         },
         terms: "Please agree to the terms to continue"
      },
      errorElement: 'span',
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
