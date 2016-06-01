<?php if (isset($_SESSION['error']) || isset($_SESSION['success'])): ?>
<div class="row align-center">
	<?php if (isset($_SESSION['error'])): ?>
	<div class="medium-6 text-center">
		<div class="alert callout">
			<?php echo $_SESSION['error']; ?>
			<?php unset($_SESSION['error']); ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if (isset($_SESSION['success'])): ?>
	<div class="medium-6 text-center">
		<div class="success callout">
			<?php echo $_SESSION['success']; ?>
			<?php unset($_SESSION['success']); ?>
		</div>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>

<div class="row">
	<div class="small-12 columns">
		<h3>Example Site Index.php</h3>
		<p>This is the landing page of index.php after you've successfully setup your database connection!</p>
	</div>
</div>
