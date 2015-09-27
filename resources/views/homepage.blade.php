<?= View::make('partials/header', array('hideHome' => true)); ?>

	<div class="row">
		<div id="pushButton">
				<a href="http://www.facebook.com/iansilber">{!! HTML::image('images/sugarcereal_logo3.png', 'logo', array('width' => '200px', 'height' => '200px')); !!}</a>
		</div>
	</div>


	<div class="row">
		<div class="large-12 columns">

			<ul class="inline-list">
				<li><strong>Today's top 5 bids:</strong></li>
			<?php foreach ($bids as $bid) { ?>
				<li><?= $bid->url ?> $<?= $bid->amount ?></li>
				<li> / </li>
			<?php } ?>
			</ul>
		</div>
	</div>

<?= View::make('partials/footer'); ?>