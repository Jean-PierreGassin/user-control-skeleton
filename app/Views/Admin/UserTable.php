<?php if (isset($message)): ?>
<div class="row align-center">
	<div class="small-12 columns">
		<table class="hover stack" style="table-layout: fixed">
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
							<td class="table-scroll"><?php echo $user ?></td>
						<?php endforeach ?>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<?php endif ?>
