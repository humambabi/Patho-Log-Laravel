<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	
	<!-- SEO Meta Tags -->
	<meta name="description" content="Free service to create stylish pathology reports, archive them, and share them with your patients and other doctors." />
	<meta name="author" content="Patho•Log Team" />

	<!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
	<meta property="og:site_name" content="Patho•Log" /> <!-- website name -->
	<meta property="og:site" content="https://www.patho-log.com" /> <!-- website link -->
	<meta property="og:title" content="Patho•Log Home Page" /> <!-- title shown in the actual shared post -->
	<meta property="og:description" content="Free service to create stylish pathology reports, archive them, and share them with your patients and other doctors." /> <!-- description shown in the actual shared post -->
	<meta property="og:image" content="img/home/social-share.jpg" /> <!-- image link, make sure it's jpg -->
	<meta property="og:url" content="https://www.patho-log.com" /> <!-- where do you want your post to link to -->
	<meta property="og:type" content="website" />

	<!-- Website Title -->
	<title>Patho•Log - Create, archive, and share stylish pathology reports for free!</title>
	
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" /> <!-- IE -->
	<link rel="icon" type="image/x-icon" href="/favicon.ico" />	<!-- All others -->
	<link rel="apple-touch-icon" sizes="180x180" href="/img/logo/apple-touch-icon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="/img/logo/favicon-32x32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="/img/logo/favicon-16x16.png" />
	<link rel="manifest" href="/site.webmanifest" />

	<!-- Styles -->
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,600,700,700i&amp;subset=latin-ext&amp;display=swap" rel="stylesheet" />
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
	<link href="/vendor/fontawesome-free-5.0.13/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet" />
	<link href="/vendor/swiper-4.4.6/dist/css/swiper.min.css" rel="stylesheet" />
	<link href="/vendor/magnific-popup-1.1.0/dist/magnific-popup.css" rel="stylesheet" />
	<link href="/css/styles.css" rel="stylesheet" />

	<!-- CSRF protection -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- gtag/g.analytics - same as the comingsoon page -->
	<!-- -->
</head>
<body data-spy="scroll" data-target=".fixed-top">
	<!-- Preloader -->
	<div class="spinner-wrapper">
		<div class="spinner">
			<div class="bounce1"></div>
			<div class="bounce2"></div>
			<div class="bounce3"></div>
		</div>
	</div>
	<!-- end of preloader -->


	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
		<!-- Image Logo -->
		<a class="navbar-brand logo-image" href="{{ url('/') }}"><img src="/img/logo/pl-logo.png" alt="Patho•Log Logo" width="680" height="179" /></a>
		
		<!-- Mobile Menu Toggle Button -->
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-awesome fas fa-bars"></span>
			<span class="navbar-toggler-awesome fas fa-times"></span>
		</button>
		<!-- end of mobile menu toggle button -->

		<div class="collapse navbar-collapse" id="navbarsDefault">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link page-scroll" href="#header">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link page-scroll" href="#features">Features</a>
				</li>
				<li class="nav-item">
					<a class="nav-link page-scroll" href="#minifaqs">FAQs</a>
				</li>

				<li class="nav-item">
					<a class="btn-nav-md page-scroll" id="navbar-start" href="#start">GET STARTED</a>
				</li>
			</ul>
		</div>
	</nav> <!-- end of navbar -->
	<!-- end of navigation -->


	<!-- Header -->
	<header id="header" class="header">
		<div id="headbkgnd"></div>
		<div class="header-content">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="text-container">
							<h1><span class="turquoise">Authoring Pathology Reports</span> has never been faster and easier!</h1>
							<p class="p-large">Patho<span class="turquoise">&bull;</span>Log provides the fastest, easiest, and most secure way to author, customize, share, and archive your pathology reports.</p>
							<a class="btn-solid-lg page-scroll" href="#features">LEARN MORE</a>
						</div> <!-- end of text-container -->
					</div> <!-- end of col -->
					<div class="col-lg-6">
						<div class="image-container">
							<img class="img-fluid" src="/img/home/homeslides.png" alt="Slides" width="496" height="421" />
						</div> <!-- end of image-container -->
					</div> <!-- end of col -->
				</div> <!-- end of row -->
			</div> <!-- end of container -->
		</div> <!-- end of header-content -->
	</header> <!-- end of header -->
	<!-- end of header -->


	<!-- Customers -->
	<div class="slider-1">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">

					<!-- Image Slider -->
					<div class="slider-container">
						<div class="swiper-container image-slider">
							<div class="swiper-wrapper">
								<div class="swiper-slide">
									<div class="image-container">
										<img class="img-responsive" src="/img/home/slide01.jpg" alt="slide-a" width="185" height="125" />
									</div>
								</div>
								<div class="swiper-slide">
									<div class="image-container">
										<img class="img-responsive" src="/img/home/slide02.jpg" alt="slide-b" width="185" height="125" />
									</div>
								</div>
								<div class="swiper-slide">
									<div class="image-container">
										<img class="img-responsive" src="/img/home/slide03.jpg" alt="slide-c" width="185" height="125" />
									</div>
								</div>
								<div class="swiper-slide">
									<div class="image-container">
										<img class="img-responsive" src="/img/home/slide04.jpg" alt="slide-d" width="185" height="125" />
									</div>
								</div>
								<div class="swiper-slide">
									<div class="image-container">
										<img class="img-responsive" src="/img/home/slide05.jpg" alt="slide-e" width="185" height="125" />
									</div>
								</div>
							</div> <!-- end of swiper-wrapper -->
						</div> <!-- end of swiper container -->
					</div> <!-- end of slider-container -->
					<!-- end of image slider -->

				</div> <!-- end of col -->
			</div> <!-- end of row -->
		</div> <!-- end of container -->
	</div> <!-- end of slider-1 -->
	<!-- end of customers -->


	<div id="features" style="width:100%;height:3.63rem;"></div>
	<!-- Features -->
	<div class="cards-1">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h2>Discover a new way of managing pathology reports</h2>
					<p class="p-heading p-large">Using modern technologies, we provide fast and easy ways to author pathology reports, share them with others, and archive them, while supporting a wide range of platforms and devices.</p>
				</div> <!-- end of col -->
			</div> <!-- end of row -->
		</div> <!-- end of container -->
	</div> <!-- end of cards-1 -->
	<!-- end of services -->


	<!-- Details 1 -->
	<!--
		- Create and edit your pathology reports using any device like your computer, tablet, or even mobile phone.
		- Patho<span class="turquoise">&bull;</span>Log works fine for slow as well as fast internet connections, while preserving the same great services.
		- You can work offline if your prefer, by installing Patho<span class="turquoise">&bull;</span>Log app (supports all major systems like Windows, MacOS, iOS, Android, and Linux)
	-->
	<div class="basic-2">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="text-container">
						<h2>Design and author your pathology reports quickly and easily</h2>
						<ul class="list-unstyled li-space-lg">
							<li class="media">
								<i class="fas fa-check"></i>
								<div class="media-body">Create your reports using your computer, tablet, or mobile phone.</div>
							</li>
							<li class="media">
								<i class="fas fa-check"></i>
								<div class="media-body">Patho<span class="turquoise">&bull;</span>Log works fine for slow as well as fast internet connections.</div>
							</li>
							<li class="media">
								<i class="fas fa-check"></i>
								<div class="media-body">You can work offline if your prefer, by installing Patho<span class="turquoise">&bull;</span>Log app.</div>
							</li>
						</ul>
					</div> <!-- end of text-container -->
				</div> <!-- end of col -->
				<div class="col-lg-6">
					<div class="image-container">
						<img class="img-fluid" src="/img/home/details-1-office-worker.svg" alt="office-worker" width="690" height="545" />
					</div> <!-- end of image-container -->
				</div> <!-- end of col -->
			</div> <!-- end of row -->
		</div> <!-- end of container -->
	</div> <!-- end of basic-1 -->
	<!-- end of details 1 -->


	<!-- Details 2 -->
	<!--
		- Only those with a code can access or read the reorts
		- Privacy is important to us
	-->
	<div class="basic-2">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="image-container">
						<img class="img-fluid" src="/img/home/details-2-office-team-work.svg" alt="team-work" width="690" height="545" />
					</div> <!-- end of image-container -->
				</div> <!-- end of col -->
				<div class="col-lg-6">
					<div class="text-container">
						<h2>Share your reports with other doctors or your patients</h2>
						<ul class="list-unstyled li-space-lg">
							<li class="media">
								<i class="fas fa-check"></i>
								<div class="media-body">Share your reports with whoever you want using a specific link.</div>
							</li>
							<li class="media">
								<i class="fas fa-check"></i>
								<div class="media-body">Maintain privacy by locking reports with a password if you want.</div>
							</li>
							<li class="media">
								<i class="fas fa-check"></i>
								<div class="media-body">Print your reports, or create a PDF file to share them manually.</div>
							</li>
						</ul>
					</div> <!-- end of text-container -->
				</div> <!-- end of col -->
			</div> <!-- end of row -->
		</div> <!-- end of container -->
	</div> <!-- end of basic-2 -->
	<!-- end of details 2 -->


	<div id="minifaqs" style="width:100%;height:3.63rem;"></div>
	<!-- MiniFAQs -->
	<div class="cards-2 darker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<br/><br/>
					<div class="home-question">Is Patho<span class="turquoise">&bull;</span>Log free?</div>
					<p>Yes! Patho<span class="turquoise">&bull;</span>Log is free and its core functionality will always be free.</p>
					<br/>
					<div class="home-question">Can I save copies of my reports locally on my computer?</div>
					<p>Yes, you can always save your reports as PDF files on your computer for your reference.</p>
					<br/>
					<div class="home-question">What about privacy?</div>
					<p>Privacy is important to us. No one can read your reports unless you share a special link with them, and optionally password-locked.</p>
					<br/>
					<br/>
					<a href="#request" class="btn-solid-reg">FREQUENTLY ASKED QUESTIONS</a>
					<br/><br/>
				</div>
			</div> <!-- end of row -->
		</div> <!-- end of container -->
	</div> <!-- end of form-1 -->
	<!-- end of request -->


	<div id="start" style="width:100%;height:3.63rem;"></div>
	<!-- StartHere -->
	<div class="cards-1">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h2>Let's Start</h2>
				</div>
				<div class="col-lg-12">
					<br/>
					<p>Register now and start using Patho<span class="turquoise">&bull;</span>Log</p>
					<div class="pulse-btnlink">
						<div class="pulse"></div><a class="btnlink-solid-lg" href="#request">REGISTER for FREE</a>
					</div>
					<br/>
					<br/>
					<br/>
					<br/>
					<p>Already have an account?</p>
					<div class="pulse-btnlink">
						<div class="pulse"></div><a class="btnlink-outline-lg" href="#screenshots">SIGN-IN</a>
					</div>
					<br/><br/><br/>

				</div>
			</div>
		</div>
	</div>


	<!-- Footer -->
	<div class="footer darker">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="footer-col">
						<div class="home-question">About&nbsp;<img id="logo-bw" src="/img/logo/pl-logo-bw.png" alt="Patho•Log BW Logo" width="94" height="32" /></div>
						<p>We're passionate about offering some of the best pathology reporting services out there! Create, share, and archive stylish pathology reports quickly and easily for free!</p>
					</div>
				</div> <!-- end of col -->
				<div class="col-md-4">
					<div class="footer-col middle">
						<div class="home-question">Important Links</div>
						<ul class="list-unstyled li-space-lg">
							<li class="media">
								<i class="fas fa-square"></i>
								<div class="media-body">Read our <a class="turquoise" href="terms-conditions.html">Terms & Conditions</a>, <a class="turquoise" href="privacy-policy.html">Privacy Policy</a>.</div>
							</li>
							<li class="media">
								<i class="fas fa-square"></i>
								<div class="media-body">Visit our <a class="turquoise" href="#your-link">Frequently asked questions</a> page.</div>
							</li>
							<li class="media">
								<i class="fas fa-square"></i>
								<div class="media-body">Contact our support: <a class="turquoise" href="mailto:support@patho-log.com">support@patho-log.com</a>.</div>
							</li>
						</ul>
					</div>
				</div> <!-- end of col -->
				<div class="col-md-4">
					<div class="footer-col last">
						<div class="home-question trans">Social Links</div>
						<span class="fa-stack">
							<a href="#" class="trans" title="Visit our Facebook page">
								<i class="fas fa-circle fa-stack-2x"></i>
								<i class="fab fa-facebook-f fa-stack-1x"></i>
								.
							</a>
						</span>
						<span class="fa-stack">
							<a href="mailto:support@patho-log.com" class="trans" title="Contact us via email">
								<i class="fas fa-circle fa-stack-2x"></i>
								<i class="far fa-envelope fa-stack-1x"></i>
								.
							</a>
						</span>
					</div> 
				</div> <!-- end of col -->
			</div> <!-- end of row -->
		</div> <!-- end of container -->
	</div> <!-- end of footer -->  
	<!-- end of footer -->


	<!-- Copyright -->
	<div class="copyright darker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<p class="p-small">Copyright © {{ date('Y') }} <a href="https://www.patho-log.com">Patho<span class="turquoise">&bull;</span>Log</a> - All rights reserved</p>
				</div> <!-- end of col -->
			</div> <!-- enf of row -->
		</div> <!-- end of container -->
	</div> <!-- end of copyright --> 
	<!-- end of copyright -->
	
		
	<!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- jQuery for Bootstrap's JavaScript plugins -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> <!-- Popper tooltip library for Bootstrap -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> <!-- Bootstrap framework -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js" integrity="sha512-ahmSZKApTDNd3gVuqL5TQ3MBTj8tL5p2tYV05Xxzcfu6/ecvt1A0j6tfudSGBVuteSoTRMqMljbfdU0g2eDNUA==" crossorigin="anonymous"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
	<script src="/vendor/swiper-4.4.6/dist/js/swiper.min.js"></script> <!-- Swiper for image and text sliders -->
	<script src="/vendor/magnific-popup-1.1.0/dist/jquery.magnific-popup.js"></script> <!-- Magnific Popup for lightboxes -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.8/validator.min.js" integrity="sha512-tRBNdBCA7T90XrFn6MgPvUe7+HqU5Le7zfKIDaDJb8b2Cf5nbzJR2aTN6KIwPUpFLLx8kvOd7AkDnfDaqrLsmQ==" crossorigin="anonymous"></script> <!-- Validator.js - Bootstrap plugin that validates forms -->
	<script src="/js/scripts.js"></script> <!-- Custom scripts -->
</body>
</html>