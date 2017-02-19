<div class="row align-center">
	<div class="small-12 columns">
		<form method="POST">
			<div class="input-group">
				<span class="input-group-label">User:</span>
				<input class="input-group-field" type="text" name="search_field">
				<input type="submit" class="input-group-button button" value="Search">
			</div>
		</form>
	</div>
</div>

<?php if (isset($message)): ?>
<div class="row align-center">
	<div class="small-12 columns">
		<table class="hover stack" style="table-layout: fixed;">
			<thead>
				<tr>
					<?php foreach ($message[0] as $key => $value): ?>
						<th style="border: 1px solid #f0f0f0; padding: 0; text-align: center;"><?php echo $key ?></th>
					<?php endforeach ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($message as $users): ?>
					<tr>
						<?php foreach ($users as $cell): ?>
							<td class="table-scroll" style="white-space: nowrap; text-align: center;"><?php echo $cell ?></td>
						<?php endforeach ?>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<?php endif ?>
