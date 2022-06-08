   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
         <div class="container-fluid">
            <div class="row mb-2 mt-3">
               <div class="col-sm-12">
                  <h1 class="m-0 text-center">Create a new report</h1>
               </div><!-- /.col -->
            </div><!-- /.row -->
         </div><!-- /.container-fluid -->
      </section><!-- /.content-header -->



      <style type="text/css">
         .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
         }
         .alert a {
             color: unset;
         }
      </style>
      <section class="content">
         <div class="container-fluid">
            <div class="alert alert-danger" role="alert">
               <strong>Dear users and visitors:</strong><br/><br/>
               The site is currently under testing and construction. If you find it useful, have an idea to improve it,
               or simply just want to say hi, you are always welcome to drop an email at:
               <a href="mailto:support@patho-log.com">support@patho-log.com</a><br/>
               Your donations are most appreciated, and will be dedicated to speeding up development.<br/><br/>
               Thank you very much ❤️
            </div>
         </div>
      </section>
        
        
        
      <!-- Main content -->
      <section class="content">
         <div class="container-fluid">
            <div class="row">
               <div class="col-lg-12">
                  <div class="card">

                     <!-- Stepper (full-width and compact) -->
                     <div class="card-header d-flex flex-row justify-content-center">
                        <div id="stepper-container" class="d-none d-md-flex">
                           <div class="step">
                              <i class="far fa-circle"></i><span>Template</span>
                           </div>
                           <i class="fas fa-angle-right nextsteparrow"></i>
                           <div class="step">
                              <i class="far fa-circle"></i><span>Patient</span>
                           </div>
                           <i class="fas fa-angle-right nextsteparrow"></i>
                           <div class="step">
                              <i class="far fa-circle"></i><span>Specimen</span>
                           </div>
                           <i class="fas fa-angle-right nextsteparrow"></i>
                           <div class="step">
                              <i class="far fa-circle"></i><span>Microscope</span>
                           </div>
                           <i class="fas fa-angle-right nextsteparrow"></i>
                           <div class="step">
                              <i class="far fa-circle"></i><span>Diagnosis</span>
                           </div>
                           <i class="fas fa-angle-right nextsteparrow"></i>
                           <div class="step">
                              <i class="far fa-circle"></i><span>Additional</span>
                           </div>
                           <i class="fas fa-angle-right nextsteparrow"></i>
                           <div class="step">
                              <i class="far fa-circle"></i><span>Finish</span>
                           </div>
                        </div><!-- /#stepper-container -->
                        <div id="stepper-onestep" class="d-flex d-md-none flex-column">
                           <div id="onestep-title">Loading</div>
                           <div id="onestep-dots"></div>
                        </div><!-- /#stepper-onestep -->
                     </div><!-- /.card-header -->
                     <!-- /Stepper -->

                     <!--
                        STEP: template (1) -------------------------------
                     -->
                     <div id="step-template">
                        <div class="card-body" style="min-height: 53vh;">
                           <div class="px-0">
                              <h4><strong>Select a template for your new report:</strong></h4>
                              <h6 class="mb-4">The selected template theme, logo, and fields will be applied to the report.</h6>
                              <div id="templates-container">{!! $templates_html !!}</div>
                           </div>
                        </div>
                        <div class="card-footer">
                           <a href="{{ url('/') }}/templates">Customize the templates</a>
                        </div>
                     </div>

                     <!--
                        STEP: patient (2) --------------------------------
                     -->
                     <div id="step-patient" class="d-none">
                        <div class="card-body d-flex flex-row" style="min-height: 53vh;">
                           <div class="col-12 col-md-8 col-xl-6 px-0 pr-md-4">
                              <h4><strong>Enter the patient's information:</strong></h4>
                              <div id="patient-container">
                                 <div id="step-loader-container"><img alt="Loading" src="/img/portal/templates/tpl_loader.gif" width="auto" height="126"/></div>
                              </div>
                           </div>
                           <div class="d-none d-md-flex col-md-4 col-xl-6 px-0" id="rep_pvw_container">
                              <div id="rep_pvw_title">Report Preview</div>
                              <div id="rep_pvw">
                                 <img id="rep_pvw_loader" alt="Loading preview" src="/img/portal/templates/tpl_loader.gif" width="auto" height="126"/>
                              </div>
                              <div class="mt-2"><button type="button" class="btn btn-sm btn-default"><i class="fas fa-search"></i>&nbsp;Big Preview</button></div>
                           </div>
                        </div><!-- /.card-body -->
                        <div class="card-footer d-flex flex-row justify-content-between justify-content-md-end">
                           <button type="button" class="btn btn-sm btn-default d-md-none"><i class="far fa-eye"></i></button>
                           <div class="d-flex flex-row justify-content-end" style="width:81%;">
                              <button type="button" class="btn btn-default wizbtn"><i class="fas fa-undo"></i>&nbsp;&nbsp;&nbsp;Back</button>
                              <div style="height:100%;width:5%;max-width:1rem;"></div>
                              <button type="button" class="btn btn-turquoise wizbtn">Next&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-right"></i></button>
                           <div>
                        </div><!-- /.card-footer-->
                     </div>



                  </div><!-- /.card -->

               </div><!-- /.col-md-6 -->
            </div><!-- /.row -->
         </div><!-- /.container-fluid -->
      </section><!-- /.content -->
   </div><!-- /.content-wrapper -->