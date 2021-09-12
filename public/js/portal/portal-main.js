/*
Patho•Log - Main
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
(function ($) {
  // User menu: Sign Out
  $('#btnSignOut').click(function() {
    $.ajax({url: "/reqSignOut"}).done(function () { location.reload(true); /* Reload from server */ });
  });
})(jQuery);
