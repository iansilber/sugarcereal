<?= View::make('partials/header'); ?>

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

<?= View::make('partials/footer'); ?>