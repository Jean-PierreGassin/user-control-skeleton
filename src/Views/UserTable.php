<?php if (isset($message)): ?>
	<div class="row">
		<div class="small-12 columns">
			<table class="small-12">
				<thead>
					<tr>
						<?php foreach ($message2 as $columns): ?>
							<?php foreach($columns as $field): ?>
								<th ><?php echo $field; ?></th>
							<?php endforeach; ?>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($message as $users): ?>
						<tr>
							<?php foreach ($users as $user): ?>
								<td><?php echo $user; ?></td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php endif; ?>
