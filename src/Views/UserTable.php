<?php if (isset($message)): ?>
<div class="row">
	<table class="small-12 columns">
		<thead>
			<tr>
				<?php foreach ($message as $columns): ?>
					<?php foreach($columns as $key => $value): ?>
						<th><?php echo $key ?></th>
					<?php endforeach ?>
				<?php endforeach ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($message as $users): ?>
				<tr>
					<?php foreach ($users as $user): ?>
						<td><?php echo $user ?></td>
					<?php endforeach ?>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
<?php endif ?>
