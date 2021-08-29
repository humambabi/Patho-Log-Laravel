/*
Patho•Log - extra-portal script
*/

// Laravel's CSRF Setup
$.ajaxSetup({
   headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
               type: 'post',
               data: {
                  email: email,
                  password: password,
                  remember: remember
               },
               datatype: 'json',
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
      } // submitHandler
   }); // validator.setDefaults

   $('#form_login').validate({
      rules: {
         email: {
            required: true,
            email: true,
            maxlength: EMAIL_MAXLENGTH,

            // Using the normalizer to trim the value of the element before validating it.
            // The value of `this` inside the `normalizer` is the corresponding DOMElement. Here it's the `email` element.
            normalizer: function(value) {
               return $.trim(value);
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
            email: "Please enter a vaild email address"
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
