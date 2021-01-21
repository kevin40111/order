<div class='row-fluid'>
			<div class='span10'>
				<h1>待確認人員列表</h1>
				<hr>
				<table class="table">
					<thead>
						<tr>
							<th>姓名</th>
							<th>位階</th>
							<th>生日</th>
							<th>手機</th>
							<th>處室</th>
							<th>審核確認</th>
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
									<td><button class='btn btn-primary yes' type="button" >是</button><span>  </span><button class='btn btn-danger no' type="button" >否</button></td>
								</tr>
						<?endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
<script>
$('.table').delegate('.yes','click',function(){
	var $this = $(this);
	var uid = $this.parents('tr').data('uid');
	if(!confirm("確認審核？")){
		return false;
	}

	$.post('/member/check_member_ok',{uid:uid},function(data){
		if(data == 1){
			alert('審核通過');
			$this.parents('tr').remove();
		}
		else {
			alert('發生錯誤');
		}
	});
});

$('.table').delegate('.no','click',function(){
	var $this = $(this);
	var uid = $this.parents('tr').data('uid');
	if(!confirm("確認刪除審核？")){
		return false;
	}

	$.post('/member/check_member_no',{uid:uid},function(data){
		if(data == 1){
			alert('審核刪除成功');
			$this.parents('tr').remove();
		}
		else {
			alert('發生錯誤');
		}
	});
});


</script>
<style>
</style>
