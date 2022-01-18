/*
Patho•Log - New Report
*/

'use strict';
var stepperCurrentStepIndex = 0;
var g_oReportData = new Object;

/*
Create the 'OneStep' stepper intended for mobile phones
*/
function initOneStepStepperDots() {
   var stepsCount = $("#stepper-container .step").length, innerHtml = "", iC;

   for (iC = 0; iC < stepsCount; iC++) {
      innerHtml += '<i class="fas fa-circle"></i>';
   }

   $("#onestep-dots").html(innerHtml);
}

/*
Set the stepper's step icon according to the current step
*/
function setStepperCurrentStep() {
   $("#stepper-container .step").each(function(index) {
      if (index < stepperCurrentStepIndex) {
         $(this).removeClass("current").addClass("done");
         $(this).find("i").removeClass("far fa-circle fa-dot-circle").addClass("fas fa-check-circle");
      }
      if (index == stepperCurrentStepIndex) {
         $(this).removeClass("done").addClass("current");
         $(this).find("i").removeClass("far fa-check-circle fa-circle").addClass("fas fa-dot-circle");
      }
      if (index > stepperCurrentStepIndex) {
         $(this).removeClass("done current");
         $(this).find("i").removeClass("fas fa-check-circle fa-dot-circle").addClass("far fa-circle");
      }
   });
   
   var onestepTitle = "Step (" + (stepperCurrentStepIndex + 1) + "/" + $("#onestep-dots i").length + "): ";
   onestepTitle += ($("#stepper-container .step")[stepperCurrentStepIndex]).querySelector("span").innerText;
   $("#onestep-title").text(onestepTitle);

   $("#onestep-dots i").each(function(index) {
      if (index < stepperCurrentStepIndex) $(this).css("color", "var(--palette-turquoise)");
      if (index == stepperCurrentStepIndex) $(this).css("color", "var(--palette-purple)");
      if (index > stepperCurrentStepIndex) $(this).css("color", "var(--gray-disabled)");
   });
}

/*
Go to NEXT step
*/
function gotoNextStep() {
   stepperCurrentStepIndex++;
   setStepperCurrentStep();
}
function gotoStepPatient() {
   $("div#step-template").addClass("d-none");
   $("div#step-patient").removeClass("d-none");
   gotoNextStep();

   // Get the needed steps fro the template from the server
   $.ajax({
      url: "/reqTplStepFields",
      data: {
         _token: $('meta[name="csrf-token"]').attr('content'), // Laravel's CSRF Setup
         tpl_id: g_oReportData.templateId,
         stp_name: "patient"
      }
   })
   .done(function (response) {
      if ((!(typeof(response) === "object")) || (response.retcode != ERR_NOERROR)) {
         console.log(response);
         Swal.fire({
            title: "Error!",
            html: "<p>Sorry!</p><p>An unknown server error occurred!</p><p>Please, try again later.</p>",
            icon: "error"
         });
         return;
      }

      //console.log(response);

      // Update the step html
      $("div#patient-container").html(response.stepHtml);
   });
}



(function ($) { // When the document is ready...
   initOneStepStepperDots();
   setStepperCurrentStep();

   $(".tplitem-container").click(function() {
      g_oReportData.templateId = this.id;
      gotoStepPatient();
   });
})(jQuery);


/*
When you get the Age field value, it should be Abs (meaning, > 0)
*/