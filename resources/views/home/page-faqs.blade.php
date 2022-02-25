   <!-- Header -->
   <header id="header" class="ex-header">
      <div id="headbkgnd" style="top:-99%;"></div>
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <h1>Frequently Asked Questions</h1>
            </div> <!-- end of col -->
         </div> <!-- end of row -->
      </div> <!-- end of container -->
   </header> <!-- end of ex-header -->
   <!-- end of header -->

   <!-- Breadcrumbs -->
   <div class="ex-basic-1">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="breadcrumbs">
                  <a href="{{ url('/') }}">Home</a><i class="fa fa-angle-double-right"></i><span>Frequently Asked Questions</span>
               </div> <!-- end of breadcrumbs -->
            </div> <!-- end of col -->
         </div> <!-- end of row -->
      </div> <!-- end of container -->
   </div> <!-- end of ex-basic-1 -->
   <!-- end of breadcrumbs -->

   <style type="text/css">
      h2 { font-size: 20px; text-align: center; }
      .accordion .btn { padding-right: 1.75rem; }
      .accordion .btn:after { position: absolute; content: "\2039"; font-weight: 400; font-size: 1.7rem; top: 1.45rem; right: 1.75rem; transform: rotate(90deg); width: 1rem; height: 1rem; line-height: 1.2rem; display: flex; align-items: flex-end; justify-content: center; transition: 400ms all; }
      .accordion .btn.collapsed:after { transform: rotate(270deg); }
      button.turquoise { font-weight: bold; }
   </style>

   <!-- FAQs Content -->
   <div class="ex-basic-2">
      <div class="container">
         <div class="row">
            <div class="col-lg-10 offset-lg-1">
               <div class="text-container">
                  <p>
                     Here are some of the most frequent questions that we receive with their answers. <strong>If you have any
                     question that is not answered here, feel free to contact us via our
                     <a class="turquoise" href="mailto:{{ config('mail.from.address') }}">email address</a>, or using the
                     <a class="turquoise" href="{{ url('/') }}/contact">Contact us</a> form.</strong>
                  </p>

                  <br/>
                  
                  <div id="accordionFAQs">
                     <!-- General -->
                     <h2>General</h2>
                     <div class="accordion">
                        <div class="card">
                           <div class="card-header" id="heading000">
                              <h2 class="mb-0">
                                 <button class="btn btn-link btn-block text-left turquoise collapsed" type="button" data-toggle="collapse" data-target="#collapse000" aria-expanded="true" aria-controls="collapse000">
                                    Is {{ config("app.name") }} free? Can I use its services without paying anything?
                                 </button>
                              </h2>
                           </div>
                           <div id="collapse000" class="collapse" aria-labelledby="heading000" data-parent="#accordionFAQs">
                              <div class="card-body">
                                 Yes! {{ config("app.name") }} is a free website and you can use it without paying anything at all.
                                 However, some features require that you sign up for a <u>free</u> account so that we can save your
                                 reports, any report data you enter, and protect your privacy.
                              </div>
                           </div>
                        </div>

                        <div class="card">
                           <div class="card-header" id="heading001">
                              <h2 class="mb-0">
                                 <button class="btn btn-link btn-block text-left turquoise collapsed" type="button" data-toggle="collapse" data-target="#collapse001" aria-expanded="false" aria-controls="collapse001">
                                    Do I need to install any software to be able to create or save my pathology reports?
                                 </button>
                              </h2>
                           </div>
                           <div id="collapse001" class="collapse" aria-labelledby="heading001" data-parent="#accordionFAQs">
                              <div class="card-body">
                                 Absolutely not! You can use all of our services online. All you need is a web browser and a PDF viewer
                                 (most computers do have these already installed).<br/>
                                 We plan to provide a desktop application in the future, but this will be totally optional.
                              </div>
                           </div>
                        </div>

                        <div class="card">
                           <div class="card-header" id="heading002">
                              <h2 class="mb-0">
                                 <button class="btn btn-link btn-block text-left turquoise collapsed" type="button" data-toggle="collapse" data-target="#collapse002" aria-expanded="false" aria-controls="collapse002">
                                    Can I advertise on your site?
                                 </button>
                              </h2>
                           </div>
                           <div id="collapse002" class="collapse" aria-labelledby="heading002" data-parent="#accordionFAQs">
                              <div class="card-body">
                                 Yes you can. If you are interested please <a class="turquoise" href="mailto:{{ config('mail.from.address') }}">
                                 contact us</a>.
                              </div>
                           </div>
                        </div>

                        <div class="card">
                           <div class="card-header" id="heading003">
                              <h2 class="mb-0">
                                 <button class="btn btn-link btn-block text-left turquoise collapsed" type="button" data-toggle="collapse" data-target="#collapse003" aria-expanded="false" aria-controls="collapse003">
                                    What about privacy?
                                 </button>
                              </h2>
                           </div>
                           <div id="collapse003" class="collapse" aria-labelledby="heading003" data-parent="#accordionFAQs">
                              <div class="card-body">
                                 Privacy is important to us. No one can read your reports unless you share a special link with them,
                                 and optionally password-locked. Also, you can stop sharing your reports anytime.
                              </div>
                           </div>
                        </div>
                     </div>
                     <br/><br/>


                     <!-- Pathology Reports -->
                     <h2>Pathology Reports</h2>
                     <div class="accordion">
                        <div class="card">
                           <div class="card-header" id="heading010">
                              <h2 class="mb-0">
                                 <button class="btn btn-link btn-block text-left turquoise collapsed" type="button" data-toggle="collapse" data-target="#collapse010" aria-expanded="false" aria-controls="collapse010">
                                    Can I create a report without even signing in?
                                 </button>
                              </h2>
                           </div>
                           <div id="collapse010" class="collapse" aria-labelledby="heading010" data-parent="#accordionFAQs">
                              <div class="card-body">
                                 You can of course, however, you cannot customize your report, nor save it afterwards. You have to have
                                 an account (free) in order to benefit from all {{ config("app.name") }} features.
                              </div>
                           </div>
                        </div>

                        <div class="card">
                           <div class="card-header" id="heading011">
                              <h2 class="mb-0">
                                 <button class="btn btn-link btn-block text-left turquoise collapsed" type="button" data-toggle="collapse" data-target="#collapse011" aria-expanded="false" aria-controls="collapse011">
                                    How many reports can I create as a free user? and how many times can I download my reports?
                                 </button>
                              </h2>
                           </div>
                           <div id="collapse011" class="collapse" aria-labelledby="heading011" data-parent="#accordionFAQs">
                              <div class="card-body">
                                 As many as you want! Yes, {{ config("app.name") }} is a free service!
                              </div>
                           </div>
                        </div>

                        <div class="card">
                           <div class="card-header" id="heading012">
                              <h2 class="mb-0">
                                 <button class="btn btn-link btn-block text-left turquoise collapsed" type="button" data-toggle="collapse" data-target="#collapse012" aria-expanded="false" aria-controls="collapse012">
                                    Can I save copies of my reports locally on my computer?
                                 </button>
                              </h2>
                           </div>
                           <div id="collapse012" class="collapse" aria-labelledby="heading012" data-parent="#accordionFAQs">
                              <div class="card-body">
                                 Yes, you can always save your reports as PDF files on your computer for your reference.
                              </div>
                           </div>
                        </div>

                        <div class="card">
                           <div class="card-header" id="heading013">
                              <h2 class="mb-0">
                                 <button class="btn btn-link btn-block text-left turquoise collapsed" type="button" data-toggle="collapse" data-target="#collapse013" aria-expanded="false" aria-controls="collapse013">
                                    How can I change the information in a saved report?
                                 </button>
                              </h2>
                           </div>
                           <div id="collapse013" class="collapse" aria-labelledby="heading013" data-parent="#accordionFAQs">
                              <div class="card-body">
                                 First, you have to login (if not already), then from the <a class="turquoise" href="{{ url('/') }}/savedreports">
                                 Saved Reports</a> page, search and find your report, then press the &quot;Edit&quot; button to edit your report.
                              </div>
                           </div>
                        </div>

                        <div class="card">
                           <div class="card-header" id="heading014">
                              <h2 class="mb-0">
                                 <button class="btn btn-link btn-block text-left turquoise collapsed" type="button" data-toggle="collapse" data-target="#collapse014" aria-expanded="false" aria-controls="collapse014">
                                    Can I create my own report template?
                                 </button>
                              </h2>
                           </div>
                           <div id="collapse014" class="collapse" aria-labelledby="heading014" data-parent="#accordionFAQs">
                              <div class="card-body">
                                 Of course! If you have an already made report (like a PDF or Word file, or even an image file), send
                                 it to our <a class="turquoise" href="mailto:{{ config('mail.from.address') }}">support email</a>, and we will
                                 create a new pathology template for you and make it possible to create new report using this template.
                              </div>
                           </div>
                        </div>

                        <div class="card">
                           <div class="card-header" id="heading015">
                              <h2 class="mb-0">
                                 <button class="btn btn-link btn-block text-left turquoise collapsed" type="button" data-toggle="collapse" data-target="#collapse015" aria-expanded="false" aria-controls="collapse015">
                                    Does PathoLog supports local languages?
                                 </button>
                              </h2>
                           </div>
                           <div id="collapse015" class="collapse" aria-labelledby="heading015" data-parent="#accordionFAQs">
                              <div class="card-body">
                                 Yes of course! You can use your local language when entering text in report fields. Any language
                                 that your computer supports is also supported to enter report information with.
                              </div>
                           </div>
                        </div>

                        <div class="card">
                           <div class="card-header" id="heading016">
                              <h2 class="mb-0">
                                 <button class="btn btn-link btn-block text-left turquoise collapsed" type="button" data-toggle="collapse" data-target="#collapse016" aria-expanded="false" aria-controls="collapse016">
                                    How fast is it to create a pathology report?
                                 </button>
                              </h2>
                           </div>
                           <div id="collapse016" class="collapse" aria-labelledby="heading016" data-parent="#accordionFAQs">
                              <div class="card-body">
                                 It depends on how fast you enter report information, but generally it takes between 1 to 3 minutes,
                                 and then your report is immediately ready.
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>

               </div> <!-- end of text-container -->
            </div>
         </div> <!-- end of row -->
      </div> <!-- end of container -->
   </div> <!-- end of ex-basic -->
   <!-- end of FAQs -->
