/*
Patho•Log - New Report
*/

'use strict';
var stepperCurrentStepIndex = 0;

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
}


(function ($) { // When the document is ready...
   setStepperCurrentStep();
})(jQuery);
