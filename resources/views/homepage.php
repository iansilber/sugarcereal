<header><a href="bid">place bid</a></header>

<h1><a href="http://google.com">Sugar Cereal Button</a></h1>

<h3>Top 5 bids:</h3>
<ul>
<?php foreach ($bids as $bid) { ?>
	<li><?= $bid->url ?>, <?= $bid->amount ?></li>
<?php } ?>
</ul>