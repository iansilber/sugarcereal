<!doctype html>
<html>
<head>
{!! HTML::style('css/main.css'); !!}

<meta charset="utf-8">
<title>SugarCereal</title>

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

<header><a href="bid">place bid</a></header>

<div id="pushButton">
	<a href="http://www.facebook.com/iansilber">
		{!! HTML::image('images/sugarcereal_logo3.png', 'logo', array('width' => '200px', 'height' => '200px')); !!}
		</a>
</div>

<h3>Today's top 5 bids:</h3>
<ul>
<?php foreach ($bids as $bid) { ?>
	<li><?= $bid->url ?>, <?= $bid->amount ?></li>
<?php } ?>
</ul>



</body>
</html>
