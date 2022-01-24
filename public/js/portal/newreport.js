/*
Patho•Log - New Report
*/

'use strict';
const TIMEOUT_REPPREV_REFRESH = 2500;

var g_stepperCurrentStepIndex = 0;
var g_oReportData = new Object;
var g_RepPrev_TimerId = null;



/*
Create the 'OneStep' stepper intended for mobile phones *******************************************
*/
function initOneStepStepperDots() {
   var stepsCount = $("#stepper-container .step").length, innerHtml = "", iC;

   for (iC = 0; iC < stepsCount; iC++) {
      innerHtml += '<i class="fas fa-circle"></i>';
   }

   $("#onestep-dots").html(innerHtml);
}

/*
Set the stepper's step icon according to the current step *****************************************
*/
function setStepperCurrentStep() {
   $("#stepper-container .step").each(function(index) {
      if (index < g_stepperCurrentStepIndex) {
         $(this).removeClass("current").addClass("done");
         $(this).find("i").removeClass("far fa-circle fa-dot-circle").addClass("fas fa-check-circle");
      }
      if (index == g_stepperCurrentStepIndex) {
         $(this).removeClass("done").addClass("current");
         $(this).find("i").removeClass("far fa-check-circle fa-circle").addClass("fas fa-dot-circle");
      }
      if (index > g_stepperCurrentStepIndex) {
         $(this).removeClass("done current");
         $(this).find("i").removeClass("fas fa-check-circle fa-dot-circle").addClass("far fa-circle");
      }
   });
   
   var onestepTitle = "Step (" + (g_stepperCurrentStepIndex + 1) + "/" + $("#onestep-dots i").length + "): ";
   onestepTitle += ($("#stepper-container .step")[g_stepperCurrentStepIndex]).querySelector("span").innerText;
   $("#onestep-title").text(onestepTitle);

   $("#onestep-dots i").each(function(index) {
      if (index < g_stepperCurrentStepIndex) $(this).css("color", "var(--palette-turquoise)");
      if (index == g_stepperCurrentStepIndex) $(this).css("color", "var(--palette-purple)");
      if (index > g_stepperCurrentStepIndex) $(this).css("color", "var(--gray-disabled)");
   });
}


/*
Reset userData (only for empty fields) ************************************************************
*/
function userData_Reset() {
   if (g_oReportData.hasOwnProperty("fields") == false) g_oReportData.fields = {}; // Later we need to add members to it.

   if (g_oReportData.fields.hasOwnProperty("CONST_PATIENTNAME") == false) g_oReportData.fields.CONST_PATIENTNAME = "---";

}


/*
Get the report's preview (according to user data) *************************************************
*/
function getReportPreview() {
   $.ajax({
      url: "/reqTplGetPreview",
      data: {
         _token: $('meta[name="csrf-token"]').attr('content'), // Laravel's CSRF Setup
         userData: g_oReportData
      },
      cache: false // Mostly will not work!
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

      // Update the report preview
      $("div#rep_pvw").html(response.pvwImg);
   });
}


/*
Reset report preview timer ************************************************************************
*/
function repPrevTimer_Reset() {
   if (g_RepPrev_TimerId) clearTimeout(g_RepPrev_TimerId);

   g_RepPrev_TimerId = setTimeout(function() {
      g_RepPrev_TimerId = null;

      // create a semi-transparent overlay over the report, with a loader inside
      // send an ajax request to get a new preview
      getReportPreview();
      // don't forget: inside the ajax .done handler, remove the overlay with the loader (replace them)

   }, TIMEOUT_REPPREV_REFRESH);
}


/*
Set the event handler for a field *****************************************************************
*/
function setFieldEvent(fieldId, tplField) {
   $("#" + fieldId).keyup(function() {
///////verify field data
      g_oReportData.fields[tplField] = this.value;
      repPrevTimer_Reset();
   });
}


/*
Go to NEXT step(s) ********************************************************************************
*/
function gotoNextStep() {
   g_stepperCurrentStepIndex++;
   setStepperCurrentStep();
}
function gotoStepPatient() {
   $("div#step-template").addClass("d-none");
   $("div#step-patient").removeClass("d-none");
   gotoNextStep();

   // Get the needed steps for the template from the server
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

//      console.log(response);

      // Update the step html
      $("div#patient-container").html(response.stepHtml);

      // Update event mapping
      for (var iC = 0; iC < response.actFields.length; iC++) {
         var oneField = response.actFields[iC];
         switch (oneField.type) {
            case 'TEXTBOX':
               setFieldEvent(oneField.id, oneField.tplField);
               break;
         }

//         console.log(response.actFields[iC]);
      }

      // After showing the step fields, adjust the global userData and set step fields' UI contents
      if (g_oReportData.fields.hasOwnProperty("CONST_PATIENTNAME")) /* and not "---" */{
         
         // set text.text = field
      }

      // After showing the step fields, and updating the userData, send a new ajax to get the report preview.
      getReportPreview();
   });
}



(function ($) { // When the document is ready...
   initOneStepStepperDots();
   setStepperCurrentStep();

   $(".tplitem-container").click(function() {
      g_oReportData.templateId = this.id;
      userData_Reset();
      gotoStepPatient();
   });
})(jQuery);


/*
When you get the Age field value, it should be Abs (meaning, > 0)
On mobile, no need for the ajax: reportpreview
Don't let the user refresh the page without a warning!
report previews -> queue
*/
