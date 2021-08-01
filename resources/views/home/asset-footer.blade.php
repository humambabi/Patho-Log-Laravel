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
								<div class="media-body">Read our <a class="turquoise" href="{{ url('/') }}/terms-conditions">Terms & Conditions</a>, <a class="turquoise" href="privacy-policy.html">Privacy Policy</a>.</div>
							</li>
							<li class="media">
								<i class="fas fa-square"></i>
								<div class="media-body">Visit our <a class="turquoise" href="#your-link">Frequently asked questions</a> page.</div>
							</li>
							<li class="media">
								<i class="fas fa-square"></i>
								<div class="media-body">Contact our support: <a class="turquoise" href="mailto:{{ config('constants.PATHOLOG_EMAIL_SUPPORT') }}">{{ config('constants.PATHOLOG_EMAIL_SUPPORT') }}</a>.</div>
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
							<a href="mailto:{{ config('constants.PATHOLOG_EMAIL_SUPPORT') }}" class="trans" title="Contact us via email">
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
					<p class="p-small">Copyright © {{ date('Y') }} <a href="{{ url('/') }}">Patho<span class="turquoise">&bull;</span>Log</a> - All rights reserved</p>
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
	<script src="/js/home/scripts.js"></script> <!-- Custom scripts -->
</body>
</html>