	<!-- Scripts -->
	@if (config('app.debug') == false)
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	@else
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
	@endif
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<script type="text/javascript" src="/vendor/OverlayScrollbars-1.13.1/js/jquery.overlayScrollbars.min.js"></script>
	@if (config('app.debug') == false)
	<script src="/js/portal/adminlte.min.js"></script>
	@else
	<script src="/js/portal/adminlte.js"></script>
	@endif
	<script src="/js/portal/demo.js"></script>
	<!--<script src="/js/portal/scripts.js"></script> < !-- Custom scripts -- > -->
</body>
</html>