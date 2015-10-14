<!doctype html>
<html class="no-js" lang="en">
<head>
  <title><?= $title ?></title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://fonts.googleapis.com/css?family=Lato:400,700,100' rel='stylesheet' type='text/css'>
  
  <link rel="stylesheet" href="{{asset('css/app.css')}}" />
  <script src="{{asset('js/vendor/modernizr.js')}}"></script>
  <script src="{{asset('js/vendor/jquery.js')}}"></script>
  <script src="{{asset('js/foundation.min.js')}}"></script>
  <script src="{{asset('js/foundation/foundation.abide.js')}}"></script>
  <script src="{{asset('js/foundation/foundation.alert.js')}}"></script>
  <script src="{{asset('js/app.js')}}"></script>

  <link rel="shortcut icon" href="{{asset('favicon.ico')}}"/>

  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42919824-3', 'auto');
  ga('send', 'pageview');

</script>

</head>
<body>

  @if (Session::has('flash_message'))
  <div data-alert class="alert-box {{Session::get('flash_type')}}">
    {{Session::get('flash_message')}}
    <a href="#" class="close">&times;</a>
  </div>
  @endif


  <div id="wrapper">

    <nav class="my-top-bar">

      <h1><a href="{{route('home')}}"><img src="{{asset('images/logo.png')}}" width="106" height="21" /></a></h1>
      <ul class="nav">
        <li><a href="{{route('bid')}}"><strong>Place Bid</strong></a></li>
      </ul>
    </nav>

    <div id="body">