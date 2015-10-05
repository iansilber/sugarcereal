<!-- {{$winning_url}} -->
<?= View::make('partials/header', array('title' => 'Sugar Cereal')); ?>

<script>
function push_me_now() {
	window.open('{{$winning_url}}');
}
</script>

	<div class="row">
		<div id="pushButton">
				<a href="javascript:push_me_now()" onclick="">Push me!</a>
		</div>
	</div>

	<div class="top-five">
		<div class="row">
			<div class="large-12 columns">
				<p><strong>Today's top bids:</strong></p>
				<ul>
					
				<?php foreach ($bids as $bid) { ?>
					<li><?= $bid->url ?></li>
				<?php } ?>

				<?php if (count($bids) == 0) { ?>
					<li>No bids today</li>
				<?php } ?>
				</ul>
			</div>
		</div>
	</div>

<?= View::make('partials/footer'); ?>