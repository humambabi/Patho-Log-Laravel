/*
Patho•Log - Social login scripts

Should be loaded only:
1. After loading accounts.google.com/gsi/client script.
2. If the user is NOT authenticated yet.
*/

'use strict';

function GoogleHandleCredentialResponse(encGoogleResp) {
   //console.log(encGoogleResp);
   $.ajax({
      url: "/reqSocialRegLogIn",
      data: {socialType: "google", socialResponse: encGoogleResp}
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

      if (response.retcode == ERR_WITHMSG) { // General & reCAPTCHA
         Swal.fire({title: "Alert!", html: "<p>" + response.errmsg + "</p>", icon: "warning"});
         return;
      }

      if (response.retcode == ERR_NOERROR) {
         if (PAGE_TYPE == "extraportal") location.href = "/dashboard"; else location.reload();
      }
   });
}


window.onload = function () {
   google.accounts.id.initialize({
      client_id: SOCIALLOGIN_GOOGLE_CLIENT_ID,
      callback: GoogleHandleCredentialResponse
   });

   var elmGoogleBtn = document.getElementById("loginGoogle");
   if (elmGoogleBtn) {
      // Won't always work, but good to be set!
      var btnText = "continue_with";
      if (PAGE_NAME == "login") btnText = "signin_with";
      if (PAGE_NAME == "register") btnText = "signup_with";
      
      google.accounts.id.renderButton(
         elmGoogleBtn,
         {theme: "outline", size: "large", text: btnText }
      );
   }
   google.accounts.id.prompt(); // Also display the One Tap dialog
};
