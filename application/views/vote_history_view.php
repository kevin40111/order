		<div class='row-fluid'>
			<div class='span12'>
				<div id="right_view">
				<h2>投票歷史</h2>
				<a href="/vote" class="btn btn-success"><i class="icon-chevron-left icon-white"></i> 回上頁</a>
				<hr>
				<table class="table">
					<thead>
						<tr>
							<th>投票名稱</th><th>投票發起人</th><th>參與人數</th><th>建立日期</th>
						</tr>
					</thead>
					<tbody class="listbody">
						<?foreach( $list as $row):?>
							<tr data-voteid='<?= $row->id?>'>
								<td><?= $row->name ?></td>
								<td><?= $row->member ?></td>
								<td><?= $row->member_num ?></td>
								<td><?= $row->create_time	?></td>
							</tr>
						<?endforeach;?>
					</tbody>
				</table>
				</div>
			</div>
		</div>
<div id='bg-container'></div>
<script>
$('.listbody').delegate('tr','click',function(){
	var $this = $(this);
	location.href = '/vote/item_view/'+$this.data('voteid')+'/close';
});

</script>
<style>
div#bg-container {
    width: 789px;
    height: 564px;
    z-index: -1;
    position: fixed;
    background-repeat: no-repeat;
    top: 200px;
    left: 200px;
  }

  td, th {
    background-color: rgba(255, 255, 255, .75) !important;
  }
tbody tr {
	cursor:pointer;
}

</style>
