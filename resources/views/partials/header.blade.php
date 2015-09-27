<!doctype html>
<html class="no-js" lang="en">
<head>
  <title>Place Bid</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  
  <link rel="stylesheet" href="{{asset('css/normalize.css')}}" />
  <link rel="stylesheet" href="{{asset('css/foundation.min.css')}}" />
  <link rel="stylesheet" href="{{asset('css/main.css')}}" />
  <script src="{{asset('js/vendor/modernizr.js')}}"></script>
  <script src="{{asset('js/vendor/jquery.js')}}"></script>

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

  <nav class="top-bar" data-topbar role="navigation">

    <? if (!isset($hideHome)) { ?>
    <ul class="title-area">
    <li class="name">
      <h1><a href="./">Sugar Cereal</a></h1>
    </li>
    </ul>
    <? } ?>

  <section class="top-bar-section">
    <ul class="right">
      <li><a href="bid">Place Bid</a></li>
    </ul>
  </nav>