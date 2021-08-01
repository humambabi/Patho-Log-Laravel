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
	
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" /> <!-- IE -->
	<link rel="icon" type="image/x-icon" href="/favicon.ico" />	<!-- All others -->
	<link rel="apple-touch-icon" sizes="180x180" href="/img/logo/apple-touch-icon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="/img/logo/favicon-32x32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="/img/logo/favicon-16x16.png" />
	<link rel="manifest" href="/site.webmanifest" />

	<!-- Styles -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap" rel="stylesheet" />
	<link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
	<link href="/css/portal/styles.css" rel="stylesheet" />

	<!-- CSRF protection -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- gtag/g.analytics - same as the comingsoon page -->
	<!-- -->
</head>
