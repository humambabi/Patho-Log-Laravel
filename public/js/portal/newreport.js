/*
Patho•Log - New Report
*/

'use strict';
var stepperCurrentStepIndex = 0;

function initOneStepStepperDots() {
   var stepsCount = $("#stepper-container .step").length, innerHtml = "", iC;

   for (iC = 0; iC < stepsCount; iC++) {
      innerHtml += '<i class="fas fa-circle"></i>';
   }

   $("#onestep-dots").html(innerHtml);
}

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


(function ($) { // When the document is ready...
   initOneStepStepperDots();
   setStepperCurrentStep();
})(jQuery);
