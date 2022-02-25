<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   
   <!-- SEO Meta Tags -->
   <meta name="description" content="{{ $head_description }}" />
   <meta name="author" content="Patho•Log Team" />

   <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
   <meta property="og:site_name" content="Patho•Log" /> <!-- website name -->
   <meta property="og:site" content="{{ config('app.url') }}" /> <!-- website link -->
   <meta property="og:title" content="{{ $ogmeta_title }}" /> <!-- title shown in the actual shared post -->
   <meta property="og:description" content="{{ $ogmeta_description }}" /> <!-- description shown in the actual shared post -->
   <meta property="og:image" content="{{ $ogmeta_image }}" /> <!-- image link, make sure it's jpg -->
   <meta property="og:url" content="{{ $ogmeta_url }}" /> <!-- where do you want your post to link to -->
   <meta property="og:type" content="{{ $ogmeta_type }}" />

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
   <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,600,700,700i&amp;subset=latin-ext&amp;display=swap" rel="stylesheet" />
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
   <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
   <link href="/vendor/swiper-4.4.6/dist/css/swiper.min.css" rel="stylesheet" />
   <link href="/css/home/styles.css" rel="stylesheet" />

   <!-- Global site tag (gtag.js) - Google Analytics -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=G-7S4S8DXKS1"></script>
   <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js',new Date());gtag('config','G-7S4S8DXKS1');
   </script>
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
         {{-- page-scroll class causes some errors when directing to another page --}}
            <li class="nav-item">
               @if ($navbar_ishome)
               <a class="nav-link page-scroll" href="#header">Home <span class="sr-only">(current)</span></a>
               @else
               <a class="nav-link" href="{{ config('app.url') }}/#header">Home</a>
               @endif
            </li>
            <li class="nav-item">
               @if ($navbar_ishome)
               <a class="nav-link page-scroll" href="#features">Features</a>
               @else
               <a class="nav-link" href="{{ config('app.url') }}/#features">Features</a>
               @endif
            </li>
            <li class="nav-item">
               @if ($navbar_ishome)
               <a class="nav-link page-scroll" href="#minifaqs">FAQs</a>
               @else
               <a class="nav-link" href="{{ config('app.url') }}/#minifaqs">FAQs</a>
               @endif
            </li>

            <li class="nav-item">
               @if ($navbar_ishome)
               <a class="btn-nav-md page-scroll" id="navbar-start" href="#start">GET STARTED</a>
               @else
               <a class="btn-nav-md" id="navbar-start" href="{{ url('/') }}/default">GET STARTED</a>
               @endif
            </li>
         </ul>
      </div>
   </nav> <!-- end of navbar -->
   <!-- end of navigation -->