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

                     <div class="card-body">
                        <div class="container-fluid">
                           <h5><strong>Select a template for your new report:</strong></h5>
                           <h6 class="mb-4">The selected template theme, logo, and fields will be applied to the report.</h6>

                           <!-- Template item container -->
                           <div id="templates-container">

                              <div class="tplitem-container">
                                 <div class="tplitem-backribbon"></div>
                                 <div class="tplitem-previmg">
                                    <img alt="General Report" src="/img/portal/templates/general/preview-thumbnail.jpg" width="auto" height="100%" />
                                 </div>
                                 <div class="tplitem-ctl">
                                    <div class="tplitem-ctl-desc">
                                       <div class="tplitem-ctl-desc-title">General Report</div>
                                       <div class="tplitem-ctl-desc-text">
                                          A general biopsy report, with all the standard sections.
                                       </div>
                                    </div>
                                    <div class="tplitem-ctl-btn">
                                       <button type="button" class="btn btn-turquoise btn-block">Select</button>
                                    </div>
                                 </div>
                              </div>

                              <div class="tplitem-container">
                                 <div class="tplitem-backribbon"></div>
                                 <div class="tplitem-previmg">
                                    <img alt="General Report" src="/img/portal/templates/papsmear/preview-thumbnail.jpg" width="auto" height="100%" />
                                 </div>
                                 <div class="tplitem-ctl">
                                    <div class="tplitem-ctl-desc">
                                       <div class="tplitem-ctl-desc-title">Pap Smear</div>
                                       <div class="tplitem-ctl-desc-text">
                                          A Cytology report, with cell categories and final diagnosis.
                                       </div>
                                    </div>
                                    <div class="tplitem-ctl-btn">
                                       <button type="button" class="btn btn-turquoise btn-block">Select</button>
                                    </div>
                                 </div>
                              </div>

                           </div>
                           <!-- / Template item container -->

                        </div>
                        
                     </div><!-- /.card-body -->

                     <div class="card-footer">
                        Want to customize the templates? <a href="{{ url('/') }}/templates">Click Here</a>
                     </div><!-- /.card-footer-->
                  </div><!-- /.card -->

               </div><!-- /.col-md-6 -->
            </div><!-- /.row -->
         </div><!-- /.container-fluid -->
      </section><!-- /.content -->
   </div><!-- /.content-wrapper -->