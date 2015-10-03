<!doctype html>
<html class="no-js" lang="en">
<head>
  <title><?= $title ?></title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  
  <link rel="stylesheet" href="{{asset('css/app.css')}}" />
  <script src="{{asset('js/vendor/modernizr.js')}}"></script>
  <script src="{{asset('js/vendor/jquery.js')}}"></script>
  <script src="{{asset('js/foundation.min.js')}}"></script>
  <script src="{{asset('js/foundation/foundation.abide.js')}}"></script>

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

  <div id="wrapper">

    <nav class="top-bar" data-topbar role="navigation">
      <ul class="title-area">
        <li class="name"><h1><a href="./">Sugar Cereal</a></h1></li>
      </ul>

      <section class="top-bar-section">
        <ul class="right">
          <li><a href="bid">Place Bid</a></li>
        </ul>
      </section>
    </nav>

    @if (Session::has('flash_message'))
    <div class="row">
      <div class="large-12 columns">
        <div data-alert class="alert-box {{Session::get('flash_type')}}">
          {{Session::get('flash_message')}}
        </div>
      </div>
    </div>
    @endif


    <div id="body">