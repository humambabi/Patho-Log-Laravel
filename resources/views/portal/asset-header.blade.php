<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	
	<!-- SEO Meta Tags -->
	<meta name="description" content="{{ $head_description }}" />
	<meta name="author" content="Patho•Log Team" />

	<!-- Website Title -->
	<title>{{ $head_title }}</title>
	<base href="{{ url('/') }}" />
	
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" /> <!-- IE -->
	<link rel="icon" type="image/x-icon" href="/favicon.ico" />	<!-- All others -->
	<link rel="apple-touch-icon" sizes="180x180" href="/img/logo/apple-touch-icon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="/img/logo/favicon-32x32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="/img/logo/favicon-16x16.png" />
	<link rel="manifest" href="/site.webmanifest" />

	<!-- Styles -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=swap" />
	<link rel="stylesheet" href="/vendor/fontawesome-free/css/all.min.css" />
	@if (config('app.debug') == false)
	<link rel="stylesheet" href="/css/portal/adminlte.min.css" />
	@else
	<link rel="stylesheet" href="/css/portal/adminlte.css" />
	@endif
	<link rel="stylesheet" type="text/css" href="/vendor/OverlayScrollbars-1.13.1/css/OverlayScrollbars.min.css" />
	<link rel="stylesheet" href="/css/portal/custom.css" />

	<!-- CSRF protection -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- gtag/g.analytics - same as the comingsoon page -->
	<!-- -->
</head>
