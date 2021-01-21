		<div class='row-fluid'>
			<div class='span10'>
				<h1>人員列表</h1>
				<hr>
				<table class="table">
					<thead>
						<tr>
							<th>姓名</th>
							<th>生日</th>
							<th>手機</th>
							<th>計畫</th>
						</tr>
					</thead>
					<tbody id='member_body'>
						<?foreach($members as $row ):?>
              <?
                $mobile = str_replace('-', '', $row->phone);
                if (strlen($mobile) == 10) {
                    $mobile = substr($mobile, 0, 4) . '-' . substr($mobile, 4, 3) . '-' . substr($mobile, 7, 3);
                } else {
                    $mobile = '';
                }
              ?>
								<tr data-uid='<?= $row->id ?>'>
									<td><?= $row->name ?></td>
									<td><?= $row->rank_name ?></td>
									<td><?= $row->birth; ?></td>
									<td><?= $mobile; ?></td>
									<td><?= $row->dep_name ?></td>
									<td><?= $row->start_date ?></td>
									<td><?= $row->end_date; ?></td>
								</tr>
						<?endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
<script>
</script>
<style>
</style>
